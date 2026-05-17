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
        sobreTexto1: document.getElementById("editar-sobre-texto-1"),
        sobreTexto2: document.getElementById("editar-sobre-texto-2"),
        sobreTexto3: document.getElementById("editar-sobre-texto-3"),

        sobreCardTitulo: document.getElementById("editar-sobre-card-titulo"),
        sobreCardTexto1: document.getElementById("editar-sobre-card-texto-1"),
        sobreCardTexto2: document.getElementById("editar-sobre-card-texto-2"),
        sobreCardTexto3: document.getElementById("editar-sobre-card-texto-3"),
        sobreCardTexto4: document.getElementById("editar-sobre-card-texto-4"),

        funcionalidadesTitulo: document.getElementById("editar-funcionalidades-titulo"),
        funcionalidadesTexto: document.getElementById("editar-funcionalidades-texto"),

        funcionalidadeTitulo1: document.getElementById("editar-funcionalidade-titulo-1"),
        funcionalidadeTexto1: document.getElementById("editar-funcionalidade-texto-1"),

        funcionalidadeTitulo2: document.getElementById("editar-funcionalidade-titulo-2"),
        funcionalidadeTexto2: document.getElementById("editar-funcionalidade-texto-2"),

        funcionalidadeTitulo3: document.getElementById("editar-funcionalidade-titulo-3"),
        funcionalidadeTexto3: document.getElementById("editar-funcionalidade-texto-3"),

        funcionalidadeTitulo4: document.getElementById("editar-funcionalidade-titulo-4"),
        funcionalidadeTexto4: document.getElementById("editar-funcionalidade-texto-4"),

        funcionalidadeTitulo5: document.getElementById("editar-funcionalidade-titulo-5"),
        funcionalidadeTexto5: document.getElementById("editar-funcionalidade-texto-5"),

        funcionalidadeTitulo6: document.getElementById("editar-funcionalidade-titulo-6"),
        funcionalidadeTexto6: document.getElementById("editar-funcionalidade-texto-6"),

        funcionalidadeTitulo7: document.getElementById("editar-funcionalidade-titulo-7"),
        funcionalidadeTexto7: document.getElementById("editar-funcionalidade-texto-7"),

        funcionalidadeTitulo8: document.getElementById("editar-funcionalidade-titulo-8"),
        funcionalidadeTexto8: document.getElementById("editar-funcionalidade-texto-8"),

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
        homeTitulo: "Sistema de Inventário de Equipamentos Hospitalares",
        homeTexto: "Plataforma web para gestão e monitorização do inventário de equipamentos médicos em ambiente hospitalar.",
        homeBotao: "Entre em contacto connosco",

        sobreTitulo: "Sobre",
        sobreTexto1: "A MediVault é uma plataforma desenvolvida para apoiar a gestão do inventário hospitalar, permitindo organizar equipamentos médicos, controlar documentação, acompanhar garantias e melhorar a rastreabilidade dos recursos existentes.",
        sobreTexto2: "O sistema permite reunir, num único local, informação essencial sobre os equipamentos, incluindo categoria, localização, estado atual, fornecedor, documentação técnica, garantias e contactos associados.",
        sobreTexto3: "O objetivo da plataforma é substituir métodos dispersos, como folhas de cálculo, documentos isolados e registos manuais, por uma solução digital mais segura, acessível e eficiente para os utilizadores autorizados.",

        sobreCardTitulo: "O que a MediVault permite?",
        sobreCardTexto1: "Gerir equipamentos médicos e respetiva informação técnica",
        sobreCardTexto2: "Associar equipamentos a localizações hospitalares específicas",
        sobreCardTexto3: "Registar fornecedores, garantias e contratos associados",
        sobreCardTexto4: "Consultar indicadores básicos através de um dashboard",

        funcionalidadesTitulo: "Funcionalidades",
        funcionalidadesTexto: "A MediVault disponibiliza um conjunto de serviços e funcionalidades para gerir o inventário hospitalar com eficiência, segurança e total rastreabilidade.",

        funcionalidadeTitulo1: "Gestão de Equipamentos",
        funcionalidadeTexto1: "Registe, consulte, edite e arquive equipamentos médicos com total rastreabilidade e controlo.",

        funcionalidadeTitulo2: "Localizações",
        funcionalidadeTexto2: "Associe cada equipamento à sua localização física: edifício, piso, serviço e sala.",

        funcionalidadeTitulo3: "Gestão de Fornecedores",
        funcionalidadeTexto3: "Gerencie fornecedores, fabricantes e entidades de assistência técnica associados aos equipamentos.",

        funcionalidadeTitulo4: "Documentação",
        funcionalidadeTexto4: "Associe documentos técnicos, manuais, certificados, relatórios e contratos aos equipamentos.",

        funcionalidadeTitulo5: "Garantias e Contratos",
        funcionalidadeTexto5: "Registe garantias e contratos de manutenção, incluindo prazos, entidades responsáveis e periodicidade.",

        funcionalidadeTitulo6: "Pesquisa e Filtragem",
        funcionalidadeTexto6: "Pesquise e filtre equipamentos por código, designação, marca, modelo, número de série, serviço e estado.",

        funcionalidadeTitulo7: "Dashboard",
        funcionalidadeTexto7: "Visualize indicadores e estatísticas importantes sobre o inventário: totais, estados, serviços e garantias.",

        funcionalidadeTitulo8: "Alertas e Notificações",
        funcionalidadeTexto8: "Receba alertas sobre manutenções, garantias a expirar, documentos vencidos e outras situações relevantes.",

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
        atualizarTexto("sobre-texto-1", "sobreTexto1");
        atualizarTexto("sobre-texto-2", "sobreTexto2");
        atualizarTexto("sobre-texto-3", "sobreTexto3");

        atualizarTexto("sobre-card-titulo", "sobreCardTitulo");
        atualizarTexto("sobre-card-texto-1", "sobreCardTexto1");
        atualizarTexto("sobre-card-texto-2", "sobreCardTexto2");
        atualizarTexto("sobre-card-texto-3", "sobreCardTexto3");
        atualizarTexto("sobre-card-texto-4", "sobreCardTexto4");

        atualizarTexto("funcionalidades-titulo", "funcionalidadesTitulo");
        atualizarTexto("funcionalidades-texto", "funcionalidadesTexto");

        atualizarTexto("funcionalidade-titulo-1", "funcionalidadeTitulo1");
        atualizarTexto("funcionalidade-texto-1", "funcionalidadeTexto1");

        atualizarTexto("funcionalidade-titulo-2", "funcionalidadeTitulo2");
        atualizarTexto("funcionalidade-texto-2", "funcionalidadeTexto2");

        atualizarTexto("funcionalidade-titulo-3", "funcionalidadeTitulo3");
        atualizarTexto("funcionalidade-texto-3", "funcionalidadeTexto3");

        atualizarTexto("funcionalidade-titulo-4", "funcionalidadeTitulo4");
        atualizarTexto("funcionalidade-texto-4", "funcionalidadeTexto4");

        atualizarTexto("funcionalidade-titulo-5", "funcionalidadeTitulo5");
        atualizarTexto("funcionalidade-texto-5", "funcionalidadeTexto5");

        atualizarTexto("funcionalidade-titulo-6", "funcionalidadeTitulo6");
        atualizarTexto("funcionalidade-texto-6", "funcionalidadeTexto6");

        atualizarTexto("funcionalidade-titulo-7", "funcionalidadeTitulo7");
        atualizarTexto("funcionalidade-texto-7", "funcionalidadeTexto7");

        atualizarTexto("funcionalidade-titulo-8", "funcionalidadeTitulo8");
        atualizarTexto("funcionalidade-texto-8", "funcionalidadeTexto8");

        atualizarTexto("contactos-titulo", "contactosTitulo");
        atualizarTexto("contactos-texto", "contactosTexto");

        atualizarTextoComQuebras("rodape-localizacao", "localizacao");
        atualizarTextoComQuebras("rodape-horario", "horario");
        atualizarTexto("rodape-email", "email");
        atualizarTexto("rodape-telefone", "telefone");

        atualizarTexto("nav-sobre", "sobreTitulo");
        atualizarTexto("nav-funcionalidades", "funcionalidadesTitulo");
        atualizarTexto("nav-contactos", "contactosTitulo");
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

