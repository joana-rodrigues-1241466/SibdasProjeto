<?php

// ============================================================
// Validações dos campos do formulário de Localizações
// ============================================================

function validar_codigo(string $codigo): array {
    $erros = [];
    if (empty($codigo)) {
        $erros[] = "O campo Código é obrigatório.";
    } elseif (!preg_match('/^LOC\d+$/', $codigo)) {
        $erros[] = "O código deve começar com \"LOC\" seguido apenas de números (ex: LOC001).";
    } elseif (strlen($codigo) < 6) {
        $erros[] = "O código deve ter no mínimo 6 caracteres.";
    }
    return $erros;
}

function validar_edificio(string $edificio): array {
    $erros = [];
    if (empty($edificio)) {
        $erros[] = "O campo Edifício é obrigatório.";
    } elseif (strlen($edificio) < 2) {
        $erros[] = "O campo Edifício deve ter no mínimo 2 caracteres.";
    }
    return $erros;
}

function validar_piso(string $piso): array {
    $erros = [];
    if (empty($piso)) {
        $erros[] = "O campo Piso é obrigatório.";
    } elseif (strlen($piso) < 2) {
        $erros[] = "O campo Piso deve ter no mínimo 2 caracteres.";
    } elseif (!preg_match('/^[A-Za-zÀ-ÿ0-9 ]+$/', $piso)) {
        $erros[] = "O campo Piso só pode conter letras, números e espaços.";
    }
    return $erros;
}

function validar_servico(string $servico): array {
    $erros = [];
    if (empty($servico)) {
        $erros[] = "O campo Serviço/Departamento é obrigatório.";
    } elseif (strlen($servico) < 2) {
        $erros[] = "O campo Serviço/Departamento deve ter no mínimo 2 caracteres.";
    }
    return $erros;
}

function validar_sala(string $sala): array {
    $erros = [];
    if (empty($sala)) {
        $erros[] = "O campo Sala/Gabinete é obrigatório.";
    } elseif (strlen($sala) < 2) {
        $erros[] = "O campo Sala/Gabinete deve ter no mínimo 2 caracteres.";
    }
    return $erros;
}

function validar_observacoes(string $observacoes): array {
    $erros = [];
    if (!empty($observacoes) && strlen($observacoes) < 2) {
        $erros[] = "O campo Observações, se preenchido, deve ter no mínimo 2 caracteres.";
    }
    return $erros;
}

// ============================================================
// Validações dos campos do formulário de Fornecedores
// ============================================================

function validar_codigo_fornecedor(string $codigo): array {
    $erros = [];
    if ($codigo === "") {
        $erros[] = "O código do fornecedor é obrigatório.";
    } else {
        if (preg_match('/\s/', $codigo)) {
            $erros[] = "O código não pode conter espaços em branco.";
        }
        if (strlen($codigo) < 6) {
            $erros[] = "O código deve ter no mínimo 6 caracteres.";
        }
        if (!preg_match('/^FOR\d+$/', $codigo)) {
            $erros[] = "O código deve começar com o prefixo \"FOR\" seguido de números (ex.: FOR001).";
        }
    }
    return $erros;
}

function validar_nome_empresa(string $nome_empresa): array {
    $erros = [];
    if ($nome_empresa === "") {
        $erros[] = "O nome da empresa é obrigatório.";
    } elseif (strlen($nome_empresa) < 2) {
        $erros[] = "O nome da empresa deve ter no mínimo 2 caracteres.";
    }
    return $erros;
}

function validar_nif(string $nif): array {
    $erros = [];
    if ($nif === "") {
        $erros[] = "O NIF é obrigatório.";
    } else {
        if (preg_match('/\s/', $nif)) {
            $erros[] = "O NIF não pode conter espaços em branco.";
        }
        if (!preg_match('/^\d{9}$/', $nif)) {
            $erros[] = "O NIF deve ser constituído por exatamente 9 dígitos numéricos.";
        }
    }
    return $erros;
}

function validar_tipo_fornecedor(string $tipo_fornecedor): array {
    $erros = [];
    if ($tipo_fornecedor === "") {
        $erros[] = "O tipo de fornecedor é obrigatório.";
    }
    return $erros;
}

function validar_website(string $website): array {
    $erros = [];
    if ($website !== "") {
        if (!preg_match('/^www\.[a-zA-Z0-9\-]+\.pt$/', $website)) {
            $erros[] = "O website deve começar com \"www.\" e terminar com a extensão \".pt\" (ex.: www.empresa.pt).";
        }
    }
    return $erros;
}

