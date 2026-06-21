// ===============================
// HISTÓRICO DE EQUIPAMENTOS
// ===============================
function abrirHistoricoNavbar() {
    const offcanvasEl = document.getElementById("offcanvasHistorico");
    const offcanvas = new bootstrap.Offcanvas(offcanvasEl);
    offcanvas.show();
}

// ========================================
// TOGGLES DOCUMENTAÇÃO - NOVO EQUIPAMENTO
// ========================================

function inicializarTogglesDocumentacaoEquipamento() {

    ligarToggle("tem_documentacao_tecnica", "bloco-documentacao-tecnica");
    ligarToggle("tem_documentacao_utilizacao", "bloco-documentacao-utilizacao");
    ligarToggle("tem_declaracao_conformidade", "bloco-declaracao-conformidade");
    ligarToggle("tem_contrato_aquisicao", "bloco-contrato-aquisicao");
    ligarToggle("tem_fatura", "bloco-fatura");
    ligarToggle("tem_documentacao_garantia", "bloco-documentacao-garantia");
    ligarToggle("tem_documentacao_contrato", "bloco-documentacao-contrato");
    ligarToggle("tem_relatorio_contrato", "bloco-relatorio-contrato");
    ligarToggle("tem_documentacao_calibracao", "bloco-documentacao-calibracao");
    ligarToggle("tem_relatorio_calibracao", "bloco-relatorio-calibracao");
}

// ===============================
// VALIDAÇÃO CLIENT-SIDE — TAB 1 (IDENTIFICAÇÃO)
// ===============================

function validarTabIdentificacao() {
    const erros = [];

    const codigo = document.getElementById("codigo").value.trim();
    const designacao = document.getElementById("designacao").value.trim();
    const categoria = document.getElementById("categoria").value;
    const marca = document.getElementById("marca").value.trim();
    const modelo = document.getElementById("modelo").value.trim();
    const numeroSerie = document.getElementById("numero_serie").value.trim();
    const fabricante = document.getElementById("fabricante").value.trim();
    const anoFabrico = document.getElementById("ano_fabrico").value.trim();
    const estado = document.getElementById("estado").value;
    const criticidade = document.getElementById("criticidade").value;

    if (codigo === "") {
        erros.push("O código do equipamento é obrigatório.");
    } else {
        if (/\s/.test(codigo)) erros.push("O código não pode conter espaços em branco.");
        if (codigo.length < 5) erros.push("O código deve ter no mínimo 5 caracteres.");
        if (!/^EQ\d+$/.test(codigo)) erros.push("O código deve começar com \"EQ\" seguido de números (ex.: EQ001).");
    }

    if (designacao === "") {
        erros.push("A designação do equipamento é obrigatória.");
    } else if (designacao.length < 2) {
        erros.push("A designação deve ter no mínimo 2 caracteres.");
    }

    if (categoria === "") erros.push("A categoria do equipamento é obrigatória.");

    if (marca === "") {
        erros.push("A marca é obrigatória.");
    } else if (marca.length < 2) {
        erros.push("A marca deve ter no mínimo 2 caracteres.");
    }

    if (modelo === "") {
        erros.push("O modelo é obrigatório.");
    } else if (modelo.length < 2) {
        erros.push("O modelo deve ter no mínimo 2 caracteres.");
    }

    if (numeroSerie === "") {
        erros.push("O número de série é obrigatório.");
    } else if (numeroSerie.length < 2) {
        erros.push("O número de série deve ter no mínimo 2 caracteres.");
    }

    if (fabricante === "") {
        erros.push("O fabricante é obrigatório.");
    } else if (fabricante.length < 2) {
        erros.push("O fabricante deve ter no mínimo 2 caracteres.");
    }

    const anoAtual = new Date().getFullYear();
    if (anoFabrico !== "") {
        const ano = parseInt(anoFabrico, 10);
        if (isNaN(ano) || ano < 1900 || ano > anoAtual) {
            erros.push("O ano de fabrico, se preenchido, deve estar entre 1900 e " + anoAtual + ".");
        }
    }

    if (estado === "") erros.push("O estado do equipamento é obrigatório.");
    if (criticidade === "") erros.push("A criticidade do equipamento é obrigatória.");

    // Documentação técnica / utilização / conformidade
    erros.push(...validarBlocoDocumentacao("tem_documentacao_tecnica", "nomeManualTecnico", "dataManualTecnico", "validadeManualTecnico", anoFabrico, "documentação técnica"));
    erros.push(...validarBlocoDocumentacao("tem_documentacao_utilizacao", "nomeManualUtilizacao", "dataManualUtilizacao", "validadeManualUtilizacao", anoFabrico, "documentação de utilização"));
    erros.push(...validarBlocoDocumentacao("tem_declaracao_conformidade", "nomeDeclaracaoConformidade", "dataDeclaracaoConformidade", "validadeDeclaracaoConformidade", anoFabrico, "declaração de conformidade"));

    return erros;
}