// Dados fictícios dos equipamentos para a página de consulta e edição
const equipamentosConsulta = {
    EQ001: {
        codigo: "EQ001",
        designacao: "Monitor multiparamétrico de sinais vitais",
        categoria: "Monitorização",
        marca: "Philips",
        modelo: "IntelliVue MP5",
        numeroSerie: "MP5-2022-45873",
        fabricante: "Philips Healthcare",
        anoFabrico: "2022",
        dataAquisicao: "15/04/2023",
        custoAquisicao: "3200 €",
        tipoEntrada: "Compra",
        estado: "Ativo",
        criticidade: "Suporte de vida",
        localizacao: "Unidade de Cuidados Intensivos",
        observacoes: "Equipamento utilizado para monitorizar continuamente parâmetros fisiológicos do doente, como frequência cardíaca, saturação de oxigénio, pressão arterial e temperatura."
    },

    EQ002: {
        codigo: "EQ002",
        designacao: "Ventilador pulmonar",
        categoria: "Suporte de vida",
        marca: "Dräger",
        modelo: "Evita V500",
        numeroSerie: "EV500-2021-9934",
        fabricante: "Dräger Medical",
        anoFabrico: "2021",
        dataAquisicao: "10/02/2022",
        custoAquisicao: "18500 €",
        tipoEntrada: "Compra",
        estado: "Ativo",
        criticidade: "Suporte de vida",
        localizacao: "Unidade de Cuidados Intensivos",
        observacoes: "Equipamento utilizado para suporte ventilatório de doentes que não conseguem respirar de forma autónoma."
    },

    EQ003: {
        codigo: "EQ003",
        designacao: "Bomba de infusão",
        categoria: "Terapia",
        marca: "B. Braun",
        modelo: "Infusomat Space",
        numeroSerie: "INF-2020-88321",
        fabricante: "B. Braun Medical",
        anoFabrico: "2020",
        dataAquisicao: "22/09/2021",
        custoAquisicao: "1450 €",
        tipoEntrada: "Compra",
        estado: "Ativo",
        criticidade: "Média",
        localizacao: "Serviço de Medicina",
        observacoes: "Equipamento utilizado para administração controlada de medicamentos e fluidos intravenosos."
    },

    EQ004: {
        codigo: "EQ004",
        designacao: "Desfibrilhador",
        categoria: "Suporte de vida",
        marca: "Zoll",
        modelo: "R Series",
        numeroSerie: "ZR-2021-7712",
        fabricante: "Zoll Medical",
        anoFabrico: "2021",
        dataAquisicao: "05/06/2022",
        custoAquisicao: "7900 €",
        tipoEntrada: "Compra",
        estado: "Ativo",
        criticidade: "Alta",
        localizacao: "Urgência",
        observacoes: "Equipamento utilizado para tratamento de arritmias cardíacas graves através da administração de choques elétricos controlados."
    }
};