function validar_telefone(string $telefone): array {
    $erros = [];
    if ($telefone === "") {
        $erros[] = "O telefone geral é obrigatório.";
    } else {
        $telefoneSemEspacos = preg_replace('/\s+/', '', $telefone);
        if (!preg_match('/^\+351(91|92|93|96)\d{7}$/', $telefoneSemEspacos)) {
            $erros[] = "O telefone geral deve começar com \"+351\" seguido de 9 dígitos, sendo os dois primeiros 91, 92, 93 ou 96.";
        }
    }
    return $erros;
}

function validar_email_fornecedor(string $email): array {
    $erros = [];
    if ($email === "") {
        $erros[] = "O email geral é obrigatório.";
    } else {
        if (preg_match('/\s/', $email)) {
            $erros[] = "O email não pode conter espaços em branco.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erros[] = "O email deve ter um formato válido (ex.: contacto@empresa.pt).";
        }
    }
    return $erros;
}

function validar_pessoa_contacto(string $pessoa_contacto): array {
    $erros = [];
    if ($pessoa_contacto === "") {
        $erros[] = "A pessoa de contacto é obrigatória.";
    } else {
        if (strlen($pessoa_contacto) < 2) {
            $erros[] = "O nome da pessoa de contacto deve ter no mínimo 2 caracteres.";
        }
        if (!preg_match('/^[A-Za-zÀ-ÿ\s\'-]+$/', $pessoa_contacto)) {
            $erros[] = "O nome da pessoa de contacto deve conter apenas letras, espaços, hífens e apóstrofos.";
        }
    }
    return $erros;
}

function validar_telefone_pessoa_contacto(string $telefone_pessoa_contacto): array {
    $erros = [];
    if ($telefone_pessoa_contacto === "") {
        $erros[] = "O telefone da pessoa de contacto é obrigatório.";
    } else {
        $telefonePessoaSemEspacos = preg_replace('/\s+/', '', $telefone_pessoa_contacto);
        if (!preg_match('/^\+351(91|92|93|96)\d{7}$/', $telefonePessoaSemEspacos)) {
            $erros[] = "O telefone da pessoa de contacto deve começar com \"+351\" seguido de 9 dígitos, sendo os dois primeiros 91, 92, 93 ou 96.";
        }
    }
    return $erros;
}

function validar_morada(string $morada): array {
    $erros = [];
    if ($morada === "") {
        $erros[] = "A morada é obrigatória.";
    }
    return $erros;
}

function validar_observacoes_fornecedor(string $observacoes): array {
    $erros = [];
    if ($observacoes !== "" && strlen($observacoes) < 2) {
        $erros[] = "As observações, se preenchidas, devem ter no mínimo 2 caracteres.";
    }
    return $erros;
}

function validar_documentacao_fornecedor(string $tem_doc_fornecedor, string $tipoDocFornecedor, string $nomeDocFornecedor, string $dataDocFornecedor, string $validadeDocFornecedor): array {
    $erros = [];

    if ($tem_doc_fornecedor === "") {
        $erros[] = "É obrigatório indicar se existe documentação associada ao fornecedor.";
    } elseif ($tem_doc_fornecedor === "sim") {

        if ($tipoDocFornecedor === "") {
            $erros[] = "O tipo de documento é obrigatório.";
        }

        if ($nomeDocFornecedor === "") {
            $erros[] = "O nome do documento é obrigatório.";
        } elseif (strlen($nomeDocFornecedor) < 2) {
            $erros[] = "O nome do documento deve ter no mínimo 2 caracteres.";
        }

        if ($dataDocFornecedor === "") {
            $erros[] = "A data do documento é obrigatória.";
        } else {
            $dataDocObj = DateTime::createFromFormat('Y-m-d', $dataDocFornecedor);
            $hoje = new DateTime('today');
            if ($dataDocObj && $dataDocObj > $hoje) {
                $erros[] = "A data do documento não pode ser uma data futura.";
            }
        }

        if ($validadeDocFornecedor !== "" && $dataDocFornecedor !== "") {
            $validadeObj = DateTime::createFromFormat('Y-m-d', $validadeDocFornecedor);
            $dataDocObj = DateTime::createFromFormat('Y-m-d', $dataDocFornecedor);
            if ($validadeObj && $dataDocObj && $validadeObj <= $dataDocObj) {
                $erros[] = "A validade do documento deve ser posterior à data do documento.";
            }
        }
    }

    return $erros;
}

