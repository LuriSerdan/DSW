<?php
require '../conexao.php';
// Inicia a sessão
session_start();

// Verifica se a variável de sessão "nome" está definida
if (!isset($_SESSION["nome"])) {
    // Se não estiver definida, redireciona para a página de login
    header("Location: login.php");
    exit();
}

if(isset($_POST['time'])){
    // Coletar dados do formulário
    $titulo = $_POST['title'];
    $data_desejada = $_POST['expectedDate'];
    $hora = $_POST['time'];
    $qtd_convidados = $_POST['guestQuantity'];
    $auditorio = $_POST['selectAuditorium'];
    $informacoes_adicionais = $_POST['additionalInformation'];
    $status_ativo = 'A CONFIRMAR'; // Status inicial
    $cpf_usuario = $_SESSION["cpf"]; //PUXAR O CPF VIA ID_USUÁRIO

    // Verificar se o usuário tem agendamento ativo ou aguardando confirmação
    $sql = "SELECT * FROM agendamento WHERE id_usuario = '".$cpf_usuario."' AND (STATUS_ATIVO = 'ATIVO' OR STATUS_ATIVO = 'A CONFIRMAR')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        // Se o usuário já tem um agendamento ativo ou aguardando confirmação
        echo "<script>alert('Você já tem um agendamento ativo ou aguardando confirmação. Por favor, finalize seu agendamento atual antes de fazer outro.');</script>";
    } else {
        // Inserir o novo agendamento (não inclui o ID, pois é autoincremento)
        $sql = "INSERT INTO agendamento (TITULO, DATA, HORARIO, OBS, qtd_convidados, auditorio, id_usuario, STATUS_ATIVO) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$titulo, $data_desejada, $hora, $informacoes_adicionais, $qtd_convidados, $auditorio, $cpf_usuario, $status_ativo])) {
            // Sucesso no agendamento
            echo "<script>alert('Agendamento realizado com sucesso!');</script>";
        } else {
            // Erro ao inserir
            echo "<script>alert('Erro ao realizar o agendamento: " . $stmt->$error . "');</script>";
        }
    }
}

// $sql = "UPDATE agendamento SET STATUS_ATIVO = 'INATIVO' WHERE DATA < CURDATE() AND STATUS_ATIVO != 'INATIVO'";
// $stmt = $pdo->prepare($sql);
// $stmt->execute();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Natureza Viva - Alugar Auditório</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alatsi&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../css/bookAuditorium.css">
</head>
<body>
    <nav id="menu">
        <img id="logo" alt="Logo" src="../img/natureza_viva.png" onclick="window.location.href='../index.php'"></img>

        <ul>            
            <li><button id="btn2" onclick="window.location.href='faq.php'">Ajuda</button></li>  
            <li><button id="btn3" onclick="window.location.href='userMenu.php'">Menu</button></li>
        </ul>
    </nav>

    <div class="content">
        <h1>Alugar Auditório</h1>

        <div class="bookAuditorium">
            <span>Informações</span>
            
            <form action="bookAuditorium.php" method="POST">

                <div>
                    <label for="title">Título:</label>
                    <input type="text" name="title" id="title" required>
                </div>

                <div>
                    <label for="expectedDate">Data desejada:</label>
                    <input type="date" name="expectedDate" id="expectedDate" required>
                </div>

                <div>
                    <label for="time">Horário:</label>
                    <input type="time" name="time" id="time" required>
                </div>

                <div>
                    <label for="guestQuantity">Quantidade de convidados:</label>
                    <input type="number" name="guestQuantity" id="guestQuantity" required>
                </div>

                <div>
                    <label for="selectAuditorium">Auditório:</label>
                    <select name="selectAuditorium" id="selectAuditorium" required>
                        <option value="">Selecionar...</option>
                        <option value="Auditório 1">Auditório 1</option>
                        <option value="Auditório 2">Auditório 2</option>
                        <option value="Auditório 3">Auditório 3</option>
                    </select>
                </div>

                <div>
                    <label for="additionalInformation">Informações adicionais:</label>
                    <textarea name="additionalInformation" id="additionalInformation"></textarea>
                </div>

                <div>
                    <button type="submit">Enviar</button>
                </div>
            </form>
           
        </div>
    </div>
</body>
</html>
