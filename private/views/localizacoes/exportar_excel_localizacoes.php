<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    die('Erro ao ligar à base de dados.');
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="listagem_localizacoes_' . date('Y-m-d') . '.csv"');
header('Pragma: no-cache');
header('Expires: 0');

echo "\xEF\xBB\xBF";

$saida = fopen('php://output', 'w');

fputcsv($saida, [
    'Código', 'Edifício', 'Piso', 'Serviço/Departamento', 'Sala/Gabinete', 'Observações', 'Total de Equipamentos'
], ';');

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