// ===============================
// CONTACTOS
// ===============================

function inicializarContactos() {
    const formulario = document.querySelector(".form-contactos");
    const mensagemContactos = document.getElementById("mensagem-contactos");

    if (!formulario) {
        return;
    }

    formulario.addEventListener("submit", function (event) {
        event.preventDefault();

        if (mensagemContactos) {
            mensagemContactos.textContent = "Mensagem enviada com sucesso.";
            mensagemContactos.className = "mensagem-contactos sucesso";
        }

        formulario.reset();
    });
}


// ===============================
// LOGIN
// ===============================

function inicializarLogin() {
    const formularioLogin = document.querySelector(".form-login");
    const mensagemLogin = document.getElementById("mensagem-login");

    if (!formularioLogin) {
        return;
    }

    formularioLogin.addEventListener("submit", function (event) {
        event.preventDefault();

        if (mensagemLogin) {
            mensagemLogin.textContent = "Início de sessão efetuado com sucesso.";
            mensagemLogin.className = "mensagem-login sucesso";
        }

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
    const mensagemGestao = document.getElementById("mensagem-gestao");
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

        if (mensagemGestao) {
            mensagemGestao.textContent = "Conteúdos guardados com sucesso.";
            mensagemGestao.className = "mensagem-login sucesso mt-4";
        }
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

            if (mensagemGestao) {
                mensagemGestao.textContent = "Conteúdos originais repostos com sucesso.";
                mensagemGestao.className = "mensagem-login sucesso mt-4";
            }
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
        fabricante: "Philips Healthcare",
        anoFabrico: "2021",
        dataAquisicao: "12/03/2022",
        custoAquisicao: "8500 €",
        tipoEntrada: "Compra",
        estado: "Operacional",
        criticidade: "Alta",
        localizacao: "Unidade de Cuidados Intensivos",
        observacoes: "Equipamento utilizado para monitorização contínua de sinais vitais em doentes críticos."
    },

    EQ002: {
        codigo: "EQ002",
        designacao: "Ventilador pulmonar",
        categoria: "Suporte de vida",
        marca: "Dräger",
        modelo: "Evita V600",
        numeroSerie: "DR-EV600-2020-014",
        fabricante: "Dräger Medical",
        anoFabrico: "2020",
        dataAquisicao: "08/09/2021",
        custoAquisicao: "23500 €",
        tipoEntrada: "Compra",
        estado: "Em manutenção",
        criticidade: "Crítica",
        localizacao: "Unidade de Cuidados Intensivos",
        observacoes: "Equipamento em manutenção preventiva programada."
    },

    EQ003: {
        codigo: "EQ003",
        designacao: "Bomba de infusão",
        categoria: "Terapêutica",
        marca: "B. Braun",
        modelo: "Infusomat Space",
        numeroSerie: "BB-INF-2019-033",
        fabricante: "B. Braun Medical",
        anoFabrico: "2019",
        dataAquisicao: "21/01/2020",
        custoAquisicao: "3200 €",
        tipoEntrada: "Compra",
        estado: "Operacional",
        criticidade: "Média",
        localizacao: "Serviço de Medicina",
        observacoes: "Utilizada para administração controlada de terapêutica intravenosa."
    },

    EQ004: {
        codigo: "EQ004",
        designacao: "Desfibrilhador",
        categoria: "Emergência",
        marca: "Zoll",
        modelo: "R Series",
        numeroSerie: "ZL-RS-2022-007",
        fabricante: "Zoll Medical",
        anoFabrico: "2022",
        dataAquisicao: "15/06/2022",
        custoAquisicao: "12400 €",
        tipoEntrada: "Compra",
        estado: "Operacional",
        criticidade: "Crítica",
        localizacao: "Urgência",
        observacoes: "Equipamento essencial para resposta rápida em situações de paragem cardiorrespiratória."
    }
};

let equipamentosGuardados = JSON.parse(localStorage.getItem("equipamentosGuardados"));

if (!equipamentosGuardados) {
    equipamentosGuardados = equipamentosConsulta;
    localStorage.setItem("equipamentosGuardados", JSON.stringify(equipamentosGuardados));
}


function preencherListagemEquipamentos() {
    const tabelaEquipamentos = document.getElementById("tabela-equipamentos");

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
                <a href="consultar_equipamento.html?id=${equipamento.codigo}" class="acao-tabela-privada">
                    <i class="fa-regular fa-eye"></i>
                    Consultar
                </a>

                <a href="editar_equipamento.html?id=${equipamento.codigo}" class="acao-tabela-privada">
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


function inicializarNovoEquipamento() {
    const formularioNovoEquipamento = document.getElementById("form-novo-equipamento");
    const mensagemSucessoEquipamento = document.getElementById("mensagemSucessoEquipamento");

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
            if (mensagemSucessoEquipamento) {
                mensagemSucessoEquipamento.style.display = "block";
                mensagemSucessoEquipamento.textContent = "Já existe um equipamento com esse código.";
                mensagemSucessoEquipamento.classList.remove("sucesso");
                mensagemSucessoEquipamento.classList.add("erro");
            }

            return;
        }

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
            localizacao: document.getElementById("localizacao") ? document.getElementById("localizacao").value.trim() : "",
            observacoes: document.getElementById("observacoes").value.trim()
        };

        equipamentosGuardados[codigo] = novoEquipamento;

        localStorage.setItem("equipamentosGuardados", JSON.stringify(equipamentosGuardados));

        if (mensagemSucessoEquipamento) {
            mensagemSucessoEquipamento.style.display = "block";
            mensagemSucessoEquipamento.textContent = "Equipamento adicionado com sucesso.";
            mensagemSucessoEquipamento.classList.remove("erro");
            mensagemSucessoEquipamento.classList.add("sucesso");
        }

        setTimeout(function () {
            window.location.href = "equipamentos.html";
        }, 800);
    });

    formularioNovoEquipamento.addEventListener("input", function () {
        if (mensagemSucessoEquipamento) {
            mensagemSucessoEquipamento.style.display = "none";
        }
    });

    formularioNovoEquipamento.addEventListener("change", function () {
        if (mensagemSucessoEquipamento) {
            mensagemSucessoEquipamento.style.display = "none";
        }
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
    document.getElementById("detalhe-criticidade").textContent = equipamento.criticidade;

    const detalheLocalizacao = document.getElementById("detalhe-localizacao");
    if (detalheLocalizacao) {
        detalheLocalizacao.textContent = equipamento.localizacao;
    }

    document.getElementById("detalhe-observacoes").textContent = equipamento.observacoes;

    const botaoEditarEquipamento = document.getElementById("botao-editar-equipamento");

    if (botaoEditarEquipamento) {
        botaoEditarEquipamento.href = `editar_equipamento.html?id=${equipamento.codigo}`;
    }
}


function inicializarEditarEquipamento() {
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
    document.getElementById("data_aquisicao").value = converterDataParaInput(equipamento.dataAquisicao);
    document.getElementById("custo_aquisicao").value = limparCusto(equipamento.custoAquisicao);
    document.getElementById("tipo_entrada").value = equipamento.tipoEntrada;
    document.getElementById("estado").value = equipamento.estado;
    document.getElementById("criticidade").value = equipamento.criticidade;

    if (document.getElementById("localizacao")) {
        document.getElementById("localizacao").value = equipamento.localizacao;
    }

    document.getElementById("observacoes").value = equipamento.observacoes;

    const botaoCancelarEdicao = document.getElementById("botao-cancelar-edicao");

    if (botaoCancelarEdicao) {
        botaoCancelarEdicao.href = `consultar_equipamento.html?id=${equipamento.codigo}`;
    }

    formEditarEquipamento.addEventListener("submit", function (event) {
        event.preventDefault();

        equipamentosGuardados[idEquipamento].designacao = document.getElementById("designacao").value.trim();
        equipamentosGuardados[idEquipamento].categoria = document.getElementById("categoria").value.trim();
        equipamentosGuardados[idEquipamento].marca = document.getElementById("marca").value.trim();
        equipamentosGuardados[idEquipamento].modelo = document.getElementById("modelo").value.trim();
        equipamentosGuardados[idEquipamento].numeroSerie = document.getElementById("numero_serie").value.trim();
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

        equipamentosGuardados[idEquipamento].observacoes = document.getElementById("observacoes").value.trim();

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
}


function inicializarEliminarEquipamentos() {
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
        equipamentos: "Monitor multiparamétrico de sinais vitais",
        observacoes: "Área destinada à monitorização contínua de doentes críticos."
    },

    LOC002: {
        codigo: "LOC002",
        edificio: "Edifício Principal",
        piso: "Piso 2",
        servico: "Unidade de Cuidados Intensivos",
        sala: "Sala 2.11",
        equipamentos: "Ventilador pulmonar",
        observacoes: "Localização associada a equipamentos de suporte ventilatório."
    },

    LOC003: {
        codigo: "LOC003",
        edificio: "Edifício B",
        piso: "Piso 0",
        servico: "Serviço de Medicina",
        sala: "Gabinete 0.04",
        equipamentos: "Bomba de infusão",
        observacoes: "Localização utilizada para equipamentos de apoio à terapêutica intravenosa."
    },

    LOC004: {
        codigo: "LOC004",
        edificio: "Edifício Principal",
        piso: "Piso 1",
        servico: "Urgência",
        sala: "Sala 1.02",
        equipamentos: "Desfibrilhador",
        observacoes: "Localização destinada a equipamentos de resposta rápida."
    }
};

let localizacoesGuardadas = JSON.parse(localStorage.getItem("localizacoesGuardadas"));

if (!localizacoesGuardadas) {
    localizacoesGuardadas = localizacoesConsulta;
    localStorage.setItem("localizacoesGuardadas", JSON.stringify(localizacoesGuardadas));
}


function preencherListagemLocalizacoes() {
    const tabelaLocalizacoes = document.getElementById("tabela-localizacoes");

    if (!tabelaLocalizacoes) {
        return;
    }

    tabelaLocalizacoes.innerHTML = "";

    Object.values(localizacoesGuardadas).forEach(function (localizacao) {
        const linha = document.createElement("tr");

        linha.innerHTML = `
            <td>${localizacao.codigo}</td>
            <td>${localizacao.edificio}</td>
            <td>${localizacao.piso}</td>
            <td>${localizacao.servico}</td>
            <td>${localizacao.sala}</td>
            <td>${localizacao.equipamentos}</td>

            <td class="acoes-tabela-privada">
                <a href="consultar_localizacao.html?id=${localizacao.codigo}" class="acao-tabela-privada">
                    <i class="fa-regular fa-eye"></i>
                    Consultar
                </a>

                <a href="editar_localizacao.html?id=${localizacao.codigo}" class="acao-tabela-privada">
                    <i class="fa-regular fa-pen-to-square"></i>
                    Editar
                </a>

                <a href="#" class="acao-tabela-privada eliminar-localizacao" data-id="${localizacao.codigo}">
                    <i class="fa-regular fa-trash-can"></i>
                    Eliminar
                </a>
            </td>
        `;

        tabelaLocalizacoes.appendChild(linha);
    });
}


function inicializarNovaLocalizacao() {
    const formularioNovaLocalizacao = document.getElementById("form-nova-localizacao");
    const mensagemSucessoLocalizacao = document.getElementById("mensagemSucessoLocalizacao");

    if (!formularioNovaLocalizacao) {
        return;
    }

    formularioNovaLocalizacao.addEventListener("submit", function (event) {
        event.preventDefault();

        if (!formularioNovaLocalizacao.checkValidity()) {
            formularioNovaLocalizacao.reportValidity();
            return;
        }

        const codigo = document.getElementById("codigo").value.trim();

        if (localizacoesGuardadas[codigo]) {
            if (mensagemSucessoLocalizacao) {
                mensagemSucessoLocalizacao.style.display = "block";
                mensagemSucessoLocalizacao.textContent = "Já existe uma localização com esse código.";
                mensagemSucessoLocalizacao.classList.remove("sucesso");
                mensagemSucessoLocalizacao.classList.add("erro");
            }

            return;
        }

        const novaLocalizacao = {
            codigo: codigo,
            edificio: document.getElementById("edificio").value.trim(),
            piso: document.getElementById("piso").value.trim(),
            servico: document.getElementById("servico").value.trim(),
            sala: document.getElementById("sala").value.trim(),
            equipamentos: document.getElementById("equipamentos").value.trim(),
            observacoes: document.getElementById("observacoes").value.trim()
        };

        localizacoesGuardadas[codigo] = novaLocalizacao;

        localStorage.setItem("localizacoesGuardadas", JSON.stringify(localizacoesGuardadas));

        if (mensagemSucessoLocalizacao) {
            mensagemSucessoLocalizacao.style.display = "block";
            mensagemSucessoLocalizacao.textContent = "Localização adicionada com sucesso.";
            mensagemSucessoLocalizacao.classList.remove("erro");
            mensagemSucessoLocalizacao.classList.add("sucesso");
        }

        setTimeout(function () {
            window.location.href = "localizacoes.html";
        }, 800);
    });

    formularioNovaLocalizacao.addEventListener("input", function () {
        if (mensagemSucessoLocalizacao) {
            mensagemSucessoLocalizacao.style.display = "none";
        }
    });

    formularioNovaLocalizacao.addEventListener("change", function () {
        if (mensagemSucessoLocalizacao) {
            mensagemSucessoLocalizacao.style.display = "none";
        }
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
    document.getElementById("detalhe-equipamentos").textContent = localizacao.equipamentos;
    document.getElementById("detalhe-observacoes-localizacao").textContent = localizacao.observacoes;

    const botaoEditarLocalizacao = document.getElementById("botao-editar-localizacao");

    if (botaoEditarLocalizacao) {
        botaoEditarLocalizacao.href = `editar_localizacao.html?id=${localizacao.codigo}`;
    }
}


function inicializarEditarLocalizacao() {
    const formEditarLocalizacao = document.getElementById("form-editar-localizacao");

    if (!formEditarLocalizacao) {
        return;
    }

    const parametros = new URLSearchParams(window.location.search);
    const idLocalizacao = parametros.get("id");

    const localizacao = localizacoesGuardadas[idLocalizacao];
    const mensagemEditarLocalizacao = document.getElementById("mensagem-editar-localizacao");

    if (!localizacao) {
        if (mensagemEditarLocalizacao) {
            mensagemEditarLocalizacao.textContent = "Localização não encontrada.";
            mensagemEditarLocalizacao.classList.add("erro");
        }

        return;
    }

    document.getElementById("codigo").value = localizacao.codigo;
    document.getElementById("edificio").value = localizacao.edificio;
    document.getElementById("piso").value = localizacao.piso;
    document.getElementById("servico").value = localizacao.servico;
    document.getElementById("sala").value = localizacao.sala;
    document.getElementById("equipamentos").value = localizacao.equipamentos;
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
        localizacoesGuardadas[idLocalizacao].equipamentos = document.getElementById("equipamentos").value.trim();
        localizacoesGuardadas[idLocalizacao].observacoes = document.getElementById("observacoes").value.trim();

        localStorage.setItem("localizacoesGuardadas", JSON.stringify(localizacoesGuardadas));

        if (mensagemEditarLocalizacao) {
            mensagemEditarLocalizacao.textContent = "Alterações guardadas com sucesso.";
            mensagemEditarLocalizacao.classList.remove("erro");
            mensagemEditarLocalizacao.classList.add("sucesso");
        }

        setTimeout(function () {
            window.location.href = `consultar_localizacao.html?id=${idLocalizacao}`;
        }, 800);
    });
}


function inicializarEliminarLocalizacoes() {
    document.addEventListener("click", function (event) {
        const botaoEliminarLocalizacao = event.target.closest(".eliminar-localizacao");

        if (!botaoEliminarLocalizacao) {
            return;
        }

        event.preventDefault();

        const idLocalizacao = botaoEliminarLocalizacao.getAttribute("data-id");

        const confirmar = confirm("Tem a certeza que pretende eliminar esta localização?");

        if (!confirmar) {
            return;
        }

        delete localizacoesGuardadas[idLocalizacao];

        localStorage.setItem("localizacoesGuardadas", JSON.stringify(localizacoesGuardadas));

        preencherListagemLocalizacoes();
    });
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
        website: "www.philips.pt/healthcare",
        pessoaContacto: "Ana Martins",
        telefonePessoaContacto: "+351 910 000 000",
        tipoFornecedor: "Fabricante",
        equipamentos: "Monitor multiparamétrico de sinais vitais",
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
        equipamentos: "Ventilador pulmonar",
        observacoes: "Fabricante associado a equipamentos de suporte ventilatório."
    },

    FOR003: {
        codigo: "FOR003",
        nomeEmpresa: "MedSupply Portugal",
        nif: "503456789",
        telefone: "+351 930 248 308",
        email: "contacto@medsupply.pt",
        morada: "Aveiro, Portugal",
        website: "www.medsupply.pt",
        pessoaContacto: "Carla Ferreira",
        telefonePessoaContacto: "+351 930 000 000",
        tipoFornecedor: "Distribuidor ou Fornecedor comercial",
        equipamentos: "Bomba de infusão",
        observacoes: "Distribuidor comercial de equipamentos e consumíveis."
    },

    FOR004: {
        codigo: "FOR004",
        nomeEmpresa: "TecnoMed Assistência",
        nif: "504567890",
        telefone: "+351 930 656 375",
        email: "contacto@tecnomed.pt",
        morada: "Coimbra, Portugal",
        website: "www.tecnomed.pt",
        pessoaContacto: "João Almeida",
        telefonePessoaContacto: "+351 940 000 000",
        tipoFornecedor: "Fornecedor de assistência técnica",
        equipamentos: "Desfibrilhador",
        observacoes: "Empresa responsável por manutenção preventiva e corretiva."
    }
};

let fornecedoresGuardados = JSON.parse(localStorage.getItem("fornecedoresGuardados"));

if (!fornecedoresGuardados) {
    fornecedoresGuardados = fornecedoresConsulta;
    localStorage.setItem("fornecedoresGuardados", JSON.stringify(fornecedoresGuardados));
}


// Preencher listagem de fornecedores na página fornecedores.html
function preencherListagemFornecedores() {
    const tabelaFornecedores = document.getElementById("tabela-fornecedores");

    if (!tabelaFornecedores) {
        return;
    }

    tabelaFornecedores.innerHTML = "";

    Object.values(fornecedoresGuardados).forEach(function (fornecedor) {
        const linha = document.createElement("tr");

        linha.innerHTML = `
            <td>${fornecedor.codigo}</td>
            <td>${fornecedor.nomeEmpresa}</td>
            <td>${fornecedor.nif}</td>
            <td>${fornecedor.telefone}</td>
            <td>${fornecedor.email}</td>
            <td>${fornecedor.tipoFornecedor}</td>
            <td>${fornecedor.equipamentos}</td>

            <td class="acoes-tabela-privada">
                <a href="consultar_fornecedor.html?id=${fornecedor.codigo}" class="acao-tabela-privada">
                    <i class="fa-regular fa-eye"></i>
                    Consultar
                </a>

                <a href="editar_fornecedor.html?id=${fornecedor.codigo}" class="acao-tabela-privada">
                    <i class="fa-regular fa-pen-to-square"></i>
                    Editar
                </a>

                <a href="#" class="acao-tabela-privada eliminar-fornecedor" data-id="${fornecedor.codigo}">
                    <i class="fa-regular fa-trash-can"></i>
                    Eliminar
                </a>
            </td>
        `;

        tabelaFornecedores.appendChild(linha);
    });
}


// Adicionar novo fornecedor e guardar no localStorage
function inicializarNovoFornecedor() {
    const formularioNovoFornecedor = document.getElementById("form-novo-fornecedor");
    const mensagemSucessoFornecedor = document.getElementById("mensagemSucessoFornecedor");

    if (!formularioNovoFornecedor) {
        return;
    }

    formularioNovoFornecedor.addEventListener("submit", function (event) {
        event.preventDefault();

        if (!formularioNovoFornecedor.checkValidity()) {
            formularioNovoFornecedor.reportValidity();
            return;
        }

        const codigo = document.getElementById("codigo").value.trim();

        if (fornecedoresGuardados[codigo]) {
            if (mensagemSucessoFornecedor) {
                mensagemSucessoFornecedor.style.display = "block";
                mensagemSucessoFornecedor.textContent = "Já existe um fornecedor com esse código.";
                mensagemSucessoFornecedor.classList.remove("sucesso");
                mensagemSucessoFornecedor.classList.add("erro");
            }

            return;
        }

        const novoFornecedor = {
            codigo: codigo,
            nomeEmpresa: document.getElementById("nome_empresa").value.trim(),
            nif: document.getElementById("nif").value.trim(),
            telefone: document.getElementById("telefone").value.trim(),
            email: document.getElementById("email").value.trim(),
            morada: document.getElementById("morada").value.trim(),
            website: document.getElementById("website").value.trim(),
            pessoaContacto: document.getElementById("pessoa_contacto").value.trim(),
            telefonePessoaContacto: document.getElementById("telefone_pessoa_contacto").value.trim(),
            tipoFornecedor: document.getElementById("tipo_fornecedor").value.trim(),
            equipamentos: document.getElementById("equipamentos").value.trim(),
            observacoes: document.getElementById("observacoes").value.trim()
        };

        fornecedoresGuardados[codigo] = novoFornecedor;

        localStorage.setItem("fornecedoresGuardados", JSON.stringify(fornecedoresGuardados));

        if (mensagemSucessoFornecedor) {
            mensagemSucessoFornecedor.style.display = "block";
            mensagemSucessoFornecedor.textContent = "Fornecedor adicionado com sucesso.";
            mensagemSucessoFornecedor.classList.remove("erro");
            mensagemSucessoFornecedor.classList.add("sucesso");
        }

        setTimeout(function () {
            window.location.href = "fornecedores.html";
        }, 800);
    });

    formularioNovoFornecedor.addEventListener("input", function () {
        if (mensagemSucessoFornecedor) {
            mensagemSucessoFornecedor.style.display = "none";
        }
    });

    formularioNovoFornecedor.addEventListener("change", function () {
        if (mensagemSucessoFornecedor) {
            mensagemSucessoFornecedor.style.display = "none";
        }
    });
}

// Eliminar fornecedor da listagem
function inicializarEliminarFornecedores() {
    document.addEventListener("click", function (event) {
        const botaoEliminarFornecedor = event.target.closest(".eliminar-fornecedor");

        if (!botaoEliminarFornecedor) {
            return;
        }

        event.preventDefault();

        const idFornecedor = botaoEliminarFornecedor.getAttribute("data-id");

        const confirmar = confirm("Tem a certeza que pretende eliminar este fornecedor?");

        if (!confirmar) {
            return;
        }

        delete fornecedoresGuardados[idFornecedor];

        localStorage.setItem("fornecedoresGuardados", JSON.stringify(fornecedoresGuardados));

        preencherListagemFornecedores();
    });
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


// ===============================
// INICIALIZAÇÃO GERAL
// ===============================

document.addEventListener("DOMContentLoaded", function () {
    inicializarContactos();
    inicializarLogin();
    inicializarGestaoConteudos();

    preencherListagemEquipamentos();
    preencherDetalhesEquipamento();
    inicializarNovoEquipamento();
    inicializarEditarEquipamento();
    inicializarEliminarEquipamentos();

    preencherListagemLocalizacoes();
    preencherDetalhesLocalizacao();
    inicializarNovaLocalizacao();
    inicializarEditarLocalizacao();
    inicializarEliminarLocalizacoes();

    preencherListagemFornecedores();
    inicializarNovoFornecedor();
    inicializarEliminarFornecedores();

    inicializarDropdownUtilizador();
});