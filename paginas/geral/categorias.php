<?php
// Função para inserir serviço
if (isset($_POST['create_service'])) {
    $titulo = $_POST['titulo'];
    $categoria = $_POST['categoria'];
    $prestador = $_POST['prestador'];

    $sql = "INSERT INTO servicos (titulo, categoria, prestador) VALUES ('$titulo', '$categoria', '$prestador')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?message=success");
    } else {
        echo "Erro: " . $conn->error;
    }
}

// Função para atualizar serviço
if (isset($_POST['update_service'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $categoria = $_POST['categoria'];
    $prestador = $_POST['prestador'];

    $sql = "UPDATE servicos SET titulo='$titulo', categoria='$categoria', prestador='$prestador' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?message=updated");
    } else {
        echo "Erro: " . $conn->error;
    }
}

// Função para excluir serviço
if (isset($_POST['delete_service'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM servicos WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?message=deleted");
    } else {
        echo "Erro: " . $conn->error;
    }
}

// Função para buscar todos os serviços
function getAllServices($conn) {
    $sql = "SELECT * FROM servicos";
    return $conn->query($sql);
}

// Função para buscar um serviço pelo ID
function getServiceById($conn, $id) {
    $sql = "SELECT * FROM servicos WHERE id='$id'";
    return $conn->query($sql)->fetch_assoc();
}