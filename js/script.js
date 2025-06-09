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

const imagePreview = document.getElementById("imagePreview");
const svgImage = document.getElementById("svgImage");
const inputImage = document.getElementById("imageFile");

function goTotournee1() {
  window.location.href = "tournee-com.php";
}

function openModalUser() {
  modalTitle.textContent = "Ajouter l'utilisateur";
  modal.style.display = "flex";
}

/*window.addEventListener("click", (event) => {
  if (event.target === nextVisitModal) {
    nextVisitModal.style.display = "none";
  }
});*/

addButton.addEventListener("click", () => {
  modal.style.display = "flex";
});

function openModalUser() {
  modalTitle.textContent = "Ajouter l'utilisateur";
  modal.style.display = "flex";
}

// Sélection des éléments
const contentBody = document.querySelector(".content-body");
const contentScroll = document.querySelector(".container-scroll");

// Fonction pour afficher la liste
function showList() {
  contentScroll.style.display = "flex"; // Affiche la vue "Liste"
  contentBody.style.display = "none"; // Masque la vue "Détail"
  console.log("Mode Liste activé");
}

// Fonction pour afficher le détail
function showDetail() {
  contentBody.style.display = "flex"; // Affiche la vue "Détail"
  contentScroll.style.display = "none"; // Masque la vue "Liste"
  console.log("Mode Détail activé");
}

// Fonction pour envoyer les données du formulaire via AJAX
/*function submitVisiteForm(event) {
    event.preventDefault(); // Empêche la soumission normale du formulaire

    var formData = new FormData(document.getElementById('visiteForm'));

    fetch('includes/classes/enregistrerVisite.php', {
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

// Ajoutez un écouteur d'événement pour le formulaire
document.getElementById('visiteForm').addEventListener('submit', submitVisiteForm);*/

// Fonction pour afficher le modal en mode édition
function openEditModalUser(id, nom, prenom, role, date_arrive_dans_entreprise) {
  modal.style.display = "flex";
  modalTitle.textContent = "Modifier l'utilisateur";
  document.getElementById("utilisateur_id").value = id;
  document.getElementById("utilisateur_nom").value = nom;
  document.getElementById("utilisateur_prenom").value = prenom;
  document.getElementById("utilisateur_role").value = role;
  document.getElementById("utilisateur_date_arrive_dans_entreprise").value =
    date_arrive_dans_entreprise;
  // Afficher le modal
}

function openDeleteModal_utilisateur(id) {
  document.getElementById("utilisateur_id").value = id;
  document.getElementById("delete_utilisateur_id").value =
    document.getElementById("utilisateur_id").value;
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

function openModalSpecificMagasin(code) {
  modal.style.display = "flex";
  //document.getElementById('code_transfer').value = code;
}

function openDeleteModal(id) {
  document.getElementById("product_id").value = id;
  document.getElementById("delete_product_id").value =
    document.getElementById("product_id").value;
}
function openDeleteModal(id) {
  //document.getElementById("product_id").value = id;
  document.getElementById("delete_product_id").value =
    document.getElementById("product_id").value;
}

//GERER LES LIVRAISONS
function openModalLivraison() {
  modalTitle.textContent = "Ajouter une Livraison";
  modal.style.display = "flex";
}

function openModalAddTour(code) {
  console.log("Hello");
  modal2.style.display = "flex";
  document.getElementById("code_tournee").value = code;
}

const tr = document.getElementById("trblock");
/*function settrblock(){
  if(tr.style.display === "none"){
    tr.style.display = "table-row";
  }else{
    tr.style.display = "none";
  }
}*/
const modal_status = document.getElementById("ModalStatut");
const code_tournee2 = document.getElementById("code_tournee2");
function openModalSetStatutTournee(code) {
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
function openModalRemarque(id, objectif_content) {
  remarque_input.value = objectif_content;
  document.getElementById("id_tour").value = id;
  btnr.style.display = "flex";
}

// Afficher le modal lors du clic sur "Supprimer"
buttonSupprimer.forEach((button) => {
  button.addEventListener("click", () => {
    modal3.style.display = "flex";
  });
});

function closeModal() {
  modal.style.display = "none";
}
/*function closeModal() {
  btnr.style.display = "none";
}*/
function closeModalValidation() {
  modal3.style.display = "none";
}

// Sélection des éléments

//Ouvrir le modal produit de chaque magasin
function openModalProduitMagasin1(id) {
  modal2.style.display = "flex";
  document.getElementById("id_magasinproduit").value = id;
}

function openModalProduitMagasin(id) {
  document.getElementById("id_livraison_form").value = id;
  modal2.style.display = "flex";
}

function openEditModalMagasin(id) {
  modal.style.display = "flex";
  ID.value = id;
}

function openAddModalContact(id) {
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
    contactModal.style.display = "none";
  });
});
closeButtons.forEach((button) => {
  button.addEventListener("click", () => {
    alertModal.style.display = "none";
  });
});

