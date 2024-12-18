<?php
include '../conexao.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'];
    $login = $_POST['login'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Verifica se a nova senha e a confirmação coincidem
    if ($nova_senha === $confirmar_senha) {
        // Criptografando a senha
        $nova_senha_criptografada = password_hash($nova_senha, PASSWORD_DEFAULT);

        // Verifica se é o administrador
        if ($tipo === 'administrador' && $login === 'admin') {
            // Atualiza a senha do admin e marca primeiro_acesso como = 0
            $sql_update = "UPDATE administrador SET senha = ?, primeiro_acesso = 0 WHERE login = ?";
            $stmt_update = $pdo->prepare($sql_update);

            if ($stmt_update->execute([$nova_senha_criptografada, $login])) {
                $mensagem = "sucesso|Senha alterada com sucesso! Agora você pode acessar normalmente.";
            } else {
                $mensagem = "erro|Erro ao alterar a senha.";
            }
        } else {
            // Para outros usuários, ajustando o nome da tabela conforme necessário
            $tipo_tabela = ($tipo === 'usuarios') ? 'usuario_comum' : $tipo; // Ajuste para a tabela correta
            $sql = "UPDATE $tipo_tabela SET senha = ? WHERE username = ?"; // Alterei para usar 'username' ao invés de 'login'
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute([$nova_senha_criptografada, $login])) {
                $mensagem = "sucesso|Senha alterada com sucesso!";
            } else {
                $mensagem = "erro|Erro ao alterar a senha.";
            }
        }
    } else {
        $mensagem = "erro|As senhas não coincidem!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha</title>
    <link rel="stylesheet" href="../css/alterar_senha.css">
    <!-- Imagem retornando ao menu -->
    <a href="../index.html">
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

    <div class="fundo-formulario">
        <form class="formulario" method="POST">
            <h1>ALTERAR SENHA</h1>
            
            <!-- Não exibe a mensagem diretamente aqui -->
            
            <label for="tipo">Tipo de Usuário:</label>
            <select id="tipo" name="tipo" required>
                <option value="administrador">Administrador</option>
                <option value="usuarios">Usuário</option>
            </select>
            
            <label for="login">Username:</label>
            <input type="text" id="login" name="login" required>
            
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" id="nova_senha" name="nova_senha" required>
            
            <label for="confirmar_senha">Confirmar Senha:</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha" required>
            
            <button type="submit">Alterar</button>
        <button type="button" class="voltar-login" onclick="window.location.href='login.php'">Voltar ao Login</button>
        </form>
    </div>

    <script>
        // Verificar se existe uma mensagem do PHP
        <?php if ($mensagem): ?>
            // Extrair tipo de mensagem e texto
            var tipoMensagem = "<?= explode("|", $mensagem)[0] ?>";
            var mensagem = "<?= explode("|", $mensagem)[1] ?>";
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
