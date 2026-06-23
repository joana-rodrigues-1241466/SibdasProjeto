<?php
// ============================================================
// CONSULTAR_EQUIPAMENTO.PHP
// Apresenta a ficha completa de um equipamento (identificado por
// ID encriptado): identificação, acessórios/consumíveis,
// aquisição, fornecedores associados, localização, garantia,
// contrato de manutenção, documentação, histórico de alterações
// e geração de etiqueta QR Code para impressão.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Desencriptar e validar o ID do equipamento recebido na URL
$idEquipamentoEncriptado = $_GET['id_equipamento'] ?? null;
$idEquipamento = aes_decrypt($idEquipamentoEncriptado);

if (!$idEquipamento || !is_numeric($idEquipamento)) {
    header('Location: ' . BASE_URL . '/private/views/equipamentos/equipamentos.php');
    exit;
}

// Se o equipamento foi acedido a partir da página de um fornecedor,
// o botão "Voltar" deve regressar a esse fornecedor específico
$origem = $_GET['origem'] ?? null;
$idOrigemEncriptado = $_GET['id_origem'] ?? null;

$linkVoltarEquipamento = BASE_URL . '/private/views/equipamentos/equipamentos.php';
if ($origem === 'fornecedor' && $idOrigemEncriptado) {
    $linkVoltarEquipamento = BASE_URL . '/private/views/fornecedores/consultar_fornecedor.php?id_fornecedor=' . urlencode($idOrigemEncriptado);
} elseif ($origem === 'localizacao' && $idOrigemEncriptado) {
    $linkVoltarEquipamento = BASE_URL . '/private/views/localizacoes/consultar_localizacao.php?id_localizacao=' . urlencode($idOrigemEncriptado);
}

