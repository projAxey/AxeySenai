<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Serviço / Produto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        textarea {
            resize: none;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            width: 100%;
        }

        .form-container h1 {
            color: #1B3C54;
        }

        .preview img,
        .preview video {
            max-width: 100px;
            margin-top: 10px;
        }

        .char-counter {
            color: #6c757d;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>

    <?php include '../../padroes/nav.php'; ?>

    <div class="container d-flex justify-content-center">
        <div class="form-container col-12 col-md-10 col-lg-8">
            <h1 class="text-center py-2">Cadastro de Serviço / Produto</h1>
            <form action="save_service.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="serviceName">Titulo</label>
                        <input type="text" class="form-control" id="serviceName" name="serviceName" required placeholder="digite o titulo do produto / serviço">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="serviceCategory">Seguimento</label>
                        <select class="form-control" id="serviceCategory" name="serviceCategory" required>
                            <option value="" disabled selected>Selecione uma categoria</option>
                            <option value="Consultoria">Consultoria</option>
                            <option value="Treinamento">Treinamento</option>
                            <option value="Manutenção">Manutenção</option>
                            <option value="Desenvolvimento">Desenvolvimento</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="serviceDuration">Duração (horas / dias)</label>
                        <input type="number" class="form-control" id="serviceDuration" name="serviceDuration" step="0.1" required placeholder="1">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="servicePrice">Valor</label>
                        <input type="number" class="form-control servicePrice" name="servicePrice" required placeholder="0,00 R$">
                    </div>
                </div>
                <div class="form-group">
                    <label for="serviceDescription">Descrição</label>
                    <textarea class="form-control" id="serviceDescription" name="serviceDescription" rows="4" maxlength="900" required></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label for="serviceImages">Imagens</label>
                        <input type="file" class="form-control-file" id="serviceImages" name="serviceImages[]" multiple accept="image/*" onchange="previewImages()">
                        <div id="imagePreview" class="preview d-flex flex-wrap"></div>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="serviceVideos">Vídeos</label>
                        <input type="file" class="form-control-file" id="serviceVideos" name="serviceVideos[]" multiple accept="video/*" onchange="previewVideos()">
                        <div id="videoPreview" class="preview d-flex flex-wrap"></div>
                    </div>
                </div>
                <div class="text-center py-3">
                    <button type="submit" class="btn text-light" style="background-color: #1B3C54; width: 57%;">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <?php include '../../padroes/footer.php'; ?>

    <script>
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
    <script src="../projAxeySenai/assets/JS/global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>