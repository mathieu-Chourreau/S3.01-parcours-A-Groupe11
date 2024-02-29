var boutonValider = document.getElementById("validerTout");

boutonValider.addEventListener("click", function() {

    event.preventDefault();

    document.getElementById("form1").submit();
    document.getElementById("form2").submit();

});