<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../../config/conexao.php';

// Function to create a new service
function createService($conexao)
{
    if (isset($_POST['create_service'])) {
        $titulo = $_POST['titulo'];
        $categoria = $_POST['categoria'];
        $prestador = $_POST['prestador'];

        $sql = "INSERT INTO servicos (titulo, categoria, prestador) VALUES (:titulo, :categoria, :prestador)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":titulo", $titulo);
        $stmt->bindValue(":categoria", $categoria);
        $stmt->bindValue(":prestador", $prestador);
        $stmt->execute();

        header("Location: index.php?message=success");
        exit();
    }
}

// Function to update an existing service
function updateService($conexao)
{
    if (isset($_POST['update_service'])) {
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $categoria = $_POST['categoria'];
        $prestador = $_POST['prestador'];

        $sql = "UPDATE servicos SET titulo=:titulo, categoria=:categoria, prestador=:prestador WHERE id=:id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":titulo", $titulo);
        $stmt->bindValue(":categoria", $categoria);
        $stmt->bindValue(":prestador", $prestador);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: index.php?message=updated");
        exit();
    }
}

// Function to delete a service
function deleteService($conexao)
{
    if (isset($_POST['delete_service'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM servicos WHERE id=:id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: index.php?message=deleted");
        exit();
    }
}

// Function to retrieve all services
function getAllServices($conexao)
{
    $sql = "SELECT * FROM servicos";
    return $conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// Function to retrieve a single service by its ID
function getServiceById($conexao, $id)
{
    $sql = "SELECT * FROM servicos WHERE id=:id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_service'])) {
        createService($conexao);
    } elseif (isset($_POST['update_service'])) {
        updateService($conexao);
    } elseif (isset($_POST['delete_service'])) {
        deleteService($conexao);
    }
}

// Retrieve all services
$services = getAllServices($conexao);
