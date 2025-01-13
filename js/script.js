// Sélection des éléments
const modal = document.getElementById("productModal");
const contactModal = document.getElementById("contactModal");
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

const modal2 = document.getElementById("productModal2");
const addButton2 = document.querySelectorAll(".addButton2");
const closeButtons2 = document.querySelectorAll(".close-button2");
const iiiElement = document.getElementById("label1");
const ID = document.getElementById("id_magasin");
const Promotice = document.getElementById("promotrice");
const btnr = document.getElementById("remarqueModal");

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
  modal.style.display = "flex";
  document.getElementById("modalTitle").textContent = "Modifier le produit";
  document.getElementById("product_id").value = id;
  document.getElementById("commercialName").value = nomCommercial;
  document.getElementById("descripName").value = nomDescriptif;
  document.getElementById("prix").value = prix;
  document.getElementById("poids").value = poids;
}


function openDeleteModal(id){
  document.getElementById("product_id").value = id;
  document.getElementById("delete_product_id").value = document.getElementById("product_id").value;
}
function openDeleteModal(id){
  //document.getElementById("product_id").value = id;
  document.getElementById("delete_product_id").value = document.getElementById("product_id").value;
}


function openModalAddTour(code) {
  modal2.style.display = "flex";
  document.getElementById("code_tournee").value = code;
}


const tr = document.getElementById("trblock");
function settrblock(){
  if(tr.style.display === "none"){
    tr.style.display = "table-row";
  }else{
    tr.style.display = "none";
  }
}
const modal_status = document.getElementById("ModalStatut");
const code_tournee2 = document.getElementById("code_tournee2");
function openModalSetStatutTournee(code){
  code_tournee2.value = code;
  modal_status.style.display = "flex";
}
//GERER PRODUITS



/*// Afficher le modal lors du clic sur "edit"
editButton.forEach((button) => {
  button.addEventListener("click", () => {
    modal.style.display = "flex";
  });
});
*/
const remarque_input = document.getElementById("remarque");
function openModalRemarque(id, objectif_content){
  remarque_input.value = objectif_content;
  document.getElementById("id_tour").value = id;
  btnr.style.display="flex";
}

// Afficher le modal lors du clic sur "Supprimer"
buttonSupprimer.forEach((button) => {
  button.addEventListener("click", () => {
    modal3.style.display = "flex";
  });
});


function closeModal() {
  modal.style.display = "none";
  btnr.style.display = "none";
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
  /*window.addEventListener("click", (event) => {
    if (event.target === btnr) {
      btnr.style.display = "none";
    }*/
});

// Sélection des éléments

//Ouvrir le modal produit de chaque magasin
function openModalProduitMagasin(id){
  modal2.style.display = "flex";
  document.getElementById("id_magasinproduit").value=id;
}

function openEditModalMagasin(id) {
  modal.style.display = "flex";
  ID.value = id;
}

function openAddModalContact(id){
  contactModal.style.display = "flex";
  document.getElementById("id_magasin_contact").value = id;
}
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
    contactModal.style.display = "none";
  });
});

window.addEventListener("click", (event) => {
  if (event.target === contactModal) {
    contactModal.style.display = "none";
  }
});

window.addEventListener("click", (event) => {
  if (event.target === alertModal) {
    alertModal.style.display = "none";
    contactModal.style.display = "none";
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

const containcheck = document.getElementById("containcheck");
const user_role = document.getElementById("utilisateur_role");

function showCommerciaux(){
  if(user_role.value === "responsable_commercial"){
    containcheck.style.display = "block";
  } 
}

const visiteButtons = document.querySelectorAll(".visite_id"); // Utilisation de la classe pour les boutons
const btnU = document.querySelectorAll(".btn-unique");
const goVisite = document.getElementById("goVisite");


// Fonction pour afficher les boutons de visite et masquer les autres
function showVisite(){
    if (visiteButtons.length > 0) {
        visiteButtons.forEach(button => {
            button.style.display = "block";  // Affiche tous les boutons de la classe "visite_id"
        });

        btnU.forEach(element => {
            element.style.display = 'none';  // Masque tous les boutons de la classe "btn-unique"
        });
    } else {
        console.error("Aucun bouton .visite_id trouvé.");
    }
}



const tournee_actuel = document.getElementById("tournee-actuel");
const historique = document.querySelectorAll (".histo");

// Fonction pour afficher la liste
function showtournee_actuel() {
  tournee_actuel.style.display = "block"; // Affiche la vue "Liste"
  historique.forEach(element => {
    element.style.display = 'none';
  });  
  console.log("Mode planification activé");
}

// Fonction pour afficher le détail
function showHistorique() {
  historique.forEach(element => {
    element.style.display = 'block';
    //element.style.transition = 'all 0.5s ease-in';
  });  
  tournee_actuel.style.display = "none"; // Masque la vue "Liste"
  console.log("Mode historique activé");
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

function openPromotrice(){
  Promotice.style.display = "block";
}

function hiddenPromotrice(){
  Promotice.style.display = "none";
}

//Caroucelle
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
const slide = document.getElementById("slide");
function openModalSlide(){
  slide.style.display = "block";
}
window.addEventListener("click", (event) => {
  if (event.target === slide) {
    slide.style.display = "none";
  }
});
//const test =document.getElementById("alpha");
//test.textContent = "3";
const Lat =document.getElementById("Latitude");
const Lon =document.getElementById("Longitude");


    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            Lat.value= position.coords.latitude;
            Lon.value = position.coords.longitude;
            //test.textContent = test.textContent+" : Latitude: " + lat + ", Longitude: " + lon;
        }, function(error) {
            console.log("Erreur de géolocalisation : " + error.message);
        });
    } else {
        console.log("La géolocalisation n'est pas supportée par ce navigateur.");
    }



    //Fonction AJAX pour le suivit des visites

    /*function chargerVisite(idMagasin) {
      fetch(`../includes/classes/Magasin.php?id_magasin=${idMagasin}`)
          .then(response => response.json())
          .then(magasin => {
              document.querySelector('#nom_magasin').value = magasin.nom_magasin;
              document.querySelector('#produit').value = magasin.produit;
          })
          .catch(error => console.error('Erreur:', error));
  }

    function passerVisiteSuivante(idTournee, idMagasinActuel) {
      fetch(`get_magasin_suivant.php?id_tournee=${idTournee}&id_magasin=${idMagasinActuel}`)
          .then(response => response.json())
          .then(magasinSuivant => {
              if (magasinSuivant) {
                  chargerVisite(magasinSuivant.id_magasin);
              } else {
                  alert('Toutes les visites sont terminées !');
                  location.reload(); // Recharge la page pour afficher l'état final
              }
          })
          .catch(error => console.error('Erreur:', error));
  }*/

  function sedTourneeInformation(nom, ville, code){
      const villeEncode = encodeURIComponent(ville);
      const nameEncode = encodeURIComponent(nom);
      const codeEncode = encodeURIComponent(code);

      window.location.href = `visite.php?nomMagasin=${nameEncode}&villeMagasin=${villeEncode}&codeTournee=${codeEncode}`;
  }
  

  function submitForm() {
    console.error('Debut..........');
    var formData = new FormData(document.getElementById('productForm'));

    fetch('../includes/classes/enregistrerVisite.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert('Données enregistrées avec succès !');
        console.log(data);
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}

function goTomagasin(){
  window.location.href = "../pages/magasin.php";
}
function goToproduit(){
  window.location.href = "../pages/produit.php";
}
function goTolivraison(){
  window.location.href = "../pages/livraison.php";
}
function goTotournee(){
  window.location.href = "../pages/rapport.php";
}


