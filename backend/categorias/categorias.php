<!-- <?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}

include '../../config/conexao.php';
// Function to create a new service
function createService($conexao) {
    if (isset($_POST['create_service'])) {
        $titulo = $_POST['titulo'];
        $categoria = $_POST['categoria'];
        $prestador = $_POST['prestador'];

        $sql = "INSERT INTO servicos (titulo, categoria, prestador) VALUES (?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sss", $titulo, $categoria, $prestador);
        $stmt->execute();

        header("Location: index.php?message=success");
    }
}

// Function to update an existing service
function updateService($conexao) {
    if (isset($_POST['update_service'])) {
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $categoria = $_POST['categoria'];
        $prestador = $_POST['prestador'];

        $sql = "UPDATE servicos SET titulo=?, categoria=?, prestador=? WHERE id=?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sssi", $titulo, $categoria, $prestador, $id);
        $stmt->execute();

        header("Location: index.php?message=updated");
    }
}

// Function to delete a service
function deleteService($conexao) {
    if (isset($_POST['delete_service'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM servicos WHERE id=?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        header("Location: index.php?message=deleted");
    }
}

// Function to retrieve all services
function getAllServices($conexao) {
    $sql = "SELECT * FROM servicos";
    $result = $conexao->query($sql);
    return $result;
}

// Function to retrieve a single service by its ID
function getServiceById($conexao, $id) {
    $sql = "SELECT * FROM servicos WHERE id=?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Handle form submissions
createService($conexao);
updateService($conexao);
deleteService($conexao);

// Retrieve all services
$services = getAllServices($conexao);

?> 