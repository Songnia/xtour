// Sélection des éléments
const modal = document.getElementById("productModal");
const addButton = document.getElementById("addButton");
const closeButtons = document.querySelectorAll(".close-button");

const editButton = document.querySelectorAll(".edit-btn");
const buttonSupprimer = document.querySelectorAll(".delete-btn");

const modalTitle = document.getElementById("modalTitle");
const userIdField = document.getElementById("utilisateur_id");
const usernameField = document.getElementById("nom");
const roleField = document.getElementById("role");
const datecomField = document.getElementById("datecom");
const commercialnameField = document.getElementById("commercialName");
const descriptnameField = document.getElementById("descripName");
const prixField = document.getElementById("prix");
const poidField = document.getElementById("poid");
const validationModal = document.getElementById("validationModal");
const modal3 = document.getElementById("modal3");


addButton.addEventListener("click", () => {
  modal.style.display = "flex";
});

function openModalUser() {
  modalTitle.textContent = "Ajouter l’utilisateur";
  modal.style.display = "flex";
}

// Fonction pour afficher le modal en mode édition
function openEditModalUser(id, nom, prenom, role, date_arrive_dans_entreprise) {
  modal.style.display = "flex";
  modalTitle.textContent = "Modifier l’utilisateur";
  document.getElementById("utilisateur_id").value = id;
  document.getElementById("utilisateur_nom").value = nom;
  document.getElementById("utilisateur_prenom").value = prenom;
  document.getElementById("utilisateur_role").value = role;
  document.getElementById("utilisateur_date_arrive_dans_entreprise").value = date_arrive_dans_entreprise;
  // Afficher le modal
}

function openDeleteModal_utilisateur(id){
  document.getElementById("utilisateur_id").value = id;
  document.getElementById("delete_utilisateur_id").value = document.getElementById("utilisateur_id").value;
}


//GERER PRODUITS
function openModalProduit() {
  modalTitle.textContent = "Ajouter le produit";
  modal.style.display = "flex";
}

function openEditModalProduit(id, nomCommercial, nomDescriptif, prix, poids) {
  document.getElementById("modalTitle").textContent = "Modifier le produit";
  document.getElementById("product_id").value = id;
  document.getElementById("commercialName").value = nomCommercial;
  document.getElementById("descripName").value = nomDescriptif;
  document.getElementById("prix").value = prix;
  document.getElementById("poids").value = poids;
  document.getElementById("productModal").style.display = "flex";
}

function openDeleteModal(id){
  document.getElementById("product_id").value = id;
  document.getElementById("delete_product_id").value = document.getElementById("product_id").value;
}
//GERER PRODUITS



/*// Afficher le modal lors du clic sur "edit"
editButton.forEach((button) => {
  button.addEventListener("click", () => {
    modal.style.display = "flex";
  });
});
*/

// Afficher le modal lors du clic sur "Supprimer"
buttonSupprimer.forEach((button) => {
  button.addEventListener("click", () => {
    modal3.style.display = "flex";
  });
});


function closeModal() {
  modal.style.display = "none";
}
function closeModalValidation() {
  modal3.style.display = "none";
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

//Ouvrir le modal produit de chaque magasin
function openModalProduitMagasin(){
  modal2.style.display = "flex";
}

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

// Sélection des éléments
const contentBody = document.querySelector(".content-body");
const contentScroll = document.querySelector(".container-scroll");

// Fonction pour afficher la liste
function showList() {
  contentScroll.style.display = "flex"; // Affiche la vue "Liste"
  contentBody.style.display = "none";   // Masque la vue "Détail"
  console.log("Mode Liste activé");
}

// Fonction pour afficher le détail
function showDetail() {
  contentBody.style.display = "flex";  // Affiche la vue "Détail"
  contentScroll.style.display = "none"; // Masque la vue "Liste"
  console.log("Mode Détail activé");
}

const searchInput = document.getElementById("searchInput");
const containterFilter = document.getElementById("containterFilter");
const goButton = document.getElementById("go");

// Affiche la div au clic
searchInput.addEventListener("focus", () => {
  containterFilter.classList.add("active");
});

// Cache le conteneur uniquement au clic sur le bouton "go"
goButton.addEventListener("click", () => {
  containterFilter.classList.remove("active");
});

function closeFilterContainer(){
  containterFilter.classList.remove("active");
}

// Sélection des éléments nécessaires
const filterInput = document.getElementById("searchInput");
const filterElements = document.querySelectorAll("#elementsFilter input[type='radio']");

// Objet pour stocker les sélections par filtre
const selectedFilters = {
    magasin: "",
    produit: "",
    date: ""
};

// Ajout d'un événement sur chaque élément radio
filterElements.forEach((radio) => {
    radio.addEventListener("change", (event) => {
        const filterGroup = event.target.name; // Identifier le groupe (radio_magasin, radio_produit, radio_date)
        const selectedValue = event.target.value; // Récupérer la valeur sélectionnée

        // Mettre à jour la sélection du groupe correspondant
        if (filterGroup.includes("magasin")) {
            selectedFilters.magasin = selectedValue;
        } else if (filterGroup.includes("produit")) {
            selectedFilters.produit = selectedValue;
        } else if (filterGroup.includes("date")) {
            selectedFilters.date = selectedValue;
        }

        // Construire le texte à afficher dans l'input
        const combinedText = Object.values(selectedFilters)
            .filter((value) => value !== "") // Ne conserver que les filtres sélectionnés
            .join(", "); // Les combiner avec une virgule

        // Mettre à jour l'input avec le texte combiné
        filterInput.value = combinedText;
    });
});

