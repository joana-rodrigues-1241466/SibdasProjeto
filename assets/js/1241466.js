// Confirmação do formulário de contactos
document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.querySelector(".form-contactos");
    const mensagemContactos = document.getElementById("mensagem-contactos");

    if (formulario) {
        formulario.addEventListener("submit", function (event) {
            event.preventDefault();

            mensagemContactos.textContent = "Mensagem enviada com sucesso.";
            mensagemContactos.className = "mensagem-contactos sucesso";

            formulario.reset();
        });
    }
});

// Confirmação do formulário de iniciar sessão
document.addEventListener("DOMContentLoaded", function () {
    const formularioLogin = document.querySelector(".form-login");
    const mensagemLogin = document.getElementById("mensagem-login");

    if (formularioLogin) {
        formularioLogin.addEventListener("submit", function (event) {
            event.preventDefault();

            mensagemLogin.textContent = "Início de sessão efetuado com sucesso.";
            mensagemLogin.className = "mensagem-login sucesso";

            setTimeout(function () {
                window.location.href = "gestao_conteudos.html";
            }, 1000);
        });
    }
});