// Carregar equipamentos guardados no navegador ou usar os dados iniciais
let equipamentosGuardados = JSON.parse(localStorage.getItem("equipamentosGuardados"));

if (!equipamentosGuardados) {
    equipamentosGuardados = equipamentosConsulta;
    localStorage.setItem("equipamentosGuardados", JSON.stringify(equipamentosGuardados));
}

// Adicionar novo equipamento e guardar no localStorage
document.addEventListener("DOMContentLoaded", function () {

    const formularioNovoEquipamento = document.getElementById("form-novo-equipamento");
    const mensagemSucesso = document.getElementById("mensagemSucessoEquipamento");

    if (!formularioNovoEquipamento) {
        return;
    }

    formularioNovoEquipamento.addEventListener("submit", function (event) {
        event.preventDefault();

        if (!formularioNovoEquipamento.checkValidity()) {
            formularioNovoEquipamento.reportValidity();
            return;
        }

        const codigo = document.getElementById("codigo").value.trim();

        if (equipamentosGuardados[codigo]) {
            if (mensagemSucesso) {
                mensagemSucesso.style.display = "block";
                mensagemSucesso.textContent = "Já existe um equipamento com esse código.";
                mensagemSucesso.classList.remove("sucesso");
                mensagemSucesso.classList.add("erro");
            }

            return;
        }

        const novoEquipamento = {
            codigo: codigo,
            designacao: document.getElementById("designacao").value.trim(),
            categoria: document.getElementById("categoria").value,
            marca: document.getElementById("marca").value.trim(),
            modelo: document.getElementById("modelo").value.trim(),
            numeroSerie: document.getElementById("numero_serie").value.trim(),
            fabricante: document.getElementById("fabricante").value.trim(),
            anoFabrico: document.getElementById("ano_fabrico").value,
            dataAquisicao: converterDataParaTexto(document.getElementById("data_aquisicao").value),
            custoAquisicao: document.getElementById("custo_aquisicao").value + " €",
            tipoEntrada: document.getElementById("tipo_entrada").value,
            estado: document.getElementById("estado").value,
            criticidade: document.getElementById("criticidade").value,
            localizacao: "Não definida",
            observacoes: document.getElementById("observacoes").value.trim()
        };

        equipamentosGuardados[codigo] = novoEquipamento;

        localStorage.setItem("equipamentosGuardados", JSON.stringify(equipamentosGuardados));

        if (mensagemSucesso) {
            mensagemSucesso.style.display = "block";
            mensagemSucesso.textContent = "Equipamento adicionado com sucesso.";
            mensagemSucesso.classList.remove("erro");
            mensagemSucesso.classList.add("sucesso");
        }

        setTimeout(function () {
            window.location.href = "equipamentos.html";
        }, 800);
    });

    formularioNovoEquipamento.addEventListener("input", function () {
        if (mensagemSucesso) {
            mensagemSucesso.style.display = "none";
        }
    });

    formularioNovoEquipamento.addEventListener("change", function () {
        if (mensagemSucesso) {
            mensagemSucesso.style.display = "none";
        }
    });
});

