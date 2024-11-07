<?php

function createCategory($conexao)
{
    if (isset($_POST['create_category'])) {
        $titulo_categoria = trim($_POST['titulo_categoria']);
        $descricao_categoria = trim($_POST['descricao_categoria']);
        $icon = trim($_POST['icon']);
        $status = trim($_POST['status']);

        if (empty($titulo_categoria) || empty($descricao_categoria) || ctype_space($titulo_categoria) || ctype_space($descricao_categoria)) {
            $erro = "Erro: Não é possível criar uma categoria vazia ou nula. Por favor, preencha todos os campos com texto válido.";
            $_SESSION['erro'] = $erro;
            header("Location: controleCategorias.php?aviso=erro");
            exit;
        } else {
            $sqlCount = "SELECT COUNT(*) FROM Categorias WHERE status = 1";
            $stmtCount = $conexao->prepare($sqlCount);
            $stmtCount->execute();
            $count = $stmtCount->fetchColumn();

            // Verifica se o número de categorias ativas é maior ou igual a 15
            if ($count >= 15 && $status == 1) {
                $status = 2;
                $aviso = "A categoria foi criada com sucesso, mas já excedemos o limite de 15 categorias na home. A nova categoria não aparecerá na home";
            } else {
                // Caso contrário, usa a mensagem padrão
                $aviso = "A categoria foi criada com sucesso";
            }

            $sql = "INSERT INTO Categorias (titulo_categoria, descricao_categoria, icon, status) VALUES (:titulo_categoria, :descricao_categoria, :icon, :status)";
            $stmt = $conexao->prepare($sql);

            $stmt->bindParam(':titulo_categoria', $titulo_categoria);
            $stmt->bindParam(':descricao_categoria', $descricao_categoria);
            $stmt->bindParam(':icon', $icon);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);

            // Inicia o buffer de saída
            ob_start();
            if ($stmt->execute()) {
                // Armazena o aviso na sessão
                $_SESSION['aviso'] = $aviso;
                header("Location: controleCategorias.php?aviso=true");
                exit;
            } else {
                $erro = "Erro ao criar a categoria: " . implode(", ", $stmt->errorInfo());
                $_SESSION['erro'] = $erro;
                header("Location: controleCategorias.php?aviso=erro");
                exit;
            }
        }
    }
}



// Function to update an existing category
function edit_category($conexao)
{
    if (isset($_POST['edit_category'])) {
        $categoria_id = $_POST['categoria_id'];
        $titulo_categoria = trim($_POST['titulo_categoria']);
        $descricao_categoria = trim($_POST['descricao_categoria']);
        $icon = trim($_POST['icon']);
        $status = trim($_POST['status']); // Supondo que você tenha o status vindo do formulário

        if (empty($titulo_categoria) || empty($descricao_categoria) || ctype_space($titulo_categoria) || ctype_space($descricao_categoria)) {
            $erro = "Erro: Não é possível atualizar uma categoria vazia ou nula. Por favor, preencha todos os campos com texto válido.";
            $_SESSION['erro'] = $erro;
            header("Location: controleCategorias.php?aviso=erro");
            exit;
        } else {
            $sqlCount = "SELECT COUNT(*) FROM Categorias WHERE status = 1";
            $stmtCount = $conexao->prepare($sqlCount);
            $stmtCount->execute();
            $count = $stmtCount->fetchColumn();
            if ($count >= 15 && $status == 1) {
                // Atualiza o status para 2
                $status = 2;
                $aviso = "A categoria foi editada com sucesso, mas já excedemos o limite de 15 categorias na home. A categoria editada não aparecerá na home.";
            } else {
                $aviso = "A categoria foi editada com sucesso.";
            }
            $sql = "UPDATE Categorias SET titulo_categoria = :titulo_categoria, descricao_categoria = :descricao_categoria, icon = :icon, status = :status WHERE categoria_id = :categoria_id";
            $stmt = $conexao->prepare($sql);

            $stmt->bindParam(':titulo_categoria', $titulo_categoria);
            $stmt->bindParam(':descricao_categoria', $descricao_categoria);
            $stmt->bindParam(':icon', $icon);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);

            ob_start();
            if ($stmt->execute()) {
                if (isset($aviso)) {
                    $_SESSION['aviso'] = $aviso;
                }
                header("Location: controleCategorias.php?aviso=true");
                exit;
            } else {
                $erro = "Erro ao editar a categoria: " . implode(", ", $stmt->errorInfo());
                $_SESSION['erro'] = $erro;
                header("Location: controleCategorias.php?aviso=erro");
                exit;
            }
        }
    }
}


// Function to delete a category
function deleteCategory($conexao)
{
    if (isset($_POST['delete_category'])) {
        $categoria_id = $_POST['categoria_id'];

        // Usando PDO para preparar a consulta
        $sql = "DELETE FROM Categorias WHERE categoria_id = :categoria_id";
        $stmt = $conexao->prepare($sql);

        // Bind parameter usando PDO
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            ob_end_flush();
            header("Refresh:0");
            exit;
        } else {
            $erro = "Erro ao excluir a categoria: " . implode(", ", $stmt->errorInfo());
        }
    }
}

// Function to retrieve all categories
function getAllCategories($conexao)
{
    $sql = "SELECT * FROM Categorias ORDER BY titulo_categoria ASC";
    $result = $conexao->query($sql);
    return $result;
}

// Function to retrieve a single category by its ID
function getCategoryById($conexao, $categoria_id)
{
    $sql = "SELECT * FROM Categorias WHERE categoria_id=?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $categoria_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch();
}

// Handle form submissions
createCategory($conexao);
edit_category($conexao);
deleteCategory($conexao);

// Retrieve all categories
$categories = getAllCategories($conexao);
?>