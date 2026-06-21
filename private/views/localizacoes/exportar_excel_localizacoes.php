<?php
// ============================================================
// EXPORTAR_EXCEL_LOCALIZACOES.PHP
// Gera e envia para download um ficheiro CSV (compatível com
// Excel) com a listagem de todas as localizações ativas,
// incluindo o número de equipamentos associados a cada uma.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Obter os dados das localizações a exportar
try {
    $ligacao = conectar_bd();

    $resultados = $ligacao->query("
        SELECT l.codigo, l.edificio, l.piso, l.servico, l.sala, l.observacoes,
               COUNT(e.id) AS total_equipamentos
        FROM localizacoes l
        LEFT JOIN equipamentos e ON e.localizacao_id = l.id AND e.ativo = 1
        WHERE l.ativo = 1
        GROUP BY l.id
        ORDER BY l.codigo
    ")->fetchAll(PDO::FETCH_ASSOC);

    $ligacao = null;
} catch (PDOException $e) {
    registar_erro_log($e->getMessage());
    die('Erro ao ligar à base de dados.');
}

// Configurar os cabeçalhos HTTP para forçar o download do ficheiro CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="listagem_localizacoes_' . date('Y-m-d') . '.csv"');
header('Pragma: no-cache');
header('Expires: 0');

// BOM para UTF-8 — garante que os acentos aparecem corretos no Excel
echo "\xEF\xBB\xBF";

$saida = fopen('php://output', 'w');

// Linha de cabeçalho do CSV
fputcsv($saida, [
    'Código', 'Edifício', 'Piso', 'Serviço/Departamento', 'Sala/Gabinete', 'Observações', 'Total de Equipamentos'
], ';');

// Uma linha por cada localização
foreach ($resultados as $linha) {
    fputcsv($saida, [
        $linha['codigo'],
        $linha['edificio'],
        $linha['piso'],
        $linha['servico'],
        $linha['sala'],
        $linha['observacoes'] ?? '',
        $linha['total_equipamentos'],
    ], ';');
}

fclose($saida);
exit;