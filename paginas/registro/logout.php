<?php
session_start();
session_unset(); // Remove todas as variáveis de sessão
session_destroy(); // Destroi a sessão

header("Location: /projAxeySenai/index.php"); // Redireciona para a página inicial após o logout
exit;