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