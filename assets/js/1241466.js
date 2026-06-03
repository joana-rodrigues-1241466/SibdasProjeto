// ===============================
// CONTACTOS
// ===============================

function inicializarContactos() {
    const formulario = document.querySelector(".form-contactos");

    if (!formulario) {
        return;
    }

    formulario.addEventListener("submit", function (event) {
        event.preventDefault();
        formulario.reset();
    });
}


// ===============================
// LOGIN
// ===============================

function inicializarLogin() {
    const formularioLogin = document.querySelector(".form-login");

    if (!formularioLogin) {
        return;
    }

    formularioLogin.addEventListener("submit", function (event) {
        event.preventDefault();

        setTimeout(function () {
            window.location.href = "views/gestao_conteudos/gestao_conteudos.html";
        }, 1000);
    });
}

// ===============================
// GESTÃO DE CONTEÚDOS DA ÁREA PÚBLICA
// ===============================

function inicializarGestaoConteudos() {
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
    const botaoRepor = document.getElementById("repor-conteudos");

    if (!formularioGestao) {
        return;
    }

    const conteudosOriginais = {
        homeTitulo: "Sistema de Inventário de Equipamentos Hospitalares",
        homeTexto: "Plataforma web para gestão e monitorização do inventário de equipamentos médicos em ambiente hospitalar.",
        homeBotao: "Entre em contacto connosco",

        sobreTitulo: "Sobre",
        sobreTexto1: "A MediVault é uma plataforma desenvolvida para apoiar a gestão do inventário hospitalar, permitindo organizar equipamentos médicos, controlar documentação, acompanhar garantias e melhorar a rastreabilidade dos recursos existentes.",
        sobreTexto2: "O sistema permite reunir, num único local, informação essencial sobre os equipamentos, incluindo categoria, localização, estado atual, fornecedor, documentação técnica, garantias e contactos associados.",
        sobreTexto3: "O objetivo da plataforma é substituir métodos dispersos, como folhas de cálculo, documentos isolados e registos manuais, por uma solução digital mais segura, acessível e eficiente para os utilizadores autorizados.",

        sobreCardTitulo: "Gestão centralizada",
        sobreCardTexto1: "Organização dos equipamentos médicos por categoria, estado, localização e criticidade.",
        sobreCardTexto2: "Acompanhamento de documentação técnica, contratos, garantias e fornecedores.",
        sobreCardTexto3: "Acesso reservado a utilizadores autorizados através de uma área privada.",
        sobreCardTexto4: "Apoio à rastreabilidade e à tomada de decisão em contexto hospitalar.",

        funcionalidadesTitulo: "Funcionalidades",
        funcionalidadesTexto: "A MediVault disponibiliza um conjunto de serviços e funcionalidades para gerir o inventário hospitalar com eficiência, segurança e total rastreabilidade.",

        funcionalidadeTitulo1: "Gestão de Equipamentos",
        funcionalidadeTexto1: "Registo, consulta, edição e remoção de equipamentos médicos existentes no inventário hospitalar.",

        funcionalidadeTitulo2: "Localizações",
        funcionalidadeTexto2: "Organização da localização física dos equipamentos por edifício, piso, serviço e sala.",

        funcionalidadeTitulo3: "Fornecedores",
        funcionalidadeTexto3: "Gestão de fornecedores associados aos equipamentos médicos e respetivos contactos.",

        funcionalidadeTitulo4: "Documentação",
        funcionalidadeTexto4: "Registo e controlo de documentação técnica, manuais, certificados e relatórios.",

        funcionalidadeTitulo5: "Garantias e Contratos",
        funcionalidadeTexto5: "Acompanhamento de garantias, contratos de manutenção e datas relevantes.",

        funcionalidadeTitulo6: "Dashboard",
        funcionalidadeTexto6: "Visualização resumida de indicadores relevantes para apoio à gestão.",

        funcionalidadeTitulo7: "Área Privada",
        funcionalidadeTexto7: "Acesso reservado a profissionais autorizados para gestão dos dados do sistema.",

        funcionalidadeTitulo8: "Gestão de Conteúdos",
        funcionalidadeTexto8: "Possibilidade de editar conteúdos da área pública através da área privada.",

        contactosTitulo: "Contactos",
        contactosTexto: "Entre em contacto connosco para esclarecer dúvidas sobre a MediVault ou obter mais informações sobre a gestão do inventário hospitalar.",

        localizacao: "Aveiro, Portugal",
        horario: "Segunda a sexta-feira, das 09h00 às 18h00",
        email: "medivault@hospital.pt",
        telefone: "+351 234 000 000"
    };

    let conteudosGuardados = JSON.parse(localStorage.getItem("conteudosPublicos"));

    if (!conteudosGuardados) {
        conteudosGuardados = conteudosOriginais;
        localStorage.setItem("conteudosPublicos", JSON.stringify(conteudosGuardados));
    }

    Object.keys(camposGestao).forEach(function (chave) {
        if (camposGestao[chave] && conteudosGuardados[chave]) {
            camposGestao[chave].value = conteudosGuardados[chave];
        }
    });

    formularioGestao.addEventListener("submit", function (event) {
        event.preventDefault();

        Object.keys(camposGestao).forEach(function (chave) {
            if (camposGestao[chave]) {
                conteudosGuardados[chave] = camposGestao[chave].value;
            }
        });

        localStorage.setItem("conteudosPublicos", JSON.stringify(conteudosGuardados));
    });

    if (botaoRepor) {
        botaoRepor.addEventListener("click", function () {
            const confirmar = confirm("Tem a certeza que pretende repor os conteúdos originais?");

            if (!confirmar) {
                return;
            }

            localStorage.setItem("conteudosPublicos", JSON.stringify(conteudosOriginais));

            Object.keys(camposGestao).forEach(function (chave) {
                if (camposGestao[chave]) {
                    camposGestao[chave].value = conteudosOriginais[chave];
                }
            });
        });
    }
}


// ===============================
// EQUIPAMENTOS
// ===============================

const equipamentosConsulta = {
    EQ001: {
        codigo: "EQ001",
        designacao: "Monitor multiparamétrico de sinais vitais",
        categoria: "Monitorização",
        marca: "Philips",
        modelo: "IntelliVue MX450",
        numeroSerie: "PH-MX450-2021-001",
        fornecedor: "FOR001",
        moradaFornecedorEquipamento: "Lisboa, Portugal",
        pessoaContactoFornecedor: "Ana Martins",
        telefonePessoaContactoFornecedor: "+351 910 000 000",
        tipoFornecedorEquipamento: "Fabricante",
        observacoesFornecedorEquipamento: "Fornecedor associado a equipamentos de monitorização.",
        fabricante: "Philips Healthcare",
        anoFabrico: "2021",
        dataAquisicao: "12/03/2022",
        custoAquisicao: "8500 €",
        tipoEntrada: "Compra",
        estado: "Ativo",
        criticidade: "Alta",
        localizacao: "LOC001",
        observacoes: "Equipamento utilizado para monitorização contínua de sinais vitais em doentes críticos.",
        documentacaoAssociada: ["DOC001"],
        dataInicioGarantia: "12/03/2022",
        dataFimGarantia: "12/03/2025",
        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "Philips Healthcare",
        periodicidadeContrato: "Anual",
        observacoesContrato: "Garantia ativa e contrato de manutenção preventiva associado."
    },

    EQ002: {
        codigo: "EQ002",
        designacao: "Ventilador pulmonar",
        categoria: "Suporte de Vida",
        marca: "Dräger",
        modelo: "Evita V600",
        numeroSerie: "DR-EV600-2020-014",
        fornecedor: "FOR002",
        moradaFornecedorEquipamento: "Porto, Portugal",
        pessoaContactoFornecedor: "Miguel Santos",
        telefonePessoaContactoFornecedor: "+351 920 000 000",
        tipoFornecedorEquipamento: "Fabricante",
        observacoesFornecedorEquipamento: "Fabricante associado a equipamentos de suporte ventilatório.",
        fabricante: "Dräger Medical",
        anoFabrico: "2020",
        dataAquisicao: "08/09/2021",
        custoAquisicao: "23500 €",
        tipoEntrada: "Compra",
        estado: "Em manutenção",
        criticidade: "Suporte de vida",
        localizacao: "LOC002",
        observacoes: "Equipamento em manutenção preventiva programada.",
        documentacaoAssociada: ["DOC002"],
        dataInicioGarantia: "08/09/2021",
        dataFimGarantia: "08/09/2024",
        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva e corretiva",
        entidadeResponsavelContrato: "TecnoMed Assistência",
        periodicidadeContrato: "Semestral",
        observacoesContrato: "Contrato de manutenção associado ao ventilador pulmonar."
    },

    EQ003: {
        codigo: "EQ003",
        designacao: "Bomba de infusão",
        categoria: "Terapia",
        marca: "B. Braun",
        modelo: "Infusomat Space",
        numeroSerie: "BB-INF-2019-033",
        fornecedor: "FOR003",
        moradaFornecedorEquipamento: "Aveiro, Portugal",
        pessoaContactoFornecedor: "Carla Ferreira",
        telefonePessoaContactoFornecedor: "+351 930 000 000",
        tipoFornecedorEquipamento: "Distribuidor ou Fornecedor comercial",
        observacoesFornecedorEquipamento: "Distribuidor comercial de equipamentos e consumíveis.",
        fabricante: "B. Braun Medical",
        anoFabrico: "2019",
        dataAquisicao: "21/01/2020",
        custoAquisicao: "3200 €",
        tipoEntrada: "Compra",
        estado: "Em calibração",
        criticidade: "Média",
        localizacao: "LOC003",
        observacoes: "Utilizada para administração controlada de terapêutica intravenosa.",
        documentacaoAssociada: ["DOC003"],
        dataInicioGarantia: "21/01/2020",
        dataFimGarantia: "21/01/2023",
        contratoManutencao: "Não",
        tipoContrato: "Não existe",
        entidadeResponsavelContrato: "Não existe",
        periodicidadeContrato: "Não aplicável",
        observacoesContrato: "Sem contrato de manutenção associado."
    },

    EQ004: {
        codigo: "EQ004",
        designacao: "Desfibrilhador",
        categoria: "Suporte de Vida",
        marca: "Zoll",
        modelo: "R Series",
        numeroSerie: "ZL-RS-2022-007",
        fornecedor: "FOR004",
        moradaFornecedorEquipamento: "Coimbra, Portugal",
        pessoaContactoFornecedor: "João Almeida",
        telefonePessoaContactoFornecedor: "+351 940 000 000",
        tipoFornecedorEquipamento: "Empresa de assistência técnica",
        observacoesFornecedorEquipamento: "Empresa responsável por manutenção preventiva e corretiva.",
        fabricante: "Zoll Medical",
        anoFabrico: "2022",
        dataAquisicao: "15/06/2022",
        custoAquisicao: "12400 €",
        tipoEntrada: "Compra",
        estado: "Ativo",
        criticidade: "Baixa",
        localizacao: "LOC004",
        observacoes: "Equipamento essencial para resposta rápida em situações de paragem cardiorrespiratória.",
        documentacaoAssociada: ["DOC004"],
        dataInicioGarantia: "15/06/2022",
        dataFimGarantia: "15/06/2025",
        contratoManutencao: "Sim",
        tipoContrato: "Manutenção corretiva",
        entidadeResponsavelContrato: "Zoll Medical",
        periodicidadeContrato: "Anual",
        observacoesContrato: "Garantia comercial associada ao equipamento."
    }
};

let equipamentosGuardados = JSON.parse(localStorage.getItem("equipamentosGuardados"));

if (!equipamentosGuardados) {
    equipamentosGuardados = equipamentosConsulta;
    localStorage.setItem("equipamentosGuardados", JSON.stringify(equipamentosGuardados));
}

function preencherListagemEquipamentos(listaEquipamentos = Object.values(equipamentosGuardados)) {
    const tabelaEquipamentos = document.getElementById("tabela-equipamentos");

    if (!tabelaEquipamentos) {
        return;
    }

    ordenarEquipamentosPorCodigoCrescente(listaEquipamentos);

    tabelaEquipamentos.innerHTML = "";

    if (listaEquipamentos.length === 0) {
        tabelaEquipamentos.innerHTML = `
        <tr>
            <td colspan="7" class="text-center">Nenhum equipamento encontrado.</td>
        </tr>
    `;
        return;
    }

    listaEquipamentos.forEach(function (equipamento) {
        const linha = document.createElement("tr");

        const pessoaContactoFornecedor = equipamento.pessoaContactoFornecedor || "-";

        const telefonePessoaContactoFornecedor = equipamento.telefonePessoaContactoFornecedor || "-";

        const classesCriticidade = {
            "Suporte de vida": "badge-criticidade-suporte",
            "Alta": "badge-criticidade-alta",
            "Média": "badge-criticidade-media",
            "Baixa": "badge-criticidade-baixa"
        };

        const classeCriticidade = classesCriticidade[equipamento.criticidade];

        const criticidadeHTML = classeCriticidade
            ? `<span class="badge-detalhe ${classeCriticidade}">${equipamento.criticidade}</span>`
            : (equipamento.criticidade || "-");

        linha.innerHTML = `
    <td>${equipamento.designacao || "-"}</td>
    <td>${equipamento.marca || "-"}</td>
    <td>${pessoaContactoFornecedor}</td>
    <td>${telefonePessoaContactoFornecedor}</td>
    <td>${equipamento.estado || "-"}</td>
    <td>${criticidadeHTML}</td>

    <td class="acoes-tabela-privada">
        <a href="consultar_equipamento.html?id=${equipamento.codigo}" class="acao-tabela-privada">
            <i class="fa-regular fa-eye"></i>
            Consultar
        </a>

        <a href="editar_equipamento.html?id=${equipamento.codigo}" class="acao-tabela-privada">
            <i class="fa-regular fa-pen-to-square"></i>
            Editar
        </a>

        <button
    class="acao-tabela-privada botao-acao-tabela"
    data-bs-toggle="modal"
    data-bs-target="#modalEliminarEquipamento"
    onclick="prepararEliminacaoEquipamento('${equipamento.codigo}')">

    <i class="fa-regular fa-trash-can"></i>
    Eliminar
</button>
    </td>
`;

        tabelaEquipamentos.appendChild(linha);
    });
}

function ordenarEquipamentosPorCodigoCrescente(listaEquipamentos) {
    listaEquipamentos.sort(function (a, b) {
        return (a.codigo || "").localeCompare(b.codigo || "");
    });
}

