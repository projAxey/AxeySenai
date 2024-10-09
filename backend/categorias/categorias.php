<!-- <?php
// Connection details
$hostname = '108.179.193.15';
$username = 'axeyfu72_root';
$password = 'AiOu}v3P0kx6';
$database = 'axeyfu72_db';

// Create a connection to the database
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to create a new service
function createService($conn) {
    if (isset($_POST['create_service'])) {
        $titulo = $_POST['titulo'];
        $categoria = $_POST['categoria'];
        $prestador = $_POST['prestador'];

        $sql = "INSERT INTO servicos (titulo, categoria, prestador) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $titulo, $categoria, $prestador);
        $stmt->execute();

        header("Location: index.php?message=success");
    }
}

// Function to update an existing service
function updateService($conn) {
    if (isset($_POST['update_service'])) {
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $categoria = $_POST['categoria'];
        $prestador = $_POST['prestador'];

        $sql = "UPDATE servicos SET titulo=?, categoria=?, prestador=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $titulo, $categoria, $prestador, $id);
        $stmt->execute();

        header("Location: index.php?message=updated");
    }
}

// Function to delete a service
function deleteService($conn) {
    if (isset($_POST['delete_service'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM servicos WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        header("Location: index.php?message=deleted");
    }
}

// Function to retrieve all services
function getAllServices($conn) {
    $sql = "SELECT * FROM servicos";
    $result = $conn->query($sql);
    return $result;
}

// Function to retrieve a single service by its ID
function getServiceById($conn, $id) {
    $sql = "SELECT * FROM servicos WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Handle form submissions
createService($conn);
updateService($conn);
deleteService($conn);

// Retrieve all services
$services = getAllServices($conn);

// Close the database connection
$conn->close();
?> -->