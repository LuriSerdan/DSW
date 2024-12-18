<?php
// Inicia a sessão
session_start();

// Verifica se a variável de sessão "nome" está definida
if (!isset($_SESSION["login"])) {
    // Se não estiver definida, redireciona para a página de login
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Natureza Viva - Menu de Administrador</title>
    <link rel="stylesheet" href="../css/admMenu.css">
</head>
<body>
    <nav id="menu">
        <img id="logo" alt="Logo" src="../img/natureza_viva.png" onclick="window.location.href='../index.php'"></img>

        <ul>            
            <li><button id="btn1" onclick="window.location.href='aboutUs.php'">Sobre Nós</button></li>  
            <li><button id="btn2" onclick="window.location.href='faq.php'">Ajuda</button></li>  
        </ul>
    </nav>

    <div class="content">
        <h1>Bem-vindo, Administrador!</h1>

        <div class="admMenu">
            <span>Menu</span>
            
            <div class="mainButtons">
                <button onclick="window.location.href='reviewRegistration.php'">Avaliar Cadastro</button>
                <button onclick="window.location.href='manageBookAuditorium.php'">Dar Baixa</button>
                <button onclick="window.location.href='filterBooks.php'">Filtrar Usuários</button>
            </div>

            <div class="leftButton">
                <button onclick="window.location.href='logout.php'">Sair</button>
            </div>
        </div>
    </div>
</body>
</html>
