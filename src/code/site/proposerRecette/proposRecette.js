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

