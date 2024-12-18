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
    <title>Página com Imagem de Fundo</title>
    <link rel="stylesheet" href="../css/myAuditoriumBooks.css">
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
        <h1>Meus Aluguéis</h1>

        <div>
            <table>
                
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Qtd Convidados</th>
                        <th>Auditório</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                        <?php
                            require '../conexao.php';
                            $sql = "SELECT * FROM agendamento where id_usuario = '".$_SESSION['cpf']."' ORDER BY DATA desc";
                            $stmt = $pdo->query($sql);

                            $tabela = "";
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $tabela = $tabela . "<tr>";
                                $tabela = $tabela . "<td>".$row['DATA']."</td><td>".$row['HORARIO']."</td><td>".$row['qtd_convidados']."</td><td>".$row['auditorio']."</td><td>".$row['STATUS']."</td>";
                                $tabela = $tabela . "</tr>";
                            }
                            echo $tabela;
                            echo "<td>- - -</td><td>- - -</td><td>- - -</td><td>- - -</td><td>- - -</td>";
                        ?>
                </tbody>

            </table>
        </div>
    </div>
</body>
</html>
