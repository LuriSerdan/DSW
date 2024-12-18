<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Natureza Viva - Alugar Auditório</title>
    <link rel="stylesheet" href="../css/filterBooks.css">
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
        <h1>Filtrar Agendamentos</h1>

        <div class="bookAuditorium">
            <span>Localizar:</span>
            
            <form action='filterBooks.php' method='POST'>
                <div>
                    <label for="filterBooks">Filtrar por:</label>
                    <select type="text" name="filterBooks" id="filterBooks">
                        <option value="">Selecionar...</option>
                        <option value="option1">Agendamentos futuros</option>
                        <option value="option2">Agendamentos pendentes</option>
                        <option value="option3">Usuários A-Z</option>
                    </select>
                </div>

                <div>
                    <button type='submit'>Enviar</button>
                </div>
            </form>
        </div>
    
        <?php
        require "../conexao.php";

        // Verifica se a variável de sessão "nome" está definida
        if (!isset($_SESSION["login"])) {
            // Se não estiver definida, redireciona para a página de login
            header("Location: login.php");
            exit();
        }

        if(isset($_POST["filterBooks"])){
            echo "<div><table id='agendamentos'><thead>";

            $filterOption = $_POST['filterBooks'];
            $query = "";
            if ($filterOption === "option1") {
                echo "<tr><th>Título</th><th>Data</th><th>Horario</th><th>Status</th></tr></thead>";
                $query = "SELECT * FROM agendamento WHERE DATA >= CURDATE()"; 
                $stmt = $pdo->query($query);

                $tabela = "";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $tabela = $tabela . "<tr>";
                    $tabela = $tabela . "<td>".$row['TITULO']."</td><td>".$row['DATA']."</td><td>".$row['HORARIO']."</td><td>".$row['STATUS']."</td>";
                    $tabela = $tabela . "</tr>";
                }
                echo $tabela;
                echo "<td>- - -</td><td>- - -</td><td>- - -</td><td>- - -</td>";


            } elseif ($filterOption === "option2") {
                echo "<tr><th>Título</th><th>Data</th><th>Horario</th><th>Status</th></tr></thead>";
                $query = "SELECT * FROM agendamento WHERE STATUS_ATIVO = 'ATIVO' and DATA < CURDATE() and mensagem_adm is not NULL";
                $stmt = $pdo->query($query);

                $tabela = "";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $tabela = $tabela . "<tr>";
                    $tabela = $tabela . "<td>".$row['TITULO']."</td><td>".$row['DATA']."</td><td>".$row['HORARIO']."</td><td>".$row['STATUS']."</td>";
                    $tabela = $tabela . "</tr>";
                }
                echo $tabela;
                echo "<td>- - -</td><td>- - -</td><td>- - -</td><td>- - -</td>";

            } elseif ($filterOption === "option3") {
                echo "<tr><th>CPF</th><th>Nome Completo</th><th>Telefone</th><th>Email</th></tr></thead>";
                $query = "SELECT * FROM usuario_comum ORDER BY nome ASC";
                $stmt = $pdo->query($query);

                $tabela = "";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $tabela = $tabela . "<tr>";
                    $tabela = $tabela . "<td>".$row['cpf']."</td><td>".$row['nome']." ".$row["sobrenome"]."</td><td>".$row['telefone']."</td><td>".$row['email']."</td>";
                    $tabela = $tabela . "</tr>";
                }
                echo $tabela;
                echo "<td>- - -</td><td>- - -</td><td>- - -</td>";

            }            
        }
        echo "</div>";
        ?>

    
    </div>
</body>
</html>
