<?php
// Inicia a sessão
session_start();

// Verifica se a variável de sessão "nome" está definida
if (!isset($_SESSION["nome"])) {
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
    <title>Natureza Viva - Menu de usuário</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alatsi&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../css/userMenu.css">
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
        <h1>Bem-vindo, <?php echo $_SESSION["nome"] ?> !</h1>

        <div class="userMenu">
            <span>Menu</span>
            
            <div class="mainButtons">
                <button onclick="window.location.href='bookAuditorium.php'">Alugar auditório</button>
                <button onclick="window.location.href='myAuditoriumBooks.php'">Meu aluguel</button>
                <button onclick="window.location.href='pendingIssues.php'">Pendências</button>
            </div>

            <div class="leftButton">
                <button onclick="window.location.href='logout.php'">Sair</button>
            </div>
        </div>
    </div>
</body>
</html>
