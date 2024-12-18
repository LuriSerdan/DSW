<?php
require '../conexao.php';

// Verifica se a variável de sessão "nome" está definida
if (!isset($_SESSION["login"])) {
    // Se não estiver definida, redireciona para a página de login
    header("Location: login.php");
    exit();
}

if (isset($_POST["id"])) {
    $sql = "UPDATE agendamento set STATUS_ATIVO = 'INATIVO' where ID = ".$_POST['id'].";";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    echo "<script>alert('Agendamento Liberado!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página com Imagem de Fundo</title>
    <link rel="stylesheet" href="../css/manageBookAuditorium.css">
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
        <h1>Dar Baixa</h1>

        <div>
            <table>
                
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Auditório</th>
                        <th>Informar sobre Pendencia</th>
                        <th>Dar baixa</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                        require '../conexao.php';
                        $sql = "SELECT * FROM agendamento where STATUS_ATIVO = 'ATIVO' and DATA < CURDATE() ORDER BY DATA";
                        $stmt = $pdo->query($sql);

                        $tabela = "";
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $tabela = $tabela . "<tr>";
                            $tabela = $tabela . "<td>".$row['TITULO']."</td><td>".$row['DATA']."</td><td>".$row['HORARIO']."</td><td>".$row['auditorio']."</td>";
                            $tabela = $tabela . "<td>

                            <input id='txt_".$row["ID"]."' type='text' value='".$row['mensagem_adm']."'>

                            <script>
                                document.getElementById('txt_".$row["ID"]."').addEventListener('blur', function () {
                                    const txt = this.value;
                                    fetch('../setMensagemAdm.php', {
                                        method: 'POST',
                                        headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                        },
                                        body: `id='".$row["ID"]."'&txt=`+txt, // Enviar o valor do campo
                                    });
                                });
                                
                            </script>
                            
                            </td><td><form action='manageBookAuditorium.php' method='POST'><input type=hidden value=".$row['ID']." name='id'><button type='submit'>Liberar</button></form></td>";
                            $tabela = $tabela . "</tr>";
                        }
                        echo $tabela;
                        echo "<td>- - -</td><td>- - -</td><td>- - -</td><td>- - -</td><td>- - -</td><td>- - -</td>";
                    ?>
                </tbody>

            </table>
        </div>
    </div>

    
</body>
</html>
