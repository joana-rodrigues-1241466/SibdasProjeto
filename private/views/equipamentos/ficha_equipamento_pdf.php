<?php
// ============================================================
// FICHA_EQUIPAMENTO_PDF.PHP
// Gera uma versão HTML "imprimível" da ficha completa de um
// equipamento (Identificação, Localização, Aquisição, Garantia,
// Contrato de Manutenção, Fornecedores, Acessórios, Consumíveis
// e Documentação), pronta a converter em PDF através da
// funcionalidade de impressão do browser (window.print()).
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Desencriptar e validar o ID do equipamento recebido na URL
$idEncriptado = $_GET['id_equipamento'] ?? null;
$id = aes_decrypt($idEncriptado);

if (!$id || !is_numeric($id)) {
    header('Location: ' . BASE_URL . '/private/views/equipamentos/equipamentos.php');
    exit;
}

// --------------------------------------------------------------------
// CARREGAMENTO DE TODOS OS DADOS DO EQUIPAMENTO PARA A FICHA
// --------------------------------------------------------------------
try {
    $ligacao = conectar_bd();

    // Dados principais do equipamento (identificação, categoria, estado, criticidade, localização)
    $stmt = $ligacao->prepare("
        SELECT e.*, cat.designacao AS categoria, ee.designacao AS estado, c.designacao AS criticidade,
               l.codigo AS loc_codigo, l.edificio, l.piso, l.servico, l.sala
        FROM equipamentos e
        LEFT JOIN categorias cat ON e.categoria_id = cat.id
        LEFT JOIN estados_equipamento ee ON e.estado_id = ee.id
        LEFT JOIN criticidades c ON e.criticidade_id = c.id
        LEFT JOIN localizacoes l ON e.localizacao_id = l.id
        WHERE e.id = :id
    ");
    $stmt->execute([':id' => $id]);
    $eq = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$eq) {
        header('Location: ' . BASE_URL . '/private/views/equipamentos/equipamentos.php');
        exit;
    }

    // Dados de aquisição
    $stmtAq = $ligacao->prepare("
        SELECT aq.data_aquisicao, aq.custo_aquisicao, aq.observacoes, te.designacao AS tipo_entrada
        FROM aquisicao_equipamentos aq
        LEFT JOIN tipos_entrada te ON aq.tipo_entrada_id = te.id
        WHERE aq.equipamento_id = :id
    ");
    $stmtAq->execute([':id' => $id]);
    $aquisicao = $stmtAq->fetch(PDO::FETCH_ASSOC);

    // Garantia
    $stmtGar = $ligacao->prepare("SELECT * FROM garantias_equipamentos WHERE equipamento_id = :id");
    $stmtGar->execute([':id' => $id]);
    $garantia = $stmtGar->fetch(PDO::FETCH_ASSOC);

    // Contrato de manutenção
    $stmtCont = $ligacao->prepare("
        SELECT cm.entidade_responsavel, cm.observacoes, tc.designacao AS tipo_contrato, p.designacao AS periodicidade
        FROM contratos_manutencao cm
        LEFT JOIN tipos_contrato tc ON cm.tipo_contrato_id = tc.id
        LEFT JOIN periodicidades p ON cm.periodicidade_id = p.id
        WHERE cm.equipamento_id = :id
    ");
    $stmtCont->execute([':id' => $id]);
    $contrato = $stmtCont->fetch(PDO::FETCH_ASSOC);

    // Fornecedores associados
    $stmtForn = $ligacao->prepare("
        SELECT f.codigo, f.nome_empresa, tf.designacao AS tipo, ef.pessoa_contacto, ef.telefone_pessoa_contacto
        FROM equipamento_fornecedor ef
        JOIN fornecedores f ON f.id = ef.fornecedor_id
        LEFT JOIN tipos_fornecedor tf ON f.tipo_id = tf.id
        WHERE ef.equipamento_id = :id
    ");
    $stmtForn->execute([':id' => $id]);
    $fornecedores = $stmtForn->fetchAll(PDO::FETCH_ASSOC);

    // Acessórios
    $stmtAcess = $ligacao->prepare("
        SELECT a.nome, a.referencia, a.quantidade, u.designacao AS unidade, ea.designacao AS estado, a.observacoes
        FROM acessorios a
        LEFT JOIN unidades u ON a.unidade_id = u.id
        LEFT JOIN estados_acessorio ea ON a.estado_id = ea.id
        WHERE a.equipamento_id = :id
        ORDER BY a.nome
    ");
    $stmtAcess->execute([':id' => $id]);
    $acessorios = $stmtAcess->fetchAll(PDO::FETCH_ASSOC);

    // Consumíveis
    $stmtCons = $ligacao->prepare("
        SELECT c.nome, c.referencia, c.quantidade, u.designacao AS unidade, ea.designacao AS estado, c.observacoes
        FROM consumiveis c
        LEFT JOIN unidades u ON c.unidade_id = u.id
        LEFT JOIN estados_acessorio ea ON c.estado_id = ea.id
        WHERE c.equipamento_id = :id
        ORDER BY c.nome
    ");
    $stmtCons->execute([':id' => $id]);
    $consumiveis = $stmtCons->fetchAll(PDO::FETCH_ASSOC);

    // Documentação associada
    $stmtDocs = $ligacao->prepare("
        SELECT de.nome_documento, de.data_documento, de.validade_documento, tde.designacao AS tipo_documento
        FROM documentacao_equipamentos de
        JOIN tipos_documento_equipamento tde ON de.tipo_documento_id = tde.id
        WHERE de.equipamento_id = :id
        ORDER BY tde.ordem
    ");
    $stmtDocs->execute([':id' => $id]);
    $documentos = $stmtDocs->fetchAll(PDO::FETCH_ASSOC);

    $ligacao = null;
} catch (PDOException $e) {
    die('Erro: ' . $e->getMessage());
}

// Calcular o estado textual da garantia (Em vigor / A expirar em breve / Expirada)
$diasGarantia = $garantia ? (strtotime($garantia['data_fim']) - strtotime('today')) / 86400 : null;
if ($diasGarantia === null) $estadoGarantia = '—';
elseif ($diasGarantia < 0) $estadoGarantia = 'Expirada';
elseif ($diasGarantia <= 30) $estadoGarantia = 'A expirar em breve';
else $estadoGarantia = 'Em vigor';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Ficha do Equipamento <?= htmlspecialchars($eq['codigo']) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1a1a1a; padding: 20px; }

        .cabecalho { display: flex; align-items: center; justify-content: space-between; border-bottom: 3px solid #003f78; padding-bottom: 12px; margin-bottom: 20px; }
        .cabecalho-logo { display: flex; align-items: center; gap: 10px; }
        .cabecalho-logo img { height: 45px; }
        .cabecalho-logo span { font-size: 22px; font-weight: 700; color: #003f78; letter-spacing: 2px; }
        .cabecalho-info { text-align: right; color: #555; font-size: 10px; }
        .cabecalho-info strong { font-size: 13px; color: #003f78; display: block; }

        .secao { margin-bottom: 16px; }
        .secao-titulo { background: #003f78; color: white; padding: 5px 10px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .grelha { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; padding: 0 4px; }
        .grelha-2 { grid-template-columns: repeat(2, 1fr); }
        .grelha-1 { grid-template-columns: 1fr; }
        .campo label { font-size: 9px; font-weight: 700; color: #005fae; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 2px; }
        .campo p { font-size: 11px; color: #1a1a1a; border-bottom: 1px solid #e0e0e0; padding-bottom: 4px; min-height: 18px; }

        table { width: 100%; border-collapse: collapse; font-size: 10px; margin-top: 4px; }
        table th { background: #e8f0fb; color: #003f78; font-weight: 700; padding: 5px 8px; text-align: left; border: 1px solid #ccd9f0; }
        table td { padding: 4px 8px; border: 1px solid #e0e0e0; }
        table tr:nth-child(even) td { background: #f8faff; }

        .rodape { border-top: 1px solid #ccc; margin-top: 20px; padding-top: 8px; text-align: center; font-size: 9px; color: #888; }

        @media print {
            body { padding: 10px; }
            @page { margin: 1cm; size: A4; }
        }
    </style>
</head>
<body>

    <!-- Cabeçalho da ficha -->
    <div class="cabecalho">
        <div class="cabecalho-logo">
            <img src="/medivault/assets/imagens/LOGO.png" alt="MediVault">
            <span>MediVault</span>
        </div>
        <div class="cabecalho-info">
            <strong>Ficha do Equipamento</strong>
            <?= htmlspecialchars($eq['codigo']) ?> — <?= htmlspecialchars($eq['designacao']) ?><br>
            Gerado em <?= date('d/m/Y \à\s H:i') ?>
        </div>
    </div>

    <!-- Identificação -->
    <div class="secao">
        <div class="secao-titulo">Identificação</div>
        <div class="grelha">
            <div class="campo"><label>Código</label><p><?= htmlspecialchars($eq['codigo']) ?></p></div>
            <div class="campo"><label>Designação</label><p><?= htmlspecialchars($eq['designacao']) ?></p></div>
            <div class="campo"><label>Categoria</label><p><?= htmlspecialchars($eq['categoria']) ?></p></div>
            <div class="campo"><label>Marca</label><p><?= htmlspecialchars($eq['marca']) ?></p></div>
            <div class="campo"><label>Modelo</label><p><?= htmlspecialchars($eq['modelo']) ?></p></div>
            <div class="campo"><label>N.º de Série</label><p><?= htmlspecialchars($eq['numero_serie']) ?></p></div>
            <div class="campo"><label>Fabricante</label><p><?= htmlspecialchars($eq['fabricante']) ?></p></div>
            <div class="campo"><label>Ano de Fabrico</label><p><?= htmlspecialchars($eq['ano_fabrico'] ?? '—') ?></p></div>
            <div class="campo"><label>Estado</label><p><?= htmlspecialchars($eq['estado']) ?></p></div>
            <div class="campo"><label>Criticidade</label><p><?= htmlspecialchars($eq['criticidade']) ?></p></div>
        </div>
        <?php if (!empty($eq['observacoes'])) : ?>
            <div class="grelha grelha-1" style="margin-top:8px;">
                <div class="campo"><label>Observações</label><p><?= htmlspecialchars($eq['observacoes']) ?></p></div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Localização -->
    <div class="secao">
        <div class="secao-titulo">Localização</div>
        <div class="grelha">
            <div class="campo"><label>Código</label><p><?= htmlspecialchars($eq['loc_codigo'] ?? '—') ?></p></div>
            <div class="campo"><label>Edifício</label><p><?= htmlspecialchars($eq['edificio'] ?? '—') ?></p></div>
            <div class="campo"><label>Piso</label><p><?= htmlspecialchars($eq['piso'] ?? '—') ?></p></div>
            <div class="campo"><label>Serviço</label><p><?= htmlspecialchars($eq['servico'] ?? '—') ?></p></div>
            <div class="campo"><label>Sala</label><p><?= htmlspecialchars($eq['sala'] ?? '—') ?></p></div>
        </div>
    </div>

    <!-- Aquisição -->
    <?php if ($aquisicao) : ?>
    <div class="secao">
        <div class="secao-titulo">Aquisição</div>
        <div class="grelha">
            <div class="campo"><label>Data de Aquisição</label><p><?= $aquisicao['data_aquisicao'] ? date('d/m/Y', strtotime($aquisicao['data_aquisicao'])) : '—' ?></p></div>
            <div class="campo"><label>Custo de Aquisição</label><p><?= number_format($aquisicao['custo_aquisicao'], 2, ',', '.') ?> €</p></div>
            <div class="campo"><label>Tipo de Entrada</label><p><?= htmlspecialchars($aquisicao['tipo_entrada'] ?? '—') ?></p></div>
        </div>
        <?php if (!empty($aquisicao['observacoes'])) : ?>
        <div class="grelha grelha-1" style="margin-top:6px; padding: 0 4px;">
            <div class="campo"><label>Observações</label><p><?= htmlspecialchars($aquisicao['observacoes']) ?></p></div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Garantia -->
    <?php if ($garantia) : ?>
    <div class="secao">
        <div class="secao-titulo">Garantia</div>
        <div class="grelha">
            <div class="campo"><label>Início da Garantia</label><p><?= date('d/m/Y', strtotime($garantia['data_inicio'])) ?></p></div>
            <div class="campo"><label>Fim da Garantia</label><p><?= date('d/m/Y', strtotime($garantia['data_fim'])) ?></p></div>
            <div class="campo"><label>Estado da Garantia</label><p><?= $estadoGarantia ?></p></div>
        </div>
        <?php if (!empty($garantia['observacoes'])) : ?>
        <div class="grelha grelha-1" style="margin-top:6px; padding: 0 4px;">
            <div class="campo"><label>Observações</label><p><?= htmlspecialchars($garantia['observacoes']) ?></p></div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Contrato de Manutenção -->
    <div class="secao">
        <div class="secao-titulo">Contrato de Manutenção</div>
        <div class="grelha">
            <div class="campo"><label>Contrato</label><p><?= $contrato ? 'Sim' : 'Não' ?></p></div>
            <div class="campo"><label>Tipo</label><p><?= htmlspecialchars($contrato['tipo_contrato'] ?? 'Não existe') ?></p></div>
            <div class="campo"><label>Entidade Responsável</label><p><?= htmlspecialchars($contrato['entidade_responsavel'] ?? 'Não existe') ?></p></div>
            <div class="campo"><label>Periodicidade</label><p><?= htmlspecialchars($contrato['periodicidade'] ?? 'Não aplicável') ?></p></div>
        </div>
        <?php if (!empty($contrato['observacoes'])) : ?>
        <div class="grelha grelha-1" style="margin-top:6px; padding: 0 4px;">
            <div class="campo"><label>Observações</label><p><?= htmlspecialchars($contrato['observacoes']) ?></p></div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Fornecedores -->
    <?php if (!empty($fornecedores)) : ?>
    <div class="secao">
        <div class="secao-titulo">Fornecedores Associados</div>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome da Empresa</th>
                    <th>Tipo</th>
                    <th>Pessoa de Contacto</th>
                    <th>Telefone</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fornecedores as $f) : ?>
                    <tr>
                        <td><?= htmlspecialchars($f['codigo']) ?></td>
                        <td><?= htmlspecialchars($f['nome_empresa']) ?></td>
                        <td><?= htmlspecialchars($f['tipo']) ?></td>
                        <td><?= htmlspecialchars($f['pessoa_contacto']) ?></td>
                        <td><?= htmlspecialchars($f['telefone_pessoa_contacto']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Acessórios -->
    <?php if (!empty($acessorios)) : ?>
    <div class="secao">
        <div class="secao-titulo">Acessórios</div>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Referência</th>
                    <th>Quantidade</th>
                    <th>Unidade</th>
                    <th>Estado</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($acessorios as $a) : ?>
                    <tr>
                        <td><?= htmlspecialchars($a['nome']) ?></td>
                        <td><?= htmlspecialchars($a['referencia']) ?></td>
                        <td><?= htmlspecialchars($a['quantidade']) ?></td>
                        <td><?= htmlspecialchars($a['unidade']) ?></td>
                        <td><?= htmlspecialchars($a['estado']) ?></td>
                        <td><?= htmlspecialchars($a['observacoes']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Consumíveis -->
    <?php if (!empty($consumiveis)) : ?>
    <div class="secao">
        <div class="secao-titulo">Consumíveis</div>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Referência</th>
                    <th>Quantidade</th>
                    <th>Unidade</th>
                    <th>Estado</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consumiveis as $c) : ?>
                    <tr>
                        <td><?= htmlspecialchars($c['nome']) ?></td>
                        <td><?= htmlspecialchars($c['referencia']) ?></td>
                        <td><?= htmlspecialchars($c['quantidade']) ?></td>
                        <td><?= htmlspecialchars($c['unidade']) ?></td>
                        <td><?= htmlspecialchars($c['estado']) ?></td>
                        <td><?= htmlspecialchars($c['observacoes']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Documentação -->
    <?php if (!empty($documentos)) : ?>
    <div class="secao">
        <div class="secao-titulo">Documentação Associada</div>
        <table>
            <thead>
                <tr>
                    <th>Tipo de Documento</th>
                    <th>Nome</th>
                    <th>Data</th>
                    <th>Validade</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documentos as $doc) : ?>
                    <tr>
                        <td><?= htmlspecialchars($doc['tipo_documento']) ?></td>
                        <td><?= htmlspecialchars($doc['nome_documento']) ?></td>
                        <td><?= date('d/m/Y', strtotime($doc['data_documento'])) ?></td>
                        <td><?= $doc['validade_documento'] ? date('d/m/Y', strtotime($doc['validade_documento'])) : 'Sem validade' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <div class="rodape">
        MediVault — Sistema de Inventário de Equipamentos Hospitalares &nbsp;|&nbsp; Ficha gerada em <?= date('d/m/Y \à\s H:i') ?>
    </div>

</body>
</html>

<!-- ============================================================ -->
<!-- Script JavaScript: dispara a impressão automaticamente -->
<!-- ============================================================ -->
<script>
    window.onload = function () {
        window.print();
    };
</script>