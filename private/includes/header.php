<?php
// ============================================================
// HEADER.PHP
// Cabeçalho comum a todas as páginas da área privada.
// Carrega a configuração da aplicação e abre a estrutura HTML
// base (DOCTYPE, <head> com metadados/folhas de estilo, e o
// início do <body>), incluindo as bibliotecas externas (jQuery,
// DataTables, Bootstrap, Font Awesome) e o CSS próprio do projeto.
// ============================================================
require_once __DIR__ . '/../../config/config.php';
?>

<!DOCTYPE html>
<html lang="pt">

<!-- jQuery -->
<script src="<?= BASE_URL ?>/assets/jquery/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS + JS -->
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/datatables/datatables.min.css">
<script src="<?= BASE_URL ?>/assets/datatables/datatables.min.js"></script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>

    <link rel="shortcut icon" href="<?= BASE_URL ?>/assets/imagens/LOGO.png" type="image/png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/1241466.css">
</head>

<body class="pagina-privada">