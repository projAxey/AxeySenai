<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../frontend/auth/redirecionamento.php");
    exit();
}
?>

<?php include '../layouts/head.php'; ?>
<body class="bodyCadastroProdutos">
<?php
include '../../config/conexao.php'; // Inclui a conexão com o banco de dados

// Consulta para obter as categorias
try {
    $sql = "SELECT categoria_id, titulo_categoria FROM Categorias"; // Altere o nome da tabela conforme necessário
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar categorias: " . $e->getMessage();
}
?>

<div class="container d-flex justify-content-center">
    <div class="form-container formularioCadastroProdutos col-12 col-md-10 col-lg-8 mb-5">
        <h1 class="text-center py-2">Cadastro de Serviço / Produto</h1>
        <form method="post" enctype="multipart/form-data" action="../../backend/save_service.php">
            <div class="mb-3 col-md-3">
                <label for="productType" class="form-label">Tipo</label>
                <select class="form-select" id="productType" name="productType" required onchange="toggleFields()">
                    <option value="" disabled selected>Selecione o tipo</option>
                    <option value="1">Produto</option>
                    <option value="2">Serviço</option>
                </select>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="serviceName" class="form-label">Título</label>
                    <input type="text" class="form-control" id="serviceName" name="serviceName" required placeholder="Digite o título do produto / serviço">
                </div>
                <div class="col-md-4">
                    <label for="serviceValue" class="form-label">Valor</label>
                    <input type="number" class="form-control" id="serviceValue" name="serviceValue" required placeholder="Digite o valor do produto / serviço">
                </div>
                <div class="col-md-4">
                    <label for="serviceCategory" class="form-label">Categoria</label>
                    <select class="form-select" id="serviceCategory" name="serviceCategory" required>
                        <option value="" disabled selected>Selecione uma categoria</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria['categoria_id']; ?>"><?= $categoria['titulo_categoria']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3" id="priceField" style="display: none;">
                <div class="col-md-6">
                    <label for="servicePrice" class="form-label">Valor</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="text" class="form-control" id="servicePrice" name="servicePrice" placeholder="0,00" onkeyup="formatPrice(this)">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="serviceDescription" class="form-label">Descrição</label>
                <textarea class="form-control" id="serviceDescription" name="serviceDescription" rows="4" maxlength="900" required></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="serviceImages" class="form-label">Imagens</label>
                    <input type="file" class="form-control" id="serviceImages" name="serviceImages[]" multiple accept="image/*" onchange="previewImages()">
                    <div id="imagePreview" class="preview d-flex flex-wrap"></div>
                </div>
                <div class="col-md-6">
                    <label for="serviceVideos" class="form-label">Vídeos</label>
                    <input type="file" class="form-control" id="serviceVideos" name="serviceVideos[]" multiple accept="video/*" onchange="previewVideos()">
                    <div id="videoPreview" class="preview d-flex flex-wrap"></div>
                </div>
            </div>

            <div class="text-center py-3">
                <button type="submit" class="btn text-light" style="background-color: #1B3C54; width: 57%;">Cadastrar</button>
            </div>
        </form>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>

<script>
    function toggleFields() {
        var productType = document.getElementById("productType").value;
        var priceField = document.getElementById("priceField");
        
        if (productType === "Produto") {
            priceField.style.display = "block";
        } else {
            priceField.style.display = "none";
        }
    }

    function formatPrice(input) {
        var value = input.value.replace(/\D/g, '');
        value = (value / 100).toFixed(2) + '';
        value = value.replace(".", ",");
        value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        input.value = value;
    }

    function previewImages() {
        var preview = document.getElementById("imagePreview");
        preview.innerHTML = "";
        var files = document.getElementById("serviceImages").files;

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            reader.onload = function(e) {
                var img = document.createElement("img");
                img.src = e.target.result;
                img.classList.add("m-2");
                preview.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    }

    function previewVideos() {
        var preview = document.getElementById("videoPreview");
        preview.innerHTML = "";
        var files = document.getElementById("serviceVideos").files;

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            reader.onload = function(e) {
                var video = document.createElement("video");
                video.src = e.target.result;
                video.classList.add("m-2");
                video.controls = true;
                preview.appendChild(video);
            };

            reader.readAsDataURL(file);
        }
    }
</script>

</body>
</html>