function inicializarFiltrosEquipamentos() {
    const pesquisaEquipamentos = document.getElementById("pesquisaEquipamentos");
    const filtroEstado = document.getElementById("filtroEstadoEquipamento");
    const filtroFornecedor = document.getElementById("filtroFornecedorEquipamento");
    const filtroLocalizacao = document.getElementById("filtroLocalizacaoEquipamento");
    const filtroCategoria = document.getElementById("filtroCategoriaEquipamento");
    const filtroCriticidade = document.getElementById("filtroCriticidadeEquipamento");
    const botaoLimparApenasPesquisa = document.getElementById("botaoLimparApenasPesquisaEquipamentos");
    const botaoLimparApenasFiltros = document.getElementById("botaoLimparApenasFiltrosEquipamentos");
    const botaoPesquisar = document.getElementById("botaoPesquisarEquipamentos");

    if (!pesquisaEquipamentos || !filtroEstado || !filtroFornecedor || !filtroLocalizacao || !filtroCategoria || !filtroCriticidade) {
        return;
    }

    preencherSelectFiltrosEquipamentos();

    function aplicarFiltrosEquipamentos() {
        const textoPesquisa = pesquisaEquipamentos.value.toLowerCase().trim();
        const estadoSelecionado = filtroEstado.value;
        const fornecedorSelecionado = filtroFornecedor.value;
        const localizacaoSelecionada = filtroLocalizacao.value;
        const categoriaSelecionada = filtroCategoria.value;
        const criticidadeSelecionada = filtroCriticidade.value;

        const equipamentosFiltrados = Object.values(equipamentosGuardados).filter(function (equipamento) {
            const fornecedorAssociado = fornecedoresGuardados[equipamento.fornecedor];
            const localizacaoAssociada = localizacoesGuardadas[equipamento.localizacao];

            const textoFornecedor = fornecedorAssociado
                ? [
                    fornecedorAssociado.codigo,
                    fornecedorAssociado.nomeEmpresa,
                    fornecedorAssociado.nif,
                    fornecedorAssociado.telefone,
                    fornecedorAssociado.email,
                    fornecedorAssociado.morada,
                    fornecedorAssociado.website,
                    fornecedorAssociado.pessoaContacto,
                    fornecedorAssociado.telefonePessoaContacto,
                    fornecedorAssociado.tipoFornecedor,
                    fornecedorAssociado.observacoes
                ].join(" ").toLowerCase()
                : "";

            const textoLocalizacao = localizacaoAssociada
                ? [
                    localizacaoAssociada.codigo,
                    localizacaoAssociada.edificio,
                    localizacaoAssociada.piso,
                    localizacaoAssociada.servico,
                    localizacaoAssociada.sala,
                    localizacaoAssociada.observacoes
                ].join(" ").toLowerCase()
                : "";

            const correspondePesquisa =
                (equipamento.codigo || "").toLowerCase().includes(textoPesquisa) ||
                (equipamento.designacao || "").toLowerCase().includes(textoPesquisa) ||
                (equipamento.categoria || "").toLowerCase().includes(textoPesquisa) ||
                (equipamento.marca || "").toLowerCase().includes(textoPesquisa) ||
                (equipamento.modelo || "").toLowerCase().includes(textoPesquisa) ||
                (equipamento.numeroSerie || "").toLowerCase().includes(textoPesquisa) ||
                (equipamento.fabricante || "").toLowerCase().includes(textoPesquisa) ||
                (equipamento.anoFabrico || "").toLowerCase().includes(textoPesquisa) ||
                (equipamento.dataAquisicao || "").toLowerCase().includes(textoPesquisa) ||
                (equipamento.custoAquisicao || "").toLowerCase().includes(textoPesquisa) ||
                (equipamento.tipoEntrada || "").toLowerCase().includes(textoPesquisa) ||
                (equipamento.estado || "").toLowerCase().includes(textoPesquisa) ||
                (equipamento.criticidade || "").toLowerCase().includes(textoPesquisa) ||
                (equipamento.observacoes || "").toLowerCase().includes(textoPesquisa) ||
                textoFornecedor.includes(textoPesquisa) ||
                textoLocalizacao.includes(textoPesquisa);

            const correspondeEstado =
                estadoSelecionado === "" || equipamento.estado === estadoSelecionado;

            const correspondeFornecedor =
                fornecedorSelecionado === "" || equipamento.fornecedor === fornecedorSelecionado;

            const correspondeLocalizacao =
                localizacaoSelecionada === "" || equipamento.localizacao === localizacaoSelecionada;

            const correspondeCategoria =
                categoriaSelecionada === "" || equipamento.categoria === categoriaSelecionada;

            const correspondeCriticidade =
                criticidadeSelecionada === "" || equipamento.criticidade === criticidadeSelecionada;

            return correspondePesquisa &&
                correspondeEstado &&
                correspondeFornecedor &&
                correspondeLocalizacao &&
                correspondeCategoria &&
                correspondeCriticidade;
        });

        ordenarEquipamentosPorCodigoCrescente(equipamentosFiltrados);
        preencherListagemEquipamentos(equipamentosFiltrados);
    }

    pesquisaEquipamentos.addEventListener("input", aplicarFiltrosEquipamentos);
    filtroEstado.addEventListener("change", aplicarFiltrosEquipamentos);
    filtroFornecedor.addEventListener("change", aplicarFiltrosEquipamentos);
    filtroLocalizacao.addEventListener("change", aplicarFiltrosEquipamentos);
    filtroCategoria.addEventListener("change", aplicarFiltrosEquipamentos);
    filtroCriticidade.addEventListener("change", aplicarFiltrosEquipamentos);

    if (botaoPesquisar) {
        botaoPesquisar.addEventListener("click", aplicarFiltrosEquipamentos);
    }

    if (botaoLimparApenasPesquisa) {
        botaoLimparApenasPesquisa.addEventListener("click", function () {
            pesquisaEquipamentos.value = "";

            aplicarFiltrosEquipamentos();
        });
    }

    if (botaoLimparApenasFiltros) {
        botaoLimparApenasFiltros.addEventListener("click", function () {
            filtroEstado.value = "";
            filtroFornecedor.value = "";
            filtroLocalizacao.value = "";
            filtroCategoria.value = "";
            filtroCriticidade.value = "";

            aplicarFiltrosEquipamentos();
        });
    }
}

function preencherSelectFiltrosEquipamentos() {
    const filtroFornecedor = document.getElementById("filtroFornecedorEquipamento");
    const filtroLocalizacao = document.getElementById("filtroLocalizacaoEquipamento");
    const filtroCategoria = document.getElementById("filtroCategoriaEquipamento");

    if (!filtroFornecedor || !filtroLocalizacao || !filtroCategoria) {
        return;
    }

    filtroFornecedor.innerHTML = '<option value="">Todos</option>';
    filtroLocalizacao.innerHTML = '<option value="">Todas</option>';
    filtroCategoria.innerHTML = '<option value="">Todas</option>';

    const fornecedores = [...new Set(
        Object.values(equipamentosGuardados)
            .map(function (equipamento) {
                return equipamento.fornecedor;
            })
            .filter(function (fornecedor) {
                return fornecedor;
            })
    )];

    const localizacoes = [...new Set(
        Object.values(equipamentosGuardados)
            .map(function (equipamento) {
                return equipamento.localizacao;
            })
            .filter(function (localizacao) {
                return localizacao;
            })
    )];

    const categorias = [
        "Monitorização",
        "Suporte de vida",
        "Terapia",
        "Diagnóstico",
        "Imagiologia",
        "Laboratório",
        "Cirurgia",
        "Reabilitação"
    ];

    fornecedores.forEach(function (fornecedor) {
        const option = document.createElement("option");
        option.value = fornecedor;
        option.textContent = fornecedor;
        filtroFornecedor.appendChild(option);
    });

    localizacoes.forEach(function (localizacao) {
        const option = document.createElement("option");
        option.value = localizacao;
        option.textContent = localizacao;
        filtroLocalizacao.appendChild(option);
    });

    categorias.forEach(function (categoria) {
        const option = document.createElement("option");
        option.value = categoria;
        option.textContent = categoria;
        filtroCategoria.appendChild(option);
    });
}

function inicializarNovoEquipamento() {
    const formularioNovoEquipamento = document.getElementById("form-novo-equipamento");

    if (!formularioNovoEquipamento) {
        return;
    }

    preencherSelectFornecedores("fornecedor");
    preencherSelectLocalizacoes("localizacao");
    preencherSelectDocumentacao("documentacaoAssociada");
    preencherDadosFornecedorAssociado();
    preencherDadosLocalizacaoAssociada();
    preencherDadosDocumentacaoAssociada();

    formularioNovoEquipamento.addEventListener("submit", function (event) {
        event.preventDefault();

        const codigo = document.getElementById("codigo").value.trim();

        const novoEquipamento = {
            codigo: codigo,
            designacao: document.getElementById("designacao").value.trim(),
            categoria: document.getElementById("categoria").value.trim(),
            marca: document.getElementById("marca").value.trim(),
            modelo: document.getElementById("modelo").value.trim(),
            numeroSerie: document.getElementById("numero_serie").value.trim(),
            fabricante: document.getElementById("fabricante").value.trim(),
            anoFabrico: document.getElementById("ano_fabrico").value.trim(),
            dataAquisicao: converterDataParaTexto(document.getElementById("data_aquisicao").value),
            custoAquisicao: document.getElementById("custo_aquisicao").value.trim() + " €",
            tipoEntrada: document.getElementById("tipo_entrada").value.trim(),
            estado: document.getElementById("estado").value.trim(),
            criticidade: document.getElementById("criticidade").value.trim(),
            observacoes: document.getElementById("observacoes").value.trim(),

            fornecedor: document.getElementById("fornecedor").value,
            moradaFornecedorEquipamento: document.getElementById("moradaFornecedorEquipamento").value.trim(),
            pessoaContactoFornecedor: document.getElementById("pessoaContactoFornecedor").value.trim(),
            telefonePessoaContactoFornecedor: document.getElementById("telefonePessoaContactoFornecedor").value.trim(),
            tipoFornecedorEquipamento: document.getElementById("tipoFornecedorEquipamento").value,
            observacoesFornecedorEquipamento: document.getElementById("observacoesFornecedorEquipamento").value.trim(),

            localizacao: document.getElementById("localizacao") ? document.getElementById("localizacao").value.trim() : "",
            observacoesLocalizacao: document.getElementById("observacoesLocalizacao")?.value || "",

            documentacaoAssociada: Array.from(document.getElementById("documentacaoAssociada").selectedOptions).map(function (option) {
                return option.value;
            }),

            dataInicioGarantia: converterDataParaTexto(document.getElementById("dataInicioGarantia").value),
            dataFimGarantia: converterDataParaTexto(document.getElementById("dataFimGarantia").value),
            contratoManutencao: document.getElementById("contratoManutencao").value,
            tipoContrato: document.getElementById("contratoManutencao").value === "Não" ? "Não existe" : document.getElementById("tipoContrato").value.trim(),
            entidadeResponsavelContrato: document.getElementById("contratoManutencao").value === "Não" ? "Não existe" : document.getElementById("entidadeResponsavelContrato").value.trim(),
            periodicidadeContrato: document.getElementById("contratoManutencao").value === "Não" ? "Não aplicável" : document.getElementById("periodicidadeContrato").value,
            observacoesContrato: document.getElementById("observacoesContrato").value.trim()
        };

        equipamentosGuardados[codigo] = novoEquipamento;

        localStorage.setItem("equipamentosGuardados", JSON.stringify(equipamentosGuardados));

        setTimeout(function () {
            window.location.href = "equipamentos.html";
        }, 800);
    });
}


function preencherDetalhesEquipamento() {
    const campoCodigo = document.getElementById("detalhe-codigo");

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
    const campoCriticidade = document.getElementById("detalhe-criticidade");

    if (campoCriticidade) {
        const classesCriticidade = {
            "Suporte de vida": "badge-criticidade-suporte",
            "Alta": "badge-criticidade-alta",
            "Média": "badge-criticidade-media",
            "Baixa": "badge-criticidade-baixa"
        };

        const classeCriticidade = classesCriticidade[equipamento.criticidade];

        if (classeCriticidade) {
            campoCriticidade.innerHTML = `
            <span class="badge-detalhe ${classeCriticidade}">
                ${equipamento.criticidade}
            </span>
        `;
        } else {
            campoCriticidade.textContent = equipamento.criticidade || "Não definida";
        }
    }

    const fornecedorAssociado = fornecedoresGuardados[equipamento.fornecedor];

    const campoFornecedorCodigo = document.getElementById("detalhe-fornecedor-codigo");
    const campoFornecedorNome = document.getElementById("detalhe-fornecedor-nome");
    const campoFornecedorNif = document.getElementById("detalhe-fornecedor-nif");
    const campoFornecedorEmail = document.getElementById("detalhe-fornecedor-email");
    const campoFornecedorTelefone = document.getElementById("detalhe-fornecedor-telefone");
    const campoFornecedorMorada = document.getElementById("detalhe-fornecedor-morada");
    const campoFornecedorWebsite = document.getElementById("detalhe-fornecedor-website");
    const campoFornecedorPessoaContacto = document.getElementById("detalhe-fornecedor-pessoa-contacto");
    const campoFornecedorTelefonePessoaContacto = document.getElementById("detalhe-fornecedor-telefone-pessoa-contacto");
    const campoFornecedorTipo = document.getElementById("detalhe-fornecedor-tipo");
    const campoFornecedorObservacoes = document.getElementById("detalhe-fornecedor-observacoes");

    if (campoFornecedorCodigo) {
        if (fornecedorAssociado) {
            campoFornecedorCodigo.textContent = fornecedorAssociado.codigo || "Não definido";

            if (campoFornecedorNome) campoFornecedorNome.textContent = fornecedorAssociado.nomeEmpresa || "Não definido";
            if (campoFornecedorNif) campoFornecedorNif.textContent = fornecedorAssociado.nif || "Não definido";
            if (campoFornecedorEmail) campoFornecedorEmail.textContent = fornecedorAssociado.email || "Não definido";
            if (campoFornecedorTelefone) campoFornecedorTelefone.textContent = fornecedorAssociado.telefone || "Não definido";
            if (campoFornecedorWebsite) campoFornecedorWebsite.textContent = fornecedorAssociado.website || "Não definido";

            if (campoFornecedorMorada) {
                campoFornecedorMorada.textContent = equipamento.moradaFornecedorEquipamento || "Não definido";
            }

            if (campoFornecedorPessoaContacto) {
                campoFornecedorPessoaContacto.textContent = equipamento.pessoaContactoFornecedor || "Não definido";
            }

            if (campoFornecedorTelefonePessoaContacto) {
                campoFornecedorTelefonePessoaContacto.textContent = equipamento.telefonePessoaContactoFornecedor || "Não definido";
            }

            if (campoFornecedorTipo) {
                campoFornecedorTipo.textContent = equipamento.tipoFornecedorEquipamento || "Não definido";
            }

            if (campoFornecedorObservacoes) {
                campoFornecedorObservacoes.textContent = equipamento.observacoesFornecedorEquipamento || "Sem observações";
            }
        } else {
            campoFornecedorCodigo.textContent = equipamento.fornecedor || "Sem fornecedor associado";

            if (campoFornecedorNome) campoFornecedorNome.textContent = "Não definido";
            if (campoFornecedorNif) campoFornecedorNif.textContent = "Não definido";
            if (campoFornecedorEmail) campoFornecedorEmail.textContent = "Não definido";
            if (campoFornecedorTelefone) campoFornecedorTelefone.textContent = "Não definido";
            if (campoFornecedorMorada) campoFornecedorMorada.textContent = "Não definido";
            if (campoFornecedorWebsite) campoFornecedorWebsite.textContent = "Não definido";
            if (campoFornecedorPessoaContacto) campoFornecedorPessoaContacto.textContent = "Não definido";
            if (campoFornecedorTelefonePessoaContacto) campoFornecedorTelefonePessoaContacto.textContent = "Não definido";
            if (campoFornecedorTipo) campoFornecedorTipo.textContent = "Não definido";
            if (campoFornecedorObservacoes) campoFornecedorObservacoes.textContent = "Sem observações";
        }
    }

    const localizacaoAssociada = localizacoesGuardadas[equipamento.localizacao];
    const campoLocalizacaoCodigo = document.getElementById("detalhe-localizacao-codigo");
    const campoLocalizacaoServico = document.getElementById("detalhe-localizacao-servico");
    const campoLocalizacaoPiso = document.getElementById("detalhe-localizacao-piso");
    const campoLocalizacaoSala = document.getElementById("detalhe-localizacao-sala");
    const campoLocalizacaoEdificio = document.getElementById("detalhe-localizacao-edificio");
    const campoLocalizacaoObservacoes = document.getElementById("detalhe-localizacao-observacoes");

    if (campoLocalizacaoCodigo) {

        if (localizacaoAssociada) {

            campoLocalizacaoCodigo.textContent =
                localizacaoAssociada.codigo || "Não definido";

            campoLocalizacaoServico.textContent =
                localizacaoAssociada.servico || "Não definido";

            campoLocalizacaoPiso.textContent =
                localizacaoAssociada.piso || "Não definido";

            campoLocalizacaoSala.textContent =
                localizacaoAssociada.sala || "Não definido";

            campoLocalizacaoEdificio.textContent =
                localizacaoAssociada.edificio || "Não definido";

            campoLocalizacaoObservacoes.textContent =
                equipamento.observacoesLocalizacao ||
                localizacaoAssociada.observacoes ||
                "Sem observações";

        } else {

            campoLocalizacaoCodigo.textContent =
                equipamento.localizacao || "Sem localização associada";

            campoLocalizacaoServico.textContent = "Não definido";
            campoLocalizacaoPiso.textContent = "Não definido";
            campoLocalizacaoSala.textContent = "Não definido";
            campoLocalizacaoEdificio.textContent = "Não definido";

            campoLocalizacaoObservacoes.textContent =
                equipamento.observacoesLocalizacao || "Sem observações";
        }
    }

    const documentacoesAssociadas =
        (equipamento.documentacaoAssociada || []).map(function (codigo) {
            return documentacaoGuardada[codigo];
        }).filter(function (documentacao) {
            return documentacao;
        });

    const containerDocumentacao =
        document.getElementById("detalhes-documentacao-associada");

    if (containerDocumentacao) {

        if (documentacoesAssociadas.length === 0) {

            containerDocumentacao.innerHTML = `
            <div class="campo-detalhes">
                <p>Sem documentação associada.</p>
            </div>
        `;

        } else {

            containerDocumentacao.innerHTML = "";

            documentacoesAssociadas.forEach(function (documentacao) {

                containerDocumentacao.innerHTML += `

                <div class="campo-detalhes">

                    <div class="grelha-detalhes-equipamento">

                        <div>
                            <h3>Código da documentação</h3>
                            <p>${documentacao.codigo || "Não definido"}</p>
                        </div>

                        <div>
                            <h3>Tipo de documentação</h3>
                            <p>${documentacao.tipoDocumentacao || "Não definido"}</p>
                        </div>

                        <div>
                            <h3>Nome da documentação</h3>
                            <p>${documentacao.nomeDocumentacao || "Não definido"}</p>
                        </div>

                        <div>
                            <h3>Data da documentação</h3>
                            <p>${documentacao.dataDocumentacao || "Não definido"}</p>
                        </div>

                        <div>
                            <h3>Data de validade</h3>
                            <p>${documentacao.dataValidade || "Sem data de validade"}</p>
                        </div>

                        <div>
                            <h3>Ficheiro / localização</h3>
                            <p>${documentacao.ficheiro || "Não definido"}</p>
                        </div>

                        <div class="campo-detalhes-largo">
                            <h3>Observações da documentação</h3>
                            <p>${documentacao.observacoes || "Sem observações"}</p>
                        </div>

                    </div>

                </div>
            `;
            });
        }
    }

    document.getElementById("detalhe-data-inicio-garantia").textContent =
        equipamento.dataInicioGarantia || "Não definida";

    document.getElementById("detalhe-data-fim-garantia").textContent =
        equipamento.dataFimGarantia || "Não definida";

    document.getElementById("detalhe-contrato-manutencao").textContent =
        equipamento.contratoManutencao || "Não definido";

    document.getElementById("detalhe-tipo-contrato").textContent =
        equipamento.tipoContrato || "Não definido";

    document.getElementById("detalhe-entidade-responsavel-contrato").textContent =
        equipamento.entidadeResponsavelContrato || "Não definido";

    document.getElementById("detalhe-periodicidade-contrato").textContent =
        equipamento.periodicidadeContrato || "Não definida";

    document.getElementById("detalhe-observacoes-contrato").textContent =
        equipamento.observacoesContrato || "Sem observações";
}

