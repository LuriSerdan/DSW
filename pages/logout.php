<?php
// Inicia a sessão
session_start();

// Destroi a sessão
session_destroy();

// Redireciona o usuário para a página de login ou para a página inicial
header("Location: login.php");
exit();
?>