// Preencher listagem de equipamentos na página equipamentos.html
function preencherListagemEquipamentos() {
    const tabelaEquipamentos = document.getElementById("tabela-equipamentos");

    // Se não estiver na página da listagem, para aqui
    if (!tabelaEquipamentos) {
        return;
    }

    tabelaEquipamentos.innerHTML = "";

    Object.values(equipamentosGuardados).forEach(function (equipamento) {
        const linha = document.createElement("tr");

        linha.innerHTML = `
    <td>${equipamento.codigo}</td>
    <td>${equipamento.designacao}</td>
    <td>${equipamento.categoria}</td>
    <td>${equipamento.marca}</td>
    <td>${equipamento.modelo}</td>
    <td>${equipamento.numeroSerie}</td>
    <td>${equipamento.fabricante}</td>
    <td>${equipamento.anoFabrico}</td>
    <td>${equipamento.dataAquisicao}</td>
    <td>${equipamento.custoAquisicao}</td>
    <td>${equipamento.tipoEntrada}</td>
    <td>${equipamento.estado}</td>
    <td>${equipamento.criticidade}</td>

    <td class="acoes-tabela-privada">
        <a href="consultar_equipamento.html?id=${equipamento.codigo}" class="acao-tabela">
            <i class="fa-regular fa-eye"></i>
            Consultar
        </a>

        <a href="editar_equipamento.html?id=${equipamento.codigo}" class="acao-tabela">
            <i class="fa-regular fa-pen-to-square"></i>
            Editar
        </a>

        <a href="#" class="acao-tabela-privada eliminar-equipamento" data-id="${equipamento.codigo}">
            <i class="fa-regular fa-trash-can"></i>
            Eliminar
        </a>
    </td>
`;

        tabelaEquipamentos.appendChild(linha);
    });
}

