<?php
// ============================================================
// EDITAR_EQUIPAMENTO.PHP
// Permite editar um equipamento existente (identificado por ID
// encriptado), através de um formulário multi-separador igual
// ao de criação (Identificação, Acessórios/Consumíveis,
// Aquisição, Fornecedor, Localização, Garantia, Contrato de
// Manutenção). Valida e atualiza todos os dados associados,
// registando as alterações no histórico do equipamento.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
require_once __DIR__ . '/../../includes/validacoes.php';

// Permitir apenas pedidos GET (clicar em "Editar") ou POST (submeter o formulário)
if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'])) {
    header('Location: ' . BASE_URL . '/private/iniciar_sessao.php');
    exit;
}

// Recolhe e desencripta o ID do equipamento recebido na URL
$idEquipamentoEncriptado = $_GET['id_equipamento'] ?? null;
$idEquipamento = aes_decrypt($idEquipamentoEncriptado);

if (!$idEquipamento || !is_numeric($idEquipamento)) {
header('Location: ' . BASE_URL . '/private/views/equipamentos/equipamentos.php');
exit;
}

$erros = [];
$metodoPost = ($_SERVER['REQUEST_METHOD'] === 'POST');

// --------------------------------------------------------------------
// VALIDAÇÃO DO FORMULÁRIO (submissão POST), separador a separador
// --------------------------------------------------------------------
if ($metodoPost) {

    $anoFabrico = trim($_POST['ano_fabrico'] ?? '');

    // ============================================================
    // Tab 1 — Identificação
    // ============================================================
    // Nota: "codigo" é readonly no formulário, por isso não é validado aqui
    $erros = array_merge($erros, validar_designacao_equipamento(trim($_POST['designacao'] ?? '')));
    $erros = array_merge($erros, validar_categoria_equipamento($_POST['categoria'] ?? ''));
    $erros = array_merge($erros, validar_marca_equipamento(trim($_POST['marca'] ?? '')));
    $erros = array_merge($erros, validar_modelo_equipamento(trim($_POST['modelo'] ?? '')));
    $erros = array_merge($erros, validar_numero_serie_equipamento(trim($_POST['numero_serie'] ?? '')));
    $erros = array_merge($erros, validar_fabricante_equipamento(trim($_POST['fabricante'] ?? '')));
    $erros = array_merge($erros, validar_ano_fabrico_equipamento($anoFabrico));
    $erros = array_merge($erros, validar_estado_equipamento($_POST['estado'] ?? ''));
    $erros = array_merge($erros, validar_criticidade_equipamento($_POST['criticidade'] ?? ''));
    $erros = array_merge($erros, validar_observacoes_equipamento(trim($_POST['observacoes'] ?? '')));

    $erros = array_merge($erros, validar_documentacao_identificacao_equipamento(
        $_POST['tem_documentacao_tecnica'] ?? '',
        trim($_POST['nomeManualTecnico'] ?? ''),
        $_POST['dataManualTecnico'] ?? '',
        $_POST['validadeManualTecnico'] ?? '',
        $anoFabrico,
        'documentação técnica'
    ));

    $erros = array_merge($erros, validar_documentacao_identificacao_equipamento(
        $_POST['tem_documentacao_utilizacao'] ?? '',
        trim($_POST['nomeManualUtilizacao'] ?? ''),
        $_POST['dataManualUtilizacao'] ?? '',
        $_POST['validadeManualUtilizacao'] ?? '',
        $anoFabrico,
        'documentação de utilização'
    ));

    $erros = array_merge($erros, validar_documentacao_identificacao_equipamento(
        $_POST['tem_declaracao_conformidade'] ?? '',
        trim($_POST['nomeDeclaracaoConformidade'] ?? ''),
        $_POST['dataDeclaracaoConformidade'] ?? '',
        $_POST['validadeDeclaracaoConformidade'] ?? '',
        $anoFabrico,
        'declaração de conformidade'
    ));

    // ============================================================
    // Tab 2 — Acessórios e Consumíveis
    // ============================================================
    $erros = array_merge($erros, validar_acessorios_equipamento($_POST['acessorios'] ?? []));
    $erros = array_merge($erros, validar_consumiveis_equipamento($_POST['consumiveis'] ?? ['nome' => []]));

    // ============================================================
    // Tab 3 — Aquisição
    // ============================================================
    $dataAquisicao = $_POST['data_aquisicao'] ?? '';

    $erros = array_merge($erros, validar_data_aquisicao_equipamento($dataAquisicao, $anoFabrico));
    $erros = array_merge($erros, validar_custo_aquisicao_equipamento(trim($_POST['custo_aquisicao'] ?? '')));
    $erros = array_merge($erros, validar_tipo_entrada_equipamento($_POST['tipo_entrada'] ?? ''));
    $erros = array_merge($erros, validar_tem_contrato_aquisicao_equipamento($_POST['tem_contrato_aquisicao'] ?? ''));
    $erros = array_merge($erros, validar_tem_fatura_equipamento($_POST['tem_fatura'] ?? ''));

    $dataAquisicaoObj = DateTime::createFromFormat('Y-m-d', $dataAquisicao) ?: null;

    $erros = array_merge($erros, validar_documentacao_contrato_aquisicao_equipamento(
        $_POST['tem_contrato_aquisicao'] ?? '',
        trim($_POST['nomeContratoAquisicao'] ?? ''),
        $_POST['dataContratoAquisicao'] ?? '',
        $_POST['validadeContratoAquisicao'] ?? '',
        $dataAquisicaoObj
    ));

    $erros = array_merge($erros, validar_documentacao_fatura_equipamento(
        $_POST['tem_fatura'] ?? '',
        trim($_POST['nomeFatura'] ?? ''),
        $_POST['dataFatura'] ?? '',
        $dataAquisicaoObj
    ));

    $erros = array_merge($erros, validar_observacoes_aquisicao_equipamento(trim($_POST['observacoesAquisicao'] ?? '')));

    // ============================================================
    // Tab 4 — Fornecedores Associados
    // ============================================================
    $erros = array_merge($erros, validar_fornecedores_associados_equipamento($_POST['fornecedores'] ?? []));

    // ============================================================
    // Tab 5 — Localização
    // ============================================================
    $erros = array_merge($erros, validar_localizacao_equipamento($_POST['localizacao'] ?? ''));
    $erros = array_merge($erros, validar_observacoes_localizacao_equipamento(trim($_POST['observacoesLocalizacao'] ?? '')));

    // ============================================================
    // Tab 6 — Garantia
    // ============================================================
    $dataInicioGarantia = $_POST['dataInicioGarantia'] ?? '';

    $erros = array_merge($erros, validar_data_inicio_garantia_equipamento($dataInicioGarantia, $dataAquisicaoObj));

    $dataInicioGarantiaObj = DateTime::createFromFormat('Y-m-d', $dataInicioGarantia) ?: null;

    $erros = array_merge($erros, validar_data_fim_garantia_equipamento(
        $_POST['dataFimGarantia'] ?? '',
        $dataInicioGarantiaObj
    ));

    $erros = array_merge($erros, validar_documentacao_garantia_equipamento(
        $_POST['tem_documentacao_garantia'] ?? '',
        trim($_POST['nomeCertificadoGarantia'] ?? ''),
        $_POST['dataCertificadoGarantia'] ?? '',
        $_POST['validadeCertificadoGarantia'] ?? '',
        $dataInicioGarantiaObj
    ));

    $erros = array_merge($erros, validar_observacoes_garantia_equipamento(trim($_POST['observacoesGarantia'] ?? '')));

    // ============================================================
    // Tab 7 — Contrato de Manutenção
    // ============================================================
    $erros = array_merge($erros, validar_contrato_manutencao_equipamento(
        $_POST['contratoManutencao'] ?? '',
        $_POST['tipoContrato'] ?? '',
        trim($_POST['entidadeResponsavelContrato'] ?? ''),
        $_POST['periodicidadeContrato'] ?? ''
    ));

    $erros = array_merge($erros, validar_documentacao_com_data_equipamento(
        $_POST['tem_documentacao_contrato'] ?? '',
        trim($_POST['nomeCertificadoContrato'] ?? ''),
        $_POST['dataContratoManutencao'] ?? '',
        $_POST['validadeContratoManutencao'] ?? '',
        $dataAquisicaoObj,
        'contrato de manutenção'
    ));

    $erros = array_merge($erros, validar_documentacao_com_data_equipamento(
        $_POST['tem_relatorio_contrato'] ?? '',
        trim($_POST['nomeRelatorioManutencao'] ?? ''),
        $_POST['dataRelatorioManutencao'] ?? '',
        $_POST['validadeRelatorioManutencao'] ?? '',
        $dataAquisicaoObj,
        'relatório de manutenção'
    ));

    $erros = array_merge($erros, validar_documentacao_com_data_equipamento(
        $_POST['tem_documentacao_calibracao'] ?? '',
        trim($_POST['nomeCertificadoCalibracao'] ?? ''),
        $_POST['dataCertificadoCalibracao'] ?? '',
        $_POST['validadeCertificadoCalibracao'] ?? '',
        $dataAquisicaoObj,
        'certificado de calibração'
    ));

    $erros = array_merge($erros, validar_documentacao_com_data_equipamento(
        $_POST['tem_relatorio_calibracao'] ?? '',
        trim($_POST['nomeRelatorioCalibracao'] ?? ''),
        $_POST['dataRelatorioCalibracao'] ?? '',
        $_POST['validadeRelatorioCalibracao'] ?? '',
        $dataAquisicaoObj,
        'relatório de calibração'
    ));

    $erros = array_merge($erros, validar_observacoes_contrato_equipamento(trim($_POST['observacoesContrato'] ?? '')));

    // --------------------------------------------------------------------
    // ATUALIZAÇÃO NA BASE DE DADOS (se não houver erros de validação)
    // --------------------------------------------------------------------
    if (empty($erros)) {
    try {
        $ligacao = conectar_bd();

        // codigo é readonly mas é submetido — usado para o nome do ficheiro
        $codigoEquipamento = $_POST['codigo'];

        // Estado anterior do equipamento, para o histórico de movimentações
        $stmtAntes = $ligacao->prepare("
            SELECT e.designacao, e.marca, e.modelo, e.numero_serie, e.fabricante, e.ano_fabrico, e.observacoes,
                   cat.designacao AS categoria, ee.designacao AS estado, c.designacao AS criticidade
            FROM equipamentos e
            LEFT JOIN categorias cat ON e.categoria_id = cat.id
            LEFT JOIN estados_equipamento ee ON e.estado_id = ee.id
            LEFT JOIN criticidades c ON e.criticidade_id = c.id
            WHERE e.id = :id
        ");
        $stmtAntes->execute([':id' => $idEquipamento]);
        $dadosAntesEdicao = $stmtAntes->fetch(PDO::FETCH_ASSOC);

        // ============================================================
        // Tab 1 — Identificação
        // ============================================================
        $stmt = $ligacao->prepare("SELECT id FROM categorias WHERE designacao = :d");
        $stmt->execute([':d' => $_POST['categoria']]);
        $categoriaId = $stmt->fetchColumn();

        $stmt = $ligacao->prepare("SELECT id FROM estados_equipamento WHERE designacao = :d");
        $stmt->execute([':d' => $_POST['estado']]);
        $estadoId = $stmt->fetchColumn();

        $stmt = $ligacao->prepare("SELECT id FROM criticidades WHERE designacao = :d");
        $stmt->execute([':d' => $_POST['criticidade']]);
        $criticidadeId = $stmt->fetchColumn();

        $anoFabrico = $_POST['ano_fabrico'] !== '' ? $_POST['ano_fabrico'] : null;

        $stmt = $ligacao->prepare("
            UPDATE equipamentos
            SET designacao        = :designacao,
                categoria_id      = :categoria_id,
                marca             = :marca,
                modelo            = :modelo,
                numero_serie      = :numero_serie,
                fabricante        = :fabricante,
                ano_fabrico       = :ano_fabrico,
                estado_id         = :estado_id,
                criticidade_id    = :criticidade_id,
                observacoes       = :observacoes
            WHERE id = :id
        ");
        $stmt->execute([
            ':designacao'     => trim($_POST['designacao']),
            ':categoria_id'   => $categoriaId,
            ':marca'          => trim($_POST['marca']),
            ':modelo'         => trim($_POST['modelo']),
            ':numero_serie'   => trim($_POST['numero_serie']),
            ':fabricante'     => trim($_POST['fabricante']),
            ':ano_fabrico'    => $anoFabrico,
            ':estado_id'      => $estadoId,
            ':criticidade_id' => $criticidadeId,
            ':observacoes'    => trim($_POST['observacoes'] ?? ''),
            ':id'             => $idEquipamento,
        ]);

        // Documentação Tab 1 (tipos 1, 2, 3)
        guardarDocumentoEquipamento($ligacao, $idEquipamento, $codigoEquipamento, 1, 'tem_documentacao_tecnica', 'nomeManualTecnico', 'dataManualTecnico', 'validadeManualTecnico', 'ficheiroManualTecnico');
        guardarDocumentoEquipamento($ligacao, $idEquipamento, $codigoEquipamento, 2, 'tem_documentacao_utilizacao', 'nomeManualUtilizacao', 'dataManualUtilizacao', 'validadeManualUtilizacao', 'ficheiroManualUtilizacao');
        guardarDocumentoEquipamento($ligacao, $idEquipamento, $codigoEquipamento, 3, 'tem_declaracao_conformidade', 'nomeDeclaracaoConformidade', 'dataDeclaracaoConformidade', 'validadeDeclaracaoConformidade', 'ficheiroDeclaracaoConformidade');

        // ============================================================
        // Tab 2 — Acessórios e Consumíveis
        // (apaga os existentes e reinseere os submetidos)
        // ============================================================
        $stmt = $ligacao->prepare("DELETE FROM acessorios WHERE equipamento_id = :id");
        $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $ligacao->prepare("DELETE FROM consumiveis WHERE equipamento_id = :id");
        $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
        $stmt->execute();

        if (!empty($_POST['acessorios']['nome'])) {
            foreach ($_POST['acessorios']['nome'] as $i => $nome) {
                $stmt = $ligacao->prepare("SELECT id FROM unidades WHERE designacao = :d");
                $stmt->execute([':d' => $_POST['acessorios']['unidade'][$i] ?? '']);
                $unidadeId = $stmt->fetchColumn() ?: null;

                $stmt = $ligacao->prepare("SELECT id FROM estados_acessorio WHERE valor = :v");
                $stmt->execute([':v' => $_POST['acessorios']['estado'][$i] ?? '']);
                $estadoAcessorioId = $stmt->fetchColumn() ?: null;

                $stmt = $ligacao->prepare("
                    INSERT INTO acessorios (equipamento_id, nome, referencia, quantidade, unidade_id, estado_id, observacoes)
                    VALUES (:equipamento_id, :nome, :referencia, :quantidade, :unidade_id, :estado_id, :observacoes)
                ");
                $stmt->execute([
                    ':equipamento_id' => $idEquipamento,
                    ':nome'           => trim($nome),
                    ':referencia'     => trim($_POST['acessorios']['referencia'][$i] ?? ''),
                    ':quantidade'     => (int)($_POST['acessorios']['quantidade'][$i] ?? 0),
                    ':unidade_id'     => $unidadeId,
                    ':estado_id'      => $estadoAcessorioId,
                    ':observacoes'    => trim($_POST['acessorios']['observacoes'][$i] ?? ''),
                ]);
            }
        }

        if (!empty($_POST['consumiveis']['nome'])) {
            foreach ($_POST['consumiveis']['nome'] as $i => $nome) {
                $stmt = $ligacao->prepare("SELECT id FROM unidades WHERE designacao = :d");
                $stmt->execute([':d' => $_POST['consumiveis']['unidade'][$i] ?? '']);
                $unidadeId = $stmt->fetchColumn() ?: null;

                $stmt = $ligacao->prepare("SELECT id FROM estados_acessorio WHERE valor = :v");
                $stmt->execute([':v' => $_POST['consumiveis']['estado'][$i] ?? '']);
                $estadoConsumívelId = $stmt->fetchColumn() ?: null;

                $stmt = $ligacao->prepare("
                    INSERT INTO consumiveis (equipamento_id, nome, referencia, quantidade, unidade_id, estado_id, observacoes)
                    VALUES (:equipamento_id, :nome, :referencia, :quantidade, :unidade_id, :estado_id, :observacoes)
                ");
                $stmt->execute([
                    ':equipamento_id' => $idEquipamento,
                    ':nome'           => trim($nome),
                    ':referencia'     => trim($_POST['consumiveis']['referencia'][$i] ?? ''),
                    ':quantidade'     => (int)($_POST['consumiveis']['quantidade'][$i] ?? 0),
                    ':unidade_id'     => $unidadeId,
                    ':estado_id'      => $estadoConsumívelId,
                    ':observacoes'    => trim($_POST['consumiveis']['observacoes'][$i] ?? ''),
                ]);
            }
        }

        // ============================================================
        // Tab 3 — Aquisição
        // ============================================================
        $stmt = $ligacao->prepare("SELECT id FROM tipos_entrada WHERE designacao = :d");
        $stmt->execute([':d' => $_POST['tipo_entrada']]);
        $tipoEntradaId = $stmt->fetchColumn();

        $stmt = $ligacao->prepare("SELECT id FROM aquisicao_equipamentos WHERE equipamento_id = :id");
        $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
        $stmt->execute();
        $aquisicaoExiste = $stmt->fetchColumn();

        if ($aquisicaoExiste) {
            $stmt = $ligacao->prepare("
                UPDATE aquisicao_equipamentos
                SET data_aquisicao  = :data_aquisicao,
                    custo_aquisicao = :custo_aquisicao,
                    tipo_entrada_id = :tipo_entrada_id,
                    observacoes     = :observacoes
                WHERE equipamento_id = :id
            ");
        } else {
            $stmt = $ligacao->prepare("
                INSERT INTO aquisicao_equipamentos (equipamento_id, data_aquisicao, custo_aquisicao, tipo_entrada_id, observacoes)
                VALUES (:id, :data_aquisicao, :custo_aquisicao, :tipo_entrada_id, :observacoes)
            ");
        }
        $stmt->execute([
            ':id'             => $idEquipamento,
            ':data_aquisicao' => $_POST['data_aquisicao'],
            ':custo_aquisicao'=> $_POST['custo_aquisicao'],
            ':tipo_entrada_id'=> $tipoEntradaId,
            ':observacoes'    => trim($_POST['observacoesAquisicao'] ?? ''),
        ]);

        // Documentação Tab 3: fatura (4), contrato de aquisição (5)
        // A fatura não tem campo de validade no formulário — passamos '' para o campoValidade
        guardarDocumentoEquipamento($ligacao, $idEquipamento, $codigoEquipamento, 4, 'tem_fatura', 'nomeFatura', 'dataFatura', '', 'ficheiroFatura');
        guardarDocumentoEquipamento($ligacao, $idEquipamento, $codigoEquipamento, 5, 'tem_contrato_aquisicao', 'nomeContratoAquisicao', 'dataContratoAquisicao', 'validadeContratoAquisicao', 'ficheiroContratoAquisicao');

        // ============================================================
        // Tab 4 — Fornecedores Associados
        // (apaga os existentes e reinseere os submetidos)
        // ============================================================
        $stmt = $ligacao->prepare("DELETE FROM equipamento_fornecedor WHERE equipamento_id = :id");
        $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
        $stmt->execute();

        if (!empty($_POST['fornecedores']['fornecedor'])) {
            foreach ($_POST['fornecedores']['fornecedor'] as $i => $fornecedorId) {
                $stmt = $ligacao->prepare("
                    INSERT INTO equipamento_fornecedor (equipamento_id, fornecedor_id, morada_id, pessoa_contacto, telefone_pessoa_contacto, observacoes)
                    VALUES (:equipamento_id, :fornecedor_id, :morada_id, :pessoa_contacto, :telefone, :observacoes)
                ");
                $stmt->execute([
                    ':equipamento_id' => $idEquipamento,
                    ':fornecedor_id'  => $fornecedorId,
                    ':morada_id'      => $_POST['fornecedores']['morada'][$i] ?? null,
                    ':pessoa_contacto'=> trim($_POST['fornecedores']['pessoa'][$i] ?? ''),
                    ':telefone'       => trim($_POST['fornecedores']['telefone'][$i] ?? ''),
                    ':observacoes'    => trim($_POST['fornecedores']['observacoes'][$i] ?? ''),
                ]);
            }
        }

        // ============================================================
        // Tab 5 — Localização
        // ============================================================
        $stmt = $ligacao->prepare("
            UPDATE equipamentos
            SET localizacao_id        = :localizacao_id,
                observacoes_localizacao = :observacoes_localizacao
            WHERE id = :id
        ");
        $stmt->execute([
            ':localizacao_id'         => $_POST['localizacao'] ?? null,
            ':observacoes_localizacao'=> trim($_POST['observacoesLocalizacao'] ?? ''),
            ':id'                     => $idEquipamento,
        ]);

        // ============================================================
        // Tab 6 — Garantia
        // ============================================================
        $stmt = $ligacao->prepare("SELECT id FROM garantias_equipamentos WHERE equipamento_id = :id");
        $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
        $stmt->execute();
        $garantiaExiste = $stmt->fetchColumn();

        if ($garantiaExiste) {
            $stmt = $ligacao->prepare("
                UPDATE garantias_equipamentos
                SET data_inicio = :data_inicio,
                    data_fim    = :data_fim,
                    observacoes = :observacoes
                WHERE equipamento_id = :id
            ");
        } else {
            $stmt = $ligacao->prepare("
                INSERT INTO garantias_equipamentos (equipamento_id, data_inicio, data_fim, observacoes)
                VALUES (:id, :data_inicio, :data_fim, :observacoes)
            ");
        }
        $stmt->execute([
            ':id'          => $idEquipamento,
            ':data_inicio' => $_POST['dataInicioGarantia'],
            ':data_fim'    => !empty($_POST['dataFimGarantia']) ? $_POST['dataFimGarantia'] : null,
            ':observacoes' => trim($_POST['observacoesGarantia'] ?? ''),
        ]);

        // Documentação Tab 6 (tipo 9)
        guardarDocumentoEquipamento($ligacao, $idEquipamento, $codigoEquipamento, 9, 'tem_documentacao_garantia', 'nomeCertificadoGarantia', 'dataCertificadoGarantia', 'validadeCertificadoGarantia', 'ficheiroCertificadoGarantia');

        // ============================================================
        // Tab 7 — Contrato de Manutenção
        // ============================================================
        $contratoManutencao = $_POST['contratoManutencao'] ?? 'nao';

        $stmt = $ligacao->prepare("SELECT id FROM contratos_manutencao WHERE equipamento_id = :id");
        $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
        $stmt->execute();
        $contratoExiste = $stmt->fetchColumn();

        if ($contratoManutencao === 'sim') {
            if ($contratoExiste) {
                $stmt = $ligacao->prepare("
                    UPDATE contratos_manutencao
                    SET tipo_contrato_id    = :tipo_contrato_id,
                        entidade_responsavel = :entidade_responsavel,
                        periodicidade_id    = :periodicidade_id,
                        observacoes         = :observacoes
                    WHERE equipamento_id = :id
                ");
            } else {
                $stmt = $ligacao->prepare("
                    INSERT INTO contratos_manutencao (equipamento_id, tipo_contrato_id, entidade_responsavel, periodicidade_id, observacoes)
                    VALUES (:id, :tipo_contrato_id, :entidade_responsavel, :periodicidade_id, :observacoes)
                ");
            }
            $stmt->execute([
                ':id'                  => $idEquipamento,
                ':tipo_contrato_id'    => $_POST['tipoContrato'] ?? null,
                ':entidade_responsavel'=> trim($_POST['entidadeResponsavelContrato'] ?? ''),
                ':periodicidade_id'    => $_POST['periodicidadeContrato'] ?? null,
                ':observacoes'         => trim($_POST['observacoesContrato'] ?? ''),
            ]);
        } else {
            // Sem contrato — apaga se existia
            if ($contratoExiste) {
                $stmt = $ligacao->prepare("DELETE FROM contratos_manutencao WHERE equipamento_id = :id");
                $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        // Documentação Tab 7 (tipos 10, 11, 12, 13)
        guardarDocumentoEquipamento($ligacao, $idEquipamento, $codigoEquipamento, 10, 'tem_documentacao_contrato', 'nomeCertificadoContrato', 'dataContratoManutencao', 'validadeContratoManutencao', 'ficheiroContratoManutencao');
        guardarDocumentoEquipamento($ligacao, $idEquipamento, $codigoEquipamento, 11, 'tem_relatorio_contrato', 'nomeRelatorioManutencao', 'dataRelatorioManutencao', 'validadeRelatorioManutencao', 'ficheiroRelatorioManutencao');
        guardarDocumentoEquipamento($ligacao, $idEquipamento, $codigoEquipamento, 12, 'tem_documentacao_calibracao', 'nomeCertificadoCalibracao', 'dataCertificadoCalibracao', 'validadeCertificadoCalibracao', 'ficheiroCertificadoCalibracao');
        guardarDocumentoEquipamento($ligacao, $idEquipamento, $codigoEquipamento, 13, 'tem_relatorio_calibracao', 'nomeRelatorioCalibracao', 'dataRelatorioCalibracao', 'validadeRelatorioCalibracao', 'ficheiroRelatorioCalibracao');

        registar_historico(
            $ligacao,
            $idEquipamento,
            'Edição',
            "Equipamento {$codigoEquipamento} editado.",
            $dadosAntesEdicao,
            [
                'designacao' => trim($_POST['designacao']),
                'categoria' => $_POST['categoria'],
                'marca' => trim($_POST['marca']),
                'modelo' => trim($_POST['modelo']),
                'numero_serie' => trim($_POST['numero_serie']),
                'fabricante' => trim($_POST['fabricante']),
                'ano_fabrico' => $anoFabrico,
                'estado' => $_POST['estado'],
                'criticidade' => $_POST['criticidade'],
                'observacoes' => trim($_POST['observacoes'] ?? ''),
            ]
        );

        $ligacao = null;

        $_SESSION['sucesso'] = 'equipamento_atualizado';
header('Location: ' . BASE_URL . '/private/views/equipamentos/equipamentos.php');
exit;

    } catch (PDOException $err) {
        $erros[] = "Erro ao atualizar o equipamento: " . $err->getMessage();
    }
}
}

// --------------------------------------------------------------------
// CARREGAMENTO DOS DADOS ATUAIS (para pré-preencher o formulário em GET,
// ou para repopular os <select> dependentes da BD mesmo em POST)
// --------------------------------------------------------------------
// Ligação à base de dados e obtenção dos dados atuais do equipamento
try {
    $ligacao = conectar_bd();

    // Dados principais do equipamento (Tab 1)
    $stmt = $ligacao->prepare("
        SELECT e.*, cat.designacao AS categoria, ee.designacao AS estado, c.designacao AS criticidade
        FROM equipamentos e
        LEFT JOIN categorias cat ON e.categoria_id = cat.id
        LEFT JOIN estados_equipamento ee ON e.estado_id = ee.id
        LEFT JOIN criticidades c ON e.criticidade_id = c.id
        WHERE e.id = :id
    ");
    $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmt->execute();
    $equipamento = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$equipamento) {
header('Location: ' . BASE_URL . '/private/views/equipamentos/equipamentos.php');
exit;
    }

    // Documentação do Tab 1: técnica (1), utilização (2), conformidade (3)
    $stmt = $ligacao->prepare("
        SELECT tipo_documento_id, nome_documento, data_documento, validade_documento, nome_original_ficheiro
        FROM documentacao_equipamentos
        WHERE equipamento_id = :id AND tipo_documento_id IN (1, 2, 3)
    ");
    $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmt->execute();
    $docsIdentificacao = $stmt->fetchAll(PDO::FETCH_OBJ);

    $docTecnica = null;
    $docUtilizacao = null;
    $docConformidade = null;

    foreach ($docsIdentificacao as $doc) {
        if ($doc->tipo_documento_id == 1) {
            $docTecnica = $doc;
        } elseif ($doc->tipo_documento_id == 2) {
            $docUtilizacao = $doc;
        } elseif ($doc->tipo_documento_id == 3) {
            $docConformidade = $doc;
        }
    }

    // Listas para os <select> de Unidade e Estado dos Acessórios/Consumíveis (Tab 2)
    $unidadesBD = $ligacao->query("SELECT designacao FROM unidades ORDER BY ordem")->fetchAll(PDO::FETCH_COLUMN);
    $estadosAcessorioBD = $ligacao->query("SELECT designacao, valor FROM estados_acessorio ORDER BY ordem")->fetchAll(PDO::FETCH_ASSOC);

    // Acessórios e Consumíveis associados ao equipamento (Tab 2)
    $stmt = $ligacao->prepare("
        SELECT a.nome, a.referencia, a.quantidade, u.designacao AS unidade, ea.valor AS estado, a.observacoes
        FROM acessorios a
        LEFT JOIN unidades u ON a.unidade_id = u.id
        LEFT JOIN estados_acessorio ea ON a.estado_id = ea.id
        WHERE a.equipamento_id = :id
    ");
    $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmt->execute();
    $acessoriosBD = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $ligacao->prepare("
        SELECT c.nome, c.referencia, c.quantidade, u.designacao AS unidade, ea.valor AS estado, c.observacoes
        FROM consumiveis c
        LEFT JOIN unidades u ON c.unidade_id = u.id
        LEFT JOIN estados_acessorio ea ON c.estado_id = ea.id
        WHERE c.equipamento_id = :id
    ");
    $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmt->execute();
    $consumiveisBD = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Dados de aquisição do equipamento (Tab 3)
    $stmt = $ligacao->prepare("
        SELECT aq.data_aquisicao, aq.custo_aquisicao, aq.observacoes, te.designacao AS tipo_entrada
        FROM aquisicao_equipamentos aq
        LEFT JOIN tipos_entrada te ON aq.tipo_entrada_id = te.id
        WHERE aq.equipamento_id = :id
    ");
    $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmt->execute();
    $aquisicaoBD = $stmt->fetch(PDO::FETCH_OBJ);

    // Documentação do Tab 3: fatura (4), contrato de aquisição (5)
    $stmt = $ligacao->prepare("
        SELECT tipo_documento_id, nome_documento, data_documento, validade_documento, nome_original_ficheiro
        FROM documentacao_equipamentos
        WHERE equipamento_id = :id AND tipo_documento_id IN (4, 5)
    ");
    $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmt->execute();
    $docsAquisicao = $stmt->fetchAll(PDO::FETCH_OBJ);

    $docFatura = null;
    $docContratoAquisicao = null;

    foreach ($docsAquisicao as $doc) {
        if ($doc->tipo_documento_id == 4) {
            $docFatura = $doc;
        } elseif ($doc->tipo_documento_id == 5) {
            $docContratoAquisicao = $doc;
        }
    }

    // Fornecedores e Moradas (para os <select> da tabela de fornecedores associados) — Tab 4
    $fornecedoresBD = $ligacao->query("SELECT id, codigo, nome_empresa FROM fornecedores ORDER BY codigo")->fetchAll(PDO::FETCH_ASSOC);
    $moradasBD = $ligacao->query("SELECT id, designacao FROM moradas ORDER BY designacao")->fetchAll(PDO::FETCH_ASSOC);

    // Fornecedores associados a este equipamento (Tab 4)
    $stmt = $ligacao->prepare("
        SELECT fornecedor_id, morada_id, pessoa_contacto, telefone_pessoa_contacto, observacoes
        FROM equipamento_fornecedor
        WHERE equipamento_id = :id
    ");
    $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmt->execute();
    $fornecedoresAssociadosBD = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Localizações disponíveis (para o <select> "Localização associada") — Tab 5
    $localizacoesBD = $ligacao->query("SELECT id, codigo, edificio, piso, servico, sala FROM localizacoes ORDER BY codigo")->fetchAll(PDO::FETCH_ASSOC);

    // Dados da garantia do equipamento (Tab 6)
    $stmt = $ligacao->prepare("
        SELECT data_inicio, data_fim, observacoes
        FROM garantias_equipamentos
        WHERE equipamento_id = :id
    ");
    $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmt->execute();
    $garantiaBD = $stmt->fetch(PDO::FETCH_OBJ);

    // Documentação do Tab 6: certificado de garantia (9)
    $stmt = $ligacao->prepare("
        SELECT nome_documento, data_documento, validade_documento, nome_original_ficheiro
        FROM documentacao_equipamentos
        WHERE equipamento_id = :id AND tipo_documento_id = 9
    ");
    $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmt->execute();
    $docGarantia = $stmt->fetch(PDO::FETCH_OBJ);

    // Listas para os <select> "Tipo de contrato" e "Periodicidade" — Tab 7
    $tiposContratoBD = $ligacao->query("SELECT id, designacao FROM tipos_contrato ORDER BY ordem")->fetchAll(PDO::FETCH_ASSOC);
    $periodicidadesBD = $ligacao->query("SELECT id, designacao FROM periodicidades ORDER BY ordem")->fetchAll(PDO::FETCH_ASSOC);

    // Contrato de manutenção do equipamento (Tab 7)
    $stmt = $ligacao->prepare("
        SELECT tipo_contrato_id, entidade_responsavel, periodicidade_id, observacoes
        FROM contratos_manutencao
        WHERE equipamento_id = :id
    ");
    $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmt->execute();
    $contratoBD = $stmt->fetch(PDO::FETCH_OBJ);

    // Documentação do Tab 7: certificado de contrato (10), relatório de manutenção (11),
    // certificado de calibração (12), relatório de calibração (13)
    $stmt = $ligacao->prepare("
        SELECT tipo_documento_id, nome_documento, data_documento, validade_documento, nome_original_ficheiro
        FROM documentacao_equipamentos
        WHERE equipamento_id = :id AND tipo_documento_id IN (10, 11, 12, 13)
    ");
    $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmt->execute();
    $docsContrato = $stmt->fetchAll(PDO::FETCH_OBJ);

    $docCertificadoContrato = null;
    $docRelatorioManutencao = null;
    $docCertificadoCalibracao = null;
    $docRelatorioCalibracao = null;

    foreach ($docsContrato as $doc) {
        if ($doc->tipo_documento_id == 10) {
            $docCertificadoContrato = $doc;
        } elseif ($doc->tipo_documento_id == 11) {
            $docRelatorioManutencao = $doc;
        } elseif ($doc->tipo_documento_id == 12) {
            $docCertificadoCalibracao = $doc;
        } elseif ($doc->tipo_documento_id == 13) {
            $docRelatorioCalibracao = $doc;
        }
    }

} catch (PDOException $err) {
    $erros[] = "Erro na ligação à base de dados.";
    $equipamento = null;
    $docTecnica = null;
    $docUtilizacao = null;
    $docConformidade = null;
    $unidadesBD = [];
    $estadosAcessorioBD = [];
    $acessoriosBD = [];
    $consumiveisBD = [];
    $aquisicaoBD = null;
    $docFatura = null;
    $docContratoAquisicao = null;
    $fornecedoresBD = [];
    $moradasBD = [];
    $fornecedoresAssociadosBD = [];
    $localizacoesBD = [];
    $garantiaBD = null;
    $docGarantia = null;
    $tiposContratoBD = [];
    $periodicidadesBD = [];
    $contratoBD = null;
    $docCertificadoContrato = null;
    $docRelatorioManutencao = null;
    $docCertificadoCalibracao = null;
    $docRelatorioCalibracao = null;
}

$ligacao = null;

// Fallback se houver erro de ligação
if (!$equipamento) {
    $equipamento = (object) [
        'codigo' => '',
        'designacao' => '',
        'categoria' => '',
        'marca' => '',
        'modelo' => '',
        'numero_serie' => '',
        'fabricante' => '',
        'ano_fabrico' => '',
        'estado' => '',
        'criticidade' => '',
        'observacoes' => ''
    ];
}

// Fallback se o equipamento ainda não tiver registo em aquisicao_equipamentos
// (pode acontecer em equipamentos criados antes desta funcionalidade existir)
if (!$aquisicaoBD) {
    $aquisicaoBD = (object) [
        'data_aquisicao' => '',
        'custo_aquisicao' => '',
        'observacoes' => '',
        'tipo_entrada' => ''
    ];
}

// Fallback se o equipamento ainda não tiver registo em garantias_equipamentos
if (!$garantiaBD) {
    $garantiaBD = (object) [
        'data_inicio' => '',
        'data_fim' => '',
        'observacoes' => ''
    ];
}

// Guardar se existe (ou não) registo de contrato de manutenção, antes do fallback
$temContratoManutencaoBD = $contratoBD ? 'sim' : 'nao';

// Fallback se o equipamento ainda não tiver registo em contratos_manutencao
if (!$contratoBD) {
    $contratoBD = (object) [
        'tipo_contrato_id' => '',
        'entidade_responsavel' => '',
        'periodicidade_id' => '',
        'observacoes' => ''
    ];
}

// Valores "atuais" do Tab 1: se for um POST (mesmo com erros), mostra o que foi submetido;
// caso contrário (GET), mostra os valores atuais da base de dados

$categoriaAtual = $metodoPost ? ($_POST['categoria'] ?? '') : $equipamento->categoria;
$estadoAtual = $metodoPost ? ($_POST['estado'] ?? '') : $equipamento->estado;
$criticidadeAtual = $metodoPost ? ($_POST['criticidade'] ?? '') : $equipamento->criticidade;

$temDocTecnicaAtual = $metodoPost ? ($_POST['tem_documentacao_tecnica'] ?? '') : ($docTecnica ? 'sim' : 'nao');
$temDocUtilizacaoAtual = $metodoPost ? ($_POST['tem_documentacao_utilizacao'] ?? '') : ($docUtilizacao ? 'sim' : 'nao');
$temDeclConformidadeAtual = $metodoPost ? ($_POST['tem_declaracao_conformidade'] ?? '') : ($docConformidade ? 'sim' : 'nao');

// Acessórios e Consumíveis atuais (Tab 2): em GET vêm da BD, em POST vêm do que foi submetido
function construirItensAtuaisEquipamento($itensBD, $itensPost)
{
    if ($itensPost !== null && isset($itensPost['nome'])) {
        $itens = [];
        foreach ($itensPost['nome'] as $i => $nome) {
            $itens[] = [
                'nome' => $nome,
                'ref' => $itensPost['referencia'][$i] ?? '',
                'qty' => $itensPost['quantidade'][$i] ?? '',
                'unidade' => $itensPost['unidade'][$i] ?? '',
                'estado' => $itensPost['estado'][$i] ?? '',
                'obs' => $itensPost['observacoes'][$i] ?? '',
            ];
        }
        return $itens;
    }

    $itens = [];
    foreach ($itensBD as $item) {
        $itens[] = [
            'nome' => $item['nome'],
            'ref' => $item['referencia'],
            'qty' => $item['quantidade'],
            'unidade' => $item['unidade'],
            'estado' => $item['estado'],
            'obs' => $item['observacoes'],
        ];
    }
    return $itens;
}

$acessoriosAtuais = construirItensAtuaisEquipamento($acessoriosBD, $metodoPost ? ($_POST['acessorios'] ?? null) : null);
$consumiveisAtuais = construirItensAtuaisEquipamento($consumiveisBD, $metodoPost ? ($_POST['consumiveis'] ?? null) : null);

$tipoEntradaAtual = $metodoPost ? ($_POST['tipo_entrada'] ?? '') : $aquisicaoBD->tipo_entrada;
$temContratoAquisicaoAtual = $metodoPost ? ($_POST['tem_contrato_aquisicao'] ?? '') : ($docContratoAquisicao ? 'sim' : 'nao');
$temFaturaAtual = $metodoPost ? ($_POST['tem_fatura'] ?? '') : ($docFatura ? 'sim' : 'nao');

// Fornecedores associados atuais (Tab 4): mesma forma de $_POST['fornecedores'],
// para que a função repopularFornecedoresEquipamento() (1241466.js) os possa usar tal como faz com um POST
$fornecedoresPost = [
    'fornecedor' => [],
    'morada' => [],
    'pessoa' => [],
    'telefone' => [],
    'observacoes' => [],
];
foreach ($fornecedoresAssociadosBD as $linha) {
    $fornecedoresPost['fornecedor'][] = $linha['fornecedor_id'];
    $fornecedoresPost['morada'][] = $linha['morada_id'];
    $fornecedoresPost['pessoa'][] = $linha['pessoa_contacto'];
    $fornecedoresPost['telefone'][] = $linha['telefone_pessoa_contacto'];
    $fornecedoresPost['observacoes'][] = $linha['observacoes'];
}

$localizacaoAtual = $metodoPost ? ($_POST['localizacao'] ?? '') : $equipamento->localizacao_id;

$temDocGarantiaAtual = $metodoPost ? ($_POST['tem_documentacao_garantia'] ?? '') : ($docGarantia ? 'sim' : 'nao');

$contratoManutencaoAtual = $metodoPost ? ($_POST['contratoManutencao'] ?? '') : $temContratoManutencaoBD;
$tipoContratoAtual = $metodoPost ? ($_POST['tipoContrato'] ?? '') : $contratoBD->tipo_contrato_id;
$entidadeResponsavelAtual = $metodoPost ? ($_POST['entidadeResponsavelContrato'] ?? '') : $contratoBD->entidade_responsavel;
$periodicidadeContratoAtual = $metodoPost ? ($_POST['periodicidadeContrato'] ?? '') : $contratoBD->periodicidade_id;
$observacoesContratoAtual = $metodoPost ? ($_POST['observacoesContrato'] ?? '') : ($contratoBD->observacoes ?? '');

$temDocCertificadoContratoAtual = $metodoPost ? ($_POST['tem_documentacao_contrato'] ?? '') : ($docCertificadoContrato ? 'sim' : 'nao');
$temRelatorioManutencaoAtual = $metodoPost ? ($_POST['tem_relatorio_contrato'] ?? '') : ($docRelatorioManutencao ? 'sim' : 'nao');
$temDocCalibracaoAtual = $metodoPost ? ($_POST['tem_documentacao_calibracao'] ?? '') : ($docCertificadoCalibracao ? 'sim' : 'nao');
$temRelatorioCalibracaoAtual = $metodoPost ? ($_POST['tem_relatorio_calibracao'] ?? '') : ($docRelatorioCalibracao ? 'sim' : 'nao');
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- ============================================================ -->
    <!-- Formulário de edição do equipamento (multi-separador) -->
    <!-- ============================================================ -->
    <main class="conteudo-privado">

        <section class="formulario-privado">

            <div class="cabecalho-formulario-privado">
                <h1>
                    <i class="fa-solid fa-pen-to-square"></i>
                    Editar equipamento
                </h1>
            </div>

            <hr>

            <form id="form-editar-equipamento" class="form-equipamento-privado" action="editar_equipamento.php?id_equipamento=<?= htmlspecialchars($idEquipamentoEncriptado) ?>" method="post" enctype="multipart/form-data" novalidate>

                <div class="tabs-consulta-equipamento">

                    <div class="botoes-tabs-equipamento">
                        <button type="button" class="botao-tab-equipamento ativo" data-tab="tab-identificacao">
                            <i class="fa-solid fa-stethoscope"></i>
                            Identificação
                        </button>
                        <button type="button" class="botao-tab-equipamento" data-tab="tab-acessorios-consumiveis">
                            <i class="fa-solid fa-toolbox"></i>
                            Acessórios e Consumíveis
                        </button>
                        <button type="button" class="botao-tab-equipamento" data-tab="tab-aquisicao">
                            <i class="fa-solid fa-cart-shopping"></i>
                            Aquisição
                        </button>
                        <button type="button" class="botao-tab-equipamento" data-tab="tab-novo-fornecedor">
                            <i class="fa-solid fa-truck-medical"></i>
                            Fornecedor
                        </button>
                        <button type="button" class="botao-tab-equipamento" data-tab="tab-nova-localizacao">
                            <i class="fa-solid fa-location-dot"></i>
                            Localização
                        </button>
                        <button type="button" class="botao-tab-equipamento" data-tab="tab-garantia">
                            <i class="fa-solid fa-shield-halved"></i>
                            Garantia
                        </button>
                        <button type="button" class="botao-tab-equipamento" data-tab="tab-contrato">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                            Contrato
                        </button>
                    </div>

                    <!-- Separador Identificação -->
                    <div id="tab-identificacao" class="conteudo-tab-equipamento ativo">

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-circle-info"></i>
                            Dados do Equipamento
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="codigo" class="form-label">Código interno de inventário</label>
                                <input type="text" class="form-control campo-formulario-privado" id="codigo"
                                    name="codigo" value="<?= htmlspecialchars($equipamento->codigo) ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="designacao" class="form-label">Designação do equipamento</label>
                                <input type="text" class="form-control campo-formulario-privado" id="designacao"
                                    name="designacao" value="<?= htmlspecialchars($metodoPost ? ($_POST['designacao'] ?? '') : $equipamento->designacao) ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="categoria" class="form-label">Categoria ou grupo
                                    <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
                                        data-bs-trigger="hover focus" data-bs-placement="right" data-bs-html="true"
                                        data-bs-content="
        <strong>Monitorização</strong> - Equipamentos utilizados para monitorizar parâmetros fisiológicos e o estado clínico do paciente.<br><br>
        <strong>Suporte de vida</strong> - Equipamentos essenciais para manter ou substituir funções vitais do organismo.<br><br>
        <strong>Terapia</strong> - Equipamentos utilizados na administração de tratamentos e intervenções terapêuticas.<br><br>
        <strong>Diagnóstico</strong> - Equipamentos destinados à deteção, avaliação e diagnóstico de condições clínicas.<br><br>
        <strong>Laboratório</strong> - Equipamentos utilizados na análise e processamento de amostras laboratoriais.<br><br>
        <strong>Esterilização</strong> - Equipamentos destinados à limpeza, desinfeção e esterilização de materiais e dispositivos médicos.<br><br>
        <strong>Reabilitação</strong> - Equipamentos utilizados na recuperação funcional e reabilitação dos pacientes.
        ">
                                    </i>
                                </label>
                                <select class="form-select campo-formulario-privado" id="categoria"
                                    name="categoria">
                                    <option value="" disabled <?= empty($categoriaAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                    <option <?= $categoriaAtual === 'Monitorização' ? 'selected' : '' ?>>Monitorização</option>
                                    <option <?= $categoriaAtual === 'Suporte de vida' ? 'selected' : '' ?>>Suporte de vida</option>
                                    <option <?= $categoriaAtual === 'Terapia' ? 'selected' : '' ?>>Terapia</option>
                                    <option <?= $categoriaAtual === 'Diagnóstico' ? 'selected' : '' ?>>Diagnóstico</option>
                                    <option <?= $categoriaAtual === 'Laboratório' ? 'selected' : '' ?>>Laboratório</option>
                                    <option <?= $categoriaAtual === 'Esterilização' ? 'selected' : '' ?>>Esterilização</option>
                                    <option <?= $categoriaAtual === 'Reabilitação' ? 'selected' : '' ?>>Reabilitação</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" class="form-control campo-formulario-privado" id="marca"
                                    name="marca" value="<?= htmlspecialchars($metodoPost ? ($_POST['marca'] ?? '') : $equipamento->marca) ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input type="text" class="form-control campo-formulario-privado" id="modelo"
                                    name="modelo" value="<?= htmlspecialchars($metodoPost ? ($_POST['modelo'] ?? '') : $equipamento->modelo) ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="numero_serie" class="form-label">N.º de série</label>
                                <input type="text" class="form-control campo-formulario-privado" id="numero_serie"
                                    name="numero_serie" value="<?= htmlspecialchars($metodoPost ? ($_POST['numero_serie'] ?? '') : $equipamento->numero_serie) ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="fabricante" class="form-label">Fabricante</label>
                                <input type="text" class="form-control campo-formulario-privado" id="fabricante"
                                    name="fabricante" value="<?= htmlspecialchars($metodoPost ? ($_POST['fabricante'] ?? '') : $equipamento->fabricante) ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="ano_fabrico" class="form-label">Ano de fabrico</label>
                                <input type="number" class="form-control campo-formulario-privado" id="ano_fabrico"
                                    name="ano_fabrico" value="<?= htmlspecialchars($metodoPost ? ($_POST['ano_fabrico'] ?? '') : $equipamento->ano_fabrico) ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">
                                    Estado atual
                                    <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
                                        data-bs-trigger="hover focus" data-bs-placement="right" data-bs-html="true"
                                        data-bs-content="
       <strong>Ativo</strong> - Equipamento operacional e disponível para utilização.<br><br>
       <strong>Em manutenção</strong> - Equipamento temporariamente indisponível devido a manutenção preventiva ou corretiva.<br><br>
       <strong>Inativo</strong> - Equipamento sem utilização atual, mas disponível para voltar ao serviço.<br><br>
       <strong>Em calibração</strong> - Equipamento em processo de calibração ou verificação metrológica.<br><br>
       <strong>Em quarentena</strong> - Equipamento isolado temporariamente para avaliação, descontaminação ou validação técnica.<br><br>
       <strong>Abatido</strong> - Equipamento retirado definitivamente de serviço e sem possibilidade de utilização.
       ">
                                    </i>
                                </label>
                                <select class="form-select campo-formulario-privado" id="estado" name="estado">
                                    <option value="" disabled <?= empty($estadoAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                    <option <?= $estadoAtual === 'Ativo' ? 'selected' : '' ?>>Ativo</option>
                                    <option <?= $estadoAtual === 'Em manutenção' ? 'selected' : '' ?>>Em manutenção</option>
                                    <option <?= $estadoAtual === 'Inativo' ? 'selected' : '' ?>>Inativo</option>
                                    <option <?= $estadoAtual === 'Em calibração' ? 'selected' : '' ?>>Em calibração</option>
                                    <option <?= $estadoAtual === 'Em quarentena' ? 'selected' : '' ?>>Em quarentena</option>
                                    <option <?= $estadoAtual === 'Abatido' ? 'selected' : '' ?>>Abatido</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="criticidade" class="form-label">Criticidade
                                    <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
                                        data-bs-trigger="hover focus" data-bs-placement="right" data-bs-html="true"
                                        data-bs-content="
        <strong>Suporte de vida</strong> - Equipamento essencial para manter ou monitorizar funções vitais do paciente.<br><br>
        <strong>Alta</strong> - Equipamento cuja indisponibilidade afeta significativamente a prestação de cuidados de saúde.<br><br>
        <strong>Média</strong> - Equipamento importante, mas cuja indisponibilidade pode ser temporariamente compensada por alternativas.<br><br>
        <strong>Baixa</strong> - Equipamento de apoio com impacto reduzido na prestação de cuidados.
        ">
                                    </i>
                                </label>
                                <select class="form-select campo-formulario-privado" id="criticidade"
                                    name="criticidade">
                                    <option value="" disabled <?= empty($criticidadeAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                    <option <?= $criticidadeAtual === 'Baixa' ? 'selected' : '' ?>>Baixa</option>
                                    <option <?= $criticidadeAtual === 'Média' ? 'selected' : '' ?>>Média</option>
                                    <option <?= $criticidadeAtual === 'Alta' ? 'selected' : '' ?>>Alta</option>
                                    <option <?= $criticidadeAtual === 'Suporte de vida' ? 'selected' : '' ?>>Suporte de vida</option>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-file-medical"></i>
                            Documentação Técnica
                        </h5>

                        <div class="grupo-campo-privado grupo-campo-total">
                            <label for="tem_documentacao_tecnica">Existe documentação técnica associada?</label>
                            <select id="tem_documentacao_tecnica" name="tem_documentacao_tecnica" class="campo-formulario-privado">
                                <option value="" disabled <?= empty($temDocTecnicaAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temDocTecnicaAtual === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temDocTecnicaAtual === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <div id="bloco-documentacao-tecnica" style="<?= $temDocTecnicaAtual === 'sim' ? '' : 'display:none' ?>">
                            <div class="card-documentacao">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tipo de documento</label>
                                        <input type="text" class="form-control campo-formulario-privado"
                                            value="Manual de Serviço" readonly>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Nome do documento</label>
                                        <input type="text" id="nomeManualTecnico" name="nomeManualTecnico"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['nomeManualTecnico'] ?? '') : ($docTecnica->nome_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataManualTecnico" name="dataManualTecnico"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['dataManualTecnico'] ?? '') : ($docTecnica->data_documento ?? '')) ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeManualTecnico" name="validadeManualTecnico"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['validadeManualTecnico'] ?? '') : ($docTecnica->validade_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroManualTecnico" name="ficheiroManualTecnico"
                                            accept=".pdf" class="form-control campo-formulario-privado">
                                        <?php if (!empty($docTecnica->nome_original_ficheiro)) : ?>
                                            <small class="form-text text-muted">Ficheiro atual: <?= htmlspecialchars($docTecnica->nome_original_ficheiro) ?> (só é substituído se escolheres um novo)</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-book-open"></i>
                            Documentação de Utilização
                        </h5>

                        <div class="grupo-campo-privado grupo-campo-total">
                            <label for="tem_documentacao_utilizacao">Existe documentação de utilização
                                associada?</label>
                            <select id="tem_documentacao_utilizacao" name="tem_documentacao_utilizacao" class="campo-formulario-privado">
                                <option value="" disabled <?= empty($temDocUtilizacaoAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temDocUtilizacaoAtual === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temDocUtilizacaoAtual === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <div id="bloco-documentacao-utilizacao" style="<?= $temDocUtilizacaoAtual === 'sim' ? '' : 'display:none' ?>">
                            <div class="card-documentacao">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tipo de documento</label>
                                        <input type="text" class="form-control campo-formulario-privado"
                                            value="Manual de Utilização" readonly>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Nome do documento</label>
                                        <input type="text" id="nomeManualUtilizacao" name="nomeManualUtilizacao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['nomeManualUtilizacao'] ?? '') : ($docUtilizacao->nome_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataManualUtilizacao" name="dataManualUtilizacao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['dataManualUtilizacao'] ?? '') : ($docUtilizacao->data_documento ?? '')) ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeManualUtilizacao"
                                            name="validadeManualUtilizacao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['validadeManualUtilizacao'] ?? '') : ($docUtilizacao->validade_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroManualUtilizacao"
                                            name="ficheiroManualUtilizacao" accept=".pdf"
                                            class="form-control campo-formulario-privado">
                                        <?php if (!empty($docUtilizacao->nome_original_ficheiro)) : ?>
                                            <small class="form-text text-muted">Ficheiro atual: <?= htmlspecialchars($docUtilizacao->nome_original_ficheiro) ?> (só é substituído se escolheres um novo)</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-certificate"></i>
                            Documentação de Conformidade
                        </h5>

                        <div class="grupo-campo-privado grupo-campo-total">
                            <label for="tem_declaracao_conformidade">
                                Existe documentação de conformidade associada?
                            </label>
                            <select id="tem_declaracao_conformidade" name="tem_declaracao_conformidade" class="campo-formulario-privado">
                                <option value="" disabled <?= empty($temDeclConformidadeAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temDeclConformidadeAtual === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temDeclConformidadeAtual === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <div id="bloco-declaracao-conformidade" style="<?= $temDeclConformidadeAtual === 'sim' ? '' : 'display:none' ?>">
                            <div class="card-documentacao">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tipo de documento</label>
                                        <input type="text" class="form-control campo-formulario-privado"
                                            value="Documentação de Conformidade" readonly>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Nome do documento</label>
                                        <input type="text" id="nomeDeclaracaoConformidade"
                                            name="nomeDeclaracaoConformidade"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['nomeDeclaracaoConformidade'] ?? '') : ($docConformidade->nome_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataDeclaracaoConformidade"
                                            name="dataDeclaracaoConformidade"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['dataDeclaracaoConformidade'] ?? '') : ($docConformidade->data_documento ?? '')) ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeDeclaracaoConformidade"
                                            name="validadeDeclaracaoConformidade"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['validadeDeclaracaoConformidade'] ?? '') : ($docConformidade->validade_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroDeclaracaoConformidade"
                                            name="ficheiroDeclaracaoConformidade" accept=".pdf"
                                            class="form-control campo-formulario-privado">
                                        <?php if (!empty($docConformidade->nome_original_ficheiro)) : ?>
                                            <small class="form-text text-muted">Ficheiro atual: <?= htmlspecialchars($docConformidade->nome_original_ficheiro) ?> (só é substituído se escolheres um novo)</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-comment-medical"></i>
                            Observações do Equipamento
                        </h5>

                        <div class="mb-4">
                            <textarea id="observacoes" name="observacoes" rows="6"
                                class="form-control campo-formulario-privado"
                                placeholder="Informações adicionais relevantes sobre o equipamento..."><?= htmlspecialchars($metodoPost ? ($_POST['observacoes'] ?? '') : ($equipamento->observacoes ?? '')) ?></textarea>
                        </div>

                        <?php if (!empty($erros)) : ?>
                            <div id="erros-separador-1" class="erros-separador alert alert-danger text-center">
                                <?php foreach ($erros as $erro) : ?>
                                    <div><?= htmlspecialchars($erro) ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="botoes-formulario-privado">
                            <a id="botao-cancelar-edicao" href="equipamentos.php" class="botao-cancelar-privado">
                                <i class="fa-solid fa-xmark"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="botao-guardar-privado">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Guardar alterações
                            </button>
                        </div>

                    </div>

                    <!-- Separador Acessórios e Consumíveis -->
                    <div id="tab-acessorios-consumiveis" class="conteudo-tab-equipamento">

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-toolbox"></i> Acessórios
                        </h5>

                        <div class="mb-4">
                            <table class="tabela-itens w-100 mb-2" id="tabela-acessorios">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Referência</th>
                                        <th>Qtd.</th>
                                        <th>Unidade</th>
                                        <th>Estado</th>
                                        <th>Observações</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-acessorios"></tbody>
                            </table>

                            <button type="button" class="botao-adicionar-item"
                                onclick="adicionarItem('acessorios')">
                                <i class="fa-solid fa-plus"></i>
                                Adicionar acessório
                            </button>

                            <div class="resumo-itens mt-2" id="resumo-acessorios"></div>
                        </div>

                        <hr>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-box-open"></i> Consumíveis
                        </h5>

                        <div class="mb-4">
                            <table class="tabela-itens w-100 mb-2" id="tabela-consumiveis">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Referência</th>
                                        <th>Qtd.</th>
                                        <th>Unidade</th>
                                        <th>Estado</th>
                                        <th>Observações</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-consumiveis"></tbody>
                            </table>

                            <button type="button" class="botao-adicionar-item"
                                onclick="adicionarItem('consumiveis')">
                                <i class="fa-solid fa-plus"></i>
                                Adicionar consumível
                            </button>

                            <div class="resumo-itens mt-2" id="resumo-consumiveis"></div>
                        </div>

                        <div id="erros-separador-2" class="erros-separador" style="display:none;">
                            <ul id="lista-erros-separador-2"></ul>
                        </div>

                        <div class="acoes-formulario-privado">
                            <a href="equipamentos.php" class="botao-cancelar-privado">
                                <i class="fa-solid fa-xmark"></i>
                                Cancelar
                            </a>

                            <button type="submit" class="botao-guardar-privado">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Guardar alterações
                            </button>
                        </div>

                    </div>

                    <!-- Separador Aquisição -->
                    <div id="tab-aquisicao" class="conteudo-tab-equipamento">

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-cart-shopping"></i>
                            Dados de Aquisição do equipamento
                        </h5>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="data_aquisicao" class="form-label">Data de aquisição</label>
                                <input type="date" class="form-control campo-formulario-privado" id="data_aquisicao"
                                    name="data_aquisicao" value="<?= htmlspecialchars($metodoPost ? ($_POST['data_aquisicao'] ?? '') : $aquisicaoBD->data_aquisicao) ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="custo_aquisicao" class="form-label">Custo de aquisição (€)</label>
                                <input type="number" step="0.01" class="form-control campo-formulario-privado"
                                    id="custo_aquisicao" name="custo_aquisicao" value="<?= htmlspecialchars($metodoPost ? ($_POST['custo_aquisicao'] ?? '') : $aquisicaoBD->custo_aquisicao) ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tipo_entrada" class="form-label">Tipo de entrada
                                    <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
                                        data-bs-trigger="hover focus" data-bs-placement="right" data-bs-html="true"
                                        data-bs-content="
        <strong>Compra</strong> - Equipamento adquirido pela instituição através de compra direta.<br><br>
        <strong>Doação</strong> - Equipamento recebido sem custos por oferta de uma entidade ou particular.<br><br>
        <strong>Aluguer</strong> - Equipamento utilizado mediante pagamento periódico durante um período definido.<br><br>
        <strong>Empréstimo</strong> - Equipamento cedido temporariamente por outra entidade para utilização durante um período acordado.
        ">
                                    </i>
                                </label>
                                <select class="form-select campo-formulario-privado" id="tipo_entrada"
                                    name="tipo_entrada">
                                    <option value="" disabled <?= empty($tipoEntradaAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                    <option <?= $tipoEntradaAtual === 'Compra' ? 'selected' : '' ?>>Compra</option>
                                    <option <?= $tipoEntradaAtual === 'Doação' ? 'selected' : '' ?>>Doação</option>
                                    <option <?= $tipoEntradaAtual === 'Aluguer' ? 'selected' : '' ?>>Aluguer</option>
                                    <option <?= $tipoEntradaAtual === 'Empréstimo' ? 'selected' : '' ?>>Empréstimo</option>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-file-invoice"></i>
                            Documentação de Aquisição do equipamento
                        </h5>

                        <div class="grupo-campo-privado">
                            <label for="tem_contrato_aquisicao">Existe contrato de aquisição associado?</label>
                            <select id="tem_contrato_aquisicao" name="tem_contrato_aquisicao" class="campo-formulario-privado">
                                <option value="" disabled <?= empty($temContratoAquisicaoAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temContratoAquisicaoAtual === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temContratoAquisicaoAtual === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <div id="bloco-contrato-aquisicao" style="<?= $temContratoAquisicaoAtual === 'sim' ? '' : 'display:none' ?>">
                            <div class="card-documentacao">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tipo de documento</label>
                                        <input type="text" class="form-control campo-formulario-privado"
                                            value="Contrato de Aquisição" readonly>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Nome do documento</label>
                                        <input type="text" id="nomeContratoAquisicao" name="nomeContratoAquisicao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['nomeContratoAquisicao'] ?? '') : ($docContratoAquisicao->nome_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data do documento</label>
                                        <input type="date" id="dataContratoAquisicao" name="dataContratoAquisicao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['dataContratoAquisicao'] ?? '') : ($docContratoAquisicao->data_documento ?? '')) ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeContratoAquisicao"
                                            name="validadeContratoAquisicao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['validadeContratoAquisicao'] ?? '') : ($docContratoAquisicao->validade_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroContratoAquisicao"
                                            name="ficheiroContratoAquisicao" accept=".pdf"
                                            class="form-control campo-formulario-privado">
                                        <?php if (!empty($docContratoAquisicao->nome_original_ficheiro)) : ?>
                                            <small class="form-text text-muted">Ficheiro atual: <?= htmlspecialchars($docContratoAquisicao->nome_original_ficheiro) ?> (só é substituído se escolheres um novo)</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-receipt"></i>
                            Fatura da aquisição
                        </h5>

                        <div class="grupo-campo-privado">
                            <label for="tem_fatura">Existe fatura associada?</label>
                            <select id="tem_fatura" name="tem_fatura" class="campo-formulario-privado">
                                <option value="" disabled <?= empty($temFaturaAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temFaturaAtual === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temFaturaAtual === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <div id="bloco-fatura" style="<?= $temFaturaAtual === 'sim' ? '' : 'display:none' ?>">
                            <div class="card-documentacao">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tipo de documento</label>
                                        <input type="text" class="form-control campo-formulario-privado"
                                            value="Fatura" readonly>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Nome do documento</label>
                                        <input type="text" id="nomeFatura" name="nomeFatura"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['nomeFatura'] ?? '') : ($docFatura->nome_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data do documento</label>
                                        <input type="date" id="dataFatura" name="dataFatura"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['dataFatura'] ?? '') : ($docFatura->data_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroFatura" name="ficheiroFatura" accept=".pdf"
                                            class="form-control campo-formulario-privado">
                                        <?php if (!empty($docFatura->nome_original_ficheiro)) : ?>
                                            <small class="form-text text-muted">Ficheiro atual: <?= htmlspecialchars($docFatura->nome_original_ficheiro) ?> (só é substituído se escolheres um novo)</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-comment-medical"></i>
                            Observações da aquisição do equipamento
                        </h5>

                        <div class="mb-4">
                            <textarea id="observacoesAquisicao" name="observacoesAquisicao" rows="6"
                                class="form-control campo-formulario-privado"
                                placeholder="Informações adicionais relevantes sobre a aquisição do equipamento..."><?= htmlspecialchars($metodoPost ? ($_POST['observacoesAquisicao'] ?? '') : ($aquisicaoBD->observacoes ?? '')) ?></textarea>
                        </div>

                        <div id="erros-separador-3" class="erros-separador" style="display:none;">
                            <ul id="lista-erros-separador-3"></ul>
                        </div>

                        <div class="acoes-formulario-privado">
                            <a href="equipamentos.php" class="botao-cancelar-privado">
                                <i class="fa-solid fa-xmark"></i> Cancelar
                            </a>
                            <button type="submit" class="botao-guardar-privado">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Guardar alterações
                            </button>
                        </div>

                    </div>

                    <!-- Separador Fornecedor -->
                    <div id="tab-novo-fornecedor" class="conteudo-tab-equipamento">

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-truck-medical"></i>
                            Fornecedores Associados
                        </h5>

                        <table class="tabela-itens w-100 mb-2" id="tabela-fornecedores-equipamento">
                            <thead>
                                <tr>
                                    <th>Fornecedor</th>
                                    <th>Morada</th>
                                    <th>Pessoa de contacto</th>
                                    <th>Telefone da pessoa de contacto</th>
                                    <th>Observações</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tbody-fornecedores-equipamento"></tbody>
                        </table>

                        <button type="button" class="botao-adicionar-item"
                            onclick="adicionarFornecedorEquipamento()">
                            <i class="fa-solid fa-plus"></i> Adicionar fornecedor
                        </button>
                        <div class="resumo-itens mt-2" id="resumo-fornecedores"></div>

                        <input type="hidden" id="fornecedor" name="fornecedor">
                        <input type="hidden" id="nomeFornecedor" name="nomeFornecedor">
                        <input type="hidden" id="nifFornecedor" name="nifFornecedor">
                        <input type="hidden" id="telefoneFornecedor" name="telefoneFornecedor">
                        <input type="hidden" id="emailFornecedor" name="emailFornecedor">
                        <input type="hidden" id="websiteFornecedor" name="websiteFornecedor">
                        <input type="hidden" id="moradaFornecedorEquipamento" name="moradaFornecedorEquipamento">
                        <input type="hidden" id="pessoaContactoFornecedor" name="pessoaContactoFornecedor">
                        <input type="hidden" id="telefonePessoaContactoFornecedor"
                            name="telefonePessoaContactoFornecedor">
                        <input type="hidden" id="tipoFornecedorEquipamento" name="tipoFornecedorEquipamento">

                        <div id="erros-separador-4" class="erros-separador" style="display:none;">
                            <ul id="lista-erros-separador-4"></ul>
                        </div>

                        <div class="acoes-formulario-privado">
                            <a href="equipamentos.php" class="botao-cancelar-privado">
                                <i class="fa-solid fa-xmark"></i> Cancelar
                            </a>
                            <button type="submit" class="botao-guardar-privado">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Guardar alterações
                            </button>
                        </div>

                    </div>

                    <!-- Separador Localização -->
                    <div id="tab-nova-localizacao" class="conteudo-tab-equipamento">

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-location-dot"></i>
                            Localização Associada
                        </h5>

                        <div class="row">
                            <div class="grupo-campo-privado grupo-campo-total">
                                <label for="localizacao">Localização associada</label>
                                <select id="localizacao" name="localizacao"
                                    class="form-select campo-formulario-privado">
                                    <option value="" disabled <?= empty($localizacaoAtual) ? 'selected' : '' ?>>Escolha uma localização</option>
                                    <?php foreach ($localizacoesBD as $loc) : ?>
                                        <option value="<?= $loc['id'] ?>" <?= (string)$localizacaoAtual === (string)$loc['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($loc['codigo'] . ' — ' . $loc['edificio'] . ', ' . $loc['piso'] . ', ' . $loc['servico'] . ', ' . $loc['sala']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small>Selecione uma localização previamente registada.</small>
                            </div>

                            <hr>

                            <h5 class="subtitulo-separador titulo-azul-separador">
                                <i class="fa-solid fa-comment-medical"></i>
                                Observações da localização associada
                            </h5>

                            <div class="mb-4">
                                <textarea id="observacoesLocalizacao" name="observacoesLocalizacao"
                                    class="form-control campo-formulario-privado" rows="6"
                                    placeholder="Escreva observações específicas sobre a localização deste equipamento"><?= htmlspecialchars($metodoPost ? ($_POST['observacoesLocalizacao'] ?? '') : ($equipamento->observacoes_localizacao ?? '')) ?></textarea>
                            </div>
                        </div>

                        <div id="erros-separador-5" class="erros-separador" style="display:none;">
                            <ul id="lista-erros-separador-5"></ul>
                        </div>

                        <div class="acoes-formulario-privado">
                            <a href="equipamentos.php" class="botao-cancelar-privado">
                                <i class="fa-solid fa-xmark"></i> Cancelar
                            </a>
                            <button type="submit" class="botao-guardar-privado">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Guardar alterações
                            </button>
                        </div>

                    </div>

                    <!-- Separador Garantia -->
                    <div id="tab-garantia" class="conteudo-tab-equipamento">

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-shield-halved"></i>
                            Dados da Garantia
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dataInicioGarantia" class="form-label">Data de início da
                                    garantia</label>
                                <input type="date" id="dataInicioGarantia" name="dataInicioGarantia"
                                    class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['dataInicioGarantia'] ?? '') : ($garantiaBD->data_inicio ?? '')) ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dataFimGarantia" class="form-label">Data de fim da garantia</label>
                                <input type="date" id="dataFimGarantia" name="dataFimGarantia"
                                    class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['dataFimGarantia'] ?? '') : ($garantiaBD->data_fim ?? '')) ?>">
                            </div>
                        </div>

                        <hr>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-file-medical"></i>
                            Documentação de garantia
                        </h5>

                        <div class="grupo-campo-privado grupo-campo-total">
                            <label for="tem_documentacao_garantia">Existe certificado de garantia associado?</label>
                            <select id="tem_documentacao_garantia" name="tem_documentacao_garantia" class="campo-formulario-privado">
                                <option value="" disabled <?= empty($temDocGarantiaAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temDocGarantiaAtual === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temDocGarantiaAtual === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <div id="bloco-documentacao-garantia" style="<?= $temDocGarantiaAtual === 'sim' ? '' : 'display:none' ?>">
                            <div class="card-documentacao">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tipo de documento</label>
                                        <input type="text" class="form-control campo-formulario-privado"
                                            value="Certificado de garantia" readonly>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Nome do documento</label>
                                        <input type="text" id="nomeCertificadoGarantia"
                                            name="nomeCertificadoGarantia"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['nomeCertificadoGarantia'] ?? '') : ($docGarantia->nome_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataCertificadoGarantia"
                                            name="dataCertificadoGarantia"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['dataCertificadoGarantia'] ?? '') : ($docGarantia->data_documento ?? '')) ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeCertificadoGarantia"
                                            name="validadeCertificadoGarantia"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['validadeCertificadoGarantia'] ?? '') : ($docGarantia->validade_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroCertificadoGarantia"
                                            name="ficheiroCertificadoGarantia" accept=".pdf"
                                            class="form-control campo-formulario-privado">
                                        <?php if (!empty($docGarantia->nome_original_ficheiro)) : ?>
                                            <small class="form-text text-muted">Ficheiro atual: <?= htmlspecialchars($docGarantia->nome_original_ficheiro) ?> (só é substituído se escolheres um novo)</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-comment-medical"></i>
                            Observações da garantia
                        </h5>

                        <div class="grupo-campo-privado">
                            <textarea id="observacoesGarantia" name="observacoesGarantia"
                                class="campo-formulario-privado" rows="4"
                                placeholder="Escreva observações específicas sobre a garantia deste equipamento"><?= htmlspecialchars($metodoPost ? ($_POST['observacoesGarantia'] ?? '') : ($garantiaBD->observacoes ?? '')) ?></textarea>
                        </div>

                        <div id="erros-separador-6" class="erros-separador" style="display:none;">
                            <ul id="lista-erros-separador-6"></ul>
                        </div>

                        <div class="acoes-formulario-privado">
                            <a href="equipamentos.php" class="botao-cancelar-privado">
                                <i class="fa-solid fa-xmark"></i> Cancelar
                            </a>
                            <button type="submit" class="botao-guardar-privado">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Guardar alterações
                            </button>
                        </div>

                    </div>

                    <!-- Separador Contrato -->
                    <div id="tab-contrato" class="conteudo-tab-equipamento">

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                            Contrato de Manutenção
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contratoManutencao" class="form-label">Contrato de manutenção</label>
                                <select id="contratoManutencao" name="contratoManutencao" class="form-select campo-formulario-privado">
                                    <option value="" disabled <?= empty($contratoManutencaoAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                    <option value="sim" <?= $contratoManutencaoAtual === 'sim' ? 'selected' : '' ?>>Sim</option>
                                    <option value="nao" <?= $contratoManutencaoAtual === 'nao' ? 'selected' : '' ?>>Não</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tipoContrato" class="form-label">Tipo de contrato</label>
                                <select id="tipoContrato" name="tipoContrato" class="form-select campo-formulario-privado">
                                    <?php if ($contratoManutencaoAtual === 'nao') : ?>
                                        <option value="" selected>Não existe</option>
                                    <?php else : ?>
                                        <option value="" disabled <?= empty($tipoContratoAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                        <?php foreach ($tiposContratoBD as $tipo) : ?>
                                            <option value="<?= $tipo['id'] ?>" <?= (string)$tipoContratoAtual === (string)$tipo['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($tipo['designacao']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="entidadeResponsavelContrato" class="form-label">Entidade
                                    responsável</label>
                                <input type="text" id="entidadeResponsavelContrato" name="entidadeResponsavelContrato"
                                    class="form-control campo-formulario-privado"
                                    placeholder="Ex.: Philips Healthcare"
                                    value="<?= $contratoManutencaoAtual === 'nao' ? 'Não existe' : htmlspecialchars($entidadeResponsavelAtual) ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="periodicidadeContrato" class="form-label">Periodicidade</label>
                                <select id="periodicidadeContrato" name="periodicidadeContrato" class="form-select campo-formulario-privado">
                                    <?php if ($contratoManutencaoAtual === 'nao') : ?>
                                        <option value="" selected>Não aplicável</option>
                                    <?php else : ?>
                                        <option value="" disabled <?= empty($periodicidadeContratoAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                        <?php foreach ($periodicidadesBD as $periodicidade) : ?>
                                            <option value="<?= $periodicidade['id'] ?>" <?= (string)$periodicidadeContratoAtual === (string)$periodicidade['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($periodicidade['designacao']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-file-medical"></i>
                            Documentação do contrato
                        </h5>

                        <div class="grupo-campo-privado">
                            <label for="tem_documentacao_contrato">Existe contrato de manutenção associado?</label>
                            <select id="tem_documentacao_contrato" name="tem_documentacao_contrato" class="campo-formulario-privado">
                                <option value="" disabled <?= empty($temDocCertificadoContratoAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temDocCertificadoContratoAtual === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temDocCertificadoContratoAtual === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <div id="bloco-documentacao-contrato" style="<?= $temDocCertificadoContratoAtual === 'sim' ? '' : 'display:none' ?>">
                            <div class="card-documentacao">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tipo de documento</label>
                                        <input type="text" class="form-control campo-formulario-privado"
                                            value="Contrato de manutenção" readonly>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Nome do documento</label>
                                        <input type="text" id="nomeCertificadoContrato" name="nomeCertificadoContrato"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['nomeCertificadoContrato'] ?? '') : ($docCertificadoContrato->nome_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataContratoManutencao" name="dataContratoManutencao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['dataContratoManutencao'] ?? '') : ($docCertificadoContrato->data_documento ?? '')) ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeContratoManutencao"
                                            name="validadeContratoManutencao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['validadeContratoManutencao'] ?? '') : ($docCertificadoContrato->validade_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroContratoManutencao"
                                            name="ficheiroContratoManutencao" accept=".pdf"
                                            class="form-control campo-formulario-privado">
                                        <?php if (!empty($docCertificadoContrato->nome_original_ficheiro)) : ?>
                                            <small class="form-text text-muted">Ficheiro atual: <?= htmlspecialchars($docCertificadoContrato->nome_original_ficheiro) ?> (só é substituído se escolheres um novo)</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grupo-campo-privado" style="margin-top: 1.2rem;">
                            <label for="tem_relatorio_contrato">Existe relatório de manutenção associado?</label>
                            <select id="tem_relatorio_contrato" name="tem_relatorio_contrato" class="campo-formulario-privado">
                                <option value="" disabled <?= empty($temRelatorioManutencaoAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temRelatorioManutencaoAtual === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temRelatorioManutencaoAtual === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <div id="bloco-relatorio-contrato" style="<?= $temRelatorioManutencaoAtual === 'sim' ? '' : 'display:none' ?>">
                            <div class="card-documentacao">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tipo de documento</label>
                                        <input type="text" class="form-control campo-formulario-privado"
                                            value="Relatório de manutenção" readonly>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Nome do documento</label>
                                        <input type="text" id="nomeRelatorioManutencao"
                                            name="nomeRelatorioManutencao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['nomeRelatorioManutencao'] ?? '') : ($docRelatorioManutencao->nome_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataRelatorioManutencao"
                                            name="dataRelatorioManutencao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['dataRelatorioManutencao'] ?? '') : ($docRelatorioManutencao->data_documento ?? '')) ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeRelatorioManutencao"
                                            name="validadeRelatorioManutencao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['validadeRelatorioManutencao'] ?? '') : ($docRelatorioManutencao->validade_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroRelatorioManutencao"
                                            name="ficheiroRelatorioManutencao" accept=".pdf"
                                            class="form-control campo-formulario-privado">
                                        <?php if (!empty($docRelatorioManutencao->nome_original_ficheiro)) : ?>
                                            <small class="form-text text-muted">Ficheiro atual: <?= htmlspecialchars($docRelatorioManutencao->nome_original_ficheiro) ?> (só é substituído se escolheres um novo)</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-book-open"></i>
                            Documentação de calibração
                        </h5>

                        <div class="grupo-campo-privado">
                            <label for="tem_documentacao_calibracao">Existe certificado de calibração
                                associado?</label>
                            <select id="tem_documentacao_calibracao" name="tem_documentacao_calibracao" class="campo-formulario-privado">
                                <option value="" disabled <?= empty($temDocCalibracaoAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temDocCalibracaoAtual === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temDocCalibracaoAtual === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <div id="bloco-documentacao-calibracao" style="<?= $temDocCalibracaoAtual === 'sim' ? '' : 'display:none' ?>">
                            <div class="card-documentacao">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tipo de documento</label>
                                        <input type="text" class="form-control campo-formulario-privado"
                                            value="Certificado de calibração" readonly>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Nome do documento</label>
                                        <input type="text" id="nomeCertificadoCalibracao"
                                            name="nomeCertificadoCalibracao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['nomeCertificadoCalibracao'] ?? '') : ($docCertificadoCalibracao->nome_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataCertificadoCalibracao"
                                            name="dataCertificadoCalibracao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['dataCertificadoCalibracao'] ?? '') : ($docCertificadoCalibracao->data_documento ?? '')) ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeCertificadoCalibracao"
                                            name="validadeCertificadoCalibracao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['validadeCertificadoCalibracao'] ?? '') : ($docCertificadoCalibracao->validade_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroCertificadoCalibracao"
                                            name="ficheiroCertificadoCalibracao" accept=".pdf"
                                            class="form-control campo-formulario-privado">
                                        <?php if (!empty($docCertificadoCalibracao->nome_original_ficheiro)) : ?>
                                            <small class="form-text text-muted">Ficheiro atual: <?= htmlspecialchars($docCertificadoCalibracao->nome_original_ficheiro) ?> (só é substituído se escolheres um novo)</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grupo-campo-privado" style="margin-top: 1.2rem;">
                            <label for="tem_relatorio_calibracao">Existe relatório de calibração associado?</label>
                            <select id="tem_relatorio_calibracao" name="tem_relatorio_calibracao" class="campo-formulario-privado">
                                <option value="" disabled <?= empty($temRelatorioCalibracaoAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temRelatorioCalibracaoAtual === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temRelatorioCalibracaoAtual === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <div id="bloco-relatorio-calibracao" style="<?= $temRelatorioCalibracaoAtual === 'sim' ? '' : 'display:none' ?>">
                            <div class="card-documentacao">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tipo de documento</label>
                                        <input type="text" class="form-control campo-formulario-privado"
                                            value="Relatório de calibração" readonly>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Nome do documento</label>
                                        <input type="text" id="nomeRelatorioCalibracao"
                                            name="nomeRelatorioCalibracao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['nomeRelatorioCalibracao'] ?? '') : ($docRelatorioCalibracao->nome_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataRelatorioCalibracao"
                                            name="dataRelatorioCalibracao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['dataRelatorioCalibracao'] ?? '') : ($docRelatorioCalibracao->data_documento ?? '')) ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeRelatorioCalibracao"
                                            name="validadeRelatorioCalibracao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($metodoPost ? ($_POST['validadeRelatorioCalibracao'] ?? '') : ($docRelatorioCalibracao->validade_documento ?? '')) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroRelatorioCalibracao"
                                            name="ficheiroRelatorioCalibracao" accept=".pdf"
                                            class="form-control campo-formulario-privado">
                                        <?php if (!empty($docRelatorioCalibracao->nome_original_ficheiro)) : ?>
                                            <small class="form-text text-muted">Ficheiro atual: <?= htmlspecialchars($docRelatorioCalibracao->nome_original_ficheiro) ?> (só é substituído se escolheres um novo)</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-comment-medical"></i>
                            Observações do contrato
                        </h5>

                        <div class="mb-4">
                            <textarea id="observacoesContrato" name="observacoesContrato" rows="6"
                                class="form-control campo-formulario-privado"
                                placeholder="Informações adicionais relevantes sobre o contrato do equipamento..."><?= htmlspecialchars($observacoesContratoAtual) ?></textarea>
                        </div>

                        <div id="erros-separador-7" class="erros-separador" style="display:none;">
                            <ul id="lista-erros-separador-7"></ul>
                        </div>

                        <div class="acoes-formulario-privado">
                            <a href="equipamentos.php" class="botao-cancelar-privado">
                                <i class="fa-solid fa-xmark"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="botao-guardar-privado">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Guardar alterações
                            </button>
                        </div>

                    </div>

                </div>

            </form>

        </section>

    </main>

</div>

<!-- ============================================================ -->
<!-- Script JavaScript da página -->
<!-- ============================================================ -->
<script>
    const UNIDADES_BD = <?= json_encode($unidadesBD) ?>;
    const ESTADOS_ACESSORIO_BD = <?= json_encode($estadosAcessorioBD) ?>;
    const ACESSORIOS_ATUAIS = <?= json_encode($acessoriosAtuais) ?>;
    const CONSUMIVEIS_ATUAIS = <?= json_encode($consumiveisAtuais) ?>;
    const FORNECEDORES_BD = <?= json_encode($fornecedoresBD) ?>;
    const MORADAS_BD = <?= json_encode($moradasBD) ?>;
    const FORNECEDORES_POST = <?= json_encode($metodoPost ? ($_POST['fornecedores'] ?? null) : $fornecedoresPost) ?>;
    const TIPOS_CONTRATO_BD = <?= json_encode($tiposContratoBD) ?>;
    const PERIODICIDADES_BD = <?= json_encode($periodicidadesBD) ?>;
</script>

<?php include '../../includes/footer.php'; ?>

<script>
    ACESSORIOS_ATUAIS.forEach(function (item) {
        adicionarItem('acessorios', item);
    });

    CONSUMIVEIS_ATUAIS.forEach(function (item) {
        adicionarItem('consumiveis', item);
    });
</script>