// ============================================================
// Validações dos campos do formulário de Equipamentos — Tab 1 (Identificação)
// ============================================================

function validar_codigo_equipamento(string $codigo): array {
    $erros = [];
    if ($codigo === "") {
        $erros[] = "O código do equipamento é obrigatório.";
    } else {
        if (preg_match('/\s/', $codigo)) {
            $erros[] = "O código não pode conter espaços em branco.";
        }
        if (strlen($codigo) < 5) {
            $erros[] = "O código deve ter no mínimo 5 caracteres.";
        }
        if (!preg_match('/^EQ\d+$/', $codigo)) {
            $erros[] = "O código deve começar com o prefixo \"EQ\" seguido de números (ex.: EQ001).";
        }
    }
    return $erros;
}

function validar_designacao_equipamento(string $designacao): array {
    $erros = [];
    if ($designacao === "") {
        $erros[] = "A designação do equipamento é obrigatória.";
    } elseif (strlen($designacao) < 2) {
        $erros[] = "A designação deve ter no mínimo 2 caracteres.";
    }
    return $erros;
}

function validar_categoria_equipamento(string $categoria): array {
    $erros = [];
    if ($categoria === "") {
        $erros[] = "A categoria do equipamento é obrigatória.";
    }
    return $erros;
}

function validar_marca_equipamento(string $marca): array {
    $erros = [];
    if ($marca === "") {
        $erros[] = "A marca é obrigatória.";
    } elseif (strlen($marca) < 2) {
        $erros[] = "A marca deve ter no mínimo 2 caracteres.";
    }
    return $erros;
}

function validar_modelo_equipamento(string $modelo): array {
    $erros = [];
    if ($modelo === "") {
        $erros[] = "O modelo é obrigatório.";
    } elseif (strlen($modelo) < 2) {
        $erros[] = "O modelo deve ter no mínimo 2 caracteres.";
    }
    return $erros;
}

function validar_numero_serie_equipamento(string $numero_serie): array {
    $erros = [];
    if ($numero_serie === "") {
        $erros[] = "O número de série é obrigatório.";
    } elseif (strlen($numero_serie) < 2) {
        $erros[] = "O número de série deve ter no mínimo 2 caracteres.";
    }
    return $erros;
}

function validar_fabricante_equipamento(string $fabricante): array {
    $erros = [];
    if ($fabricante === "") {
        $erros[] = "O fabricante é obrigatório.";
    } elseif (strlen($fabricante) < 2) {
        $erros[] = "O fabricante deve ter no mínimo 2 caracteres.";
    }
    return $erros;
}

function validar_ano_fabrico_equipamento(string $ano_fabrico): array {
    $erros = [];
    $anoAtual = (int) date('Y');
    if ($ano_fabrico !== "") {
        if (!preg_match('/^\d{4}$/', $ano_fabrico) || (int)$ano_fabrico < 1900 || (int)$ano_fabrico > $anoAtual) {
            $erros[] = "O ano de fabrico, se preenchido, deve estar entre 1900 e $anoAtual.";
        }
    }
    return $erros;
}

function validar_estado_equipamento(string $estado): array {
    $erros = [];
    if ($estado === "") {
        $erros[] = "O estado do equipamento é obrigatório.";
    }
    return $erros;
}

function validar_criticidade_equipamento(string $criticidade): array {
    $erros = [];
    if ($criticidade === "") {
        $erros[] = "A criticidade do equipamento é obrigatória.";
    }
    return $erros;
}

function validar_observacoes_equipamento(string $observacoes): array {
    $erros = [];
    if ($observacoes !== "" && strlen($observacoes) < 2) {
        $erros[] = "As observações, se preenchidas, devem ter no mínimo 2 caracteres.";
    }
    return $erros;
}