const containcheck = document.getElementById("containcheck");
const user_role = document.getElementById("utilisateur_role");

function showCommerciaux() {
  if (user_role.value === "responsable_commercial") {
    containcheck.style.display = "block";
  }
}

const visiteButtons = document.querySelectorAll(".visite_id"); // Utilisation de la classe pour les boutons
const btnU = document.querySelectorAll(".btn-unique");
const goVisite = document.getElementById("goVisite");

// Fonction pour afficher les boutons de visite et masquer les autres
function showVisite() {
  if (visiteButtons.length > 0) {
    visiteButtons.forEach((button) => {
      button.style.display = "block"; // Affiche tous les boutons de la classe "visite_id"
    });

    btnU.forEach((element) => {
      element.style.display = "none"; // Masque tous les boutons de la classe "btn-unique"
    });
  } else {
    console.error("Aucun bouton .visite_id trouvé.");
  }
}

const tournee_actuel = document.getElementById("tournee-actuel");
const historique = document.querySelectorAll(".histo");

// Fonction pour afficher la liste
function showtournee_actuel() {
  tournee_actuel.style.display = "block"; // Affiche la vue "Liste"
  historique.forEach((element) => {
    element.style.display = "none";
  });
  console.log("Mode planification activé");
}

// Fonction pour afficher le détail
function showHistorique() {
  historique.forEach((element) => {
    element.style.display = "block";
    //element.style.transition = 'all 0.5s ease-in';
  });
  tournee_actuel.style.display = "none"; // Masque la vue "Liste"
  console.log("Mode historique activé");
}

const searchInput = document.getElementById("searchInput");
const containterFilter = document.getElementById("containterFilter");
const goButton = document.getElementById("go");

// Affiche la div au clic
/*searchInput.addEventListener("focus", () => {
  containterFilter.classList.add("active");
});

// Cache le conteneur uniquement au clic sur le bouton "go"
goButton.addEventListener("click", () => {
  containterFilter.classList.remove("active");
});

function closeFilterContainer(){
  containterFilter.classList.remove("active");
}*/

// Sélection des éléments nécessaires
const filterInput = document.getElementById("searchInput");
const filterElements = document.querySelectorAll(
  "#elementsFilter input[type='radio']"
);