function validarBlocoDocumentacao(idSelect, idNome, idData, idValidade, anoFabrico, rotulo) {
    const erros = [];

    const temDoc = document.getElementById(idSelect).value;

    if (temDoc === "") {
        erros.push("É obrigatório indicar se existe " + rotulo + " associada.");
        return erros;
    }

    if (temDoc !== "sim") {
        return erros;
    }

    const nome = document.getElementById(idNome).value.trim();
    const data = document.getElementById(idData).value;
    const validade = document.getElementById(idValidade).value;

    if (nome === "") {
        erros.push("O nome do documento (" + rotulo + ") é obrigatório.");
    } else if (nome.length < 2) {
        erros.push("O nome do documento (" + rotulo + ") deve ter no mínimo 2 caracteres.");
    }

    if (data === "") {
        erros.push("A data do documento (" + rotulo + ") é obrigatória.");
    } else {
        const dataObj = new Date(data);
        if (anoFabrico !== "") {
            if (dataObj.getFullYear() <= parseInt(anoFabrico, 10)) {
                erros.push("A data do documento (" + rotulo + ") deve ser posterior ao ano de fabrico do equipamento.");
            }
        } else {
            const hoje = new Date();
            hoje.setHours(0, 0, 0, 0);
            if (dataObj > hoje) {
                erros.push("A data do documento (" + rotulo + ") não pode ser uma data futura.");
            }
        }

        if (validade !== "") {
            const validadeObj = new Date(validade);
            if (validadeObj <= dataObj) {
                erros.push("A validade do documento (" + rotulo + ") deve ser posterior à data do documento.");
            }
        }
    }

    return erros;
}

function inicializarValidacaoTabIdentificacao() {
    const botao = document.getElementById("botao-seguinte-identificacao");

    if (!botao) {
        return;
    }

    botao.addEventListener("click", function (event) {
        const erros = validarTabIdentificacao();

        mostrarErrosTab("erros-separador-1", erros);

        if (erros.length > 0) {
            event.stopPropagation();
            event.stopImmediatePropagation();
        }
    });
}

function mostrarErrosTab(idContainerErros, erros) {
    const container = document.getElementById(idContainerErros);
    const lista = container ? container.querySelector("ul") : null;

    if (!container || !lista) {
        return;
    }

    if (erros.length === 0) {
        container.style.display = "none";
        lista.innerHTML = "";
        return;
    }

    lista.innerHTML = "";
    erros.forEach(function (erro) {
        const li = document.createElement("li");
        li.textContent = erro;
        lista.appendChild(li);
    });

    container.style.display = "block";
    container.classList.add("alert", "alert-danger");
}

// ===============================
// VALIDAÇÃO CLIENT-SIDE — TAB 2 (ACESSÓRIOS E CONSUMÍVEIS)
// ===============================

function validarTabAcessoriosConsumiveis() {
    const erros = [];

    const linhasAcessorios = document.querySelectorAll('#tbody-acessorios tr');
    const linhasConsumiveis = document.querySelectorAll('#tbody-consumiveis tr');

    if (linhasAcessorios.length === 0) {
        erros.push("Deve existir pelo menos um acessório associado ao equipamento.");
    }

    linhasAcessorios.forEach(function (tr, index) {
        validarLinhaItemJS(tr, index, "Acessório", true, erros);
    });

    linhasConsumiveis.forEach(function (tr, index) {
        validarLinhaItemJS(tr, index, "Consumível", false, erros);
    });

    return erros;
}

function validarLinhaItemJS(tr, index, rotulo, estadoObrigatorio, erros) {
    const numeroLinha = index + 1;

    const nome = tr.querySelector('input[name$="[nome][]"]').value.trim();
    const referencia = tr.querySelector('input[name$="[referencia][]"]').value.trim();
    const quantidade = tr.querySelector('input[name$="[quantidade][]"]').value.trim();
    const unidade = tr.querySelector('select[name$="[unidade][]"]').value;
    const estadoSelect = tr.querySelector('select[name$="[estado][]"]');
    const estado = estadoSelect ? estadoSelect.value : "";
    const observacoes = tr.querySelector('input[name$="[observacoes][]"]').value.trim();

    if (nome === "") {
        erros.push(rotulo + " #" + numeroLinha + ": o nome é obrigatório.");
    } else if (nome.length < 2) {
        erros.push(rotulo + " #" + numeroLinha + ": o nome deve ter no mínimo 2 caracteres.");
    }

    if (referencia === "") {
        erros.push(rotulo + " #" + numeroLinha + ": a referência é obrigatória.");
    } else if (referencia.length < 2) {
        erros.push(rotulo + " #" + numeroLinha + ": a referência deve ter no mínimo 2 caracteres.");
    }

    let quantidadeValida = false;
    if (quantidade === "" || !/^\d+$/.test(quantidade)) {
        erros.push(rotulo + " #" + numeroLinha + ": a quantidade deve ser um número inteiro igual ou superior a zero.");
    } else {
        quantidadeValida = true;
    }

    if (unidade === "") {
        erros.push(rotulo + " #" + numeroLinha + ": a unidade é obrigatória.");
    }

    if (estadoObrigatorio && estado === "") {
        erros.push(rotulo + " #" + numeroLinha + ": o estado é obrigatório.");
    }

    if (quantidadeValida && estado !== "") {
        const qtd = parseInt(quantidade, 10);
        const estadosSemStock = ['Em falta', 'Abatido'];
        const estadosComStock = ['Novo', 'Em uso', 'Danificado'];

        // Procurar a label correspondente ao value selecionado
        const labelEstado = estadoSelect.options[estadoSelect.selectedIndex]?.text || estado;

        if (qtd === 0 && !estadosSemStock.includes(labelEstado)) {
            erros.push(rotulo + " #" + numeroLinha + ": com quantidade 0, o estado deve ser \"Em falta\" ou \"Abatido\".");
        } else if (qtd > 0 && !estadosComStock.includes(labelEstado)) {
            erros.push(rotulo + " #" + numeroLinha + ": com quantidade superior a 0, o estado deve ser \"Novo\", \"Em uso\" ou \"Danificado\".");
        }
    }

    if (observacoes !== "" && observacoes.length < 2) {
        erros.push(rotulo + " #" + numeroLinha + ": as observações, se preenchidas, devem ter no mínimo 2 caracteres.");
    }
}

