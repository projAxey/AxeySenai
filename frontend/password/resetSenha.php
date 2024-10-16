<?php
include '../../config/conexao.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verifica se o token existe nas tabelas Clientes ou Prestadores
    $sqlCheck = "
        SELECT 'Clientes' as tabela, cliente_id as id FROM Clientes WHERE token_temp = :token
        UNION 
        SELECT 'Prestadores' as tabela, prestador_id as id FROM Prestadores WHERE token_temp = :token";
    $stmtCheck = $conexao->prepare($sqlCheck);
    $stmtCheck->execute([':token' => $token]);
    $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        echo "Token inválido ou expirado.";
        exit();
    }
} else {
    echo "Token não fornecido.";
    exit();
}
?>
<body>
    <div class="container mt-5">
        <h2>Redefinir Senha</h2>
        <form action="../../backend/password/alterarSenhaBackend.php" method="POST">
            <div class="form-group mb-3">
                <label for="novaSenha">Nova Senha</label>
                <input type="password" class="form-control" name="novaSenha" id="novaSenha" required>
            </div>
            <input type="hidden" name="tabela" value="<?= $result['tabela'] ?>">
            <input type="hidden" name="id" value="<?= $result['id'] ?>">
            <button type="submit" class="btn btn-primary" name="btnResetSenha">Redefinir Senha</button>
        </form>
    </div>
</body>
</html>