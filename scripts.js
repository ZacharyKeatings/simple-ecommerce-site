function setCookie(idName, idTitle) {  
    let cookieValue = document.getElementById(idName).value;
    const now = new Date();
    now.setTime(now.getTime() + (365*24*60*60*1000));
    let cookieLength = ";expires=" + now.toUTCString();
    let path = ';path=/';
    
    document.cookie = idTitle + '=' + cookieValue + cookieLength + path;
  }

function addToCart(id, name, price, availableQuantity) {
  const quantity = Number(document.getElementById(`quantityInput${id}`).value);

  if (quantity < 1){
    alert('Please set the quantity to at least 1.');
    return;
  }

  if (availableQuantity <= 0){
    alert(`${name} is sold out!`);
    return;
  }

  let cartItems = getCartContents();

  if (!cartItems) {
    cartItems = [];
  }

  let productExists = false;

  for (const product of cartItems){
    for (const productid in product){
      if (product.hasOwnProperty(id)){
        if (product[id].quantity == availableQuantity){
          alert("You have added the maximum available stock to your cart.");
          return;
        } else if (product[id].quantity + quantity > availableQuantity){
          alert(`The maximum quantity you can add to your cart is ${availableQuantity - product[id].quantity}`);
          return;
        }
        product[id].quantity += quantity;
        productExists = true;
        break;
      }
    }
  }

  if (!productExists) {
    const productInfo = {
      [id]: {
      productName: name,
      regularPrice: price,
      quantity: quantity
    }
  };

    cartItems.push(productInfo);
  }

  const cartJSON = JSON.stringify(cartItems);
  console.log(cartJSON);

  document.cookie = `shoppingCart=${encodeURIComponent(cartJSON)}; path=/`;
  console.log(document.cookie);

  updateCartTotal();
}
  
function getCartContents() {
  const cookies = document.cookie.split(';');
  let cartInfo = null;

  for (const cookie of cookies) {
    const [name, value] = cookie.trim().split('=');

    if (name === 'shoppingCart') {
      cartInfo = JSON.parse(decodeURIComponent(value));
      break;
    }
  }
  console.log(cartInfo);
  return Array.isArray(cartInfo) ? cartInfo : [];
}
  
function displayCartContents() {
  const cartContents = JSON.parse(JSON.stringify(getCartContents()));
  const cartDisplay = document.querySelector('.right-column');

  if (cartContents && cartContents.length > 0) {
    const table = document.createElement('table');
    table.id = 'cart-table';
    const thead = document.createElement('thead');
    const theadRow = document.createElement('tr');

    const headers = ['Product Name', 'Price', 'Quantity', 'Total', ''];
    for (let i = 0; i < headers.length; i++) {
      const th = document.createElement('th');
      th.textContent = headers[i];
      theadRow.appendChild(th);
    }

    thead.appendChild(theadRow);
    table.appendChild(thead);
    const tbody = document.createElement('tbody');

    let subtotal = 0;
    let taxRate = 0.13;

    for (const product of cartContents) {
      for (const productid in product){
        const row = document.createElement('tr');

        let totalQuantity = 0;
        let totalPrice = 0;

        for (const [key, value] of Object.entries(product[productid])) {
          const cell = document.createElement('td');

          if (key === "regularPrice") {
            cell.textContent = "$" + value;
          } 
          
          if (key === "productName") {
            cell.innerHTML = '<a href="product_details.php?id=' + productid + '">' + value + '</a>';
          }

          row.appendChild(cell);

          if (key === 'quantity') {
            cell.textContent = value;
            totalQuantity = value;
          }

          if (key === 'regularPrice') {
            totalPrice = value;
          }
        }
        
        const totalValueCell = document.createElement('td');
        totalValueCell.textContent = "$" + (totalQuantity * totalPrice).toFixed(2);
        row.appendChild(totalValueCell);
        
        const buttonCell = document.createElement('td');
        const button = document.createElement('button');
        button.textContent = 'Remove';
        button.addEventListener('click', () => {
          removeFromCart(productid);
        });
        buttonCell.appendChild(button);
        row.appendChild(buttonCell);
        
        tbody.appendChild(row);
        subtotal += totalPrice * totalQuantity;
      }
    }

    let tax = subtotal * taxRate;
    let total = subtotal + tax;
    
    const subTotalRow = document.createElement('tr');
    const subTotalTextCell = document.createElement('td');
    subTotalTextCell.colSpan = 3;
    subTotalTextCell.style.textAlign = 'right';
    subTotalTextCell.textContent = 'Subtotal:';
    subTotalRow.appendChild(subTotalTextCell);
    
    const subTotalValueCell = document.createElement('td');
    subTotalValueCell.textContent = '$' + (subtotal).toFixed(2);
    subTotalRow.appendChild(subTotalValueCell);
    tbody.appendChild(subTotalRow);

    const taxRow = document.createElement('tr');
    const taxTextCell = document.createElement('td');
    taxTextCell.colSpan = 3;
    taxTextCell.style.textAlign = 'right';
    taxTextCell.textContent = 'Tax (13%):';
    taxRow.appendChild(taxTextCell);

    const taxValueCell = document.createElement('td');
    taxValueCell.textContent = '$' + (tax).toFixed(2);
    taxRow.appendChild(taxValueCell);
    tbody.appendChild(taxRow);

    const totalRow = document.createElement('tr');
    const totalTextCell = document.createElement('td');
    totalTextCell.colSpan = 3;
    totalTextCell.style.textAlign = 'right';
    totalTextCell.textContent = 'Total:';
    totalRow.appendChild(totalTextCell);

    const totalValueCell = document.createElement('td');
    totalValueCell.textContent = '$' + (total).toFixed(2);
    totalRow.appendChild(totalValueCell);
    tbody.appendChild(totalRow);

    table.appendChild(tbody);
    cartDisplay.appendChild(table);
  } else {
    cartDisplay.textContent = 'No products in the cart.';
  }
}

function updateCartTotal() {
  const cartContents = getCartContents();
  const cartTotal = document.getElementById('cart-item-count');
  let totalQuantity = 0;

  if (cartContents && cartContents.length > 0) {
    for (const product of cartContents) {
      for (const quantity in product) {
        if (product.hasOwnProperty(quantity)) {
          const productInfo = product[quantity];
          totalQuantity += productInfo.quantity;
        }
      }
    }

    cartTotal.innerHTML = `${totalQuantity}`;
  } else {
    cartTotal.innerHTML = '0';
  }
}

function removeFromCart(productIdToRemove) {
  console.log("removefromcart called with productID: " + productIdToRemove);
   const cartContentsCookie = document.cookie
   .split('; ')
   .find(row => row.startsWith("shoppingCart="));

 if (cartContentsCookie) {
   const cartContentsEncoded = cartContentsCookie.split('=')[1];
   const cartContentsDecoded = decodeURIComponent(cartContentsEncoded);

   try {
     const cartContentsArray = JSON.parse(cartContentsDecoded);

     const updatedCartContents = cartContentsArray.map(item => {
       const productId = Object.keys(item)[0];
       if (productId !== productIdToRemove) {
         return item;
       }
     }).filter(item => item);

     document.cookie = `shoppingCart=${JSON.stringify(updatedCartContents)}; path=/`;
   } catch (error) {
     console.error('Error parsing JSON:', error);
   }
 }

 cartTable = document.getElementById('cart-table');
 cartTable.parentNode.removeChild(cartTable);

 displayCartContents();
 updateCartTotal();
}

updateCartTotal();

if (window.location.pathname.includes("cart.php")) {
  displayCartContents();
}