// --------------------------------------------------------------------
// CARREGAMENTO DE TODOS OS DADOS DO EQUIPAMENTO
// --------------------------------------------------------------------
try {
    $ligacao = conectar_bd();

    // Dados principais do equipamento (identificação, categoria, estado, criticidade, localização)
    $stmt = $ligacao->prepare("
        SELECT e.*, cat.designacao AS categoria, ee.designacao AS estado, c.designacao AS criticidade,
               l.codigo AS localizacao_codigo, l.edificio AS localizacao_edificio, l.piso AS localizacao_piso,
               l.servico AS localizacao_servico, l.sala AS localizacao_sala, l.observacoes AS observacoes_localizacao
        FROM equipamentos e
        LEFT JOIN categorias cat ON e.categoria_id = cat.id
        LEFT JOIN estados_equipamento ee ON e.estado_id = ee.id
        LEFT JOIN criticidades c ON e.criticidade_id = c.id
        LEFT JOIN localizacoes l ON e.localizacao_id = l.id
        WHERE e.id = :id
    ");
    $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmt->execute();
    $equipamento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$equipamento) {
        echo "<p class='text-danger'>Equipamento não encontrado.</p>";
        exit;
    }

    // Acessórios associados
    $stmtAcessorios = $ligacao->prepare("
        SELECT a.nome, a.referencia, a.quantidade, u.designacao AS unidade, ea.designacao AS estado, a.observacoes
        FROM acessorios a
        LEFT JOIN unidades u ON a.unidade_id = u.id
        LEFT JOIN estados_acessorio ea ON a.estado_id = ea.id
        WHERE a.equipamento_id = :id
        ORDER BY a.nome
    ");
    $stmtAcessorios->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmtAcessorios->execute();
    $acessorios = $stmtAcessorios->fetchAll(PDO::FETCH_ASSOC);

    // Consumíveis associados
    $stmtConsumiveis = $ligacao->prepare("
        SELECT c.nome, c.referencia, c.quantidade, u.designacao AS unidade, ea.designacao AS estado, c.observacoes
        FROM consumiveis c
        LEFT JOIN unidades u ON c.unidade_id = u.id
        LEFT JOIN estados_acessorio ea ON c.estado_id = ea.id
        WHERE c.equipamento_id = :id
        ORDER BY c.nome
    ");
    $stmtConsumiveis->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmtConsumiveis->execute();
    $consumiveis = $stmtConsumiveis->fetchAll(PDO::FETCH_ASSOC);

    // Dados de aquisição
    $stmtAquisicao = $ligacao->prepare("
        SELECT aq.data_aquisicao, aq.custo_aquisicao, aq.observacoes, te.designacao AS tipo_entrada
        FROM aquisicao_equipamentos aq
        LEFT JOIN tipos_entrada te ON aq.tipo_entrada_id = te.id
        WHERE aq.equipamento_id = :id
    ");
    $stmtAquisicao->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmtAquisicao->execute();
    $aquisicao = $stmtAquisicao->fetch(PDO::FETCH_ASSOC);

    // Documentação do equipamento — todos os tipos de uma vez, organizados pela designação do tipo
    $stmtDocs = $ligacao->prepare("
        SELECT de.*, tde.designacao AS tipo_documento
        FROM documentacao_equipamentos de
        JOIN tipos_documento_equipamento tde ON de.tipo_documento_id = tde.id
        WHERE de.equipamento_id = :id
    ");
    $stmtDocs->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmtDocs->execute();
    $documentosEquipamento = [];
    foreach ($stmtDocs->fetchAll(PDO::FETCH_ASSOC) as $doc) {
        $documentosEquipamento[$doc['tipo_documento']] = $doc;
    }

    $docContratoAquisicao = $documentosEquipamento['Contrato de Aquisição'] ?? null;
    $docFatura = $documentosEquipamento['Fatura'] ?? null;

    // Fornecedores associados ao equipamento
    $stmtFornecedores = $ligacao->prepare("
        SELECT f.codigo, f.nome_empresa, f.nif, f.website, f.telefone AS telefone_geral, f.email AS email_geral,
               tf.designacao AS tipo_fornecedor,
               ef.pessoa_contacto, ef.telefone_pessoa_contacto, ef.observacoes,
               m.designacao AS morada
        FROM equipamento_fornecedor ef
        JOIN fornecedores f ON f.id = ef.fornecedor_id
        LEFT JOIN tipos_fornecedor tf ON f.tipo_id = tf.id
        LEFT JOIN moradas m ON ef.morada_id = m.id
        WHERE ef.equipamento_id = :id
        ORDER BY f.codigo
    ");
    $stmtFornecedores->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmtFornecedores->execute();
    $fornecedoresEquipamento = $stmtFornecedores->fetchAll(PDO::FETCH_ASSOC);

    $docManualServico = $documentosEquipamento['Manual de Serviço'] ?? null;
    $docManualUtilizacao = $documentosEquipamento['Manual de Utilização'] ?? null;
    $docDeclaracaoConformidade = $documentosEquipamento['Declaração de Conformidade'] ?? null;

    // Documentação dos fornecedores associados a este equipamento
    $stmtDocsFornecedores = $ligacao->prepare("
        SELECT df.*, tdf.designacao AS tipo_documento, f.nome_empresa, f.codigo AS fornecedor_codigo
        FROM equipamento_fornecedor ef
        JOIN documentacao_fornecedores df ON df.fornecedor_id = ef.fornecedor_id
        JOIN fornecedores f ON f.id = ef.fornecedor_id
        LEFT JOIN tipos_documento_fornecedor tdf ON df.tipo_documento_id = tdf.id
        WHERE ef.equipamento_id = :id
    ");
    $stmtDocsFornecedores->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmtDocsFornecedores->execute();
    $documentosFornecedoresEquipamento = $stmtDocsFornecedores->fetchAll(PDO::FETCH_ASSOC);

    // Garantia
    $stmtGarantia = $ligacao->prepare("
        SELECT data_inicio, data_fim, observacoes
        FROM garantias_equipamentos
        WHERE equipamento_id = :id
    ");
    $stmtGarantia->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmtGarantia->execute();
    $garantia = $stmtGarantia->fetch(PDO::FETCH_ASSOC);

    $docCertificadoGarantia = $documentosEquipamento['Certificado de Garantia'] ?? null;

    // Contrato de manutenção
    $stmtContrato = $ligacao->prepare("
        SELECT cm.entidade_responsavel, cm.observacoes, tc.designacao AS tipo_contrato, p.designacao AS periodicidade
        FROM contratos_manutencao cm
        LEFT JOIN tipos_contrato tc ON cm.tipo_contrato_id = tc.id
        LEFT JOIN periodicidades p ON cm.periodicidade_id = p.id
        WHERE cm.equipamento_id = :id
    ");
    $stmtContrato->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmtContrato->execute();
    $contrato = $stmtContrato->fetch(PDO::FETCH_ASSOC);

    $docContratoManutencao = $documentosEquipamento['Contrato de Manutenção'] ?? null;
    $docRelatorioManutencao = $documentosEquipamento['Relatório de Manutenção'] ?? null;
    $docCertificadoCalibracao = $documentosEquipamento['Certificado de Calibração'] ?? null;
    $docRelatorioCalibracao = $documentosEquipamento['Relatório de Calibração'] ?? null;
} catch (PDOException $e) {
    registar_erro_log($e->getMessage());
    echo "<p class='text-danger'>Erro: " . $e->getMessage() . "</p>";
    exit;
}

$ligacao = null;

// --------------------------------------------------------------------
// MAPAS DE ESTILO E DADOS AUXILIARES PARA A RENDERIZAÇÃO
// --------------------------------------------------------------------
// Mapa de classes CSS para colorir o estado do equipamento
$classesEstadoDetalhe = [
    'Ativo' => 'estado-ativo',
    'Em manutenção' => 'estado-manutencao',
    'Em calibração' => 'estado-calibracao',
    'Inativo' => 'estado-inativo',
    'Em quarentena' => 'estado-quarentena',
    'Abatido' => 'estado-abatido'
];
$classeEstadoDetalhe = $classesEstadoDetalhe[$equipamento['estado']] ?? '';

// Mapa de classes CSS para colorir a criticidade do equipamento
$classesCriticidadeDetalhe = [
    'Suporte de vida' => 'badge-criticidade-suporte',
    'Alta' => 'badge-criticidade-alta',
    'Média' => 'badge-criticidade-media',
    'Baixa' => 'badge-criticidade-baixa'
];
$classeCriticidadeDetalhe = $classesCriticidadeDetalhe[$equipamento['criticidade']] ?? '';

// Lista de todos os tipos de documento, usada para construir o resumo de documentação
$tiposDocumentoResumo = [
    ['label' => 'Documentação Técnica', 'icon' => 'fa-file-medical', 'doc' => $docManualServico, 'pasta' => 'documentacao_equipamentos'],
    ['label' => 'Documentação de Utilização', 'icon' => 'fa-book-open', 'doc' => $docManualUtilizacao, 'pasta' => 'documentacao_equipamentos'],
    ['label' => 'Declaração de Conformidade', 'icon' => 'fa-certificate', 'doc' => $docDeclaracaoConformidade, 'pasta' => 'documentacao_equipamentos'],
    ['label' => 'Contrato de Aquisição', 'icon' => 'fa-file-invoice', 'doc' => $docContratoAquisicao, 'pasta' => 'documentacao_equipamentos'],
    ['label' => 'Fatura', 'icon' => 'fa-receipt', 'doc' => $docFatura, 'pasta' => 'documentacao_equipamentos'],
    ['label' => 'Certificado de Garantia', 'icon' => 'fa-shield-halved', 'doc' => $docCertificadoGarantia, 'pasta' => 'documentacao_equipamentos'],
    ['label' => 'Contrato de Manutenção', 'icon' => 'fa-screwdriver-wrench', 'doc' => $docContratoManutencao, 'pasta' => 'documentacao_equipamentos'],
    ['label' => 'Relatório de Manutenção', 'icon' => 'fa-clipboard-list', 'doc' => $docRelatorioManutencao, 'pasta' => 'documentacao_equipamentos'],
    ['label' => 'Certificado de Calibração', 'icon' => 'fa-book-open', 'doc' => $docCertificadoCalibracao, 'pasta' => 'documentacao_equipamentos'],
    ['label' => 'Relatório de Calibração', 'icon' => 'fa-file-lines', 'doc' => $docRelatorioCalibracao, 'pasta' => 'documentacao_equipamentos'],
];

$documentosExistentesResumo = array_filter($tiposDocumentoResumo, function ($item) {
    return !empty($item['doc']);
});

// Função auxiliar: gera o HTML do resumo de um documento (nome, data, validade, link do ficheiro)
function render_resumo_documento($doc, $pasta = 'documentacao_equipamentos')
{
    if (!$doc) {
        return '<p class="text-muted" style="padding: 1.2rem 0;">Sem documento associado.</p>';
    }
    $html = '<div class="grelha-detalhes-equipamento" style="padding: 1.2rem 0 0.5rem;">';
    $html .= '<div class="campo-detalhes"><h3>Nome do documento</h3><p>' . htmlspecialchars($doc['nome_documento']) . '</p></div>';
    $html .= '<div class="campo-detalhes"><h3>Data do documento</h3><p>' . date('d/m/Y', strtotime($doc['data_documento'])) . '</p></div>';
    $html .= '<div class="campo-detalhes"><h3>Validade</h3><p>' . ($doc['validade_documento'] ? date('d/m/Y', strtotime($doc['validade_documento'])) : 'Sem validade definida') . '</p></div>';
    $html .= '<div class="campo-detalhes"><h3>Ficheiro PDF</h3><p>';
    if (!empty($doc['ficheiro_documento'])) {
        $html .= '<a href="' . BASE_URL . '/uploads/' . $pasta . '/' . htmlspecialchars($doc['ficheiro_documento']) . '" target="_blank" style="color:#005fae;font-weight:600;"><i class="fa-solid fa-file-pdf me-1"></i>' . htmlspecialchars($doc['nome_original_ficheiro'] ?? 'Ver ficheiro') . '</a>';
    } else {
        $html .= '—';
    }
    $html .= '</p></div></div>';
    return $html;
}
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- ============================================================ -->
    <!-- Ficha de detalhes do equipamento -->
    <!-- ============================================================ -->
    <main class="conteudo-privado">

        <section class="detalhes-equipamento-privada">

            <div class="titulo-detalhes-equipamento">
                <i class="fa-solid fa-stethoscope"></i>
                <h1>
    Detalhes do Equipamento
    <?php if ($equipamento['ativo'] == 1): ?>
        <span class="badge bg-success" style="font-size: 0.9rem; vertical-align: middle; padding: 5px 10px;">Ativo</span>
    <?php else: ?>
        <span class="badge bg-secondary" style="font-size: 0.9rem; vertical-align: middle; padding: 5px 10px;">Inativo</span>
    <?php endif; ?>
    <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
        data-bs-trigger="hover focus" data-bs-placement="right" data-bs-html="true"
        style="font-size: 0.9rem; cursor: pointer; vertical-align: middle;"
        data-bs-content="
        <strong>Ativo</strong> - O equipamento ainda se encontra no hospital, fazendo parte do inventário em gestão.<br><br>
        <strong>Inativo</strong> - O equipamento já não está no hospital (foi removido/abatido), deixando de fazer parte deste sistema de gestão até ser reativado.<br><br>
        Isto é diferente do <strong>Estado</strong> do equipamento (Ativo, Em manutenção, etc.), que descreve a condição operacional do equipamento enquanto este está no hospital.">
    </i>
</h1>
            </div>

            <div class="cabecalho-equipamento-detalhe">

                <div class="cabecalho-info-equipamento">
                    <span id="cabecalho-codigo-equipamento" class="cabecalho-codigo"><?= htmlspecialchars($equipamento['codigo']) ?></span>
                    <span class="cabecalho-separador">·</span>
                    <span id="cabecalho-nome-equipamento" class="cabecalho-nome"><?= htmlspecialchars($equipamento['designacao']) ?></span>
                </div>

                <a href="#" class="link-gerar-etiqueta" onclick="gerarEtiqueta()">
                    <i class="fa-solid fa-tag"></i>
                    Gerar Etiqueta
                </a>

                <a href="ficha_equipamento_pdf.php?id_equipamento=<?= htmlspecialchars($idEquipamentoEncriptado) ?>" target="_blank" class="link-exportar-pdf">
                    <i class="fa-solid fa-file-pdf"></i>
                    Exportar Ficha do Equipamento
                </a>

            </div>

            <div class="tabs-consulta-equipamento">

                <div class="botoes-tabs-equipamento">
                    <button type="button" class="botao-tab-equipamento ativo" data-tab="tab-identificacao-detalhe">
                        <i class="fa-solid fa-stethoscope"></i>
                        Identificação
                    </button>
                    <button type="button" class="botao-tab-equipamento" data-tab="tab-acessorios-detalhe">
                        <i class="fa-solid fa-toolbox"></i>
                        Acessórios e <br> Consumíveis
                    </button>
                    <button type="button" class="botao-tab-equipamento" data-tab="tab-aquisicao-detalhe">
                        <i class="fa-solid fa-cart-shopping"></i>
                        Aquisição
                    </button>
                    <button type="button" class="botao-tab-equipamento" data-tab="tab-fornecedor-detalhe">
                        <i class="fa-solid fa-truck-medical"></i>
                        Fornecedor
                    </button>
                    <button type="button" class="botao-tab-equipamento" data-tab="tab-localizacao-detalhe">
                        <i class="fa-solid fa-location-dot"></i>
                        Localização
                    </button>
                    <button type="button" class="botao-tab-equipamento" data-tab="tab-garantia-detalhe">
                        <i class="fa-solid fa-shield-halved"></i>
                        Garantia
                    </button>
                    <button type="button" class="botao-tab-equipamento" data-tab="tab-contrato-detalhe">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        Contrato
                    </button>
                    <button type="button" class="botao-tab-equipamento" data-tab="tab-documentacao-detalhe">
                        <i class="fa-solid fa-file-medical"></i>
                        Documentação
                    </button>
                </div>

                <!-- Separador 1: Identificação -->
                <div id="tab-identificacao-detalhe" class="conteudo-tab-equipamento ativo">

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-circle-info"></i>
                        Dados do Equipamento
                    </h5>

                    <div class="grelha-detalhes-equipamento">
                        <div class="campo-detalhes">
                            <h3>Código interno de inventário</h3>
                            <p id="detalhe-codigo"><?= htmlspecialchars($equipamento['codigo']) ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>Designação do equipamento</h3>
                            <p id="detalhe-designacao"><?= htmlspecialchars($equipamento['designacao']) ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>Categoria ou grupo
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
                            </h3>
                            <p id="detalhe-categoria"><?= htmlspecialchars($equipamento['categoria']) ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>Marca</h3>
                            <p id="detalhe-marca"><?= htmlspecialchars($equipamento['marca']) ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>Modelo</h3>
                            <p id="detalhe-modelo"><?= htmlspecialchars($equipamento['modelo']) ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>N.º de série</h3>
                            <p id="detalhe-numero-serie"><?= htmlspecialchars($equipamento['numero_serie']) ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>Fabricante</h3>
                            <p id="detalhe-fabricante"><?= htmlspecialchars($equipamento['fabricante']) ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>Ano de fabrico</h3>
                            <p id="detalhe-ano-fabrico"><?= htmlspecialchars($equipamento['ano_fabrico']) ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>
                                Estado atual
                                <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
                                    data-bs-trigger="hover focus" data-bs-placement="right" data-bs-html="true"
                                    data-bs-content="<strong>Ativo</strong> - Equipamento operacional e disponível para utilização.<br><br>
            <strong>Em manutenção</strong> - Equipamento temporariamente indisponível devido a manutenção preventiva ou corretiva.<br><br>
            <strong>Inativo</strong> - Equipamento sem utilização atual, mas disponível para voltar ao serviço.<br><br>
            <strong>Em calibração</strong> - Equipamento em processo de calibração ou verificação metrológica.<br><br>
            <strong>Em quarentena</strong> - Equipamento isolado temporariamente para avaliação, descontaminação ou validação técnica.<br><br>
            <strong>Abatido</strong> - Equipamento retirado definitivamente de serviço e sem possibilidade de utilização.">
                                </i>
                            </h3>
                            <p id="detalhe-estado"><span class="<?= $classeEstadoDetalhe ?>"><?= htmlspecialchars($equipamento['estado']) ?></span></p>
                        </div>
                        <div class="campo-detalhes campo-criticidade-destaque">
                            <h3>Criticidade
                                <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
                                    data-bs-trigger="hover focus" data-bs-placement="right" data-bs-html="true"
                                    data-bs-content="
        <strong>Suporte de vida</strong> - Equipamento essencial para manter ou monitorizar funções vitais do paciente.<br><br>
        <strong>Alta</strong> - Equipamento cuja indisponibilidade afeta significativamente a prestação de cuidados de saúde.<br><br>
        <strong>Média</strong> - Equipamento importante, mas cuja indisponibilidade pode ser temporariamente compensada por alternativas.<br><br>
        <strong>Baixa</strong> - Equipamento de apoio com impacto reduzido na prestação de cuidados.
        ">
                                </i>
                            </h3>
                            <p id="detalhe-criticidade"><span class="badge-detalhe <?= $classeCriticidadeDetalhe ?>"><?= htmlspecialchars($equipamento['criticidade']) ?></span></p>
                        </div>
                    </div>

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-folder-open"></i>
                        Documentação
                    </h5>

                    <div class="accordion-documentacao">

                        <div class="accordion-item-doc">
                            <button class="accordion-btn-doc" onclick="toggleAccordionDoc(this)">
                                <span>
                                    <i class="fa-solid fa-file-medical"></i>
                                    Documentação Técnica
                                </span>
                                <div class="accordion-btn-doc-direita">
                                    <span id="badge-accordion-tecnica" class="badge-detalhe <?= $docManualServico ? 'badge-sim' : 'badge-nao' ?>"><?= $docManualServico ? 'Sim' : 'Não' ?></span>
                                    <i class="fa-solid fa-chevron-down icone-accordion-doc"></i>
                                </div>
                            </button>
                            <div class="accordion-body-doc" style="display:none;">
                                <?php if (!$docManualServico) : ?>
                                    <p class="text-muted" style="padding: 1.2rem 0 0.5rem;">Não existe documentação associada a este equipamento.</p>
                                <?php else : ?>
                                    <div class="grelha-detalhes-equipamento" style="padding: 1.2rem 0 0.5rem;">
                                        <div class="campo-detalhes">
                                            <h3>Tipo de documentação</h3>
                                            <p id="detalhe-tem-doc-tecnica">Sim</p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Nome do manual técnico</h3>
                                            <p id="detalhe-nome-manual-tecnico"><?= htmlspecialchars($docManualServico['nome_documento']) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Data do manual técnico</h3>
                                            <p id="detalhe-data-manual-tecnico"><?= date('d/m/Y', strtotime($docManualServico['data_documento'])) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Validade do manual técnico</h3>
                                            <p id="detalhe-validade-manual-tecnico"><?= $docManualServico['validade_documento'] ? date('d/m/Y', strtotime($docManualServico['validade_documento'])) : 'Sem validade definida' ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Ficheiro PDF</h3>
                                            <p id="detalhe-ficheiro-manual-tecnico">
                                                <?php if (!empty($docManualServico['ficheiro_documento'])) : ?>
                                                    <a href="<?= BASE_URL ?>/uploads/documentacao_equipamentos/<?= htmlspecialchars($docManualServico['ficheiro_documento']) ?>" target="_blank" style="color: #005fae; font-weight: 600;">
                                                        <i class="fa-solid fa-file-pdf me-1"></i><?= htmlspecialchars($docManualServico['nome_original_ficheiro'] ?? 'Ver ficheiro') ?>
                                                    </a>
                                                <?php else : ?>
                                                    —
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="accordion-item-doc">
                            <button class="accordion-btn-doc" onclick="toggleAccordionDoc(this)">
                                <span>
                                    <i class="fa-solid fa-book-open"></i>
                                    Documentação de Utilização
                                </span>
                                <div class="accordion-btn-doc-direita">
                                    <span id="badge-accordion-utilizacao" class="badge-detalhe <?= $docManualUtilizacao ? 'badge-sim' : 'badge-nao' ?>"><?= $docManualUtilizacao ? 'Sim' : 'Não' ?></span>
                                    <i class="fa-solid fa-chevron-down icone-accordion-doc"></i>
                                </div>
                            </button>
                            <div class="accordion-body-doc" style="display:none;">
                                <?php if (!$docManualUtilizacao) : ?>
                                    <p class="text-muted" style="padding: 1.2rem 0 0.5rem;">Não existe documentação associada a este equipamento.</p>
                                <?php else : ?>
                                    <div class="grelha-detalhes-equipamento" style="padding: 1.2rem 0 0.5rem;">
                                        <div class="campo-detalhes">
                                            <h3>Tipo de documentação</h3>
                                            <p id="detalhe-tem-doc-utilizacao">Sim</p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Nome do manual de utilização</h3>
                                            <p id="detalhe-nome-manual-utilizacao"><?= htmlspecialchars($docManualUtilizacao['nome_documento']) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Data do manual de utilização</h3>
                                            <p id="detalhe-data-manual-utilizacao"><?= date('d/m/Y', strtotime($docManualUtilizacao['data_documento'])) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Validade do manual de utilização</h3>
                                            <p id="detalhe-validade-manual-utilizacao"><?= $docManualUtilizacao['validade_documento'] ? date('d/m/Y', strtotime($docManualUtilizacao['validade_documento'])) : 'Sem validade definida' ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Ficheiro PDF</h3>
                                            <p id="detalhe-ficheiro-manual-utilizacao">
                                                <?php if (!empty($docManualUtilizacao['ficheiro_documento'])) : ?>
                                                    <a href="<?= BASE_URL ?>/uploads/documentacao_equipamentos/<?= htmlspecialchars($docManualUtilizacao['ficheiro_documento']) ?>" target="_blank" style="color: #005fae; font-weight: 600;">
                                                        <i class="fa-solid fa-file-pdf me-1"></i><?= htmlspecialchars($docManualUtilizacao['nome_original_ficheiro'] ?? 'Ver ficheiro') ?>
                                                    </a>
                                                <?php else : ?>
                                                    —
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <div class="accordion-item-doc" style="margin-top: 0.5rem;">
                        <button class="accordion-btn-doc" onclick="toggleAccordionDoc(this)">
                            <span>
                                <i class="fa-solid fa-certificate"></i>
                                Documentação de Conformidade
                            </span>
                            <div class="accordion-btn-doc-direita">
                                <span id="badge-accordion-conformidade" class="badge-detalhe <?= $docDeclaracaoConformidade ? 'badge-sim' : 'badge-nao' ?>"><?= $docDeclaracaoConformidade ? 'Sim' : 'Não' ?></span>
                                <i class="fa-solid fa-chevron-down icone-accordion-doc"></i>
                            </div>
                        </button>
                        <div class="accordion-body-doc" style="display:none;">
                            <?php if (!$docDeclaracaoConformidade) : ?>
                                <p class="text-muted" style="padding: 1.2rem 0 0.5rem;">Não existe documentação associada a este equipamento.</p>
                            <?php else : ?>
                                <div class="grelha-detalhes-equipamento" style="padding: 1.2rem 0 0.5rem;">
                                    <div class="campo-detalhes">
                                        <h3>Tipo de documentação</h3>
                                        <p id="detalhe-tem-declaracao-conformidade">Sim</p>
                                    </div>
                                    <div class="campo-detalhes">
                                        <h3>Nome do documento</h3>
                                        <p id="detalhe-nome-declaracao-conformidade"><?= htmlspecialchars($docDeclaracaoConformidade['nome_documento']) ?></p>
                                    </div>
                                    <div class="campo-detalhes">
                                        <h3>Data do documento</h3>
                                        <p id="detalhe-data-declaracao-conformidade"><?= date('d/m/Y', strtotime($docDeclaracaoConformidade['data_documento'])) ?></p>
                                    </div>
                                    <div class="campo-detalhes">
                                        <h3>Validade do documento</h3>
                                        <p id="detalhe-validade-declaracao-conformidade"><?= $docDeclaracaoConformidade['validade_documento'] ? date('d/m/Y', strtotime($docDeclaracaoConformidade['validade_documento'])) : 'Sem validade definida' ?></p>
                                    </div>
                                    <div class="campo-detalhes">
                                        <h3>Ficheiro PDF</h3>
                                        <p id="detalhe-ficheiro-declaracao-conformidade">
                                            <?php if (!empty($docDeclaracaoConformidade['ficheiro_documento'])) : ?>
                                                <a href="<?= BASE_URL ?>/uploads/documentacao_equipamentos/<?= htmlspecialchars($docDeclaracaoConformidade['ficheiro_documento']) ?>" target="_blank" style="color: #005fae; font-weight: 600;">
                                                    <i class="fa-solid fa-file-pdf me-1"></i><?= htmlspecialchars($docDeclaracaoConformidade['nome_original_ficheiro'] ?? 'Ver ficheiro') ?>
                                                </a>
                                            <?php else : ?>
                                                —
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-comment-medical"></i>
                        Observações do Equipamento
                    </h5>

                    <div class="grelha-detalhes-equipamento">
                        <div class="campo-detalhes campo-detalhes-largo">
                            <h3>Observações</h3>
                            <p id="detalhe-observacoes"><?= htmlspecialchars($equipamento['observacoes'] ?? '') ?></p>
                        </div>
                    </div>

                </div>

                <!-- Separador 2: Acessórios e Consumíveis -->
                <div id="tab-acessorios-detalhe" class="conteudo-tab-equipamento">

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-toolbox"></i>
                        Acessórios
                    </h5>

                    <div id="resumo-acessorios-detalhe">
                        <?php if (empty($acessorios)) : ?>
                            <p style="color:#6b7280; font-style:italic;">Sem acessórios registados.</p>
                        <?php else : ?>
                            <div class="tabela-privada">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Referência</th>
                                            <th>Quantidade</th>
                                            <th>Estado</th>
                                            <th>Observações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($acessorios as $acessorio) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($acessorio['nome']) ?></td>
                                                <td><?= htmlspecialchars($acessorio['referencia']) ?></td>
                                                <td><?= htmlspecialchars($acessorio['quantidade']) ?> <?= htmlspecialchars($acessorio['unidade']) ?></td>
                                                <td><?= htmlspecialchars($acessorio['estado']) ?></td>
                                                <td><?= htmlspecialchars($acessorio['observacoes'] ?? '') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>

                    <hr>

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-box-open"></i>
                        Consumíveis
                    </h5>

                    <div id="resumo-consumiveis-detalhe">
                        <?php if (empty($consumiveis)) : ?>
                            <p style="color:#6b7280; font-style:italic;">Sem consumíveis registados.</p>
                        <?php else : ?>
                            <div class="tabela-privada">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Referência</th>
                                            <th>Quantidade</th>
                                            <th>Estado</th>
                                            <th>Observações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($consumiveis as $consumivel) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($consumivel['nome']) ?></td>
                                                <td><?= htmlspecialchars($consumivel['referencia']) ?></td>
                                                <td><?= htmlspecialchars($consumivel['quantidade']) ?> <?= htmlspecialchars($consumivel['unidade']) ?></td>
                                                <td><?= htmlspecialchars($consumivel['estado']) ?></td>
                                                <td><?= htmlspecialchars($consumivel['observacoes'] ?? '') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>

                <!-- Separador 3: Aquisição -->
                <div id="tab-aquisicao-detalhe" class="conteudo-tab-equipamento">

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-cart-shopping"></i>
                        Dados de Aquisição
                    </h5>

                    <div class="grelha-detalhes-equipamento">
                        <div class="campo-detalhes">
                            <h3>Data de aquisição</h3>
                            <p id="detalhe-data-aquisicao"><?= $aquisicao ? date('d/m/Y', strtotime($aquisicao['data_aquisicao'])) : '' ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>Custo de aquisição</h3>
                            <p id="detalhe-custo-aquisicao"><?= $aquisicao ? number_format($aquisicao['custo_aquisicao'], 2, ',', '.') . ' €' : '' ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>Tipo de entrada
                                <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
                                    data-bs-trigger="hover focus" data-bs-placement="right" data-bs-html="true"
                                    data-bs-content="
        <strong>Compra</strong> - Equipamento adquirido pela instituição através de compra direta.<br><br>
        <strong>Doação</strong> - Equipamento recebido sem custos por oferta de uma entidade ou particular.<br><br>
        <strong>Aluguer</strong> - Equipamento utilizado mediante pagamento periódico durante um período definido.<br><br>
        <strong>Empréstimo</strong> - Equipamento cedido temporariamente por outra entidade para utilização durante um período acordado.
        ">
                                </i>
                            </h3>
                            <p id="detalhe-tipo-entrada"><?= htmlspecialchars($aquisicao['tipo_entrada'] ?? '') ?></p>
                        </div>
                    </div>

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-folder-open"></i>
                        Documentação
                    </h5>

                    <div class="accordion-documentacao">

                        <div class="accordion-item-doc">
                            <button class="accordion-btn-doc" onclick="toggleAccordionDoc(this)">
                                <span>
                                    <i class="fa-solid fa-file-invoice"></i>
                                    Contrato de Aquisição
                                </span>
                                <div class="accordion-btn-doc-direita">
                                    <span id="badge-accordion-contrato-aquisicao"
                                        class="badge-detalhe <?= $docContratoAquisicao ? 'badge-sim' : 'badge-nao' ?>"><?= $docContratoAquisicao ? 'Sim' : 'Não' ?></span>
                                    <i class="fa-solid fa-chevron-down icone-accordion-doc"></i>
                                </div>
                            </button>
                            <div class="accordion-body-doc" style="display:none;">
                                <?php if (!$docContratoAquisicao) : ?>
                                    <p class="text-muted" style="padding: 1.2rem 0 0.5rem;">Não existe documentação associada a este equipamento.</p>
                                <?php else : ?>
                                    <div class="grelha-detalhes-equipamento" style="padding: 1.2rem 0 0.5rem;">
                                        <div class="campo-detalhes">
                                            <h3>Tipo de documentação</h3>
                                            <p id="detalhe-tem-contrato-aquisicao">Sim</p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Nome do contrato de aquisição</h3>
                                            <p id="detalhe-nome-contrato-aquisicao"><?= htmlspecialchars($docContratoAquisicao['nome_documento']) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Data do contrato de aquisição</h3>
                                            <p id="detalhe-data-contrato-aquisicao"><?= date('d/m/Y', strtotime($docContratoAquisicao['data_documento'])) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Validade do contrato de aquisição</h3>
                                            <p id="detalhe-validade-contrato-aquisicao"><?= $docContratoAquisicao['validade_documento'] ? date('d/m/Y', strtotime($docContratoAquisicao['validade_documento'])) : 'Sem validade definida' ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Ficheiro PDF</h3>
                                            <p id="detalhe-ficheiro-contrato-aquisicao">
                                                <?php if (!empty($docContratoAquisicao['ficheiro_documento'])) : ?>
                                                    <a href="<?= BASE_URL ?>/uploads/documentacao_equipamentos/<?= htmlspecialchars($docContratoAquisicao['ficheiro_documento']) ?>" target="_blank" style="color: #005fae; font-weight: 600;">
                                                        <i class="fa-solid fa-file-pdf me-1"></i><?= htmlspecialchars($docContratoAquisicao['nome_original_ficheiro'] ?? 'Ver ficheiro') ?>
                                                    </a>
                                                <?php else : ?>
                                                    —
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="accordion-item-doc">
                            <button class="accordion-btn-doc" onclick="toggleAccordionDoc(this)">
                                <span>
                                    <i class="fa-solid fa-receipt"></i>
                                    Fatura
                                </span>
                                <div class="accordion-btn-doc-direita">
                                    <span id="badge-accordion-fatura" class="badge-detalhe <?= $docFatura ? 'badge-sim' : 'badge-nao' ?>"><?= $docFatura ? 'Sim' : 'Não' ?></span>
                                    <i class="fa-solid fa-chevron-down icone-accordion-doc"></i>
                                </div>
                            </button>
                            <div class="accordion-body-doc" style="display:none;">
                                <?php if (!$docFatura) : ?>
                                    <p class="text-muted" style="padding: 1.2rem 0 0.5rem;">Não existe documentação associada a este equipamento.</p>
                                <?php else : ?>
                                    <div class="grelha-detalhes-equipamento" style="padding: 1.2rem 0 0.5rem;">
                                        <div class="campo-detalhes">
                                            <h3>Tipo de documentação</h3>
                                            <p id="detalhe-tem-fatura">Sim</p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Nome da fatura</h3>
                                            <p id="detalhe-nome-fatura"><?= htmlspecialchars($docFatura['nome_documento']) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Data da fatura</h3>
                                            <p id="detalhe-data-fatura"><?= date('d/m/Y', strtotime($docFatura['data_documento'])) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Ficheiro PDF</h3>
                                            <p id="detalhe-ficheiro-fatura">
                                                <?php if (!empty($docFatura['ficheiro_documento'])) : ?>
                                                    <a href="<?= BASE_URL ?>/uploads/documentacao_equipamentos/<?= htmlspecialchars($docFatura['ficheiro_documento']) ?>" target="_blank" style="color: #005fae; font-weight: 600;">
                                                        <i class="fa-solid fa-file-pdf me-1"></i><?= htmlspecialchars($docFatura['nome_original_ficheiro'] ?? 'Ver ficheiro') ?>
                                                    </a>
                                                <?php else : ?>
                                                    —
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-comment-medical"></i>
                        Observações da Aquisição
                    </h5>

                    <div class="grelha-detalhes-equipamento">
                        <div class="campo-detalhes campo-detalhes-largo">
                            <h3>Observações</h3>
                            <p id="detalhe-observacoes-aquisicao"><?= htmlspecialchars($equipamento['observacoes'] ?? '') ?></p>
                        </div>
                    </div>

                </div>

                <!-- Separador 4: Fornecedor -->
                <div id="tab-fornecedor-detalhe" class="conteudo-tab-equipamento">

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-truck-medical"></i>
                        Fornecedores Associados
                    </h5>

                    <?php if (empty($fornecedoresEquipamento)) : ?>
                        <p class="text-muted">Não existem fornecedores associados a este equipamento.</p>
                    <?php else : ?>
                        <div class="tabela-privada">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nome da empresa</th>
                                        <th>Tipo</th>
                                        <th>Pessoa de contacto</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
    <?php foreach ($fornecedoresEquipamento as $forn) : ?>
        <tr>
            <td><?= htmlspecialchars($forn['codigo']) ?></td>
            <td><?= htmlspecialchars($forn['nome_empresa']) ?></td>
            <td><?= htmlspecialchars($forn['tipo_fornecedor']) ?></td>
            <td><?= htmlspecialchars($forn['pessoa_contacto']) ?></td>
            <td class="acoes-tabela-privada">
                <?php if ($_SESSION['profile'] !== 'Profissional de Saúde') : ?>
                <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFornecedor"
                    style="display: inline-block; padding: 4px 14px; border: 1px solid #005fae; border-radius: 6px; background: none; color: #005fae; font-weight: 600; font-size: 0.85rem;"
                    onclick='abrirDetalhesFornecedorEquipamento(<?= json_encode($forn, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP) ?>)'>
                    Ver detalhes
                </button>
                <?php else : ?>
                    —
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Offcanvas fornecedor -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasFornecedor"
                    aria-labelledby="offcanvasFornecedorLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasFornecedorLabel">
                            <i class="fa-solid fa-truck-medical" style="color:#0086a8; margin-right:8px;"></i>
                            Detalhes do Fornecedor
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            aria-label="Fechar"></button>
                    </div>
                    <div class="offcanvas-body" id="offcanvas-body-fornecedor"></div>
                </div>

                <!-- Separador 5: Localização -->
                <div id="tab-localizacao-detalhe" class="conteudo-tab-equipamento">

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-location-dot"></i>
                        Localização Associada
                    </h5>

                    <div class="grelha-detalhes-equipamento">
                        <div class="campo-detalhes">
                            <h3>Código da localização</h3>
                            <p id="detalhe-localizacao-codigo"><?= htmlspecialchars($equipamento['localizacao_codigo']) ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>Edifício</h3>
                            <p id="detalhe-localizacao-edificio"><?= htmlspecialchars($equipamento['localizacao_edificio']) ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>Piso</h3>
                            <p id="detalhe-localizacao-piso"><?= htmlspecialchars($equipamento['localizacao_piso']) ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>Serviço</h3>
                            <p id="detalhe-localizacao-servico"><?= htmlspecialchars($equipamento['localizacao_servico']) ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>Sala</h3>
                            <p id="detalhe-localizacao-sala"><?= htmlspecialchars($equipamento['localizacao_sala']) ?></p>
                        </div>
                        <div class="campo-detalhes campo-detalhes-largo">
                            <h3>Observações da localização</h3>
                            <p id="detalhe-localizacao-observacoes"><?= htmlspecialchars($equipamento['observacoes'] ?? '') ?></p>
                        </div>
                    </div>

                </div>

                <!-- Separador 6: Garantia -->
                <div id="tab-garantia-detalhe" class="conteudo-tab-equipamento">

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-shield-halved"></i>
                        Dados da Garantia
                    </h5>

                    <div class="grelha-detalhes-equipamento">
                        <div class="campo-detalhes">
                            <h3>Data de início da garantia</h3>
                            <p id="detalhe-data-inicio-garantia"><?= $garantia ? date('d/m/Y', strtotime($garantia['data_inicio'])) : '' ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>Data de fim da garantia</h3>
                            <p id="detalhe-data-fim-garantia"><?= $garantia ? date('d/m/Y', strtotime($garantia['data_fim'])) : '' ?></p>
                        </div>
                        <div class="campo-detalhes">
                            <h3>Estado da garantia</h3>
                            <p id="badge-estado-garantia">
    <?php
    // Calcula o estado visual da garantia (ativa, perto de expirar, ou expirada) com base na data de fim
    $diasParaExpirar = (strtotime($garantia['data_fim']) - strtotime('today')) / 86400;

    if ($diasParaExpirar < 0) {
        $estadoGarantiaTexto = 'Expirada';
        $estadoGarantiaClasse = 'estado-abatido';
    } elseif ($diasParaExpirar <= 30) {
        $estadoGarantiaTexto = 'Expira nos próximos 30 dias';
        $estadoGarantiaClasse = 'estado-manutencao';
    } else {
        $estadoGarantiaTexto = 'Ativa';
        $estadoGarantiaClasse = 'estado-ativo';
    }
    ?>
    <span class="<?= $estadoGarantiaClasse ?>"><?= $estadoGarantiaTexto ?></span>
</p>
                        </div>
                    </div>

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-folder-open"></i>
                        Documentação
                    </h5>

                    <div class="accordion-documentacao">

                        <div class="accordion-item-doc">
                            <button class="accordion-btn-doc" onclick="toggleAccordionDoc(this)">
                                <span>
                                    <i class="fa-solid fa-file-medical"></i>
                                    Certificado de Garantia
                                </span>
                                <div class="accordion-btn-doc-direita">
                                    <span id="badge-accordion-garantia" class="badge-detalhe <?= $docCertificadoGarantia ? 'badge-sim' : 'badge-nao' ?>"><?= $docCertificadoGarantia ? 'Sim' : 'Não' ?></span>
                                    <i class="fa-solid fa-chevron-down icone-accordion-doc"></i>
                                </div>
                            </button>
                            <div class="accordion-body-doc" style="display:none;">
                                <?php if (!$docCertificadoGarantia) : ?>
                                    <p class="text-muted" style="padding: 1.2rem 0 0.5rem;">Não existe documentação associada a este equipamento.</p>
                                <?php else : ?>
                                    <div class="grelha-detalhes-equipamento" style="padding: 1.2rem 0 0.5rem;">
                                        <div class="campo-detalhes">
                                            <h3>Tipo de documento</h3>
                                            <p id="detalhe-tem-doc-garantia">Sim</p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Nome do certificado</h3>
                                            <p id="detalhe-nome-certificado-garantia"><?= htmlspecialchars($docCertificadoGarantia['nome_documento']) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Data do certificado</h3>
                                            <p id="detalhe-data-certificado-garantia"><?= date('d/m/Y', strtotime($docCertificadoGarantia['data_documento'])) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Validade do certificado</h3>
                                            <p id="detalhe-validade-certificado-garantia"><?= $docCertificadoGarantia['validade_documento'] ? date('d/m/Y', strtotime($docCertificadoGarantia['validade_documento'])) : 'Sem validade definida' ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Ficheiro PDF</h3>
                                            <p id="detalhe-ficheiro-garantia">
                                                <?php if (!empty($docCertificadoGarantia['ficheiro_documento'])) : ?>
                                                    <a href="<?= BASE_URL ?>/uploads/documentacao_equipamentos/<?= htmlspecialchars($docCertificadoGarantia['ficheiro_documento']) ?>" target="_blank" style="color: #005fae; font-weight: 600;">
                                                        <i class="fa-solid fa-file-pdf me-1"></i><?= htmlspecialchars($docCertificadoGarantia['nome_original_ficheiro'] ?? 'Ver ficheiro') ?>
                                                    </a>
                                                <?php else : ?>
                                                    —
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-comment-medical"></i>
                        Observações da Garantia
                    </h5>

                    <div class="grelha-detalhes-equipamento">
                        <div class="campo-detalhes campo-detalhes-largo">
                            <h3>Observações</h3>
                            <p id="detalhe-observacoes-garantia"><?= htmlspecialchars($equipamento['observacoes'] ?? '') ?></p>
                        </div>
                    </div>

                </div>

                <!-- Separador 7: Contrato -->
                <div id="tab-contrato-detalhe" class="conteudo-tab-equipamento">

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        Contrato de Manutenção
                    </h5>

                    <div class="grelha-detalhes-equipamento">
                        <div class="campo-detalhes">
                            <h3>Contrato de manutenção</h3>
                            <p id="detalhe-contrato-manutencao"><?= $contrato ? 'Sim' : 'Não' ?></p>
                        </div>
                       <div class="campo-detalhes">
    <h3>Tipo de contrato</h3>
    <p id="detalhe-tipo-contrato"><?= $contrato ? htmlspecialchars($contrato['tipo_contrato']) : 'Não existe' ?></p>
</div>
<div class="campo-detalhes">
    <h3>Entidade responsável</h3>
    <p id="detalhe-entidade-responsavel-contrato"><?= $contrato ? htmlspecialchars($contrato['entidade_responsavel']) : 'Não existe' ?></p>
</div>
<div class="campo-detalhes">
    <h3>Periodicidade</h3>
    <p id="detalhe-periodicidade-contrato"><?= $contrato ? htmlspecialchars($contrato['periodicidade']) : 'Não aplicável' ?></p>
</div>
                    </div>

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-folder-open"></i>
                        Documentação
                    </h5>

                    <div class="accordion-documentacao">

                        <div class="accordion-item-doc">
                            <button class="accordion-btn-doc" onclick="toggleAccordionDoc(this)">
                                <span>
                                    <i class="fa-solid fa-file-medical"></i>
                                    Contrato de Manutenção
                                </span>
                                <div class="accordion-btn-doc-direita">
                                    <span id="badge-accordion-doc-contrato" class="badge-detalhe <?= $docContratoManutencao ? 'badge-sim' : 'badge-nao' ?>"><?= $docContratoManutencao ? 'Sim' : 'Não' ?></span>
                                    <i class="fa-solid fa-chevron-down icone-accordion-doc"></i>
                                </div>
                            </button>
                            <div class="accordion-body-doc" style="display:none;">
                                <?php if (!$docContratoManutencao) : ?>
                                    <p class="text-muted" style="padding: 1.2rem 0 0.5rem;">Não existe documentação associada a este equipamento.</p>
                                <?php else : ?>
                                    <div class="grelha-detalhes-equipamento" style="padding: 1.2rem 0 0.5rem;">
                                        <div class="campo-detalhes">
                                            <h3>Tipo de documento</h3>
                                            <p id="detalhe-tem-doc-contrato">Sim</p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Nome do contrato</h3>
                                            <p id="detalhe-nome-contrato-manutencao"><?= htmlspecialchars($docContratoManutencao['nome_documento']) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Data do contrato</h3>
                                            <p id="detalhe-data-contrato-manutencao"><?= date('d/m/Y', strtotime($docContratoManutencao['data_documento'])) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Validade do contrato</h3>
                                            <p id="detalhe-validade-contrato-manutencao"><?= $docContratoManutencao['validade_documento'] ? date('d/m/Y', strtotime($docContratoManutencao['validade_documento'])) : 'Sem validade definida' ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Ficheiro PDF</h3>
                                            <p id="detalhe-ficheiro-contrato-manutencao">
                                                <?php if (!empty($docContratoManutencao['ficheiro_documento'])) : ?>
                                                    <a href="<?= BASE_URL ?>/uploads/documentacao_equipamentos/<?= htmlspecialchars($docContratoManutencao['ficheiro_documento']) ?>" target="_blank" style="color: #005fae; font-weight: 600;">
                                                        <i class="fa-solid fa-file-pdf me-1"></i><?= htmlspecialchars($docContratoManutencao['nome_original_ficheiro'] ?? 'Ver ficheiro') ?>
                                                    </a>
                                                <?php else : ?>
                                                    —
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="accordion-item-doc">
                            <button class="accordion-btn-doc" onclick="toggleAccordionDoc(this)">
                                <span>
                                    <i class="fa-solid fa-clipboard-list"></i>
                                    Relatório de Manutenção
                                </span>
                                <div class="accordion-btn-doc-direita">
                                    <span id="badge-accordion-relatorio-manutencao" class="badge-detalhe <?= $docRelatorioManutencao ? 'badge-sim' : 'badge-nao' ?>"><?= $docRelatorioManutencao ? 'Sim' : 'Não' ?></span> <i class="fa-solid fa-chevron-down icone-accordion-doc"></i>
                                </div>
                            </button>
                            <div class="accordion-body-doc" style="display:none;">
                                <?php if (!$docRelatorioManutencao) : ?>
                                    <p class="text-muted" style="padding: 1.2rem 0 0.5rem;">Não existe documentação associada a este equipamento.</p>
                                <?php else : ?>
                                    <div class="grelha-detalhes-equipamento" style="padding: 1.2rem 0 0.5rem;">
                                        <div class="campo-detalhes">
                                            <h3>Tipo de documento</h3>
                                            <p id="detalhe-tem-relatorio-contrato">Sim</p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Nome do relatório</h3>
                                            <p id="detalhe-nome-relatorio-manutencao"><?= htmlspecialchars($docRelatorioManutencao['nome_documento']) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Data do relatório</h3>
                                            <p id="detalhe-data-relatorio-manutencao"><?= date('d/m/Y', strtotime($docRelatorioManutencao['data_documento'])) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Validade do relatório</h3>
                                            <p id="detalhe-validade-relatorio-manutencao"><?= $docRelatorioManutencao['validade_documento'] ? date('d/m/Y', strtotime($docRelatorioManutencao['validade_documento'])) : 'Sem validade definida' ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Ficheiro PDF</h3>
                                            <p id="detalhe-ficheiro-relatorio-manutencao">
                                                <?php if (!empty($docRelatorioManutencao['ficheiro_documento'])) : ?>
                                                    <a href="<?= BASE_URL ?>/uploads/documentacao_equipamentos/<?= htmlspecialchars($docRelatorioManutencao['ficheiro_documento']) ?>" target="_blank" style="color: #005fae; font-weight: 600;">
                                                        <i class="fa-solid fa-file-pdf me-1"></i><?= htmlspecialchars($docRelatorioManutencao['nome_original_ficheiro'] ?? 'Ver ficheiro') ?>
                                                    </a>
                                                <?php else : ?>
                                                    —
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="accordion-item-doc">
                            <button class="accordion-btn-doc" onclick="toggleAccordionDoc(this)">
                                <span>
                                    <i class="fa-solid fa-book-open"></i>
                                    Certificado de Calibração
                                </span>
                                <div class="accordion-btn-doc-direita">
                                    <span id="badge-accordion-calibracao" class="badge-detalhe <?= $docCertificadoCalibracao ? 'badge-sim' : 'badge-nao' ?>"><?= $docCertificadoCalibracao ? 'Sim' : 'Não' ?></span>
                                    <i class="fa-solid fa-chevron-down icone-accordion-doc"></i>
                                </div>
                            </button>
                            <div class="accordion-body-doc" style="display:none;">
                                <?php if (!$docCertificadoCalibracao) : ?>
                                    <p class="text-muted" style="padding: 1.2rem 0 0.5rem;">Não existe documentação associada a este equipamento.</p>
                                <?php else : ?>
                                    <div class="grelha-detalhes-equipamento" style="padding: 1.2rem 0 0.5rem;">
                                        <div class="campo-detalhes">
                                            <h3>Tipo de documento</h3>
                                            <p id="detalhe-tem-doc-calibracao">Sim</p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Nome do certificado</h3>
                                            <p id="detalhe-nome-certificado-calibracao"><?= htmlspecialchars($docCertificadoCalibracao['nome_documento']) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Data do certificado</h3>
                                            <p id="detalhe-data-certificado-calibracao"><?= date('d/m/Y', strtotime($docCertificadoCalibracao['data_documento'])) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Validade do certificado</h3>
                                            <p id="detalhe-validade-certificado-calibracao"><?= $docCertificadoCalibracao['validade_documento'] ? date('d/m/Y', strtotime($docCertificadoCalibracao['validade_documento'])) : 'Sem validade definida' ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Ficheiro PDF</h3>
                                            <p id="detalhe-ficheiro-certificado-calibracao">
                                                <?php if (!empty($docCertificadoCalibracao['ficheiro_documento'])) : ?>
                                                    <a href="<?= BASE_URL ?>/uploads/documentacao_equipamentos/<?= htmlspecialchars($docCertificadoCalibracao['ficheiro_documento']) ?>" target="_blank" style="color: #005fae; font-weight: 600;">
                                                        <i class="fa-solid fa-file-pdf me-1"></i><?= htmlspecialchars($docCertificadoCalibracao['nome_original_ficheiro'] ?? 'Ver ficheiro') ?>
                                                    </a>
                                                <?php else : ?>
                                                    —
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="accordion-item-doc">
                            <button class="accordion-btn-doc" onclick="toggleAccordionDoc(this)">
                                <span>
                                    <i class="fa-solid fa-file-lines"></i>
                                    Relatório de Calibração
                                </span>
                                <div class="accordion-btn-doc-direita">
                                    <span id="badge-accordion-relatorio-calibracao"
                                        class="badge-detalhe <?= $docRelatorioCalibracao ? 'badge-sim' : 'badge-nao' ?>"><?= $docRelatorioCalibracao ? 'Sim' : 'Não' ?></span>
                                    <i class="fa-solid fa-chevron-down icone-accordion-doc"></i>
                                </div>
                            </button>
                            <div class="accordion-body-doc" style="display:none;">
                                <?php if (!$docRelatorioCalibracao) : ?>
                                    <p class="text-muted" style="padding: 1.2rem 0 0.5rem;">Não existe documentação associada a este equipamento.</p>
                                <?php else : ?>
                                    <div class="grelha-detalhes-equipamento" style="padding: 1.2rem 0 0.5rem;">
                                        <div class="campo-detalhes">
                                            <h3>Tipo de documento</h3>
                                            <p id="detalhe-tem-relatorio-calibracao">Sim</p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Nome do relatório</h3>
                                            <p id="detalhe-nome-relatorio-calibracao"><?= htmlspecialchars($docRelatorioCalibracao['nome_documento']) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Data do relatório</h3>
                                            <p id="detalhe-data-relatorio-calibracao"><?= date('d/m/Y', strtotime($docRelatorioCalibracao['data_documento'])) ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Validade do relatório</h3>
                                            <p id="detalhe-validade-relatorio-calibracao"><?= $docRelatorioCalibracao['validade_documento'] ? date('d/m/Y', strtotime($docRelatorioCalibracao['validade_documento'])) : 'Sem validade definida' ?></p>
                                        </div>
                                        <div class="campo-detalhes">
                                            <h3>Ficheiro PDF</h3>
                                            <p id="detalhe-ficheiro-relatorio-calibracao">
                                                <?php if (!empty($docRelatorioCalibracao['ficheiro_documento'])) : ?>
                                                    <a href="<?= BASE_URL ?>/uploads/documentacao_equipamentos/<?= htmlspecialchars($docRelatorioCalibracao['ficheiro_documento']) ?>" target="_blank" style="color: #005fae; font-weight: 600;">
                                                        <i class="fa-solid fa-file-pdf me-1"></i><?= htmlspecialchars($docRelatorioCalibracao['nome_original_ficheiro'] ?? 'Ver ficheiro') ?>
                                                    </a>
                                                <?php else : ?>
                                                    —
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-comment-medical"></i>
                        Observações do Contrato
                    </h5>

                    <div class="grelha-detalhes-equipamento">
                        <div class="campo-detalhes campo-detalhes-largo">
                            <h3>Observações</h3>
                            <p id="detalhe-observacoes-contrato"><?= htmlspecialchars($equipamento['observacoes'] ?? '') ?></p>
                        </div>
                    </div>

                </div>

                <!-- Separador 8: Documentação (resumo) -->
                <div id="tab-documentacao-detalhe" class="conteudo-tab-equipamento">

                    <h5 class="subtitulo-separador titulo-azul-separador">
                        <i class="fa-solid fa-file-medical"></i>
                        Resumo da Documentação Associada
                    </h5>

                    <p style="color:#6b7280; margin-bottom: 1.5rem;">
                        Toda a documentação registada para este equipamento, organizada por categoria.
                    </p>

                    <?php if (empty($documentosExistentesResumo)) : ?>
                        <p class="text-muted">Não existe nenhuma documentação associada a este equipamento.</p>
                    <?php else : ?>
                        <div class="accordion-documentacao">
                            <?php foreach ($documentosExistentesResumo as $item) : ?>
                                <?php $doc = $item['doc']; ?>
                                <div class="accordion-item-doc">
                                    <button class="accordion-btn-doc" onclick="toggleAccordionDoc(this)">
                                        <span>
                                            <i class="fa-solid <?= $item['icon'] ?>"></i>
                                            <?= htmlspecialchars($item['label']) ?>
                                        </span>
                                        <div class="accordion-btn-doc-direita">
                                            <?php if (!empty($doc['ficheiro_documento'])) : ?>
                                                <a href="<?= BASE_URL ?>/uploads/<?= $item['pasta'] ?>/<?= htmlspecialchars($doc['ficheiro_documento']) ?>" target="_blank" class="badge-detalhe badge-sim" style="text-decoration: none;" onclick="event.stopPropagation();">
                                                    <i class="fa-solid fa-file-pdf me-1"></i>Ver PDF
                                                </a>
                                            <?php else : ?>
                                                <span class="badge-detalhe badge-nao">Sem ficheiro</span>
                                            <?php endif; ?>
                                            <i class="fa-solid fa-chevron-down icone-accordion-doc"></i>
                                        </div>
                                    </button>
                                    <div class="accordion-body-doc" style="display:none;">
                                        <?= render_resumo_documento($doc) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <?php if (!empty($documentosFornecedoresEquipamento)) : ?>
                                <div class="accordion-item-doc">
                                    <button class="accordion-btn-doc" onclick="toggleAccordionDoc(this)">
                                        <span>
                                            <i class="fa-solid fa-truck-medical"></i>
                                            Documentação dos Fornecedores
                                        </span>
                                        <div class="accordion-btn-doc-direita">
                                            <i class="fa-solid fa-chevron-down icone-accordion-doc"></i>
                                        </div>
                                    </button>
                                    <div class="accordion-body-doc" style="display:none;">
                                        <div class="accordion-documentacao" style="padding: 0.5rem 0;">
                                            <?php foreach ($documentosFornecedoresEquipamento as $docForn) : ?>
                                                <div class="accordion-item-doc">
                                                    <button class="accordion-btn-doc" onclick="toggleAccordionDoc(this)">
                                                        <span>
                                                            <i class="fa-solid fa-building"></i>
                                                            <?= htmlspecialchars($docForn['fornecedor_codigo'] . ' - ' . $docForn['nome_empresa']) ?>
                                                        </span>
                                                        <div class="accordion-btn-doc-direita">
                                                            <?php if (!empty($docForn['ficheiro_documento'])) : ?>
                                                                <a href="<?= BASE_URL ?>/uploads/documentacao_fornecedores/<?= htmlspecialchars($docForn['ficheiro_documento']) ?>" target="_blank" class="badge-detalhe badge-sim" style="text-decoration: none;" onclick="event.stopPropagation();">
                                                                    <i class="fa-solid fa-file-pdf me-1"></i>Ver PDF
                                                                </a>
                                                            <?php else : ?>
                                                                <span class="badge-detalhe badge-nao">Sem ficheiro</span>
                                                            <?php endif; ?>
                                                            <i class="fa-solid fa-chevron-down icone-accordion-doc"></i>
                                                        </div>
                                                    </button>
                                                    <div class="accordion-body-doc" style="display:none;">
                                                        <?= render_resumo_documento($docForn, 'documentacao_fornecedores') ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="botoes-detalhes-equipamento">
    <a href="<?= htmlspecialchars($linkVoltarEquipamento) ?>" class="botao-voltar-detalhes">
        <i class="fa-solid fa-arrow-left"></i>
        Voltar
    </a>
</div>

        </section>

    </main>

</div>

<!-- Modal de geração de etiqueta com QR Code -->
<div id="modalEtiqueta" class="modal-etiqueta">

    <div class="conteudo-modal-etiqueta">

        <h3>MediVault</h3>

        <div id="qrcode-etiqueta"></div>

        <p id="codigoEtiqueta"></p>

        <p id="nomeEtiqueta"></p>

        <p id="localizacaoEtiqueta">
            <i class="fa-solid fa-location-dot"></i>
            <span id="textoLocalizacaoEtiqueta"></span>
        </p>

        <div class="botoes-modal-etiqueta">
            <button onclick="imprimirEtiqueta()">
                <i class="fa-solid fa-print"></i>
                Imprimir
            </button>
            <button onclick="fecharEtiqueta()">
                <i class="fa-solid fa-xmark"></i>
                Fechar
            </button>
        </div>

    </div>

</div>

<!-- ============================================================ -->
<!-- Script JavaScript da página -->
<!-- ============================================================ -->
<script>
    // Dados usados na geração da etiqueta com QR Code
    const LOCALIZACAO_ETIQUETA = "<?= htmlspecialchars($equipamento['localizacao_servico'] . ' · ' . $equipamento['localizacao_sala']) ?>";
    const URL_EQUIPAMENTO = "<?= BASE_URL ?>/private/views/equipamentos/consultar_equipamento.php?id_equipamento=<?= htmlspecialchars($idEquipamentoEncriptado) ?>";

    // Ativar os popovers do Bootstrap (tooltips informativos)
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('[data-bs-toggle="popover"]').forEach(function (el) {
            new bootstrap.Popover(el);
        });
    });

    // Preenche o offcanvas com os detalhes completos de um fornecedor associado
    function abrirDetalhesFornecedorEquipamento(dados) {
        const corpo = document.getElementById("offcanvas-body-fornecedor");
        if (!corpo) {
            return;
        }

        let websiteHtml = '—';
        if (dados.website) {
            const url = dados.website.startsWith('http') ? dados.website : ('https://' + dados.website);
            websiteHtml = `<a href="${url}" target="_blank" style="color:#005fae; font-weight:600;">${dados.website}</a>`;
        }

        corpo.innerHTML = `
            <h5 class="subtitulo-separador titulo-azul-separador" style="margin-top:0;">
                <i class="fa-solid fa-building"></i>
                Dados Gerais
            </h5>
            <div class="grelha-detalhes-equipamento" style="grid-template-columns: 1fr;">
                <div class="campo-detalhes">
                    <h3>Código</h3>
                    <p>${dados.codigo ?? ''}</p>
                </div>
                <div class="campo-detalhes">
                    <h3>Nome da empresa</h3>
                    <p>${dados.nome_empresa ?? ''}</p>
                </div>
                <div class="campo-detalhes">
                    <h3>NIF</h3>
                    <p>${dados.nif ?? ''}</p>
                </div>
                <div class="campo-detalhes">
                    <h3>Tipo de fornecedor</h3>
                    <p>${dados.tipo_fornecedor ?? ''}</p>
                </div>
                <div class="campo-detalhes">
                    <h3>Website</h3>
                    <p>${websiteHtml}</p>
                </div>
            </div>

            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-phone"></i>
                Contacto Geral
            </h5>
            <div class="grelha-detalhes-equipamento" style="grid-template-columns: 1fr;">
                <div class="campo-detalhes">
                    <h3>Contacto telefónico geral</h3>
                    <p>${dados.telefone_geral ?? ''}</p>
                </div>
                <div class="campo-detalhes">
                    <h3>Email geral</h3>
                    <p>${dados.email_geral ?? ''}</p>
                </div>
            </div>

            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-user"></i>
                Contacto para este Equipamento
            </h5>
            <div class="grelha-detalhes-equipamento" style="grid-template-columns: 1fr;">
                <div class="campo-detalhes">
                    <h3>Pessoa de contacto</h3>
                    <p>${dados.pessoa_contacto ?? '—'}</p>
                </div>
                <div class="campo-detalhes">
                    <h3>Telefone da pessoa de contacto</h3>
                    <p>${dados.telefone_pessoa_contacto ?? '—'}</p>
                </div>
            </div>

            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-location-dot"></i>
                Localização
            </h5>
            <div class="grelha-detalhes-equipamento" style="grid-template-columns: 1fr;">
                <div class="campo-detalhes">
                    <h3>Morada</h3>
                    <p>${dados.morada ?? '—'}</p>
                </div>
            </div>

            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-comment-medical"></i>
                Observações
            </h5>
            <div class="grelha-detalhes-equipamento" style="grid-template-columns: 1fr;">
                <div class="campo-detalhes">
                    <h3>Observações</h3>
                    <p>${dados.observacoes ?? '—'}</p>
                </div>
            </div>
        `;
    }
</script>

<?php include '../../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>