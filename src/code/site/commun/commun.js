const menuHamburger = document.getElementById("burger");
const navLinks = document.querySelector(".titreMenu");
menuHamburger.addEventListener('click', () => { navLinks.classList.toggle('mobile-menu') });

function toggleDropdown() {
    var dropdownContent = document.getElementById("dropdownContent");
    dropdownContent.style.display === "block" ? dropdownContent.style.display = "none" : dropdownContent.style.display = "block";
}