function inicializarEditarEquipamento() {
    const formEditarEquipamento = document.getElementById("form-editar-equipamento");

    if (!formEditarEquipamento) {
        return;
    }

    const parametros = new URLSearchParams(window.location.search);
    const idEquipamento = parametros.get("id");

    const equipamento = equipamentosGuardados[idEquipamento];

    if (!equipamento) {
        return;
    }

    preencherSelectFornecedores("fornecedor", equipamento.fornecedor);
    preencherSelectLocalizacoes("localizacao", equipamento.localizacao);

    preencherDadosFornecedorAssociado();

    preencherDadosLocalizacaoAssociada();
    preencherSelectDocumentacao(
        "documentacaoAssociada",
        equipamento.documentacaoAssociada || []
    );

    preencherDadosDocumentacaoAssociada();

    if (document.getElementById("observacoesLocalizacao")) {
        document.getElementById("observacoesLocalizacao").value = equipamento.observacoesLocalizacao || "";
    }

    document.getElementById("moradaFornecedorEquipamento").value = equipamento.moradaFornecedorEquipamento || "";
    document.getElementById("pessoaContactoFornecedor").value = equipamento.pessoaContactoFornecedor || "";
    document.getElementById("telefonePessoaContactoFornecedor").value = equipamento.telefonePessoaContactoFornecedor || "";
    document.getElementById("tipoFornecedorEquipamento").value = equipamento.tipoFornecedorEquipamento || "";
    document.getElementById("observacoesFornecedorEquipamento").value = equipamento.observacoesFornecedorEquipamento || "";

    document.getElementById("codigo").value = equipamento.codigo;
    document.getElementById("designacao").value = equipamento.designacao;
    document.getElementById("categoria").value = equipamento.categoria;
    document.getElementById("marca").value = equipamento.marca;
    document.getElementById("modelo").value = equipamento.modelo;
    document.getElementById("numero_serie").value = equipamento.numeroSerie;
    document.getElementById("fabricante").value = equipamento.fabricante;
    document.getElementById("ano_fabrico").value = equipamento.anoFabrico;
    document.getElementById("data_aquisicao").value = converterDataParaInput(equipamento.dataAquisicao);
    document.getElementById("custo_aquisicao").value = limparCusto(equipamento.custoAquisicao);
    document.getElementById("tipo_entrada").value = equipamento.tipoEntrada;
    document.getElementById("estado").value = equipamento.estado;
    document.getElementById("criticidade").value = equipamento.criticidade;
    document.getElementById("observacoes").value = equipamento.observacoes;

    document.getElementById("dataInicioGarantia").value = converterDataParaInput(equipamento.dataInicioGarantia);
    document.getElementById("dataFimGarantia").value = converterDataParaInput(equipamento.dataFimGarantia);
    document.getElementById("contratoManutencao").value = equipamento.contratoManutencao || "";
    document.getElementById("tipoContrato").value = equipamento.tipoContrato || "";
    document.getElementById("entidadeResponsavelContrato").value = equipamento.entidadeResponsavelContrato || "";
    document.getElementById("periodicidadeContrato").value = equipamento.periodicidadeContrato || "Não aplicável";
    document.getElementById("observacoesContrato").value = equipamento.observacoesContrato || "";

    formEditarEquipamento.addEventListener("submit", function (event) {
        event.preventDefault();

        equipamentosGuardados[idEquipamento].designacao = document.getElementById("designacao").value.trim();
        equipamentosGuardados[idEquipamento].categoria = document.getElementById("categoria").value.trim();
        equipamentosGuardados[idEquipamento].marca = document.getElementById("marca").value.trim();
        equipamentosGuardados[idEquipamento].modelo = document.getElementById("modelo").value.trim();
        equipamentosGuardados[idEquipamento].numeroSerie = document.getElementById("numero_serie").value.trim();
        equipamentosGuardados[idEquipamento].fornecedor = document.getElementById("fornecedor").value;
        equipamentosGuardados[idEquipamento].moradaFornecedorEquipamento = document.getElementById("moradaFornecedorEquipamento").value.trim();
        equipamentosGuardados[idEquipamento].pessoaContactoFornecedor = document.getElementById("pessoaContactoFornecedor").value.trim();
        equipamentosGuardados[idEquipamento].telefonePessoaContactoFornecedor = document.getElementById("telefonePessoaContactoFornecedor").value.trim();
        equipamentosGuardados[idEquipamento].tipoFornecedorEquipamento = document.getElementById("tipoFornecedorEquipamento").value;
        equipamentosGuardados[idEquipamento].observacoesFornecedorEquipamento = document.getElementById("observacoesFornecedorEquipamento").value.trim();
        equipamentosGuardados[idEquipamento].fabricante = document.getElementById("fabricante").value.trim();
        equipamentosGuardados[idEquipamento].anoFabrico = document.getElementById("ano_fabrico").value.trim();
        equipamentosGuardados[idEquipamento].dataAquisicao = converterDataParaTexto(document.getElementById("data_aquisicao").value);
        equipamentosGuardados[idEquipamento].custoAquisicao = document.getElementById("custo_aquisicao").value.trim() + " €";
        equipamentosGuardados[idEquipamento].tipoEntrada = document.getElementById("tipo_entrada").value.trim();
        equipamentosGuardados[idEquipamento].estado = document.getElementById("estado").value.trim();
        equipamentosGuardados[idEquipamento].criticidade = document.getElementById("criticidade").value.trim();

        if (document.getElementById("localizacao")) {
            equipamentosGuardados[idEquipamento].localizacao = document.getElementById("localizacao").value.trim();
        }

        if (document.getElementById("observacoesLocalizacao")) {
            equipamentosGuardados[idEquipamento].observacoesLocalizacao =
                document.getElementById("observacoesLocalizacao").value.trim();
        }

        equipamentosGuardados[idEquipamento].observacoes = document.getElementById("observacoes").value.trim();

        equipamentosGuardados[idEquipamento].dataInicioGarantia = converterDataParaTexto(document.getElementById("dataInicioGarantia").value);
        equipamentosGuardados[idEquipamento].dataFimGarantia = converterDataParaTexto(document.getElementById("dataFimGarantia").value);
        equipamentosGuardados[idEquipamento].contratoManutencao = document.getElementById("contratoManutencao").value;
        equipamentosGuardados[idEquipamento].tipoContrato = document.getElementById("contratoManutencao").value === "Não" ? "Não existe" : document.getElementById("tipoContrato").value.trim();
        equipamentosGuardados[idEquipamento].entidadeResponsavelContrato = document.getElementById("contratoManutencao").value === "Não" ? "Não existe" : document.getElementById("entidadeResponsavelContrato").value.trim();
        equipamentosGuardados[idEquipamento].periodicidadeContrato = document.getElementById("contratoManutencao").value === "Não" ? "Não aplicável" : document.getElementById("periodicidadeContrato").value;
        equipamentosGuardados[idEquipamento].observacoesContrato = document.getElementById("observacoesContrato").value.trim();

        localStorage.setItem("equipamentosGuardados", JSON.stringify(equipamentosGuardados));

        setTimeout(function () {
            const origem = parametros.get("origem");

            if (origem === "filaFornecedor") {
                let filaEquipamentos = JSON.parse(localStorage.getItem("filaEdicaoEquipamentos")) || [];

                filaEquipamentos = filaEquipamentos.filter(function (codigoEquipamento) {
                    return codigoEquipamento !== idEquipamento;
                });

                localStorage.setItem("filaEdicaoEquipamentos", JSON.stringify(filaEquipamentos));

                if (filaEquipamentos.length > 0) {
                    window.location.href = `editar_equipamento.html?id=${filaEquipamentos[0]}&origem=filaFornecedor`;
                } else {
                    localStorage.removeItem("filaEdicaoEquipamentos");

                    window.location.href = "../fornecedores/fornecedores.html";
                }

                return;
            }

            if (origem === "filaLocalizacao") {
                let filaEquipamentos = JSON.parse(localStorage.getItem("filaEdicaoEquipamentos")) || [];

                filaEquipamentos = filaEquipamentos.filter(function (codigoEquipamento) {
                    return codigoEquipamento !== idEquipamento;
                });

                localStorage.setItem("filaEdicaoEquipamentos", JSON.stringify(filaEquipamentos));

                if (filaEquipamentos.length > 0) {
                    window.location.href = `editar_equipamento.html?id=${filaEquipamentos[0]}&origem=filaLocalizacao`;
                } else {
                    localStorage.removeItem("filaEdicaoEquipamentos");

                    window.location.href = "../localizacoes/localizacoes.html";
                }

                return;
            }

            window.location.href = `consultar_equipamento.html?id=${idEquipamento}`;
        }, 800);
    });
}

let codigoEquipamentoEliminar = null;

function prepararEliminacaoEquipamento(codigo) {

    codigoEquipamentoEliminar = codigo;

    const equipamento = equipamentosGuardados[codigo];

    const textoModal =
        document.getElementById("textoModalEliminarEquipamento");

    if (textoModal && equipamento) {

        textoModal.innerHTML =
            `Tem a certeza que pretende eliminar o equipamento 
            <strong>${equipamento.designacao}</strong>?`;
    }
}

function confirmarEliminacaoEquipamento() {

    if (!codigoEquipamentoEliminar) {
        return;
    }

    delete equipamentosGuardados[codigoEquipamentoEliminar];

    localStorage.setItem(
        "equipamentosGuardados",
        JSON.stringify(equipamentosGuardados)
    );

    preencherListagemEquipamentos();

    const modalElement =
        document.getElementById("modalEliminarEquipamento");

    const modalBootstrap =
        bootstrap.Modal.getInstance(modalElement);

    if (modalBootstrap) {
        modalBootstrap.hide();
    }

    codigoEquipamentoEliminar = null;
}

// ===============================
// LOCALIZAÇÕES
// ===============================

const localizacoesConsulta = {
    LOC001: {
        codigo: "LOC001",
        edificio: "Edifício Principal",
        piso: "Piso 2",
        servico: "Unidade de Cuidados Intensivos",
        sala: "Sala 2.10",
        observacoes: "Área destinada à monitorização contínua de doentes críticos."
    },

    LOC002: {
        codigo: "LOC002",
        edificio: "Edifício Principal",
        piso: "Piso 2",
        servico: "Unidade de Cuidados Intensivos",
        sala: "Sala 2.11",
        observacoes: "Localização associada a equipamentos de suporte ventilatório."
    },

    LOC003: {
        codigo: "LOC003",
        edificio: "Edifício B",
        piso: "Piso 0",
        servico: "Serviço de Medicina",
        sala: "Gabinete 0.04",
        observacoes: "Localização utilizada para equipamentos de apoio à terapêutica intravenosa."
    },

    LOC004: {
        codigo: "LOC004",
        edificio: "Edifício Principal",
        piso: "Piso 1",
        servico: "Urgência",
        sala: "Sala 1.02",
        observacoes: "Localização destinada a equipamentos de resposta rápida."
    }
};

