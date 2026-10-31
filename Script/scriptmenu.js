// ===========================
// 📌 GESTION DU PANIER
// ===========================

let cart = [];

/**
 * Affiche ou masque le panier.
 */
function toggleCart() {
    let cartContainer = document.querySelector(".cart");
    cartContainer.style.display = cartContainer.style.display === "none" || cartContainer.style.display === "" ? "flex" : "none";
}

/**
 * Ajoute un produit au panier.
 * @param {string} productName - Nom du produit.
 * @param {number} productPrice - Prix du produit.
 */
function addToCart(productName, productPrice) {
    let existingItem = cart.find(item => item.name === productName);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({ name: productName, price: productPrice, quantity: 1 });
    }

    updateCart();
}

/**
 * Met à jour l'affichage du panier.
 */
function updateCart() {
    let cartItemsContainer = document.getElementById("cart-items");
    let cartTotalContainer = document.getElementById("cart-total");
    let cartCountContainer = document.getElementById("cart-count");

    cartItemsContainer.innerHTML = "";
    let total = 0;
    let totalItems = 0;

    cart.forEach(item => {
        total += item.price * item.quantity;
        totalItems += item.quantity;

        let li = document.createElement("li");
        li.innerHTML = `${item.name} - ${item.price} DA x ${item.quantity} 
            <button onclick="removeFromCart('${item.name}')">❌</button>`;
        cartItemsContainer.appendChild(li);
    });

    cartTotalContainer.innerText = total;
    cartCountContainer.innerText = totalItems;

    // Masquer le compteur si aucun article
    cartCountContainer.style.display = totalItems > 0 ? "flex" : "none";
}

/**
 * Supprime un produit du panier.
 * @param {string} productName - Nom du produit à supprimer.
 */
function removeFromCart(productName) {
    cart = cart.filter(item => item.name !== productName);
    updateCart();
}

  // Validation
  function setupValidationModal(triggerSelector, modalSelector, closeSelector) {
    document.addEventListener("DOMContentLoaded", () => {
      const valideButton = document.querySelector(triggerSelector);
      const validationModal = document.querySelector(modalSelector);
      const closeButton = document.querySelector(closeSelector);
  
      if (!valideButton || !validationModal || !closeButton) {
        console.error("Un ou plusieurs éléments sont introuvables !");
        return;
      }
     
      valideButton.addEventListener('click', () => {
        validationModal.style.display = 'flex';
      });
  
      closeButton.addEventListener('click', () => {
        validationModal.style.display = 'none';
      });
  
      validationModal.addEventListener('click', (event) => {
        if (event.target === validationModal) {
          validationModal.style.display = 'none';
        }
      });
    });
  }
  
  // Appel de la fonction avec les sélecteurs
  setupValidationModal('.valide-button', '.validation-modal', '.validation-modal .close-button');
  
  

// recherche
  document.querySelector(".search-input").addEventListener("input", (e) => {
    const searchTerm = e.target.value.toLowerCase();
    const categories = document.querySelectorAll(".category");
    const noResultsMessage = document.getElementById("no-results-message");
    let anyVisibleItem = false;

    categories.forEach(category => {
        const items = category.querySelectorAll(".card");
        let hasVisibleItem = false;

        items.forEach(item => {
            const itemName = item.querySelector("h2").textContent.toLowerCase();
            const match = itemName.includes(searchTerm);
            item.style.display = match ? "block" : "none";
            if (match) {
                hasVisibleItem = true;
                anyVisibleItem = true;
            }
        });

        const categoryTitle = category.querySelector(".category-title");
        const titleLine = category.querySelector(".title-line");
        const separator = category.querySelector(".separator");

        if (categoryTitle) {
            categoryTitle.style.display = hasVisibleItem ? "block" : "none";
        }
        if (titleLine) {
            titleLine.style.display = hasVisibleItem ? "block" : "none";
        }
        if (separator) {
            separator.style.display = hasVisibleItem ? "block" : "none";
        }
    });

    // Affiche le message si aucun plat ne correspond
    if (searchTerm && !anyVisibleItem) {
        noResultsMessage.style.display = "block";
    } else {
        noResultsMessage.style.display = "none";
    }
});

// ===========================
// 📌 GESTION DES SUGGESTIONS
// ===========================

const plats = ["Brownie", "Tiramisu", "Cheesecake", "Fondant au chocolat"];
const searchInput = document.querySelector(".search-input");
const suggestionsList = document.querySelector(".suggestions-list");

/**
 * Affiche les suggestions basées sur l'entrée utilisateur.
 */
searchInput.addEventListener("input", () => {
    const searchTerm = searchInput.value.toLowerCase();
    suggestionsList.innerHTML = ""; // Vide les anciennes suggestions

    if (searchTerm === "") {
        suggestionsList.style.display = "none"; // Cache la liste si l'input est vide
        return;
    }

    const filteredPlats = plats.filter(plat => plat.toLowerCase().includes(searchTerm));

    if (filteredPlats.length === 0) {
        suggestionsList.style.display = "none"; // Cache la liste si aucune suggestion
        return;
    }

    filteredPlats.forEach(plat => {
        const li = document.createElement("li");
        li.textContent = plat;
        li.addEventListener("click", () => {
            searchInput.value = plat; // Remplit l'input avec le choix
            suggestionsList.style.display = "none"; // Cache les suggestions après sélection
        });
        suggestionsList.appendChild(li);
    });

    suggestionsList.style.display = "block"; // Affiche la liste des suggestions
});
document.getElementById("category-filter").addEventListener("change", function () {
    const selectedCategory = this.value;
    const categories = document.querySelectorAll(".category");

    categories.forEach(category => {
        const items = category.querySelectorAll(".card");
        let hasVisibleItem = false;

        items.forEach(item => {
            if (selectedCategory === "all" || item.dataset.category === selectedCategory) {
                item.style.display = "block"; // Afficher l'article
                hasVisibleItem = true;
            } else {
                item.style.display = "none"; // Cacher l'article
            }
        });

        // Cache le titre de la catégorie si aucun plat n'est affiché
        const categoryTitle = category.querySelector(".category-title");
        const titleLine = category.querySelector(".title-line"); // <- Cible la ligne
        const separator = category.querySelector(".separator");
        if (categoryTitle) {
            categoryTitle.style.display = hasVisibleItem ? "block" : "none";
        }

        if (titleLine) {
            titleLine.style.display = hasVisibleItem ? "block" : "none";
        }

        if (separator) {
            separator.style.display = hasVisibleItem ? "block" : "none";
        }
    });
});