function validar_documentacao_identificacao_equipamento(string $temDoc, string $nomeDoc, string $dataDoc, string $validadeDoc, string $anoFabrico, string $rotulo): array {
    $erros = [];

    if ($temDoc === "") {
        $erros[] = "É obrigatório indicar se existe $rotulo associada.";
        return $erros;
    }

    if ($temDoc !== "sim") {
        return $erros;
    }

    if ($nomeDoc === "") {
        $erros[] = "O nome do documento ($rotulo) é obrigatório.";
    } elseif (strlen($nomeDoc) < 2) {
        $erros[] = "O nome do documento ($rotulo) deve ter no mínimo 2 caracteres.";
    }

    $dataDocObj = null;

    if ($dataDoc === "") {
        $erros[] = "A data do documento ($rotulo) é obrigatória.";
    } else {
        $dataDocObj = DateTime::createFromFormat('Y-m-d', $dataDoc);

        if ($dataDocObj) {
            if ($anoFabrico !== "") {
                if ((int)$dataDocObj->format('Y') <= (int)$anoFabrico) {
                    $erros[] = "A data do documento ($rotulo) deve ser posterior ao ano de fabrico do equipamento.";
                }
            } else {
                $hoje = new DateTime('today');
                if ($dataDocObj > $hoje) {
                    $erros[] = "A data do documento ($rotulo) não pode ser uma data futura.";
                }
            }
        }
    }

    if ($validadeDoc !== "" && $dataDocObj) {
        $validadeObj = DateTime::createFromFormat('Y-m-d', $validadeDoc);
        if ($validadeObj && $validadeObj <= $dataDocObj) {
            $erros[] = "A validade do documento ($rotulo) deve ser posterior à data do documento.";
        }
    }

    return $erros;
}

// ============================================================
// Validações dos campos do formulário de Equipamentos — Tab 2 (Acessórios e Consumíveis)
// ============================================================

function validar_linha_item_equipamento(string $nome, string $referencia, string $quantidade, string $unidade, string $estado, string $observacoes, bool $estadoObrigatorio, string $rotulo, int $indice): array {
    $erros = [];

    $nome = trim($nome);
    $referencia = trim($referencia);
    $quantidade = trim($quantidade);
    $unidade = trim($unidade);
    $estado = trim($estado);
    $observacoes = trim($observacoes);

    $numeroLinha = $indice + 1;

    // Nome
    if ($nome === "") {
        $erros[] = "$rotulo #$numeroLinha: o nome é obrigatório.";
    } elseif (strlen($nome) < 2) {
        $erros[] = "$rotulo #$numeroLinha: o nome deve ter no mínimo 2 caracteres.";
    }

    // Referência
    if ($referencia === "") {
        $erros[] = "$rotulo #$numeroLinha: a referência é obrigatória.";
    } elseif (strlen($referencia) < 2) {
        $erros[] = "$rotulo #$numeroLinha: a referência deve ter no mínimo 2 caracteres.";
    }

    // Quantidade
    $quantidadeValida = false;
    if ($quantidade === "" || !preg_match('/^\d+$/', $quantidade)) {
        $erros[] = "$rotulo #$numeroLinha: a quantidade deve ser um número inteiro igual ou superior a zero.";
    } else {
        $quantidadeValida = true;
    }

    // Unidade
    if ($unidade === "") {
        $erros[] = "$rotulo #$numeroLinha: a unidade é obrigatória.";
    }

    // Estado
    if ($estadoObrigatorio && $estado === "") {
        $erros[] = "$rotulo #$numeroLinha: o estado é obrigatório.";
    }

    // Coerência quantidade/estado
    if ($quantidadeValida && $estado !== "") {
        $qtd = (int)$quantidade;
        $estadosSemStock = ['em-falta', 'abatido'];
        $estadosComStock = ['novo', 'em-uso', 'danificado'];

        if ($qtd === 0 && !in_array($estado, $estadosSemStock)) {
            $erros[] = "$rotulo #$numeroLinha: com quantidade 0, o estado deve ser \"Em falta\" ou \"Abatido\".";
        } elseif ($qtd > 0 && !in_array($estado, $estadosComStock)) {
            $erros[] = "$rotulo #$numeroLinha: com quantidade superior a 0, o estado deve ser \"Novo\", \"Em uso\" ou \"Danificado\".";
        }
    }

    return $erros;
}

function validar_acessorios_equipamento(array $acessorios): array {
    $erros = [];

    if (empty($acessorios['nome'])) {
        $erros[] = "Deve existir pelo menos um acessório associado ao equipamento.";
        return $erros;
    }

    foreach ($acessorios['nome'] as $i => $nome) {
        $erros = array_merge($erros, validar_linha_item_equipamento(
            $nome,
            $acessorios['referencia'][$i] ?? '',
            $acessorios['quantidade'][$i] ?? '',
            $acessorios['unidade'][$i] ?? '',
            $acessorios['estado'][$i] ?? '',
            $acessorios['observacoes'][$i] ?? '',
            true, // estado obrigatório
            "Acessório",
            $i
        ));
    }

    return $erros;
}

