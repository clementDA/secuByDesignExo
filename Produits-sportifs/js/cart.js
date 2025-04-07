// Structure du panier
const cart = {};

// Fonction pour ajouter un article au panier
function addToCart(name, price) {
  if (!cart[name]) {
    cart[name] = { name, price, quantity: 1 };
  } else {
    cart[name].quantity += 1;
  }
  updateCart();
}

// Fonction pour changer la quantité d'un article
function changeQuantity(name, change) {
  if (cart[name]) {
    if (cart[name].quantity + change > 0) {
      cart[name].quantity += change;
      updateCart();
    }
  }
}

// Fonction pour mettre à jour l'affichage du panier
function updateCart() {
  const cartContainer = document.getElementById('shopping-cart');
  cartContainer.innerHTML = ''; // Réinitialiser le contenu
  let total = 0;

  // Parcours de chaque article dans le panier
  for (const item of Object.values(cart)) {
    const itemElement = document.createElement('div');
    itemElement.classList.add('mini-cart-item', 'd-flex', 'border-bottom', 'pb-3');
    itemElement.innerHTML = `
      <div class="col-lg-9 col-md-8 col-sm-8">
        <div class="product-header d-flex justify-content-between align-items-center mb-3">
          <h4 class="product-title fs-6 me-5">${item.name}</h4>
          <button type="button" class="btn btn-light" onclick="removeFromCart('${item.name}')">Remove</button>
        </div>
        <div class="quantity-price d-flex justify-content-between align-items-center">
          <div class="input-group product-qty">
            <button type="button" class="quantity-left-minus btn btn-light rounded-0 btn-number" onclick="changeQuantity('${item.name}', -1)">
              <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
            </button>
            <input type="text" class="form-control input-number quantity" value="${item.quantity}" readonly>
            <button type="button" class="quantity-right-plus btn btn-light rounded-0 btn-number" onclick="changeQuantity('${item.name}', 1)">
              <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
            </button>
          </div>
          <div class="price-code">
            <span class="product-price fs-6">€${(item.price * item.quantity).toFixed(2)}</span>
          </div>
        </div>
      </div>
    `;
    cartContainer.appendChild(itemElement);
    total += item.price * item.quantity; // Calcul du total
  }

  // Met à jour le total du panier dans la modal
  document.getElementById('cart-total').innerText = `€${total.toFixed(2)}`;

  // Met à jour l'URL du bouton Checkout avec le total
  const checkoutButton = document.getElementById('checkout-btn');
  checkoutButton.onclick = function() {
    window.location.href = `checkout.php?total=${total.toFixed(2)}`;
  };
}



// Fonction pour supprimer un article du panier
function removeFromCart(name) {
  delete cart[name];
  updateCart();
}