function inicializarValidacaoTabAcessoriosConsumiveis() {
    const botao = document.getElementById("botao-seguinte-acessorios");

    if (!botao) {
        return;
    }

    botao.addEventListener("click", function (event) {
        const erros = validarTabAcessoriosConsumiveis();

        mostrarErrosTab("erros-separador-2", erros);

        if (erros.length > 0) {
            event.stopPropagation();
            event.stopImmediatePropagation();
        }
    });
}

const ESTADOS = (typeof ESTADOS_ACESSORIO_BD !== 'undefined' ? ESTADOS_ACESSORIO_BD : []).map(function (e) {
    return { value: e.valor, label: e.designacao };
});

const UNIDADES = typeof UNIDADES_BD !== 'undefined' ? UNIDADES_BD : [];

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

// ===============================
// VALIDAÇÃO CLIENT-SIDE — TAB 3 (AQUISIÇÃO)
// ===============================

function atualizarDocumentacaoPorTipoEntrada() {
    const selectTipoEntrada = document.getElementById("tipo_entrada");
    const seletorFatura = document.getElementById("tem_fatura");
    const blocoFatura = document.getElementById("bloco-fatura");
    const seletorContratoAquisicao = document.getElementById("tem_contrato_aquisicao");
    const blocoContratoAquisicao = document.getElementById("bloco-contrato-aquisicao");

    if (!selectTipoEntrada || !seletorFatura || !blocoFatura || !seletorContratoAquisicao || !blocoContratoAquisicao) {
        return;
    }

    function aplicar() {
        const tipo = selectTipoEntrada.value;

        // --- Fatura ---
        if (tipo === "Compra") {
            seletorFatura.value = "sim";
            blocoFatura.style.display = "block";
            seletorFatura.style.pointerEvents = "none";
            seletorFatura.style.opacity = "0.65";
        } else if (tipo === "Doação") {
            seletorFatura.value = "nao";
            blocoFatura.style.display = "none";
            seletorFatura.style.pointerEvents = "none";
            seletorFatura.style.opacity = "0.65";
        } else {
            // Aluguer, Empréstimo ou sem seleção: livre
            seletorFatura.style.pointerEvents = "";
            seletorFatura.style.opacity = "";
            blocoFatura.style.display = seletorFatura.value === "sim" ? "block" : "none";
        }

        // --- Contrato de aquisição ---
        if (tipo === "Aluguer" || tipo === "Empréstimo") {
            seletorContratoAquisicao.value = "sim";
            blocoContratoAquisicao.style.display = "block";
            seletorContratoAquisicao.style.pointerEvents = "none";
            seletorContratoAquisicao.style.opacity = "0.65";
        } else {
            // Compra, Doação ou sem seleção: livre
            seletorContratoAquisicao.style.pointerEvents = "";
            seletorContratoAquisicao.style.opacity = "";
            blocoContratoAquisicao.style.display = seletorContratoAquisicao.value === "sim" ? "block" : "none";
        }
    }

    selectTipoEntrada.addEventListener("change", aplicar);
    seletorFatura.addEventListener("change", function () {
        blocoFatura.style.display = this.value === "sim" ? "block" : "none";
    });
    seletorContratoAquisicao.addEventListener("change", function () {
        blocoContratoAquisicao.style.display = this.value === "sim" ? "block" : "none";
    });

    aplicar();
}