let localizacoesGuardadas = JSON.parse(localStorage.getItem("localizacoesGuardadas"));

if (!localizacoesGuardadas) {
    localizacoesGuardadas = localizacoesConsulta;
    localStorage.setItem("localizacoesGuardadas", JSON.stringify(localizacoesGuardadas));
}


function preencherListagemLocalizacoes(localizacoes = null) {
    const tabelaLocalizacoes = document.getElementById("tabela-localizacoes");

    if (!tabelaLocalizacoes) {
        return;
    }

    tabelaLocalizacoes.innerHTML = "";

    (localizacoes || Object.values(localizacoesGuardadas))
        .forEach(function (localizacao) {
            const linha = document.createElement("tr");

            linha.innerHTML = `
            <td>${localizacao.codigo}</td>
            <td>${localizacao.edificio}</td>
            <td>${localizacao.piso}</td>
            <td>${localizacao.servico}</td>
            <td>${localizacao.sala}</td>

            <td class="acoes-tabela-privada">
                <a href="consultar_localizacao.html?id=${localizacao.codigo}" class="acao-tabela-privada">
                    <i class="fa-regular fa-eye"></i>
                    Consultar
                </a>

                <a href="editar_localizacao.html?id=${localizacao.codigo}" class="acao-tabela-privada">
                    <i class="fa-regular fa-pen-to-square"></i>
                    Editar
                </a>

                <button
    class="acao-tabela-privada botao-acao-tabela"
    data-bs-toggle="modal"
    data-bs-target="#modalEliminarLocalizacao"
    onclick="prepararEliminacaoLocalizacao('${localizacao.codigo}')">

    <i class="fa-regular fa-trash-can"></i>
    Eliminar
</button>
            </td>
        `;

            tabelaLocalizacoes.appendChild(linha);
        });
}

