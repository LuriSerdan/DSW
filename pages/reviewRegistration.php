<?php
require '../conexao.php';

// Verifica se a variável de sessão "nome" está definida
if (!isset($_SESSION["login"])) {
    // Se não estiver definida, redireciona para a página de login
    header("Location: login.php");
    exit();
}

if (isset($_POST["id"])) {
    if($_POST['acao'] == 1){
        $sql = "UPDATE agendamento set STATUS = 'APROVADO', STATUS_ATIVO = 'ATIVO'  where ID = ".$_POST['id'].";";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        echo "<script>alert('Agendamento APROVADO!');</script>";
    } else {
        $sql = "UPDATE agendamento set STATUS = 'REPROVADO', STATUS_ATIVO = 'INATIVO' where ID = ".$_POST['id'].";";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        echo "<script>alert('Agendamento REPROVADO!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página com Imagem de Fundo</title>
    <link rel="stylesheet" href="../css/reviewRegistration.css">
</head>
<body>
    <nav id="menu">
        <img id="logo" alt="Logo" src="../img/natureza_viva.png" onclick="window.location.href='../index.php'"></img>

        <ul>            
            <li><button id="btn2" onclick="window.location.href='faq.php'">Ajuda</button></li>  
            <li><button id="btn3" onclick="window.location.href='admMenu.php'">Menu</button></li>
        </ul>
    </nav>

    <div class="content">
        <h1>Avaliar Cadastro</h1>

        <div>
            <table>
                
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Qte Convidados</th>
                        <th>Auditório</th>
                        <th>Informações</th>
                        <th>Avaliar</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        require '../conexao.php';
                        $sql = "SELECT * FROM agendamento where STATUS_ATIVO = 'A CONFIRMAR' ORDER BY DATA";
                        $stmt = $pdo->query($sql);

                        $tabela = "";
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $tabela = $tabela . "<tr>";
                            $tabela = $tabela . "<td>".$row['TITULO']."</td><td>".$row['DATA']."</td><td>".$row['HORARIO']."</td><td>".$row['qtd_convidados']."</td><td>".$row['auditorio']."</td><td>".$row['OBS']."</td>";

                            $tabela = $tabela . "<td>
                                    <form action='reviewRegistration.php' method='POST'>
                                    <input type=hidden value=".$row['ID']." name='id'>
                                    <input type=hidden value=1 name='acao'>
                                    <button type='submit' class='accept'>Aceitar</button>
                                    </form>
                                    
                                    <form action='reviewRegistration.php' method='POST'>
                                    <input type=hidden value=".$row['ID']." name='id'>
                                    <input type=hidden value=0 name='acao'>
                                    <button type='submit' class='deny'>Negar</button>
                                    </form>
                                </td>";

                            $tabela = $tabela . "</tr>";
                        }
                        echo $tabela;
                        echo "<td>- - -</td><td>- - -</td><td>- - -</td><td>- - -</td><td>- - -</td><td>- - -</td><td>- - -</td>";
                    ?>
                </tbody>

            </table>
        </div>
    </div>
</body>
</html>