function validar_consumiveis_equipamento(array $consumiveis): array {
    $erros = [];

    foreach ($consumiveis['nome'] as $i => $nome) {
        $erros = array_merge($erros, validar_linha_item_equipamento(
            $nome,
            $consumiveis['referencia'][$i] ?? '',
            $consumiveis['quantidade'][$i] ?? '',
            $consumiveis['unidade'][$i] ?? '',
            $consumiveis['estado'][$i] ?? '',
            $consumiveis['observacoes'][$i] ?? '',
            false, // estado opcional
            "Consumível",
            $i
        ));
    }

    return $erros;
}

// ============================================================
// Validações dos campos do formulário de Equipamentos — Tab 3 (Aquisição)
// ============================================================

function validar_data_aquisicao_equipamento(string $data_aquisicao, string $ano_fabrico): array {
    $erros = [];
    if ($data_aquisicao === "") {
        $erros[] = "A data de aquisição é obrigatória.";
    } else {
        $dataAquisicaoObj = DateTime::createFromFormat('Y-m-d', $data_aquisicao);
        if (!$dataAquisicaoObj) {
            $erros[] = "A data de aquisição é inválida.";
        } elseif ($ano_fabrico !== "") {
            if ((int)$dataAquisicaoObj->format('Y') <= (int)$ano_fabrico) {
                $erros[] = "A data de aquisição deve ser posterior ao ano de fabrico do equipamento.";
            }
        }
    }
    return $erros;
}

function validar_custo_aquisicao_equipamento(string $custo_aquisicao): array {
    $erros = [];
    if ($custo_aquisicao === "") {
        $erros[] = "O custo de aquisição é obrigatório.";
    } elseif (!is_numeric($custo_aquisicao) || (float)$custo_aquisicao < 0) {
        $erros[] = "O custo de aquisição deve ser um valor numérico igual ou superior a zero.";
    }
    return $erros;
}

function validar_tipo_entrada_equipamento(string $tipo_entrada): array {
    $erros = [];
    if ($tipo_entrada === "") {
        $erros[] = "O tipo de entrada é obrigatório.";
    }
    return $erros;
}

function validar_tem_contrato_aquisicao_equipamento(string $tem_contrato_aquisicao): array {
    $erros = [];
    if ($tem_contrato_aquisicao === "") {
        $erros[] = "É obrigatório indicar se existe contrato de aquisição associado.";
    }
    return $erros;
}

function validar_tem_fatura_equipamento(string $tem_fatura): array {
    $erros = [];
    if ($tem_fatura === "") {
        $erros[] = "É obrigatório indicar se existe fatura associada.";
    }
    return $erros;
}

function validar_documentacao_contrato_aquisicao_equipamento(string $tem_contrato_aquisicao, string $nomeContratoAquisicao, string $dataContratoAquisicao, string $validadeContratoAquisicao, $dataAquisicaoObj): array {
    $erros = [];

    if ($tem_contrato_aquisicao !== "sim") {
        return $erros;
    }

    if ($nomeContratoAquisicao === "") {
        $erros[] = "O nome do documento (contrato de aquisição) é obrigatório.";
    } elseif (strlen($nomeContratoAquisicao) < 2) {
        $erros[] = "O nome do documento (contrato de aquisição) deve ter no mínimo 2 caracteres.";
    }

    $dataContratoAquisicaoObj = null;
    if ($dataContratoAquisicao === "") {
        $erros[] = "A data do documento (contrato de aquisição) é obrigatória.";
    } else {
        $dataContratoAquisicaoObj = DateTime::createFromFormat('Y-m-d', $dataContratoAquisicao);
        if (!$dataContratoAquisicaoObj) {
            $erros[] = "A data do documento (contrato de aquisição) é inválida.";
        } elseif ($dataAquisicaoObj && $dataContratoAquisicaoObj < $dataAquisicaoObj) {
            $erros[] = "A data do documento (contrato de aquisição) deve ser igual ou posterior à data de aquisição.";
        }
    }

    if ($validadeContratoAquisicao !== "" && $dataContratoAquisicaoObj) {
        $validadeContratoAquisicaoObj = DateTime::createFromFormat('Y-m-d', $validadeContratoAquisicao);
        if ($validadeContratoAquisicaoObj && $validadeContratoAquisicaoObj <= $dataContratoAquisicaoObj) {
            $erros[] = "A validade do documento (contrato de aquisição) deve ser posterior à data do documento.";
        }
    }

    return $erros;
}

