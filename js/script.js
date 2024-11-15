// Sélection des éléments
const modal = document.getElementById("productModal");
const addButton = document.getElementById("addButton");
const closeButtons = document.querySelectorAll(".close-button");

const editButton = document.querySelectorAll(".edit-btn");
const buttonSupprimer = document.querySelectorAll(".delete-btn");

const modalTitle = document.getElementById("modalTitle");
const userIdField = document.getElementById("user_id");
const usernameField = document.getElementById("username");
const roleField = document.getElementById("role");
const datecomField = document.getElementById("datecom");
const commercialnameField = document.getElementById("commercialName");
const descriptnameField = document.getElementById("descripName");
const prixField = document.getElementById("prix");
const poidField = document.getElementById("poid");
const validationModal = document.getElementById("validationModal");

addButton.addEventListener("click", () => {
  modal.style.display = "flex";
});

function openModalUser() {
  modalTitle.textContent = "Ajouter l’utilisateur";
  modal.style.display = "flex";
}

// Fonction pour afficher le modal en mode édition
function openEditModalUser(username, role, date) {
  modalTitle.textContent = "Modifier l’utilisateur";
  usernameField.value = username; // Remplir le champ nom d'utilisateur
  roleField.value = role; // Remplir le champ role
  datecomField.value = date;
  // Afficher le modal
}

function openModalProduit() {
  modalTitle.textContent = "Ajouter le produit";
  modal.style.display = "flex";
}

function openEditModalProduit(id, nomCommercial, nomDescriptif, prix, poids) {
  document.getElementById("modalTitle").textContent = "Modifier le produit";
  document.getElementById("product_id").value = id;
  //document.getElementById('commercialName').value = nomCommercial;
  //document.getElementById('descripName').value = nomDescriptif;
  //document.getElementById('prix').value = prix;
  document.getElementById("poids").value = poids;
  document.getElementById("productModal").style.display = "flex";
}

// Afficher le modal lors du clic sur "edit"
editButton.forEach((button) => {
  button.addEventListener("click", () => {
    modal.style.display = "flex";
  });
});

// Afficher le modal lors du clic sur "Supprimer"
buttonSupprimer.forEach((button) => {
  button.addEventListener("click", () => {
    modal3.style.display = "flex";
  });
});

function openvalidationModal() {
  validationModal.style.display = "flex";
}

function closeModal() {
  modal.style.display = "none";
  validationModal.style.display = "none";
}

// Masquer le modal lors du clic à l'extérieur de celui-ci
window.addEventListener("click", (event) => {
  if (event.target === modal) {
    modal.style.display = "none";
  }
});
window.addEventListener("click", (event) => {
  if (event.target === modal3) {
    modal3.style.display = "none";
  }
});

// Sélection des éléments
const modal2 = document.getElementById("productModal2");
const addButton2 = document.querySelectorAll(".addButton2");
const closeButtons2 = document.querySelectorAll(".close-button2");

// Afficher le modal lors du clic sur "Ajouter un produit"
addButton2.forEach((button) => {
  button.addEventListener("click", () => {
    modal2.style.display = "flex";
  });
});

// Masquer les modals lors du clic sur les boutons de fermeture
closeButtons2.forEach((button) => {
  button.addEventListener("click", () => {
    modal2.style.display = "none";
  });
});

// Masquer le modal lors du clic à l'extérieur de celui-ci
window.addEventListener("click", (event) => {
  if (event.target === modal2) {
    modal2.style.display = "none";
  }
});

const buttonValider = document.querySelectorAll(".buttonValider");
const modal3 = document.getElementById("modal3");
const acceptButton = document.querySelectorAll(".acceptButton");
const declineButton = document.querySelectorAll(".declineButton");

// Afficher le modal lors du clic sur "Ajouter un produit"
buttonValider.forEach((button) => {
  button.addEventListener("click", () => {
    modal3.style.display = "flex";
  });
});

// Masquer les modals lors du clic sur les boutons de fermeture
acceptButton.forEach((button) => {
  button.addEventListener("click", () => {
    modal3.style.display = "none";
  });
});

// Masquer les modals lors du clic sur les boutons de fermeture
declineButton.forEach((button) => {
  button.addEventListener("click", () => {
    modal3.style.display = "none";
  });
});

// Masquer le modal lors du clic à l'extérieur de celui-ci
// script.js
const menuToggle = document.getElementById("menuToggle");
const sidebar = document.getElementById("sidebarMobile");
const closesidebar = document.getElementById("closesidebarMobile");

menuToggle.addEventListener("click", () => {
  sidebar.style.right = "0"; // Affiche la sidebar en la ramenant à droite de l'écran
});

closesidebar.addEventListener("click", () => {
  sidebar.style.right = "-100%"; // Cache la sidebar en la renvoyant hors de l'écran
});

window.addEventListener("click", (event) => {
  if (event.target === sidebar) {
    sidebar.style.right = "-100%"; // Cache la sidebar en la renvoyant hors de l'écran
  }
});

const alertClick = document.getElementById("alertClick");
const alertModal = document.getElementById("alertModal");
// Afficher le modal des alertes
alertClick.addEventListener("click", () => {
  alertModal.style.display = "flex";
});

// Masquer les modals lors du clic sur les boutons de fermeture
closeButtons.forEach((button) => {
  button.addEventListener("click", () => {
    alertModal.style.display = "none";
  });
});

window.addEventListener("click", (event) => {
  if (event.target === alertModal) {
    alertModal.style.display = "none";
  }
});
