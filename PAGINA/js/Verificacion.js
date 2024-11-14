document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");

    form.addEventListener("submit", function(event) {
        const password = document.getElementById("password").value;

        if (password.length < 6) {
            alert("La contraseña debe tener al menos 6 caracteres.");
            event.preventDefault();
        }
    });
});