function validar_documentacao_fatura_equipamento(string $tem_fatura, string $nomeFatura, string $dataFatura, $dataAquisicaoObj): array {
    $erros = [];

    if ($tem_fatura !== "sim") {
        return $erros;
    }

    if ($nomeFatura === "") {
        $erros[] = "O nome do documento (fatura) é obrigatório.";
    } elseif (strlen($nomeFatura) < 2) {
        $erros[] = "O nome do documento (fatura) deve ter no mínimo 2 caracteres.";
    }

    if ($dataFatura === "") {
        $erros[] = "A data do documento (fatura) é obrigatória.";
    } else {
        $dataFaturaObj = DateTime::createFromFormat('Y-m-d', $dataFatura);
        if (!$dataFaturaObj) {
            $erros[] = "A data do documento (fatura) é inválida.";
        } elseif ($dataAquisicaoObj && $dataFaturaObj < $dataAquisicaoObj) {
            $erros[] = "A data do documento (fatura) deve ser igual ou posterior à data de aquisição.";
        }
    }

    return $erros;
}

function validar_observacoes_aquisicao_equipamento(string $observacoes): array {
    $erros = [];
    if ($observacoes !== "" && strlen($observacoes) < 2) {
        $erros[] = "As observações da aquisição, se preenchidas, devem ter no mínimo 2 caracteres.";
    }
    return $erros;
}

// ============================================================
// Validações dos campos do formulário de Equipamentos — Tab 4 (Fornecedores Associados)
// ============================================================

function validar_linha_fornecedor_equipamento(string $fornecedorId, string $moradaId, string $pessoaContacto, string $telefonePessoaContacto, string $observacoes, int $indice, array &$idsFornecedoresUsados): array {
    $erros = [];
    $numeroLinha = $indice + 1;

    $fornecedorId = trim($fornecedorId);
    $moradaId = trim($moradaId);
    $pessoaContacto = trim($pessoaContacto);
    $telefonePessoaContacto = trim($telefonePessoaContacto);
    $observacoes = trim($observacoes);

    // --- Fornecedor ---
    if ($fornecedorId === "") {
        $erros[] = "Fornecedor #$numeroLinha: o fornecedor é obrigatório.";
    } else {
        if (in_array($fornecedorId, $idsFornecedoresUsados)) {
            $erros[] = "Fornecedor #$numeroLinha: este fornecedor já foi associado noutra linha.";
        } else {
            $idsFornecedoresUsados[] = $fornecedorId;
        }
    }

    // --- Morada ---
    if ($moradaId === "") {
        $erros[] = "Fornecedor #$numeroLinha: a morada é obrigatória.";
    }

    // --- Pessoa de contacto ---
    if ($pessoaContacto === "") {
        $erros[] = "Fornecedor #$numeroLinha: a pessoa de contacto é obrigatória.";
    } else {
        if (strlen($pessoaContacto) < 2) {
            $erros[] = "Fornecedor #$numeroLinha: o nome da pessoa de contacto deve ter no mínimo 2 caracteres.";
        }
        if (!preg_match('/^[A-Za-zÀ-ÿ\s\'-]+$/', $pessoaContacto)) {
            $erros[] = "Fornecedor #$numeroLinha: o nome da pessoa de contacto deve conter apenas letras, espaços, hífens e apóstrofos.";
        }
    }

    // --- Telefone da pessoa de contacto ---
    $telefoneSemEspacos = preg_replace('/\s+/', '', $telefonePessoaContacto);
    if ($telefoneSemEspacos === "") {
        $erros[] = "Fornecedor #$numeroLinha: o telefone da pessoa de contacto é obrigatório.";
    } elseif (!preg_match('/^\+351(91|92|93|96)\d{7}$/', $telefoneSemEspacos)) {
        $erros[] = "Fornecedor #$numeroLinha: o telefone da pessoa de contacto deve começar com \"+351\" seguido de 9 dígitos, sendo os dois primeiros 91, 92, 93 ou 96.";
    }

    // --- Observações (opcional) ---
    if ($observacoes !== "" && strlen($observacoes) < 2) {
        $erros[] = "Fornecedor #$numeroLinha: as observações, se preenchidas, devem ter no mínimo 2 caracteres.";
    }

    return $erros;
}

