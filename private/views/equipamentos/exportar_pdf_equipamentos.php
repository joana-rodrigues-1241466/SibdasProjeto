<?php
// ============================================================
// LISTAGEM_EQUIPAMENTOS_PDF.PHP
// Gera uma versão HTML "imprimível" com a listagem completa
// de todos os equipamentos ativos, pronta a converter em PDF
// através da funcionalidade de impressão do browser (window.print()).
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// --------------------------------------------------------------------
// CARREGAMENTO DA LISTAGEM DE EQUIPAMENTOS
// --------------------------------------------------------------------
try {
    $ligacao = conectar_bd();

    $equipamentos = $ligacao->query("
        SELECT e.codigo, e.designacao,
               l.codigo AS localizacao,
               ee.designacao AS estado,
               c.designacao AS criticidade,
               cat.designacao AS categoria
        FROM equipamentos e
        LEFT JOIN localizacoes l ON e.localizacao_id = l.id
        LEFT JOIN estados_equipamento ee ON e.estado_id = ee.id
        LEFT JOIN criticidades c ON e.criticidade_id = c.id
        LEFT JOIN categorias cat ON e.categoria_id = cat.id
        WHERE e.ativo = 1
        ORDER BY e.codigo
    ")->fetchAll(PDO::FETCH_ASSOC);

    $ligacao = null;
} catch (PDOException $e) {
    registar_erro_log($e->getMessage());
    die('Erro: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Equipamentos</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1a1a1a; padding: 20px; }

        .cabecalho { display: flex; align-items: center; justify-content: space-between; border-bottom: 3px solid #003f78; padding-bottom: 12px; margin-bottom: 20px; }
        .cabecalho-logo { display: flex; align-items: center; gap: 10px; }
        .cabecalho-logo img { height: 45px; }
        .cabecalho-logo span { font-size: 22px; font-weight: 700; color: #003f78; letter-spacing: 2px; }
        .cabecalho-info { text-align: right; color: #555; font-size: 10px; }
        .cabecalho-info strong { font-size: 13px; color: #003f78; display: block; }

        table { width: 100%; border-collapse: collapse; font-size: 10px; margin-top: 4px; }
        table th { background: #e8f0fb; color: #003f78; font-weight: 700; padding: 6px 8px; text-align: left; border: 1px solid #ccd9f0; }
        table td { padding: 5px 8px; border: 1px solid #e0e0e0; }
        table tr:nth-child(even) td { background: #f8faff; }

        .rodape { border-top: 1px solid #ccc; margin-top: 20px; padding-top: 8px; text-align: center; font-size: 9px; color: #888; }

        @media print {
            body { padding: 10px; }
            @page { margin: 1cm; size: A4 landscape; }
        }
    </style>
</head>
<body>

    <!-- Cabeçalho da listagem -->
    <div class="cabecalho">
        <div class="cabecalho-logo">
            <img src="<?= BASE_URL ?>/assets/imagens/LOGO.png" alt="MediVault">
            <span>MediVault</span>
        </div>
        <div class="cabecalho-info">
            <strong>Listagem de Equipamentos</strong>
            <?= count($equipamentos) ?> equipamento<?= count($equipamentos) !== 1 ? 's' : '' ?> ativo<?= count($equipamentos) !== 1 ? 's' : '' ?><br>
            Gerado em <?= date('d/m/Y \à\s H:i') ?>
        </div>
    </div>

    <!-- Tabela com todos os equipamentos ativos -->
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Designação</th>
                <th>Localização</th>
                <th>Categoria</th>
                <th>Estado</th>
                <th>Criticidade</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($equipamentos)) : ?>
                <tr><td colspan="6" style="text-align:center;">Não existem equipamentos registados.</td></tr>
            <?php else : ?>
                <?php foreach ($equipamentos as $eq) : ?>
                    <tr>
                        <td><?= htmlspecialchars($eq['codigo']) ?></td>
                        <td><?= htmlspecialchars($eq['designacao']) ?></td>
                        <td><?= htmlspecialchars($eq['localizacao'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($eq['categoria'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($eq['estado'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($eq['criticidade'] ?? '—') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="rodape">
        MediVault — Sistema de Inventário de Equipamentos Hospitalares &nbsp;|&nbsp; Listagem gerada em <?= date('d/m/Y \à\s H:i') ?>
    </div>

</body>
</html>

<script>
    window.onload = function () {
        window.print();
    };
</script>