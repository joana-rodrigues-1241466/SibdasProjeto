<?php
// Inicia a sessão para aceder e manipular os dados da $_SESSION
session_start();

// --------------------------------------------------------------------
// TERMINAR A SESSÃO
// --------------------------------------------------------------------
// Remove todas as variáveis da sessão
session_unset();

// Destroi completamente a sessão no servidor
session_destroy();

// --------------------------------------------------------------------
// REDIRECIONAMENTO PARA O LOGIN
// --------------------------------------------------------------------
// Após terminar a sessão, redireciona o utilizador para a página de login
header('Location: /medivault/private/iniciar_sessao.php');

// Encerra a execução do script
return;