function validar_fornecedores_associados_equipamento(array $fornecedoresAssociados): array {
    $erros = [];

    if (empty($fornecedoresAssociados['fornecedor'])) {
        $erros[] = "Deve existir pelo menos um fornecedor associado ao equipamento.";
        return $erros;
    }

    $idsFornecedoresUsados = [];

    foreach ($fornecedoresAssociados['fornecedor'] as $i => $fornecedorId) {
        $erros = array_merge($erros, validar_linha_fornecedor_equipamento(
            $fornecedorId,
            $fornecedoresAssociados['morada'][$i] ?? '',
            $fornecedoresAssociados['pessoa'][$i] ?? '',
            $fornecedoresAssociados['telefone'][$i] ?? '',
            $fornecedoresAssociados['observacoes'][$i] ?? '',
            $i,
            $idsFornecedoresUsados
        ));
    }

    return $erros;
}

// ============================================================
// Validações dos campos do formulário de Equipamentos — Tab 5 (Localização)
// ============================================================

function validar_localizacao_equipamento(string $localizacao_id): array {
    $erros = [];
    if ($localizacao_id === "") {
        $erros[] = "A localização associada é obrigatória.";
    }
    return $erros;
}

function validar_observacoes_localizacao_equipamento(string $observacoes): array {
    $erros = [];
    if ($observacoes !== "" && strlen($observacoes) < 2) {
        $erros[] = "As observações da localização, se preenchidas, devem ter no mínimo 2 caracteres.";
    }
    return $erros;
}

// ============================================================
// Validações dos campos do formulário de Equipamentos — Tab 6 (Garantia)
// ============================================================

function validar_data_inicio_garantia_equipamento(string $dataInicioGarantia, $dataAquisicaoObj): array {
    $erros = [];
    if ($dataInicioGarantia === "") {
        $erros[] = "A data de início da garantia é obrigatória.";
    } else {
        $dataInicioGarantiaObj = DateTime::createFromFormat('Y-m-d', $dataInicioGarantia);
        if (!$dataInicioGarantiaObj) {
            $erros[] = "A data de início da garantia é inválida.";
        } elseif ($dataAquisicaoObj && $dataInicioGarantiaObj < $dataAquisicaoObj) {
            $erros[] = "A data de início da garantia deve ser igual ou posterior à data de aquisição do equipamento.";
        }
    }
    return $erros;
}

function validar_data_fim_garantia_equipamento(string $dataFimGarantia, $dataInicioGarantiaObj): array {
    $erros = [];
    if ($dataFimGarantia === "") {
        $erros[] = "A data de fim da garantia é obrigatória.";
    } else {
        $dataFimGarantiaObj = DateTime::createFromFormat('Y-m-d', $dataFimGarantia);
        if (!$dataFimGarantiaObj) {
            $erros[] = "A data de fim da garantia é inválida.";
        } elseif ($dataInicioGarantiaObj && $dataFimGarantiaObj <= $dataInicioGarantiaObj) {
            $erros[] = "A data de fim da garantia deve ser posterior à data de início da garantia.";
        }
    }
    return $erros;
}

function validar_observacoes_garantia_equipamento(string $observacoes): array {
    $erros = [];
    if ($observacoes !== "" && strlen($observacoes) < 2) {
        $erros[] = "As observações da garantia, se preenchidas, devem ter no mínimo 2 caracteres.";
    }
    return $erros;
}

