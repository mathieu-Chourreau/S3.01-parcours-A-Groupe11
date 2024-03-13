var validerToutButton = document.getElementById('validerTout');


validerToutButton.style.backgroundColor = "rgb(110, 65, 65)";

document.getElementById('niveau').addEventListener('change', function() {
    if (this.value !== "0") {
        validerToutButton.style.backgroundColor = "rgb(123, 8, 8)";
    } else {
        validerToutButton.style.backgroundColor = "rgb(110, 65, 65)";
    }
});

document.addEventListener("DOMContentLoaded", function() {
    var searchInput = document.getElementById('searchInput');
    var checkboxesContainer = document.getElementById('checkboxContainer');
    var checkboxes = checkboxesContainer.querySelectorAll('.ingredient-checkbox');

    // Créer une copie de sauvegarde des cases à cocher pour une réinitialisation ultérieure
    var checkboxesBackup = Array.from(checkboxesContainer.children);

    searchInput.addEventListener('input', function() {
        var searchTerm = searchInput.value.toLowerCase();

        // Supprimer toutes les cases à cocher actuelles
        checkboxesContainer.innerHTML = '';

        // Recréer les cases à cocher visibles en fonction du terme de recherche
        checkboxesBackup.forEach(function(checkbox) {
            var label = checkbox.textContent.toLowerCase();
            if (label.includes(searchTerm)) {
                checkboxesContainer.appendChild(checkbox); // Ajouter la case à cocher au conteneur si elle correspond au terme de recherche
            }
        });
    });
});

