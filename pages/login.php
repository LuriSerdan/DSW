<?php
include '../conexao.php';
// Inicia a sessão
session_start();

$mensagem = "";
$tipo_mensagem = ""; // Variável para definir o tipo da mensagem (sucesso ou erro)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo']; // Administrador ou usuario

    if ($tipo === 'administrador') {
        // Verifica se o login e a senha são corretos
        $sql = "SELECT * FROM administrador WHERE login = '".$user."'";
    } else {
        $sql = "SELECT * FROM usuario_comum WHERE username = '".$user."'";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        $row = $result[0];

        if ($tipo === 'administrador' and $senha == '123456' and $row["senha"] == "123456") {
            header("Location: alterar_senha.php");
        } else if (password_verify($senha, $row['senha'])){
            foreach(array_keys($row) as $key){
                $_SESSION[$key] = $row[$key];
            }
            if($tipo === 'administrador'){
                header("Location: admMenu.php");
            } else {
                header("Location: userMenu.php");
            }
            exit;
        } else {
            $mensagem = "Usuário ou senha incorretos!";
            $tipo_mensagem = "erro";
        }
    } else {
        $mensagem = "Usuário ou senha incorretos!";
        $tipo_mensagem = "erro";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <!-- Imagem retornando ao menu -->
    <a href="../index.php">
        <div class="logo-bar">
            <img style="padding: 1%;" id="logo" alt="Logo" src="../img/natureza_viva.png">
        </div>
    </a>
</head>
<body>

    <!-- Modal para exibir a mensagem -->
    <div id="popupModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="popupMensagem"></p>
        </div>
    </div>

    <!-- Formulário -->
    <div class="fundo-formulario">
        <form class="formulario" method="POST" action="login.php">
            <div style="text-align: center;">
                <h1 class="linha-personalizada">LOGIN</h1>
            </div>
            
            <div>
                <label for="user">Username:</label>
                <input type="text" id="user" name="user" required>
            </div>
    
            <div>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <div>
                <label for="tipo">Tipo de Login:</label>
                <select id="tipo" name="tipo" required>
                    <option value="administrador">Administrador</option>
                    <option value="usuario">Usuário</option>
                </select>
            </div>
    
            <div style="text-align: center;">
                <button type="submit">Entrar</button>
            </div>

            <div class="esqueceu-senha">
                <a href="alterar_senha.php">Esqueceu sua senha?</a>
                <a href="cadastro.php">Criar cadastro!</a>
            </div>
        </form>
    </div>

    <script>
        // Verificar se existe uma mensagem do PHP
        <?php if ($mensagem): ?>
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