// Eliminar equipamento da listagem
document.addEventListener("click", function (event) {
    const botaoEliminar = event.target.closest(".eliminar-equipamento");

    if (!botaoEliminar) {
        return;
    }

    event.preventDefault();

    const idEquipamento = botaoEliminar.getAttribute("data-id");

    const confirmar = confirm("Tem a certeza que pretende eliminar este equipamento?");

    if (!confirmar) {
        return;
    }

    delete equipamentosGuardados[idEquipamento];

    localStorage.setItem("equipamentosGuardados", JSON.stringify(equipamentosGuardados));

    preencherListagemEquipamentos();
});

// Preenche automaticamente a página consultar_equipamento.html
function preencherDetalhesEquipamento() {
    const campoCodigo = document.getElementById("detalhe-codigo");

    // Se não estiver na página de consulta, para aqui
    if (!campoCodigo) {
        return;
    }

    const parametros = new URLSearchParams(window.location.search);
    const idEquipamento = parametros.get("id");

    const equipamento = equipamentosGuardados[idEquipamento];

    if (!equipamento) {
        campoCodigo.textContent = "Equipamento não encontrado";
        return;
    }

    document.getElementById("detalhe-codigo").textContent = equipamento.codigo;
    document.getElementById("detalhe-designacao").textContent = equipamento.designacao;
    document.getElementById("detalhe-categoria").textContent = equipamento.categoria;
    document.getElementById("detalhe-marca").textContent = equipamento.marca;
    document.getElementById("detalhe-modelo").textContent = equipamento.modelo;
    document.getElementById("detalhe-numero-serie").textContent = equipamento.numeroSerie;
    document.getElementById("detalhe-fabricante").textContent = equipamento.fabricante;
    document.getElementById("detalhe-ano-fabrico").textContent = equipamento.anoFabrico;
    document.getElementById("detalhe-data-aquisicao").textContent = equipamento.dataAquisicao;
    document.getElementById("detalhe-custo-aquisicao").textContent = equipamento.custoAquisicao;
    document.getElementById("detalhe-tipo-entrada").textContent = equipamento.tipoEntrada;
    document.getElementById("detalhe-estado").textContent = equipamento.estado;
    document.getElementById("detalhe-criticidade").textContent = equipamento.criticidade;
    document.getElementById("detalhe-localizacao").textContent = equipamento.localizacao;
    document.getElementById("detalhe-observacoes").textContent = equipamento.observacoes;

    const botaoEditarEquipamento = document.getElementById("botao-editar-equipamento");

    if (botaoEditarEquipamento) {
        botaoEditarEquipamento.href = `editar_equipamento.html?id=${equipamento.codigo}`;
    }
}

// Só executa quando a página terminar de carregar
document.addEventListener("DOMContentLoaded", function () {
    preencherListagemEquipamentos();
    preencherDetalhesEquipamento();
});

// Dropdown do utilizador na navbar privada
const botaoUtilizadorPrivado = document.querySelector(".utilizador-privado");
const menuUtilizadorPrivado = document.querySelector(".menu-utilizador-privado");

if (botaoUtilizadorPrivado && menuUtilizadorPrivado) {
    botaoUtilizadorPrivado.addEventListener("click", function (event) {
        event.stopPropagation();
        menuUtilizadorPrivado.classList.toggle("ativo");
    });

    document.addEventListener("click", function () {
        menuUtilizadorPrivado.classList.remove("ativo");
    });

    menuUtilizadorPrivado.addEventListener("click", function (event) {
        event.stopPropagation();
    });
}

