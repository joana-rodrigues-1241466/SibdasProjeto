<?php
// ============================================================
// EXPORTAR_JSON_EQUIPAMENTOS.PHP
// Gera e envia para download um ficheiro JSON com a listagem
// de todos os equipamentos ativos.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Obter os dados dos equipamentos a exportar
try {
    $ligacao = conectar_bd();

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
    registar_erro_log($e->getMessage());
    die('Erro ao ligar à base de dados.');
}

// Configurar os cabeçalhos HTTP para forçar o download do ficheiro JSON
header('Content-Type: application/json; charset=utf-8');
header('Content-Disposition: attachment; filename="listagem_equipamentos_' . date('Y-m-d') . '.json"');
header('Pragma: no-cache');
header('Expires: 0');

// Gerar o JSON formatado (legível) com acentos corretos
echo json_encode($resultados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;