function validarTabAquisicao() {
    const erros = [];

    const dataAquisicao = document.getElementById("data_aquisicao").value;
    const custoAquisicao = document.getElementById("custo_aquisicao").value.trim();
    const tipoEntrada = document.getElementById("tipo_entrada").value;
    const temContratoAquisicao = document.getElementById("tem_contrato_aquisicao").value;
    const temFatura = document.getElementById("tem_fatura").value;
    const observacoesAquisicao = document.getElementById("observacoesAquisicao").value.trim();
    const anoFabrico = document.getElementById("ano_fabrico").value.trim();

    let dataAquisicaoObj = null;

    // Data de aquisição
    if (dataAquisicao === "") {
        erros.push("A data de aquisição é obrigatória.");
    } else {
        dataAquisicaoObj = new Date(dataAquisicao);
        if (anoFabrico !== "") {
            if (dataAquisicaoObj.getFullYear() <= parseInt(anoFabrico, 10)) {
                erros.push("A data de aquisição deve ser posterior ao ano de fabrico do equipamento.");
            }
        }
    }

    // Custo de aquisição
    if (custoAquisicao === "") {
        erros.push("O custo de aquisição é obrigatório.");
    } else if (isNaN(custoAquisicao) || parseFloat(custoAquisicao) < 0) {
        erros.push("O custo de aquisição deve ser um valor numérico igual ou superior a zero.");
    }

    // Tipo de entrada
    if (tipoEntrada === "") {
        erros.push("O tipo de entrada é obrigatório.");
    }

    // Tem contrato de aquisição
    if (temContratoAquisicao === "") {
        erros.push("É obrigatório indicar se existe contrato de aquisição associado.");
    }

    // Tem fatura
    if (temFatura === "") {
        erros.push("É obrigatório indicar se existe fatura associada.");
    }

    // Documentação: Contrato de Aquisição
    if (temContratoAquisicao === "sim") {
        const nomeContratoAquisicao = document.getElementById("nomeContratoAquisicao").value.trim();
        const dataContratoAquisicao = document.getElementById("dataContratoAquisicao").value;
        const validadeContratoAquisicao = document.getElementById("validadeContratoAquisicao").value;

        if (nomeContratoAquisicao === "") {
            erros.push("O nome do documento (contrato de aquisição) é obrigatório.");
        } else if (nomeContratoAquisicao.length < 2) {
            erros.push("O nome do documento (contrato de aquisição) deve ter no mínimo 2 caracteres.");
        }

        let dataContratoAquisicaoObj = null;

        if (dataContratoAquisicao === "") {
            erros.push("A data do documento (contrato de aquisição) é obrigatória.");
        } else {
            dataContratoAquisicaoObj = new Date(dataContratoAquisicao);
            if (dataAquisicaoObj && dataContratoAquisicaoObj < dataAquisicaoObj) {
                erros.push("A data do documento (contrato de aquisição) deve ser igual ou posterior à data de aquisição.");
            }
        }

        if (validadeContratoAquisicao !== "" && dataContratoAquisicaoObj) {
            const validadeContratoAquisicaoObj = new Date(validadeContratoAquisicao);
            if (validadeContratoAquisicaoObj <= dataContratoAquisicaoObj) {
                erros.push("A validade do documento (contrato de aquisição) deve ser posterior à data do documento.");
            }
        }
    }

    // Documentação: Fatura
    if (temFatura === "sim") {
        const nomeFatura = document.getElementById("nomeFatura").value.trim();
        const dataFatura = document.getElementById("dataFatura").value;

        if (nomeFatura === "") {
            erros.push("O nome do documento (fatura) é obrigatório.");
        } else if (nomeFatura.length < 2) {
            erros.push("O nome do documento (fatura) deve ter no mínimo 2 caracteres.");
        }

        if (dataFatura === "") {
            erros.push("A data do documento (fatura) é obrigatória.");
        } else {
            const dataFaturaObj = new Date(dataFatura);
            if (dataAquisicaoObj && dataFaturaObj < dataAquisicaoObj) {
                erros.push("A data do documento (fatura) deve ser igual ou posterior à data de aquisição.");
            }
        }
    }

    // Observações
    if (observacoesAquisicao !== "" && observacoesAquisicao.length < 2) {
        erros.push("As observações da aquisição, se preenchidas, devem ter no mínimo 2 caracteres.");
    }

    return erros;
}

function inicializarValidacaoTabAquisicao() {
    const botao = document.getElementById("botao-seguinte-aquisicao");

    if (!botao) {
        return;
    }

    botao.addEventListener("click", function (event) {
        const erros = validarTabAquisicao();

        mostrarErrosTab("erros-separador-3", erros);

        if (erros.length > 0) {
            event.stopPropagation();
            event.stopImmediatePropagation();
        }
    });
}

const contadorFornecedores = { count: 0 };

window.adicionarFornecedorEquipamento = function (dados) {
    dados = dados || {};

    const tbody = document.getElementById('tbody-fornecedores-equipamento');
    if (!tbody) return;
    const id = 'fornecedor-linha-' + (++contadorFornecedores.count);

    const listaFornecedores = typeof FORNECEDORES_BD !== 'undefined' ? FORNECEDORES_BD : [];
    const listaMoradas = typeof MORADAS_BD !== 'undefined' ? MORADAS_BD : [];

    const opcoesFornecedores = listaFornecedores.map(function (f) {
        const sel = String(dados.fornecedor) === String(f.id) ? ' selected' : '';
        return '<option value="' + f.id + '"' + sel + '>' + f.codigo + ' — ' + f.nome_empresa + '</option>';
    }).join('');

    const opcoesMorada = listaMoradas.map(function (m) {
        const sel = String(dados.morada) === String(m.id) ? ' selected' : '';
        return '<option value="' + m.id + '"' + sel + '>' + m.designacao + '</option>';
    }).join('');

    const tr = document.createElement('tr');
    tr.id = id;
    tr.innerHTML =
        '<td><select name="fornecedores[fornecedor][]" class="campo-formulario-privado">' +
        '<option value="" disabled' + (dados.fornecedor ? '' : ' selected') + '>Escolha</option>' + opcoesFornecedores +
        '</select></td>' +
        '<td><select name="fornecedores[morada][]" class="campo-formulario-privado">' +
        '<option value="" disabled' + (dados.morada ? '' : ' selected') + '>Escolha</option>' + opcoesMorada +
        '</select></td>' +
        '<td><input type="text" name="fornecedores[pessoa][]" placeholder="Nome" class="campo-formulario-privado" value="' + (dados.pessoa || '') + '"></td>' +
        '<td><input type="text" name="fornecedores[telefone][]" placeholder="+351 9XX XXX XXX" class="campo-formulario-privado" value="' + (dados.telefone || '') + '"></td>' +
        '<td><input type="text" name="fornecedores[observacoes][]" placeholder="Notas opcionais..." class="campo-formulario-privado" value="' + (dados.observacoes || '') + '"></td>' +
        '<td><button type="button" class="botao-remover-item" onclick="removerFornecedorEquipamento(\'' + id + '\')" title="Remover">' +
        '<i class="fa-solid fa-xmark"></i>' +
        '</button></td>';

    tbody.appendChild(tr);
    atualizarResumoFornecedores();
    tr.querySelector('select').focus();
};

