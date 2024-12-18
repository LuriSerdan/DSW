<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página com Imagem de Fundo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alatsi&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <nav id="menu">
        <img id="logo" alt="Logo" src="img/natureza_viva.png" onclick="window.location.href='index.php'"></img>

        <ul>            
            <li><button id="btn1" onclick="window.location.href='pages/aboutUs.php'">Sobre Nós</button></li>  
            <li><button id="btn2" onclick="window.location.href='pages/faq.php'">Ajuda</button></li>  
            <li><button id="btn3" onclick="window.location.href='pages/login.php'">Entrar</button></li>
            <li><button id="btn4" onclick="window.location.href='pages/cadastro.php'">Comece Já</button></li>
        </ul>
    </nav>

    <div class="content">
        <h1>Organizando Espaços, Fortalecendo Comunidades.</h1>
        <p>Solução voluntária para gerenciar o aluguel de auditórios e salões de festas, unindo tecnologia e propósito para apoiar ações comunitárias.</p>
        <button id="btn4" onclick="window.location.href='pages/cadastro.php'">Comece Já</button>
    </div>

    <footer>
        <a href="pages/faq.php">Ajuda</a>
    </footer>
</body>
</html>