function inicializarFiltrosLocalizacoes() {

    const pesquisaLocalizacoes =
        document.getElementById("pesquisaLocalizacoes");

    const filtroEdificio =
        document.getElementById("filtroEdificioLocalizacao");

    const filtroServico =
        document.getElementById("filtroServicoLocalizacao");

    const filtroPiso =
        document.getElementById("filtroPisoLocalizacao");

    const filtroSala =
        document.getElementById("filtroSalaLocalizacao");

    const botaoLimparPesquisa =
        document.getElementById("botaoLimparApenasPesquisaLocalizacoes");

    const botaoLimparFiltros =
        document.getElementById("botaoLimparApenasFiltrosLocalizacoes");

    const botaoPesquisar =
        document.getElementById("botaoPesquisarLocalizacoes");

    if (
        !pesquisaLocalizacoes ||
        !filtroEdificio ||
        !filtroServico ||
        !filtroPiso ||
        !filtroSala
    ) {
        return;
    }

    preencherSelectFiltrosLocalizacoes();

    function aplicarFiltrosLocalizacoes() {

        const textoPesquisa =
            pesquisaLocalizacoes.value.toLowerCase().trim();

        const edificioSelecionado =
            filtroEdificio.value;

        const servicoSelecionado =
            filtroServico.value;

        const pisoSelecionado =
            filtroPiso.value;

        const salaSelecionada =
            filtroSala.value;

        const localizacoesFiltradas =
            Object.values(localizacoesGuardadas).filter(function (localizacao) {

                const correspondePesquisa =

                    (localizacao.codigo || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (localizacao.edificio || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (localizacao.piso || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (localizacao.servico || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (localizacao.sala || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                const correspondeEdificio =
                    edificioSelecionado === ""
                    ||
                    localizacao.edificio === edificioSelecionado;

                const correspondeServico =
                    servicoSelecionado === ""
                    ||
                    localizacao.servico === servicoSelecionado;

                const correspondePiso =
                    pisoSelecionado === ""
                    ||
                    localizacao.piso === pisoSelecionado;

                const correspondeSala =
                    salaSelecionada === ""
                    ||
                    localizacao.sala === salaSelecionada;

                return (
                    correspondePesquisa &&
                    correspondeEdificio &&
                    correspondeServico &&
                    correspondePiso &&
                    correspondeSala
                );
            });

        preencherListagemLocalizacoes(localizacoesFiltradas);
    }

    pesquisaLocalizacoes.addEventListener(
        "input",
        aplicarFiltrosLocalizacoes
    );

    filtroEdificio.addEventListener(
        "change",
        aplicarFiltrosLocalizacoes
    );

    filtroServico.addEventListener(
        "change",
        aplicarFiltrosLocalizacoes
    );

    filtroPiso.addEventListener(
        "change",
        aplicarFiltrosLocalizacoes
    );

    filtroSala.addEventListener(
        "change",
        aplicarFiltrosLocalizacoes
    );

    if (botaoPesquisar) {

        botaoPesquisar.addEventListener(
            "click",
            aplicarFiltrosLocalizacoes
        );
    }

    if (botaoLimparPesquisa) {

        botaoLimparPesquisa.addEventListener(
            "click",
            function () {

                pesquisaLocalizacoes.value = "";

                aplicarFiltrosLocalizacoes();
            }
        );
    }

    if (botaoLimparFiltros) {

        botaoLimparFiltros.addEventListener(
            "click",
            function () {

                filtroEdificio.value = "";
                filtroServico.value = "";
                filtroPiso.value = "";
                filtroSala.value = "";

                aplicarFiltrosLocalizacoes();
            }
        );
    }
}

function preencherSelectFiltrosLocalizacoes() {

    const filtroEdificio =
        document.getElementById("filtroEdificioLocalizacao");

    const filtroServico =
        document.getElementById("filtroServicoLocalizacao");

    const filtroPiso =
        document.getElementById("filtroPisoLocalizacao");

    const filtroSala =
        document.getElementById("filtroSalaLocalizacao");

    if (
        !filtroEdificio ||
        !filtroServico ||
        !filtroPiso ||
        !filtroSala
    ) {
        return;
    }

    filtroEdificio.innerHTML =
        '<option value="">Todos</option>';

    filtroServico.innerHTML =
        '<option value="">Todos</option>';

    filtroPiso.innerHTML =
        '<option value="">Todos</option>';

    filtroSala.innerHTML =
        '<option value="">Todos</option>';

    // EDIFÍCIOS
    const edificios = [...new Set(
        Object.values(localizacoesGuardadas)
            .map(function (localizacao) {
                return localizacao.edificio;
            })
    )];

    edificios.forEach(function (edificio) {

        const option = document.createElement("option");

        option.value = edificio;
        option.textContent = edificio;

        filtroEdificio.appendChild(option);
    });

    // SERVIÇOS
    const servicos = [...new Set(
        Object.values(localizacoesGuardadas)
            .map(function (localizacao) {
                return localizacao.servico;
            })
    )];

    servicos.forEach(function (servico) {

        const option = document.createElement("option");

        option.value = servico;
        option.textContent = servico;

        filtroServico.appendChild(option);
    });

    // PISOS
    const pisos = [...new Set(
        Object.values(localizacoesGuardadas)
            .map(function (localizacao) {
                return localizacao.piso;
            })
    )];

    pisos.forEach(function (piso) {

        const option = document.createElement("option");

        option.value = piso;
        option.textContent = piso;

        filtroPiso.appendChild(option);
    });

    // SALAS
    const salas = [...new Set(
        Object.values(localizacoesGuardadas)
            .map(function (localizacao) {
                return localizacao.sala;
            })
    )];

    salas.forEach(function (sala) {

        const option = document.createElement("option");

        option.value = sala;
        option.textContent = sala;

        filtroSala.appendChild(option);
    });
}

function inicializarNovaLocalizacao() {
    const formularioNovaLocalizacao = document.getElementById("form-nova-localizacao");

    if (!formularioNovaLocalizacao) {
        return;
    }

    formularioNovaLocalizacao.addEventListener("submit", function (event) {
        event.preventDefault();

        const codigo = document.getElementById("codigo").value.trim();

        const novaLocalizacao = {
            codigo: codigo,
            edificio: document.getElementById("edificio").value.trim(),
            piso: document.getElementById("piso").value.trim(),
            servico: document.getElementById("servico").value.trim(),
            sala: document.getElementById("sala").value.trim(),
            observacoes: document.getElementById("observacoes").value.trim()
        };

        localizacoesGuardadas[codigo] = novaLocalizacao;

        localStorage.setItem("localizacoesGuardadas", JSON.stringify(localizacoesGuardadas));

        setTimeout(function () {
            window.location.href = "localizacoes.html";
        }, 800);
    });
}

function preencherDetalhesLocalizacao() {
    const campoCodigoLocalizacao = document.getElementById("detalhe-codigo-localizacao");

    if (!campoCodigoLocalizacao) {
        return;
    }

    const parametros = new URLSearchParams(window.location.search);
    const idLocalizacao = parametros.get("id");

    const localizacao = localizacoesGuardadas[idLocalizacao];

    if (!localizacao) {
        campoCodigoLocalizacao.textContent = "Localização não encontrada";
        return;
    }

    document.getElementById("detalhe-codigo-localizacao").textContent = localizacao.codigo;
    document.getElementById("detalhe-edificio").textContent = localizacao.edificio;
    document.getElementById("detalhe-piso").textContent = localizacao.piso;
    document.getElementById("detalhe-servico").textContent = localizacao.servico;
    document.getElementById("detalhe-sala").textContent = localizacao.sala;
    document.getElementById("detalhe-observacoes-localizacao").textContent = localizacao.observacoes;
}

function inicializarEditarLocalizacao() {
    const formEditarLocalizacao = document.getElementById("form-editar-localizacao");

    if (!formEditarLocalizacao) {
        return;
    }

    const parametros = new URLSearchParams(window.location.search);
    const idLocalizacao = parametros.get("id");

    const localizacao = localizacoesGuardadas[idLocalizacao];

    if (!localizacao) {
        return;
    }

    document.getElementById("codigo").value = localizacao.codigo;
    document.getElementById("edificio").value = localizacao.edificio;
    document.getElementById("piso").value = localizacao.piso;
    document.getElementById("servico").value = localizacao.servico;
    document.getElementById("sala").value = localizacao.sala;
    document.getElementById("observacoes").value = localizacao.observacoes;

    const botaoCancelarEdicaoLocalizacao = document.getElementById("botao-cancelar-edicao-localizacao");

    if (botaoCancelarEdicaoLocalizacao) {
        botaoCancelarEdicaoLocalizacao.href = `consultar_localizacao.html?id=${localizacao.codigo}`;
    }

    formEditarLocalizacao.addEventListener("submit", function (event) {
        event.preventDefault();

        localizacoesGuardadas[idLocalizacao].edificio = document.getElementById("edificio").value.trim();
        localizacoesGuardadas[idLocalizacao].piso = document.getElementById("piso").value.trim();
        localizacoesGuardadas[idLocalizacao].servico = document.getElementById("servico").value.trim();
        localizacoesGuardadas[idLocalizacao].sala = document.getElementById("sala").value.trim();
        localizacoesGuardadas[idLocalizacao].observacoes = document.getElementById("observacoes").value.trim();

        localStorage.setItem("localizacoesGuardadas", JSON.stringify(localizacoesGuardadas));

        setTimeout(function () {
            window.location.href = `consultar_localizacao.html?id=${idLocalizacao}`;
        }, 800);
    });
}

let codigoLocalizacaoEliminar = null;

function prepararEliminacaoLocalizacao(codigo) {

    codigoLocalizacaoEliminar = codigo;

    const localizacao =
        localizacoesGuardadas[codigo];

    const textoModal =
        document.getElementById(
            "textoModalEliminarLocalizacao"
        );

    if (textoModal && localizacao) {

        textoModal.innerHTML =
            `Tem a certeza que pretende eliminar a localização 
            <strong>${localizacao.codigo}</strong>?`;
    }
}

function confirmarEliminacaoLocalizacao() {

    if (!codigoLocalizacaoEliminar) {
        return;
    }

    delete localizacoesGuardadas[
        codigoLocalizacaoEliminar
    ];

    localStorage.setItem(
        "localizacoesGuardadas",
        JSON.stringify(localizacoesGuardadas)
    );

    preencherListagemLocalizacoes();

    const modalElement =
        document.getElementById(
            "modalEliminarLocalizacao"
        );

    const modalBootstrap =
        bootstrap.Modal.getInstance(
            modalElement
        );

    if (modalBootstrap) {
        modalBootstrap.hide();
    }

    codigoLocalizacaoEliminar = null;
}

// ===============================
// FORNECEDORES
// ===============================

const fornecedoresConsulta = {
    FOR001: {
        codigo: "FOR001",
        nomeEmpresa: "Philips Healthcare",
        nif: "501234567",
        telefone: "+351 930 193 126",
        email: "contacto@philipshealthcare.pt",
        morada: "Lisboa, Portugal",
        website: "www.philips.com",
        pessoaContacto: "Ana Martins",
        telefonePessoaContacto: "+351 910 000 000",
        tipoFornecedor: "Fabricante",
        observacoes: "Fornecedor associado a equipamentos de monitorização."
    },

    FOR002: {
        codigo: "FOR002",
        nomeEmpresa: "Dräger",
        nif: "502345678",
        telefone: "+351 930 327 344",
        email: "contacto@draegermedical.pt",
        morada: "Porto, Portugal",
        website: "www.draeger.com",
        pessoaContacto: "Miguel Santos",
        telefonePessoaContacto: "+351 920 000 000",
        tipoFornecedor: "Fabricante",
        observacoes: "Fabricante associado a equipamentos de suporte ventilatório."
    },

    FOR003: {
        codigo: "FOR003",
        nomeEmpresa: "MedSupply Portugal",
        nif: "503456789",
        telefone: "+351 930 248 308",
        email: "contacto@medsupply.pt",
        morada: "Aveiro, Portugal",
        website: "www.medsupply.com",
        pessoaContacto: "Carla Ferreira",
        telefonePessoaContacto: "+351 930 000 000",
        tipoFornecedor: "Distribuidor ou Fornecedor comercial",
        observacoes: "Distribuidor comercial de equipamentos e consumíveis."
    },

    FOR004: {
        codigo: "FOR004",
        nomeEmpresa: "TecnoMed Assistência",
        nif: "504567890",
        telefone: "+351 930 656 375",
        email: "contacto@tecnomed.pt",
        morada: "Coimbra, Portugal",
        website: "www.tecnomed.com",
        pessoaContacto: "João Almeida",
        telefonePessoaContacto: "+351 940 000 000",
        tipoFornecedor: "Empresa de assistência técnica",
        observacoes: "Empresa responsável por manutenção preventiva e corretiva."
    }
};

let fornecedoresGuardados = JSON.parse(localStorage.getItem("fornecedoresGuardados"));

if (!fornecedoresGuardados) {
    fornecedoresGuardados = fornecedoresConsulta;
    localStorage.setItem("fornecedoresGuardados", JSON.stringify(fornecedoresGuardados));
}


// Preencher listagem de fornecedores na página fornecedores.html
function preencherListagemFornecedores(
    listaFornecedores = Object.values(fornecedoresGuardados)) {
    const tabelaFornecedores = document.getElementById("tabela-fornecedores");

    if (!tabelaFornecedores) {
        return;
    }

    tabelaFornecedores.innerHTML = "";

    ordenarFornecedoresPorCodigoCrescente(listaFornecedores);

    if (listaFornecedores.length === 0) {

        tabelaFornecedores.innerHTML = `
        <tr>
            <td colspan="7" class="text-center">
                Nenhum fornecedor encontrado.
            </td>
        </tr>
    `;

        return;
    }

    listaFornecedores.forEach(function (fornecedor) {
        const linha = document.createElement("tr");

        linha.innerHTML = `
    <td>${fornecedor.nomeEmpresa}</td>
    <td>${fornecedor.telefone}</td>
    <td>${fornecedor.email}</td>
    <td>${fornecedor.website}</td>
    <td>${fornecedor.tipoFornecedor}</td>

            <td class="acoes-tabela-privada">
                <a href="consultar_fornecedor.html?id=${fornecedor.codigo}" class="acao-tabela-privada">
                    <i class="fa-regular fa-eye"></i>
                    Consultar
                </a>

                <a href="editar_fornecedor.html?id=${fornecedor.codigo}" class="acao-tabela-privada">
                    <i class="fa-regular fa-pen-to-square"></i>
                    Editar
                </a>

                <button
    class="acao-tabela-privada botao-acao-tabela"
    data-bs-toggle="modal"
    data-bs-target="#modalEliminarFornecedor"
    onclick="prepararEliminacaoFornecedor('${fornecedor.codigo}')">

    <i class="fa-regular fa-trash-can"></i>
    Eliminar
</button>
            </td>
        `;

        tabelaFornecedores.appendChild(linha);
    });
}

function inicializarFiltrosFornecedores() {

    const pesquisaFornecedores =
        document.getElementById("pesquisaFornecedores");

    const filtroTipoFornecedor =
        document.getElementById("filtroTipoFornecedor");

    const filtroNomeEmpresa =
        document.getElementById("filtroNomeEmpresa");

    const filtroMoradaFornecedor =
        document.getElementById("filtroMoradaFornecedor");

    const filtroPessoaContacto =
        document.getElementById("filtroPessoaContacto");

    const botaoLimparPesquisa =
        document.getElementById("botaoLimparApenasPesquisaFornecedores");

    const botaoLimparFiltros =
        document.getElementById("botaoLimparApenasFiltrosFornecedores");

    const botaoPesquisar =
        document.getElementById("botaoPesquisarFornecedores");

    if (
        !pesquisaFornecedores ||
        !filtroTipoFornecedor ||
        !filtroMoradaFornecedor
    ) {
        return;
    }

    preencherSelectFiltrosFornecedores();

    function aplicarFiltrosFornecedores() {

        const textoPesquisa =
            pesquisaFornecedores.value.toLowerCase().trim();

        const tipoSelecionado =
            filtroTipoFornecedor.value;

        const nomeEmpresaSelecionado =
            filtroNomeEmpresa.value;

        const moradaSelecionada =
            filtroMoradaFornecedor.value;

        const pessoaContactoSelecionada =
            filtroPessoaContacto.value;

        const fornecedoresFiltrados =
            Object.values(fornecedoresGuardados).filter(function (fornecedor) {

                const textoEquipamentos =
                    equipamentosAssociados.map(function (equipamento) {

                        return [
                            equipamento.codigo,
                            equipamento.designacao,
                            equipamento.marca,
                            equipamento.modelo,
                            equipamento.categoria
                        ].join(" ");

                    }).join(" ").toLowerCase();

                const correspondePesquisa =

                    (fornecedor.codigo || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (fornecedor.nomeEmpresa || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (fornecedor.nif || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (fornecedor.telefone || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (fornecedor.email || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (fornecedor.morada || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (fornecedor.website || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (fornecedor.pessoaContacto || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (fornecedor.telefonePessoaContacto || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (fornecedor.tipoFornecedor || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (fornecedor.observacoes || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    textoEquipamentos.includes(textoPesquisa);

                const correspondeTipo =
                    tipoSelecionado === ""
                    ||
                    fornecedor.tipoFornecedor === tipoSelecionado;

                const correspondeNomeEmpresa =
                    nomeEmpresaSelecionado === ""
                    ||
                    fornecedor.nomeEmpresa === nomeEmpresaSelecionado;

                const correspondeMorada =
                    moradaSelecionada === ""
                    ||
                    (fornecedor.morada || "")
                        .toLowerCase()
                        .includes(moradaSelecionada.toLowerCase());

                const correspondePessoaContacto =
                    pessoaContactoSelecionada === ""
                    ||
                    fornecedor.pessoaContacto === pessoaContactoSelecionada;

                return (
                    correspondePesquisa &&
                    correspondeTipo &&
                    correspondeNomeEmpresa &&
                    correspondeMorada &&
                    correspondePessoaContacto
                );
            });

        preencherListagemFornecedores(fornecedoresFiltrados);
    }

    pesquisaFornecedores.addEventListener(
        "input",
        aplicarFiltrosFornecedores
    );

    filtroTipoFornecedor.addEventListener(
        "change",
        aplicarFiltrosFornecedores
    );

    filtroNomeEmpresa.addEventListener(
        "change",
        aplicarFiltrosFornecedores
    );

    filtroMoradaFornecedor.addEventListener(
        "change",
        aplicarFiltrosFornecedores
    );

    filtroPessoaContacto.addEventListener(
        "change",
        aplicarFiltrosFornecedores
    );

    if (botaoPesquisar) {

        botaoPesquisar.addEventListener(
            "click",
            aplicarFiltrosFornecedores
        );
    }

    if (botaoLimparPesquisa) {

        botaoLimparPesquisa.addEventListener(
            "click",
            function () {

                pesquisaFornecedores.value = "";

                aplicarFiltrosFornecedores();
            }
        );
    }

    if (botaoLimparFiltros) {

        botaoLimparFiltros.addEventListener(
            "click",
            function () {

                filtroTipoFornecedor.value = "";
                filtroNomeEmpresa.value = "";
                filtroMoradaFornecedor.value = "";
                filtroPessoaContacto.value = "";

                aplicarFiltrosFornecedores();
            }
        );
    }
}

function preencherSelectFiltrosFornecedores() {

    const filtroTipoFornecedor =
        document.getElementById("filtroTipoFornecedor");

    const filtroNomeEmpresa =
        document.getElementById("filtroNomeEmpresa");

    const filtroPessoaContacto =
        document.getElementById("filtroPessoaContacto");

    if (
        !filtroTipoFornecedor ||
        !filtroNomeEmpresa ||
        !filtroPessoaContacto
    ) {
        return;
    }

    filtroTipoFornecedor.innerHTML =
        '<option value="">Todos</option>';

    filtroNomeEmpresa.innerHTML =
        '<option value="">Todos</option>';

    filtroPessoaContacto.innerHTML =
        '<option value="">Todos</option>';

    // TIPOS DE FORNECEDOR
    const tiposFornecedor = [
        "Fabricante",
        "Distribuidor ou Fornecedor comercial",
        "Empresa de assistência técnica",
        "Fornecedor de consumíveis ou acessórios"
    ];

    tiposFornecedor.forEach(function (tipo) {

        const option = document.createElement("option");

        option.value = tipo;
        option.textContent = tipo;

        filtroTipoFornecedor.appendChild(option);
    });

    // NOMES DAS EMPRESAS
    Object.values(fornecedoresGuardados).forEach(function (fornecedor) {

        const option = document.createElement("option");

        option.value = fornecedor.nomeEmpresa;
        option.textContent = fornecedor.nomeEmpresa;

        filtroNomeEmpresa.appendChild(option);
    });

    // PESSOAS DE CONTACTO
    Object.values(fornecedoresGuardados).forEach(function (fornecedor) {

        const option = document.createElement("option");

        option.value = fornecedor.pessoaContacto;
        option.textContent = fornecedor.pessoaContacto;

        filtroPessoaContacto.appendChild(option);
    });
}

function ordenarFornecedoresPorCodigoCrescente(listaFornecedores) {

    listaFornecedores.sort(function (a, b) {

        return (a.codigo || "")
            .localeCompare(b.codigo || "");

    });
}

// Adicionar novo fornecedor e guardar no localStorage
function inicializarNovoFornecedor() {
    const formularioNovoFornecedor = document.getElementById("form-novo-fornecedor");

    if (!formularioNovoFornecedor) {
        return;
    }

    formularioNovoFornecedor.addEventListener("submit", function (event) {
        event.preventDefault();

        const codigo = document.getElementById("codigo").value.trim();
        const nomeEmpresa = document.getElementById("nome_empresa").value.trim();
        const nif = document.getElementById("nif").value.trim();
        const telefoneNovo = document.getElementById("telefone").value.trim();
        const emailNovo = document.getElementById("email").value.trim();
        const moradaNova = document.getElementById("morada").value.trim();
        const websiteNovo = document.getElementById("website").value.trim();
        const pessoaContactoNova = document.getElementById("pessoa_contacto").value.trim();
        const telefonePessoaContactoNovo = document.getElementById("telefone_pessoa_contacto").value.trim();
        const tipoFornecedorNovo = document.getElementById("tipo_fornecedor").value.trim();
        const observacoesNovas = document.getElementById("observacoes").value.trim();

        const novoFornecedor = {
            codigo: codigo,
            nomeEmpresa: nomeEmpresa,
            nif: nif,
            telefone: telefoneNovo,
            email: emailNovo,
            morada: moradaNova,
            website: websiteNovo,
            pessoaContacto: pessoaContactoNova,
            telefonePessoaContacto: telefonePessoaContactoNovo,
            tipoFornecedor: tipoFornecedorNovo,
            observacoes: observacoesNovas
        };

        fornecedoresGuardados[codigo] = novoFornecedor;

        localStorage.setItem("fornecedoresGuardados", JSON.stringify(fornecedoresGuardados));

        setTimeout(function () {
            window.location.href = "fornecedores.html";
        }, 800);
    });
}

// Consultar detalhes do fornecedor
function preencherDetalhesFornecedor() {
    const campoCodigoFornecedor = document.getElementById("detalhe-codigo-fornecedor");

    if (!campoCodigoFornecedor) {
        return;
    }

    const parametros = new URLSearchParams(window.location.search);
    const idFornecedor = parametros.get("id");

    const fornecedor = fornecedoresGuardados[idFornecedor];

    if (!fornecedor) {
        campoCodigoFornecedor.textContent = "Fornecedor não encontrado";
        return;
    }

    document.getElementById("detalhe-codigo-fornecedor").textContent = fornecedor.codigo;
    document.getElementById("detalhe-nome-empresa").textContent = fornecedor.nomeEmpresa;
    document.getElementById("detalhe-nif").textContent = fornecedor.nif;
    document.getElementById("detalhe-telefone").textContent = fornecedor.telefone;
    document.getElementById("detalhe-email").textContent = fornecedor.email;
    document.getElementById("detalhe-morada").textContent = fornecedor.morada;
    document.getElementById("detalhe-website").textContent = fornecedor.website;
    document.getElementById("detalhe-pessoa-contacto").textContent = fornecedor.pessoaContacto;
    document.getElementById("detalhe-telefone-pessoa-contacto").textContent = fornecedor.telefonePessoaContacto;
    document.getElementById("detalhe-tipo-fornecedor").textContent = fornecedor.tipoFornecedor;
    document.getElementById("detalhe-observacoes-fornecedor").textContent = fornecedor.observacoes;
}

// Editar fornecedor
function inicializarEditarFornecedor() {
    const formEditarFornecedor = document.getElementById("form-editar-fornecedor");

    if (!formEditarFornecedor) {
        return;
    }

    const parametros = new URLSearchParams(window.location.search);
    const idFornecedor = parametros.get("id");

    const fornecedor = fornecedoresGuardados[idFornecedor];

    if (!fornecedor) {
        return;
    }

    document.getElementById("codigo").value = fornecedor.codigo;
    document.getElementById("nome_empresa").value = fornecedor.nomeEmpresa;
    document.getElementById("nif").value = fornecedor.nif;
    document.getElementById("telefone").value = fornecedor.telefone;
    document.getElementById("email").value = fornecedor.email;
    document.getElementById("morada").value = fornecedor.morada;
    document.getElementById("website").value = fornecedor.website;
    document.getElementById("pessoa_contacto").value = fornecedor.pessoaContacto;
    document.getElementById("telefone_pessoa_contacto").value = fornecedor.telefonePessoaContacto;
    document.getElementById("tipo_fornecedor").value = fornecedor.tipoFornecedor;
    document.getElementById("observacoes").value = fornecedor.observacoes;

    const botaoCancelarEdicaoFornecedor = document.getElementById("botao-cancelar-edicao-fornecedor");

    if (botaoCancelarEdicaoFornecedor) {
        botaoCancelarEdicaoFornecedor.href = `consultar_fornecedor.html?id=${fornecedor.codigo}`;
    }

    formEditarFornecedor.addEventListener("submit", function (event) {
        event.preventDefault();

        fornecedoresGuardados[idFornecedor].codigo =
            document.getElementById("codigo").value.trim();

        fornecedoresGuardados[idFornecedor].nomeEmpresa =
            document.getElementById("nome_empresa").value.trim();

        fornecedoresGuardados[idFornecedor].nif =
            document.getElementById("nif").value.trim();
        fornecedoresGuardados[idFornecedor].telefone = document.getElementById("telefone").value.trim();
        fornecedoresGuardados[idFornecedor].email = document.getElementById("email").value.trim();
        fornecedoresGuardados[idFornecedor].morada = document.getElementById("morada").value.trim();
        fornecedoresGuardados[idFornecedor].website = document.getElementById("website").value.trim();
        fornecedoresGuardados[idFornecedor].pessoaContacto = document.getElementById("pessoa_contacto").value.trim();
        fornecedoresGuardados[idFornecedor].telefonePessoaContacto = document.getElementById("telefone_pessoa_contacto").value.trim();
        fornecedoresGuardados[idFornecedor].tipoFornecedor = document.getElementById("tipo_fornecedor").value.trim();
        fornecedoresGuardados[idFornecedor].observacoes = document.getElementById("observacoes").value.trim();

        localStorage.setItem("fornecedoresGuardados", JSON.stringify(fornecedoresGuardados));

        setTimeout(function () {
            window.location.href = `consultar_fornecedor.html?id=${idFornecedor}`;
        }, 800);
    });
}

let codigoFornecedorEliminar = null;

function prepararEliminacaoFornecedor(codigo) {

    codigoFornecedorEliminar = codigo;

    const fornecedor = fornecedoresGuardados[codigo];

    const textoModal =
        document.getElementById("textoModalEliminarFornecedor");

    if (textoModal && fornecedor) {

        textoModal.innerHTML =
            `Tem a certeza que pretende eliminar o fornecedor 
            <strong>${fornecedor.nomeEmpresa}</strong>?`;
    }
}

function confirmarEliminacaoFornecedor() {

    if (!codigoFornecedorEliminar) {
        return;
    }

    delete fornecedoresGuardados[codigoFornecedorEliminar];

    localStorage.setItem(
        "fornecedoresGuardados",
        JSON.stringify(fornecedoresGuardados)
    );

    preencherListagemFornecedores();

    const modalElement =
        document.getElementById("modalEliminarFornecedor");

    const modalBootstrap =
        bootstrap.Modal.getInstance(modalElement);

    if (modalBootstrap) {
        modalBootstrap.hide();
    }

    codigoFornecedorEliminar = null;
}

// ===============================
// DOCUMENTAÇÃO
// ===============================

const documentacaoConsulta = {
    DOC001: {
        codigo: "DOC001",
        tipoDocumentacao: "Manual técnico",
        nomeDocumentacao: "Manual do monitor multiparamétrico",
        dataDocumentacao: "10/01/2022",
        dataValidade: "",
        ficheiro: "manual_monitor_multiparametrico.pdf",
        observacoes: "Manual técnico fornecido pelo fabricante."
    },

    DOC002: {
        codigo: "DOC002",
        tipoDocumentacao: "Certificado de calibração",
        nomeDocumentacao: "Certificado de calibração da bomba de infusão",
        dataDocumentacao: "15/03/2024",
        dataValidade: "15/03/2025",
        ficheiro: "certificado_calibracao_bomba_infusao.pdf",
        observacoes: "Documento válido por um ano."
    },

    DOC003: {
        codigo: "DOC003",
        tipoDocumentacao: "Relatório de manutenção",
        nomeDocumentacao: "Relatório de manutenção do ventilador pulmonar",
        dataDocumentacao: "20/09/2024",
        dataValidade: "",
        ficheiro: "relatorio_manutencao_ventilador.pdf",
        observacoes: "Relatório associado à intervenção técnica realizada."
    },

    DOC004: {
        codigo: "DOC004",
        tipoDocumentacao: "Garantia",
        nomeDocumentacao: "Garantia do desfibrilhador",
        dataDocumentacao: "05/06/2022",
        dataValidade: "05/06/2025",
        ficheiro: "garantia_desfibrilhador.pdf",
        observacoes: "Garantia comercial do equipamento."
    }
};

let documentacaoGuardada = JSON.parse(localStorage.getItem("documentacaoGuardada"));

if (!documentacaoGuardada) {
    documentacaoGuardada = documentacaoConsulta;
    localStorage.setItem("documentacaoGuardada", JSON.stringify(documentacaoGuardada));
}

function preencherListagemDocumentacao(
    listaDocumentacao = Object.values(documentacaoGuardada)
) {

    const tabelaDocumentacao =
        document.getElementById("tabela-documentacoes");

    if (!tabelaDocumentacao) {
        return;
    }

    tabelaDocumentacao.innerHTML = "";

    // Caso não existam documentações
    if (listaDocumentacao.length === 0) {

        tabelaDocumentacao.innerHTML = `
            <tr>
                <td colspan="7" class="text-center">
                    Nenhuma documentação encontrada.
                </td>
            </tr>
        `;

        return;
    }

    listaDocumentacao.forEach(function (documentacao) {

        const linha = document.createElement("tr");

        linha.innerHTML = `
            <td>${documentacao.codigo}</td>
            <td>${documentacao.tipoDocumentacao}</td>
            <td>${documentacao.nomeDocumentacao}</td>
            <td>${documentacao.dataDocumentacao}</td>

            <td class="acoes-tabela-privada">

                <a href="consultar_documentacao.html?id=${documentacao.codigo}"
                    class="acao-tabela-privada">

                    <i class="fa-regular fa-eye"></i>
                    Consultar
                </a>

                <a href="editar_documentacao.html?id=${documentacao.codigo}"
                    class="acao-tabela-privada">

                    <i class="fa-regular fa-pen-to-square"></i>
                    Editar
                </a>

                <button
                    class="acao-tabela-privada botao-acao-tabela"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEliminarDocumentacao"
                    onclick="prepararEliminacaoDocumentacao('${documentacao.codigo}')">

                    <i class="fa-regular fa-trash-can"></i>
                    Eliminar
                </button>

            </td>
        `;

        tabelaDocumentacao.appendChild(linha);
    });
}

function ordenarEquipamentosPorCodigoCrescente(listaEquipamentos) {
    listaEquipamentos.sort(function (a, b) {
        return (a.codigo || "").localeCompare(b.codigo || "");
    });
}

function inicializarFiltrosDocumentacoes() {

    const pesquisaDocumentacoes =
        document.getElementById("pesquisaDocumentacoes");

    const filtroTipoDocumentacao =
        document.getElementById("filtroTipoDocumentacao");

    const filtroNomeDocumentacao =
        document.getElementById("filtroNomeDocumentacao");

    const filtroDataDocumentacao =
        document.getElementById("filtroDataDocumentacao");

    const botaoLimparPesquisa =
        document.getElementById("botaoLimparApenasPesquisaDocumentacoes");

    const botaoLimparFiltros =
        document.getElementById("botaoLimparApenasFiltrosDocumentacoes");

    const botaoPesquisar =
        document.getElementById("botaoPesquisarDocumentacoes");

    if (
        !pesquisaDocumentacoes ||
        !filtroTipoDocumentacao ||
        !filtroNomeDocumentacao ||
        !filtroDataDocumentacao
    ) {
        return;
    }

    preencherSelectFiltrosDocumentacoes();

    function aplicarFiltrosDocumentacoes() {

        const textoPesquisa =
            pesquisaDocumentacoes.value.toLowerCase().trim();

        const tipoSelecionado =
            filtroTipoDocumentacao.value;

        const nomeSelecionado =
            filtroNomeDocumentacao.value;

        const dataSelecionada =
            filtroDataDocumentacao.value;

        const documentacoesFiltradas =
            Object.values(documentacaoGuardada).filter(function (documentacao) {

                const correspondePesquisa =

                    (documentacao.codigo || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (documentacao.tipoDocumentacao || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (documentacao.nomeDocumentacao || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (documentacao.dataDocumentacao || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (documentacao.dataValidade || "")
                        .toLowerCase()
                        .includes(textoPesquisa)

                    ||

                    (documentacao.ficheiro || "")
                        .toLowerCase()
                        .includes(textoPesquisa);

                const correspondeTipo =
                    tipoSelecionado === ""
                    ||
                    documentacao.tipoDocumentacao === tipoSelecionado;

                const correspondeNome =
                    nomeSelecionado === ""
                    ||
                    documentacao.nomeDocumentacao === nomeSelecionado;

                const correspondeData =
                    dataSelecionada === ""
                    ||
                    documentacao.dataDocumentacao === dataSelecionada;

                return (
                    correspondePesquisa &&
                    correspondeTipo &&
                    correspondeNome &&
                    correspondeData
                );
            });

        preencherListagemDocumentacao(documentacoesFiltradas);
    }

    pesquisaDocumentacoes.addEventListener(
        "input",
        aplicarFiltrosDocumentacoes
    );

    filtroTipoDocumentacao.addEventListener(
        "change",
        aplicarFiltrosDocumentacoes
    );

    filtroNomeDocumentacao.addEventListener(
        "change",
        aplicarFiltrosDocumentacoes
    );

    filtroDataDocumentacao.addEventListener(
        "change",
        aplicarFiltrosDocumentacoes
    );

    if (botaoPesquisar) {

        botaoPesquisar.addEventListener(
            "click",
            aplicarFiltrosDocumentacoes
        );
    }

    if (botaoLimparPesquisa) {

        botaoLimparPesquisa.addEventListener(
            "click",
            function () {

                pesquisaDocumentacoes.value = "";

                aplicarFiltrosDocumentacoes();
            }
        );
    }

    if (botaoLimparFiltros) {

        botaoLimparFiltros.addEventListener(
            "click",
            function () {

                filtroTipoDocumentacao.value = "";
                filtroNomeDocumentacao.value = "";
                filtroDataDocumentacao.value = "";

                aplicarFiltrosDocumentacoes();
            }
        );
    }
}

function preencherSelectFiltrosDocumentacoes() {

    const filtroTipoDocumentacao =
        document.getElementById("filtroTipoDocumentacao");

    const filtroNomeDocumentacao =
        document.getElementById("filtroNomeDocumentacao");

    const filtroDataDocumentacao =
        document.getElementById("filtroDataDocumentacao");


    if (
        !filtroTipoDocumentacao ||
        !filtroNomeDocumentacao ||
        !filtroDataDocumentacao
    ) {
        return;
    }

    filtroTipoDocumentacao.innerHTML =
        '<option value="">Todos</option>';

    filtroNomeDocumentacao.innerHTML =
        '<option value="">Todos</option>';

    filtroDataDocumentacao.innerHTML =
        '<option value="">Todas</option>';

    // TIPOS DE DOCUMENTAÇÃO
    const tiposDocumentacao = [
        "Manual técnico",
        "Certificado de calibração",
        "Relatório de manutenção",
        "Garantia"
    ];

    tiposDocumentacao.forEach(function (tipo) {

        const option = document.createElement("option");

        option.value = tipo;
        option.textContent = tipo;

        filtroTipoDocumentacao.appendChild(option);
    });

    // NOMES DE DOCUMENTAÇÃO
    const nomesDocumentacao = [...new Set(
        Object.values(documentacaoGuardada)
            .map(function (documentacao) {
                return documentacao.nomeDocumentacao;
            })
    )];

    nomesDocumentacao.forEach(function (nome) {

        const option = document.createElement("option");

        option.value = nome;
        option.textContent = nome;

        filtroNomeDocumentacao.appendChild(option);
    });

    //DATA DOCUMENTAÇÃO
    const datasDocumentacao = [...new Set(
        Object.values(documentacaoGuardada)
            .map(function (documentacao) {
                return documentacao.dataDocumentacao;
            })
    )].sort();

    datasDocumentacao.forEach(function (data) {

        const option = document.createElement("option");

        option.value = data;
        option.textContent = data;

        filtroDataDocumentacao.appendChild(option);
    });
}

function inicializarNovaDocumentacao() {
    const formularioNovaDocumentacao = document.getElementById("form-nova-documentacao");

    if (!formularioNovaDocumentacao) {
        return;
    }

    formularioNovaDocumentacao.addEventListener("submit", function (event) {
        event.preventDefault();

        const codigo = document.getElementById("codigo").value.trim();

        const novaDocumentacao = {
            codigo: codigo,
            tipoDocumentacao: document.getElementById("tipo_documento").value.trim(),
            nomeDocumentacao: document.getElementById("nome_documento").value.trim(),
            dataDocumentacao: converterDataParaTexto(document.getElementById("data_documento").value),
            dataValidade: converterDataParaTexto(document.getElementById("data_validade").value),
            ficheiro: document.getElementById("ficheiro").value.trim(),
            observacoes: document.getElementById("observacoes").value.trim()
        };

        documentacaoGuardada[codigo] = novaDocumentacao;

        localStorage.setItem("documentacaoGuardada", JSON.stringify(documentacaoGuardada));

        setTimeout(function () {
            window.location.href = "documentacao.html";
        }, 800);
    });
}

function preencherDetalhesDocumentacao() {
    const campoCodigoDocumentacao = document.getElementById("detalhe-codigo-documentacao");

    if (!campoCodigoDocumentacao) {
        return;
    }

    const parametros = new URLSearchParams(window.location.search);
    const idDocumentacao = parametros.get("id");

    const documentacao = documentacaoGuardada[idDocumentacao];

    if (!documentacao) {
        campoCodigoDocumentacao.textContent = "Documentação não encontrada";
        return;
    }

    document.getElementById("detalhe-codigo-documentacao").textContent = documentacao.codigo;
    document.getElementById("detalhe-tipo-documentacao").textContent = documentacao.tipoDocumentacao;
    document.getElementById("detalhe-nome-documentacao").textContent = documentacao.nomeDocumentacao;
    document.getElementById("detalhe-data-documentacao").textContent = documentacao.dataDocumentacao;
    document.getElementById("detalhe-data-validade-documentacao").textContent = documentacao.dataValidade || "Sem data de validade";
    document.getElementById("detalhe-ficheiro-documentacao").textContent = documentacao.ficheiro;
    document.getElementById("detalhe-observacoes-documentacao").textContent = documentacao.observacoes || "Sem observações";
}

function inicializarEditarDocumentacao() {
    const formularioEditarDocumentacao = document.getElementById("form-editar-documentacao");

    if (!formularioEditarDocumentacao) {
        return;
    }

    const parametros = new URLSearchParams(window.location.search);
    const idDocumentacao = parametros.get("id");

    const documentacao = documentacaoGuardada[idDocumentacao];

    if (!documentacao) {
        return;
    }

    document.getElementById("codigo").value = documentacao.codigo;
    document.getElementById("tipo_documento").value = documentacao.tipoDocumentacao;
    document.getElementById("nome_documento").value = documentacao.nomeDocumentacao;
    document.getElementById("data_documento").value = converterDataParaInput(documentacao.dataDocumentacao);
    document.getElementById("data_validade").value = converterDataParaInput(documentacao.dataValidade);
    document.getElementById("ficheiro").value = documentacao.ficheiro;
    document.getElementById("observacoes").value = documentacao.observacoes;

    const botaoCancelarEdicaoDocumentacao = document.getElementById("botao-cancelar-edicao-documentacao");

    if (botaoCancelarEdicaoDocumentacao) {
        botaoCancelarEdicaoDocumentacao.href = `consultar_documentacao.html?id=${documentacao.codigo}`;
    }

    formularioEditarDocumentacao.addEventListener("submit", function (event) {
        event.preventDefault();

        documentacaoGuardada[idDocumentacao].tipoDocumentacao = document.getElementById("tipo_documento").value.trim();
        documentacaoGuardada[idDocumentacao].nomeDocumentacao = document.getElementById("nome_documento").value.trim();
        documentacaoGuardada[idDocumentacao].dataDocumentacao = converterDataParaTexto(document.getElementById("data_documento").value);
        documentacaoGuardada[idDocumentacao].dataValidade = converterDataParaTexto(document.getElementById("data_validade").value);
        documentacaoGuardada[idDocumentacao].ficheiro = document.getElementById("ficheiro").value.trim();
        documentacaoGuardada[idDocumentacao].observacoes = document.getElementById("observacoes").value.trim();

        localStorage.setItem("documentacaoGuardada", JSON.stringify(documentacaoGuardada));

        setTimeout(function () {
            const origem = parametros.get("origem");

            if (origem === "filaEquipamento") {
                let filaDocumentacao = JSON.parse(localStorage.getItem("filaEdicaoDocumentacao")) || [];

                filaDocumentacao = filaDocumentacao.filter(function (codigoDocumentacao) {
                    return codigoDocumentacao !== idDocumentacao;
                });

                localStorage.setItem("filaEdicaoDocumentacao", JSON.stringify(filaDocumentacao));

                if (filaDocumentacao.length > 0) {
                    window.location.href = `editar_documentacao.html?id=${filaDocumentacao[0]}&origem=filaEquipamento`;
                } else {
                    localStorage.removeItem("filaEdicaoDocumentacao");

                    window.location.href = "../equipamentos/equipamentos.html";
                }

                return;
            }

            window.location.href = `consultar_documentacao.html?id=${idDocumentacao}`;
        }, 800);
    });
}

let codigoDocumentacaoEliminar = null;

function prepararEliminacaoDocumentacao(codigo) {

    codigoDocumentacaoEliminar = codigo;

    const documentacao =
        documentacaoGuardada[codigo];

    const textoModal =
        document.getElementById(
            "textoModalEliminarDocumentacao"
        );

    if (textoModal && documentacao) {

        textoModal.innerHTML =
            `Tem a certeza que pretende eliminar a documentação 
            <strong>${documentacao.nomeDocumentacao}</strong>?`;
    }
}

function confirmarEliminacaoDocumentacao() {

    if (!codigoDocumentacaoEliminar) {
        return;
    }

    delete documentacaoGuardada[
        codigoDocumentacaoEliminar
    ];

    localStorage.setItem(
        "documentacaoGuardada",
        JSON.stringify(documentacaoGuardada)
    );

    preencherListagemDocumentacao();

    const modalElement =
        document.getElementById(
            "modalEliminarDocumentacao"
        );

    const modalBootstrap =
        bootstrap.Modal.getInstance(
            modalElement
        );

    if (modalBootstrap) {
        modalBootstrap.hide();
    }

    codigoDocumentacaoEliminar = null;
}

/*DASHBOARD*/
function inicializarDashboard() {
    const totalEquipamentos = document.getElementById("totalEquipamentosDashboard");

    if (!totalEquipamentos) {
        return;
    }

    const equipamentos = Object.values(equipamentosGuardados || {});
    const documentacao = Object.values(documentacaoGuardada || {});
    const fornecedores = fornecedoresGuardados || {};
    const localizacoes = localizacoesGuardadas || {};

    const hoje = new Date();
    hoje.setHours(0, 0, 0, 0);

    const total = equipamentos.length;

    const ativos = equipamentos.filter(function (equipamento) {
        return equipamento.estado === "Ativo";
    }).length;

    const manutencao = equipamentos.filter(function (equipamento) {
        return equipamento.estado === "Em manutenção";
    }).length;

    const inativos = equipamentos.filter(function (equipamento) {
        return equipamento.estado === "Inativo";
    }).length;

    const garantiasExpiradas = equipamentos.filter(function (equipamento) {
        if (!equipamento.dataFimGarantia) {
            return false;
        }

        const dataFim = converterTextoParaData(equipamento.dataFimGarantia);

        if (!dataFim) {
            return false;
        }

        dataFim.setHours(0, 0, 0, 0);

        return dataFim < hoje;
    }).length;

    const equipamentosSemDocumentacao = equipamentos.filter(function (equipamento) {
        return !documentacao.some(function (doc) {
            return doc.equipamento === equipamento.codigo;
        });
    }).length;

    totalEquipamentos.textContent = total;
    document.getElementById("equipamentosAtivosDashboard").textContent = ativos;
    document.getElementById("equipamentosManutencaoDashboard").textContent = manutencao;
    document.getElementById("equipamentosInativosDashboard").textContent = inativos;
    document.getElementById("garantiasExpiradasDashboard").textContent = garantiasExpiradas;
    document.getElementById("semDocumentacaoDashboard").textContent = equipamentosSemDocumentacao;

    preencherGraficoServicosDashboard(equipamentos, localizacoes);
    preencherDistribuicaoCategoriasDashboard(equipamentos);
    preencherTabelaGarantiasDashboard(equipamentos, fornecedores);
    preencherCriticidadeElevadaDashboard(equipamentos);
    preencherSuporteVidaDashboard(equipamentos, localizacoes);

    const dataAtual = new Date();

    document.getElementById("ultimaAtualizacaoDashboard").textContent =
        "Última atualização: " +
        dataAtual.toLocaleDateString("pt-PT") +
        " " +
        dataAtual.toLocaleTimeString("pt-PT", { hour: "2-digit", minute: "2-digit" });
}

// ===============================
// DROPDOWN DO UTILIZADOR
// ===============================

function inicializarDropdownUtilizador() {
    const botaoUtilizadorPrivado = document.querySelector(".utilizador-privado");
    const menuUtilizadorPrivado = document.querySelector(".menu-utilizador-privado");

    if (!botaoUtilizadorPrivado || !menuUtilizadorPrivado) {
        return;
    }

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


// ===============================
// FUNÇÕES AUXILIARES
// ===============================

function preencherDadosLocalizacaoAssociada() {
    const selectLocalizacao = document.getElementById("localizacao");

    const campoEdificioLocalizacao = document.getElementById("edificioLocalizacao");
    const campoPisoLocalizacao = document.getElementById("pisoLocalizacao");
    const campoServicoLocalizacao = document.getElementById("servicoLocalizacao");
    const campoSalaLocalizacao = document.getElementById("salaLocalizacao");
    const campoObservacoesLocalizacao = document.getElementById("observacoesLocalizacao");

    if (!selectLocalizacao) {
        return;
    }

    function limparCamposLocalizacao() {
        if (campoEdificioLocalizacao) campoEdificioLocalizacao.value = "";
        if (campoPisoLocalizacao) campoPisoLocalizacao.value = "";
        if (campoServicoLocalizacao) campoServicoLocalizacao.value = "";
        if (campoSalaLocalizacao) campoSalaLocalizacao.value = "";
        if (campoObservacoesLocalizacao) campoObservacoesLocalizacao.value = "";
    }

    function atualizarCamposLocalizacao() {
        const codigoLocalizacao = selectLocalizacao.value;
        const localizacao = localizacoesGuardadas[codigoLocalizacao];

        if (!localizacao) {
            limparCamposLocalizacao();
            return;
        }

        if (campoEdificioLocalizacao) campoEdificioLocalizacao.value = localizacao.edificio || "";
        if (campoPisoLocalizacao) campoPisoLocalizacao.value = localizacao.piso || "";
        if (campoServicoLocalizacao) campoServicoLocalizacao.value = localizacao.servico || "";
        if (campoSalaLocalizacao) campoSalaLocalizacao.value = localizacao.sala || "";
        if (campoObservacoesLocalizacao) {
            campoObservacoesLocalizacao.value =
                localizacao.observacoes || "";
        }
    }

    selectLocalizacao.addEventListener("change", atualizarCamposLocalizacao);
    atualizarCamposLocalizacao();
}

function preencherDadosFornecedorAssociado() {
    const selectFornecedor = document.getElementById("fornecedor");

    const campoNomeFornecedor = document.getElementById("nomeFornecedor");
    const campoNifFornecedor = document.getElementById("nifFornecedor");
    const campoTelefoneFornecedor = document.getElementById("telefoneFornecedor");
    const campoEmailFornecedor = document.getElementById("emailFornecedor");
    const campoWebsiteFornecedor = document.getElementById("websiteFornecedor");

    const campoMoradaFornecedorEquipamento = document.getElementById("moradaFornecedorEquipamento");
    const campoPessoaContactoFornecedor = document.getElementById("pessoaContactoFornecedor");
    const campoTelefonePessoaContactoFornecedor = document.getElementById("telefonePessoaContactoFornecedor");
    const campoTipoFornecedorEquipamento = document.getElementById("tipoFornecedorEquipamento");
    const campoObservacoesFornecedorEquipamento = document.getElementById("observacoesFornecedorEquipamento");

    if (!selectFornecedor) {
        return;
    }

    function limparCamposFornecedor() {
        if (campoNomeFornecedor) campoNomeFornecedor.value = "";
        if (campoNifFornecedor) campoNifFornecedor.value = "";
        if (campoTelefoneFornecedor) campoTelefoneFornecedor.value = "";
        if (campoEmailFornecedor) campoEmailFornecedor.value = "";
        if (campoWebsiteFornecedor) campoWebsiteFornecedor.value = "";

        if (campoMoradaFornecedorEquipamento) campoMoradaFornecedorEquipamento.value = "";
        if (campoPessoaContactoFornecedor) campoPessoaContactoFornecedor.value = "";
        if (campoTelefonePessoaContactoFornecedor) campoTelefonePessoaContactoFornecedor.value = "";
        if (campoTipoFornecedorEquipamento) campoTipoFornecedorEquipamento.value = "";
        if (campoObservacoesFornecedorEquipamento) campoObservacoesFornecedorEquipamento.value = "";
    }

    function atualizarCamposFornecedor() {
        const codigoFornecedor = selectFornecedor.value;
        const fornecedor = fornecedoresGuardados[codigoFornecedor];

        if (!fornecedor) {
            limparCamposFornecedor();
            return;
        }

        if (campoNomeFornecedor) campoNomeFornecedor.value = fornecedor.nomeEmpresa || "";
        if (campoNifFornecedor) campoNifFornecedor.value = fornecedor.nif || "";
        if (campoTelefoneFornecedor) campoTelefoneFornecedor.value = fornecedor.telefone || "";
        if (campoEmailFornecedor) campoEmailFornecedor.value = fornecedor.email || "";
        if (campoWebsiteFornecedor) campoWebsiteFornecedor.value = fornecedor.website || "";

        if (campoMoradaFornecedorEquipamento)
            campoMoradaFornecedorEquipamento.value = "";

        if (campoPessoaContactoFornecedor)
            campoPessoaContactoFornecedor.value = "";

        if (campoTelefonePessoaContactoFornecedor)
            campoTelefonePessoaContactoFornecedor.value = "";

        if (campoTipoFornecedorEquipamento)
            campoTipoFornecedorEquipamento.value = "";

        if (campoObservacoesFornecedorEquipamento) {
            campoObservacoesFornecedorEquipamento.value =
                fornecedor.observacoes || "";
        }
    }

    selectFornecedor.addEventListener("change", atualizarCamposFornecedor);

    atualizarCamposFornecedor();
}

function preencherDadosDocumentacaoAssociada() {

    const selectDocumentacao =
        document.getElementById("documentacaoAssociada");

    const campoObservacoesDocumentacao =
        document.getElementById("observacoesDocumentacaoEquipamento");

    if (!selectDocumentacao || !campoObservacoesDocumentacao) {
        return;
    }

    function atualizarObservacoesDocumentacao() {

        const documentosSelecionados =
            Array.from(selectDocumentacao.selectedOptions);

        let observacoesAutomaticas = "";

        documentosSelecionados.forEach(function (option) {

            const codigoDocumento = option.value;

            const documentacao =
                documentacaoGuardada[codigoDocumento];

            if (!documentacao) {
                return;
            }

            if (documentacao.observacoes) {

                observacoesAutomaticas +=
                    `${codigoDocumento}: ${documentacao.observacoes}\n\n`;
            }
        });

        const observacoesAtuais =
            campoObservacoesDocumentacao.value.trim();

        campoObservacoesDocumentacao.value =
            observacoesAutomaticas.trim();
    }

    selectDocumentacao.addEventListener(
        "change",
        atualizarObservacoesDocumentacao
    );

    atualizarObservacoesDocumentacao();
}

function obterEquipamentosPorFornecedor(codigoFornecedor) {
    return Object.values(equipamentosGuardados).filter(function (equipamento) {
        return equipamento.fornecedor === codigoFornecedor;
    });
}

function obterEquipamentosPorLocalizacao(codigoLocalizacao) {
    return Object.values(equipamentosGuardados).filter(function (equipamento) {
        return equipamento.localizacao === codigoLocalizacao;
    });
}

function preencherSelectFornecedores(idSelect, fornecedorSelecionado = "", opcional = false) {
    const selectFornecedor = document.getElementById(idSelect);

    if (!selectFornecedor) {
        return;
    }

    if (opcional) {
        selectFornecedor.innerHTML = '<option value="">Sem fornecedor associado</option>';
    } else {
        selectFornecedor.innerHTML = '<option value="" selected disabled>Escolha um fornecedor</option>';
    }

    Object.values(fornecedoresGuardados).forEach(function (fornecedor) {
        const option = document.createElement("option");

        option.value = fornecedor.codigo;
        option.textContent = fornecedor.codigo;

        if (fornecedor.codigo === fornecedorSelecionado) {
            option.selected = true;
        }

        selectFornecedor.appendChild(option);
    });
}

function preencherSelectEquipamentos(idSelect, equipamentoSelecionado = "") {
    const selectEquipamento = document.getElementById(idSelect);

    if (!selectEquipamento) {
        return;
    }

    selectEquipamento.innerHTML = '<option value="" selected disabled>Escolha um equipamento</option>';

    Object.values(equipamentosGuardados).forEach(function (equipamento) {
        const option = document.createElement("option");

        option.value = equipamento.codigo;
        option.textContent = equipamento.codigo;

        if (equipamento.codigo === equipamentoSelecionado) {
            option.selected = true;
        }

        selectEquipamento.appendChild(option);
    });
}

function preencherSelectLocalizacoes(idSelect, localizacaoSelecionada = "") {
    const selectLocalizacao = document.getElementById(idSelect);

    if (!selectLocalizacao) {
        return;
    }

    selectLocalizacao.innerHTML = '<option value="" selected disabled>Escolha uma localização</option>';

    if (localizacaoSelecionada && !localizacoesGuardadas[localizacaoSelecionada]) {
        const optionEliminada = document.createElement("option");

        optionEliminada.value = localizacaoSelecionada;
        optionEliminada.textContent = localizacaoSelecionada;
        optionEliminada.selected = true;

        selectLocalizacao.appendChild(optionEliminada);
    }

    Object.values(localizacoesGuardadas).forEach(function (localizacao) {
        const option = document.createElement("option");

        option.value = localizacao.codigo;
        option.textContent = localizacao.codigo;

        if (localizacao.codigo === localizacaoSelecionada) {
            option.selected = true;
        }

        selectLocalizacao.appendChild(option);
    });
}

function preencherSelectDocumentacao(idSelect, documentacaoSelecionada = [], opcional = true) {
    const selectDocumentacao = document.getElementById(idSelect);

    if (!selectDocumentacao) {
        return;
    }

    selectDocumentacao.innerHTML = "";

    Object.values(documentacaoGuardada).forEach(function (documentacao) {
        const option = document.createElement("option");

        option.value = documentacao.codigo;
        option.textContent = documentacao.codigo + " - " + documentacao.nomeDocumentacao;

        if (Array.isArray(documentacaoSelecionada) && documentacaoSelecionada.includes(documentacao.codigo)) {
            option.selected = true;
        }

        selectDocumentacao.appendChild(option);
    });
}

function converterTextoParaData(dataTexto) {
    if (!dataTexto) {
        return null;
    }

    const partes = dataTexto.split("/");

    if (partes.length !== 3) {
        return null;
    }

    return new Date(partes[2], partes[1] - 1, partes[0]);
}

function formatarData(data) {
    if (!data) {
        return "";
    }

    return data.toLocaleDateString("pt-PT");
}

function converterDataParaInput(dataTexto) {
    if (!dataTexto) {
        return "";
    }

    const partes = dataTexto.split("/");

    if (partes.length !== 3) {
        return "";
    }

    return `${partes[2]}-${partes[1]}-${partes[0]}`;
}


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


function limparCusto(custoTexto) {
    if (!custoTexto) {
        return "";
    }

    return custoTexto.replace("€", "").trim();
}

function controlarCamposContratoManutencao() {
    const contratoManutencao = document.getElementById("contratoManutencao");
    const tipoContrato = document.getElementById("tipoContrato");
    const entidadeResponsavelContrato = document.getElementById("entidadeResponsavelContrato");
    const periodicidadeContrato = document.getElementById("periodicidadeContrato");

    if (!contratoManutencao || !tipoContrato || !entidadeResponsavelContrato || !periodicidadeContrato) {
        return;
    }

    const opcaoNaoAplicavel = periodicidadeContrato.querySelector('option[value="Não aplicável"]');

    function atualizarCamposContrato() {
        if (contratoManutencao.value === "Não") {
            tipoContrato.value = "Não existe";
            entidadeResponsavelContrato.value = "Não existe";
            periodicidadeContrato.value = "Não aplicável";

            tipoContrato.disabled = true;
            entidadeResponsavelContrato.disabled = true;
            periodicidadeContrato.disabled = true;

            if (opcaoNaoAplicavel) {
                opcaoNaoAplicavel.hidden = false;
            }

        } else if (contratoManutencao.value === "Sim") {
            if (tipoContrato.value === "Não existe") {
                tipoContrato.value = "";
            }

            if (entidadeResponsavelContrato.value === "Não existe") {
                entidadeResponsavelContrato.value = "";
            }

            if (periodicidadeContrato.value === "Não aplicável") {
                periodicidadeContrato.value = "";
            }

            tipoContrato.disabled = false;
            entidadeResponsavelContrato.disabled = false;
            periodicidadeContrato.disabled = false;

            if (opcaoNaoAplicavel) {
                opcaoNaoAplicavel.hidden = true;
            }

        } else {
            tipoContrato.value = "";
            entidadeResponsavelContrato.value = "";
            periodicidadeContrato.value = "";

            tipoContrato.disabled = false;
            entidadeResponsavelContrato.disabled = false;
            periodicidadeContrato.disabled = false;

            if (opcaoNaoAplicavel) {
                opcaoNaoAplicavel.hidden = true;
            }
        }
    }

    contratoManutencao.addEventListener("change", atualizarCamposContrato);
    atualizarCamposContrato();
}

function contarPorCampo(lista, campo) {
    const contagem = {};

    lista.forEach(function (item) {
        const valor = item[campo] || "Não definido";

        if (!contagem[valor]) {
            contagem[valor] = 0;
        }

        contagem[valor]++;
    });

    return contagem;
}

function preencherGraficoServicosDashboard(equipamentos, localizacoes) {
    const container = document.getElementById("graficoServicosDashboard");

    if (!container) {
        return;
    }

    const contagemServicos = {};

    equipamentos.forEach(function (equipamento) {
        const localizacao = localizacoes[equipamento.localizacao];
        const servico = localizacao ? localizacao.servico : "Não definido";

        if (!contagemServicos[servico]) {
            contagemServicos[servico] = 0;
        }

        contagemServicos[servico]++;
    });

    const servicos = Object.entries(contagemServicos)
        .sort(function (a, b) {
            return b[1] - a[1];
        })
        .slice(0, 7);

    const maximo = servicos.length > 0 ? servicos[0][1] : 1;

    container.innerHTML = "";

    if (servicos.length === 0) {
        container.innerHTML = "<p>Sem dados de serviços.</p>";
        return;
    }

    servicos.forEach(function ([servico, valor]) {
        const altura = (valor / maximo) * 150;

        container.innerHTML += `
            <div class="barra-servico-dashboard">
                <span class="valor">${valor}</span>
                <div class="barra" style="height: ${altura}px;"></div>
                <span class="label">${servico}</span>
            </div>
        `;
    });
}

function preencherDistribuicaoCategoriasDashboard(equipamentos) {
    const container = document.getElementById("categoriasDashboard");

    if (!container) {
        return;
    }

    const contagem = contarPorCampo(equipamentos, "categoria");
    const total = equipamentos.length || 1;

    container.innerHTML = "";

    Object.entries(contagem).forEach(function ([categoria, valor]) {
        const percentagem = Math.round((valor / total) * 100);

        container.innerHTML += `
            <div class="item-distribuicao-dashboard">
                <span class="nome">${categoria}</span>
                <span class="valor">${valor} (${percentagem}%)</span>
                <div class="barra-distribuicao-dashboard">
                    <span style="width: ${percentagem}%;"></span>
                </div>
            </div>
        `;
    });
}

function preencherTabelaGarantiasDashboard(equipamentos, fornecedores) {
    const tabela = document.getElementById("tabelaGarantiasDashboard");

    if (!tabela) {
        return;
    }

    const hoje = new Date();
    hoje.setHours(0, 0, 0, 0);

    const limite = new Date();
    limite.setDate(hoje.getDate() + 30);
    limite.setHours(0, 0, 0, 0);

    const garantias = equipamentos.filter(function (equipamento) {
        if (!equipamento.dataFimGarantia) {
            return false;
        }

        const dataFim = converterTextoParaData(equipamento.dataFimGarantia);

        if (!dataFim) {
            return false;
        }

        dataFim.setHours(0, 0, 0, 0);

        return dataFim >= hoje && dataFim <= limite;
    }).sort(function (a, b) {
        return converterTextoParaData(a.dataFimGarantia) - converterTextoParaData(b.dataFimGarantia);
    });

    tabela.innerHTML = "";

    if (garantias.length === 0) {
        tabela.innerHTML = `
            <tr>
                <td colspan="5" class="text-center">Nenhuma garantia a expirar nos próximos 30 dias.</td>
            </tr>
        `;
        return;
    }

    garantias.forEach(function (equipamento) {
        const fornecedor = fornecedores[equipamento.fornecedor];
        const nomeFornecedor = fornecedor ? fornecedor.nomeEmpresa : equipamento.fornecedor;

        const dataFim = converterTextoParaData(equipamento.dataFimGarantia);
        const diasRestantes = Math.ceil((dataFim - hoje) / (1000 * 60 * 60 * 24));

        tabela.innerHTML += `
            <tr>
                <td>${equipamento.codigo}</td>
                <td>${equipamento.designacao}</td>
                <td>${nomeFornecedor || "Não definido"}</td>
                <td>${formatarData(dataFim)}</td>
                <td>${diasRestantes}</td>
            </tr>
        `;
    });
}

function preencherCriticidadeElevadaDashboard(equipamentos) {
    const numero = document.getElementById("dashboardCriticidadeElevada");
    const percentagemTexto = document.getElementById("dashboardPercentagemCriticidade");

    if (!numero || !percentagemTexto) {
        return;
    }

    const total = equipamentos.length || 1;

    const criticidadeElevada = equipamentos.filter(function (equipamento) {
        return equipamento.criticidade === "Alta" ||
            equipamento.criticidade === "Suporte de vida";
    }).length;

    console.log(equipamentos);
    console.log(criticidadeElevada);

    const percentagem = Math.round((criticidadeElevada / total) * 100);

    equipamentos.forEach(function (equipamento) {
        console.log(
            equipamento.codigo,
            equipamento.categoria,
            equipamento.criticidade
        );
    });

    numero.textContent = criticidadeElevada;
    percentagemTexto.textContent = percentagem + "% do total";
}

function preencherSuporteVidaDashboard(equipamentos, localizacoes) {
    const container = document.getElementById("suporteVidaDashboard");

    if (!container) {
        return;
    }

    const contagem = {};

    equipamentos.forEach(function (equipamento) {
        if (equipamento.categoria !== "Suporte de vida") {
            return;
        }

        const localizacao = localizacoes[equipamento.localizacao];
        const servico = localizacao ? localizacao.servico : "Não definido";

        if (!contagem[servico]) {
            contagem[servico] = 0;
        }

        contagem[servico]++;
    });

    const servicos = Object.entries(contagem)
        .sort(function (a, b) {
            return b[1] - a[1];
        });

    const maximo = servicos.length > 0 ? servicos[0][1] : 1;

    container.innerHTML = "";

    if (servicos.length === 0) {
        container.innerHTML = "<p>Sem equipamentos de suporte de vida registados.</p>";
        return;
    }

    servicos.forEach(function ([servico, valor]) {

        const largura = (valor / maximo) * 100;

        container.innerHTML += `
        <div class="linha-horizontal-dashboard">
            <span>${servico}</span>

            <div class="barra-horizontal"
                 style="width: ${largura}%;">
            </div>

            <strong>${valor}</strong>
        </div>
    `;
    });
}

function inicializarTabsEquipamento() {
    const botoesTabs = document.querySelectorAll(".botao-tab-equipamento");
    const conteudosTabs = document.querySelectorAll(".conteudo-tab-equipamento");

    if (botoesTabs.length === 0 || conteudosTabs.length === 0) {
        return;
    }

    botoesTabs.forEach(function (botao) {
        botao.addEventListener("click", function () {

            if (botao.classList.contains("bloqueado")) {
                return;
            }

            const tabDestino = botao.getAttribute("data-tab");

            botoesTabs.forEach(function (botaoAtual) {
                botaoAtual.classList.remove("ativo");
            });

            conteudosTabs.forEach(function (conteudoAtual) {
                conteudoAtual.classList.remove("ativo");
            });

            botao.classList.add("ativo");

            const conteudoSelecionado = document.getElementById(tabDestino);

            if (conteudoSelecionado) {
                conteudoSelecionado.classList.add("ativo");
            }
        });
    });
}

function inicializarBotaoSeguinteEquipamento() {
    const botaoSeguinte = document.getElementById("botaoPaginaSeguinteEquipamento");

    if (!botaoSeguinte) {
        return;
    }

    botaoSeguinte.addEventListener("click", function () {
        const tabEquipamento = document.querySelector('[data-tab="tab-novo-equipamento"]');
        const tabFornecedor = document.querySelector('[data-tab="tab-novo-fornecedor"]');

        const conteudoFornecedor = document.getElementById("tab-novo-fornecedor");

        const botoesTabs = document.querySelectorAll(".botao-tab-equipamento");
        const conteudosTabs = document.querySelectorAll(".conteudo-tab-equipamento");

        if (!tabFornecedor || !conteudoFornecedor) {
            return;
        }

        tabFornecedor.classList.remove("bloqueado");
        tabFornecedor.disabled = false;

        if (tabEquipamento) {
            tabEquipamento.classList.add("bloqueado");
            tabEquipamento.disabled = true;
        }

        botoesTabs.forEach(function (botao) {
            botao.classList.remove("ativo");
        });

        conteudosTabs.forEach(function (conteudo) {
            conteudo.classList.remove("ativo");
        });

        tabFornecedor.classList.add("ativo");
        conteudoFornecedor.classList.add("ativo");
    });
}


function inicializarBotaoAnteriorEquipamento() {
    const botaoAnteriorFornecedor = document.getElementById("botaoPaginaAnteriorFornecedor");
    const botaoSeguinteFornecedor = document.getElementById("botaoPaginaSeguinteFornecedor");

    const botaoAnteriorLocalizacao = document.getElementById("botaoPaginaAnteriorLocalizacao");
    const botaoSeguinteLocalizacao = document.getElementById("botaoPaginaSeguinteLocalizacao");

    const botaoAnteriorDocumentacao = document.getElementById("botaoPaginaAnteriorDocumentacao");
    const botaoSeguinteDocumentacao = document.getElementById("botaoPaginaSeguinteDocumentacao");

    const botaoAnteriorGarantia = document.getElementById("botaoPaginaAnteriorGarantia");

    const botoesTabs = document.querySelectorAll(".botao-tab-equipamento");
    const conteudosTabs = document.querySelectorAll(".conteudo-tab-equipamento");

    function mostrarTab(idTab) {
        const botaoTab = document.querySelector(`[data-tab="${idTab}"]`);
        const conteudoTab = document.getElementById(idTab);

        if (!botaoTab || !conteudoTab) {
            return;
        }

        botoesTabs.forEach(function (botao) {
            botao.classList.remove("ativo");
        });

        conteudosTabs.forEach(function (conteudo) {
            conteudo.classList.remove("ativo");
        });

        botaoTab.classList.remove("bloqueado");
        botaoTab.disabled = false;

        botaoTab.classList.add("ativo");
        conteudoTab.classList.add("ativo");
    }

    if (botaoAnteriorFornecedor) {
        botaoAnteriorFornecedor.addEventListener("click", function () {
            mostrarTab("tab-novo-equipamento");

            const tabFornecedor = document.querySelector('[data-tab="tab-novo-fornecedor"]');

            if (tabFornecedor) {
                tabFornecedor.classList.add("bloqueado");
                tabFornecedor.disabled = true;
            }
        });
    }

    if (botaoSeguinteFornecedor) {
        botaoSeguinteFornecedor.addEventListener("click", function () {
            mostrarTab("tab-nova-localizacao");

            const tabFornecedor = document.querySelector('[data-tab="tab-novo-fornecedor"]');

            if (tabFornecedor) {
                tabFornecedor.classList.add("bloqueado");
                tabFornecedor.disabled = true;
            }
        });
    }

    if (botaoAnteriorLocalizacao) {
        botaoAnteriorLocalizacao.addEventListener("click", function () {
            mostrarTab("tab-novo-fornecedor");

            const tabLocalizacao = document.querySelector('[data-tab="tab-nova-localizacao"]');

            if (tabLocalizacao) {
                tabLocalizacao.classList.add("bloqueado");
                tabLocalizacao.disabled = true;
            }
        });
    }

    if (botaoSeguinteLocalizacao) {
        botaoSeguinteLocalizacao.addEventListener("click", function () {
            mostrarTab("tab-nova-documentacao");

            const tabLocalizacao = document.querySelector('[data-tab="tab-nova-localizacao"]');

            if (tabLocalizacao) {
                tabLocalizacao.classList.add("bloqueado");
                tabLocalizacao.disabled = true;
            }
        });
    }

    if (botaoAnteriorDocumentacao) {
        botaoAnteriorDocumentacao.addEventListener("click", function () {
            mostrarTab("tab-nova-localizacao");

            const tabDocumentacao = document.querySelector('[data-tab="tab-nova-documentacao"]');

            if (tabDocumentacao) {
                tabDocumentacao.classList.add("bloqueado");
                tabDocumentacao.disabled = true;
            }
        });
    }

    if (botaoSeguinteDocumentacao) {
        botaoSeguinteDocumentacao.addEventListener("click", function () {
            mostrarTab("tab-nova-garantia");

            const tabDocumentacao = document.querySelector('[data-tab="tab-nova-documentacao"]');

            if (tabDocumentacao) {
                tabDocumentacao.classList.add("bloqueado");
                tabDocumentacao.disabled = true;
            }
        });
    }

    if (botaoAnteriorGarantia) {
        botaoAnteriorGarantia.addEventListener("click", function () {
            mostrarTab("tab-nova-documentacao");

            const tabGarantia = document.querySelector('[data-tab="tab-nova-garantia"]');

            if (tabGarantia) {
                tabGarantia.classList.add("bloqueado");
                tabGarantia.disabled = true;
            }
        });
    }
}

// ===============================
// INICIALIZAÇÃO GERAL
// ===============================

document.addEventListener("DOMContentLoaded", function () {
    inicializarContactos();
    inicializarLogin();
    inicializarGestaoConteudos();

    preencherListagemEquipamentos();
    inicializarFiltrosEquipamentos();
    inicializarDashboard();
    preencherDetalhesEquipamento();
    inicializarTabsEquipamento();
    inicializarBotaoSeguinteEquipamento();
    inicializarBotaoAnteriorEquipamento();
    inicializarNovoEquipamento();
    inicializarEditarEquipamento();
    controlarCamposContratoManutencao();

    preencherListagemLocalizacoes();
    inicializarFiltrosLocalizacoes();
    preencherDetalhesLocalizacao();
    inicializarNovaLocalizacao();
    inicializarEditarLocalizacao();

    preencherListagemFornecedores();
    inicializarFiltrosFornecedores();
    preencherDetalhesFornecedor();
    inicializarNovoFornecedor();
    inicializarEditarFornecedor();

    preencherListagemDocumentacao();
    inicializarFiltrosDocumentacoes();
    preencherDetalhesDocumentacao();
    inicializarNovaDocumentacao();
    inicializarEditarDocumentacao();

    inicializarDropdownUtilizador();
});