// Objet pour stocker les sélections par filtre
const selectedFilters = {
  magasin: "",
  produit: "",
  date: "",
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

function openPromotrice() {
  Promotice.style.display = "block";
}

function hiddenPromotrice() {
  Promotice.style.display = "none";
}

// Vérifier si les éléments existent avant d'utiliser la géolocalisation
const Lat = document.getElementById("Latitude");
const Lon = document.getElementById("Longitude");

if (Lat && Lon && navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(
    function (position) {
      Lat.value = position.coords.latitude;
      Lon.value = position.coords.longitude;
    },
    function (error) {
      console.log("Erreur de géolocalisation : " + error.message);
    }
  );
} else {
  console.log(
    "La géolocalisation n'est pas disponible ou les champs sont manquants."
  );
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

function sendTourneeInformation(nom, ville, code,type) {
  const villeEncode = encodeURIComponent(ville);
  const nameEncode = encodeURIComponent(nom);
  const codeEncode = encodeURIComponent(code);
  const typeEncode = encodeURIComponent(type);

  window.location.href = `visite.php?nomMagasin=${nameEncode}&villeMagasin=${villeEncode}&codeTournee=${codeEncode}&typeTournee=${typeEncode}`;
}

function submitForm() {
  console.error("Debut..........");
  var formData = new FormData(document.getElementById("productForm"));

  fetch("../includes/classes/enregistrerVisite.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      alert("Données enregistrées avec succès !");
      console.log(data);
    })
    .catch((error) => {
      console.error("Erreur:", error);
    });
}

function goTomagasin() {
  window.location.href = "../pages/magasin.php";
}
function goToproduit() {
  window.location.href = "../pages/produit.php";
}
function goTolivraison() {
  window.location.href = "../pages/livraison.php";
}
function goTotournee() {
  window.location.href = "../pages/rapport.php";
}

//Caroucelle
function plusSlides(n) {
  showSlides((slideIndex += n));
}

function currentSlide(n) {
  showSlides((slideIndex = n));
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {
    slideIndex = 1;
  }
  if (n < 1) {
    slideIndex = slides.length;
  }
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  // Assurez-vous que slideIndex est correct avant de décommenter ces lignes
  if (slideIndex >= 1 && slideIndex <= slides.length) {
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
  }
}
const slide = document.getElementById("slide");
function openModalSlide() {
  slide.style.display = "block";
}

function previewImage() {
  if (inputImage.files && inputImage.files[0]) {
    const reader = new FileReader();
    reader.onload = function () {
      imagePreview.src = reader.result;
    };
    reader.readAsDataURL(inputImage.files[0]);
  }
  imagePreview.style.display = "block";
  svgImage.style.display = "none";
}
let slideIndex = 1;

showSlides(slideIndex);

// Vérifiez que les éléments existent
console.log(contactModal, alertModal, modal, modal3, modal2, slide);

// Ajoutez les écouteurs d'événements
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

window.addEventListener("click", (event) => {
  if (event.target === modal2) {
    modal2.style.display = "none";
  }
});

window.addEventListener("click", (event) => {
  if (event.target === slide) {
    slide.style.display = "none";
  }
});

function handleTourneeStatus(button, codeVisite) {
  const currentStatut = parseInt(button.dataset.statut);
  let newStatut;

  // Détermination du nouveau statut
  if (currentStatut === 0 || currentStatut === 1) {
    newStatut = 2; // En attente -> En cours
  } else if (currentStatut === 2) {
    newStatut = 3; // En cours -> Terminé
  } else {
    // Vérification si toutes les visites sont validées
    fetch(
      `../includes/classes/tournee_method/checkVisites.php?code=${encodeURIComponent(
        codeVisite
      )}`
    )
      .then((response) => response.json())
      .then((data) => {
        if (data.allValid) {
          newStatut = 3; // En cours -> Terminé
          // Mettre à jour le statut de la tournée
          updateTourneeStatus(codeVisite, newStatut);
        } else {
          alert(
            "Toutes les visites doivent être validées avant de terminer la tournée."
          );
        }
      });
    return; // Ne rien faire si déjà terminé
  }

  // Requête au serveur pour mettre à jour le statut
  fetch("../includes/classes/tournee_method/setStatut.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `code=${encodeURIComponent(codeVisite)}&statut=${encodeURIComponent(
      newStatut
    )}`,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Mise à jour du bouton principal
        button.dataset.statut = newStatut;

        // Récupération du conteneur de la tournée
        const tableContainer = button.closest(".table-container");

        // Mise à jour du texte du bouton principal
        if (newStatut === 2) {
          button.textContent = "Tournée en cours";
        } else if (newStatut === 3) {
          button.textContent = "Tournée terminée";
        }

        // Mise à jour du span de statut
        const statutSpan = tableContainer.querySelector("span");
        if (statutSpan) {
          if (newStatut === 2) {
            statutSpan.innerHTML = "En cours";
            statutSpan.style.color = "green";
            statutSpan.style.fontWeight = "bold";
            statutSpan.style.padding = "2px";
            statutSpan.style.border = "1px solid green";
          } else if (newStatut === 3) {
            statutSpan.innerHTML = "Effectué";
            statutSpan.style.color = "#26c4ec";
            statutSpan.style.fontWeight = "bold";
            statutSpan.style.padding = "2px";
            statutSpan.style.border = "1px solid #26c4ec";
          }
        }

        // Mise à jour de la visibilité des boutons
        const modifierBtns = tableContainer.querySelectorAll(
          ".btn-green, .delete-btn"
        );
        const visiterBtns = tableContainer.querySelectorAll(".btn-purple");
        const ajouterMagasinBtn = tableContainer.querySelector(
          '[onclick^="openModalAddTour"]'
        );

        if (newStatut === 2) {
          // En cours: Cacher les boutons modifier/supprimer, montrer visiter
          modifierBtns.forEach((btn) => (btn.style.display = "none"));
          visiterBtns.forEach((btn) => (btn.style.display = "inline-block"));
          if (ajouterMagasinBtn) ajouterMagasinBtn.style.display = "none";
        } else if (newStatut === 3) {
          // Terminé: Garder la même visibilité qu'en cours
          modifierBtns.forEach((btn) => (btn.style.display = "none"));
          visiterBtns.forEach((btn) => (btn.style.display = "inline-block"));
          if (ajouterMagasinBtn) ajouterMagasinBtn.style.display = "none";
        }
      }
    })
    .catch((error) => {
      console.error("Erreur lors de la mise à jour du statut:", error);
    });
}