// Função específica: certificado de garantia, cuja data deve ser igual ou posterior à data de início da garantia (em vez da data de aquisição)
function validar_documentacao_garantia_equipamento(string $temDoc, string $nomeDoc, string $dataDoc, string $validadeDoc, $dataInicioGarantiaObj): array {
    $erros = [];

    if ($temDoc === "") {
        $erros[] = "É obrigatório indicar se existe certificado de garantia associada.";
        return $erros;
    }

    if ($temDoc !== "sim") {
        return $erros;
    }

    if ($nomeDoc === "") {
        $erros[] = "O nome do documento (certificado de garantia) é obrigatório.";
    } elseif (strlen($nomeDoc) < 2) {
        $erros[] = "O nome do documento (certificado de garantia) deve ter no mínimo 2 caracteres.";
    }

    $dataDocObj = null;

    if ($dataDoc === "") {
        $erros[] = "A data do documento (certificado de garantia) é obrigatória.";
    } else {
        $dataDocObj = DateTime::createFromFormat('Y-m-d', $dataDoc);

        if ($dataDocObj && $dataInicioGarantiaObj) {
            if ($dataDocObj < $dataInicioGarantiaObj) {
                $erros[] = "A data do documento (certificado de garantia) deve ser igual ou posterior à data de início da garantia.";
            }
        }
    }

    if ($validadeDoc !== "" && $dataDocObj) {
        $validadeObj = DateTime::createFromFormat('Y-m-d', $validadeDoc);
        if ($validadeObj && $validadeObj <= $dataDocObj) {
            $erros[] = "A validade do documento (certificado de garantia) deve ser posterior à data do documento.";
        }
    }

    return $erros;
}

// ============================================================
// Validações dos campos do formulário de Equipamentos — Tab 7 (Contrato de Manutenção)
// ============================================================

function validar_contrato_manutencao_equipamento(string $contratoManutencao, string $tipoContrato, string $entidadeResponsavelContrato, string $periodicidadeContrato): array {
    $erros = [];

    if ($contratoManutencao === "") {
        $erros[] = "É obrigatório indicar se existe contrato de manutenção.";
        return $erros;
    }

    if ($contratoManutencao !== "sim") {
        return $erros;
    }

    // --- Tipo de contrato ---
    if ($tipoContrato === "") {
        $erros[] = "O tipo de contrato é obrigatório.";
    }

    // --- Entidade responsável ---
    if ($entidadeResponsavelContrato === "") {
        $erros[] = "A entidade responsável pelo contrato é obrigatória.";
    } else {
        if (strlen($entidadeResponsavelContrato) < 2) {
            $erros[] = "O nome da entidade responsável deve ter no mínimo 2 caracteres.";
        }
        if (!preg_match('/^[A-Za-zÀ-ÿ0-9\s.\-]+$/', $entidadeResponsavelContrato)) {
            $erros[] = "O nome da entidade responsável deve conter apenas letras, números, espaços, pontos e hífens.";
        }
    }

    // --- Periodicidade ---
    if ($periodicidadeContrato === "") {
        $erros[] = "A periodicidade do contrato é obrigatória.";
    }

    return $erros;
}

function validar_observacoes_contrato_equipamento(string $observacoes): array {
    $erros = [];
    if ($observacoes !== "" && strlen($observacoes) < 2) {
        $erros[] = "As observações do contrato, se preenchidas, devem ter no mínimo 2 caracteres.";
    }
    return $erros;
}

// Função genérica: documentação cuja data deve ser posterior à data de aquisição (usada no Tab 7)
function validar_documentacao_com_data_equipamento(string $temDoc, string $nomeDoc, string $dataDoc, string $validadeDoc, $dataReferenciaObj, string $rotulo): array {
    $erros = [];

    if ($temDoc === "") {
        $erros[] = "É obrigatório indicar se existe $rotulo associada.";
        return $erros;
    }

    if ($temDoc !== "sim") {
        return $erros;
    }

    if ($nomeDoc === "") {
        $erros[] = "O nome do documento ($rotulo) é obrigatório.";
    } elseif (strlen($nomeDoc) < 2) {
        $erros[] = "O nome do documento ($rotulo) deve ter no mínimo 2 caracteres.";
    }

    $dataDocObj = null;

    if ($dataDoc === "") {
        $erros[] = "A data do documento ($rotulo) é obrigatória.";
    } else {
        $dataDocObj = DateTime::createFromFormat('Y-m-d', $dataDoc);

        if ($dataDocObj && $dataReferenciaObj) {
            if ($dataDocObj <= $dataReferenciaObj) {
                $erros[] = "A data do documento ($rotulo) deve ser posterior à data de aquisição do equipamento.";
            }
        }
    }

    if ($validadeDoc !== "" && $dataDocObj) {
        $validadeObj = DateTime::createFromFormat('Y-m-d', $validadeDoc);
        if ($validadeObj && $validadeObj <= $dataDocObj) {
            $erros[] = "A validade do documento ($rotulo) deve ser posterior à data do documento.";
        }
    }

    return $erros;
}