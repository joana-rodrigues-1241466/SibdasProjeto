<?php
// ============================================================
// NOVO_EQUIPAMENTO.PHP
// Formulário multi-separador (Identificação, Acessórios/
// Consumíveis, Aquisição, Fornecedor, Localização, Garantia,
// Contrato de Manutenção) para criar um novo equipamento.
// Recolhe os dados de todos os separadores, valida-os com as
// funções reutilizáveis de validacoes.php e, se válidos, insere
// o equipamento e todos os dados/documentação associados.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
bloquear_profissional_saude();
require_once __DIR__ . '/../../includes/validacoes.php';

// Ir buscar unidades e estados de acessório para os selects dinâmicos (Tab 2)
try {
    $ligacaoListas = conectar_bd();

    $unidadesBD = $ligacaoListas->query("SELECT designacao FROM unidades ORDER BY ordem")->fetchAll(PDO::FETCH_COLUMN);
    $estadosAcessorioBD = $ligacaoListas->query("SELECT designacao, valor FROM estados_acessorio ORDER BY ordem")->fetchAll(PDO::FETCH_ASSOC);
    $fornecedoresBD = $ligacaoListas->query("SELECT id, codigo, nome_empresa FROM fornecedores ORDER BY codigo")->fetchAll(PDO::FETCH_ASSOC);
    $moradasBD = $ligacaoListas->query("SELECT id, designacao FROM moradas ORDER BY designacao")->fetchAll(PDO::FETCH_ASSOC);
    $localizacoesBD = $ligacaoListas->query("SELECT id, codigo, edificio, piso, servico, sala FROM localizacoes ORDER BY codigo")->fetchAll(PDO::FETCH_ASSOC);
    $tiposContratoBD = $ligacaoListas->query("SELECT id, designacao FROM tipos_contrato ORDER BY ordem")->fetchAll(PDO::FETCH_ASSOC);
    $periodicidadesBD = $ligacaoListas->query("SELECT id, designacao FROM periodicidades ORDER BY ordem")->fetchAll(PDO::FETCH_ASSOC);

    $ligacaoListas = null;
} catch (PDOException $err) {
    registar_erro_log($err->getMessage());
    $unidadesBD = [];
    $estadosAcessorioBD = [];
    $fornecedoresBD = [];
    $moradasBD = [];
    $localizacoesBD = [];
    $tiposContratoBD = [];
    $periodicidadesBD = [];
}

$erros = [];

