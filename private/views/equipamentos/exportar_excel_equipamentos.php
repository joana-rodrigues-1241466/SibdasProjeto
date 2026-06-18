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
        SELECT e.codigo, e.designacao,
               CONCAT(l.edificio, ', ', l.piso, ', ', l.servico, ', ', l.sala) AS localizacao,
               ee.designacao AS estado,
               c.designacao AS criticidade,
               cat.designacao AS categoria,
               e.marca,
               e.modelo,
               e.numero_serie,
               e.fabricante,
               e.ano_fabrico
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
    die('Erro ao ligar à base de dados.');
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="listagem_equipamentos_' . date('Y-m-d') . '.csv"');
header('Pragma: no-cache');
header('Expires: 0');

// BOM para UTF-8 — garante acentos corretos no Excel
echo "\xEF\xBB\xBF";

$saida = fopen('php://output', 'w');

// Cabeçalhos
fputcsv($saida, [
    'Código', 'Designação', 'Localização', 'Estado', 'Criticidade',
    'Categoria', 'Marca', 'Modelo', 'N.º de Série', 'Fabricante', 'Ano de Fabrico'
], ';');

// Dados
foreach ($resultados as $linha) {
    fputcsv($saida, [
        $linha['codigo'],
        $linha['designacao'],
        $linha['localizacao'],
        $linha['estado'],
        $linha['criticidade'],
        $linha['categoria'],
        $linha['marca'],
        $linha['modelo'],
        $linha['numero_serie'],
        $linha['fabricante'],
        $linha['ano_fabrico'] ?? '',
    ], ';');
}

fclose($saida);
exit;