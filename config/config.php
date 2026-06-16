<?php
define('APP_NAME', 'MediVault');
define('APP_VERSION', '1.0.0');
define('APP_COPYRIGHT', '© 2025 MediVault');

define('BASE_URL', '/medivault');

define('MYSQL_HOST', 'vsgate-s1.dei.isep.ipp.pt');
define('MYSQL_DATABASE', 'db1241466');
define('MYSQL_USERNAME', '1241466');
define('MYSQL_PASSWORD', 'rodrigues_466');
define('MYSQL_PORT', '10464');

define('DB_HOST', MYSQL_HOST);
define('DB_NAME', MYSQL_DATABASE);
define('DB_USER', MYSQL_USERNAME);
define('DB_PASS', MYSQL_PASSWORD);
define('DB_PORT', MYSQL_PORT);

// --------------------------------------------------------------------
// Segurança – Encriptação com OpenSSL
// --------------------------------------------------------------------
define('OPENSSL_METHOD', 'AES-256-CBC'); // Algoritmo simétrico robusto
define('OPENSSL_KEY', 'H0SDRQzIGqclX2kbYBk9xspdn9U5f3Wa'); // Chave de 32 caracteres
define('OPENSSL_IV', 'BzKAbjuREsHgnw56'); // Vetor de inicialização (16 caracteres)

// --------------------------------------------------------------------
// Uploads de documentos
// --------------------------------------------------------------------
define('UPLOAD_DIR_EQUIPAMENTOS', __DIR__ . '/../uploads/documentacao_equipamentos');