// --------------------------------------------------------------------
// PROCESSAMENTO DO FORMULÁRIO (submissão POST)
// --------------------------------------------------------------------
// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Recolher dados — Tab 1 (Identificação)
    $codigo = trim($_POST["codigo"] ?? "");
    $designacao = trim($_POST["designacao"] ?? "");
    $categoria = trim($_POST["categoria"] ?? "");
    $marca = trim($_POST["marca"] ?? "");
    $modelo = trim($_POST["modelo"] ?? "");
    $numero_serie = trim($_POST["numero_serie"] ?? "");
    $fabricante = trim($_POST["fabricante"] ?? "");
    $ano_fabrico = trim($_POST["ano_fabrico"] ?? "");
    $estado = trim($_POST["estado"] ?? "");
    $criticidade = trim($_POST["criticidade"] ?? "");
    $observacoes = trim($_POST["observacoes"] ?? "");

    // Documentação técnica
    $tem_documentacao_tecnica = $_POST["tem_documentacao_tecnica"] ?? "";
    $nomeManualTecnico = trim($_POST["nomeManualTecnico"] ?? "");
    $dataManualTecnico = $_POST["dataManualTecnico"] ?? "";
    $validadeManualTecnico = $_POST["validadeManualTecnico"] ?? "";

    // Documentação de utilização
    $tem_documentacao_utilizacao = $_POST["tem_documentacao_utilizacao"] ?? "";
    $nomeManualUtilizacao = trim($_POST["nomeManualUtilizacao"] ?? "");
    $dataManualUtilizacao = $_POST["dataManualUtilizacao"] ?? "";
    $validadeManualUtilizacao = $_POST["validadeManualUtilizacao"] ?? "";

    // Declaração de conformidade
    $tem_declaracao_conformidade = $_POST["tem_declaracao_conformidade"] ?? "";
    $nomeDeclaracaoConformidade = trim($_POST["nomeDeclaracaoConformidade"] ?? "");
    $dataDeclaracaoConformidade = $_POST["dataDeclaracaoConformidade"] ?? "";
    $validadeDeclaracaoConformidade = $_POST["validadeDeclaracaoConformidade"] ?? "";

    // 3. Validar os dados — Tab 1 (Identificação), funções reutilizáveis em validacoes.php
    $erros = array_merge(
        $erros,
        validar_codigo_equipamento($codigo),
        validar_designacao_equipamento($designacao),
        validar_categoria_equipamento($categoria),
        validar_marca_equipamento($marca),
        validar_modelo_equipamento($modelo),
        validar_numero_serie_equipamento($numero_serie),
        validar_fabricante_equipamento($fabricante),
        validar_ano_fabrico_equipamento($ano_fabrico),
        validar_estado_equipamento($estado),
        validar_criticidade_equipamento($criticidade),
        validar_observacoes_equipamento($observacoes),
        validar_documentacao_identificacao_equipamento($tem_documentacao_tecnica, $nomeManualTecnico, $dataManualTecnico, $validadeManualTecnico, $ano_fabrico, "documentação técnica"),
        validar_documentacao_identificacao_equipamento($tem_documentacao_utilizacao, $nomeManualUtilizacao, $dataManualUtilizacao, $validadeManualUtilizacao, $ano_fabrico, "documentação de utilização"),
        validar_documentacao_identificacao_equipamento($tem_declaracao_conformidade, $nomeDeclaracaoConformidade, $dataDeclaracaoConformidade, $validadeDeclaracaoConformidade, $ano_fabrico, "declaração de conformidade")
    );

    // --- Validações de unicidade (código; fabricante+modelo+numero_serie) ---
    if (empty($erros)) {
        try {
            $ligacao = conectar_bd();

            // Código único
            $stmt = $ligacao->prepare("SELECT COUNT(*) FROM equipamentos WHERE codigo = :codigo");
            $stmt->execute([':codigo' => $codigo]);
            if ($stmt->fetchColumn() > 0) {
                $erros[] = "Já existe um equipamento registado com o código \"$codigo\".";
            }

            // Número de série único para o mesmo fabricante e modelo
            $stmt = $ligacao->prepare("SELECT COUNT(*) FROM equipamentos WHERE fabricante = :fabricante AND modelo = :modelo AND numero_serie = :numero_serie");
            $stmt->execute([':fabricante' => $fabricante, ':modelo' => $modelo, ':numero_serie' => $numero_serie]);
            if ($stmt->fetchColumn() > 0) {
                $erros[] = "Já existe um equipamento registado com este número de série para o fabricante e modelo indicados.";
            }

            $ligacao = null;
        } catch (PDOException $err) {
            registar_erro_log($err->getMessage());
            $erros[] = "Erro ao verificar duplicados: " . $err->getMessage();
        }
    }

    // 1b. Recolher dados — Tab 2 (Acessórios e Consumíveis)
    $acessorios = [
        'nome' => $_POST['acessorios']['nome'] ?? [],
        'referencia' => $_POST['acessorios']['referencia'] ?? [],
        'quantidade' => $_POST['acessorios']['quantidade'] ?? [],
        'unidade' => $_POST['acessorios']['unidade'] ?? [],
        'estado' => $_POST['acessorios']['estado'] ?? [],
        'observacoes' => $_POST['acessorios']['observacoes'] ?? [],
    ];

    $consumiveis = [
        'nome' => $_POST['consumiveis']['nome'] ?? [],
        'referencia' => $_POST['consumiveis']['referencia'] ?? [],
        'quantidade' => $_POST['consumiveis']['quantidade'] ?? [],
        'unidade' => $_POST['consumiveis']['unidade'] ?? [],
        'estado' => $_POST['consumiveis']['estado'] ?? [],
        'observacoes' => $_POST['consumiveis']['observacoes'] ?? [],
    ];

    // --- Validar Acessórios e Consumíveis (funções reutilizáveis em validacoes.php) ---
    $erros = array_merge(
        $erros,
        validar_acessorios_equipamento($acessorios),
        validar_consumiveis_equipamento($consumiveis)
    );

    // 1c. Recolher dados — Tab 3 (Aquisição)
    $data_aquisicao = trim($_POST["data_aquisicao"] ?? "");
    $custo_aquisicao = trim($_POST["custo_aquisicao"] ?? "");
    $tipo_entrada = trim($_POST["tipo_entrada"] ?? "");

    $tem_contrato_aquisicao = $_POST["tem_contrato_aquisicao"] ?? "";
    $nomeContratoAquisicao = trim($_POST["nomeContratoAquisicao"] ?? "");
    $dataContratoAquisicao = $_POST["dataContratoAquisicao"] ?? "";
    $validadeContratoAquisicao = $_POST["validadeContratoAquisicao"] ?? "";

    $tem_fatura = $_POST["tem_fatura"] ?? "";
    $nomeFatura = trim($_POST["nomeFatura"] ?? "");
    $dataFatura = $_POST["dataFatura"] ?? "";

    $observacoesAquisicao = trim($_POST["observacoesAquisicao"] ?? "");

    // $dataAquisicaoObj é reutilizada nos Tabs 6 e 7 (validarDocumentacaoComData)
    $dataAquisicaoObj = ($data_aquisicao !== "") ? DateTime::createFromFormat('Y-m-d', $data_aquisicao) : null;

    // Validações do Tab 3 (funções reutilizáveis em validacoes.php)
    $erros = array_merge(
        $erros,
        validar_data_aquisicao_equipamento($data_aquisicao, $ano_fabrico),
        validar_custo_aquisicao_equipamento($custo_aquisicao),
        validar_tipo_entrada_equipamento($tipo_entrada),
        validar_tem_contrato_aquisicao_equipamento($tem_contrato_aquisicao),
        validar_tem_fatura_equipamento($tem_fatura),
        validar_documentacao_contrato_aquisicao_equipamento($tem_contrato_aquisicao, $nomeContratoAquisicao, $dataContratoAquisicao, $validadeContratoAquisicao, $dataAquisicaoObj),
        validar_documentacao_fatura_equipamento($tem_fatura, $nomeFatura, $dataFatura, $dataAquisicaoObj),
        validar_observacoes_aquisicao_equipamento($observacoesAquisicao)
    );

    // 1d. Recolher dados — Tab 4 (Fornecedor)
    $fornecedoresAssociados = [
        'fornecedor' => $_POST['fornecedores']['fornecedor'] ?? [],
        'morada' => $_POST['fornecedores']['morada'] ?? [],
        'pessoa' => $_POST['fornecedores']['pessoa'] ?? [],
        'telefone' => $_POST['fornecedores']['telefone'] ?? [],
        'observacoes' => $_POST['fornecedores']['observacoes'] ?? [],
    ];

    // Validações dos fornecedores associados (função reutilizável em validacoes.php)
    $erros = array_merge($erros, validar_fornecedores_associados_equipamento($fornecedoresAssociados));

    // 1e. Recolher dados — Tab 5 (Localização)
    $localizacao_id = trim($_POST["localizacao"] ?? "");
    $observacoesLocalizacao = trim($_POST["observacoesLocalizacao"] ?? "");

    // Validações do Tab 5 (funções reutilizáveis em validacoes.php)
    $erros = array_merge(
        $erros,
        validar_localizacao_equipamento($localizacao_id),
        validar_observacoes_localizacao_equipamento($observacoesLocalizacao)
    );

    // 1f. Recolher dados — Tab 6 (Garantia)
    $dataInicioGarantia = $_POST["dataInicioGarantia"] ?? "";
    $dataFimGarantia = $_POST["dataFimGarantia"] ?? "";

    $tem_documentacao_garantia = $_POST["tem_documentacao_garantia"] ?? "";
    $nomeCertificadoGarantia = trim($_POST["nomeCertificadoGarantia"] ?? "");
    $dataCertificadoGarantia = $_POST["dataCertificadoGarantia"] ?? "";
    $validadeCertificadoGarantia = $_POST["validadeCertificadoGarantia"] ?? "";

    $observacoesGarantia = trim($_POST["observacoesGarantia"] ?? "");

    // $dataInicioGarantiaObj é reutilizada para validar a data de fim da garantia
    // e a data do certificado de garantia (funções reutilizáveis em validacoes.php)
    $dataInicioGarantiaObj = ($dataInicioGarantia !== "") ? DateTime::createFromFormat('Y-m-d', $dataInicioGarantia) : null;

    $erros = array_merge(
        $erros,
        validar_data_inicio_garantia_equipamento($dataInicioGarantia, $dataAquisicaoObj),
        validar_data_fim_garantia_equipamento($dataFimGarantia, $dataInicioGarantiaObj),
        validar_documentacao_garantia_equipamento($tem_documentacao_garantia, $nomeCertificadoGarantia, $dataCertificadoGarantia, $validadeCertificadoGarantia, $dataInicioGarantiaObj),
        validar_observacoes_garantia_equipamento($observacoesGarantia)
    );

    // 1g. Recolher dados — Tab 7 (Contrato de Manutenção)
    $contratoManutencao = $_POST["contratoManutencao"] ?? "";
    $tipoContrato = trim($_POST["tipoContrato"] ?? "");
    $entidadeResponsavelContrato = trim($_POST["entidadeResponsavelContrato"] ?? "");
    $periodicidadeContrato = trim($_POST["periodicidadeContrato"] ?? "");
    $observacoesContrato = trim($_POST["observacoesContrato"] ?? "");

    $tem_documentacao_contrato = $_POST["tem_documentacao_contrato"] ?? "";
    $nomeCertificadoContrato = trim($_POST["nomeCertificadoContrato"] ?? "");
    $dataContratoManutencao = $_POST["dataContratoManutencao"] ?? "";
    $validadeContratoManutencao = $_POST["validadeContratoManutencao"] ?? "";

    $tem_relatorio_contrato = $_POST["tem_relatorio_contrato"] ?? "";
    $nomeRelatorioManutencao = trim($_POST["nomeRelatorioManutencao"] ?? "");
    $dataRelatorioManutencao = $_POST["dataRelatorioManutencao"] ?? "";
    $validadeRelatorioManutencao = $_POST["validadeRelatorioManutencao"] ?? "";

    $tem_documentacao_calibracao = $_POST["tem_documentacao_calibracao"] ?? "";
    $nomeCertificadoCalibracao = trim($_POST["nomeCertificadoCalibracao"] ?? "");
    $dataCertificadoCalibracao = $_POST["dataCertificadoCalibracao"] ?? "";
    $validadeCertificadoCalibracao = $_POST["validadeCertificadoCalibracao"] ?? "";

    $tem_relatorio_calibracao = $_POST["tem_relatorio_calibracao"] ?? "";
    $nomeRelatorioCalibracao = trim($_POST["nomeRelatorioCalibracao"] ?? "");
    $dataRelatorioCalibracao = $_POST["dataRelatorioCalibracao"] ?? "";
    $validadeRelatorioCalibracao = $_POST["validadeRelatorioCalibracao"] ?? "";

    // Validações de contratoManutencao/tipoContrato/entidadeResponsavel/periodicidade (função reutilizável em validacoes.php)
    $erros = array_merge($erros, validar_contrato_manutencao_equipamento($contratoManutencao, $tipoContrato, $entidadeResponsavelContrato, $periodicidadeContrato));

    // --- Documentação do Tab 7 que depende da data de aquisição (função reutilizável em validacoes.php) ---
    $erros = array_merge(
        $erros,
        validar_documentacao_com_data_equipamento($tem_documentacao_contrato, $nomeCertificadoContrato, $dataContratoManutencao, $validadeContratoManutencao, $dataAquisicaoObj, "contrato de manutenção"),
        validar_documentacao_com_data_equipamento($tem_relatorio_contrato, $nomeRelatorioManutencao, $dataRelatorioManutencao, $validadeRelatorioManutencao, $dataAquisicaoObj, "relatório de manutenção"),
        validar_documentacao_com_data_equipamento($tem_documentacao_calibracao, $nomeCertificadoCalibracao, $dataCertificadoCalibracao, $validadeCertificadoCalibracao, $dataAquisicaoObj, "certificado de calibração"),
        validar_documentacao_com_data_equipamento($tem_relatorio_calibracao, $nomeRelatorioCalibracao, $dataRelatorioCalibracao, $validadeRelatorioCalibracao, $dataAquisicaoObj, "relatório de calibração")
    );

    // Validação das observações do contrato (função reutilizável em validacoes.php)
    $erros = array_merge($erros, validar_observacoes_contrato_equipamento($observacoesContrato));

    // 4. Guardar na base de dados — Tab 1
    if (empty($erros)) {
        try {
            $ligacao = conectar_bd();

            // Resolver categoria_id
            $stmt = $ligacao->prepare("SELECT id FROM categorias WHERE designacao = :designacao");
            $stmt->execute([':designacao' => $categoria]);
            $categoria_id = $stmt->fetchColumn();

            // Resolver estado_id
            $stmt = $ligacao->prepare("SELECT id FROM estados_equipamento WHERE designacao = :designacao");
            $stmt->execute([':designacao' => $estado]);
            $estado_id = $stmt->fetchColumn();

            // Resolver criticidade_id
            $stmt = $ligacao->prepare("SELECT id FROM criticidades WHERE designacao = :designacao");
            $stmt->execute([':designacao' => $criticidade]);
            $criticidade_id = $stmt->fetchColumn();

            // INSERT do equipamento
            $stmt = $ligacao->prepare("
                INSERT INTO equipamentos
                    (codigo, designacao, categoria_id, marca, modelo, numero_serie, fabricante, ano_fabrico, estado_id, criticidade_id, observacoes, localizacao_id)
                VALUES
                    (:codigo, :designacao, :categoria_id, :marca, :modelo, :numero_serie, :fabricante, :ano_fabrico, :estado_id, :criticidade_id, :observacoes, :localizacao_id)
            ");

            $stmt->execute([
                ':codigo' => $codigo,
                ':designacao' => $designacao,
                ':categoria_id' => $categoria_id,
                ':marca' => $marca,
                ':modelo' => $modelo,
                ':numero_serie' => $numero_serie,
                ':fabricante' => $fabricante,
                ':ano_fabrico' => $ano_fabrico !== "" ? $ano_fabrico : null,
                ':estado_id' => $estado_id,
                ':criticidade_id' => $criticidade_id,
                ':observacoes' => $observacoes !== "" ? $observacoes : null,
                ':localizacao_id' => $localizacao_id,
            ]);

            $equipamento_id = $ligacao->lastInsertId();

            // Pasta de destino para documentos de equipamentos
            $pastaDestino = __DIR__ . '/../../../uploads/documentacao_equipamentos/';
            if (!is_dir($pastaDestino)) {
                mkdir($pastaDestino, 0777, true);
            }

            // Função auxiliar para upload + insert de cada documento
            function guardarDocumentoEquipamento($ligacao, $equipamento_id, $tipo_documento_id, $nomeDoc, $dataDoc, $validadeDoc, $campoFicheiro, $codigo, $pastaDestino)
            {

                $ficheiroDestino = null;
                $nomeOriginal = null;

                if (isset($_FILES[$campoFicheiro]) && $_FILES[$campoFicheiro]['error'] === UPLOAD_ERR_OK) {
                    $nomeOriginal = $_FILES[$campoFicheiro]['name'];
                    $nomeFicheiro = 'doc_equipamento_' . $codigo . '_' . $tipo_documento_id . '_' . time() . '.pdf';
                    $caminhoDestino = $pastaDestino . $nomeFicheiro;

                    move_uploaded_file($_FILES[$campoFicheiro]['tmp_name'], $caminhoDestino);

                    $ficheiroDestino = $nomeFicheiro;
                }

                $stmt = $ligacao->prepare("
                    INSERT INTO documentacao_equipamentos
                        (equipamento_id, tipo_documento_id, nome_documento, data_documento, validade_documento, ficheiro_documento, nome_original_ficheiro)
                    VALUES
                        (:equipamento_id, :tipo_documento_id, :nome_documento, :data_documento, :validade_documento, :ficheiro_documento, :nome_original_ficheiro)
                ");

                $stmt->execute([
                    ':equipamento_id' => $equipamento_id,
                    ':tipo_documento_id' => $tipo_documento_id,
                    ':nome_documento' => $nomeDoc,
                    ':data_documento' => $dataDoc !== "" ? $dataDoc : null,
                    ':validade_documento' => $validadeDoc !== "" ? $validadeDoc : null,
                    ':ficheiro_documento' => $ficheiroDestino,
                    ':nome_original_ficheiro' => $nomeOriginal,
                ]);
            }

            // Documentação técnica (tipo_documento_id = 1)
            if ($tem_documentacao_tecnica === "sim") {
                guardarDocumentoEquipamento($ligacao, $equipamento_id, 1, $nomeManualTecnico, $dataManualTecnico, $validadeManualTecnico, 'ficheiroManualTecnico', $codigo, $pastaDestino);
            }

            // Documentação de utilização (tipo_documento_id = 2)
            if ($tem_documentacao_utilizacao === "sim") {
                guardarDocumentoEquipamento($ligacao, $equipamento_id, 2, $nomeManualUtilizacao, $dataManualUtilizacao, $validadeManualUtilizacao, 'ficheiroManualUtilizacao', $codigo, $pastaDestino);
            }

            // Declaração de conformidade (tipo_documento_id = 3)
            if ($tem_declaracao_conformidade === "sim") {
                guardarDocumentoEquipamento($ligacao, $equipamento_id, 3, $nomeDeclaracaoConformidade, $dataDeclaracaoConformidade, $validadeDeclaracaoConformidade, 'ficheiroDeclaracaoConformidade', $codigo, $pastaDestino);
            }

            // Contrato de Aquisição (tipo_documento_id = 5)
            if ($tem_contrato_aquisicao === "sim") {
                guardarDocumentoEquipamento($ligacao, $equipamento_id, 5, $nomeContratoAquisicao, $dataContratoAquisicao, $validadeContratoAquisicao, 'ficheiroContratoAquisicao', $codigo, $pastaDestino);
            }

            // Fatura (tipo_documento_id = 4)
            if ($tem_fatura === "sim") {
                guardarDocumentoEquipamento($ligacao, $equipamento_id, 4, $nomeFatura, $dataFatura, "", 'ficheiroFatura', $codigo, $pastaDestino);
            }

            // Fornecedores associados (Tab 4)
            $stmtFornecedor = $ligacao->prepare("
                INSERT INTO equipamento_fornecedor
                    (equipamento_id, fornecedor_id, morada_id, pessoa_contacto, telefone_pessoa_contacto, observacoes)
                VALUES
                    (:equipamento_id, :fornecedor_id, :morada_id, :pessoa_contacto, :telefone_pessoa_contacto, :observacoes)
            ");

            foreach ($fornecedoresAssociados['fornecedor'] as $i => $fornecedorId) {
                $stmtFornecedor->execute([
                    ':equipamento_id' => $equipamento_id,
                    ':fornecedor_id' => trim($fornecedorId),
                    ':morada_id' => trim($fornecedoresAssociados['morada'][$i] ?? ''),
                    ':pessoa_contacto' => trim($fornecedoresAssociados['pessoa'][$i] ?? ''),
                    ':telefone_pessoa_contacto' => trim($fornecedoresAssociados['telefone'][$i] ?? ''),
                    ':observacoes' => trim($fornecedoresAssociados['observacoes'][$i] ?? '') !== "" ? trim($fornecedoresAssociados['observacoes'][$i]) : null,
                ]);
            }

            // Observações de localização (Tab 5)
            $stmtLocalizacao = $ligacao->prepare("
                UPDATE equipamentos
                SET observacoes_localizacao = :observacoes_localizacao
                WHERE id = :equipamento_id
            ");

            $stmtLocalizacao->execute([
                ':observacoes_localizacao' => $observacoesLocalizacao !== "" ? $observacoesLocalizacao : null,
                ':equipamento_id' => $equipamento_id,
            ]);

            // Garantia (Tab 6)
            $stmtGarantia = $ligacao->prepare("
                INSERT INTO garantias_equipamentos
                    (equipamento_id, data_inicio, data_fim, observacoes)
                VALUES
                    (:equipamento_id, :data_inicio, :data_fim, :observacoes)
            ");

            $stmtGarantia->execute([
                ':equipamento_id' => $equipamento_id,
                ':data_inicio' => $dataInicioGarantia,
                ':data_fim' => $dataFimGarantia,
                ':observacoes' => $observacoesGarantia !== "" ? $observacoesGarantia : null,
            ]);

            // Certificado de Garantia (tipo_documento_id = 9)
            if ($tem_documentacao_garantia === "sim") {
                guardarDocumentoEquipamento($ligacao, $equipamento_id, 9, $nomeCertificadoGarantia, $dataCertificadoGarantia, $validadeCertificadoGarantia, 'ficheiroCertificadoGarantia', $codigo, $pastaDestino);
            }

            // Contrato de Manutenção (Tab 7)
            if ($contratoManutencao === "sim") {
                $stmtContrato = $ligacao->prepare("
                    INSERT INTO contratos_manutencao
                        (equipamento_id, tipo_contrato, entidade_responsavel, periodicidade, observacoes)
                    VALUES
                        (:equipamento_id, :tipo_contrato, :entidade_responsavel, :periodicidade, :observacoes)
                ");

                $stmtContrato->execute([
                    ':equipamento_id' => $equipamento_id,
                    ':tipo_contrato' => $tipoContrato,
                    ':entidade_responsavel' => $entidadeResponsavelContrato,
                    ':periodicidade' => $periodicidadeContrato,
                    ':observacoes' => $observacoesContrato !== "" ? $observacoesContrato : null,
                ]);
            }

            // Certificado de Contrato de Manutenção (tipo_documento_id = 10)
            if ($tem_documentacao_contrato === "sim") {
                guardarDocumentoEquipamento($ligacao, $equipamento_id, 10, $nomeCertificadoContrato, $dataContratoManutencao, $validadeContratoManutencao, 'ficheiroContratoManutencao', $codigo, $pastaDestino);
            }

            // Relatório de Manutenção (tipo_documento_id = 11)
            if ($tem_relatorio_contrato === "sim") {
                guardarDocumentoEquipamento($ligacao, $equipamento_id, 11, $nomeRelatorioManutencao, $dataRelatorioManutencao, $validadeRelatorioManutencao, 'ficheiroRelatorioManutencao', $codigo, $pastaDestino);
            }

            // Certificado de Calibração (tipo_documento_id = 12)
            if ($tem_documentacao_calibracao === "sim") {
                guardarDocumentoEquipamento($ligacao, $equipamento_id, 12, $nomeCertificadoCalibracao, $dataCertificadoCalibracao, $validadeCertificadoCalibracao, 'ficheiroCertificadoCalibracao', $codigo, $pastaDestino);
            }

            // Relatório de Calibração (tipo_documento_id = 13)
            if ($tem_relatorio_calibracao === "sim") {
                guardarDocumentoEquipamento($ligacao, $equipamento_id, 13, $nomeRelatorioCalibracao, $dataRelatorioCalibracao, $validadeRelatorioCalibracao, 'ficheiroRelatorioCalibracao', $codigo, $pastaDestino);
            }

            registar_historico(
                $ligacao,
                $equipamento_id,
                'Criação',
                "Equipamento {$codigo} criado.",
                null,
                ['codigo' => $codigo, 'designacao' => $designacao, 'estado' => $estado, 'criticidade' => $criticidade]
            );

            $ligacao = null;

            // Redirecionar após sucesso
            $_SESSION['mensagem_sucesso'] = 'Equipamento criado com sucesso.';
            header("Location: equipamentos.php");
            exit;
        } catch (PDOException $err) {
            registar_erro_log($err->getMessage());
            $erros[] = "Erro ao guardar o equipamento: " . $err->getMessage();
        }
    }
}
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- ============================================================ -->
    <!-- Formulário de criação de novo equipamento (multi-separador) -->
    <!-- ============================================================ -->
    <main class="conteudo-privado">

        <section class="formulario-privado">

            <div class="cabecalho-formulario-privado">
                <h1>
                    <i class="fa-solid fa-plus"></i>
                    Inserir novo equipamento
                </h1>
            </div>

            <hr>

            <form id="form-novo-equipamento" class="form-equipamento-privado" action="#" method="post" enctype="multipart/form-data" novalidate>

                <div class="tabs-consulta-equipamento">

                    <div class="botoes-tabs-equipamento">
                        <button type="button" class="botao-tab-equipamento ativo" data-tab="tab-identificacao">
                            <i class="fa-solid fa-stethoscope"></i>
                            Identificação
                        </button>

                        <button type="button" class="botao-tab-equipamento bloqueado"
                            data-tab="tab-acessorios-consumiveis" disabled>
                            <i class="fa-solid fa-toolbox"></i>
                            Acessórios e Consumíveis
                        </button>

                        <button type="button" class="botao-tab-equipamento bloqueado" data-tab="tab-aquisicao"
                            disabled>
                            <i class="fa-solid fa-cart-shopping"></i>
                            Aquisição
                        </button>

                        <button type="button" class="botao-tab-equipamento bloqueado" data-tab="tab-novo-fornecedor"
                            disabled>
                            <i class="fa-solid fa-truck-medical"></i>
                            Fornecedor
                        </button>

                        <button type="button" class="botao-tab-equipamento bloqueado"
                            data-tab="tab-nova-localizacao" disabled>
                            <i class="fa-solid fa-location-dot"></i>
                            Localização
                        </button>

                        <button type="button" class="botao-tab-equipamento bloqueado" data-tab="tab-garantia"
                            disabled>
                            <i class="fa-solid fa-shield-halved"></i>
                            Garantia
                        </button>

                        <button type="button" class="botao-tab-equipamento bloqueado" data-tab="tab-contrato"
                            disabled>
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                            Contrato
                        </button>
                    </div>

                    <!-- Separador identificacao -->
                    <div id="tab-identificacao" class="conteudo-tab-equipamento ativo">

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-circle-info"></i>
                            Dados do Equipamento
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="codigo" class="form-label">Código interno de inventário</label>
                                <input type="text" class="form-control campo-formulario-privado" id="codigo"
                                    name="codigo" value="<?= htmlspecialchars($_POST['codigo'] ?? '') ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="designacao" class="form-label">Designação do equipamento</label>
                                <input type="text" class="form-control campo-formulario-privado" id="designacao"
                                    name="designacao" value="<?= htmlspecialchars($_POST['designacao'] ?? '') ?>">
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
                                <?php $categoriaSelecionada = $_POST['categoria'] ?? ''; ?>
                                <select class="form-select campo-formulario-privado" id="categoria"
                                    name="categoria">
                                    <option value="" disabled <?= $categoriaSelecionada === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                    <option <?= $categoriaSelecionada === 'Monitorização' ? 'selected' : '' ?>>Monitorização</option>
                                    <option <?= $categoriaSelecionada === 'Suporte de vida' ? 'selected' : '' ?>>Suporte de vida</option>
                                    <option <?= $categoriaSelecionada === 'Terapia' ? 'selected' : '' ?>>Terapia</option>
                                    <option <?= $categoriaSelecionada === 'Diagnóstico' ? 'selected' : '' ?>>Diagnóstico</option>
                                    <option <?= $categoriaSelecionada === 'Laboratório' ? 'selected' : '' ?>>Laboratório</option>
                                    <option <?= $categoriaSelecionada === 'Esterilização' ? 'selected' : '' ?>>Esterilização</option>
                                    <option <?= $categoriaSelecionada === 'Reabilitação' ? 'selected' : '' ?>>Reabilitação</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" class="form-control campo-formulario-privado" id="marca"
                                    name="marca" value="<?= htmlspecialchars($_POST['marca'] ?? '') ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input type="text" class="form-control campo-formulario-privado" id="modelo"
                                    name="modelo" value="<?= htmlspecialchars($_POST['modelo'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="numero_serie" class="form-label">N.º de série</label>
                                <input type="text" class="form-control campo-formulario-privado" id="numero_serie"
                                    name="numero_serie" value="<?= htmlspecialchars($_POST['numero_serie'] ?? '') ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="fabricante" class="form-label">Fabricante</label>
                                <input type="text" class="form-control campo-formulario-privado" id="fabricante"
                                    name="fabricante" value="<?= htmlspecialchars($_POST['fabricante'] ?? '') ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="ano_fabrico" class="form-label">Ano de fabrico</label>
                                <input type="number" class="form-control campo-formulario-privado" id="ano_fabrico"
                                    name="ano_fabrico" value="<?= htmlspecialchars($_POST['ano_fabrico'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">
                                    Estado
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

                                <?php $estadoSelecionado = $_POST['estado'] ?? ''; ?>
                                <select class="form-select campo-formulario-privado" id="estado" name="estado">

                                    <option value="" disabled <?= $estadoSelecionado === '' ? 'selected' : '' ?>>
                                        Escolha uma opção
                                    </option>

                                    <option <?= $estadoSelecionado === 'Ativo' ? 'selected' : '' ?>>Ativo</option>
                                    <option <?= $estadoSelecionado === 'Em manutenção' ? 'selected' : '' ?>>Em manutenção</option>
                                    <option <?= $estadoSelecionado === 'Inativo' ? 'selected' : '' ?>>Inativo</option>
                                    <option <?= $estadoSelecionado === 'Em calibração' ? 'selected' : '' ?>>Em calibração</option>
                                    <option <?= $estadoSelecionado === 'Em quarentena' ? 'selected' : '' ?>>Em quarentena</option>
                                    <option <?= $estadoSelecionado === 'Abatido' ? 'selected' : '' ?>>Abatido</option>

                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="criticidade" class="form-label">
                                    Criticidade
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

                                <?php $criticidadeSelecionada = $_POST['criticidade'] ?? ''; ?>
                                <select class="form-select campo-formulario-privado" id="criticidade"
                                    name="criticidade">

                                    <option value="" disabled <?= $criticidadeSelecionada === '' ? 'selected' : '' ?>>
                                        Escolha uma opção
                                    </option>

                                    <option <?= $criticidadeSelecionada === 'Baixa' ? 'selected' : '' ?>>Baixa</option>
                                    <option <?= $criticidadeSelecionada === 'Média' ? 'selected' : '' ?>>Média</option>
                                    <option <?= $criticidadeSelecionada === 'Alta' ? 'selected' : '' ?>>Alta</option>
                                    <option <?= $criticidadeSelecionada === 'Suporte de vida' ? 'selected' : '' ?>>Suporte de vida</option>

                                </select>
                            </div>

                        </div>

                        <hr>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-file-medical"></i>
                            Documentação Técnica
                        </h5>

                        <div class="grupo-campo-privado grupo-campo-total">

                            <label for="tem_documentacao_tecnica">
                                Existe documentação técnica associada?
                            </label>

                            <?php $temDocTecnicaSelecionado = $_POST['tem_documentacao_tecnica'] ?? ''; ?>
                            <select id="tem_documentacao_tecnica" name="tem_documentacao_tecnica" class="campo-formulario-privado">

                                <option value="" <?= $temDocTecnicaSelecionado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temDocTecnicaSelecionado === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temDocTecnicaSelecionado === 'nao' ? 'selected' : '' ?>>Não</option>

                            </select>

                        </div>

                        <?php $estiloDocTecnica = ($_POST['tem_documentacao_tecnica'] ?? '') === 'sim' ? '' : 'style="display:none"'; ?>
                        <div id="bloco-documentacao-tecnica" <?= $estiloDocTecnica ?>>

                            <div class="card-documentacao">

                                <div class="row">

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tipo de documento</label>
                                        <input type="text" class="form-control campo-formulario-privado"
                                            value="Manual de Serviço" readonly>
                                    </div>

                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Nome do documento</label>
                                        <input type="text" class="form-control campo-formulario-privado"
                                            id="nomeManualTecnico" name="nomeManualTecnico" value="<?= htmlspecialchars($_POST['nomeManualTecnico'] ?? '') ?>">
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataManualTecnico" name="dataManualTecnico"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['dataManualTecnico'] ?? '') ?>">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeManualTecnico" name="validadeManualTecnico"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['validadeManualTecnico'] ?? '') ?>">
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroManualTecnico" name="ficheiroManualTecnico"
                                            accept=".pdf" class="form-control campo-formulario-privado">
                                    </div>

                                </div>

                            </div>

                        </div>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-book-open"></i>
                            Documentação de Utilização
                        </h5>

                        <div class="grupo-campo-privado grupo-campo-total">

                            <label for="tem_documentacao_utilizacao">
                                Existe documentação de utilização associada?
                            </label>

                            <?php $temDocUtilizacaoSelecionado = $_POST['tem_documentacao_utilizacao'] ?? ''; ?>
                            <select id="tem_documentacao_utilizacao" name="tem_documentacao_utilizacao" class="campo-formulario-privado">

                                <option value="" <?= $temDocUtilizacaoSelecionado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temDocUtilizacaoSelecionado === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temDocUtilizacaoSelecionado === 'nao' ? 'selected' : '' ?>>Não</option>

                            </select>

                        </div>

                        <?php $estiloDocUtilizacao = ($_POST['tem_documentacao_utilizacao'] ?? '') === 'sim' ? '' : 'style="display:none"'; ?>
                        <div id="bloco-documentacao-utilizacao" <?= $estiloDocUtilizacao ?>>

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
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['nomeManualUtilizacao'] ?? '') ?>">
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataManualUtilizacao" name="dataManualUtilizacao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['dataManualUtilizacao'] ?? '') ?>">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeManualUtilizacao"
                                            name="validadeManualUtilizacao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['validadeManualUtilizacao'] ?? '') ?>">
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroManualUtilizacao"
                                            name="ficheiroManualUtilizacao" accept=".pdf"
                                            class="form-control campo-formulario-privado">
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
                                Existe declaração de conformidade associada?
                            </label>
                            <?php $temDeclConformidadeSelecionado = $_POST['tem_declaracao_conformidade'] ?? ''; ?>
                            <select id="tem_declaracao_conformidade" name="tem_declaracao_conformidade" class="campo-formulario-privado">
                                <option value="" <?= $temDeclConformidadeSelecionado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temDeclConformidadeSelecionado === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temDeclConformidadeSelecionado === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <?php $estiloDeclConformidade = ($_POST['tem_declaracao_conformidade'] ?? '') === 'sim' ? '' : 'style="display:none"'; ?>
                        <div id="bloco-declaracao-conformidade" <?= $estiloDeclConformidade ?>>
                            <div class="card-documentacao">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tipo de documento</label>
                                        <input type="text" class="form-control campo-formulario-privado"
                                            value="Declaração de Conformidade" readonly>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Nome do documento</label>
                                        <input type="text" id="nomeDeclaracaoConformidade"
                                            name="nomeDeclaracaoConformidade"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['nomeDeclaracaoConformidade'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataDeclaracaoConformidade"
                                            name="dataDeclaracaoConformidade"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['dataDeclaracaoConformidade'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeDeclaracaoConformidade"
                                            name="validadeDeclaracaoConformidade"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['validadeDeclaracaoConformidade'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroDeclaracaoConformidade"
                                            name="ficheiroDeclaracaoConformidade" accept=".pdf"
                                            class="form-control campo-formulario-privado">
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
                                placeholder="Informações adicionais relevantes sobre o equipamento..."><?= htmlspecialchars($_POST['observacoes'] ?? '') ?></textarea>

                        </div>

                        <div id="erros-separador-1" class="erros-separador<?= !empty($erros) ? ' alert alert-danger' : '' ?>" style="<?= !empty($erros) ? '' : 'display:none;' ?>">
                            <ul id="lista-erros-separador-1">
                                <?php foreach ($erros as $erro): ?>
                                    <li><?= htmlspecialchars($erro) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="botoes-formulario-privado">
                            <a href="equipamentos.php" class="botao-cancelar-privado">
                                <i class="fa-solid fa-xmark"></i>
                                Cancelar
                            </a>

                            <button type="button" id="botao-seguinte-identificacao" class="botao-guardar-privado botao-seguinte"
                                data-seguinte="tab-acessorios-consumiveis">

                                Página seguinte
                            </button>
                        </div>

                    </div>

                    <!-- Separador Acessórios e Consumíveis -->
                    <div id="tab-acessorios-consumiveis" class="conteudo-tab-equipamento">

                        <!-- Acessórios -->
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
                                <i class="fa-solid fa-plus"></i> Adicionar acessório
                            </button>
                            <div class="resumo-itens mt-2" id="resumo-acessorios"></div>
                        </div>

                        <hr>

                        <!-- Consumíveis -->
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
                                <i class="fa-solid fa-plus"></i> Adicionar consumível
                            </button>
                            <div class="resumo-itens mt-2" id="resumo-consumiveis"></div>
                        </div>

                        <div id="erros-separador-2" class="erros-separador<?= !empty($erros) ? ' alert alert-danger' : '' ?>" style="<?= !empty($erros) ? '' : 'display:none;' ?>">
                            <ul id="lista-erros-separador-2">
                                <?php foreach ($erros as $erro): ?>
                                    <li><?= htmlspecialchars($erro) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- Ações -->
                        <div class="acoes-formulario-privado">
                            <button type="button" class="botao-guardar-privado botao-anterior"
                                data-anterior="tab-identificacao">Página anterior</button>
                            <a href="equipamentos.php" class="botao-cancelar-privado">
                                <i class="fa-solid fa-xmark"></i> Cancelar
                            </a>
                            <button type="button" id="botao-seguinte-acessorios" class="botao-guardar-privado botao-seguinte"
                                data-seguinte="tab-aquisicao">Página seguinte</button>
                        </div>

                    </div>

                    <!-- Separador Aquisição -->
                    <div id="tab-aquisicao" class="conteudo-tab-equipamento">

                        <!-- Dados de Aquisição -->
                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-cart-shopping"></i>
                            Dados de Aquisição do equipamento
                        </h5>

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label for="data_aquisicao" class="form-label">
                                    Data de aquisição
                                </label>

                                <input type="date" class="form-control campo-formulario-privado" id="data_aquisicao"
                                    name="data_aquisicao" value="<?= htmlspecialchars($_POST['data_aquisicao'] ?? '') ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="custo_aquisicao" class="form-label">
                                    Custo de aquisição (€)
                                </label>

                                <input type="number" step="0.01" class="form-control campo-formulario-privado"
                                    id="custo_aquisicao" name="custo_aquisicao" value="<?= htmlspecialchars($_POST['custo_aquisicao'] ?? '') ?>">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="tipo_entrada" class="form-label">
                                    Tipo de entrada
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

                                <?php $tipoEntradaSelecionado = $_POST['tipo_entrada'] ?? ''; ?>
                                <select class="form-select campo-formulario-privado" id="tipo_entrada"
                                    name="tipo_entrada">

                                    <option value="" disabled <?= $tipoEntradaSelecionado === '' ? 'selected' : '' ?>>
                                        Escolha uma opção
                                    </option>

                                    <option <?= $tipoEntradaSelecionado === 'Compra' ? 'selected' : '' ?>>Compra</option>
                                    <option <?= $tipoEntradaSelecionado === 'Doação' ? 'selected' : '' ?>>Doação</option>
                                    <option <?= $tipoEntradaSelecionado === 'Aluguer' ? 'selected' : '' ?>>Aluguer</option>
                                    <option <?= $tipoEntradaSelecionado === 'Empréstimo' ? 'selected' : '' ?>>Empréstimo</option>

                                </select>
                            </div>

                        </div>

                        <hr>

                        <!-- Documentação de Aquisição -->
                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-file-invoice"></i>
                            Documentação de Aquisição do equipamento
                        </h5>

                        <div class="grupo-campo-privado">
                            <label for="tem_contrato_aquisicao">
                                Existe contrato de aquisição associado?
                            </label>
                            <?php $temContratoAquisicaoSelecionado = $_POST['tem_contrato_aquisicao'] ?? ''; ?>
                            <select id="tem_contrato_aquisicao" name="tem_contrato_aquisicao" class="campo-formulario-privado">
                                <option value="" <?= $temContratoAquisicaoSelecionado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temContratoAquisicaoSelecionado === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temContratoAquisicaoSelecionado === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <?php $estiloContratoAquisicao = ($_POST['tem_contrato_aquisicao'] ?? '') === 'sim' ? '' : 'style="display:none"'; ?>
                        <div id="bloco-contrato-aquisicao" <?= $estiloContratoAquisicao ?>>
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
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['nomeContratoAquisicao'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data do documento</label>
                                        <input type="date" id="dataContratoAquisicao" name="dataContratoAquisicao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['dataContratoAquisicao'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeContratoAquisicao"
                                            name="validadeContratoAquisicao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['validadeContratoAquisicao'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroContratoAquisicao"
                                            name="ficheiroContratoAquisicao" accept=".pdf"
                                            class="form-control campo-formulario-privado">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fatura -->
                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-receipt"></i>
                            Fatura da aquisição
                        </h5>

                        <div class="grupo-campo-privado">
                            <label for="tem_fatura">
                                Existe fatura associada?
                            </label>
                            <?php $temFaturaSelecionado = $_POST['tem_fatura'] ?? ''; ?>
                            <select id="tem_fatura" name="tem_fatura" class="campo-formulario-privado">
                                <option value="" <?= $temFaturaSelecionado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temFaturaSelecionado === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temFaturaSelecionado === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <?php $estiloFatura = ($_POST['tem_fatura'] ?? '') === 'sim' ? '' : 'style="display:none"'; ?>
                        <div id="bloco-fatura" <?= $estiloFatura ?>>
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
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['nomeFatura'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data do documento</label>
                                        <input type="date" id="dataFatura" name="dataFatura"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['dataFatura'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroFatura" name="ficheiroFatura" accept=".pdf"
                                            class="form-control campo-formulario-privado">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Observações -->
                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-comment-medical"></i>
                            Observações da aquisição do equipamento
                        </h5>

                        <div class="mb-4">

                            <textarea id="observacoesAquisicao" name="observacoesAquisicao" rows="6"
                                class="form-control campo-formulario-privado"
                                placeholder="Informações adicionais relevantes sobre a aquisição do equipamento..."><?= htmlspecialchars($_POST['observacoesAquisicao'] ?? '') ?></textarea>

                        </div>

                        <div id="erros-separador-3" class="erros-separador<?= !empty($erros) ? ' alert alert-danger' : '' ?>" style="<?= !empty($erros) ? '' : 'display:none;' ?>">
                            <ul id="lista-erros-separador-3">
                                <?php foreach ($erros as $erro): ?>
                                    <li><?= htmlspecialchars($erro) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="acoes-formulario-privado">

                            <button type="button" class="botao-guardar-privado botao-anterior"
                                data-anterior="tab-acessorios-consumiveis">

                                Página anterior
                            </button>

                            <a href="equipamentos.php" class="botao-cancelar-privado">

                                <i class="fa-solid fa-xmark"></i>
                                Cancelar

                            </a>

                            <button type="button" id="botao-seguinte-aquisicao" class="botao-guardar-privado botao-seguinte"
                                data-seguinte="tab-novo-fornecedor">

                                Página seguinte
                            </button>

                        </div>

                    </div>

                    <!-- Separador fornecedor associado -->
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

                        <!-- Campos ocultos para compatibilidade com o JS existente -->
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

                        <div id="erros-separador-4" class="erros-separador<?= !empty($erros) ? ' alert alert-danger' : '' ?>" style="<?= !empty($erros) ? '' : 'display:none;' ?>">
                            <ul id="lista-erros-separador-4">
                                <?php foreach ($erros as $erro): ?>
                                    <li><?= htmlspecialchars($erro) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="acoes-formulario-privado">
                            <button type="button" class="botao-guardar-privado botao-anterior"
                                data-anterior="tab-aquisicao">
                                Página anterior
                            </button>
                            <a href="equipamentos.php" class="botao-cancelar-privado">
                                <i class="fa-solid fa-xmark"></i>
                                Cancelar
                            </a>
                            <button type="button" id="botao-seguinte-fornecedor" class="botao-guardar-privado botao-seguinte"
                                data-seguinte="tab-nova-localizacao">
                                Página seguinte
                            </button>
                        </div>

                    </div>

                    <!-- Separador Localização associada -->
                    <div id="tab-nova-localizacao" class="conteudo-tab-equipamento">

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-location-dot"></i>
                            Localização Associada
                        </h5>

                        <div class="row">

                            <div class="grupo-campo-privado grupo-campo-total">
                                <label for="localizacao">Localização associada</label>
                                <?php $localizacaoSelecionada = $_POST['localizacao'] ?? ''; ?>
                                <select id="localizacao" name="localizacao"
                                    class="form-select campo-formulario-privado">
                                    <option value="" disabled <?= $localizacaoSelecionada === '' ? 'selected' : '' ?>>Escolha uma localização</option>
                                    <?php foreach ($localizacoesBD as $loc): ?>
                                        <option value="<?= $loc['id'] ?>" <?= (string)$localizacaoSelecionada === (string)$loc['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($loc['codigo'] . ' — ' . $loc['edificio'] . ', ' . $loc['piso'] . ', ' . $loc['servico'] . ', ' . $loc['sala']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small>Selecione uma localização previamente registada.</small>
                            </div>

                            <hr>

                            <!-- Observações -->
                            <h5 class="subtitulo-separador titulo-azul-separador">
                                <i class="fa-solid fa-comment-medical"></i>
                                Observações da localização associada
                            </h5>

                            <div class="mb-4">
                                <div class="mb-4">
                                    <textarea id="observacoesLocalizacao" name="observacoesLocalizacao"
                                        class="form-control campo-formulario-privado" rows="6"
                                        placeholder="Escreva observações específicas sobre a localização deste equipamento"><?= htmlspecialchars($_POST['observacoesLocalizacao'] ?? '') ?></textarea>
                                </div>
                            </div>

                        </div>

                        <div id="erros-separador-5" class="erros-separador<?= !empty($erros) ? ' alert alert-danger' : '' ?>" style="<?= !empty($erros) ? '' : 'display:none;' ?>">
                            <ul id="lista-erros-separador-5">
                                <?php foreach ($erros as $erro): ?>
                                    <li><?= htmlspecialchars($erro) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="acoes-formulario-privado">
                            <button type="button" class="botao-guardar-privado botao-anterior"
                                data-anterior="tab-novo-fornecedor">

                                Página anterior
                            </button>

                            <a href="equipamentos.php" class="botao-cancelar-privado">
                                <i class="fa-solid fa-xmark"></i>
                                Cancelar
                            </a>

                            <button type="button" id="botao-seguinte-localizacao" class="botao-guardar-privado botao-seguinte"
                                data-seguinte="tab-garantia">

                                Página seguinte
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
                                <label for="dataInicioGarantia" class="form-label">
                                    Data de início da garantia
                                </label>

                                <input type="date" id="dataInicioGarantia" name="dataInicioGarantia"
                                    class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['dataInicioGarantia'] ?? '') ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dataFimGarantia" class="form-label">
                                    Data de fim da garantia
                                </label>

                                <input type="date" id="dataFimGarantia" name="dataFimGarantia"
                                    class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['dataFimGarantia'] ?? '') ?>">
                            </div>

                        </div>

                        <hr>

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-file-medical"></i>
                            Documentação de garantia
                        </h5>

                        <div class="grupo-campo-privado grupo-campo-total">

                            <label for="tem_documentacao_garantia">
                                Existe certificado de garantia associado?
                            </label>

                            <?php $temDocGarantiaSelecionado = $_POST['tem_documentacao_garantia'] ?? ''; ?>
                            <select id="tem_documentacao_garantia" name="tem_documentacao_garantia" class="campo-formulario-privado">

                                <option value="" <?= $temDocGarantiaSelecionado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temDocGarantiaSelecionado === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temDocGarantiaSelecionado === 'nao' ? 'selected' : '' ?>>Não</option>

                            </select>

                        </div>

                        <?php $estiloDocGarantia = ($_POST['tem_documentacao_garantia'] ?? '') === 'sim' ? '' : 'style="display:none"'; ?>
                        <div id="bloco-documentacao-garantia" <?= $estiloDocGarantia ?>>

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
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['nomeCertificadoGarantia'] ?? '') ?>">
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataCertificadoGarantia"
                                            name="dataCertificadoGarantia"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['dataCertificadoGarantia'] ?? '') ?>">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeCertificadoGarantia"
                                            name="validadeCertificadoGarantia"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['validadeCertificadoGarantia'] ?? '') ?>">
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroCertificadoGarantia"
                                            name="ficheiroCertificadoGarantia" accept=".pdf"
                                            class="form-control campo-formulario-privado">
                                    </div>

                                </div>

                            </div>

                        </div>

                        <hr>

                        <!-- Observações -->
                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-comment-medical"></i>
                            Observações da garantia
                        </h5>

                        <div class="grupo-campo-privado">
                            <textarea id="observacoesGarantia" name="observacoesGarantia"
                                class="campo-formulario-privado" rows="4"
                                placeholder="Escreva observações específicas sobre a garantia deste equipamento"><?= htmlspecialchars($_POST['observacoesGarantia'] ?? '') ?></textarea>
                        </div>

                        <div id="erros-separador-6" class="erros-separador<?= !empty($erros) ? ' alert alert-danger' : '' ?>" style="<?= !empty($erros) ? '' : 'display:none;' ?>">
                            <ul id="lista-erros-separador-6">
                                <?php foreach ($erros as $erro): ?>
                                    <li><?= htmlspecialchars($erro) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="acoes-formulario-privado">

                            <button type="button" class="botao-guardar-privado botao-anterior"
                                data-anterior="tab-nova-localizacao">

                                Página anterior
                            </button>

                            <a href="equipamentos.php" class="botao-cancelar-privado">

                                <i class="fa-solid fa-xmark"></i>
                                Cancelar

                            </a>

                            <button type="button" id="botao-seguinte-garantia" class="botao-guardar-privado botao-seguinte"
                                data-seguinte="tab-contrato">

                                Página seguinte
                            </button>

                        </div>

                    </div>

                    <!-- Separador Contrato de Manutenção -->
                    <div id="tab-contrato" class="conteudo-tab-equipamento">

                        <h5 class="subtitulo-separador titulo-azul-separador">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                            Contrato de Manutenção
                        </h5>

                        <div class="row">
    <div class="col-md-6 mb-3">
        <label for="contratoManutencao" class="form-label">Contrato de manutenção</label>
        <?php $contratoManutencaoSelecionado = $_POST['contratoManutencao'] ?? ''; ?>
        <select id="contratoManutencao" name="contratoManutencao" class="form-select campo-formulario-privado">
            <option value="" <?= $contratoManutencaoSelecionado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
            <option value="sim" <?= $contratoManutencaoSelecionado === 'sim' ? 'selected' : '' ?>>Sim</option>
            <option value="nao" <?= $contratoManutencaoSelecionado === 'nao' ? 'selected' : '' ?>>Não</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="tipoContrato" class="form-label">Tipo de contrato</label>
        <?php $tipoContratoSelecionado = $_POST['tipoContrato'] ?? ''; ?>
        <select id="tipoContrato" name="tipoContrato" class="form-select campo-formulario-privado">
            <?php if ($contratoManutencaoSelecionado === 'nao'): ?>
                <option value="" selected>Não existe</option>
            <?php else: ?>
                <option value="" <?= $tipoContratoSelecionado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                <?php foreach ($tiposContratoBD as $tipo): ?>
                    <option value="<?= $tipo['id'] ?>" <?= (string)$tipoContratoSelecionado === (string)$tipo['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tipo['designacao']) ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="entidadeResponsavelContrato" class="form-label">Entidade responsável</label>
        <input type="text" id="entidadeResponsavelContrato" name="entidadeResponsavelContrato"
            class="form-control campo-formulario-privado"
            value="<?= $contratoManutencaoSelecionado === 'nao' ? 'Não existe' : htmlspecialchars($_POST['entidadeResponsavelContrato'] ?? '') ?>">
    </div>
    <div class="col-md-6 mb-3">
        <label for="periodicidadeContrato" class="form-label">Periodicidade</label>
        <?php $periodicidadeContratoSelecionada = $_POST['periodicidadeContrato'] ?? ''; ?>
        <select id="periodicidadeContrato" name="periodicidadeContrato" class="form-select campo-formulario-privado">
            <?php if ($contratoManutencaoSelecionado === 'nao'): ?>
                <option value="" selected>Não aplicável</option>
            <?php else: ?>
                <option value="" <?= $periodicidadeContratoSelecionada === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                <?php foreach ($periodicidadesBD as $periodicidade): ?>
                    <option value="<?= $periodicidade['id'] ?>" <?= (string)$periodicidadeContratoSelecionada === (string)$periodicidade['id'] ? 'selected' : '' ?>>
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
                            <?php $temDocContratoSelecionado = $_POST['tem_documentacao_contrato'] ?? ''; ?>
                            <select id="tem_documentacao_contrato" name="tem_documentacao_contrato" class="form-select campo-formulario-privado">
                                <option value="" <?= $temDocContratoSelecionado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temDocContratoSelecionado === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temDocContratoSelecionado === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <?php $estiloDocContrato = ($_POST['tem_documentacao_contrato'] ?? '') === 'sim' ? '' : 'style="display:none"'; ?>
                        <div id="bloco-documentacao-contrato" <?= $estiloDocContrato ?>>
                            <div class="card-documentacao">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tipo de documento</label>
                                        <input type="text" class="form-control campo-formulario-privado"
                                            value="Contrato de manutenção" readonly>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label">Nome do documento</label>
                                        <input type="text" id="nomeCertificadoContrato" name="nomeCertificadoContrato" class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['nomeCertificadoContrato'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataContratoManutencao" name="dataContratoManutencao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['dataContratoManutencao'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeContratoManutencao"
                                            name="validadeContratoManutencao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['validadeContratoManutencao'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroContratoManutencao"
                                            name="ficheiroContratoManutencao" accept=".pdf"
                                            class="form-control campo-formulario-privado">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grupo-campo-privado" style="margin-top: 1.2rem;">
                            <label for="tem_relatorio_contrato">Existe relatório de manutenção associado?</label>
                            <?php $temRelatorioContratoSelecionado = $_POST['tem_relatorio_contrato'] ?? ''; ?>
                            <select id="tem_relatorio_contrato" name="tem_relatorio_contrato" class="form-select campo-formulario-privado">
                                <option value="" <?= $temRelatorioContratoSelecionado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temRelatorioContratoSelecionado === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temRelatorioContratoSelecionado === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <?php $estiloRelContrato = ($_POST['tem_relatorio_contrato'] ?? '') === 'sim' ? '' : 'style="display:none"'; ?>
                        <div id="bloco-relatorio-contrato" <?= $estiloRelContrato ?>>
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
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['nomeRelatorioManutencao'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataRelatorioManutencao"
                                            name="dataRelatorioManutencao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['dataRelatorioManutencao'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeRelatorioManutencao"
                                            name="validadeRelatorioManutencao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['validadeRelatorioManutencao'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroRelatorioManutencao"
                                            name="ficheiroRelatorioManutencao" accept=".pdf"
                                            class="form-control campo-formulario-privado">
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
                            <?php $temDocCalibracaoSelecionado = $_POST['tem_documentacao_calibracao'] ?? ''; ?>
                            <select id="tem_documentacao_calibracao" name="tem_documentacao_calibracao" class="form-select campo-formulario-privado">
                                <option value="" <?= $temDocCalibracaoSelecionado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temDocCalibracaoSelecionado === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temDocCalibracaoSelecionado === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <?php $estiloDocCalibracao = ($_POST['tem_documentacao_calibracao'] ?? '') === 'sim' ? '' : 'style="display:none"'; ?>
                        <div id="bloco-documentacao-calibracao" <?= $estiloDocCalibracao ?>>
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
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['nomeCertificadoCalibracao'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataCertificadoCalibracao"
                                            name="dataCertificadoCalibracao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['dataCertificadoCalibracao'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeCertificadoCalibracao"
                                            name="validadeCertificadoCalibracao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['validadeCertificadoCalibracao'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroCertificadoCalibracao"
                                            name="ficheiroCertificadoCalibracao" accept=".pdf"
                                            class="form-control campo-formulario-privado">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grupo-campo-privado" style="margin-top: 1.2rem;">
                            <label for="tem_relatorio_calibracao">Existe relatório de calibração associado?</label>
                            <?php $temRelatorioCalibracaoSelecionado = $_POST['tem_relatorio_calibracao'] ?? ''; ?>
                            <select id="tem_relatorio_calibracao" name="tem_relatorio_calibracao" class="form-select campo-formulario-privado">
                                <option value="" <?= $temRelatorioCalibracaoSelecionado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                <option value="sim" <?= $temRelatorioCalibracaoSelecionado === 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $temRelatorioCalibracaoSelecionado === 'nao' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <?php $estiloRelCalibracao = ($_POST['tem_relatorio_calibracao'] ?? '') === 'sim' ? '' : 'style="display:none"'; ?>
                        <div id="bloco-relatorio-calibracao" <?= $estiloRelCalibracao ?>>
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
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['nomeRelatorioCalibracao'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data da documentação</label>
                                        <input type="date" id="dataRelatorioCalibracao"
                                            name="dataRelatorioCalibracao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['dataRelatorioCalibracao'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data de validade</label>
                                        <input type="date" id="validadeRelatorioCalibracao"
                                            name="validadeRelatorioCalibracao"
                                            class="form-control campo-formulario-privado" value="<?= htmlspecialchars($_POST['validadeRelatorioCalibracao'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Ficheiro PDF</label>
                                        <input type="file" id="ficheiroRelatorioCalibracao"
                                            name="ficheiroRelatorioCalibracao" accept=".pdf"
                                            class="form-control campo-formulario-privado">
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
                            <div class="mb-4">
                                <textarea id="observacoesContrato" name="observacoesContrato" rows="6"
                                    class="form-control campo-formulario-privado"
                                    placeholder="Informações adicionais relevantes sobre o contrato do equipamento..."><?= htmlspecialchars($_POST['observacoesContrato'] ?? '') ?></textarea>
                            </div>
                        </div>

                        <div id="erros-separador-7" class="erros-separador<?= !empty($erros) ? ' alert alert-danger' : '' ?>" style="<?= !empty($erros) ? '' : 'display:none;' ?>">
                            <ul id="lista-erros-separador-7">
                                <?php foreach ($erros as $erro): ?>
                                    <li><?= htmlspecialchars($erro) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="acoes-formulario-privado">
                            <button type="button" class="botao-guardar-privado botao-anterior"
                                data-anterior="tab-garantia">
                                Página anterior
                            </button>
                            <a href="equipamentos.php" class="botao-cancelar-privado">
                                <i class="fa-solid fa-xmark"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="botao-guardar-privado">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Guardar

                            </button>
                        </div>

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
    const FORNECEDORES_BD = <?= json_encode($fornecedoresBD) ?>;
    const MORADAS_BD = <?= json_encode($moradasBD) ?>;
    const FORNECEDORES_POST = <?= json_encode($_POST['fornecedores'] ?? null) ?>;
    const LOCALIZACOES_BD = <?= json_encode($localizacoesBD) ?>;
    const TIPOS_CONTRATO_BD = <?= json_encode($tiposContratoBD) ?>;
    const PERIODICIDADES_BD = <?= json_encode($periodicidadesBD) ?>;
</script>

<?php include '../../includes/footer.php'; ?>