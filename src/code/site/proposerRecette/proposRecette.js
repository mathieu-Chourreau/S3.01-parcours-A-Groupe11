var validerToutButton = document.getElementById('validerTout');

validerToutButton.disabled =true;
validerToutButton.style.backgroundColor = "rgb(110, 65, 65)";

document.getElementById('niveau').addEventListener('change', function() {
    if (this.value !== "0") {
        validerToutButton.disabled = false;
        validerToutButton.style.backgroundColor = "rgb(123, 8, 8)";
    } else {
        validerToutButton.disabled = true;
        validerToutButton.style.backgroundColor = "rgb(110, 65, 65)";
    }
});

document.addEventListener("DOMContentLoaded", function() {
    var searchInput = document.getElementById('searchInput');
    var ingredientsDiv = document.getElementById('ingredientsDiv');
    var checkboxes = document.querySelectorAll('.ingredient-checkbox');

    searchInput.addEventListener('input', function() {
        var searchTerm = searchInput.value.toLowerCase();
        checkboxes.forEach(function(checkbox) {
            var label = checkbox.textContent.toLowerCase();
            if (label.includes(searchTerm)) {
                checkbox.style.display = "block";
            } else {
                checkbox.style.display = "none";
            }
        });
    });
});