// Preencher e guardar formulário da página editar_equipamento.html
document.addEventListener("DOMContentLoaded", function () {

    const formEditarEquipamento = document.getElementById("form-editar-equipamento");

    if (!formEditarEquipamento) {
        return;
    }

    const parametros = new URLSearchParams(window.location.search);
    const idEquipamento = parametros.get("id");

    const equipamento = equipamentosGuardados[idEquipamento];

    const mensagemEditarEquipamento = document.getElementById("mensagem-editar-equipamento");

    if (!equipamento) {
        if (mensagemEditarEquipamento) {
            mensagemEditarEquipamento.textContent = "Equipamento não encontrado.";
            mensagemEditarEquipamento.classList.add("erro");
        }
        return;
    }

    document.getElementById("codigo").value = equipamento.codigo;
    document.getElementById("designacao").value = equipamento.designacao;
    document.getElementById("categoria").value = equipamento.categoria;
    document.getElementById("marca").value = equipamento.marca;
    document.getElementById("modelo").value = equipamento.modelo;
    document.getElementById("numero_serie").value = equipamento.numeroSerie;
    document.getElementById("fabricante").value = equipamento.fabricante;
    document.getElementById("ano_fabrico").value = equipamento.anoFabrico;

    // Para o input type="date", o formato tem de ser aaaa-mm-dd
    document.getElementById("data_aquisicao").value = converterDataParaInput(equipamento.dataAquisicao);

    document.getElementById("custo_aquisicao").value = limparCusto(equipamento.custoAquisicao);
    document.getElementById("tipo_entrada").value = equipamento.tipoEntrada;
    document.getElementById("estado").value = equipamento.estado;
    document.getElementById("criticidade").value = equipamento.criticidade;
    document.getElementById("observacoes").value = equipamento.observacoes;

    const botaoCancelarEdicao = document.getElementById("botao-cancelar-edicao");

    if (botaoCancelarEdicao) {
        botaoCancelarEdicao.href = `consultar_equipamento.html?id=${equipamento.codigo}`;
    }

    formEditarEquipamento.addEventListener("submit", function (event) {
        event.preventDefault();

        equipamentosGuardados[idEquipamento].designacao = document.getElementById("designacao").value;
        equipamentosGuardados[idEquipamento].categoria = document.getElementById("categoria").value;
        equipamentosGuardados[idEquipamento].marca = document.getElementById("marca").value;
        equipamentosGuardados[idEquipamento].modelo = document.getElementById("modelo").value;
        equipamentosGuardados[idEquipamento].numeroSerie = document.getElementById("numero_serie").value;
        equipamentosGuardados[idEquipamento].fabricante = document.getElementById("fabricante").value;
        equipamentosGuardados[idEquipamento].anoFabrico = document.getElementById("ano_fabrico").value;
        equipamentosGuardados[idEquipamento].dataAquisicao = converterDataParaTexto(document.getElementById("data_aquisicao").value);
        equipamentosGuardados[idEquipamento].custoAquisicao = document.getElementById("custo_aquisicao").value + " €";
        equipamentosGuardados[idEquipamento].tipoEntrada = document.getElementById("tipo_entrada").value;
        equipamentosGuardados[idEquipamento].estado = document.getElementById("estado").value;
        equipamentosGuardados[idEquipamento].criticidade = document.getElementById("criticidade").value;
        equipamentosGuardados[idEquipamento].observacoes = document.getElementById("observacoes").value;

        localStorage.setItem("equipamentosGuardados", JSON.stringify(equipamentosGuardados));

        if (mensagemEditarEquipamento) {
            mensagemEditarEquipamento.textContent = "Alterações guardadas com sucesso.";
            mensagemEditarEquipamento.classList.remove("erro");
            mensagemEditarEquipamento.classList.add("sucesso");
        }

        setTimeout(function () {
            window.location.href = `consultar_equipamento.html?id=${idEquipamento}`;
        }, 800);
    });
});

// Converter data de dd/mm/aaaa para aaaa-mm-dd
function converterDataParaInput(dataTexto) {
    if (!dataTexto) {
        return "";
    }

    if (dataTexto.includes("-")) {
        return dataTexto;
    }

    const partes = dataTexto.split("/");

    if (partes.length !== 3) {
        return "";
    }

    return `${partes[2]}-${partes[1]}-${partes[0]}`;
}

// Converter data de aaaa-mm-dd para dd/mm/aaaa
function converterDataParaTexto(dataInput) {
    if (!dataInput) {
        return "";
    }

    const partes = dataInput.split("-");

    if (partes.length !== 3) {
        return dataInput;
    }

    return `${partes[2]}/${partes[1]}/${partes[0]}`;
}

// Remover símbolo € do custo para colocar no input
function limparCusto(custoTexto) {
    if (!custoTexto) {
        return "";
    }

    return custoTexto.replace("€", "").trim();
}