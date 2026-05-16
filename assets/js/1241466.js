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

// Apoio de IA (ChatGPT): gestão dinâmica dos conteúdos da área pública com localStorage
document.addEventListener("DOMContentLoaded", function () {

    const camposGestao = {
        homeTitulo: document.getElementById("editar-home-titulo"),
        homeTexto: document.getElementById("editar-home-texto"),
        homeBotao: document.getElementById("editar-home-botao"),

        sobreTitulo: document.getElementById("editar-sobre-titulo"),
        sobreTexto: document.getElementById("editar-sobre-texto"),

        funcionalidadesTitulo: document.getElementById("editar-funcionalidades-titulo"),
        funcionalidadesTexto: document.getElementById("editar-funcionalidades-texto"),

        contactosTitulo: document.getElementById("editar-contactos-titulo"),
        contactosTexto: document.getElementById("editar-contactos-texto"),

        localizacao: document.getElementById("editar-localizacao"),
        horario: document.getElementById("editar-horario"),
        email: document.getElementById("editar-email"),
        telefone: document.getElementById("editar-telefone")
    };

    const formularioGestao = document.querySelector(".form-gestao-conteudos");
    const mensagemGestao = document.getElementById("mensagem-gestao");
    const botaoRepor = document.getElementById("repor-conteudos");

    const conteudosOriginais = {
        homeTitulo: "MediVault",
        homeTexto: "Plataforma de gestão de inventário hospitalar.",
        homeBotao: "Entre em contacto connosco",

        sobreTitulo: "Sobre",
        sobreTexto: "A MediVault é uma plataforma desenvolvida para apoiar a gestão do inventário hospitalar, permitindo organizar equipamentos médicos, controlar documentação, acompanhar garantias e melhorar a rastreabilidade dos recursos existentes.",

        funcionalidadesTitulo: "Funcionalidades",
        funcionalidadesTexto: "A MediVault disponibiliza um conjunto de serviços e funcionalidades para gerir o inventário hospitalar com eficiência, segurança e total rastreabilidade.",

        contactosTitulo: "Contactos",
        contactosTexto: "Entre em contacto connosco para esclarecer dúvidas sobre a MediVault ou obter mais informações sobre a gestão do inventário hospitalar.",

        localizacao: "Travessa Encosta do Pilar\n9000-136, Funchal\nMadeira",
        horario: "2.ª a 6.ª Feira: 09h - 19h\nSábados e Feriados: 09h - 13h\nDomingo: Encerrado",
        email: "suporte@medivault.pt",
        telefone: "+351 930 466 310"
    };

    function obterConteudo(chave) {
        return localStorage.getItem(chave) || conteudosOriginais[chave];
    }

    function preencherFormularioGestao() {
        if (!formularioGestao) {
            return;
        }

        for (let chave in camposGestao) {
            if (camposGestao[chave]) {
                camposGestao[chave].value = obterConteudo(chave);
            }
        }
    }

    function guardarConteudos(event) {
        event.preventDefault();

        for (let chave in camposGestao) {
            if (camposGestao[chave]) {
                localStorage.setItem(chave, camposGestao[chave].value);
            }
        }

        if (mensagemGestao) {
            mensagemGestao.textContent = "Conteúdos guardados com sucesso.";
            mensagemGestao.className = "mensagem-login sucesso";
        }
    }

    function reporConteudosOriginais() {
        for (let chave in conteudosOriginais) {
            localStorage.removeItem(chave);
        }

        preencherFormularioGestao();

        if (mensagemGestao) {
            mensagemGestao.textContent = "Conteúdos originais repostos com sucesso.";
            mensagemGestao.className = "mensagem-login sucesso";
        }
    }

    function atualizarTexto(idElemento, chave) {
        const elemento = document.getElementById(idElemento);

        if (elemento) {
            elemento.textContent = obterConteudo(chave);
        }
    }

    function atualizarTextoComQuebras(idElemento, chave) {
        const elemento = document.getElementById(idElemento);

        if (elemento) {
            elemento.innerHTML = obterConteudo(chave).replace(/\n/g, "<br>");
        }
    }

    function aplicarConteudosNaAreaPublica() {
        atualizarTexto("home-titulo", "homeTitulo");
        atualizarTexto("home-texto", "homeTexto");
        atualizarTexto("home-botao", "homeBotao");

        atualizarTexto("sobre-titulo", "sobreTitulo");
        atualizarTexto("sobre-texto", "sobreTexto");

        atualizarTexto("funcionalidades-titulo", "funcionalidadesTitulo");
        atualizarTexto("funcionalidades-texto", "funcionalidadesTexto");

        atualizarTexto("contactos-titulo", "contactosTitulo");
        atualizarTexto("contactos-texto", "contactosTexto");

        atualizarTextoComQuebras("rodape-localizacao", "localizacao");
        atualizarTextoComQuebras("rodape-horario", "horario");
        atualizarTexto("rodape-email", "email");
        atualizarTexto("rodape-telefone", "telefone");
    }

    preencherFormularioGestao();
    aplicarConteudosNaAreaPublica();

    if (formularioGestao) {
        formularioGestao.addEventListener("submit", guardarConteudos);
    }

    if (botaoRepor) {
        botaoRepor.addEventListener("click", reporConteudosOriginais);
    }
});