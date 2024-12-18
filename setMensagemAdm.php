<?php
require 'conexao.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o valor foi enviado
    if (isset($_POST['txt'])) {
        $sql = "update agendamento set mensagem_adm = '".$_POST['txt']."' where id = ".$_POST['id'].";";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
}
?>
