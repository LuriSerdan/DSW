<?php
// Conectar ao banco de dados
$servername = "localhost"; // ou o IP do seu servidor de banco de dados
$username = "root"; // Usuário do MySQL
$password = ""; // Senha do MySQL
$dbname = "aluguel_auditorio"; // Nome do banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Variável para exibir a mensagem de sucesso ou erro
$mensagem = "";
$tipo_mensagem = ""; // 'sucesso' ou 'erro'

// Variáveis para armazenar os valores dos campos (preservar dados após o envio)
$nome = $sobrenome = $cpf = $telefone = $user = $senha = "";

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar os dados do formulário
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $user = $_POST['user'];
    $senha = $_POST['senha'];

    // Sanitizar os dados para prevenir injeção de SQL
    $nome = $conn->real_escape_string($nome);
    $sobrenome = $conn->real_escape_string($sobrenome);
    $cpf = $conn->real_escape_string($cpf);
    $telefone = $conn->real_escape_string($telefone);
    $user = $conn->real_escape_string($user);
    $senha = $conn->real_escape_string($senha);

    // Verificar se o username ou o CPF já existe
    $sql_check_user = "SELECT * FROM usuario_comum WHERE username = '$user' OR cpf = '$cpf'";
    $result = $conn->query($sql_check_user);
    
    if ($result->num_rows > 0) {
        // Se o usuário ou CPF já existe
        $mensagem = "Erro: O usuário ou CPF já está cadastrado.";
        $tipo_mensagem = "erro";
        // Limpar o CPF para ser recolocado
        $cpf = "";
    } else {
        // Criptografar a senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT); // Usando bcrypt para criptografar a senha

        // Inserir os dados na tabela usuario_comum
        $sql = "INSERT INTO usuario_comum (nome, sobrenome, cpf, telefone, email, username, senha) 
                VALUES ('$nome', '$sobrenome', '$cpf', '$telefone', '', '$user', '$senhaHash')";

        // Executar a consulta
        if ($conn->query($sql) === TRUE) {
            $mensagem = "Novo usuário cadastrado com sucesso!"; // Mensagem de sucesso
            $tipo_mensagem = "sucesso"; // Tipo da mensagem: sucesso
            // Limpar todos os campos após o sucesso
            $nome = $sobrenome = $cpf = $telefone = $user = $senha = ""; // Limpar todos os campos
        } else {
            $mensagem = "Erro: " . $conn->error; // Mensagem de erro
            $tipo_mensagem = "erro"; // Tipo da mensagem: erro
        }
    }

    // Fechar a conexão
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar usuários</title>
    <link rel="stylesheet" href="../css/cadastro.css">

    <!-- Imagem retornando ao menu -->
    <a href="../index.php">
        <div class="logo-bar">
            <img style="padding: 1%;" id="logo" alt="Logo" src="../img/natureza_viva.png">
        </div>
    </a>

    <style>
        /* Estilo da modal */
        .modal {
            display: none; /* Oculta a modal por padrão */
            position: fixed; /* Fixa a posição na tela */
            z-index: 1; /* Coloca a modal acima de outros conteúdos */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4); /* Fundo escurecido */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .sucesso {
            color: green;
        }

        .erro {
            color: red;
        }
    </style>
</head>
<body>

    <!-- Formulário -->
    <div class="fundo-formulario">
        <form class="formulario" action="cadastro.php" method="POST">

            <div style="text-align: center;">
                <h1 class="linha-personalizada">CADASTRO</h1>
            </div>
            
            <div>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($nome) ?>" required>
            </div>
    
            <div>
                <label for="sobrenome">Sobrenome:</label>
                <input type="text" id="sobrenome" name="sobrenome" value="<?= htmlspecialchars($sobrenome) ?>" required>
            </div>
    
            <div> 
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" value="<?= htmlspecialchars($cpf) ?>" required>
            </div>
    
            <div>
                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" value="<?= htmlspecialchars($telefone) ?>" required>
            </div>

            <div>
                <label for="user">Username:</label>
                <input type="text" id="user" name="user" value="<?= htmlspecialchars($user) ?>" required>
            </div>
    
            <div>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" value="<?= htmlspecialchars($senha) ?>" required>
            </div>
    
            <div style="text-align: center;">
                <button type="submit">Enviar</button>
            </div>
        </form>
    </div>

    <!-- Modal de Sucesso ou Erro -->
    <div id="popupModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="popupMensagem" class="sucesso"></p> <!-- Mensagem será alterada pelo JavaScript -->
        </div>
    </div>

    <script>
        // Verificar se existe uma mensagem do PHP
        <?php if ($mensagem): ?>
            // Exibir a modal
            var tipoMensagem = "<?= $tipo_mensagem ?>";
            var mensagem = "<?= $mensagem ?>";
            var popup = document.getElementById("popupModal");
            var popupMensagem = document.getElementById("popupMensagem");
            var closeBtn = document.getElementsByClassName("close")[0];

            // Definir a classe da mensagem (sucesso ou erro)
            if (tipoMensagem === "sucesso") {
                popupMensagem.classList.add("sucesso");
                popupMensagem.classList.remove("erro");
            } else {
                popupMensagem.classList.add("erro");
                popupMensagem.classList.remove("sucesso");
            }

            // Definir o conteúdo da mensagem
            popupMensagem.textContent = mensagem;

            // Exibir a modal
            popup.style.display = "block";

            // Fechar a modal quando clicar no "X"
            closeBtn.onclick = function() {
                popup.style.display = "none";
            }

            // Fechar a modal se clicar fora dela
            window.onclick = function(event) {
                if (event.target == popup) {
                    popup.style.display = "none";
                }
            }
        <?php endif; ?>
    </script>
</body>
</html>