// ===============================
// VALIDAÇÃO CLIENT-SIDE — TAB 4 (FORNECEDOR)
// ===============================

function repopularFornecedoresEquipamento() {
    if (typeof FORNECEDORES_POST === 'undefined' || !FORNECEDORES_POST || !FORNECEDORES_POST.fornecedor) {
        return;
    }

    FORNECEDORES_POST.fornecedor.forEach(function (fornecedorId, i) {
        adicionarFornecedorEquipamento({
            fornecedor: fornecedorId,
            morada: FORNECEDORES_POST.morada ? FORNECEDORES_POST.morada[i] : '',
            pessoa: FORNECEDORES_POST.pessoa ? FORNECEDORES_POST.pessoa[i] : '',
            telefone: FORNECEDORES_POST.telefone ? FORNECEDORES_POST.telefone[i] : '',
            observacoes: FORNECEDORES_POST.observacoes ? FORNECEDORES_POST.observacoes[i] : ''
        });
    });
}

function validarTabFornecedor() {
    const erros = [];

    const linhas = document.querySelectorAll('#tbody-fornecedores-equipamento tr');

    if (linhas.length === 0) {
        erros.push("Deve existir pelo menos um fornecedor associado ao equipamento.");
        return erros;
    }

    const idsUsados = [];

    linhas.forEach(function (tr, index) {
        const numeroLinha = index + 1;

        const fornecedor = tr.querySelector('select[name="fornecedores[fornecedor][]"]').value;
        const morada = tr.querySelector('select[name="fornecedores[morada][]"]').value;
        const pessoa = tr.querySelector('input[name="fornecedores[pessoa][]"]').value.trim();
        const telefone = tr.querySelector('input[name="fornecedores[telefone][]"]').value.trim();
        const observacoes = tr.querySelector('input[name="fornecedores[observacoes][]"]').value.trim();

        // Fornecedor
        if (fornecedor === "") {
            erros.push("Fornecedor #" + numeroLinha + ": o fornecedor é obrigatório.");
        } else {
            if (idsUsados.includes(fornecedor)) {
                erros.push("Fornecedor #" + numeroLinha + ": este fornecedor já foi associado noutra linha.");
            } else {
                idsUsados.push(fornecedor);
            }
        }

        // Morada
        if (morada === "") {
            erros.push("Fornecedor #" + numeroLinha + ": a morada é obrigatória.");
        }

        // Pessoa de contacto
        if (pessoa === "") {
            erros.push("Fornecedor #" + numeroLinha + ": a pessoa de contacto é obrigatória.");
        } else {
            if (pessoa.length < 2) {
                erros.push("Fornecedor #" + numeroLinha + ": o nome da pessoa de contacto deve ter no mínimo 2 caracteres.");
            }
            if (!/^[A-Za-zÀ-ÿ\s'-]+$/.test(pessoa)) {
                erros.push("Fornecedor #" + numeroLinha + ": o nome da pessoa de contacto deve conter apenas letras, espaços, hífens e apóstrofos.");
            }
        }

        // Telefone da pessoa de contacto
        const telefoneSemEspacos = telefone.replace(/\s+/g, "");
        if (telefoneSemEspacos === "") {
            erros.push("Fornecedor #" + numeroLinha + ": o telefone da pessoa de contacto é obrigatório.");
        } else if (!/^\+351(91|92|93|96)\d{7}$/.test(telefoneSemEspacos)) {
            erros.push("Fornecedor #" + numeroLinha + ": o telefone da pessoa de contacto deve começar com \"+351\" seguido de 9 dígitos, sendo os dois primeiros 91, 92, 93 ou 96.");
        }

        // Observações (opcional)
        if (observacoes !== "" && observacoes.length < 2) {
            erros.push("Fornecedor #" + numeroLinha + ": as observações, se preenchidas, devem ter no mínimo 2 caracteres.");
        }
    });

    return erros;
}

function inicializarValidacaoTabFornecedor() {
    const botao = document.getElementById("botao-seguinte-fornecedor");

    if (!botao) {
        return;
    }

    botao.addEventListener("click", function (event) {
        const erros = validarTabFornecedor();

        mostrarErrosTab("erros-separador-4", erros);

        if (erros.length > 0) {
            event.stopPropagation();
            event.stopImmediatePropagation();
        }
    });
}

// ===============================
// VALIDAÇÃO CLIENT-SIDE — TAB 5 (LOCALIZAÇÃO)
// ===============================

function validarTabLocalizacao() {
    const erros = [];

    const localizacao = document.getElementById("localizacao").value;
    const observacoesLocalizacao = document.getElementById("observacoesLocalizacao").value.trim();

    // --- Localização ---
    if (localizacao === "") {
        erros.push("A localização associada é obrigatória.");
    }

    // --- Observações da localização (opcional) ---
    if (observacoesLocalizacao !== "" && observacoesLocalizacao.length < 2) {
        erros.push("As observações da localização, se preenchidas, devem ter no mínimo 2 caracteres.");
    }

    return erros;
}

function inicializarValidacaoTabLocalizacao() {
    const botao = document.getElementById("botao-seguinte-localizacao");

    if (!botao) {
        return;
    }

    botao.addEventListener("click", function (event) {
        const erros = validarTabLocalizacao();

        mostrarErrosTab("erros-separador-5", erros);

        if (erros.length > 0) {
            event.stopPropagation();
            event.stopImmediatePropagation();
        }
    });
}

// ===============================
// VALIDAÇÃO CLIENT-SIDE — TAB 6 (GARANTIA)
// ===============================

function validarBlocoDocumentacaoComData(idSelect, idNome, idData, idValidade, dataReferencia, rotulo) {
    const erros = [];

    const temDoc = document.getElementById(idSelect).value;

    if (temDoc === "") {
        erros.push("É obrigatório indicar se existe " + rotulo + " associada.");
        return erros;
    }

    if (temDoc !== "sim") {
        return erros;
    }

    const nome = document.getElementById(idNome).value.trim();
    const data = document.getElementById(idData).value;
    const validade = document.getElementById(idValidade).value;

    if (nome === "") {
        erros.push("O nome do documento (" + rotulo + ") é obrigatório.");
    } else if (nome.length < 2) {
        erros.push("O nome do documento (" + rotulo + ") deve ter no mínimo 2 caracteres.");
    }

    let dataObj = null;

    if (data === "") {
        erros.push("A data do documento (" + rotulo + ") é obrigatória.");
    } else {
        dataObj = new Date(data);

        if (dataReferencia) {
            const dataReferenciaObj = new Date(dataReferencia);
            if (dataObj <= dataReferenciaObj) {
                erros.push("A data do documento (" + rotulo + ") deve ser posterior à data de aquisição do equipamento.");
            }
        }

        if (validade !== "") {
            const validadeObj = new Date(validade);
            if (validadeObj <= dataObj) {
                erros.push("A validade do documento (" + rotulo + ") deve ser posterior à data do documento.");
            }
        }
    }

    return erros;
}

function validarTabGarantia() {
    const erros = [];

    const dataInicioGarantia = document.getElementById("dataInicioGarantia").value;
    const dataFimGarantia = document.getElementById("dataFimGarantia").value;
    const observacoesGarantia = document.getElementById("observacoesGarantia").value.trim();
    const dataAquisicao = document.getElementById("data_aquisicao").value;

    let dataInicioGarantiaObj = null;

    // --- Data de início da garantia ---
    if (dataInicioGarantia === "") {
        erros.push("A data de início da garantia é obrigatória.");
    } else {
        dataInicioGarantiaObj = new Date(dataInicioGarantia);

        if (dataAquisicao !== "") {
            const dataAquisicaoObj = new Date(dataAquisicao);
            if (dataInicioGarantiaObj < dataAquisicaoObj) {
                erros.push("A data de início da garantia deve ser igual ou posterior à data de aquisição do equipamento.");
            }
        }
    }

    // --- Data de fim da garantia ---
    if (dataFimGarantia === "") {
        erros.push("A data de fim da garantia é obrigatória.");
    } else {
        const dataFimGarantiaObj = new Date(dataFimGarantia);

        if (dataInicioGarantiaObj && dataFimGarantiaObj <= dataInicioGarantiaObj) {
            erros.push("A data de fim da garantia deve ser posterior à data de início da garantia.");
        }
    }

    // --- Documentação: Certificado de Garantia ---
    erros.push(...validarBlocoDocumentacaoComData("tem_documentacao_garantia", "nomeCertificadoGarantia", "dataCertificadoGarantia", "validadeCertificadoGarantia", dataAquisicao, "certificado de garantia"));

    // --- Observações (opcional) ---
    if (observacoesGarantia !== "" && observacoesGarantia.length < 2) {
        erros.push("As observações da garantia, se preenchidas, devem ter no mínimo 2 caracteres.");
    }

    return erros;
}

function inicializarValidacaoTabGarantia() {
    const botao = document.getElementById("botao-seguinte-garantia");

    if (!botao) {
        return;
    }

    botao.addEventListener("click", function (event) {
        const erros = validarTabGarantia();

        mostrarErrosTab("erros-separador-6", erros);

        if (erros.length > 0) {
            event.stopPropagation();
            event.stopImmediatePropagation();
        }
    });
}

function controlarCamposContratoManutencao() {
    const contratoManutencao = document.getElementById("contratoManutencao");
    const tipoContrato = document.getElementById("tipoContrato");
    const entidadeResponsavelContrato = document.getElementById("entidadeResponsavelContrato");
    const periodicidadeContrato = document.getElementById("periodicidadeContrato");

    if (!contratoManutencao || !tipoContrato || !entidadeResponsavelContrato || !periodicidadeContrato) {
        return;
    }

    // Guarda os valores "reais" do contrato para poder repô-los
    // sempre que o utilizador voltar a escolher "Sim"
    let valorGuardadoTipoContrato = tipoContrato.value;
    let valorGuardadoEntidade = entidadeResponsavelContrato.value === "Não existe" ? "" : entidadeResponsavelContrato.value;
    let valorGuardadoPeriodicidade = periodicidadeContrato.value;

    function atualizarCamposContrato() {
        if (contratoManutencao.value === "nao") {

            // Antes de limpar visualmente, guarda os valores atuais
            // (caso o utilizador já os tenha alterado)
            if (!tipoContrato.disabled) {
                valorGuardadoTipoContrato = tipoContrato.value;
                valorGuardadoEntidade = entidadeResponsavelContrato.value === "Não existe" ? "" : entidadeResponsavelContrato.value;
                valorGuardadoPeriodicidade = periodicidadeContrato.value;
            }

            tipoContrato.innerHTML = '<option value="" selected>Não existe</option>';
            tipoContrato.disabled = true;

            entidadeResponsavelContrato.value = "Não existe";
            entidadeResponsavelContrato.disabled = true;

            periodicidadeContrato.innerHTML = '<option value="" selected>Não aplicável</option>';
            periodicidadeContrato.disabled = true;

        } else {

            // Repor opções normais e valores guardados ao deixar de ser "nao"
            if (tipoContrato.disabled) {
                tipoContrato.innerHTML = '<option value="" disabled' + (valorGuardadoTipoContrato ? '' : ' selected') + '>Escolha uma opção</option>' +
                    TIPOS_CONTRATO_BD.map(function (t) {
                        var sel = String(valorGuardadoTipoContrato) === String(t.id) ? ' selected' : '';
                        return '<option value="' + t.id + '"' + sel + '>' + t.designacao + '</option>';
                    }).join('');
            }

            if (periodicidadeContrato.disabled) {
                periodicidadeContrato.innerHTML = '<option value="" disabled' + (valorGuardadoPeriodicidade ? '' : ' selected') + '>Escolha uma opção</option>' +
                    PERIODICIDADES_BD.map(function (p) {
                        var sel = String(valorGuardadoPeriodicidade) === String(p.id) ? ' selected' : '';
                        return '<option value="' + p.id + '"' + sel + '>' + p.designacao + '</option>';
                    }).join('');
            }

            if (entidadeResponsavelContrato.disabled || entidadeResponsavelContrato.value === "Não existe") {
                entidadeResponsavelContrato.value = valorGuardadoEntidade;
            }

            tipoContrato.disabled = false;
            entidadeResponsavelContrato.disabled = false;
            periodicidadeContrato.disabled = false;
        }
    }

    atualizarCamposContrato();
    contratoManutencao.addEventListener("change", atualizarCamposContrato);
}

// ===============================
// VALIDAÇÃO CLIENT-SIDE — TAB 7 (CONTRATO DE MANUTENÇÃO)
// ===============================

function validarTabContrato() {
    const erros = [];

    const contratoManutencao = document.getElementById("contratoManutencao").value;
    const tipoContrato = document.getElementById("tipoContrato").value;
    const entidadeResponsavelContrato = document.getElementById("entidadeResponsavelContrato").value.trim();
    const periodicidadeContrato = document.getElementById("periodicidadeContrato").value;
    const observacoesContrato = document.getElementById("observacoesContrato").value.trim();
    const dataAquisicao = document.getElementById("data_aquisicao").value;

    if (contratoManutencao === "") {
        erros.push("É obrigatório indicar se existe contrato de manutenção.");
    } else if (contratoManutencao === "sim") {

        if (tipoContrato === "") {
            erros.push("O tipo de contrato é obrigatório.");
        }

        if (entidadeResponsavelContrato === "") {
            erros.push("A entidade responsável pelo contrato é obrigatória.");
        } else {
            if (entidadeResponsavelContrato.length < 2) {
                erros.push("O nome da entidade responsável deve ter no mínimo 2 caracteres.");
            }
            if (!/^[A-Za-zÀ-ÿ0-9\s.\-]+$/.test(entidadeResponsavelContrato)) {
                erros.push("O nome da entidade responsável deve conter apenas letras, números, espaços, pontos e hífens.");
            }
        }

        if (periodicidadeContrato === "") {
            erros.push("A periodicidade do contrato é obrigatória.");
        }
    }

    erros.push(...validarBlocoDocumentacaoComData("tem_documentacao_contrato", "nomeCertificadoContrato", "dataContratoManutencao", "validadeContratoManutencao", dataAquisicao, "contrato de manutenção"));
    erros.push(...validarBlocoDocumentacaoComData("tem_relatorio_contrato", "nomeRelatorioManutencao", "dataRelatorioManutencao", "validadeRelatorioManutencao", dataAquisicao, "relatório de manutenção"));
    erros.push(...validarBlocoDocumentacaoComData("tem_documentacao_calibracao", "nomeCertificadoCalibracao", "dataCertificadoCalibracao", "validadeCertificadoCalibracao", dataAquisicao, "certificado de calibração"));
    erros.push(...validarBlocoDocumentacaoComData("tem_relatorio_calibracao", "nomeRelatorioCalibracao", "dataRelatorioCalibracao", "validadeRelatorioCalibracao", dataAquisicao, "relatório de calibração"));

    if (observacoesContrato !== "" && observacoesContrato.length < 2) {
        erros.push("As observações do contrato, se preenchidas, devem ter no mínimo 2 caracteres.");
    }

    return erros;
}

function inicializarValidacaoTabContrato() {
    const form = document.getElementById("form-novo-equipamento");

    if (!form) {
        return;
    }

    form.addEventListener("submit", function (event) {
        const erros = validarTabContrato();

        mostrarErrosTab("erros-separador-7", erros);

        if (erros.length > 0) {
            event.preventDefault();
        }
    });
}

function sincronizarDocumentacaoContrato() {
    const selectContratoManutencao = document.getElementById('contratoManutencao');
    const selectTemDocContrato = document.getElementById('tem_documentacao_contrato');
    const blocoDocContrato = document.getElementById('bloco-documentacao-contrato');

    if (!selectContratoManutencao || !selectTemDocContrato) {
        return;
    }

    // Input hidden para garantir envio do valor no POST mesmo com o select disabled
    let hidden = document.getElementById('tem_documentacao_contrato_hidden');
    if (!hidden) {
        hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.id = 'tem_documentacao_contrato_hidden';
        hidden.name = 'tem_documentacao_contrato';
        hidden.disabled = true;
        selectTemDocContrato.insertAdjacentElement('afterend', hidden);
    }

    function aplicar(valor) {
        if (valor === "sim" || valor === "nao") {
            selectTemDocContrato.value = valor;
            selectTemDocContrato.disabled = true;
            selectTemDocContrato.removeAttribute('name');

            hidden.value = valor;
            hidden.disabled = false;
        } else {
            // sem seleção
            selectTemDocContrato.value = "";
            selectTemDocContrato.disabled = true; // continua bloqueado, nunca editável
            selectTemDocContrato.removeAttribute('name');
            hidden.disabled = true;
        }

        if (blocoDocContrato) {
            blocoDocContrato.style.display = selectTemDocContrato.value === "sim" ? "" : "none";
        }
    }

    // No carregamento da página, mantém o valor já preenchido pelo PHP
    // (a partir da base de dados, em editar, ou de um POST anterior),
    // em vez de o forçar a ser sempre igual a "contratoManutencao".
    aplicar(selectTemDocContrato.value);

    // A partir de agora, alterar "Contrato de manutenção" sincroniza
    // automaticamente "Existe contrato de manutenção associado?"
    selectContratoManutencao.addEventListener('change', function () {
        aplicar(selectContratoManutencao.value);
    });
}



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

function gerarEtiqueta() {
    document.getElementById("modalEtiqueta").style.display = "flex";

    const codigo = document.getElementById("cabecalho-codigo-equipamento").textContent;
    const nome = document.getElementById("cabecalho-nome-equipamento").textContent;

    document.getElementById("codigoEtiqueta").textContent = codigo;
    document.getElementById("nomeEtiqueta").textContent = nome;
    document.getElementById("textoLocalizacaoEtiqueta").textContent = LOCALIZACAO_ETIQUETA;

    const qr = document.getElementById("qrcode-etiqueta");
    qr.innerHTML = "";

    new QRCode(qr, {
        text: URL_EQUIPAMENTO,
        width: 180,
        height: 180,
        colorDark: "#003f78",
        colorLight: "#ffffff",
    });
}

function fecharEtiqueta() {
    document.getElementById("modalEtiqueta").style.display = "none";
    document.getElementById("qrcode-etiqueta").innerHTML = "";
}

function imprimirEtiqueta() {
    const qrCanvas = document.querySelector("#qrcode-etiqueta canvas");
    const qrSrc = qrCanvas ? qrCanvas.toDataURL() : "";
    const codigo = document.getElementById("codigoEtiqueta").textContent;
    const nome = document.getElementById("nomeEtiqueta").textContent;
    const localizacao = document.getElementById("textoLocalizacaoEtiqueta").textContent;

    const janela = window.open("", "_blank", "width=400,height=500");
    janela.document.write(`
        <!DOCTYPE html>
        <html lang="pt">
        <head>
            <meta charset="UTF-8">
            <title>Etiqueta ${codigo}</title>
            <link rel="stylesheet" href="/medivault/assets/css/1241466.css">
            <style>
                @page { margin: 0.5cm; size: A6; }
            </style>
        </head>
        <body class="etiqueta-impressao-container">
            <div class="etiqueta-impressao">
                <h3>MediVault</h3>
                ${qrSrc ? `<img src="${qrSrc}" alt="QR Code">` : ""}
                <div class="codigo">${codigo}</div>
                <div class="nome">${nome}</div>
                <div class="localizacao">📍 ${localizacao}</div>
            </div>
            <script>
                window.onload = function() { window.print(); };
            <\/script>
        </body>
        </html>
    `);
    janela.document.close();
}

// ===============================
// FORNECEDORES
// ===============================

function ligarToggle(idSeletor, idBloco) {
    const seletor = document.getElementById(idSeletor);
    const bloco = document.getElementById(idBloco);

    if (!seletor || !bloco) {
        return;
    }

    // No carregamento da página, respeita a opção já selecionada
    // (vinda da base de dados, em editar, ou de um POST anterior)
    bloco.style.display = seletor.value === "sim" ? "" : "none";

    seletor.addEventListener("change", function () {
        bloco.style.display = this.value === "sim" ? "" : "none";
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
// INICIALIZAÇÃO GERAL
// ===============================

document.addEventListener("DOMContentLoaded", function () {
    inicializarTabsEquipamento();
    inicializarValidacaoTabIdentificacao();
    inicializarValidacaoTabAcessoriosConsumiveis();
    inicializarValidacaoTabAquisicao();
    inicializarValidacaoTabFornecedor();
    repopularFornecedoresEquipamento();
    inicializarValidacaoTabLocalizacao();
    inicializarValidacaoTabGarantia();
    inicializarValidacaoTabContrato();
    inicializarBotaoSeguinteEquipamento();
    inicializarBotaoAnteriorEquipamento();
    inicializarTogglesDocumentacaoEquipamento();
    atualizarDocumentacaoPorTipoEntrada();
    controlarCamposContratoManutencao();
    sincronizarDocumentacaoContrato();
    inicializarDropdownUtilizador();
});