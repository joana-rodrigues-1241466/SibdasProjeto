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
        fabricante: "Philips Healthcare",
        anoFabrico: "2024",
        estado: "Ativo",
        criticidade: "Alta",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual IntelliVue MX450",
        dataManualTecnico: "10/03/2025",
        validadeManualTecnico: "10/03/2030",
        ficheiroManualTecnico: "manual_servico_EQ001.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização MX450",
        dataManualUtilizacao: "10/03/2025",
        validadeManualUtilizacao: "10/03/2030",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ001.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade MX450",
        dataDeclaracaoConformidade: "10/03/2025",
        validadeDeclaracaoConformidade: "10/03/2030",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ001.pdf",

        observacoes: "Equipamento utilizado para monitorização contínua de sinais vitais em doentes críticos.",

        acessorios: [
            { nome: "Cabo de ECG 5 derivações", referencia: "ACC-ECG-001", quantidade: "2", unidade: "unid", estado: "em-uso", observacoes: "" },
            { nome: "Sensor de SpO2 adulto", referencia: "ACC-SPO2-001", quantidade: "1", unidade: "unid", estado: "em-uso", observacoes: "" },
            { nome: "Manguito de pressão arterial adulto", referencia: "ACC-NIBP-001", quantidade: "2", unidade: "unid", estado: "em-uso", observacoes: "" }
        ],
        consumiveis: [
            { nome: "Elétrodos de ECG descartáveis", referencia: "CON-ECG-001", quantidade: "100", unidade: "unid", estado: "em-uso", observacoes: "Repor quando stock atingir 20 unidades" },
            { nome: "Papel de impressão térmica", referencia: "CON-PAP-001", quantidade: "5", unidade: "rolo", estado: "em-uso", observacoes: "" }
        ],

        dataAquisicao: "12/03/2025",
        custoAquisicao: "8500 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "nao",
        nomeContratoAquisicao: "",
        dataContratoAquisicao: "",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Philips 2025",
        dataFatura: "12/03/2025",
        ficheiroFatura: "fatura_EQ001.pdf",

        observacoesAquisicao: "",

        fornecedores: [
            {
                codigo: "FOR001",
                morada: "Lisboa, Portugal",
                pessoaContacto: "Catarina Silva",
                telefone: "+351 910 000 000",
                tipo: "Fabricante",
                observacoes: "Fornecedor associado a equipamentos de monitorização."
            }
        ],

        localizacao: "LOC001",
        observacoesLocalizacao: "",

        dataInicioGarantia: "12/03/2025",
        dataFimGarantia: "12/03/2028",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Certificado de Garantia Philips",
        dataCertificadoGarantia: "12/03/2025",
        validadeCertificadoGarantia: "12/03/2028",
        ficheiroGarantia: "certificado_garantia_EQ001.pdf",

        observacoesGarantia: "Garantia comercial do fabricante.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "Philips Healthcare",
        periodicidadeContrato: "Anual",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção Philips 2026",
        dataContratoManutencao: "01/01/2026",
        validadeContratoManutencao: "31/12/2026",
        ficheiroContratoManutencao: "contrato_manutencao_EQ001.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório de Manutenção 2026",
        dataRelatorioManutencao: "15/02/2026",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ001.pdf",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração 2026",
        dataCertificadoCalibracao: "10/01/2026",
        validadeCertificadoCalibracao: "10/01/2027",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ001.pdf",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Garantia ativa e contrato de manutenção preventiva associado.",
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
        estado: "Em manutenção",
        criticidade: "Suporte de vida",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Evita V600",
        dataManualTecnico: "08/09/2021",
        validadeManualTecnico: "08/09/2031",
        ficheiroManualTecnico: "manual_servico_EQ002.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Evita V600",
        dataManualUtilizacao: "08/09/2021",
        validadeManualUtilizacao: "08/09/2031",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ002.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Evita V600",
        dataDeclaracaoConformidade: "08/09/2021",
        validadeDeclaracaoConformidade: "08/09/2031",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ002.pdf",

        observacoes: "Equipamento em manutenção preventiva programada. Utilizado em UCI para suporte ventilatório invasivo.",

        acessorios: [
            { nome: "Circuito ventilatório adulto reutilizável", referencia: "ACC-CIR-001", quantidade: "3", unidade: "unid", estado: "em-uso", observacoes: "" },
            { nome: "Filtro bacteriano/viral", referencia: "ACC-FIL-001", quantidade: "5", unidade: "unid", estado: "novo", observacoes: "" },
            { nome: "Sensor de fluxo proximal", referencia: "ACC-SFP-001", quantidade: "2", unidade: "unid", estado: "em-uso", observacoes: "" }
        ],
        consumiveis: [
            { nome: "Circuito ventilatório descartável", referencia: "CON-CIR-001", quantidade: "10", unidade: "unid", estado: "em-uso", observacoes: "" },
            { nome: "Câmara de humidificação descartável", referencia: "CON-HUM-001", quantidade: "8", unidade: "unid", estado: "em-uso", observacoes: "" },
            { nome: "Filtro HME descartável", referencia: "CON-HME-001", quantidade: "20", unidade: "unid", estado: "em-uso", observacoes: "Substituir a cada 24h" }
        ],

        dataAquisicao: "08/09/2021",
        custoAquisicao: "23500 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Dräger 2021",
        dataContratoAquisicao: "08/09/2021",
        validadeContratoAquisicao: "",
        icheiroContratoAquisicao: "contrato_aquisicao_EQ002.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Dräger 2021",
        dataFatura: "08/09/2021",
        ficheiroFatura: "fatura_EQ002.pdf",

        observacoesAquisicao: "Aquisição realizada no âmbito do reforço de meios de suporte ventilatório da UCI.",

        fornecedores: [
            {
                codigo: "FOR002",
                morada: "Porto, Portugal",
                pessoaContacto: "Miguel Santos",
                telefone: "+351 920 000 000",
                tipo: "Fabricante",
                observacoes: "Fabricante do equipamento."
            },
            {
                codigo: "FOR004",
                morada: "Coimbra, Portugal",
                pessoaContacto: "João Almeida",
                telefone: "+351 940 000 000",
                tipo: "Empresa de assistência técnica",
                observacoes: "Responsável pela manutenção preventiva e corretiva."
            }
        ],

        localizacao: "LOC002",
        observacoesLocalizacao: "Equipamento afeto permanentemente à sala 2.11 da UCI.",

        dataInicioGarantia: "08/09/2021",
        dataFimGarantia: "08/09/2024",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Certificado de Garantia Dräger",
        dataCertificadoGarantia: "08/09/2021",
        validadeCertificadoGarantia: "08/09/2024",
        ficheiroGarantia: "certificado_garantia_EQ002.pdf",

        observacoesGarantia: "Garantia de 3 anos do fabricante. Expirada.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva e corretiva",
        entidadeResponsavelContrato: "TecnoMed Assistência",
        periodicidadeContrato: "Semestral",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato TecnoMed 2025",
        dataContratoManutencao: "01/01/2025",
        validadeContratoManutencao: "31/12/2025",
        ficheiroContratoManutencao: "contrato_manutencao_EQ002.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Manutenção Semestral 2025",
        dataRelatorioManutencao: "15/06/2025",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ002.pdf",

        temDocumentacaoCalibracao: "nao",
        nomeCertificadoCalibracao: "",
        dataCertificadoCalibracao: "",
        validadeCertificadoCalibracao: "",
        ficheiroCertificadoCalibracao: "",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Contrato de manutenção semestral ativo com TecnoMed Assistência.",
    },

    EQ003: {
        codigo: "EQ003",
        designacao: "Bomba de infusão",
        categoria: "Terapia",
        marca: "B. Braun",
        modelo: "Infusomat Space",
        numeroSerie: "BB-INF-2019-033",
        fabricante: "B. Braun Medical",
        anoFabrico: "2019",
        estado: "Em calibração",
        criticidade: "Média",

        temDocumentacaoTecnica: "nao",
        tipoManualTecnico: "",
        nomeManualTecnico: "",
        dataManualTecnico: "",
        validadeManualTecnico: "",
        ficheiroManualTecnico: "",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Infusomat Space",
        dataManualUtilizacao: "21/01/2020",
        validadeManualUtilizacao: "21/01/2030",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ003.pdf",

        temDeclaracaoConformidade: "nao",
        nomeDeclaracaoConformidade: "",
        dataDeclaracaoConformidade: "",
        validadeDeclaracaoConformidade: "",
        ficheiroDeclaracaoConformidade: "",

        observacoes: "Utilizada para administração controlada de terapêutica intravenosa. Em processo de calibração anual.",

        acessorios: [
            { nome: "Suporte de poste para bomba", referencia: "ACC-SUP-001", quantidade: "1", unidade: "unid", estado: "em-uso", observacoes: "" },
            { nome: "Cabo de alimentação de substituição", referencia: "ACC-CAB-001", quantidade: "1", unidade: "unid", estado: "novo", observacoes: "" }
        ],
        consumiveis: [
            { nome: "Linha de infusão B. Braun compatível", referencia: "CON-LIN-001", quantidade: "20", unidade: "unid", estado: "em-uso", observacoes: "" },
            { nome: "Seringa 50ml", referencia: "CON-SER-001", quantidade: "30", unidade: "unid", estado: "em-uso", observacoes: "" },
            { nome: "Seringa 20ml", referencia: "CON-SER-002", quantidade: "20", unidade: "unid", estado: "em-uso", observacoes: "" }
        ],

        dataAquisicao: "21/01/2020",
        custoAquisicao: "3200 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "nao",
        nomeContratoAquisicao: "",
        dataContratoAquisicao: "",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura B. Braun 2020",
        dataFatura: "21/01/2020",
        ficheiroFatura: "fatura_EQ003.pdf",

        observacoesAquisicao: "",

        fornecedores: [
            {
                codigo: "FOR003",
                morada: "Aveiro, Portugal",
                pessoaContacto: "Carla Ferreira",
                telefone: "+351 930 000 000",
                tipo: "Distribuidor ou Fornecedor comercial",
                observacoes: "Distribuidor do equipamento e consumíveis associados."
            }
        ],

        localizacao: "LOC003",
        observacoesLocalizacao: "",

        dataInicioGarantia: "21/01/2020",
        dataFimGarantia: "21/01/2023",

        temDocumentacaoGarantia: "nao",
        nomeCertificadoGarantia: "",
        dataCertificadoGarantia: "",
        validadeCertificadoGarantia: "",
        ficheiroGarantia: "",

        observacoesGarantia: "Garantia expirada. Sem renovação.",

        contratoManutencao: "Não",
        tipoContrato: "Não existe",
        entidadeResponsavelContrato: "Não existe",
        periodicidadeContrato: "Não aplicável",

        temDocumentacaoContrato: "nao",
        nomeContratoManutencao: "",
        dataContratoManutencao: "",
        validadeContratoManutencao: "",
        ficheiroContratoManutencao: "",

        temRelatorioContrato: "nao",
        nomeRelatorioManutencao: "",
        dataRelatorioManutencao: "",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração B. Braun 2025",
        dataCertificadoCalibracao: "15/03/2025",
        validadeCertificadoCalibracao: "15/03/2026",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ003.pdf",

        temRelatorioCalibracao: "sim",
        tipoRelatorioCalibracao: "Relatório de calibração",
        nomeRelatorioCalibracao: "Relatório de Calibração 2025",
        dataRelatorioCalibracao: "15/03/2025",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "relatorio_calibracao_EQ003.pdf",

        observacoesContrato: "Sem contrato de manutenção associado. Calibração anual realizada por entidade externa.",
    },

    EQ004: {
        codigo: "EQ004",
        designacao: "Desfibrilhador",
        categoria: "Suporte de vida",
        marca: "Zoll",
        modelo: "R Series",
        numeroSerie: "ZL-RS-2022-007",
        fabricante: "Zoll Medical",
        anoFabrico: "2022",
        estado: "Ativo",
        criticidade: "Suporte de vida",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Zoll R Series",
        dataManualTecnico: "15/06/2022",
        validadeManualTecnico: "15/06/2032",
        ficheiroManualTecnico: "manual_servico_EQ004.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Zoll R Series",
        dataManualUtilizacao: "15/06/2022",
        validadeManualUtilizacao: "15/06/2032",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ004.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Zoll R Series",
        dataDeclaracaoConformidade: "15/06/2022",
        validadeDeclaracaoConformidade: "15/06/2032",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ004.pdf",

        observacoes: "Equipamento essencial para resposta rápida em situações de paragem cardiorrespiratória. Localizado na Urgência.",

        acessorios: [
            { nome: "Pás externas reutilizáveis adulto", referencia: "ACC-PAS-001", quantidade: "1", unidade: "par", estado: "em-uso", observacoes: "" },
            { nome: "Cabo de ECG 3 derivações", referencia: "ACC-ECG-002", quantidade: "1", unidade: "unid", estado: "em-uso", observacoes: "" },
            { nome: "Cabo de SpO2", referencia: "ACC-SPO2-002", quantidade: "1", unidade: "unid", estado: "em-uso", observacoes: "" }
        ],
        consumiveis: [
            { nome: "Elétrodos multifunções descartáveis adulto", referencia: "CON-ELE-001", quantidade: "5", unidade: "par", estado: "em-uso", observacoes: "Verificar validade regularmente" },
            { nome: "Papel de registo ECG", referencia: "CON-PAP-002", quantidade: "3", unidade: "rolo", estado: "em-uso", observacoes: "" },
            { nome: "Bateria de substituição", referencia: "CON-BAT-001", quantidade: "1", unidade: "unid", estado: "novo", observacoes: "Manter sempre carregada" }
        ],

        dataAquisicao: "15/06/2022",
        custoAquisicao: "12400 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Zoll 2022",
        dataContratoAquisicao: "15/06/2022",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ004.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Zoll 2022",
        dataFatura: "15/06/2022",
        ficheiroFatura: "fatura_EQ004.pdf",

        observacoesAquisicao: "Aquisição para reforço da resposta de emergência na Urgência.",

        fornecedores: [
            {
                codigo: "FOR004",
                morada: "Coimbra, Portugal",
                pessoaContacto: "João Almeida",
                telefone: "+351 931 000 000",
                tipo: "Empresa de assistência técnica",
                observacoes: "Responsável pela manutenção corretiva."
            },
            {
                codigo: "FOR001",
                morada: "Lisboa, Portugal",
                pessoaContacto: "Catarina Silva",
                telefone: "+351 910 126 193",
                tipo: "Fabricante",
                observacoes: "Fornecedor original do equipamento."
            }
        ],

        localizacao: "LOC004",
        observacoesLocalizacao: "Equipamento de acesso imediato na sala de emergência da Urgência.",

        dataInicioGarantia: "15/06/2022",
        dataFimGarantia: "15/06/2025",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Zoll R Series",
        dataCertificadoGarantia: "15/06/2022",
        validadeCertificadoGarantia: "15/06/2025",
        ficheiroGarantia: "certificado_garantia_EQ004.pdf",

        observacoesGarantia: "Garantia comercial de 3 anos. Expirada.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção corretiva",
        entidadeResponsavelContrato: "TecnoMed Assistência",
        periodicidadeContrato: "Anual",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção Zoll 2025",
        dataContratoManutencao: "01/01/2025",
        validadeContratoManutencao: "31/12/2025",
        ficheiroContratoManutencao: "contrato_manutencao_EQ004.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Manutenção Anual 2025",
        dataRelatorioManutencao: "20/03/2025",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ004.pdf",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração Zoll 2025",
        dataCertificadoCalibracao: "20/03/2025",
        validadeCertificadoCalibracao: "20/03/2026",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ004.pdf",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Contrato de manutenção corretiva anual ativo com TecnoMed Assistência.",
    },

    EQ005: {
        codigo: "EQ005",
        designacao: "Ecógrafo",
        categoria: "Diagnóstico",
        marca: "Siemens",
        modelo: "Acuson Redwood",
        numeroSerie: "SM-RDW-2023-021",
        fabricante: "Siemens Healthineers",
        anoFabrico: "2023",
        estado: "Ativo",
        criticidade: "Alta",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Siemens Acuson Redwood",
        dataManualTecnico: "10/04/2024",
        validadeManualTecnico: "10/04/2033",
        ficheiroManualTecnico: "manual_servico_EQ005.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Acuson Redwood",
        dataManualUtilizacao: "10/04/2024",
        validadeManualUtilizacao: "10/04/2034",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ005.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Siemens Acuson Redwood",
        dataDeclaracaoConformidade: "10/04/2024",
        validadeDeclaracaoConformidade: "10/04/2034",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ005.pdf",

        observacoes: "Equipamento utilizado para realização de exames ecográficos em diferentes especialidades clínicas.",

        acessorios: [
            {
                nome: "Sonda convexa",
                referencia: "ACC-SON-001",
                quantidade: "2",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Sonda linear",
                referencia: "ACC-SON-002",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Pedal multifunções",
                referencia: "ACC-PED-001",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Gel de ultrassom",
                referencia: "CON-GEL-001",
                quantidade: "20",
                unidade: "frasco",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Papel térmico",
                referencia: "CON-PAP-003",
                quantidade: "5",
                unidade: "rolo",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "10/04/2024",
        custoAquisicao: "28500 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Siemens 2024",
        dataContratoAquisicao: "10/04/2024",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ005.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Siemens 2024",
        dataFatura: "10/04/2024",
        ficheiroFatura: "fatura_EQ005.pdf",

        observacoesAquisicao: "Aquisição realizada para reforço da capacidade de diagnóstico por imagem.",

        fornecedores: [
            {
                codigo: "FOR005",
                morada: "Coimbra, Portugal",
                pessoaContacto: "Ricardo Moreira",
                telefone: "+351 910 111 222",
                tipo: "Fabricante",
                observacoes: "Fornecedor principal do equipamento."
            },
            {
                codigo: "FOR004",
                morada: "Coimbra, Portugal",
                pessoaContacto: "João Almeida",
                telefone: "+351 960 000 000",
                tipo: "Empresa de assistência técnica",
                observacoes: "Responsável pela manutenção preventiva."
            }
        ],

        localizacao: "LOC005",
        observacoesLocalizacao: "Equipamento instalado na sala de imagiologia para realização de exames ecográficos.",

        dataInicioGarantia: "10/04/2024",
        dataFimGarantia: "10/04/2027",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Siemens Acuson Redwood",
        dataCertificadoGarantia: "10/04/2024",
        validadeCertificadoGarantia: "10/04/2027",
        ficheiroGarantia: "certificado_garantia_EQ005.pdf",

        observacoesGarantia: "Garantia comercial de 3 anos fornecida pelo fabricante.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "TecnoMed Assistência",
        periodicidadeContrato: "Anual",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção Siemens 2025",
        dataContratoManutencao: "01/01/2025",
        validadeContratoManutencao: "31/12/2025",
        ficheiroContratoManutencao: "contrato_manutencao_EQ005.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Preventivo 2025",
        dataRelatorioManutencao: "15/02/2025",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ005.pdf",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração Ecógrafo 2025",
        dataCertificadoCalibracao: "15/02/2025",
        validadeCertificadoCalibracao: "15/02/2026",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ005.pdf",

        temRelatorioCalibracao: "sim",
        nomeRelatorioCalibracao: "Relatório Calibração Ecógrafo 2025",
        dataRelatorioCalibracao: "15/02/2025",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "relatorio_calibracao_EQ005.pdf",

        observacoesContrato: "Contrato de manutenção preventiva anual ativo com a TecnoMed Assistência."
    },

    EQ006: {
        codigo: "EQ006",
        designacao: "Analisador Bioquímico",
        categoria: "Laboratório",
        marca: "Roche",
        modelo: "Cobas Pure",
        numeroSerie: "RC-CBP-2024-014",
        fabricante: "Roche Diagnostics",
        anoFabrico: "2024",
        estado: "Ativo",
        criticidade: "Alta",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Roche Cobas Pure",
        dataManualTecnico: "20/02/2024",
        validadeManualTecnico: "20/02/2034",
        ficheiroManualTecnico: "manual_servico_EQ006.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Cobas Pure",
        dataManualUtilizacao: "20/02/2024",
        validadeManualUtilizacao: "20/02/2034",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ006.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Cobas Pure",
        dataDeclaracaoConformidade: "20/02/2024",
        validadeDeclaracaoConformidade: "20/02/2034",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ006.pdf",

        observacoes: "Equipamento destinado à realização de análises bioquímicas laboratoriais.",

        acessorios: [
            {
                nome: "Leitor de código de barras",
                referencia: "ACC-LCB-001",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Módulo de amostras",
                referencia: "ACC-MOD-001",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Reagente Bioquímico",
                referencia: "CON-REB-001",
                quantidade: "12",
                unidade: "frasco",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Cuvetes descartáveis",
                referencia: "CON-CUV-001",
                quantidade: "500",
                unidade: "unid",
                estado: "novo",
                observacoes: ""
            },
            {
                nome: "Solução de limpeza",
                referencia: "CON-LIM-001",
                quantidade: "4",
                unidade: "frasco",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        dataAquisicao: "20/02/2024",
        custoAquisicao: "36500 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Roche 2024",
        dataContratoAquisicao: "20/02/2024",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ006.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Roche 2024",
        dataFatura: "20/02/2024",
        ficheiroFatura: "fatura_EQ006.pdf",

        observacoesAquisicao: "Equipamento adquirido para modernização do laboratório clínico.",

        fornecedores: [
            {
                codigo: "FOR009",
                morada: "Lisboa, Portugal",
                pessoaContacto: "Tiago Oliveira",
                telefone: "+351 910 555 666",
                tipo: "Fornecedor de consumáveis ou acessórios",
                observacoes: "Fornecedor principal do equipamento e reagentes."
            },
            {
                codigo: "FOR004",
                morada: "Coimbra, Portugal",
                pessoaContacto: "João Almeida",
                telefone: "+351 930 000 400",
                tipo: "Empresa de assistência técnica",
                observacoes: "Responsável pela manutenção preventiva."
            }
        ],

        localizacao: "LOC011",
        observacoesLocalizacao: "Instalado na área principal do laboratório clínico.",

        dataInicioGarantia: "20/02/2024",
        dataFimGarantia: "20/02/2027",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Roche Cobas Pure",
        dataCertificadoGarantia: "20/02/2024",
        validadeCertificadoGarantia: "20/02/2027",
        ficheiroGarantia: "certificado_garantia_EQ006.pdf",

        observacoesGarantia: "Garantia comercial de 3 anos.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "TecnoMed Assistência",
        periodicidadeContrato: "Semestral",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção Roche 2025",
        dataContratoManutencao: "01/01/2025",
        validadeContratoManutencao: "31/12/2025",
        ficheiroContratoManutencao: "contrato_manutencao_EQ006.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Preventivo 1º Semestre 2025",
        dataRelatorioManutencao: "15/03/2025",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ006.pdf",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração Cobas Pure 2025",
        dataCertificadoCalibracao: "15/03/2025",
        validadeCertificadoCalibracao: "15/03/2026",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ006.pdf",

        temRelatorioCalibracao: "sim",
        nomeRelatorioCalibracao: "Relatório Calibração Cobas Pure 2025",
        dataRelatorioCalibracao: "15/03/2025",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "relatorio_calibracao_EQ006.pdf",

        observacoesContrato: "Contrato de manutenção preventiva semestral ativo."
    },

    EQ007: {
        codigo: "EQ007",
        designacao: "Autoclave",
        categoria: "Esterilização",
        marca: "Getinge",
        modelo: "HS66",
        numeroSerie: "GT-HS66-2021-009",
        fabricante: "Getinge",
        anoFabrico: "2021",
        estado: "Em manutenção",
        criticidade: "Alta",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Getinge HS66",
        dataManualTecnico: "12/05/2021",
        validadeManualTecnico: "12/05/2031",
        ficheiroManualTecnico: "manual_servico_EQ007.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Getinge HS66",
        dataManualUtilizacao: "12/05/2021",
        validadeManualUtilizacao: "12/05/2031",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ007.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Getinge HS66",
        dataDeclaracaoConformidade: "12/05/2021",
        validadeDeclaracaoConformidade: "12/05/2031",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ007.pdf",

        observacoes: "Equipamento utilizado para esterilização de instrumentos cirúrgicos e material clínico.",

        acessorios: [
            {
                nome: "Carro de carga",
                referencia: "ACC-CAR-001",
                quantidade: "2",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Cestos inox",
                referencia: "ACC-CES-001",
                quantidade: "8",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Indicadores químicos",
                referencia: "CON-IND-001",
                quantidade: "150",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Fita de esterilização",
                referencia: "CON-FIT-001",
                quantidade: "25",
                unidade: "rolo",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "12/05/2021",
        custoAquisicao: "32000 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Getinge 2021",
        dataContratoAquisicao: "12/05/2021",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ007.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Getinge 2021",
        dataFatura: "12/05/2021",
        ficheiroFatura: "fatura_EQ007.pdf",

        observacoesAquisicao: "Aquisição realizada para reforço da capacidade de esterilização hospitalar.",

        fornecedores: [
            {
                codigo: "FOR003",
                morada: "Aveiro, Portugal",
                pessoaContacto: "Carla Ferreira",
                telefone: "+351 930 000 000",
                tipo: "Distribuidor ou Fornecedor comercial",
                observacoes: "Fornecedor responsável pela entrega do equipamento."
            },
            {
                codigo: "FOR004",
                morada: "Coimbra, Portugal",
                pessoaContacto: "João Almeida",
                telefone: "+351 930 000 400",
                tipo: "Empresa de assistência técnica",
                observacoes: "Responsável pela manutenção preventiva e corretiva."
            }
        ],

        localizacao: "LOC008",
        observacoesLocalizacao: "Equipamento instalado na Central de Esterilização.",

        dataInicioGarantia: "12/05/2021",
        dataFimGarantia: "12/05/2024",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Getinge HS66",
        dataCertificadoGarantia: "12/05/2021",
        validadeCertificadoGarantia: "12/05/2024",
        ficheiroGarantia: "certificado_garantia_EQ007.pdf",

        observacoesGarantia: "Garantia comercial expirada.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "TecnoMed Assistência",
        periodicidadeContrato: "Trimestral",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção Getinge 2025",
        dataContratoManutencao: "01/01/2025",
        validadeContratoManutencao: "31/12/2025",
        ficheiroContratoManutencao: "contrato_manutencao_EQ007.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Preventivo 1º Trimestre 2025",
        dataRelatorioManutencao: "05/03/2025",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ007.pdf",

        temDocumentacaoCalibracao: "nao",
        nomeCertificadoCalibracao: "",
        dataCertificadoCalibracao: "",
        validadeCertificadoCalibracao: "",
        ficheiroCertificadoCalibracao: "",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Equipamento temporariamente em manutenção preventiva programada."
    },

    EQ008: {
        codigo: "EQ008",
        designacao: "Ultrassom Terapêutico",
        categoria: "Reabilitação",
        marca: "BTL",
        modelo: "BTL-5820S",
        numeroSerie: "BTL-US-2023-011",
        fabricante: "BTL Industries",
        anoFabrico: "2023",
        estado: "Ativo",
        criticidade: "Média",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico BTL-5820S",
        dataManualTecnico: "10/01/2023",
        validadeManualTecnico: "10/01/2033",
        ficheiroManualTecnico: "manual_servico_EQ008.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização BTL-5820S",
        dataManualUtilizacao: "10/01/2023",
        validadeManualUtilizacao: "10/01/2033",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ008.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade BTL-5820S",
        dataDeclaracaoConformidade: "10/01/2023",
        validadeDeclaracaoConformidade: "10/01/2033",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ008.pdf",

        observacoes: "Equipamento utilizado em tratamentos de fisioterapia e reabilitação músculo-esquelética.",

        acessorios: [
            {
                nome: "Cabeça de tratamento 1 MHz",
                referencia: "ACC-US-001",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Cabeça de tratamento 3 MHz",
                referencia: "ACC-US-002",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Gel condutor",
                referencia: "CON-GEL-002",
                quantidade: "10",
                unidade: "frasco",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        dataAquisicao: "15/02/2023",
        custoAquisicao: "4200 €",
        tipoEntrada: "Doação",

        temContratoAquisicao: "nao",
        nomeContratoAquisicao: "",
        dataContratoAquisicao: "",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "",

        temFatura: "nao",
        nomeFatura: "",
        dataFatura: "",
        ficheiroFatura: "",

        observacoesAquisicao: "Equipamento recebido através de doação para reforço do serviço de reabilitação.",

        fornecedores: [
            {
                codigo: "FOR008",
                morada: "Braga, Portugal",
                pessoaContacto: "Sofia Martins",
                telefone: "+351 910 444 555",
                tipo: "Distribuidor ou Fornecedor comercial",
                observacoes: "Fornecedor responsável pela entrega do equipamento."
            }
        ],

        localizacao: "LOC012",
        observacoesLocalizacao: "Equipamento utilizado no serviço de Medicina Física e Reabilitação.",

        dataInicioGarantia: "15/02/2023",
        dataFimGarantia: "15/02/2026",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia BTL-5820S",
        dataCertificadoGarantia: "15/02/2023",
        validadeCertificadoGarantia: "15/02/2026",
        ficheiroGarantia: "certificado_garantia_EQ008.pdf",

        observacoesGarantia: "Garantia de 3 anos fornecida pelo distribuidor.",

        contratoManutencao: "Não",
        tipoContrato: "Não existe",
        entidadeResponsavelContrato: "Não existe",
        periodicidadeContrato: "Não aplicável",

        temDocumentacaoContrato: "nao",
        nomeContratoManutencao: "",
        dataContratoManutencao: "",
        validadeContratoManutencao: "",
        ficheiroContratoManutencao: "",

        temRelatorioContrato: "nao",
        nomeRelatorioManutencao: "",
        dataRelatorioManutencao: "",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "",

        temDocumentacaoCalibracao: "nao",
        nomeCertificadoCalibracao: "",
        dataCertificadoCalibracao: "",
        validadeCertificadoCalibracao: "",
        ficheiroCertificadoCalibracao: "",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Equipamento sem contrato de manutenção ativo."
    },

    EQ009: {
        codigo: "EQ009",
        designacao: "Monitor Multiparamétrico",
        categoria: "Monitorização",
        marca: "GE HealthCare",
        modelo: "CARESCAPE B450",
        numeroSerie: "GE-B450-2022-019",
        fabricante: "GE HealthCare",
        anoFabrico: "2022",
        estado: "Em calibração",
        criticidade: "Alta",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico CARESCAPE B450",
        dataManualTecnico: "08/09/2022",
        validadeManualTecnico: "08/09/2032",
        ficheiroManualTecnico: "manual_servico_EQ009.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização CARESCAPE B450",
        dataManualUtilizacao: "08/09/2022",
        validadeManualUtilizacao: "08/09/2032",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ009.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade CARESCAPE B450",
        dataDeclaracaoConformidade: "08/09/2022",
        validadeDeclaracaoConformidade: "08/09/2032",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ009.pdf",

        observacoes: "Equipamento temporariamente retirado de serviço para calibração anual.",

        acessorios: [
            {
                nome: "Sensor SpO2",
                referencia: "ACC-SPO2-009",
                quantidade: "2",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Braçadeira NIBP adulto",
                referencia: "ACC-NIBP-009",
                quantidade: "2",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Cabo ECG 5 derivações",
                referencia: "ACC-ECG-009",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Elétrodos ECG descartáveis",
                referencia: "CON-ECG-009",
                quantidade: "100",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        dataAquisicao: "08/09/2022",
        custoAquisicao: "5200 €",
        tipoEntrada: "Aluguer",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aluguer",
        nomeContratoAquisicao: "Contrato Aluguer GE 2022",
        dataContratoAquisicao: "08/09/2022",
        validadeContratoAquisicao: "08/09/2027",
        ficheiroContratoAquisicao: "contrato_aluguer_EQ009.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura GE 2022",
        dataFatura: "08/09/2022",
        ficheiroFatura: "fatura_EQ009.pdf",

        observacoesAquisicao: "Equipamento obtido através de contrato de aluguer operacional.",

        fornecedores: [
            {
                codigo: "FOR006",
                morada: "Região Autónoma da Madeira, Portugal",
                pessoaContacto: "Ana Ribeiro",
                telefone: "+351 910 222 333",
                tipo: "Fabricante",
                observacoes: "Fornecedor principal do equipamento."
            }
        ],

        localizacao: "LOC001",
        observacoesLocalizacao: "Monitor instalado na Unidade de Cuidados Intensivos.",

        dataInicioGarantia: "08/09/2022",
        dataFimGarantia: "08/09/2025",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia GE CARESCAPE B450",
        dataCertificadoGarantia: "08/09/2022",
        validadeCertificadoGarantia: "08/09/2025",
        ficheiroGarantia: "certificado_garantia_EQ009.pdf",

        observacoesGarantia: "Garantia associada ao contrato de aluguer.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "GE HealthCare",
        periodicidadeContrato: "Anual",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção GE 2025",
        dataContratoManutencao: "01/01/2025",
        validadeContratoManutencao: "31/12/2025",
        ficheiroContratoManutencao: "contrato_manutencao_EQ009.pdf",

        temRelatorioContrato: "nao",
        nomeRelatorioManutencao: "",
        dataRelatorioManutencao: "",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração B450 2025",
        dataCertificadoCalibracao: "10/05/2025",
        validadeCertificadoCalibracao: "10/05/2026",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ009.pdf",

        temRelatorioCalibracao: "sim",
        nomeRelatorioCalibracao: "Relatório Calibração B450 2025",
        dataRelatorioCalibracao: "10/05/2025",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "relatorio_calibracao_EQ009.pdf",

        observacoesContrato: "Equipamento em processo de calibração periódica obrigatória."
    },

    EQ010: {
        codigo: "EQ010",
        designacao: "Bomba Infusora",
        categoria: "Terapia",
        marca: "B. Braun",
        modelo: "Perfusor Space",
        numeroSerie: "BB-PS-2021-028",
        fabricante: "B. Braun Medical",
        anoFabrico: "2021",
        estado: "Em quarentena",
        criticidade: "Média",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Perfusor Space",
        dataManualTecnico: "15/03/2021",
        validadeManualTecnico: "15/03/2031",
        ficheiroManualTecnico: "manual_servico_EQ010.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Perfusor Space",
        dataManualUtilizacao: "15/03/2021",
        validadeManualUtilizacao: "15/03/2031",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ010.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Perfusor Space",
        dataDeclaracaoConformidade: "15/03/2021",
        validadeDeclaracaoConformidade: "15/03/2031",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ010.pdf",

        observacoes: "Equipamento temporariamente em quarentena para avaliação técnica após reporte de funcionamento irregular.",

        acessorios: [
            {
                nome: "Suporte de fixação",
                referencia: "ACC-SUP-010",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Cabo de alimentação",
                referencia: "ACC-CAB-010",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Equipos de infusão",
                referencia: "CON-EQP-010",
                quantidade: "50",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Seringas 50 ml",
                referencia: "CON-SER-010",
                quantidade: "100",
                unidade: "unid",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "22/07/2021",
        custoAquisicao: "2800 €",
        tipoEntrada: "Empréstimo",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de empréstimo",
        nomeContratoAquisicao: "Contrato Empréstimo Bomba Infusora 2021",
        dataContratoAquisicao: "22/07/2021",
        validadeContratoAquisicao: "22/07/2026",
        ficheiroContratoAquisicao: "contrato_emprestimo_EQ010.pdf",

        temFatura: "nao",
        nomeFatura: "",
        dataFatura: "",
        ficheiroFatura: "",

        observacoesAquisicao: "Equipamento cedido temporariamente por parceiro institucional.",

        fornecedores: [
            {
                codigo: "FOR007",
                morada: "Faro, Portugal",
                pessoaContacto: "Pedro Costa",
                telefone: "+351 910 333 444",
                tipo: "Fornecedor de consumáveis ou acessórios",
                observacoes: "Fornecedor responsável pelos consumíveis associados."
            },
            {
                codigo: "FOR004",
                morada: "Coimbra, Portugal",
                pessoaContacto: "João Almeida",
                telefone: "+351 930 000 400",
                tipo: "Empresa de assistência técnica",
                observacoes: "Responsável pela avaliação técnica."
            }
        ],

        localizacao: "LOC003",
        observacoesLocalizacao: "Equipamento afeto ao Serviço de Medicina.",

        dataInicioGarantia: "22/07/2021",
        dataFimGarantia: "22/07/2024",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Perfusor Space",
        dataCertificadoGarantia: "22/07/2021",
        validadeCertificadoGarantia: "22/07/2024",
        ficheiroGarantia: "certificado_garantia_EQ010.pdf",

        observacoesGarantia: "Garantia expirada.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção corretiva",
        entidadeResponsavelContrato: "TecnoMed Assistência",
        periodicidadeContrato: "Mensal",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção Perfusor 2025",
        dataContratoManutencao: "01/01/2025",
        validadeContratoManutencao: "31/12/2025",
        ficheiroContratoManutencao: "contrato_manutencao_EQ010.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Avaliação Técnica 2025",
        dataRelatorioManutencao: "18/04/2025",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ010.pdf",

        temDocumentacaoCalibracao: "nao",
        nomeCertificadoCalibracao: "",
        dataCertificadoCalibracao: "",
        validadeCertificadoCalibracao: "",
        ficheiroCertificadoCalibracao: "",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Equipamento em avaliação técnica antes de regressar ao serviço."
    },

    EQ011: {
        codigo: "EQ011",
        designacao: "Eletrocardiógrafo",
        categoria: "Diagnóstico",
        marca: "Philips",
        modelo: "PageWriter TC35",
        numeroSerie: "PH-TC35-2020-017",
        fabricante: "Philips Healthcare",
        anoFabrico: "2020",
        estado: "Inativo",
        criticidade: "Média",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Philips TC35",
        dataManualTecnico: "10/02/2020",
        validadeManualTecnico: "10/02/2030",
        ficheiroManualTecnico: "manual_servico_EQ011.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Philips TC35",
        dataManualUtilizacao: "10/02/2020",
        validadeManualUtilizacao: "10/02/2030",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ011.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Philips TC35",
        dataDeclaracaoConformidade: "10/02/2020",
        validadeDeclaracaoConformidade: "10/02/2030",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ011.pdf",

        observacoes: "Equipamento atualmente sem utilização devido à aquisição de modelos mais recentes.",

        acessorios: [
            {
                nome: "Cabo ECG 12 derivações",
                referencia: "ACC-ECG-011",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Carrinho de transporte",
                referencia: "ACC-CAR-011",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Papel térmico ECG",
                referencia: "CON-PAP-011",
                quantidade: "8",
                unidade: "rolo",
                estado: "novo",
                observacoes: ""
            },
            {
                nome: "Elétrodos descartáveis",
                referencia: "CON-ELE-011",
                quantidade: "200",
                unidade: "unid",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "10/02/2020",
        custoAquisicao: "3900 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Philips 2020",
        dataContratoAquisicao: "10/02/2020",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ011.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Philips 2020",
        dataFatura: "10/02/2020",
        ficheiroFatura: "fatura_EQ011.pdf",

        observacoesAquisicao: "Aquisição para reforço da capacidade diagnóstica do serviço.",

        fornecedores: [
            {
                codigo: "FOR001",
                morada: "Lisboa, Portugal",
                pessoaContacto: "Catarina Silva",
                telefone: "+351 910 000 000",
                tipo: "Fabricante",
                observacoes: "Fornecedor original do equipamento."
            }
        ],

        localizacao: "LOC007",
        observacoesLocalizacao: "Equipamento armazenado na Cardiologia como reserva.",

        dataInicioGarantia: "10/02/2020",
        dataFimGarantia: "10/02/2023",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Philips TC35",
        dataCertificadoGarantia: "10/02/2020",
        validadeCertificadoGarantia: "10/02/2023",
        ficheiroGarantia: "certificado_garantia_EQ011.pdf",

        observacoesGarantia: "Garantia expirada.",

        contratoManutencao: "Não",
        tipoContrato: "Não existe",
        entidadeResponsavelContrato: "Não existe",
        periodicidadeContrato: "Não aplicável",

        temDocumentacaoContrato: "nao",
        nomeContratoManutencao: "",
        dataContratoManutencao: "",
        validadeContratoManutencao: "",
        ficheiroContratoManutencao: "",

        temRelatorioContrato: "nao",
        nomeRelatorioManutencao: "",
        dataRelatorioManutencao: "",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "",

        temDocumentacaoCalibracao: "nao",
        nomeCertificadoCalibracao: "",
        dataCertificadoCalibracao: "",
        validadeCertificadoCalibracao: "",
        ficheiroCertificadoCalibracao: "",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Equipamento inativo e sem contrato de manutenção."
    },

    EQ012: {
        codigo: "EQ012",
        designacao: "Ventilador Mecânico",
        categoria: "Suporte de vida",
        marca: "Dräger",
        modelo: "Evita V600",
        numeroSerie: "DR-EV600-2023-012",
        fabricante: "Dräger",
        anoFabrico: "2023",
        estado: "Ativo",
        criticidade: "Suporte de vida",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Dräger Evita V600",
        dataManualTecnico: "12/01/2023",
        validadeManualTecnico: "12/01/2033",
        ficheiroManualTecnico: "manual_servico_EQ012.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Evita V600",
        dataManualUtilizacao: "12/01/2023",
        validadeManualUtilizacao: "12/01/2033",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ012.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Evita V600",
        dataDeclaracaoConformidade: "12/01/2023",
        validadeDeclaracaoConformidade: "12/01/2033",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ012.pdf",

        observacoes: "Ventilador mecânico utilizado para suporte respiratório invasivo e não invasivo em doentes críticos.",

        acessorios: [
            {
                nome: "Braço articulado",
                referencia: "ACC-BRA-012",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Humidificador aquecido",
                referencia: "ACC-HUM-012",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Circuito respiratório",
                referencia: "CON-CIR-012",
                quantidade: "20",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Filtro bacteriano",
                referencia: "CON-FIL-012",
                quantidade: "30",
                unidade: "unid",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "12/01/2023",
        custoAquisicao: "36500 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Dräger 2023",
        dataContratoAquisicao: "12/01/2023",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ012.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Dräger 2023",
        dataFatura: "12/01/2023",
        ficheiroFatura: "fatura_EQ012.pdf",

        observacoesAquisicao: "Aquisição para reforço da capacidade da Unidade de Cuidados Intensivos.",

        fornecedores: [
            {
                codigo: "FOR002",
                morada: "Porto, Portugal",
                pessoaContacto: "Miguel Santos",
                telefone: "+351 920 000 000",
                tipo: "Fabricante",
                observacoes: "Fornecedor principal do equipamento."
            },
            {
                codigo: "FOR004",
                morada: "Coimbra, Portugal",
                pessoaContacto: "João Almeida",
                telefone: "+351 930 000 400",
                tipo: "Empresa de assistência técnica",
                observacoes: "Responsável pela manutenção preventiva."
            }
        ],

        localizacao: "LOC002",
        observacoesLocalizacao: "Equipamento instalado na Unidade de Cuidados Intensivos.",

        dataInicioGarantia: "12/01/2023",
        dataFimGarantia: "12/01/2026",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Dräger Evita V600",
        dataCertificadoGarantia: "12/01/2023",
        validadeCertificadoGarantia: "12/01/2026",
        ficheiroGarantia: "certificado_garantia_EQ012.pdf",

        observacoesGarantia: "Garantia comercial de 3 anos.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "TecnoMed Assistência",
        periodicidadeContrato: "Semestral",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção Dräger 2025",
        dataContratoManutencao: "01/01/2025",
        validadeContratoManutencao: "31/12/2025",
        ficheiroContratoManutencao: "contrato_manutencao_EQ012.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Preventivo 1º Semestre 2025",
        dataRelatorioManutencao: "15/04/2025",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ012.pdf",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração Evita V600",
        dataCertificadoCalibracao: "15/04/2025",
        validadeCertificadoCalibracao: "15/04/2026",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ012.pdf",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Contrato de manutenção preventiva semestral ativo."
    },

    EQ013: {
        codigo: "EQ013",
        designacao: "Centrífuga Laboratorial",
        categoria: "Laboratório",
        marca: "Eppendorf",
        modelo: "5702",
        numeroSerie: "EP-5702-2016-013",
        fabricante: "Eppendorf",
        anoFabrico: "2016",
        estado: "Abatido",
        criticidade: "Baixa",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Eppendorf 5702",
        dataManualTecnico: "05/04/2016",
        validadeManualTecnico: "05/04/2026",
        ficheiroManualTecnico: "manual_servico_EQ013.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Eppendorf 5702",
        dataManualUtilizacao: "05/04/2016",
        validadeManualUtilizacao: "05/04/2026",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ013.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Eppendorf 5702",
        dataDeclaracaoConformidade: "05/04/2016",
        validadeDeclaracaoConformidade: "05/04/2026",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ013.pdf",

        observacoes: "Equipamento abatido devido ao desgaste e à aquisição de equipamento mais recente.",

        acessorios: [
            {
                nome: "Rotor de 24 posições",
                referencia: "ACC-ROT-013",
                quantidade: "1",
                unidade: "unid",
                estado: "fora-de-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Tubos de centrifugação",
                referencia: "CON-TUB-013",
                quantidade: "0",
                unidade: "unid",
                estado: "esgotado",
                observacoes: ""
            }
        ],

        dataAquisicao: "05/04/2016",
        custoAquisicao: "2800 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Centrífuga 2016",
        dataContratoAquisicao: "05/04/2016",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ013.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Centrífuga 2016",
        dataFatura: "05/04/2016",
        ficheiroFatura: "fatura_EQ013.pdf",

        observacoesAquisicao: "Equipamento adquirido para o laboratório clínico.",

        fornecedores: [
            {
                codigo: "FOR003",
                morada: "Aveiro, Portugal",
                pessoaContacto: "Carla Ferreira",
                telefone: "+351 930 000 000",
                tipo: "Distribuidor ou Fornecedor comercial",
                observacoes: "Fornecedor original do equipamento."
            }
        ],

        localizacao: "LOC011",
        observacoesLocalizacao: "Equipamento armazenado em área de equipamentos abatidos.",

        dataInicioGarantia: "05/04/2016",
        dataFimGarantia: "05/04/2019",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Eppendorf 5702",
        dataCertificadoGarantia: "05/04/2016",
        validadeCertificadoGarantia: "05/04/2019",
        ficheiroGarantia: "certificado_garantia_EQ013.pdf",

        observacoesGarantia: "Garantia expirada.",

        contratoManutencao: "Não",
        tipoContrato: "Não existe",
        entidadeResponsavelContrato: "Não existe",
        periodicidadeContrato: "Não aplicável",

        temDocumentacaoContrato: "nao",
        nomeContratoManutencao: "",
        dataContratoManutencao: "",
        validadeContratoManutencao: "",
        ficheiroContratoManutencao: "",

        temRelatorioContrato: "nao",
        nomeRelatorioManutencao: "",
        dataRelatorioManutencao: "",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "",

        temDocumentacaoCalibracao: "nao",
        nomeCertificadoCalibracao: "",
        dataCertificadoCalibracao: "",
        validadeCertificadoCalibracao: "",
        ficheiroCertificadoCalibracao: "",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Equipamento retirado definitivamente de serviço."
    },

    EQ014: {
        codigo: "EQ014",
        designacao: "Monitor de Sinais Vitais",
        categoria: "Monitorização",
        marca: "Philips",
        modelo: "IntelliVue MX550",
        numeroSerie: "PH-MX550-2022-014",
        fabricante: "Philips Healthcare",
        anoFabrico: "2022",
        estado: "Ativo",
        criticidade: "Alta",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico IntelliVue MX550",
        dataManualTecnico: "20/06/2022",
        validadeManualTecnico: "20/06/2032",
        ficheiroManualTecnico: "manual_servico_EQ014.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização IntelliVue MX550",
        dataManualUtilizacao: "20/06/2022",
        validadeManualUtilizacao: "20/06/2032",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ014.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade IntelliVue MX550",
        dataDeclaracaoConformidade: "20/06/2022",
        validadeDeclaracaoConformidade: "20/06/2032",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ014.pdf",

        observacoes: "Monitor utilizado para monitorização contínua de parâmetros vitais.",

        acessorios: [
            {
                nome: "Sensor SpO2",
                referencia: "ACC-SPO2-014",
                quantidade: "2",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Cabo ECG",
                referencia: "ACC-ECG-014",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Elétrodos ECG",
                referencia: "CON-ECG-014",
                quantidade: "150",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        dataAquisicao: "20/06/2022",
        custoAquisicao: "6800 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Philips 2022",
        dataContratoAquisicao: "20/06/2022",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ014.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Philips MX550",
        dataFatura: "20/06/2022",
        ficheiroFatura: "fatura_EQ014.pdf",

        observacoesAquisicao: "Equipamento adquirido para reforço da monitorização clínica.",

        fornecedores: [
            {
                codigo: "FOR001",
                morada: "Lisboa, Portugal",
                pessoaContacto: "Catarina Silva",
                telefone: "+351 910 000 000",
                tipo: "Fabricante",
                observacoes: "Fornecedor principal do equipamento."
            }
        ],

        localizacao: "LOC009",
        observacoesLocalizacao: "Equipamento afeto ao serviço de Pediatria.",

        dataInicioGarantia: "20/06/2023",
        dataFimGarantia: "25/06/2026",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia IntelliVue MX550",
        dataCertificadoGarantia: "20/06/2023",
        validadeCertificadoGarantia: "25/06/2026",
        ficheiroGarantia: "certificado_garantia_EQ014.pdf",

        observacoesGarantia: "Garantia a expirar nos próximos dias.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "Philips Healthcare",
        periodicidadeContrato: "Anual",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção Philips 2026",
        dataContratoManutencao: "01/01/2026",
        validadeContratoManutencao: "31/12/2026",
        ficheiroContratoManutencao: "contrato_manutencao_EQ014.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Preventivo 2026",
        dataRelatorioManutencao: "15/01/2026",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ014.pdf",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração MX550",
        dataCertificadoCalibracao: "15/01/2026",
        validadeCertificadoCalibracao: "15/01/2027",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ014.pdf",

        temRelatorioCalibracao: "sim",
        nomeRelatorioCalibracao: "Relatório Calibração MX550",
        dataRelatorioCalibracao: "15/01/2026",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "relatorio_calibracao_EQ014.pdf",

        observacoesContrato: "Equipamento com garantia prestes a expirar."
    },

    EQ015: {
        codigo: "EQ015",
        designacao: "Passadeira de Reabilitação",
        categoria: "Reabilitação",
        marca: "Biodex",
        modelo: "Gait Trainer 3",
        numeroSerie: "BD-GT3-2022-015",
        fabricante: "Biodex Medical Systems",
        anoFabrico: "2022",
        estado: "Ativo",
        criticidade: "Baixa",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Biodex Gait Trainer 3",
        dataManualTecnico: "15/09/2022",
        validadeManualTecnico: "15/09/2032",
        ficheiroManualTecnico: "manual_servico_EQ015.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Gait Trainer 3",
        dataManualUtilizacao: "15/09/2022",
        validadeManualUtilizacao: "15/09/2032",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ015.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Gait Trainer 3",
        dataDeclaracaoConformidade: "15/09/2022",
        validadeDeclaracaoConformidade: "15/09/2032",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ015.pdf",

        observacoes: "Equipamento utilizado em programas de reeducação da marcha e fisioterapia.",

        acessorios: [
            {
                nome: "Arnês de segurança",
                referencia: "ACC-ARN-015",
                quantidade: "2",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Barra de apoio lateral",
                referencia: "ACC-BAR-015",
                quantidade: "2",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [],

        dataAquisicao: "10/10/2022",
        custoAquisicao: "18500 €",
        tipoEntrada: "Aluguer",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aluguer",
        nomeContratoAquisicao: "Contrato Aluguer Biodex 2022",
        dataContratoAquisicao: "10/10/2022",
        validadeContratoAquisicao: "10/10/2027",
        ficheiroContratoAquisicao: "contrato_aluguer_EQ015.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Biodex 2022",
        dataFatura: "10/10/2022",
        ficheiroFatura: "fatura_EQ015.pdf",

        observacoesAquisicao: "Equipamento obtido através de contrato de aluguer operacional.",

        fornecedores: [
            {
                codigo: "FOR008",
                morada: "Braga, Portugal",
                pessoaContacto: "Sofia Martins",
                telefone: "+351 910 444 555",
                tipo: "Distribuidor ou Fornecedor comercial",
                observacoes: "Fornecedor principal do equipamento."
            }
        ],

        localizacao: "LOC012",
        observacoesLocalizacao: "Equipamento instalado na área principal de fisioterapia.",

        dataInicioGarantia: "10/10/2022",
        dataFimGarantia: "28/06/2026",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Biodex Gait Trainer 3",
        dataCertificadoGarantia: "10/10/2022",
        validadeCertificadoGarantia: "28/06/2026",
        ficheiroGarantia: "certificado_garantia_EQ015.pdf",

        observacoesGarantia: "Garantia a expirar nos próximos 30 dias.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "Biodex Medical Systems",
        periodicidadeContrato: "Anual",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção Biodex 2026",
        dataContratoManutencao: "01/01/2026",
        validadeContratoManutencao: "31/12/2026",
        ficheiroContratoManutencao: "contrato_manutencao_EQ015.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Preventivo 2026",
        dataRelatorioManutencao: "15/02/2026",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ015.pdf",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração Gait Trainer 2026",
        dataCertificadoCalibracao: "20/05/2026",
        validadeCertificadoCalibracao: "20/06/2026",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ015.pdf",

        temRelatorioCalibracao: "sim",
        nomeRelatorioCalibracao: "Relatório Calibração Gait Trainer 2026",
        dataRelatorioCalibracao: "20/05/2026",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "relatorio_calibracao_EQ015.pdf",

        observacoesContrato: "Equipamento com calibração a expirar nos próximos 30 dias."
    },

    EQ016: {
        codigo: "EQ016",
        designacao: "Ecógrafo",
        categoria: "Diagnóstico",
        marca: "Siemens",
        modelo: "ACUSON Redwood",
        numeroSerie: "SM-RW-2024-016",
        fabricante: "Siemens Healthineers",
        anoFabrico: "2024",
        estado: "Ativo",
        criticidade: "Alta",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico ACUSON Redwood",
        dataManualTecnico: "15/01/2024",
        validadeManualTecnico: "15/01/2034",
        ficheiroManualTecnico: "manual_servico_EQ016.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização ACUSON Redwood",
        dataManualUtilizacao: "15/01/2024",
        validadeManualUtilizacao: "15/01/2034",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ016.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade ACUSON Redwood",
        dataDeclaracaoConformidade: "15/01/2024",
        validadeDeclaracaoConformidade: "15/01/2034",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ016.pdf",

        observacoes: "Ecógrafo utilizado para exames de diagnóstico em diversas especialidades clínicas.",

        acessorios: [
            {
                nome: "Sonda Convexa",
                referencia: "ACC-SON-016",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Sonda Linear",
                referencia: "ACC-SON-017",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Gel para ultrassons",
                referencia: "CON-GEL-016",
                quantidade: "20",
                unidade: "frasco",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "20/02/2024",
        custoAquisicao: "48500 €",
        tipoEntrada: "Doação",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Termo de doação",
        nomeContratoAquisicao: "Termo de Doação Ecógrafo 2024",
        dataContratoAquisicao: "20/02/2024",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "termo_doacao_EQ016.pdf",

        temFatura: "nao",
        nomeFatura: "",
        dataFatura: "",
        ficheiroFatura: "",

        observacoesAquisicao: "Equipamento recebido através de doação institucional.",

        fornecedores: [
            {
                codigo: "FOR005",
                morada: "Coimbra, Portugal",
                pessoaContacto: "Ricardo Moreira",
                telefone: "+351 910 111 222",
                tipo: "Fabricante",
                observacoes: "Fornecedor do equipamento."
            }
        ],

        localizacao: "LOC005",
        observacoesLocalizacao: "Equipamento afeto ao serviço de Radiologia.",

        dataInicioGarantia: "20/02/2024",
        dataFimGarantia: "20/02/2028",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia ACUSON Redwood",
        dataCertificadoGarantia: "20/02/2024",
        validadeCertificadoGarantia: "20/02/2028",
        ficheiroGarantia: "certificado_garantia_EQ016.pdf",

        observacoesGarantia: "Garantia válida.",

        contratoManutencao: "Não",
        tipoContrato: "Não existe",
        entidadeResponsavelContrato: "Não existe",
        periodicidadeContrato: "Não aplicável",

        temDocumentacaoContrato: "nao",
        nomeContratoManutencao: "",
        dataContratoManutencao: "",
        validadeContratoManutencao: "",
        ficheiroContratoManutencao: "",

        temRelatorioContrato: "nao",
        nomeRelatorioManutencao: "",
        dataRelatorioManutencao: "",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração Redwood 2026",
        dataCertificadoCalibracao: "15/01/2026",
        validadeCertificadoCalibracao: "15/01/2027",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ016.pdf",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Equipamento sem contrato de manutenção ativo."
    },

    EQ017: {
        codigo: "EQ017",
        designacao: "Analisador Hematológico",
        categoria: "Laboratório",
        marca: "Sysmex",
        modelo: "XN-550",
        numeroSerie: "SY-XN550-2024-017",
        fabricante: "Sysmex Corporation",
        anoFabrico: "2024",
        estado: "Ativo",
        criticidade: "Alta",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Sysmex XN-550",
        dataManualTecnico: "12/03/2024",
        validadeManualTecnico: "12/03/2034",
        ficheiroManualTecnico: "manual_servico_EQ017.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Sysmex XN-550",
        dataManualUtilizacao: "12/03/2024",
        validadeManualUtilizacao: "12/03/2034",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ017.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Sysmex XN-550",
        dataDeclaracaoConformidade: "12/03/2024",
        validadeDeclaracaoConformidade: "12/03/2034",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ017.pdf",

        observacoes: "Equipamento utilizado para análises hematológicas de rotina e urgência.",

        acessorios: [
            {
                nome: "Leitor de códigos de barras",
                referencia: "ACC-COD-017",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "UPS",
                referencia: "ACC-UPS-017",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Reagente diluente",
                referencia: "CON-DIL-017",
                quantidade: "8",
                unidade: "frasco",
                estado: "novo",
                observacoes: ""
            },
            {
                nome: "Controlo hematológico",
                referencia: "CON-CTL-017",
                quantidade: "4",
                unidade: "kit",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "18/03/2024",
        custoAquisicao: "29500 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Sysmex 2024",
        dataContratoAquisicao: "18/03/2024",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ017.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Sysmex XN-550",
        dataFatura: "18/03/2024",
        ficheiroFatura: "fatura_EQ017.pdf",

        observacoesAquisicao: "Aquisição destinada à modernização do laboratório clínico.",

        fornecedores: [
            {
                codigo: "FOR009",
                morada: "Lisboa, Portugal",
                pessoaContacto: "Tiago Oliveira",
                telefone: "+351 910 555 666",
                tipo: "Fornecedor de consumíveis ou acessórios",
                observacoes: "Fornecedor dos reagentes laboratoriais."
            },
            {
                codigo: "FOR003",
                morada: "Aveiro, Portugal",
                pessoaContacto: "Carla Ferreira",
                telefone: "+351 930 000 000",
                tipo: "Distribuidor ou Fornecedor comercial",
                observacoes: "Fornecedor responsável pela entrega e instalação."
            }
        ],

        localizacao: "LOC011",
        observacoesLocalizacao: "Equipamento instalado no Laboratório Clínico.",

        dataInicioGarantia: "18/03/2024",
        dataFimGarantia: "18/03/2027",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Sysmex XN-550",
        dataCertificadoGarantia: "18/03/2024",
        validadeCertificadoGarantia: "18/03/2027",
        ficheiroGarantia: "certificado_garantia_EQ017.pdf",

        observacoesGarantia: "Garantia válida.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "MedSupply Portugal",
        periodicidadeContrato: "Semestral",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção Sysmex 2026",
        dataContratoManutencao: "01/01/2026",
        validadeContratoManutencao: "31/12/2026",
        ficheiroContratoManutencao: "contrato_manutencao_EQ017.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Preventivo Laboratório 2026",
        dataRelatorioManutencao: "10/01/2026",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ017.pdf",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração XN-550",
        dataCertificadoCalibracao: "10/01/2026",
        validadeCertificadoCalibracao: "10/01/2027",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ017.pdf",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Contrato de manutenção preventiva semestral ativo."
    },

    EQ018: {
        codigo: "EQ018",
        designacao: "Bomba de Seringa",
        categoria: "Terapia",
        marca: "B. Braun",
        modelo: "Perfusor Compact Plus",
        numeroSerie: "BB-PCP-2023-018",
        fabricante: "B. Braun Medical",
        anoFabrico: "2023",
        estado: "Ativo",
        criticidade: "Alta",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Perfusor Compact Plus",
        dataManualTecnico: "18/07/2023",
        validadeManualTecnico: "18/07/2033",
        ficheiroManualTecnico: "manual_servico_EQ018.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Perfusor Compact Plus",
        dataManualUtilizacao: "18/07/2023",
        validadeManualUtilizacao: "18/07/2033",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ018.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Perfusor Compact Plus",
        dataDeclaracaoConformidade: "18/07/2023",
        validadeDeclaracaoConformidade: "18/07/2033",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ018.pdf",

        observacoes: "Equipamento utilizado na administração precisa de medicamentos e terapêuticas intravenosas.",

        acessorios: [
            {
                nome: "Suporte de fixação",
                referencia: "ACC-SUP-018",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Seringas 50 ml",
                referencia: "CON-SER-018",
                quantidade: "120",
                unidade: "unid",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "18/07/2023",
        custoAquisicao: "2450 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Bomba Seringa 2023",
        dataContratoAquisicao: "18/07/2023",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ018.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Bomba Seringa 2023",
        dataFatura: "18/07/2023",
        ficheiroFatura: "fatura_EQ018.pdf",

        observacoesAquisicao: "Aquisição destinada ao Serviço de Medicina.",

        fornecedores: [
            {
                codigo: "FOR007",
                morada: "Faro, Portugal",
                pessoaContacto: "Pedro Costa",
                telefone: "+351 910 333 444",
                tipo: "Fabricante",
                observacoes: "Fornecedor principal."
            }
        ],

        localizacao: "LOC003",
        observacoesLocalizacao: "Equipamento disponível para terapêutica intravenosa.",

        dataInicioGarantia: "18/07/2023",
        dataFimGarantia: "30/06/2026",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Perfusor Compact Plus",
        dataCertificadoGarantia: "18/07/2023",
        validadeCertificadoGarantia: "30/06/2026",
        ficheiroGarantia: "certificado_garantia_EQ018.pdf",

        observacoesGarantia: "Garantia a expirar nos próximos 30 dias.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "B. Braun Medical",
        periodicidadeContrato: "Anual",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção B. Braun 2026",
        dataContratoManutencao: "01/01/2026",
        validadeContratoManutencao: "31/12/2026",
        ficheiroContratoManutencao: "contrato_manutencao_EQ018.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Preventivo 2026",
        dataRelatorioManutencao: "15/02/2026",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ018.pdf",

        temDocumentacaoCalibracao: "nao",
        nomeCertificadoCalibracao: "",
        dataCertificadoCalibracao: "",
        validadeCertificadoCalibracao: "",
        ficheiroCertificadoCalibracao: "",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Contrato de manutenção preventiva ativo."
    },

    EQ019: {
        codigo: "EQ019",
        designacao: "Termodesinfetadora",
        categoria: "Esterilização",
        marca: "Getinge",
        modelo: "WD15 Claro",
        numeroSerie: "GT-WD15-2019-019",
        fabricante: "Getinge",
        anoFabrico: "2019",
        estado: "Ativo",
        criticidade: "Média",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Getinge WD15 Claro",
        dataManualTecnico: "15/04/2019",
        validadeManualTecnico: "15/04/2029",
        ficheiroManualTecnico: "manual_servico_EQ019.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Getinge WD15 Claro",
        dataManualUtilizacao: "15/04/2019",
        validadeManualUtilizacao: "15/04/2029",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ019.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade WD15 Claro",
        dataDeclaracaoConformidade: "15/04/2019",
        validadeDeclaracaoConformidade: "15/04/2029",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ019.pdf",

        observacoes: "Equipamento destinado à lavagem e desinfeção de instrumentos clínicos.",

        acessorios: [
            {
                nome: "Cesto para instrumentos",
                referencia: "ACC-CES-019",
                quantidade: "6",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Detergente enzimático",
                referencia: "CON-DET-019",
                quantidade: "10",
                unidade: "frasco",
                estado: "novo",
                observacoes: ""
            },
            {
                nome: "Neutralizante",
                referencia: "CON-NEU-019",
                quantidade: "6",
                unidade: "frasco",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "20/05/2019",
        custoAquisicao: "18500 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição WD15 2019",
        dataContratoAquisicao: "20/05/2019",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ019.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura WD15 2019",
        dataFatura: "20/05/2019",
        ficheiroFatura: "fatura_EQ019.pdf",

        observacoesAquisicao: "Aquisição para a Central de Esterilização.",

        fornecedores: [
            {
                codigo: "FOR003",
                morada: "Aveiro, Portugal",
                pessoaContacto: "Carla Ferreira",
                telefone: "+351 930 000 000",
                tipo: "Distribuidor ou Fornecedor comercial",
                observacoes: "Fornecedor responsável pela instalação."
            },
            {
                codigo: "FOR004",
                morada: "Coimbra, Portugal",
                pessoaContacto: "João Almeida",
                telefone: "+351 930 000 400",
                tipo: "Empresa de assistência técnica",
                observacoes: "Responsável pela manutenção."
            }
        ],

        localizacao: "LOC008",
        observacoesLocalizacao: "Equipamento instalado na Central de Esterilização.",

        dataInicioGarantia: "20/05/2019",
        dataFimGarantia: "20/05/2022",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Getinge WD15",
        dataCertificadoGarantia: "20/05/2019",
        validadeCertificadoGarantia: "20/05/2022",
        ficheiroGarantia: "certificado_garantia_EQ019.pdf",

        observacoesGarantia: "Garantia expirada.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "TecnoMed Assistência",
        periodicidadeContrato: "Semestral",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção WD15 2026",
        dataContratoManutencao: "01/01/2026",
        validadeContratoManutencao: "31/12/2026",
        ficheiroContratoManutencao: "contrato_manutencao_EQ019.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Preventivo WD15 2026",
        dataRelatorioManutencao: "10/01/2026",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ019.pdf",

        temDocumentacaoCalibracao: "nao",
        nomeCertificadoCalibracao: "",
        dataCertificadoCalibracao: "",
        validadeCertificadoCalibracao: "",
        ficheiroCertificadoCalibracao: "",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Contrato de manutenção preventiva ativo."
    },

    EQ020: {
        codigo: "EQ020",
        designacao: "Incubadora Neonatal",
        categoria: "Suporte de vida",
        marca: "Dräger",
        modelo: "Isolette 8000 Plus",
        numeroSerie: "DR-ISO-2023-020",
        fabricante: "Dräger",
        anoFabrico: "2023",
        estado: "Ativo",
        criticidade: "Suporte de vida",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Isolette 8000 Plus",
        dataManualTecnico: "05/05/2023",
        validadeManualTecnico: "05/05/2033",
        ficheiroManualTecnico: "manual_servico_EQ020.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Isolette 8000 Plus",
        dataManualUtilizacao: "05/05/2023",
        validadeManualUtilizacao: "05/05/2033",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ020.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Isolette 8000 Plus",
        dataDeclaracaoConformidade: "05/05/2023",
        validadeDeclaracaoConformidade: "05/05/2033",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ020.pdf",

        observacoes: "Equipamento utilizado para cuidados intensivos neonatais.",

        acessorios: [
            {
                nome: "Sensor de temperatura",
                referencia: "ACC-TMP-020",
                quantidade: "2",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Colchão neonatal",
                referencia: "ACC-COL-020",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Filtro de ar",
                referencia: "CON-FIL-020",
                quantidade: "10",
                unidade: "unid",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "05/05/2023",
        custoAquisicao: "28750 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Incubadora 2023",
        dataContratoAquisicao: "05/05/2023",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ020.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Incubadora 2023",
        dataFatura: "05/05/2023",
        ficheiroFatura: "fatura_EQ020.pdf",

        observacoesAquisicao: "Aquisição para a unidade neonatal.",

        fornecedores: [
            {
                codigo: "FOR002",
                morada: "Porto, Portugal",
                pessoaContacto: "Miguel Santos",
                telefone: "+351 920 000 000",
                tipo: "Fabricante",
                observacoes: "Fornecedor principal."
            }
        ],

        localizacao: "LOC009",
        observacoesLocalizacao: "Equipamento afeto à área pediátrica e neonatal.",

        dataInicioGarantia: "05/05/2023",
        dataFimGarantia: "05/07/2026",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Isolette 8000 Plus",
        dataCertificadoGarantia: "05/05/2023",
        validadeCertificadoGarantia: "05/07/2026",
        ficheiroGarantia: "certificado_garantia_EQ020.pdf",

        observacoesGarantia: "Garantia a expirar nos próximos 30 dias.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "Dräger",
        periodicidadeContrato: "Semestral",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção Isolette 2026",
        dataContratoManutencao: "01/01/2026",
        validadeContratoManutencao: "31/12/2026",
        ficheiroContratoManutencao: "contrato_manutencao_EQ020.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Preventivo Isolette 2026",
        dataRelatorioManutencao: "20/01/2026",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ020.pdf",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração Isolette",
        dataCertificadoCalibracao: "20/01/2026",
        validadeCertificadoCalibracao: "20/01/2027",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ020.pdf",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Equipamento crítico da unidade neonatal."
    },

    EQ021: {
        codigo: "EQ021",
        designacao: "Monitor Multiparamétrico",
        categoria: "Monitorização",
        marca: "GE HealthCare",
        modelo: "CARESCAPE B450",
        numeroSerie: "GE-B450-2021-021",
        fabricante: "GE HealthCare",
        anoFabrico: "2021",
        estado: "Em manutenção",
        criticidade: "Alta",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico CARESCAPE B450",
        dataManualTecnico: "10/03/2021",
        validadeManualTecnico: "10/03/2031",
        ficheiroManualTecnico: "manual_servico_EQ021.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização CARESCAPE B450",
        dataManualUtilizacao: "10/03/2021",
        validadeManualUtilizacao: "10/03/2031",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ021.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade CARESCAPE B450",
        dataDeclaracaoConformidade: "10/03/2021",
        validadeDeclaracaoConformidade: "10/03/2031",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ021.pdf",

        observacoes: "Equipamento temporariamente indisponível para manutenção corretiva.",

        acessorios: [
            {
                nome: "Sensor SpO2",
                referencia: "ACC-SPO2-021",
                quantidade: "2",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Cabo ECG",
                referencia: "ACC-ECG-021",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Elétrodos ECG",
                referencia: "CON-ECG-021",
                quantidade: "200",
                unidade: "unid",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "25/03/2021",
        custoAquisicao: "7200 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Monitor GE 2021",
        dataContratoAquisicao: "25/03/2021",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ021.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Monitor GE 2021",
        dataFatura: "25/03/2021",
        ficheiroFatura: "fatura_EQ021.pdf",

        observacoesAquisicao: "Aquisição destinada à monitorização contínua de doentes.",

        fornecedores: [
            {
                codigo: "FOR006",
                morada: "Região Autónoma da Madeira, Portugal",
                pessoaContacto: "Ana Ribeiro",
                telefone: "+351 910 222 333",
                tipo: "Fabricante",
                observacoes: "Fornecedor principal."
            },
            {
                codigo: "FOR004",
                morada: "Coimbra, Portugal",
                pessoaContacto: "João Almeida",
                telefone: "+351 930 656 375",
                tipo: "Empresa de assistência técnica",
                observacoes: "Responsável pela manutenção corretiva."
            }
        ],

        localizacao: "LOC001",
        observacoesLocalizacao: "Equipamento afeto à Unidade de Cuidados Intensivos.",

        dataInicioGarantia: "25/03/2021",
        dataFimGarantia: "25/03/2024",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia CARESCAPE B450",
        dataCertificadoGarantia: "25/03/2021",
        validadeCertificadoGarantia: "25/03/2024",
        ficheiroGarantia: "certificado_garantia_EQ021.pdf",

        observacoesGarantia: "Garantia expirada.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção corretiva",
        entidadeResponsavelContrato: "TecnoMed Assistência",
        periodicidadeContrato: "Anual",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção GE 2026",
        dataContratoManutencao: "01/01/2026",
        validadeContratoManutencao: "31/12/2026",
        ficheiroContratoManutencao: "contrato_manutencao_EQ021.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Corretivo B450",
        dataRelatorioManutencao: "05/06/2026",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ021.pdf",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração B450",
        dataCertificadoCalibracao: "15/02/2026",
        validadeCertificadoCalibracao: "15/02/2027",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ021.pdf",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Equipamento em manutenção corretiva devido a falha no módulo de ECG."
    },

    EQ022: {
        codigo: "EQ022",
        designacao: "Eletrocardiógrafo",
        categoria: "Diagnóstico",
        marca: "Philips",
        modelo: "PageWriter TC35",
        numeroSerie: "PH-TC35-2022-022",
        fabricante: "Philips Healthcare",
        anoFabrico: "2022",
        estado: "Em calibração",
        criticidade: "Média",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico PageWriter TC35",
        dataManualTecnico: "12/05/2022",
        validadeManualTecnico: "12/05/2032",
        ficheiroManualTecnico: "manual_servico_EQ022.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização PageWriter TC35",
        dataManualUtilizacao: "12/05/2022",
        validadeManualUtilizacao: "12/05/2032",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ022.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade PageWriter TC35",
        dataDeclaracaoConformidade: "12/05/2022",
        validadeDeclaracaoConformidade: "12/05/2032",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ022.pdf",

        observacoes: "Equipamento temporariamente indisponível por se encontrar em processo de calibração.",

        acessorios: [
            {
                nome: "Cabo ECG 10 derivações",
                referencia: "ACC-ECG-022",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Carro de transporte",
                referencia: "ACC-CAR-022",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Papel térmico ECG",
                referencia: "CON-PAP-022",
                quantidade: "15",
                unidade: "rolo",
                estado: "novo",
                observacoes: ""
            },
            {
                nome: "Elétrodos descartáveis",
                referencia: "CON-ELE-022",
                quantidade: "300",
                unidade: "unid",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "20/06/2022",
        custoAquisicao: "4200 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição ECG 2022",
        dataContratoAquisicao: "20/06/2022",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ022.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura ECG Philips 2022",
        dataFatura: "20/06/2022",
        ficheiroFatura: "fatura_EQ022.pdf",

        observacoesAquisicao: "Equipamento destinado à realização de eletrocardiogramas.",

        fornecedores: [
            {
                codigo: "FOR001",
                morada: "Lisboa, Portugal",
                pessoaContacto: "Catarina Silva",
                telefone: "+351 910 000 000",
                tipo: "Fabricante",
                observacoes: "Fornecedor principal."
            },
            {
                codigo: "FOR004",
                morada: "Coimbra, Portugal",
                pessoaContacto: "João Almeida",
                telefone: "+351 930 656 375",
                tipo: "Empresa de assistência técnica",
                observacoes: "Responsável pela calibração."
            }
        ],

        localizacao: "LOC010",
        observacoesLocalizacao: "Equipamento afeto ao serviço de Cardiologia.",

        dataInicioGarantia: "20/06/2022",
        dataFimGarantia: "20/06/2025",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia PageWriter TC35",
        dataCertificadoGarantia: "20/06/2022",
        validadeCertificadoGarantia: "20/06/2025",
        ficheiroGarantia: "certificado_garantia_EQ022.pdf",

        observacoesGarantia: "Garantia expirada.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "TecnoMed Assistência",
        periodicidadeContrato: "Anual",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção ECG 2026",
        dataContratoManutencao: "01/01/2026",
        validadeContratoManutencao: "31/12/2026",
        ficheiroContratoManutencao: "contrato_manutencao_EQ022.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Preventivo ECG 2026",
        dataRelatorioManutencao: "15/01/2026",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ022.pdf",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração TC35",
        dataCertificadoCalibracao: "10/06/2026",
        validadeCertificadoCalibracao: "10/06/2027",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ022.pdf",

        temRelatorioCalibracao: "sim",
        nomeRelatorioCalibracao: "Relatório Calibração TC35",
        dataRelatorioCalibracao: "10/06/2026",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "relatorio_calibracao_EQ022.pdf",

        observacoesContrato: "Equipamento atualmente em processo de calibração anual obrigatória."
    },

    EQ023: {
        codigo: "EQ023",
        designacao: "Cicloergómetro de Reabilitação",
        categoria: "Reabilitação",
        marca: "Ergoline",
        modelo: "Ergoselect 200",
        numeroSerie: "ER-200-2018-023",
        fabricante: "Ergoline GmbH",
        anoFabrico: "2018",
        estado: "Inativo",
        criticidade: "Baixa",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Ergoselect 200",
        dataManualTecnico: "15/03/2018",
        validadeManualTecnico: "15/03/2028",
        ficheiroManualTecnico: "manual_servico_EQ023.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Ergoselect 200",
        dataManualUtilizacao: "15/03/2018",
        validadeManualUtilizacao: "15/03/2028",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ023.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Ergoselect 200",
        dataDeclaracaoConformidade: "15/03/2018",
        validadeDeclaracaoConformidade: "15/03/2028",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ023.pdf",

        observacoes: "Equipamento temporariamente sem utilização devido à renovação da área de reabilitação.",

        acessorios: [
            {
                nome: "Sensor de frequência cardíaca",
                referencia: "ACC-FC-023",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [],

        dataAquisicao: "20/04/2018",
        custoAquisicao: "6200 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Ergoselect 2018",
        dataContratoAquisicao: "20/04/2018",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ023.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Ergoselect 2018",
        dataFatura: "20/04/2018",
        ficheiroFatura: "fatura_EQ023.pdf",

        observacoesAquisicao: "Equipamento adquirido para programas de reabilitação cardiovascular.",

        fornecedores: [
            {
                codigo: "FOR008",
                morada: "Braga, Portugal",
                pessoaContacto: "Sofia Martins",
                telefone: "+351 910 444 555",
                tipo: "Fabricante",
                observacoes: "Fornecedor principal."
            }
        ],

        localizacao: "LOC012",
        observacoesLocalizacao: "Equipamento armazenado temporariamente durante remodelação da sala.",

        dataInicioGarantia: "20/04/2018",
        dataFimGarantia: "20/04/2021",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Ergoselect 200",
        dataCertificadoGarantia: "20/04/2018",
        validadeCertificadoGarantia: "20/04/2021",
        ficheiroGarantia: "certificado_garantia_EQ023.pdf",

        observacoesGarantia: "Garantia expirada.",

        contratoManutencao: "Não",
        tipoContrato: "Não existe",
        entidadeResponsavelContrato: "Não existe",
        periodicidadeContrato: "Não aplicável",

        temDocumentacaoContrato: "nao",
        nomeContratoManutencao: "",
        dataContratoManutencao: "",
        validadeContratoManutencao: "",
        ficheiroContratoManutencao: "",

        temRelatorioContrato: "nao",
        nomeRelatorioManutencao: "",
        dataRelatorioManutencao: "",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "",

        temDocumentacaoCalibracao: "nao",
        nomeCertificadoCalibracao: "",
        dataCertificadoCalibracao: "",
        validadeCertificadoCalibracao: "",
        ficheiroCertificadoCalibracao: "",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Equipamento inativo devido à reorganização da área de reabilitação."
    },

    EQ024: {
        codigo: "EQ024",
        designacao: "Bomba Volumétrica",
        categoria: "Terapia",
        marca: "B. Braun",
        modelo: "Infusomat Space",
        numeroSerie: "BB-INF-2020-024",
        fabricante: "B. Braun Medical",
        anoFabrico: "2020",
        estado: "Em quarentena",
        criticidade: "Alta",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Infusomat Space",
        dataManualTecnico: "15/01/2020",
        validadeManualTecnico: "15/01/2030",
        ficheiroManualTecnico: "manual_servico_EQ024.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Infusomat Space",
        dataManualUtilizacao: "15/01/2020",
        validadeManualUtilizacao: "15/01/2030",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ024.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Infusomat Space",
        dataDeclaracaoConformidade: "15/01/2020",
        validadeDeclaracaoConformidade: "15/01/2030",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ024.pdf",

        observacoes: "Equipamento temporariamente isolado para avaliação técnica após ocorrência de alarme recorrente.",

        acessorios: [
            {
                nome: "Suporte de fixação",
                referencia: "ACC-SUP-024",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Equipos de infusão",
                referencia: "CON-INF-024",
                quantidade: "100",
                unidade: "unid",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "20/02/2020",
        custoAquisicao: "3900 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Infusomat 2020",
        dataContratoAquisicao: "20/02/2020",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ024.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Infusomat 2020",
        dataFatura: "20/02/2020",
        ficheiroFatura: "fatura_EQ024.pdf",

        observacoesAquisicao: "Equipamento destinado à administração controlada de terapêutica intravenosa.",

        fornecedores: [
            {
                codigo: "FOR007",
                morada: "Faro, Portugal",
                pessoaContacto: "Pedro Costa",
                telefone: "+351 910 333 444",
                tipo: "Fabricante",
                observacoes: "Fornecedor principal."
            },
            {
                codigo: "FOR004",
                morada: "Coimbra, Portugal",
                pessoaContacto: "João Almeida",
                telefone: "+351 930 656 375",
                tipo: "Empresa de assistência técnica",
                observacoes: "Responsável pela avaliação técnica."
            }
        ],

        localizacao: "LOC003",
        observacoesLocalizacao: "Equipamento removido temporariamente do serviço para avaliação.",

        dataInicioGarantia: "20/02/2020",
        dataFimGarantia: "20/02/2023",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Infusomat Space",
        dataCertificadoGarantia: "20/02/2020",
        validadeCertificadoGarantia: "20/02/2023",
        ficheiroGarantia: "certificado_garantia_EQ024.pdf",

        observacoesGarantia: "Garantia expirada.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção corretiva",
        entidadeResponsavelContrato: "TecnoMed Assistência",
        periodicidadeContrato: "Anual",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção Infusomat 2026",
        dataContratoManutencao: "01/01/2026",
        validadeContratoManutencao: "15/07/2026",
        ficheiroContratoManutencao: "contrato_manutencao_EQ024.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Avaliação Técnica 2026",
        dataRelatorioManutencao: "08/06/2026",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ024.pdf",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração Infusomat",
        dataCertificadoCalibracao: "10/02/2026",
        validadeCertificadoCalibracao: "10/02/2027",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ024.pdf",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Contrato ativo. Equipamento em quarentena para análise de ocorrência técnica."
    },

    EQ025: {
        codigo: "EQ025",
        designacao: "Analisador Bioquímico",
        categoria: "Laboratório",
        marca: "Roche",
        modelo: "cobas c 311",
        numeroSerie: "RC-C311-2024-025",
        fabricante: "Roche Diagnostics",
        anoFabrico: "2024",
        estado: "Ativo",
        criticidade: "Média",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Cobas c 311",
        dataManualTecnico: "10/02/2024",
        validadeManualTecnico: "10/02/2034",
        ficheiroManualTecnico: "manual_servico_EQ025.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Cobas c 311",
        dataManualUtilizacao: "10/02/2024",
        validadeManualUtilizacao: "10/02/2034",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ025.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Cobas c 311",
        dataDeclaracaoConformidade: "10/02/2024",
        validadeDeclaracaoConformidade: "10/02/2034",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ025.pdf",

        observacoes: "Equipamento utilizado para análises bioquímicas de rotina.",

        acessorios: [
            {
                nome: "Leitor de código de barras",
                referencia: "ACC-COD-025",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Reagente bioquímico",
                referencia: "CON-REA-025",
                quantidade: "12",
                unidade: "kit",
                estado: "novo",
                observacoes: ""
            },
            {
                nome: "Calibrador",
                referencia: "CON-CAL-025",
                quantidade: "4",
                unidade: "kit",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "01/08/2024",
        custoAquisicao: "0 €",
        tipoEntrada: "Empréstimo",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de empréstimo",
        nomeContratoAquisicao: "Contrato Empréstimo Cobas c311",
        dataContratoAquisicao: "01/08/2024",
        validadeContratoAquisicao: "01/08/2027",
        ficheiroContratoAquisicao: "contrato_emprestimo_EQ025.pdf",

        temFatura: "nao",
        nomeFatura: "",
        dataFatura: "",
        ficheiroFatura: "",

        observacoesAquisicao: "Equipamento cedido temporariamente ao hospital.",

        fornecedores: [
            {
                codigo: "FOR009",
                morada: "Lisboa, Portugal",
                pessoaContacto: "Tiago Oliveira",
                telefone: "+351 910 555 666",
                tipo: "Fornecedor de consumíveis ou acessórios",
                observacoes: "Fornecedor principal."
            }
        ],

        localizacao: "LOC011",
        observacoesLocalizacao: "Equipamento instalado no Laboratório Clínico.",

        dataInicioGarantia: "01/08/2024",
        dataFimGarantia: "12/07/2026",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Cobas c311",
        dataCertificadoGarantia: "01/08/2024",
        validadeCertificadoGarantia: "12/07/2026",
        ficheiroGarantia: "certificado_garantia_EQ025.pdf",

        observacoesGarantia: "Garantia a expirar nos próximos 30 dias.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "Roche Diagnostics",
        periodicidadeContrato: "Trimestral",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção Roche 2026",
        dataContratoManutencao: "01/01/2026",
        validadeContratoManutencao: "31/12/2026",
        ficheiroContratoManutencao: "contrato_manutencao_EQ025.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Trimestral 2026",
        dataRelatorioManutencao: "01/04/2026",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ025.pdf",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração Cobas c311",
        dataCertificadoCalibracao: "01/04/2026",
        validadeCertificadoCalibracao: "01/04/2027",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ025.pdf",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Equipamento cedido através de contrato de empréstimo com manutenção incluída."
    },

    EQ026: {
        codigo: "EQ026",
        designacao: "Holter Cardíaco",
        categoria: "Monitorização",
        marca: "GE HealthCare",
        modelo: "SEER 1000",
        numeroSerie: "GE-SEER-2015-026",
        fabricante: "GE HealthCare",
        anoFabrico: "2015",
        estado: "Abatido",
        criticidade: "Baixa",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico SEER 1000",
        dataManualTecnico: "10/02/2015",
        validadeManualTecnico: "10/02/2025",
        ficheiroManualTecnico: "manual_servico_EQ026.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização SEER 1000",
        dataManualUtilizacao: "10/02/2015",
        validadeManualUtilizacao: "10/02/2025",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ026.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade SEER 1000",
        dataDeclaracaoConformidade: "10/02/2015",
        validadeDeclaracaoConformidade: "10/02/2025",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ026.pdf",

        observacoes: "Equipamento retirado definitivamente de serviço devido à obsolescência tecnológica.",

        acessorios: [
            {
                nome: "Bolsa de transporte",
                referencia: "ACC-BOL-026",
                quantidade: "1",
                unidade: "unid",
                estado: "fora-de-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Elétrodos descartáveis",
                referencia: "CON-ELE-026",
                quantidade: "0",
                unidade: "unid",
                estado: "esgotado",
                observacoes: ""
            }
        ],

        dataAquisicao: "20/03/2015",
        custoAquisicao: "2800 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Holter 2015",
        dataContratoAquisicao: "20/03/2015",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ026.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Holter 2015",
        dataFatura: "20/03/2015",
        ficheiroFatura: "fatura_EQ026.pdf",

        observacoesAquisicao: "Equipamento destinado ao serviço de Cardiologia.",

        fornecedores: [
            {
                codigo: "FOR006",
                morada: "Região Autónoma da Madeira, Portugal",
                pessoaContacto: "Ana Ribeiro",
                telefone: "+351 910 222 333",
                tipo: "Fabricante",
                observacoes: "Fornecedor principal."
            }
        ],

        localizacao: "LOC007",
        observacoesLocalizacao: "Equipamento armazenado em área de equipamentos abatidos.",

        dataInicioGarantia: "20/03/2015",
        dataFimGarantia: "20/03/2018",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia SEER 1000",
        dataCertificadoGarantia: "20/03/2015",
        validadeCertificadoGarantia: "20/03/2018",
        ficheiroGarantia: "certificado_garantia_EQ026.pdf",

        observacoesGarantia: "Garantia expirada.",

        contratoManutencao: "Não",
        tipoContrato: "Não existe",
        entidadeResponsavelContrato: "Não existe",
        periodicidadeContrato: "Não aplicável",

        temDocumentacaoContrato: "nao",
        nomeContratoManutencao: "",
        dataContratoManutencao: "",
        validadeContratoManutencao: "",
        ficheiroContratoManutencao: "",

        temRelatorioContrato: "nao",
        nomeRelatorioManutencao: "",
        dataRelatorioManutencao: "",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "",

        temDocumentacaoCalibracao: "nao",
        nomeCertificadoCalibracao: "",
        dataCertificadoCalibracao: "",
        validadeCertificadoCalibracao: "",
        ficheiroCertificadoCalibracao: "",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Equipamento abatido após substituição por modelo mais recente."
    },

    EQ027: {
        codigo: "EQ027",
        designacao: "Ecógrafo Portátil",
        categoria: "Diagnóstico",
        marca: "Philips",
        modelo: "Lumify",
        numeroSerie: "PH-LUM-2025-027",
        fabricante: "Philips Healthcare",
        anoFabrico: "2025",
        estado: "Ativo",
        criticidade: "Média",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Philips Lumify",
        dataManualTecnico: "15/01/2025",
        validadeManualTecnico: "15/01/2035",
        ficheiroManualTecnico: "manual_servico_EQ027.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Philips Lumify",
        dataManualUtilizacao: "15/01/2025",
        validadeManualUtilizacao: "15/01/2035",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ027.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Philips Lumify",
        dataDeclaracaoConformidade: "15/01/2025",
        validadeDeclaracaoConformidade: "15/01/2035",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ027.pdf",

        observacoes: "Ecógrafo portátil utilizado para avaliações rápidas à cabeceira do doente.",

        acessorios: [
            {
                nome: "Sonda convexa",
                referencia: "ACC-SON-027",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Tablet clínico",
                referencia: "ACC-TAB-027",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Gel de ultrassom",
                referencia: "CON-GEL-027",
                quantidade: "20",
                unidade: "frasco",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "01/02/2025",
        custoAquisicao: "450 € / mês",
        tipoEntrada: "Aluguer",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aluguer",
        nomeContratoAquisicao: "Contrato Aluguer Lumify",
        dataContratoAquisicao: "01/02/2025",
        validadeContratoAquisicao: "31/01/2027",
        ficheiroContratoAquisicao: "contrato_aluguer_EQ027.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Aluguer Fevereiro 2025",
        dataFatura: "01/02/2025",
        ficheiroFatura: "fatura_EQ027.pdf",

        observacoesAquisicao: "Equipamento alugado para reforço da capacidade de diagnóstico.",

        fornecedores: [
            {
                codigo: "FOR001",
                morada: "Lisboa, Portugal",
                pessoaContacto: "Catarina Silva",
                telefone: "+351 910 000 000",
                tipo: "Fabricante",
                observacoes: "Fornecedor do equipamento."
            }
        ],

        localizacao: "LOC004",
        observacoesLocalizacao: "Equipamento móvel utilizado em vários serviços.",

        dataInicioGarantia: "01/02/2025",
        dataFimGarantia: "01/02/2028",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Philips Lumify",
        dataCertificadoGarantia: "01/02/2025",
        validadeCertificadoGarantia: "01/02/2028",
        ficheiroGarantia: "certificado_garantia_EQ027.pdf",

        observacoesGarantia: "Garantia ativa.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "Philips Healthcare",
        periodicidadeContrato: "Anual",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção Lumify",
        dataContratoManutencao: "01/01/2026",
        validadeContratoManutencao: "31/12/2026",
        ficheiroContratoManutencao: "contrato_manutencao_EQ027.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Preventivo Lumify",
        dataRelatorioManutencao: "12/02/2026",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ027.pdf",

        temDocumentacaoCalibracao: "nao",
        nomeCertificadoCalibracao: "",
        dataCertificadoCalibracao: "",
        validadeCertificadoCalibracao: "",
        ficheiroCertificadoCalibracao: "",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Equipamento alugado com manutenção incluída no contrato."
    },

    EQ028: {
        codigo: "EQ028",
        designacao: "Ventilador de Transporte",
        categoria: "Suporte de vida",
        marca: "Dräger",
        modelo: "Oxylog 3000 Plus",
        numeroSerie: "DR-OXY-2019-028",
        fabricante: "Dräger",
        anoFabrico: "2019",
        estado: "Inativo",
        criticidade: "Suporte de vida",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Oxylog 3000 Plus",
        dataManualTecnico: "12/04/2019",
        validadeManualTecnico: "12/04/2029",
        ficheiroManualTecnico: "manual_servico_EQ028.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Oxylog 3000 Plus",
        dataManualUtilizacao: "12/04/2019",
        validadeManualUtilizacao: "12/04/2029",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ028.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Oxylog 3000 Plus",
        dataDeclaracaoConformidade: "12/04/2019",
        validadeDeclaracaoConformidade: "12/04/2029",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ028.pdf",

        observacoes: "Equipamento de reserva atualmente fora de utilização por falta de necessidade operacional.",

        acessorios: [
            {
                nome: "Circuito respiratório reutilizável",
                referencia: "ACC-CIR-028",
                quantidade: "2",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Mala de transporte",
                referencia: "ACC-MAL-028",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Filtro respiratório",
                referencia: "CON-FIL-028",
                quantidade: "15",
                unidade: "unid",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "10/05/2019",
        custoAquisicao: "9800 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Oxylog 2019",
        dataContratoAquisicao: "10/05/2019",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ028.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Oxylog 2019",
        dataFatura: "10/05/2019",
        ficheiroFatura: "fatura_EQ028.pdf",

        observacoesAquisicao: "Aquisição para utilização em transporte intra-hospitalar e ambulâncias.",

        fornecedores: [
            {
                codigo: "FOR002",
                morada: "Porto, Portugal",
                pessoaContacto: "Miguel Santos",
                telefone: "+351 920 000 000",
                tipo: "Fabricante",
                observacoes: "Fornecedor original do equipamento."
            }
        ],

        localizacao: "LOC006",
        observacoesLocalizacao: "Equipamento armazenado como unidade de reserva.",

        dataInicioGarantia: "10/05/2019",
        dataFimGarantia: "10/05/2022",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Oxylog 3000 Plus",
        dataCertificadoGarantia: "10/05/2019",
        validadeCertificadoGarantia: "10/05/2022",
        ficheiroGarantia: "certificado_garantia_EQ028.pdf",

        observacoesGarantia: "Garantia expirada.",

        contratoManutencao: "Não",
        tipoContrato: "Não existe",
        entidadeResponsavelContrato: "Não existe",
        periodicidadeContrato: "Não aplicável",

        temDocumentacaoContrato: "nao",
        nomeContratoManutencao: "",
        dataContratoManutencao: "",
        validadeContratoManutencao: "",
        ficheiroContratoManutencao: "",

        temRelatorioContrato: "nao",
        nomeRelatorioManutencao: "",
        dataRelatorioManutencao: "",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração Oxylog",
        dataCertificadoCalibracao: "15/01/2026",
        validadeCertificadoCalibracao: "15/01/2027",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ028.pdf",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Equipamento mantido como reserva estratégica."
    },

    EQ029: {
        codigo: "EQ029",
        designacao: "Passadeira de Reabilitação",
        categoria: "Reabilitação",
        marca: "Biodex",
        modelo: "Gait Trainer 3",
        numeroSerie: "BD-GT3-2022-029",
        fabricante: "Biodex Medical Systems",
        anoFabrico: "2022",
        estado: "Ativo",
        criticidade: "Baixa",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico Gait Trainer 3",
        dataManualTecnico: "15/03/2022",
        validadeManualTecnico: "15/03/2032",
        ficheiroManualTecnico: "manual_servico_EQ029.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização Gait Trainer 3",
        dataManualUtilizacao: "15/03/2022",
        validadeManualUtilizacao: "15/03/2032",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ029.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade Gait Trainer 3",
        dataDeclaracaoConformidade: "15/03/2022",
        validadeDeclaracaoConformidade: "15/03/2032",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ029.pdf",

        observacoes: "Equipamento utilizado em programas de reabilitação motora e treino de marcha.",

        acessorios: [
            {
                nome: "Arnês de segurança",
                referencia: "ACC-ARN-029",
                quantidade: "2",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Barra de apoio lateral",
                referencia: "ACC-BAR-029",
                quantidade: "2",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [],

        dataAquisicao: "20/04/2022",
        custoAquisicao: "18500 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição Gait Trainer 2022",
        dataContratoAquisicao: "20/04/2022",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ029.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura Gait Trainer 2022",
        dataFatura: "20/04/2022",
        ficheiroFatura: "fatura_EQ029.pdf",

        observacoesAquisicao: "Aquisição destinada ao serviço de Medicina Física e Reabilitação.",

        fornecedores: [
            {
                codigo: "FOR008",
                morada: "Braga, Portugal",
                pessoaContacto: "Sofia Martins",
                telefone: "+351 910 444 555",
                tipo: "Fabricante",
                observacoes: "Fornecedor do equipamento."
            }
        ],

        localizacao: "LOC012",
        observacoesLocalizacao: "Equipamento utilizado diariamente em sessões de fisioterapia.",

        dataInicioGarantia: "20/04/2022",
        dataFimGarantia: "20/04/2025",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia Gait Trainer 3",
        dataCertificadoGarantia: "20/04/2022",
        validadeCertificadoGarantia: "20/04/2025",
        ficheiroGarantia: "certificado_garantia_EQ029.pdf",

        observacoesGarantia: "Garantia expirada.",

        contratoManutencao: "Não",
        tipoContrato: "Não existe",
        entidadeResponsavelContrato: "Não existe",
        periodicidadeContrato: "Não aplicável",

        temDocumentacaoContrato: "nao",
        nomeContratoManutencao: "",
        dataContratoManutencao: "",
        validadeContratoManutencao: "",
        ficheiroContratoManutencao: "",

        temRelatorioContrato: "nao",
        nomeRelatorioManutencao: "",
        dataRelatorioManutencao: "",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "",

        temDocumentacaoCalibracao: "nao",
        nomeCertificadoCalibracao: "",
        dataCertificadoCalibracao: "",
        validadeCertificadoCalibracao: "",
        ficheiroCertificadoCalibracao: "",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Equipamento sem necessidade de contrato de manutenção dedicado."
    },

    EQ030: {
        codigo: "EQ030",
        designacao: "Monitor de Sinais Vitais",
        categoria: "Monitorização",
        marca: "Philips",
        modelo: "IntelliVue MX550",
        numeroSerie: "PH-MX550-2025-030",
        fabricante: "Philips Healthcare",
        anoFabrico: "2025",
        estado: "Ativo",
        criticidade: "Alta",

        temDocumentacaoTecnica: "sim",
        tipoManualTecnico: "Manual de Serviço",
        nomeManualTecnico: "Manual Técnico IntelliVue MX550",
        dataManualTecnico: "15/02/2025",
        validadeManualTecnico: "15/02/2035",
        ficheiroManualTecnico: "manual_servico_EQ030.pdf",

        temDocumentacaoUtilizacao: "sim",
        tipoManualUtilizacao: "Manual de Utilização",
        nomeManualUtilizacao: "Manual de Utilização IntelliVue MX550",
        dataManualUtilizacao: "15/02/2025",
        validadeManualUtilizacao: "15/02/2035",
        ficheiroManualUtilizacao: "manual_utilizacao_EQ030.pdf",

        temDeclaracaoConformidade: "sim",
        nomeDeclaracaoConformidade: "Declaração de Conformidade IntelliVue MX550",
        dataDeclaracaoConformidade: "15/02/2025",
        validadeDeclaracaoConformidade: "15/02/2035",
        ficheiroDeclaracaoConformidade: "declaracao_conformidade_EQ030.pdf",

        observacoes: "Monitor multiparamétrico destinado à monitorização contínua de sinais vitais.",

        acessorios: [
            {
                nome: "Sensor SpO2",
                referencia: "ACC-SPO2-030",
                quantidade: "2",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Cabo ECG 5 derivações",
                referencia: "ACC-ECG-030",
                quantidade: "1",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            },
            {
                nome: "Braçadeira NIBP",
                referencia: "ACC-NIBP-030",
                quantidade: "2",
                unidade: "unid",
                estado: "em-uso",
                observacoes: ""
            }
        ],

        consumiveis: [
            {
                nome: "Elétrodos ECG",
                referencia: "CON-ECG-030",
                quantidade: "300",
                unidade: "unid",
                estado: "novo",
                observacoes: ""
            }
        ],

        dataAquisicao: "01/03/2025",
        custoAquisicao: "8450 €",
        tipoEntrada: "Compra",

        temContratoAquisicao: "sim",
        tipoContratoAquisicao: "Contrato de aquisição",
        nomeContratoAquisicao: "Contrato Aquisição IntelliVue MX550",
        dataContratoAquisicao: "01/03/2025",
        validadeContratoAquisicao: "",
        ficheiroContratoAquisicao: "contrato_aquisicao_EQ030.pdf",

        temFatura: "sim",
        tipoFatura: "Fatura",
        nomeFatura: "Fatura IntelliVue MX550",
        dataFatura: "01/03/2025",
        ficheiroFatura: "fatura_EQ030.pdf",

        observacoesAquisicao: "Aquisição para renovação tecnológica da Unidade de Cuidados Intensivos.",

        fornecedores: [
            {
                codigo: "FOR001",
                morada: "Lisboa, Portugal",
                pessoaContacto: "Catarina Silva",
                telefone: "+351 910 000 000",
                tipo: "Fabricante",
                observacoes: "Fornecedor principal."
            },
            {
                codigo: "FOR004",
                morada: "Coimbra, Portugal",
                pessoaContacto: "João Almeida",
                telefone: "+351 930 656 375",
                tipo: "Empresa de assistência técnica",
                observacoes: "Responsável pelo suporte técnico."
            }
        ],

        localizacao: "LOC001",
        observacoesLocalizacao: "Equipamento instalado na Unidade de Cuidados Intensivos.",

        dataInicioGarantia: "01/03/2025",
        dataFimGarantia: "01/03/2029",

        temDocumentacaoGarantia: "sim",
        tipoCertificadoGarantia: "Certificado de garantia",
        nomeCertificadoGarantia: "Garantia IntelliVue MX550",
        dataCertificadoGarantia: "01/03/2025",
        validadeCertificadoGarantia: "01/03/2029",
        ficheiroGarantia: "certificado_garantia_EQ030.pdf",

        observacoesGarantia: "Garantia válida.",

        contratoManutencao: "Sim",
        tipoContrato: "Manutenção preventiva",
        entidadeResponsavelContrato: "Philips Healthcare",
        periodicidadeContrato: "Anual",

        temDocumentacaoContrato: "sim",
        tipoContratoManutencao: "Contrato de manutenção",
        nomeContratoManutencao: "Contrato Manutenção IntelliVue 2026",
        dataContratoManutencao: "01/01/2026",
        validadeContratoManutencao: "31/12/2026",
        ficheiroContratoManutencao: "contrato_manutencao_EQ030.pdf",

        temRelatorioContrato: "sim",
        tipoRelatorioManutencao: "Relatório de manutenção",
        nomeRelatorioManutencao: "Relatório Preventivo IntelliVue 2026",
        dataRelatorioManutencao: "15/03/2026",
        validadeRelatorioManutencao: "",
        ficheiroRelatorioManutencao: "relatorio_manutencao_EQ030.pdf",

        temDocumentacaoCalibracao: "sim",
        tipoCertificadoCalibracao: "Certificado de calibração",
        nomeCertificadoCalibracao: "Certificado Calibração MX550",
        dataCertificadoCalibracao: "15/03/2026",
        validadeCertificadoCalibracao: "15/03/2027",
        ficheiroCertificadoCalibracao: "certificado_calibracao_EQ030.pdf",

        temRelatorioCalibracao: "nao",
        nomeRelatorioCalibracao: "",
        dataRelatorioCalibracao: "",
        validadeRelatorioCalibracao: "",
        ficheiroRelatorioCalibracao: "",

        observacoesContrato: "Equipamento novo com manutenção preventiva anual ativa."
    },
};

let equipamentosGuardados = JSON.parse(localStorage.getItem("equipamentosGuardados"));

if (!equipamentosGuardados) {
    equipamentosGuardados = equipamentosConsulta;
    localStorage.setItem("equipamentosGuardados", JSON.stringify(equipamentosGuardados));
}

function formatarEstadoEquipamento(estado) {
        const classes = {
            "Ativo": "estado-ativo",
            "Em manutenção": "estado-manutencao",
            "Em calibração": "estado-calibracao",
            "Inativo": "estado-inativo",
            "Em quarentena": "estado-quarentena",
            "Abatido": "estado-abatido"
        };
        const classe = classes[estado] || "";
        return classe
            ? `<span class="${classe}">${estado}</span>`
            : (estado || "-");
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

        const localizacaoAssociada =
            localizacoesGuardadas[equipamento.localizacao];

        const textoLocalizacao = localizacaoAssociada
            ? `${localizacaoAssociada.codigo}`
            : (equipamento.localizacao || "-");

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
    <td>${equipamento.codigo || "-"}</td>
    <td>${equipamento.designacao || "-"}</td>
    <td>${textoLocalizacao}</td>
    <td>${formatarEstadoEquipamento(equipamento.estado)}</td>
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
            const primeiroFornecedor =
                (equipamento.fornecedores && equipamento.fornecedores.length > 0)
                    ? equipamento.fornecedores[0]
                    : null;
            const localizacaoAssociada = localizacoesGuardadas[equipamento.localizacao];

            const textoFornecedor = primeiroFornecedor
                ? [
                    primeiroFornecedor.codigo,
                    primeiroFornecedor.nomeEmpresa,
                    primeiroFornecedor.pessoaContacto,
                    primeiroFornecedor.telefone
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

            const textoEquipamento = [

                // Identificação
                equipamento.codigo,
                equipamento.designacao,
                equipamento.categoria,
                equipamento.marca,
                equipamento.modelo,
                equipamento.numeroSerie,
                equipamento.fabricante,
                equipamento.anoFabrico,
                equipamento.estado,
                equipamento.criticidade,

                // Documentação Técnica
                equipamento.nomeManualTecnico,
                equipamento.dataManualTecnico,
                equipamento.validadeManualTecnico,

                // Documentação Utilização
                equipamento.nomeManualUtilizacao,
                equipamento.dataManualUtilizacao,
                equipamento.validadeManualUtilizacao,

                equipamento.observacoes,

                equipamento.acessorios
                    ? equipamento.acessorios.map(acessorio =>
                        [
                            acessorio.nome,
                            acessorio.referencia,
                            acessorio.quantidade,
                            acessorio.unidade,
                            acessorio.estado,
                            acessorio.observacoes
                        ].join(" ")
                    ).join(" ")
                    : "",

                equipamento.consumiveis
                    ? equipamento.consumiveis.map(consumivel =>
                        [
                            consumivel.nome,
                            consumivel.referencia,
                            consumivel.quantidade,
                            consumivel.unidade,
                            consumivel.estado,
                            consumivel.observacoes
                        ].join(" ")
                    ).join(" ")
                    : "",

                // Aquisição
                equipamento.dataAquisicao,
                equipamento.custoAquisicao,
                equipamento.tipoEntrada,

                // Contrato Aquisição
                equipamento.nomeContratoAquisicao,
                equipamento.dataContratoAquisicao,
                equipamento.validadeContratoAquisicao,

                // Fatura
                equipamento.nomeFatura,
                equipamento.dataFatura,

                equipamento.observacoesAquisicao,

                // Garantia
                equipamento.dataInicioGarantia,
                equipamento.dataFimGarantia,

                // certificado Garantia
                equipamento.nomeCertificadoGarantia,
                equipamento.dataCertificadoGarantia,
                equipamento.validadeCertificadoGarantia,

                equipamento.observacoesGarantia,

                // Contrato
                equipamento.contratoManutencao,
                equipamento.tipoContrato,
                equipamento.entidadeResponsavelContrato,
                equipamento.periodicidadeContrato,

                // Contrato Manutenção
                equipamento.nomeContratoManutencao,
                equipamento.dataContratoManutencao,
                equipamento.validadeContratoManutencao,

                // Relatório Manutenção
                equipamento.nomeRelatorioManutencao,
                equipamento.dataRelatorioManutencao,
                equipamento.validadeRelatorioManutencao,

                // Certificado Calibração
                equipamento.nomeCertificadoCalibracao,
                equipamento.dataCertificadoCalibracao,
                equipamento.validadeCertificadoCalibracao,

                // Relatório Calibração
                equipamento.nomeRelatorioCalibracao,
                equipamento.dataRelatorioCalibracao,
                equipamento.validadeRelatorioCalibracao,

                equipamento.observacoesContrato,

                // Fornecedor
                textoFornecedor,

                // Localização
                textoLocalizacao

            ].join(" ").toLowerCase();

            const correspondePesquisa =
                textoPesquisa === "" ||
                textoEquipamento.includes(textoPesquisa);

            const correspondeEstado =
                estadoSelecionado === "" || equipamento.estado === estadoSelecionado;

            const correspondeFornecedor =
                fornecedorSelecionado === "" ||
                (
                    equipamento.fornecedores &&
                    equipamento.fornecedores.some(function (fornecedor) {
                        return fornecedor.codigo === fornecedorSelecionado;
                    })
                );

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

    const fornecedores = Object.values(fornecedoresGuardados);

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
        "Laboratório",
        "Esterilização",
        "Reabilitação"
    ];

    fornecedores.forEach(function (fornecedor) {

        const option = document.createElement("option");

        option.value = fornecedor.codigo;

        option.textContent =
            fornecedor.codigo + " - " + fornecedor.nomeEmpresa;

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

    const seletorDocTecnica =
        document.getElementById("tem_documentacao_tecnica");

    const blocoDocTecnica =
        document.getElementById("bloco-documentacao-tecnica");

    const seletorDocUtilizacao =
        document.getElementById("tem_documentacao_utilizacao");

    const blocoDocUtilizacao =
        document.getElementById("bloco-documentacao-utilizacao");

    if (blocoDocTecnica) {
        blocoDocTecnica.style.display = "none";
    }

    if (blocoDocUtilizacao) {
        blocoDocUtilizacao.style.display = "none";
    }

    if (seletorDocTecnica) {

        seletorDocTecnica.addEventListener("change", function () {

            if (this.value === "sim") {
                blocoDocTecnica.style.display = "block";
            } else {
                blocoDocTecnica.style.display = "none";
            }

        });

    }

    if (seletorDocUtilizacao) {

        seletorDocUtilizacao.addEventListener("change", function () {

            if (this.value === "sim") {
                blocoDocUtilizacao.style.display = "block";
            } else {
                blocoDocUtilizacao.style.display = "none";
            }

        });

    }

    const seletorDeclaracaoConformidade = document.getElementById('tem_declaracao_conformidade');
    const blocoDeclaracaoConformidade = document.getElementById('bloco-declaracao-conformidade');

    if (blocoDeclaracaoConformidade) blocoDeclaracaoConformidade.style.display = 'none';

    if (seletorDeclaracaoConformidade) {
        seletorDeclaracaoConformidade.addEventListener('change', function () {
            blocoDeclaracaoConformidade.style.display = this.value === 'sim' ? 'block' : 'none';
        });
    }

    const seletorContratoAquisicao = document.getElementById('tem_contrato_aquisicao');
    const blocoContratoAquisicao = document.getElementById('bloco-contrato-aquisicao');
    const seletorFatura = document.getElementById('tem_fatura');
    const blocoFatura = document.getElementById('bloco-fatura');

    if (blocoContratoAquisicao) blocoContratoAquisicao.style.display = 'none';
    if (blocoFatura) blocoFatura.style.display = 'none';

    if (seletorContratoAquisicao) {
        seletorContratoAquisicao.addEventListener('change', function () {
            blocoContratoAquisicao.style.display = this.value === 'sim' ? 'block' : 'none';
        });
    }
    if (seletorFatura) {
        seletorFatura.addEventListener('change', function () {
            blocoFatura.style.display = this.value === 'sim' ? 'block' : 'none';
        });
    }

    const selectTipoEntrada = document.getElementById("tipo_entrada");

    function atualizarFaturaPorTipoEntrada() {
        if (!selectTipoEntrada || !seletorFatura || !blocoFatura) return;
        const tipo = selectTipoEntrada.value;

        if (tipo === "Compra") {
            seletorFatura.value = "sim";
            blocoFatura.style.display = "block";
            seletorFatura.style.pointerEvents = "none";
            seletorFatura.style.opacity = "0.75";
        } else if (tipo === "Doação" || tipo === "Empréstimo") {
            seletorFatura.value = "nao";
            blocoFatura.style.display = "none";
            seletorFatura.style.pointerEvents = "none";
            seletorFatura.style.opacity = "0.75";
        } else if (tipo === "Aluguer") {
            seletorFatura.style.pointerEvents = "";
            seletorFatura.style.opacity = "";
            if (seletorFatura.value !== "sim") blocoFatura.style.display = "none";
        } else {
            seletorFatura.value = "";
            blocoFatura.style.display = "none";
            seletorFatura.style.pointerEvents = "none";
            seletorFatura.style.opacity = "0.75";
        }
    }

    if (selectTipoEntrada) {
        selectTipoEntrada.addEventListener("change", atualizarFaturaPorTipoEntrada);
        atualizarFaturaPorTipoEntrada();
    }

    // Garantia
    const seletorDocGarantia = document.getElementById('tem_documentacao_garantia');
    const blocoDocGarantia = document.getElementById('bloco-documentacao-garantia');

    if (blocoDocGarantia) blocoDocGarantia.style.display = 'none';

    if (seletorDocGarantia) {
        seletorDocGarantia.addEventListener('change', function () {
            blocoDocGarantia.style.display = this.value === 'sim' ? 'block' : 'none';
        });
    }

    // Contrato de manutenção — controlado pelo select principal
    const seletorDocContrato = document.getElementById('tem_documentacao_contrato');
    const blocoDocContrato = document.getElementById('bloco-documentacao-contrato');
    const selectContratoManutencao = document.getElementById('contratoManutencao');
    const seletorRelatorioContrato = document.getElementById('tem_relatorio_contrato');
    const blocoRelatorioContrato = document.getElementById('bloco-relatorio-contrato');

    if (blocoDocContrato) blocoDocContrato.style.display = 'none';
    if (blocoRelatorioContrato) blocoRelatorioContrato.style.display = 'none';

    function atualizarDocContrato() {
        if (selectContratoManutencao.value === "Sim") {

            seletorDocContrato.value = "sim";
            if (blocoDocContrato) blocoDocContrato.style.display = "block";
            seletorDocContrato.style.pointerEvents = "none";
            seletorDocContrato.style.opacity = "0.75";

            seletorRelatorioContrato.style.pointerEvents = "";
            seletorRelatorioContrato.style.opacity = "";

        } else {

            seletorDocContrato.value = "nao";
            if (blocoDocContrato) blocoDocContrato.style.display = "none";
            seletorDocContrato.style.pointerEvents = "none";
            seletorDocContrato.style.opacity = "0.75";

            seletorRelatorioContrato.value = "nao";
            if (blocoRelatorioContrato) blocoRelatorioContrato.style.display = "none";
            seletorRelatorioContrato.style.pointerEvents = "none";
            seletorRelatorioContrato.style.opacity = "0.75";
        }
    }

    if (selectContratoManutencao && seletorDocContrato) {
        selectContratoManutencao.addEventListener('change', atualizarDocContrato);
        atualizarDocContrato();

        seletorDocContrato.addEventListener('mousedown', function (e) { e.preventDefault(); });
        seletorDocContrato.addEventListener('keydown', function (e) { e.preventDefault(); });
    }

    if (seletorRelatorioContrato) {
        seletorRelatorioContrato.addEventListener('change', function () {
            if (blocoRelatorioContrato) {
                blocoRelatorioContrato.style.display = this.value === 'sim' ? 'block' : 'none';
            }
        });
    }

    // Calibração
    const seletorDocCalibracao = document.getElementById('tem_documentacao_calibracao');
    const blocoDocCalibracao = document.getElementById('bloco-documentacao-calibracao');

    if (blocoDocCalibracao) blocoDocCalibracao.style.display = 'none';

    if (seletorDocCalibracao) {
        seletorDocCalibracao.addEventListener('change', function () {
            blocoDocCalibracao.style.display = this.value === 'sim' ? 'block' : 'none';
        });
    }

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
            temDocumentacaoTecnica:
                document.getElementById("tem_documentacao_tecnica").value,

            nomeManualTecnico:
                document.getElementById("nomeManualTecnico").value.trim(),

            dataManualTecnico:
                converterDataParaTexto(
                    document.getElementById("dataManualTecnico").value
                ),

            validadeManualTecnico:
                converterDataParaTexto(
                    document.getElementById("validadeManualTecnico").value
                ),

            ficheiroManualTecnico:
                document.getElementById("ficheiroManualTecnico").value,

            temDocumentacaoUtilizacao:
                document.getElementById("tem_documentacao_utilizacao").value,

            nomeManualUtilizacao:
                document.getElementById("nomeManualUtilizacao").value.trim(),

            dataManualUtilizacao:
                converterDataParaTexto(
                    document.getElementById("dataManualUtilizacao").value
                ),

            validadeManualUtilizacao:
                converterDataParaTexto(
                    document.getElementById("validadeManualUtilizacao").value
                ),

            ficheiroManualUtilizacao:
                document.getElementById("ficheiroManualUtilizacao").value,

            temDeclaracaoConformidade: document.getElementById("tem_declaracao_conformidade").value,
            nomeDeclaracaoConformidade: document.getElementById("nomeDeclaracaoConformidade").value.trim(),
            dataDeclaracaoConformidade: converterDataParaTexto(document.getElementById("dataDeclaracaoConformidade").value),
            validadeDeclaracaoConformidade: converterDataParaTexto(document.getElementById("validadeDeclaracaoConformidade").value),
            ficheiroDeclaracaoConformidade: document.getElementById("ficheiroDeclaracaoConformidade").value,

            dataAquisicao: converterDataParaTexto(document.getElementById("data_aquisicao").value),
            custoAquisicao: document.getElementById("custo_aquisicao").value.trim() + " €",
            tipoEntrada: document.getElementById("tipo_entrada").value.trim(),
            estado: document.getElementById("estado").value.trim(),
            criticidade: document.getElementById("criticidade").value.trim(),
            observacoesAquisicao: document.getElementById("observacoesAquisicao").value.trim(),

            fornecedores: Array.from(document.querySelectorAll('#tbody-fornecedores-equipamento tr')).map(function (tr) {
                return {
                    codigo: tr.querySelector('select[name="fornecedores[codigo][]"]')?.value || "",
                    morada: tr.querySelector('select[name="fornecedores[morada][]"]')?.value || "",
                    pessoaContacto: tr.querySelector('input[name="fornecedores[pessoa][]"]')?.value || "",
                    telefone: tr.querySelector('input[name="fornecedores[telefone][]"]')?.value || "",
                    tipo: tr.querySelector('select[name="fornecedores[tipo][]"]')?.value || "",
                    observacoes: tr.querySelector('input[name="fornecedores[observacoes][]"]')?.value || ""
                };
            }),

            localizacao: document.getElementById("localizacao") ? document.getElementById("localizacao").value.trim() : "",
            observacoesLocalizacao: document.getElementById("observacoesLocalizacao")?.value || "",

            dataInicioGarantia: converterDataParaTexto(document.getElementById("dataInicioGarantia").value),
            dataFimGarantia: converterDataParaTexto(document.getElementById("dataFimGarantia").value),
            contratoManutencao: document.getElementById("contratoManutencao").value,
            tipoContrato: document.getElementById("contratoManutencao").value === "Não" ? "Não existe" : document.getElementById("tipoContrato").value.trim(),
            entidadeResponsavelContrato: document.getElementById("contratoManutencao").value === "Não" ? "Não existe" : document.getElementById("entidadeResponsavelContrato").value.trim(),
            periodicidadeContrato: document.getElementById("contratoManutencao").value === "Não" ? "Não aplicável" : document.getElementById("periodicidadeContrato").value,
            observacoesContrato: document.getElementById("observacoesContrato").value.trim(),

            temContratoAquisicao: document.getElementById("tem_contrato_aquisicao").value,
            nomeContratoAquisicao: document.getElementById("nomeContratoAquisicao").value.trim(),
            dataContratoAquisicao: converterDataParaTexto(document.getElementById("dataContratoAquisicao").value),
            validadeContratoAquisicao: converterDataParaTexto(document.getElementById("validadeContratoAquisicao").value),

            temFatura: document.getElementById("tem_fatura").value,
            nomeFatura: document.getElementById("nomeFatura").value.trim(),
            dataFatura: converterDataParaTexto(document.getElementById("dataFatura").value),

            temDocumentacaoGarantia: document.getElementById("tem_documentacao_garantia").value,
            nomeCertificadoGarantia: document.getElementById("nomeCertificadoGarantia").value.trim(),
            dataCertificadoGarantia: converterDataParaTexto(document.getElementById("dataCertificadoGarantia").value),
            validadeCertificadoGarantia: converterDataParaTexto(document.getElementById("validadeCertificadoGarantia").value),
            observacoesGarantia: document.getElementById("observacoesGarantia").value.trim(),

            temDocumentacaoContrato: document.getElementById("tem_documentacao_contrato").value,
            nomeContratoManutencao: document.getElementById("nomeContratoManutencao").value.trim(),
            dataContratoManutencao: converterDataParaTexto(document.getElementById("dataContratoManutencao").value),
            validadeContratoManutencao: converterDataParaTexto(document.getElementById("validadeContratoManutencao").value),

            temRelatorioContrato: document.getElementById("tem_relatorio_contrato").value,
            nomeRelatorioManutencao: document.getElementById("nomeRelatorioManutencao").value.trim(),
            dataRelatorioManutencao: converterDataParaTexto(document.getElementById("dataRelatorioManutencao").value),
            validadeRelatorioManutencao: converterDataParaTexto(document.getElementById("validadeRelatorioManutencao").value),

            temDocumentacaoCalibracao: document.getElementById("tem_documentacao_calibracao").value,
            nomeCertificadoCalibracao: document.getElementById("nomeCertificadoCalibracao").value.trim(),
            dataCertificadoCalibracao: converterDataParaTexto(document.getElementById("dataCertificadoCalibracao").value),
            validadeCertificadoCalibracao: converterDataParaTexto(document.getElementById("validadeCertificadoCalibracao").value),

            temRelatorioCalibracao: document.getElementById("tem_relatorio_calibracao").value,
            nomeRelatorioCalibracao: document.getElementById("nomeRelatorioCalibracao").value.trim(),
            dataRelatorioCalibracao: converterDataParaTexto(document.getElementById("dataRelatorioCalibracao").value),
            validadeRelatorioCalibracao: converterDataParaTexto(document.getElementById("validadeRelatorioCalibracao").value),
            acessorios: Array.from(document.querySelectorAll('#tbody-acessorios tr')).map(function (tr) {
                return {
                    nome: tr.querySelector('input[name="acessorios[nome][]"]')?.value || "",
                    referencia: tr.querySelector('input[name="acessorios[referencia][]"]')?.value || "",
                    quantidade: tr.querySelector('input[type="number"]')?.value || "",
                    unidade: tr.querySelector('select[name="acessorios[unidade][]"]')?.value || "",
                    estado: tr.querySelector('select[name="acessorios[estado][]"]')?.value || "",
                    observacoes: tr.querySelector('input[name="acessorios[observacoes][]"]')?.value || ""
                };
            }),

            consumiveis: Array.from(document.querySelectorAll('#tbody-consumiveis tr')).map(function (tr) {
                return {
                    nome: tr.querySelector('input[name="consumiveis[nome][]"]')?.value || "",
                    referencia: tr.querySelector('input[name="consumiveis[referencia][]"]')?.value || "",
                    quantidade: tr.querySelector('input[type="number"]')?.value || "",
                    unidade: tr.querySelector('select[name="consumiveis[unidade][]"]')?.value || "",
                    estado: tr.querySelector('select[name="consumiveis[estado][]"]')?.value || "",
                    observacoes: tr.querySelector('input[name="consumiveis[observacoes][]"]')?.value || ""
                };
            }),
        };

        equipamentosGuardados[codigo] = novoEquipamento;

        localStorage.setItem("equipamentosGuardados", JSON.stringify(equipamentosGuardados));

        setTimeout(function () {
            window.location.href = "equipamentos.html";
        }, 800);
    });

    // Relatório de calibração
    const seletorRelatorioCalibracao = document.getElementById('tem_relatorio_calibracao');
    const blocoRelatorioCalibracao = document.getElementById('bloco-relatorio-calibracao');
    if (seletorRelatorioCalibracao) {
        seletorRelatorioCalibracao.addEventListener('change', function () {
            if (blocoRelatorioCalibracao) {
                blocoRelatorioCalibracao.style.display = this.value === 'sim' ? 'block' : 'none';
            }
        });
    }
}

const ESTADOS = [
    { value: 'novo', label: 'Novo' },
    { value: 'em-uso', label: 'Em uso' },
    { value: 'danificado', label: 'Danificado' },
    { value: 'em-falta', label: 'Em falta' },
    { value: 'obsoleto', label: 'Obsoleto' },
];

const UNIDADES = ['unid', 'cx', 'pack', 'par', 'rolo', 'frasco', 'saco', 'kit', 'L', 'mL', 'm', 'cm'];

const contadores = { acessorios: 0, consumiveis: 0 };

window.adicionarItem = function (tipo, dados) {
    dados = dados || {};

    const tbody = document.getElementById('tbody-' + tipo);
    const id = tipo + '-linha-' + (++contadores[tipo]);

    const opcoesEstado = ESTADOS.map(function (e) {
        var sel = dados.estado === e.value ? ' selected' : '';
        return '<option value="' + e.value + '"' + sel + '>' + e.label + '</option>';
    }).join('');

    const opcoesUnidade = UNIDADES.map(function (u) {
        var sel = dados.unidade === u ? ' selected' : '';
        return '<option value="' + u + '"' + sel + '>' + u + '</option>';
    }).join('');

    const tr = document.createElement('tr');
    tr.id = id;
    tr.innerHTML =
        '<td class="col-nome">' +
        '<input type="text" name="' + tipo + '[nome][]" placeholder="Nome do item" value="' + (dados.nome || '') + '" oninput="atualizarResumo(\'' + tipo + '\')">' +
        '</td>' +
        '<td class="col-ref">' +
        '<input type="text" name="' + tipo + '[referencia][]" placeholder="REF-001" value="' + (dados.ref || '') + '" style="font-family:monospace;font-size:12.5px;">' +
        '</td>' +
        '<td class="col-qty">' +
        '<input type="number" name="' + tipo + '[quantidade][]" min="0" step="1" value="' + (dados.qty !== undefined ? dados.qty : 1) + '" oninput="atualizarResumo(\'' + tipo + '\')">' +
        '</td>' +
        '<td class="col-unit">' +
        '<select name="' + tipo + '[unidade][]">' + opcoesUnidade + '</select>' +
        '</td>' +
        '<td class="col-est">' +
        '<select name="' + tipo + '[estado][]" onchange="atualizarResumo(\'' + tipo + '\')">' + opcoesEstado + '</select>' +
        '</td>' +
        '<td class="col-obs">' +
        '<input type="text" name="' + tipo + '[observacoes][]" placeholder="Notas opcionais..." value="' + (dados.obs || '') + '">' +
        '</td>' +
        '<td>' +
        '<button type="button" class="botao-remover-item" onclick="removerItem(\'' + tipo + '\',\'' + id + '\')" title="Remover">' +
        '<i class="fa-solid fa-xmark"></i>' +
        '</button>' +
        '</td>';

    tbody.appendChild(tr);
    atualizarResumo(tipo);
    tr.querySelector('input').focus();
};

window.removerItem = function (tipo, id) {
    var linha = document.getElementById(id);
    if (linha) linha.remove();
    atualizarResumo(tipo);
};

window.atualizarResumo = function (tipo) {
    var tbody = document.getElementById('tbody-' + tipo);
    var linhas = tbody.querySelectorAll('tr');
    var resumo = document.getElementById('resumo-' + tipo);

    if (!linhas.length) {
        resumo.innerHTML = '';
        return;
    }

    var totalQty = 0;
    var contagem = {};

    linhas.forEach(function (tr) {
        var estado = tr.querySelector('select[name$="[estado][]"]').value;
        var qty = parseInt(tr.querySelector('input[type=number]').value) || 0;
        contagem[estado] = (contagem[estado] || 0) + 1;
        totalQty += qty;
    });

    var clsMap = {
        'novo': 'badge-novo',
        'em-uso': 'badge-em-uso',
        'danificado': 'badge-danificado',
        'em-falta': 'badge-em-falta',
        'obsoleto': 'badge-obsoleto'
    };
    var lblMap = {
        'novo': 'Novo',
        'em-uso': 'Em uso',
        'danificado': 'Danificado',
        'em-falta': 'Em falta',
        'obsoleto': 'Obsoleto'
    };

    var html = '<span class="badge-resumo badge-total"><span class="dot"></span>' +
        linhas.length + ' item' + (linhas.length !== 1 ? 's' : '') + ' · ' + totalQty + ' un.</span>';

    Object.keys(contagem).forEach(function (k) {
        html += '<span class="badge-resumo ' + clsMap[k] + '"><span class="dot"></span>' +
            contagem[k] + ' ' + lblMap[k] + '</span>';
    });

    resumo.innerHTML = html;
};

const contadorFornecedores = { count: 0 };

window.adicionarFornecedorEquipamento = function () {
    const tbody = document.getElementById('tbody-fornecedores-equipamento');
    if (!tbody) return;
    const id = 'fornecedor-linha-' + (++contadorFornecedores.count);

    const opcoesFornecedores = Object.values(fornecedoresGuardados).map(function (f) {
        return '<option value="' + f.codigo + '">' + f.codigo + ' — ' + f.nomeEmpresa + '</option>';
    }).join('');

    const opcoesTipo = [
        'Fabricante',
        'Distribuidor ou Fornecedor comercial',
        'Empresa de assistência técnica',
        'Fornecedor de consumíveis ou acessórios'
    ].map(function (t) {
        return '<option value="' + t + '">' + t + '</option>';
    }).join('');

    const opcoesMorada = [
        'Aveiro, Portugal', 'Beja, Portugal', 'Braga, Portugal',
        'Bragança, Portugal', 'Castelo Branco, Portugal', 'Coimbra, Portugal',
        'Évora, Portugal', 'Faro, Portugal', 'Guarda, Portugal',
        'Leiria, Portugal', 'Lisboa, Portugal', 'Portalegre, Portugal',
        'Porto, Portugal', 'Santarém, Portugal', 'Setúbal, Portugal',
        'Viana do Castelo, Portugal', 'Vila Real, Portugal', 'Viseu, Portugal',
        'Região Autónoma dos Açores, Portugal', 'Região Autónoma da Madeira, Portugal'
    ].map(function (m) {
        return '<option value="' + m + '">' + m + '</option>';
    }).join('');

    const tr = document.createElement('tr');
    tr.id = id;
    tr.innerHTML =
        '<td><select name="fornecedores[codigo][]" class="campo-formulario-privado">' +
        '<option value="" disabled selected>Escolha</option>' + opcoesFornecedores +
        '</select></td>' +
        '<td><select name="fornecedores[tipo][]" class="campo-formulario-privado">' +
        '<option value="" disabled selected>Escolha</option>' + opcoesTipo +
        '</select></td>' +
        '<td><select name="fornecedores[morada][]" class="campo-formulario-privado">' +
        '<option value="" disabled selected>Escolha</option>' + opcoesMorada +
        '</select></td>' +
        '<td><input type="text" name="fornecedores[pessoa][]" placeholder="Nome" class="campo-formulario-privado"></td>' +
        '<td><input type="text" name="fornecedores[telefone][]" placeholder="+351..." class="campo-formulario-privado"></td>' +
        '<td><input type="text" name="fornecedores[observacoes][]" placeholder="Notas opcionais..." class="campo-formulario-privado"></td>' +
        '<td><button type="button" class="botao-remover-item" onclick="removerFornecedorEquipamento(\'' + id + '\')" title="Remover">' +
        '<i class="fa-solid fa-xmark"></i>' +
        '</button></td>';

    tbody.appendChild(tr);
    atualizarResumoFornecedores();
    tr.querySelector('select').focus();
};

window.removerFornecedorEquipamento = function (id) {
    const linha = document.getElementById(id);
    if (linha) linha.remove();
    atualizarResumoFornecedores();
};

function atualizarResumoFornecedores() {
    var tbody = document.getElementById('tbody-fornecedores-equipamento');
    var resumo = document.getElementById('resumo-fornecedores');
    if (!tbody || !resumo) return;
    var linhas = tbody.querySelectorAll('tr');
    if (!linhas.length) {
        resumo.innerHTML = '';
        return;
    }
    resumo.innerHTML = '<span class="badge-resumo badge-total"><span class="dot"></span>' +
        linhas.length + ' fornecedor' + (linhas.length !== 1 ? 'es' : '') + ' associado' + (linhas.length !== 1 ? 's' : '') + '</span>';
}

function toggleAccordionDoc(botao) {

    const badge = botao.querySelector(".badge-accordion-doc");

    if (badge && badge.textContent.trim() === "Não") {
        return;
    }

    const body = botao.nextElementSibling;

    if (body.style.display === "none") {
        body.style.display = "block";
    } else {
        body.style.display = "none";
    }
}

window.abrirOffcanvasFornecedor = function (index, codigoEquipamento) {
    const equipamento = equipamentosGuardados[codigoEquipamento];
    if (!equipamento) return;

    const f = equipamento.fornecedores[index];
    if (!f) return;

    const dadosFornecedor = fornecedoresGuardados[f.codigo];
    const nomeFornecedor = dadosFornecedor ? dadosFornecedor.nomeEmpresa : f.codigo;

    const body = document.getElementById("offcanvas-body-fornecedor");
    if (body) {
        body.innerHTML = `
            <div class="offcanvas-fornecedor-secao">
                <h6 class="offcanvas-fornecedor-titulo">
                    <i class="fa-solid fa-building"></i>
                    Dados Gerais
                </h6>
                <div class="offcanvas-fornecedor-campo">
                    <span class="offcanvas-fornecedor-label">Código</span>
                    <span class="offcanvas-fornecedor-valor">${f.codigo || "Não definido"}</span>
                </div>
                <div class="offcanvas-fornecedor-campo">
                    <span class="offcanvas-fornecedor-label">Nome</span>
                    <span class="offcanvas-fornecedor-valor">${nomeFornecedor}</span>
                </div>
                <div class="offcanvas-fornecedor-campo">
                    <span class="offcanvas-fornecedor-label">NIF</span>
                    <span class="offcanvas-fornecedor-valor">${dadosFornecedor ? dadosFornecedor.nif : "Não definido"}</span>
                </div>
                <div class="offcanvas-fornecedor-campo">
                    <span class="offcanvas-fornecedor-label">Tipo</span>
                    <span class="offcanvas-fornecedor-valor">${f.tipo || "Não definido"}</span>
                </div>
                <div class="offcanvas-fornecedor-campo">
                    <span class="offcanvas-fornecedor-label">Website</span>
                    <span class="offcanvas-fornecedor-valor">${dadosFornecedor ? dadosFornecedor.website : "Não definido"}</span>
                </div>
            </div>

            <div class="offcanvas-fornecedor-secao">
                <h6 class="offcanvas-fornecedor-titulo">
                    <i class="fa-solid fa-phone"></i>
                    Contactos
                </h6>
                <div class="offcanvas-fornecedor-campo">
                    <span class="offcanvas-fornecedor-label">Email geral</span>
                    <span class="offcanvas-fornecedor-valor">${dadosFornecedor ? dadosFornecedor.email : "Não definido"}</span>
                </div>
                <div class="offcanvas-fornecedor-campo">
                    <span class="offcanvas-fornecedor-label">Telefone geral</span>
                    <span class="offcanvas-fornecedor-valor">${dadosFornecedor ? dadosFornecedor.telefone : "Não definido"}</span>
                </div>
                <div class="offcanvas-fornecedor-campo">
                    <span class="offcanvas-fornecedor-label">Pessoa de contacto</span>
                    <span class="offcanvas-fornecedor-valor">${f.pessoaContacto || "Não definido"}</span>
                </div>
                <div class="offcanvas-fornecedor-campo">
                    <span class="offcanvas-fornecedor-label">Telefone de contacto</span>
                    <span class="offcanvas-fornecedor-valor">${f.telefone || "Não definido"}</span>
                </div>
            </div>

            <div class="offcanvas-fornecedor-secao">
                <h6 class="offcanvas-fornecedor-titulo">
                    <i class="fa-solid fa-location-dot"></i>
                    Localização
                </h6>
                <div class="offcanvas-fornecedor-campo">
                    <span class="offcanvas-fornecedor-label">Morada</span>
                    <span class="offcanvas-fornecedor-valor">${f.morada || "Não definido"}</span>
                </div>
            </div>

            <div class="offcanvas-fornecedor-secao">
                <h6 class="offcanvas-fornecedor-titulo">
                    <i class="fa-solid fa-comment-medical"></i>
                    Observações
                </h6>
                <p style="color:#1f2d3d; font-size:0.95rem; line-height:1.6;">
                    ${f.observacoes || "Sem observações."}
                </p>
            </div>
        `;
    }

    const offcanvasEl = document.getElementById("offcanvasFornecedor");
    const offcanvas = new bootstrap.Offcanvas(offcanvasEl);
    offcanvas.show();
};

function mostrarTab(idTab) {

    const botoesTabs =
        document.querySelectorAll(".botao-tab-equipamento");

    const conteudosTabs =
        document.querySelectorAll(".conteudo-tab-equipamento");

    botoesTabs.forEach(function (botao) {
        botao.classList.remove("ativo");
    });

    conteudosTabs.forEach(function (conteudo) {
        conteudo.classList.remove("ativo");
    });

    const botaoSelecionado =
        document.querySelector(`[data-tab="${idTab}"]`);

    const conteudoSelecionado =
        document.getElementById(idTab);

    if (botaoSelecionado) {
        botaoSelecionado.classList.add("ativo");
    }

    if (conteudoSelecionado) {
        conteudoSelecionado.classList.add("ativo");
    }

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

            mostrarTab(tabDestino);
        });
    });
}

function inicializarBotaoSeguinteEquipamento() {

    const botoesSeguinte = document.querySelectorAll(".botao-seguinte");

    botoesSeguinte.forEach(function (botao) {

        botao.addEventListener("click", function () {

            const tabSeguinte = botao.dataset.seguinte;

            const botaoTabSeguinte =
                document.querySelector(`[data-tab="${tabSeguinte}"]`);

            if (botaoTabSeguinte) {
                botaoTabSeguinte.classList.remove("bloqueado");
                botaoTabSeguinte.disabled = false;
            }

            mostrarTab(tabSeguinte);
        });
    });
}

function inicializarBotaoAnteriorEquipamento() {

    const botoesAnterior =
        document.querySelectorAll(".botao-anterior");

    botoesAnterior.forEach(function (botao) {

        botao.addEventListener("click", function () {

            const tabAnterior =
                botao.dataset.anterior;

            mostrarTab(tabAnterior);

        });

    });

}

// Separador 2 — Acessórios e Consumíveis
function renderizarItens(containerId, itens, tipo) {
    const container = document.getElementById(containerId);
    if (!container) return;
    if (!itens || itens.length === 0) {
        container.innerHTML = `<p style="color:#6b7280; font-style:italic;">Sem ${tipo} registados.</p>`;
        return;
    }

    const classeEstado = {
        'novo': 'badge-novo',
        'em-uso': 'badge-em-uso',
        'danificado': 'badge-danificado',
        'em-falta': 'badge-em-falta',
        'obsoleto': 'badge-obsoleto'
    };

    const labelEstado = {
        'novo': 'Novo',
        'em-uso': 'Em uso',
        'danificado': 'Danificado',
        'em-falta': 'Em falta',
        'obsoleto': 'Obsoleto'
    };

    let html = `
        <table class="tabela-detalhe-itens w-100 mb-2">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Referência</th>
                    <th>Qtd.</th>
                    <th>Unidade</th>
                    <th>Estado</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
    `;

    itens.forEach(function (item, index) {
        const classe = classeEstado[item.estado] || '';
        const label = labelEstado[item.estado] || item.estado || '-';
        const par = index % 2 === 0 ? 'linha-par' : 'linha-impar';
        html += `
            <tr class="${par}">
                <td class="celula-nome">${item.nome || '-'}</td>
                <td class="celula-ref">${item.referencia || '-'}</td>
                <td class="celula-qty">${item.quantidade || '-'}</td>
                <td class="celula-unit">${item.unidade || '-'}</td>
                <td><span class="badge-resumo ${classe}">${label}</span></td>
                <td class="celula-obs">${item.observacoes || '-'}</td>
            </tr>
        `;
    });

    html += `</tbody></table>`;
    container.innerHTML = html;
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

    // Separador 1 — Identificação
    document.getElementById("detalhe-codigo").textContent = equipamento.codigo || "Não definido";
    document.getElementById("detalhe-designacao").textContent = equipamento.designacao || "Não definido";
    document.getElementById("detalhe-categoria").textContent = equipamento.categoria || "Não definido";
    document.getElementById("detalhe-marca").textContent = equipamento.marca || "Não definido";
    document.getElementById("detalhe-modelo").textContent = equipamento.modelo || "Não definido";
    document.getElementById("detalhe-numero-serie").textContent = equipamento.numeroSerie || "Não definido";
    document.getElementById("detalhe-fabricante").textContent = equipamento.fabricante || "Não definido";
    document.getElementById("detalhe-ano-fabrico").textContent = equipamento.anoFabrico || "Não definido";
    // Antes:
    document.getElementById("detalhe-estado").textContent = equipamento.estado || "Não definido";

    // Depois:
    document.getElementById("detalhe-estado").innerHTML = formatarEstadoEquipamento(equipamento.estado || "Não definido");
    document.getElementById("detalhe-observacoes").textContent = equipamento.observacoes || "Sem observações";

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
            campoCriticidade.innerHTML = `<span class="badge-detalhe ${classeCriticidade}">${equipamento.criticidade}</span>`;
        } else {
            campoCriticidade.textContent = equipamento.criticidade || "Não definida";
        }
    }

    // Badges dos accordions de documentação
    const badgeTecnica = document.getElementById("badge-accordion-tecnica");
    if (badgeTecnica) {
        const tem = equipamento.temDocumentacaoTecnica === "sim";
        badgeTecnica.className = `badge-accordion-doc ${tem ? "badge-accordion-sim" : "badge-accordion-nao"}`;
        badgeTecnica.textContent = tem ? "Sim" : "Não";
    }

    const badgeUtilizacao = document.getElementById("badge-accordion-utilizacao");
    if (badgeUtilizacao) {
        const tem = equipamento.temDocumentacaoUtilizacao === "sim";
        badgeUtilizacao.className = `badge-accordion-doc ${tem ? "badge-accordion-sim" : "badge-accordion-nao"}`;
        badgeUtilizacao.textContent = tem ? "Sim" : "Não";
    }

    const badgeConformidade = document.getElementById("badge-accordion-conformidade");
    if (badgeConformidade) {
        const tem = equipamento.temDeclaracaoConformidade === "sim";
        badgeConformidade.className = `badge-accordion-doc ${tem ? "badge-accordion-sim" : "badge-accordion-nao"}`;
        badgeConformidade.textContent = tem ? "Sim" : "Não";
    }

    // Doc técnica
    if (equipamento.temDocumentacaoTecnica === "sim") {

        document.getElementById("detalhe-tem-doc-tecnica").textContent =
            equipamento.tipoManualTecnico || "Manual de Serviço";

        document.getElementById("detalhe-nome-manual-tecnico").textContent =
            equipamento.nomeManualTecnico || "";

        document.getElementById("detalhe-data-manual-tecnico").textContent =
            equipamento.dataManualTecnico || "";

        document.getElementById("detalhe-validade-manual-tecnico").textContent =
            equipamento.validadeManualTecnico || "";

    } else {

        document.getElementById("detalhe-tem-doc-tecnica").textContent =
            "Não existe documentação técnica";

        document.getElementById("detalhe-nome-manual-tecnico").textContent = "";
        document.getElementById("detalhe-data-manual-tecnico").textContent = "";
        document.getElementById("detalhe-validade-manual-tecnico").textContent = "";
    }

    // Doc utilização
    if (equipamento.temDocumentacaoUtilizacao === "sim") {

        document.getElementById("detalhe-tem-doc-utilizacao").textContent =
            equipamento.tipoManualUtilizacao || "Manual de Utilização";

        document.getElementById("detalhe-nome-manual-utilizacao").textContent =
            equipamento.nomeManualUtilizacao || "";

        document.getElementById("detalhe-data-manual-utilizacao").textContent =
            equipamento.dataManualUtilizacao || "";

        document.getElementById("detalhe-validade-manual-utilizacao").textContent =
            equipamento.validadeManualUtilizacao || "";

    } else {

        document.getElementById("detalhe-tem-doc-utilizacao").textContent =
            "Não existe documentação de utilização";

        document.getElementById("detalhe-nome-manual-utilizacao").textContent = "";
        document.getElementById("detalhe-data-manual-utilizacao").textContent = "";
        document.getElementById("detalhe-validade-manual-utilizacao").textContent = "";
    }

    // Ficheiro doc técnica
    const campoFicheiroTecnico = document.getElementById("detalhe-ficheiro-manual-tecnico");
    if (campoFicheiroTecnico) {
        if (equipamento.ficheiroManualTecnico && equipamento.ficheiroManualTecnico !== "") {
            campoFicheiroTecnico.innerHTML = `
            <span style="display:inline-flex; align-items:center; gap:0.4rem; color:#003f78; font-weight:600;">
                <i class="fa-solid fa-file-pdf" style="color:#dc3545;"></i>
                ${equipamento.ficheiroManualTecnico.split('\\').pop().split('/').pop()}
            </span>
        `;
        } else {
            campoFicheiroTecnico.textContent = "Sem ficheiro associado";
        }
    }

    // Ficheiro doc utilização
    const campoFicheiroUtilizacao = document.getElementById("detalhe-ficheiro-manual-utilizacao");
    if (campoFicheiroUtilizacao) {
        if (equipamento.ficheiroManualUtilizacao && equipamento.ficheiroManualUtilizacao !== "") {
            campoFicheiroUtilizacao.innerHTML = `
            <span style="display:inline-flex; align-items:center; gap:0.4rem; color:#003f78; font-weight:600;">
                <i class="fa-solid fa-file-pdf" style="color:#dc3545;"></i>
                ${equipamento.ficheiroManualUtilizacao.split('\\').pop().split('/').pop()}
            </span>
        `;
        } else {
            campoFicheiroUtilizacao.textContent = "Sem ficheiro associado";
        }
    }

    // Declaração de Conformidade
    if (equipamento.temDeclaracaoConformidade === "sim") {
        document.getElementById("detalhe-tem-declaracao-conformidade").textContent = "Declaração de Conformidade";
        document.getElementById("detalhe-nome-declaracao-conformidade").textContent = equipamento.nomeDeclaracaoConformidade || "";
        document.getElementById("detalhe-data-declaracao-conformidade").textContent = equipamento.dataDeclaracaoConformidade || "";
        document.getElementById("detalhe-validade-declaracao-conformidade").textContent = equipamento.validadeDeclaracaoConformidade || "";
    } else {
        document.getElementById("detalhe-tem-declaracao-conformidade").textContent = "Não";
        document.getElementById("detalhe-nome-declaracao-conformidade").textContent = "-";
        document.getElementById("detalhe-data-declaracao-conformidade").textContent = "-";
        document.getElementById("detalhe-validade-declaracao-conformidade").textContent = "-";
    }

    const campoFicheiroConformidade = document.getElementById("detalhe-ficheiro-declaracao-conformidade");
    if (campoFicheiroConformidade) {
        if (equipamento.ficheiroDeclaracaoConformidade && equipamento.ficheiroDeclaracaoConformidade !== "") {
            campoFicheiroConformidade.innerHTML = `
            <span style="display:inline-flex; align-items:center; gap:0.4rem; color:#003f78; font-weight:600;">
                <i class="fa-solid fa-file-pdf" style="color:#dc3545;"></i>
                ${equipamento.ficheiroDeclaracaoConformidade.split('\\').pop().split('/').pop()}
            </span>`;
        } else {
            campoFicheiroConformidade.textContent = "Sem ficheiro associado";
        }
    }

    // Separador 2 — acessórios e consumíveis
    renderizarItens("resumo-acessorios-detalhe", equipamento.acessorios, "acessórios");
    renderizarItens("resumo-consumiveis-detalhe", equipamento.consumiveis, "consumíveis");

    // Separador 3 — Aquisição
    document.getElementById("detalhe-data-aquisicao").textContent = equipamento.dataAquisicao || "Não definida";
    document.getElementById("detalhe-custo-aquisicao").textContent = equipamento.custoAquisicao || "Não definido";
    document.getElementById("detalhe-tipo-entrada").textContent = equipamento.tipoEntrada || "Não definido";

    if (equipamento.temContratoAquisicao === "sim") {

        document.getElementById("detalhe-tem-contrato-aquisicao").textContent =
            equipamento.tipoContratoAquisicao || "Contrato de aquisição";

        document.getElementById("detalhe-nome-contrato-aquisicao").textContent =
            equipamento.nomeContratoAquisicao || "";

        document.getElementById("detalhe-data-contrato-aquisicao").textContent =
            equipamento.dataContratoAquisicao || "";

        document.getElementById("detalhe-validade-contrato-aquisicao").textContent =
            equipamento.validadeContratoAquisicao || "";

    } else {

        document.getElementById("detalhe-tem-contrato-aquisicao").textContent = "Não";
        document.getElementById("detalhe-nome-contrato-aquisicao").textContent = "-";
        document.getElementById("detalhe-data-contrato-aquisicao").textContent = "-";
        document.getElementById("detalhe-validade-contrato-aquisicao").textContent = "-";
    }

    // Ficheiro contrato aquisição
    const campoFicheiroContratoAquisicao = document.getElementById("detalhe-ficheiro-contrato-aquisicao");
    if (campoFicheiroContratoAquisicao) {
        if (equipamento.ficheiroContratoAquisicao && equipamento.ficheiroContratoAquisicao !== "") {
            campoFicheiroContratoAquisicao.innerHTML = `
            <span style="display:inline-flex; align-items:center; gap:0.4rem; color:#003f78; font-weight:600;">
                <i class="fa-solid fa-file-pdf" style="color:#dc3545;"></i>
                ${equipamento.ficheiroContratoAquisicao.split('\\').pop().split('/').pop()}
            </span>
        `;
        } else {
            campoFicheiroContratoAquisicao.textContent = "Sem ficheiro associado";
        }
    }

    if (equipamento.temFatura === "sim") {

        document.getElementById("detalhe-tem-fatura").textContent =
            equipamento.tipoFatura || "Fatura";

        document.getElementById("detalhe-nome-fatura").textContent =
            equipamento.nomeFatura || "";

        document.getElementById("detalhe-data-fatura").textContent =
            equipamento.dataFatura || "";

    } else {

        document.getElementById("detalhe-tem-fatura").textContent = "Não";
        document.getElementById("detalhe-nome-fatura").textContent = "-";
        document.getElementById("detalhe-data-fatura").textContent = "-";
    }

    // Ficheiro fatura
    const campoFicheiroFatura = document.getElementById("detalhe-ficheiro-fatura");
    if (campoFicheiroFatura) {
        if (equipamento.ficheiroFatura && equipamento.ficheiroFatura !== "") {
            campoFicheiroFatura.innerHTML = `
            <span style="display:inline-flex; align-items:center; gap:0.4rem; color:#003f78; font-weight:600;">
                <i class="fa-solid fa-file-pdf" style="color:#dc3545;"></i>
                ${equipamento.ficheiroFatura.split('\\').pop().split('/').pop()}
            </span>
        `;
        } else {
            campoFicheiroFatura.textContent = "Sem ficheiro associado";
        }
    }

    // Badges accordion aquisição
    const badgeContratoAquisicao = document.getElementById("badge-accordion-contrato-aquisicao");
    if (badgeContratoAquisicao) {
        const tem = equipamento.temContratoAquisicao === "sim";
        badgeContratoAquisicao.className = `badge-accordion-doc ${tem ? "badge-accordion-sim" : "badge-accordion-nao"}`;
        badgeContratoAquisicao.textContent = tem ? "Sim" : "Não";
    }

    const badgeFatura = document.getElementById("badge-accordion-fatura");
    if (badgeFatura) {
        const tem = equipamento.temFatura === "sim";
        badgeFatura.className = `badge-accordion-doc ${tem ? "badge-accordion-sim" : "badge-accordion-nao"}`;
        badgeFatura.textContent = tem ? "Sim" : "Não";
    }

    // Observações aquisição
    const campoObsAquisicao = document.getElementById("detalhe-observacoes-aquisicao");
    if (campoObsAquisicao) {
        campoObsAquisicao.textContent = equipamento.observacoesAquisicao || "Sem observações";
    }

    // Separador 4 — Fornecedores
    const containerFornecedores = document.getElementById("tab-fornecedor-detalhe");
    if (containerFornecedores) {
        const fornecedores = equipamento.fornecedores || [];

        if (fornecedores.length === 0) {
            containerFornecedores.innerHTML = `
            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-truck-medical"></i>
                Fornecedores Associados
            </h5>
            <p style="color:#6b7280; font-style:italic;">Sem fornecedores associados.</p>
        `;
        } else {
            let htmlFornecedores = `
            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-truck-medical"></i>
                Fornecedores Associados
            </h5>
            <table class="tabela-detalhe-itens w-100 mb-2">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome do Fornecedor</th>
                        <th>Tipo</th>
                        <th>Pessoa de Contacto</th>
                        <th>Telefone de Contacto</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
        `;

            fornecedores.forEach(function (f, index) {
                const dadosFornecedor = fornecedoresGuardados[f.codigo];
                const nomeFornecedor = dadosFornecedor ? dadosFornecedor.nomeEmpresa : f.codigo;
                const par = index % 2 === 0 ? 'linha-par' : 'linha-impar';

                htmlFornecedores += `
                <tr class="${par}">
                    <td class="celula-ref">${f.codigo || "-"}</td>
                    <td class="celula-nome">${nomeFornecedor}</td>
                    <td>${f.tipo || "-"}</td>
                    <td>${f.pessoaContacto || "-"}</td>
                    <td>${f.telefone || "-"}</td>
                    <td>
                        <button
                            class="botao-ver-fornecedor"
                            onclick="abrirOffcanvasFornecedor(${index}, '${equipamento.codigo}')">
                            <i class="fa-regular fa-eye"></i>
                            Ver
                        </button>
                    </td>
                </tr>
            `;
            });

            htmlFornecedores += `</tbody></table>`;
            containerFornecedores.innerHTML = htmlFornecedores;
        }
    }

    // Separador 5 — Localização
    const localizacaoAssociada = localizacoesGuardadas[equipamento.localizacao];
    if (localizacaoAssociada) {
        document.getElementById("detalhe-localizacao-codigo").textContent = localizacaoAssociada.codigo || "Não definido";
        document.getElementById("detalhe-localizacao-edificio").textContent = localizacaoAssociada.edificio || "Não definido";
        document.getElementById("detalhe-localizacao-piso").textContent = localizacaoAssociada.piso || "Não definido";
        document.getElementById("detalhe-localizacao-servico").textContent = localizacaoAssociada.servico || "Não definido";
        document.getElementById("detalhe-localizacao-sala").textContent = localizacaoAssociada.sala || "Não definido";
        document.getElementById("detalhe-localizacao-observacoes").textContent = equipamento.observacoesLocalizacao || localizacaoAssociada.observacoes || "Sem observações";
    } else {
        document.getElementById("detalhe-localizacao-codigo").textContent = equipamento.localizacao || "Sem localização";
        document.getElementById("detalhe-localizacao-edificio").textContent = "Não definido";
        document.getElementById("detalhe-localizacao-piso").textContent = "Não definido";
        document.getElementById("detalhe-localizacao-servico").textContent = "Não definido";
        document.getElementById("detalhe-localizacao-sala").textContent = "Não definido";
        document.getElementById("detalhe-localizacao-observacoes").textContent = equipamento.observacoesLocalizacao || "Sem observações";
    }

    // Separador 6 — Garantia
    document.getElementById("detalhe-data-inicio-garantia").textContent = equipamento.dataInicioGarantia || "Não definida";
    document.getElementById("detalhe-data-fim-garantia").textContent = equipamento.dataFimGarantia || "Não definida";

    if (equipamento.temDocumentacaoGarantia === "sim") {

        document.getElementById("detalhe-tem-doc-garantia").textContent =
            equipamento.tipoCertificadoGarantia || "Certificado de garantia";

        document.getElementById("detalhe-nome-certificado-garantia").textContent =
            equipamento.nomeCertificadoGarantia || "";

        document.getElementById("detalhe-data-certificado-garantia").textContent =
            equipamento.dataCertificadoGarantia || "";

        document.getElementById("detalhe-validade-certificado-garantia").textContent =
            equipamento.validadeCertificadoGarantia || "";

    } else {

        document.getElementById("detalhe-tem-doc-garantia").textContent = "Não";
        document.getElementById("detalhe-nome-certificado-garantia").textContent = "-";
        document.getElementById("detalhe-data-certificado-garantia").textContent = "-";
        document.getElementById("detalhe-validade-certificado-garantia").textContent = "-";
    }

    document.getElementById("detalhe-observacoes-garantia").textContent = equipamento.observacoesGarantia || "Sem observações";

    const badgeGarantia = document.getElementById("badge-accordion-garantia");
    if (badgeGarantia) {
        const tem = equipamento.temDocumentacaoGarantia === "sim";
        badgeGarantia.className = `badge-accordion-doc ${tem ? "badge-accordion-sim" : "badge-accordion-nao"}`;
        badgeGarantia.textContent = tem ? "Sim" : "Não";
    }

    const campoFicheiroGarantia = document.getElementById("detalhe-ficheiro-garantia");
    if (campoFicheiroGarantia) {
        if (equipamento.ficheiroGarantia && equipamento.ficheiroGarantia !== "") {
            campoFicheiroGarantia.innerHTML = `
            <span style="display:inline-flex; align-items:center; gap:0.4rem; color:#003f78; font-weight:600;">
                <i class="fa-solid fa-file-pdf" style="color:#dc3545;"></i>
                ${equipamento.ficheiroGarantia.split('\\').pop().split('/').pop()}
            </span>
        `;
        } else {
            campoFicheiroGarantia.textContent = "Sem ficheiro associado";
        }
    }

    // Separador 7 — Contrato
    document.getElementById("detalhe-contrato-manutencao").textContent = equipamento.contratoManutencao || "Não definido";
    document.getElementById("detalhe-tipo-contrato").textContent = equipamento.tipoContrato || "Não definido";
    document.getElementById("detalhe-entidade-responsavel-contrato").textContent = equipamento.entidadeResponsavelContrato || "Não definido";
    document.getElementById("detalhe-periodicidade-contrato").textContent = equipamento.periodicidadeContrato || "Não definida";

    if (equipamento.temDocumentacaoContrato === "sim") {

        document.getElementById("detalhe-tem-doc-contrato").textContent =
            equipamento.tipoContratoManutencao || "Contrato de manutenção";

        document.getElementById("detalhe-nome-contrato-manutencao").textContent =
            equipamento.nomeContratoManutencao || "";

        document.getElementById("detalhe-data-contrato-manutencao").textContent =
            equipamento.dataContratoManutencao || "";

        document.getElementById("detalhe-validade-contrato-manutencao").textContent =
            equipamento.validadeContratoManutencao || "";

    } else {

        document.getElementById("detalhe-tem-doc-contrato").textContent = "Não";
        document.getElementById("detalhe-nome-contrato-manutencao").textContent = "-";
        document.getElementById("detalhe-data-contrato-manutencao").textContent = "-";
        document.getElementById("detalhe-validade-contrato-manutencao").textContent = "-";
    }

    if (equipamento.temRelatorioContrato === "sim") {

        document.getElementById("detalhe-tem-relatorio-contrato").textContent =
            equipamento.tipoRelatorioManutencao || "Relatório de manutenção";

        document.getElementById("detalhe-nome-relatorio-manutencao").textContent =
            equipamento.nomeRelatorioManutencao || "";

        document.getElementById("detalhe-data-relatorio-manutencao").textContent =
            equipamento.dataRelatorioManutencao || "";

        document.getElementById("detalhe-validade-relatorio-manutencao").textContent =
            equipamento.validadeRelatorioManutencao || "";

    } else {

        document.getElementById("detalhe-tem-relatorio-contrato").textContent = "Não";
        document.getElementById("detalhe-nome-relatorio-manutencao").textContent = "-";
        document.getElementById("detalhe-data-relatorio-manutencao").textContent = "-";
        document.getElementById("detalhe-validade-relatorio-manutencao").textContent = "-";
    }

    if (equipamento.temDocumentacaoCalibracao === "sim") {

        document.getElementById("detalhe-tem-doc-calibracao").textContent =
            equipamento.tipoCertificadoCalibracao || "Certificado de calibração";

        document.getElementById("detalhe-nome-certificado-calibracao").textContent =
            equipamento.nomeCertificadoCalibracao || "";

        document.getElementById("detalhe-data-certificado-calibracao").textContent =
            equipamento.dataCertificadoCalibracao || "";

        document.getElementById("detalhe-validade-certificado-calibracao").textContent =
            equipamento.validadeCertificadoCalibracao || "";

    } else {

        document.getElementById("detalhe-tem-doc-calibracao").textContent = "Não";
        document.getElementById("detalhe-nome-certificado-calibracao").textContent = "-";
        document.getElementById("detalhe-data-certificado-calibracao").textContent = "-";
        document.getElementById("detalhe-validade-certificado-calibracao").textContent = "-";
    }

    if (equipamento.temRelatorioCalibracao === "sim") {

        document.getElementById("detalhe-tem-relatorio-calibracao").textContent =
            equipamento.tipoRelatorioCalibracao || "Relatório de calibração";

        document.getElementById("detalhe-nome-relatorio-calibracao").textContent =
            equipamento.nomeRelatorioCalibracao || "";

        document.getElementById("detalhe-data-relatorio-calibracao").textContent =
            equipamento.dataRelatorioCalibracao || "";

        document.getElementById("detalhe-validade-relatorio-calibracao").textContent =
            equipamento.validadeRelatorioCalibracao || "";

    } else {

        document.getElementById("detalhe-tem-relatorio-calibracao").textContent = "Não";
        document.getElementById("detalhe-nome-relatorio-calibracao").textContent = "-";
        document.getElementById("detalhe-data-relatorio-calibracao").textContent = "-";
        document.getElementById("detalhe-validade-relatorio-calibracao").textContent = "-";
    }

    document.getElementById("detalhe-observacoes-contrato").textContent = equipamento.observacoesContrato || "Sem observações";

    // Badges accordion contrato
    const badgeDocContrato = document.getElementById("badge-accordion-doc-contrato");
    if (badgeDocContrato) {
        const tem = equipamento.temDocumentacaoContrato === "sim";
        badgeDocContrato.className = `badge-accordion-doc ${tem ? "badge-accordion-sim" : "badge-accordion-nao"}`;
        badgeDocContrato.textContent = tem ? "Sim" : "Não";
    }

    const badgeRelatorioManutencao = document.getElementById("badge-accordion-relatorio-manutencao");
    if (badgeRelatorioManutencao) {
        const tem = equipamento.temRelatorioContrato === "sim";
        badgeRelatorioManutencao.className = `badge-accordion-doc ${tem ? "badge-accordion-sim" : "badge-accordion-nao"}`;
        badgeRelatorioManutencao.textContent = tem ? "Sim" : "Não";
    }

    const badgeCalibracao = document.getElementById("badge-accordion-calibracao");
    if (badgeCalibracao) {
        const tem = equipamento.temDocumentacaoCalibracao === "sim";
        badgeCalibracao.className = `badge-accordion-doc ${tem ? "badge-accordion-sim" : "badge-accordion-nao"}`;
        badgeCalibracao.textContent = tem ? "Sim" : "Não";
    }

    const badgeRelatorioCalibracao = document.getElementById("badge-accordion-relatorio-calibracao");
    if (badgeRelatorioCalibracao) {
        const tem = equipamento.temRelatorioCalibracao === "sim";
        badgeRelatorioCalibracao.className = `badge-accordion-doc ${tem ? "badge-accordion-sim" : "badge-accordion-nao"}`;
        badgeRelatorioCalibracao.textContent = tem ? "Sim" : "Não";
    }

    // Ficheiros contrato
    const ficheiroContratoManutencao = document.getElementById("detalhe-ficheiro-contrato-manutencao");
    if (ficheiroContratoManutencao) {
        if (equipamento.ficheiroContratoManutencao && equipamento.ficheiroContratoManutencao !== "") {
            ficheiroContratoManutencao.innerHTML = `
            <span style="display:inline-flex; align-items:center; gap:0.4rem; color:#003f78; font-weight:600;">
                <i class="fa-solid fa-file-pdf" style="color:#dc3545;"></i>
                ${equipamento.ficheiroContratoManutencao.split('\\').pop().split('/').pop()}
            </span>`;
        } else {
            ficheiroContratoManutencao.textContent = "Sem ficheiro associado";
        }
    }

    const ficheiroRelatorioManutencao = document.getElementById("detalhe-ficheiro-relatorio-manutencao");
    if (ficheiroRelatorioManutencao) {
        if (equipamento.ficheiroRelatorioManutencao && equipamento.ficheiroRelatorioManutencao !== "") {
            ficheiroRelatorioManutencao.innerHTML = `
            <span style="display:inline-flex; align-items:center; gap:0.4rem; color:#003f78; font-weight:600;">
                <i class="fa-solid fa-file-pdf" style="color:#dc3545;"></i>
                ${equipamento.ficheiroRelatorioManutencao.split('\\').pop().split('/').pop()}
            </span>`;
        } else {
            ficheiroRelatorioManutencao.textContent = "Sem ficheiro associado";
        }
    }

    const ficheiroCertificadoCalibracao = document.getElementById("detalhe-ficheiro-certificado-calibracao");
    if (ficheiroCertificadoCalibracao) {
        if (equipamento.ficheiroCertificadoCalibracao && equipamento.ficheiroCertificadoCalibracao !== "") {
            ficheiroCertificadoCalibracao.innerHTML = `
            <span style="display:inline-flex; align-items:center; gap:0.4rem; color:#003f78; font-weight:600;">
                <i class="fa-solid fa-file-pdf" style="color:#dc3545;"></i>
                ${equipamento.ficheiroCertificadoCalibracao.split('\\').pop().split('/').pop()}
            </span>`;
        } else {
            ficheiroCertificadoCalibracao.textContent = "Sem ficheiro associado";
        }
    }

    const ficheiroRelatorioCalibracao = document.getElementById("detalhe-ficheiro-relatorio-calibracao");
    if (ficheiroRelatorioCalibracao) {
        if (equipamento.ficheiroRelatorioCalibracao && equipamento.ficheiroRelatorioCalibracao !== "") {
            ficheiroRelatorioCalibracao.innerHTML = `
            <span style="display:inline-flex; align-items:center; gap:0.4rem; color:#003f78; font-weight:600;">
                <i class="fa-solid fa-file-pdf" style="color:#dc3545;"></i>
                ${equipamento.ficheiroRelatorioCalibracao.split('\\').pop().split('/').pop()}
            </span>`;
        } else {
            ficheiroRelatorioCalibracao.textContent = "Sem ficheiro associado";
        }
    }

    // Separador 8 — Resumo documentação
    function renderizarResumoDoc(containerId, badgeId, tem, nome, data, validade, ficheiro, mostrarValidade = true) {
        const accordionItem = document.getElementById(containerId + "-accordion");
        const container = document.getElementById(containerId);
        const badge = document.getElementById(badgeId);

        if (!accordionItem) return;

        if (tem !== "sim" || !nome) {
            accordionItem.style.display = "none";
            return;
        }

        accordionItem.style.display = "block";

        if (badge) {
            if (ficheiro && ficheiro !== "") {
                badge.className = "badge-accordion-doc badge-resumo-pdf";
                badge.innerHTML = `<i class="fa-solid fa-file-pdf" style="margin-right:3px;"></i> Ver PDF`;
                badge.style.cursor = "pointer";
                badge.onclick = function (e) {
                    e.stopPropagation();
                    alert("Ficheiro: " + ficheiro);
                };
            } else {
                badge.className = "badge-accordion-doc badge-accordion-nao";
                badge.textContent = "Sem PDF";
                badge.onclick = null;
                badge.style.cursor = "default";
            }
        }

        if (!container) return;

        container.innerHTML = `
        <div class="grelha-detalhes-equipamento" style="padding: 1.2rem 0 0.5rem;">
            <div class="campo-detalhes">
                <h3>Nome do documento</h3>
                <p>${nome || "Não definido"}</p>
            </div>
            <div class="campo-detalhes">
                <h3>Data</h3>
                <p>${data || "Não definida"}</p>
            </div>
            ${mostrarValidade ? `
            <div class="campo-detalhes">
                <h3>Validade</h3>
                <p>${validade || "Sem validade"}</p>
            </div>` : ""}
            ${ficheiro && ficheiro !== "" ? `
            <div class="campo-detalhes">
                <h3>Ficheiro PDF</h3>
                <p>
                    <span style="display:inline-flex; align-items:center; gap:0.4rem; color:#003f78; font-weight:600;">
                        <i class="fa-solid fa-file-pdf" style="color:#dc3545;"></i>
                        ${ficheiro.split('\\').pop().split('/').pop()}
                    </span>
                </p>
            </div>` : ""}
        </div>
    `;
    }

    renderizarResumoDoc("resumo-doc-tecnica", "badge-resumo-tecnica", equipamento.temDocumentacaoTecnica, equipamento.nomeManualTecnico, equipamento.dataManualTecnico, equipamento.validadeManualTecnico, equipamento.ficheiroManualTecnico);
    renderizarResumoDoc("resumo-doc-utilizacao", "badge-resumo-utilizacao", equipamento.temDocumentacaoUtilizacao, equipamento.nomeManualUtilizacao, equipamento.dataManualUtilizacao, equipamento.validadeManualUtilizacao, equipamento.ficheiroManualUtilizacao);
    renderizarResumoDoc("resumo-doc-conformidade", "badge-resumo-conformidade", equipamento.temDeclaracaoConformidade, equipamento.nomeDeclaracaoConformidade, equipamento.dataDeclaracaoConformidade, equipamento.validadeDeclaracaoConformidade, equipamento.ficheiroDeclaracaoConformidade);
    renderizarResumoDoc("resumo-doc-aquisicao", "badge-resumo-aquisicao", equipamento.temContratoAquisicao, equipamento.nomeContratoAquisicao, equipamento.dataContratoAquisicao, equipamento.validadeContratoAquisicao, equipamento.ficheiroContratoAquisicao);
    renderizarResumoDoc("resumo-doc-fatura", "badge-resumo-fatura", equipamento.temFatura, equipamento.nomeFatura, equipamento.dataFatura, "", equipamento.ficheiroFatura, false);
    renderizarResumoDoc("resumo-doc-garantia", "badge-resumo-garantia", equipamento.temDocumentacaoGarantia, equipamento.nomeCertificadoGarantia, equipamento.dataCertificadoGarantia, equipamento.validadeCertificadoGarantia, equipamento.ficheiroGarantia);
    renderizarResumoDoc("resumo-doc-manutencao", "badge-resumo-manutencao", equipamento.temDocumentacaoContrato, equipamento.nomeContratoManutencao, equipamento.dataContratoManutencao, equipamento.validadeContratoManutencao, equipamento.ficheiroContratoManutencao);
    renderizarResumoDoc("resumo-doc-relatorio-manutencao", "badge-resumo-relatorio-manutencao", equipamento.temRelatorioContrato, equipamento.nomeRelatorioManutencao, equipamento.dataRelatorioManutencao, equipamento.validadeRelatorioManutencao, equipamento.ficheiroRelatorioManutencao);
    renderizarResumoDoc("resumo-doc-calibracao", "badge-resumo-calibracao", equipamento.temDocumentacaoCalibracao, equipamento.nomeCertificadoCalibracao, equipamento.dataCertificadoCalibracao, equipamento.validadeCertificadoCalibracao, equipamento.ficheiroCertificadoCalibracao);
    renderizarResumoDoc("resumo-doc-relatorio-calibracao", "badge-resumo-relatorio-calibracao", equipamento.temRelatorioCalibracao, equipamento.nomeRelatorioCalibracao, equipamento.dataRelatorioCalibracao, equipamento.validadeRelatorioCalibracao, equipamento.ficheiroRelatorioCalibracao);
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

    // Identificação
    document.getElementById("codigo").value = equipamento.codigo || "";
    document.getElementById("designacao").value = equipamento.designacao || "";
    document.getElementById("categoria").value = equipamento.categoria || "";
    document.getElementById("marca").value = equipamento.marca || "";
    document.getElementById("modelo").value = equipamento.modelo || "";
    document.getElementById("numero_serie").value = equipamento.numeroSerie || "";
    document.getElementById("fabricante").value = equipamento.fabricante || "";
    document.getElementById("ano_fabrico").value = equipamento.anoFabrico || "";
    document.getElementById("estado").value = equipamento.estado || "";
    document.getElementById("criticidade").value = equipamento.criticidade || "";
    document.getElementById("observacoes").value = equipamento.observacoes || "";

    // Documentação técnica
    document.getElementById("tem_documentacao_tecnica").value = equipamento.temDocumentacaoTecnica || "";
    if (equipamento.temDocumentacaoTecnica === "sim") {
        document.getElementById("bloco-documentacao-tecnica").style.display = "block";
        document.getElementById("nomeManualTecnico").value = equipamento.nomeManualTecnico || "";
        document.getElementById("dataManualTecnico").value = converterDataParaInput(equipamento.dataManualTecnico);
        document.getElementById("validadeManualTecnico").value = converterDataParaInput(equipamento.validadeManualTecnico);
    }

    // Documentação utilização
    document.getElementById("tem_documentacao_utilizacao").value = equipamento.temDocumentacaoUtilizacao || "";
    if (equipamento.temDocumentacaoUtilizacao === "sim") {
        document.getElementById("bloco-documentacao-utilizacao").style.display = "block";
        document.getElementById("nomeManualUtilizacao").value = equipamento.nomeManualUtilizacao || "";
        document.getElementById("dataManualUtilizacao").value = converterDataParaInput(equipamento.dataManualUtilizacao);
        document.getElementById("validadeManualUtilizacao").value = converterDataParaInput(equipamento.validadeManualUtilizacao);
    }

    // Documentação de Conformidade
    document.getElementById("tem_declaracao_conformidade").value = equipamento.temDeclaracaoConformidade || "";
    if (equipamento.temDeclaracaoConformidade === "sim") {
        document.getElementById("bloco-declaracao-conformidade").style.display = "block";
        document.getElementById("nomeDeclaracaoConformidade").value = equipamento.nomeDeclaracaoConformidade || "";
        document.getElementById("dataDeclaracaoConformidade").value = converterDataParaInput(equipamento.dataDeclaracaoConformidade);
        document.getElementById("validadeDeclaracaoConformidade").value = converterDataParaInput(equipamento.validadeDeclaracaoConformidade);
    }

    // Acessórios
    if (equipamento.acessorios && equipamento.acessorios.length > 0) {
        equipamento.acessorios.forEach(function (item) {
            adicionarItem('acessorios', {
                nome: item.nome,
                ref: item.referencia,
                qty: item.quantidade,
                unidade: item.unidade,
                estado: item.estado,
                obs: item.observacoes
            });
        });
    }

    // Consumíveis
    if (equipamento.consumiveis && equipamento.consumiveis.length > 0) {
        equipamento.consumiveis.forEach(function (item) {
            adicionarItem('consumiveis', {
                nome: item.nome,
                ref: item.referencia,
                qty: item.quantidade,
                unidade: item.unidade,
                estado: item.estado,
                obs: item.observacoes
            });
        });
    }

    // Aquisição
    document.getElementById("data_aquisicao").value = converterDataParaInput(equipamento.dataAquisicao);
    document.getElementById("custo_aquisicao").value = limparCusto(equipamento.custoAquisicao);
    document.getElementById("tipo_entrada").value = equipamento.tipoEntrada || "";
    document.getElementById("observacoesAquisicao").value = equipamento.observacoesAquisicao || "";

    // Contrato aquisição
    document.getElementById("tem_contrato_aquisicao").value = equipamento.temContratoAquisicao || "";
    if (equipamento.temContratoAquisicao === "sim") {
        document.getElementById("bloco-contrato-aquisicao").style.display = "block";
        document.getElementById("nomeContratoAquisicao").value = equipamento.nomeContratoAquisicao || "";
        document.getElementById("dataContratoAquisicao").value = converterDataParaInput(equipamento.dataContratoAquisicao);
        document.getElementById("validadeContratoAquisicao").value = converterDataParaInput(equipamento.validadeContratoAquisicao);
    }

    // Fatura
    document.getElementById("tem_fatura").value = equipamento.temFatura || "";
    if (equipamento.temFatura === "sim") {
        document.getElementById("bloco-fatura").style.display = "block";
        document.getElementById("nomeFatura").value = equipamento.nomeFatura || "";
        document.getElementById("dataFatura").value = converterDataParaInput(equipamento.dataFatura);
    }

    // Fornecedores
    if (equipamento.fornecedores && equipamento.fornecedores.length > 0) {
        equipamento.fornecedores.forEach(function (f) {
            adicionarFornecedorEquipamento();
            const linhas = document.querySelectorAll('#tbody-fornecedores-equipamento tr');
            const ultima = linhas[linhas.length - 1];
            ultima.querySelector('select[name="fornecedores[codigo][]"]').value = f.codigo || "";
            ultima.querySelector('select[name="fornecedores[tipo][]"]').value = f.tipo || "";
            ultima.querySelector('select[name="fornecedores[morada][]"]').value = f.morada || "";
            ultima.querySelector('input[name="fornecedores[pessoa][]"]').value = f.pessoaContacto || "";
            ultima.querySelector('input[name="fornecedores[telefone][]"]').value = f.telefone || "";
            ultima.querySelector('input[name="fornecedores[observacoes][]"]').value = f.observacoes || "";
        });
        atualizarResumoFornecedores();
    }

    // Localização
    preencherSelectLocalizacoes("localizacao", equipamento.localizacao);
    document.getElementById("observacoesLocalizacao").value = equipamento.observacoesLocalizacao || "";

    // Garantia
    document.getElementById("dataInicioGarantia").value = converterDataParaInput(equipamento.dataInicioGarantia);
    document.getElementById("dataFimGarantia").value = converterDataParaInput(equipamento.dataFimGarantia);
    document.getElementById("tem_documentacao_garantia").value = equipamento.temDocumentacaoGarantia || "";
    if (equipamento.temDocumentacaoGarantia === "sim") {
        document.getElementById("bloco-documentacao-garantia").style.display = "block";
        document.getElementById("nomeCertificadoGarantia").value = equipamento.nomeCertificadoGarantia || "";
        document.getElementById("dataCertificadoGarantia").value = converterDataParaInput(equipamento.dataCertificadoGarantia);
        document.getElementById("validadeCertificadoGarantia").value = converterDataParaInput(equipamento.validadeCertificadoGarantia);
    }
    document.getElementById("observacoesGarantia").value = equipamento.observacoesGarantia || "";

    // Contrato manutenção
    document.getElementById("contratoManutencao").value = equipamento.contratoManutencao || "";
    document.getElementById("tipoContrato").value = equipamento.tipoContrato || "";
    document.getElementById("entidadeResponsavelContrato").value = equipamento.entidadeResponsavelContrato || "";
    document.getElementById("periodicidadeContrato").value = equipamento.periodicidadeContrato || "Não aplicável";
    document.getElementById("observacoesContrato").value = equipamento.observacoesContrato || "";

    document.getElementById("tem_documentacao_contrato").value = equipamento.temDocumentacaoContrato || "";
    if (equipamento.temDocumentacaoContrato === "sim") {
        document.getElementById("bloco-documentacao-contrato").style.display = "block";
        document.getElementById("nomeContratoManutencao").value = equipamento.nomeContratoManutencao || "";
        document.getElementById("dataContratoManutencao").value = converterDataParaInput(equipamento.dataContratoManutencao);
        document.getElementById("validadeContratoManutencao").value = converterDataParaInput(equipamento.validadeContratoManutencao);
    }

    // Relatório manutenção
    document.getElementById("tem_relatorio_contrato").value = equipamento.temRelatorioContrato || "";
    if (equipamento.temRelatorioContrato === "sim") {
        document.getElementById("bloco-relatorio-contrato").style.display = "block";
        document.getElementById("nomeRelatorioManutencao").value = equipamento.nomeRelatorioManutencao || "";
        document.getElementById("dataRelatorioManutencao").value = converterDataParaInput(equipamento.dataRelatorioManutencao);
        document.getElementById("validadeRelatorioManutencao").value = converterDataParaInput(equipamento.validadeRelatorioManutencao);
    }

    // Calibração
    document.getElementById("tem_documentacao_calibracao").value = equipamento.temDocumentacaoCalibracao || "";
    if (equipamento.temDocumentacaoCalibracao === "sim") {
        document.getElementById("bloco-documentacao-calibracao").style.display = "block";
        document.getElementById("nomeCertificadoCalibracao").value = equipamento.nomeCertificadoCalibracao || "";
        document.getElementById("dataCertificadoCalibracao").value = converterDataParaInput(equipamento.dataCertificadoCalibracao);
        document.getElementById("validadeCertificadoCalibracao").value = converterDataParaInput(equipamento.validadeCertificadoCalibracao);
    }

    // Relatório calibração
    document.getElementById("tem_relatorio_calibracao").value = equipamento.temRelatorioCalibracao || "";
    if (equipamento.temRelatorioCalibracao === "sim") {
        document.getElementById("bloco-relatorio-calibracao").style.display = "block";
        document.getElementById("nomeRelatorioCalibracao").value = equipamento.nomeRelatorioCalibracao || "";
        document.getElementById("dataRelatorioCalibracao").value = converterDataParaInput(equipamento.dataRelatorioCalibracao);
        document.getElementById("validadeRelatorioCalibracao").value = converterDataParaInput(equipamento.validadeRelatorioCalibracao);
    }

    function controlarBloco(selectId, blocoId) {

        const select = document.getElementById(selectId);
        const bloco = document.getElementById(blocoId);

        if (!select || !bloco) {
            return;
        }

        function atualizar() {

            if (select.value === "sim") {
                bloco.style.display = "block";
            } else {
                bloco.style.display = "none";
            }

        }

        select.addEventListener("change", atualizar);

        atualizar();
    }

    controlarBloco(
        "tem_documentacao_tecnica",
        "bloco-documentacao-tecnica"
    );

    controlarBloco(
        "tem_documentacao_utilizacao",
        "bloco-documentacao-utilizacao"
    );

    controlarBloco(
        "tem_declaracao_conformidade",
        "bloco-declaracao-conformidade"
    );

    controlarBloco(
        "tem_contrato_aquisicao",
        "bloco-contrato-aquisicao"
    );

    controlarBloco(
        "tem_fatura",
        "bloco-fatura"
    );

    const selectTipoEntradaEditar = document.getElementById("tipo_entrada");
    const seletorFaturaEditar = document.getElementById('tem_fatura');
    const blocoFaturaEditar = document.getElementById('bloco-fatura');

    function atualizarFaturaPorTipoEntradaEditar() {
        if (!selectTipoEntradaEditar || !seletorFaturaEditar || !blocoFaturaEditar) return;
        const tipo = selectTipoEntradaEditar.value;

        if (tipo === "Compra") {
            seletorFaturaEditar.value = "sim";
            blocoFaturaEditar.style.display = "block";
            seletorFaturaEditar.style.pointerEvents = "none";
            seletorFaturaEditar.style.opacity = "0.75";
        } else if (tipo === "Doação" || tipo === "Empréstimo") {
            seletorFaturaEditar.value = "nao";
            blocoFaturaEditar.style.display = "none";
            seletorFaturaEditar.style.pointerEvents = "none";
            seletorFaturaEditar.style.opacity = "0.75";
        } else if (tipo === "Aluguer") {
            seletorFaturaEditar.style.pointerEvents = "";
            seletorFaturaEditar.style.opacity = "";
            if (seletorFaturaEditar.value !== "sim") blocoFaturaEditar.style.display = "none";
        } else {
            seletorFaturaEditar.value = "";
            blocoFaturaEditar.style.display = "none";
            seletorFaturaEditar.style.pointerEvents = "none";
            seletorFaturaEditar.style.opacity = "0.75";
        }
    }

    if (selectTipoEntradaEditar) {
        selectTipoEntradaEditar.addEventListener("change", atualizarFaturaPorTipoEntradaEditar);
        atualizarFaturaPorTipoEntradaEditar();
    }

    controlarBloco(
        "tem_documentacao_garantia",
        "bloco-documentacao-garantia"
    );

    // Contrato de manutenção — controlado pelo select principal
    const selectContratoEditar = document.getElementById('contratoManutencao');
    const seletorDocContratoEditar = document.getElementById('tem_documentacao_contrato');
    const blocoDocContratoEditar = document.getElementById('bloco-documentacao-contrato');
    const seletorRelatorioEditar = document.getElementById('tem_relatorio_contrato');
    const blocoRelatorioEditar = document.getElementById('bloco-relatorio-contrato');

    if (selectContratoEditar && seletorDocContratoEditar) {

        function atualizarDocContratoEditar() {
            if (selectContratoEditar.value === "Sim") {

                seletorDocContratoEditar.value = "sim";
                if (blocoDocContratoEditar) blocoDocContratoEditar.style.display = "block";
                seletorDocContratoEditar.style.pointerEvents = "none";
                seletorDocContratoEditar.style.opacity = "0.75";

                seletorRelatorioEditar.style.pointerEvents = "";
                seletorRelatorioEditar.style.opacity = "";
                if (blocoRelatorioEditar) {
                    blocoRelatorioEditar.style.display = seletorRelatorioEditar.value === "sim" ? "block" : "none";
                }

            } else {

                seletorDocContratoEditar.value = "nao";
                if (blocoDocContratoEditar) blocoDocContratoEditar.style.display = "none";
                seletorDocContratoEditar.style.pointerEvents = "none";
                seletorDocContratoEditar.style.opacity = "0.75";

                seletorRelatorioEditar.value = "nao";
                if (blocoRelatorioEditar) blocoRelatorioEditar.style.display = "none";
                seletorRelatorioEditar.style.pointerEvents = "none";
                seletorRelatorioEditar.style.opacity = "0.75";
            }
        }

        selectContratoEditar.addEventListener('change', atualizarDocContratoEditar);
        atualizarDocContratoEditar();

        seletorDocContratoEditar.addEventListener('mousedown', function (e) { e.preventDefault(); });
        seletorDocContratoEditar.addEventListener('keydown', function (e) { e.preventDefault(); });
    }

    if (seletorRelatorioEditar) {
        seletorRelatorioEditar.addEventListener('change', function () {
            if (blocoRelatorioEditar) {
                blocoRelatorioEditar.style.display = this.value === 'sim' ? 'block' : 'none';
            }
        });
    }

    controlarBloco(
        "tem_documentacao_calibracao",
        "bloco-documentacao-calibracao"
    );

    controlarBloco(
        "tem_relatorio_calibracao",
        "bloco-relatorio-calibracao"
    );

    // Submit
    formEditarEquipamento.addEventListener("submit", function (event) {
        event.preventDefault();

        const eq = equipamentosGuardados[idEquipamento];

        eq.designacao = document.getElementById("designacao").value.trim();
        eq.categoria = document.getElementById("categoria").value.trim();
        eq.marca = document.getElementById("marca").value.trim();
        eq.modelo = document.getElementById("modelo").value.trim();
        eq.numeroSerie = document.getElementById("numero_serie").value.trim();
        eq.fabricante = document.getElementById("fabricante").value.trim();
        eq.anoFabrico = document.getElementById("ano_fabrico").value.trim();
        eq.estado = document.getElementById("estado").value.trim();
        eq.criticidade = document.getElementById("criticidade").value.trim();
        eq.observacoes = document.getElementById("observacoes").value.trim();

        eq.temDocumentacaoTecnica = document.getElementById("tem_documentacao_tecnica").value;
        eq.nomeManualTecnico = document.getElementById("nomeManualTecnico").value.trim();
        eq.dataManualTecnico = converterDataParaTexto(document.getElementById("dataManualTecnico").value);
        eq.validadeManualTecnico = converterDataParaTexto(document.getElementById("validadeManualTecnico").value);

        eq.temDocumentacaoUtilizacao = document.getElementById("tem_documentacao_utilizacao").value;
        eq.nomeManualUtilizacao = document.getElementById("nomeManualUtilizacao").value.trim();
        eq.dataManualUtilizacao = converterDataParaTexto(document.getElementById("dataManualUtilizacao").value);
        eq.validadeManualUtilizacao = converterDataParaTexto(document.getElementById("validadeManualUtilizacao").value);

        eq.temDeclaracaoConformidade = document.getElementById("tem_declaracao_conformidade").value;
        eq.nomeDeclaracaoConformidade = document.getElementById("nomeDeclaracaoConformidade").value.trim();
        eq.dataDeclaracaoConformidade = converterDataParaTexto(document.getElementById("dataDeclaracaoConformidade").value);
        eq.validadeDeclaracaoConformidade = converterDataParaTexto(document.getElementById("validadeDeclaracaoConformidade").value);
        eq.ficheiroDeclaracaoConformidade = document.getElementById("ficheiroDeclaracaoConformidade").value;

        eq.acessorios = Array.from(document.querySelectorAll('#tbody-acessorios tr')).map(function (tr) {
            return {
                nome: tr.querySelector('input[name="acessorios[nome][]"]')?.value || "",
                referencia: tr.querySelector('input[name="acessorios[referencia][]"]')?.value || "",
                quantidade: tr.querySelector('input[type="number"]')?.value || "",
                unidade: tr.querySelector('select[name="acessorios[unidade][]"]')?.value || "",
                estado: tr.querySelector('select[name="acessorios[estado][]"]')?.value || "",
                observacoes: tr.querySelector('input[name="acessorios[observacoes][]"]')?.value || ""
            };
        });

        eq.consumiveis = Array.from(document.querySelectorAll('#tbody-consumiveis tr')).map(function (tr) {
            return {
                nome: tr.querySelector('input[name="consumiveis[nome][]"]')?.value || "",
                referencia: tr.querySelector('input[name="consumiveis[referencia][]"]')?.value || "",
                quantidade: tr.querySelector('input[type="number"]')?.value || "",
                unidade: tr.querySelector('select[name="consumiveis[unidade][]"]')?.value || "",
                estado: tr.querySelector('select[name="consumiveis[estado][]"]')?.value || "",
                observacoes: tr.querySelector('input[name="consumiveis[observacoes][]"]')?.value || ""
            };
        });

        eq.dataAquisicao = converterDataParaTexto(document.getElementById("data_aquisicao").value);
        eq.custoAquisicao = document.getElementById("custo_aquisicao").value.trim() + " €";
        eq.tipoEntrada = document.getElementById("tipo_entrada").value.trim();
        eq.observacoesAquisicao = document.getElementById("observacoesAquisicao").value.trim();

        eq.temContratoAquisicao = document.getElementById("tem_contrato_aquisicao").value;
        eq.nomeContratoAquisicao = document.getElementById("nomeContratoAquisicao").value.trim();
        eq.dataContratoAquisicao = converterDataParaTexto(document.getElementById("dataContratoAquisicao").value);
        eq.validadeContratoAquisicao = converterDataParaTexto(document.getElementById("validadeContratoAquisicao").value);

        eq.temFatura = document.getElementById("tem_fatura").value;
        eq.nomeFatura = document.getElementById("nomeFatura").value.trim();
        eq.dataFatura = converterDataParaTexto(document.getElementById("dataFatura").value);

        eq.fornecedores = Array.from(document.querySelectorAll('#tbody-fornecedores-equipamento tr')).map(function (tr) {
            return {
                codigo: tr.querySelector('select[name="fornecedores[codigo][]"]')?.value || "",
                morada: tr.querySelector('select[name="fornecedores[morada][]"]')?.value || "",
                pessoaContacto: tr.querySelector('input[name="fornecedores[pessoa][]"]')?.value || "",
                telefone: tr.querySelector('input[name="fornecedores[telefone][]"]')?.value || "",
                tipo: tr.querySelector('select[name="fornecedores[tipo][]"]')?.value || "",
                observacoes: tr.querySelector('input[name="fornecedores[observacoes][]"]')?.value || ""
            };
        });

        eq.localizacao = document.getElementById("localizacao").value.trim();
        eq.observacoesLocalizacao = document.getElementById("observacoesLocalizacao").value.trim();

        eq.dataInicioGarantia = converterDataParaTexto(document.getElementById("dataInicioGarantia").value);
        eq.dataFimGarantia = converterDataParaTexto(document.getElementById("dataFimGarantia").value);
        eq.temDocumentacaoGarantia = document.getElementById("tem_documentacao_garantia").value;
        eq.nomeCertificadoGarantia = document.getElementById("nomeCertificadoGarantia").value.trim();
        eq.dataCertificadoGarantia = converterDataParaTexto(document.getElementById("dataCertificadoGarantia").value);
        eq.validadeCertificadoGarantia = converterDataParaTexto(document.getElementById("validadeCertificadoGarantia").value);
        eq.observacoesGarantia = document.getElementById("observacoesGarantia").value.trim();

        eq.contratoManutencao = document.getElementById("contratoManutencao").value;
        eq.tipoContrato = document.getElementById("contratoManutencao").value === "Não" ? "Não existe" : document.getElementById("tipoContrato").value.trim();
        eq.entidadeResponsavelContrato = document.getElementById("contratoManutencao").value === "Não" ? "Não existe" : document.getElementById("entidadeResponsavelContrato").value.trim();
        eq.periodicidadeContrato = document.getElementById("contratoManutencao").value === "Não" ? "Não aplicável" : document.getElementById("periodicidadeContrato").value;
        eq.observacoesContrato = document.getElementById("observacoesContrato").value.trim();

        eq.temDocumentacaoContrato = document.getElementById("tem_documentacao_contrato").value;
        eq.nomeContratoManutencao = document.getElementById("nomeContratoManutencao").value.trim();
        eq.dataContratoManutencao = converterDataParaTexto(document.getElementById("dataContratoManutencao").value);
        eq.validadeContratoManutencao = converterDataParaTexto(document.getElementById("validadeContratoManutencao").value);

        eq.temRelatorioContrato = document.getElementById("tem_relatorio_contrato").value;
        eq.nomeRelatorioManutencao = document.getElementById("nomeRelatorioManutencao").value.trim();
        eq.dataRelatorioManutencao = converterDataParaTexto(document.getElementById("dataRelatorioManutencao").value);
        eq.validadeRelatorioManutencao = converterDataParaTexto(document.getElementById("validadeRelatorioManutencao").value);

        eq.temDocumentacaoCalibracao = document.getElementById("tem_documentacao_calibracao").value;
        eq.nomeCertificadoCalibracao = document.getElementById("nomeCertificadoCalibracao").value.trim();
        eq.dataCertificadoCalibracao = converterDataParaTexto(document.getElementById("dataCertificadoCalibracao").value);
        eq.validadeCertificadoCalibracao = converterDataParaTexto(document.getElementById("validadeCertificadoCalibracao").value);

        eq.temRelatorioCalibracao = document.getElementById("tem_relatorio_calibracao").value;
        eq.nomeRelatorioCalibracao = document.getElementById("nomeRelatorioCalibracao").value.trim();
        eq.dataRelatorioCalibracao = converterDataParaTexto(document.getElementById("dataRelatorioCalibracao").value);
        eq.validadeRelatorioCalibracao = converterDataParaTexto(document.getElementById("validadeRelatorioCalibracao").value);

        localStorage.setItem(
            "equipamentosGuardados",
            JSON.stringify(equipamentosGuardados)
        );

        setTimeout(function () {
            window.location.href =
                "consultar_equipamento.html?id=" + idEquipamento;
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
    },

    LOC005: {
        codigo: "LOC005",
        edificio: "Edifício Principal",
        piso: "Piso 1",
        servico: "Radiologia",
        sala: "Sala RX-03",
        observacoes: "Área destinada a equipamentos de diagnóstico por imagem."
    },

    LOC006: {
        codigo: "LOC006",
        edificio: "Edifício Cirúrgico",
        piso: "Piso 0",
        servico: "Bloco Operatório Central",
        sala: "Sala BO-02",
        observacoes: "Sala equipada para intervenções cirúrgicas programadas."
    },

    LOC007: {
        codigo: "LOC007",
        edificio: "Edifício Principal",
        piso: "Piso 3",
        servico: "Cardiologia",
        sala: "Sala 3.08",
        observacoes: "Área dedicada a exames e monitorização cardíaca."
    },

    LOC008: {
        codigo: "LOC008",
        edificio: "Edifício Técnico",
        piso: "Piso 0",
        servico: "Central de Esterilização e Desinfeção",
        sala: "Sala EST-01",
        observacoes: "Zona destinada à esterilização de material clínico."
    },

    LOC009: {
        codigo: "LOC009",
        edificio: "Edifício Principal",
        piso: "Piso 2",
        servico: "Pediatria",
        sala: "Sala PED-04",
        observacoes: "Área dedicada ao acompanhamento e tratamento pediátrico."
    },

    LOC010: {
        codigo: "LOC010",
        edificio: "Edifício Principal",
        piso: "Piso 3",
        servico: "Neurologia",
        sala: "Sala NRL-02",
        observacoes: "Serviço especializado em doenças neurológicas."
    },

    LOC011: {
        codigo: "LOC011",
        edificio: "Edifício Técnico",
        piso: "Piso 1",
        servico: "Patologia Clínica",
        sala: "Sala LAB-05",
        observacoes: "Área destinada à realização de análises clínicas e laboratoriais."
    },

    LOC012: {
        codigo: "LOC012",
        edificio: "Edifício Principal",
        piso: "Piso 4",
        servico: "Medicina Física e Reabilitação",
        sala: "Sala REAB-01",
        observacoes: "Espaço destinado a equipamentos de fisioterapia e reabilitação."
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

    const filtroEquipamentoLocalizacao =
        document.getElementById("filtroEquipamentoLocalizacao");

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

        const equipamentoSelecionado =
            filtroEquipamentoLocalizacao ? filtroEquipamentoLocalizacao.value : "";

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

                    ||

                    Object.values(equipamentosGuardados).some(function (eq) {
                        return eq.localizacao === localizacao.codigo &&
                            (
                                (eq.codigo || "").toLowerCase().includes(textoPesquisa) ||
                                (eq.designacao || "").toLowerCase().includes(textoPesquisa) ||
                                (eq.categoria || "").toLowerCase().includes(textoPesquisa) ||
                                (eq.estado || "").toLowerCase().includes(textoPesquisa)
                            );
                    })

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

                const correspondeEquipamento =
                    equipamentoSelecionado === "" ||
                    Object.values(equipamentosGuardados).some(function (eq) {
                        return eq.codigo === equipamentoSelecionado && eq.localizacao === localizacao.codigo;
                    });

                return (
                    correspondePesquisa &&
                    correspondeEdificio &&
                    correspondeServico &&
                    correspondePiso &&
                    correspondeSala &&
                    correspondeEquipamento
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

    if (filtroEquipamentoLocalizacao) {
        filtroEquipamentoLocalizacao.addEventListener("change", aplicarFiltrosLocalizacoes);
    }

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
                if (filtroEquipamentoLocalizacao) filtroEquipamentoLocalizacao.value = "";

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

    //equipamento associado
    const filtroEquipamentoLocalizacao = document.getElementById("filtroEquipamentoLocalizacao");
    if (filtroEquipamentoLocalizacao) {
        filtroEquipamentoLocalizacao.innerHTML = '<option value="">Todos</option>';
        Object.values(equipamentosGuardados).forEach(function (equipamento) {
            const option = document.createElement("option");
            option.value = equipamento.codigo;
            option.textContent = equipamento.codigo + " — " + equipamento.designacao;
            filtroEquipamentoLocalizacao.appendChild(option);
        });
    }
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

    const containerEquipamentosLocalizacao = document.getElementById("equipamentos-da-localizacao");
    if (containerEquipamentosLocalizacao) {
        const equipamentosAssociados = Object.values(equipamentosGuardados).filter(function (eq) {
            return eq.localizacao === idLocalizacao;
        });

        if (equipamentosAssociados.length === 0) {
            containerEquipamentosLocalizacao.innerHTML = `<p style="color:#6b7280; font-style:italic;">Sem equipamentos associados.</p>`;
        } else {
            let html = `
            <table class="tabela-detalhe-itens w-100 mb-2">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Designação</th>
                        <th>Categoria</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
        `;
            equipamentosAssociados.forEach(function (eq, index) {
                const par = index % 2 === 0 ? 'linha-par' : 'linha-impar';
                html += `
                <tr class="${par}">
                    <td class="celula-ref">${eq.codigo || "-"}</td>
                    <td class="celula-nome">${eq.designacao || "-"}</td>
                    <td>${eq.categoria || "-"}</td>
                    <td>${eq.estado || "-"}</td>
                    <td>
                        <a href="../equipamentos/consultar_equipamento.html?id=${eq.codigo}" class="botao-ver-fornecedor">
                            <i class="fa-regular fa-eye"></i>
                            Ver
                        </a>
                    </td>
                </tr>
            `;
            });
            html += `</tbody></table>`;
            containerEquipamentosLocalizacao.innerHTML = html;
        }
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
        botaoCancelarEdicaoLocalizacao.href = `localizacoes.html?id=${localizacao.codigo}`;
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
        pessoaContacto: "Catarina Silva",
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
    },

    FOR005: {
        codigo: "FOR005",
        nomeEmpresa: "Siemens Healthineers",
        nif: "505678901",
        telefone: "+351 930 111 222",
        email: "contacto@siemenshealthineers.pt",
        morada: "Coimbra, Portugal",
        website: "www.siemens-healthineers.com",
        pessoaContacto: "Ricardo Moreira",
        telefonePessoaContacto: "+351 910 111 222",
        tipoFornecedor: "Fabricante",
        observacoes: "Fornecedor de equipamentos de diagnóstico e imagiologia."
    },

    FOR006: {
        codigo: "FOR006",
        nomeEmpresa: "GE HealthCare",
        nif: "506789012",
        telefone: "+351 930 222 333",
        email: "contacto@gehealthcare.pt",
        morada: "Região Autónoma da Madeira, Portugal",
        website: "www.gehealthcare.com",
        pessoaContacto: "Ana Ribeiro",
        telefonePessoaContacto: "+351 910 222 333",
        tipoFornecedor: "Fabricante",
        observacoes: "Fornecedor de equipamentos de monitorização e diagnóstico."
    },

    FOR007: {
        codigo: "FOR007",
        nomeEmpresa: "B. Braun Medical",
        nif: "507890123",
        telefone: "+351 930 333 444",
        email: "contacto@bbraun.pt",
        morada: "Faro, Portugal",
        website: "www.bbraun.pt",
        pessoaContacto: "Pedro Costa",
        telefonePessoaContacto: "+351 910 333 444",
        tipoFornecedor: "Fornecedor de consumáveis ou acessórios",
        observacoes: "Fornecedor de consumíveis hospitalares e acessórios para equipamentos médicos."
    },

    FOR008: {
        codigo: "FOR008",
        nomeEmpresa: "Medtronic Portugal",
        nif: "508901234",
        telefone: "+351 930 444 555",
        email: "contacto@medtronic.pt",
        morada: "Braga, Portugal",
        website: "www.medtronic.com",
        pessoaContacto: "Sofia Martins",
        telefonePessoaContacto: "+351 910 444 555",
        tipoFornecedor: "Distribuidor ou Fornecedor comercial",
        observacoes: "Distribuidor de equipamentos médicos e dispositivos implantáveis."
    },

    FOR009: {
        codigo: "FOR009",
        nomeEmpresa: "Roche Diagnostics",
        nif: "509012345",
        telefone: "+351 930 555 666",
        email: "contacto@roche.pt",
        morada: "Lisboa, Portugal",
        website: "www.roche.pt",
        pessoaContacto: "Tiago Oliveira",
        telefonePessoaContacto: "+351 910 555 666",
        tipoFornecedor: "Fornecedor de consumíveis ou acessórios",
        observacoes: "Fornecedor de reagentes e consumíveis laboratoriais."
    },
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
    <td>${fornecedor.tipoFornecedor}</td>
    <td>${fornecedor.pessoaContacto}</td>
    <td>${fornecedor.telefonePessoaContacto}</td>

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

    const filtroEquipamentoFornecedor =
        document.getElementById("filtroEquipamentoFornecedor");

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

        const equipamentoSelecionado =
            filtroEquipamentoFornecedor ? filtroEquipamentoFornecedor.value : "";

        const fornecedoresFiltrados =
            Object.values(fornecedoresGuardados).filter(function (fornecedor) {

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

                    Object.values(equipamentosGuardados).some(function (eq) {
                        return eq.fornecedores &&
                            eq.fornecedores.some(function (f) { return f.codigo === fornecedor.codigo; }) &&
                            (
                                (eq.codigo || "").toLowerCase().includes(textoPesquisa) ||
                                (eq.designacao || "").toLowerCase().includes(textoPesquisa) ||
                                (eq.categoria || "").toLowerCase().includes(textoPesquisa)
                            );
                    })

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

                const correspondeEquipamento =
                    equipamentoSelecionado === "" ||
                    Object.values(equipamentosGuardados).some(function (eq) {
                        return eq.codigo === equipamentoSelecionado &&
                            eq.fornecedores &&
                            eq.fornecedores.some(function (f) {
                                return f.codigo === fornecedor.codigo;
                            });
                    });

                return (
                    correspondePesquisa &&
                    correspondeTipo &&
                    correspondeNomeEmpresa &&
                    correspondeMorada &&
                    correspondePessoaContacto &&
                    correspondeEquipamento
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

    if (filtroEquipamentoFornecedor) {
        filtroEquipamentoFornecedor.addEventListener("change", aplicarFiltrosFornecedores);
    }

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
                if (filtroEquipamentoFornecedor) filtroEquipamentoFornecedor.value = "";

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

    const filtroEquipamento = document.getElementById("filtroEquipamentoFornecedor");
    if (filtroEquipamento) {
        filtroEquipamento.innerHTML = '<option value="">Todos</option>';
        Object.values(equipamentosGuardados).forEach(function (equipamento) {
            const option = document.createElement("option");
            option.value = equipamento.codigo;
            option.textContent = equipamento.codigo + " — " + equipamento.designacao;
            filtroEquipamento.appendChild(option);
        });
    }
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

    // Equipamentos associados
    const containerEquipamentos = document.getElementById("equipamentos-do-fornecedor");
    if (containerEquipamentos) {
        const equipamentosAssociados = Object.values(equipamentosGuardados).filter(function (eq) {
            return eq.fornecedores && eq.fornecedores.some(function (f) {
                return f.codigo === idFornecedor;
            });
        });

        if (equipamentosAssociados.length === 0) {
            containerEquipamentos.innerHTML = `<p style="color:#6b7280; font-style:italic;">Sem equipamentos associados.</p>`;
        } else {
            let html = `
            <table class="tabela-detalhe-itens w-100 mb-2">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Designação</th>
                        <th>Categoria</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
        `;
            equipamentosAssociados.forEach(function (eq, index) {
                const par = index % 2 === 0 ? 'linha-par' : 'linha-impar';
                html += `
                <tr class="${par}">
                    <td class="celula-ref">${eq.codigo || "-"}</td>
                    <td class="celula-nome">${eq.designacao || "-"}</td>
                    <td>${eq.categoria || "-"}</td>
                    <td>${eq.estado || "-"}</td>
                    <td>
                        <a href="../equipamentos/consultar_equipamento.html?id=${eq.codigo}" class="botao-ver-fornecedor">
                            <i class="fa-regular fa-eye"></i>
                            Ver
                        </a>
                    </td>
                </tr>
            `;
            });
            html += `</tbody></table>`;
            containerEquipamentos.innerHTML = html;
        }
    }
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
        botaoCancelarEdicaoFornecedor.href = `fornecedores.html?id=${fornecedor.codigo}`;
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

/*DASHBOARD*/
function inicializarDashboard() {
    const totalEquipamentos = document.getElementById("totalEquipamentosDashboard");

    if (!totalEquipamentos) {
        return;
    }

    const equipamentos = Object.values(equipamentosGuardados || {});
    const documentacao = [];
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

    totalEquipamentos.textContent = total;
    document.getElementById("equipamentosAtivosDashboard").textContent = ativos;
    document.getElementById("equipamentosManutencaoDashboard").textContent = manutencao;
    document.getElementById("equipamentosInativosDashboard").textContent = inativos;
    document.getElementById("garantiasExpiradasDashboard").textContent = garantiasExpiradas;

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

    let valoresGuardados = {
        tipoContrato: "",
        entidadeResponsavelContrato: "",
        periodicidadeContrato: ""
    };

    function atualizarCamposContrato() {
        if (contratoManutencao.value === "Não") {

            // Guarda os valores antes de limpar
            if (tipoContrato.value && tipoContrato.value !== "Não existe") {
                valoresGuardados.tipoContrato = tipoContrato.value;
            }
            if (entidadeResponsavelContrato.value && entidadeResponsavelContrato.value !== "Não existe") {
                valoresGuardados.entidadeResponsavelContrato = entidadeResponsavelContrato.value;
            }
            if (periodicidadeContrato.value && periodicidadeContrato.value !== "Não aplicável") {
                valoresGuardados.periodicidadeContrato = periodicidadeContrato.value;
            }

            tipoContrato.value = "Não existe";
            entidadeResponsavelContrato.value = "Não existe";
            periodicidadeContrato.value = "Não aplicável";

            tipoContrato.disabled = true;
            entidadeResponsavelContrato.disabled = true;
            periodicidadeContrato.disabled = true;

            if (opcaoNaoAplicavel) opcaoNaoAplicavel.hidden = false;

        } else if (contratoManutencao.value === "Sim") {

            // Restaura os valores guardados
            tipoContrato.value = valoresGuardados.tipoContrato || "";
            entidadeResponsavelContrato.value = valoresGuardados.entidadeResponsavelContrato || "";
            periodicidadeContrato.value = valoresGuardados.periodicidadeContrato || "";

            tipoContrato.disabled = false;
            entidadeResponsavelContrato.disabled = false;
            periodicidadeContrato.disabled = false;

            if (opcaoNaoAplicavel) opcaoNaoAplicavel.hidden = true;

        } else {
            tipoContrato.value = "";
            entidadeResponsavelContrato.value = "";
            periodicidadeContrato.value = "";

            tipoContrato.disabled = false;
            entidadeResponsavelContrato.disabled = false;
            periodicidadeContrato.disabled = false;

            if (opcaoNaoAplicavel) opcaoNaoAplicavel.hidden = true;
        }
    }

    // Preenche os valores guardados com o que já está nos campos ao inicializar
    valoresGuardados.tipoContrato = tipoContrato.value !== "Não existe" ? tipoContrato.value : "";
    valoresGuardados.entidadeResponsavelContrato = entidadeResponsavelContrato.value !== "Não existe" ? entidadeResponsavelContrato.value : "";
    valoresGuardados.periodicidadeContrato = periodicidadeContrato.value !== "Não aplicável" ? periodicidadeContrato.value : "";

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
        const primeiroFornecedor = equipamento.fornecedores && equipamento.fornecedores.length > 0
            ? fornecedores[equipamento.fornecedores[0].codigo]
            : null;
        const nomeFornecedor = primeiroFornecedor ? primeiroFornecedor.nomeEmpresa : "Não definido";

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

    const percentagem = Math.round((criticidadeElevada / total) * 100);

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

    inicializarDropdownUtilizador();

    const popoverTriggerList = document.querySelectorAll(
        '[data-bs-toggle="popover"]'
    );

    popoverTriggerList.forEach(function (popoverTriggerEl) {
        new bootstrap.Popover(popoverTriggerEl);
    });
});