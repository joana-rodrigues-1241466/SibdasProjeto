// Mensagem ao enviar o formulário de contactos
document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.querySelector(".form-contactos");

    if (formulario) {
        formulario.addEventListener("submit", function (event) {
            event.preventDefault();

            alert("Mensagem enviada com sucesso!");

            formulario.reset();
        });
    }
});