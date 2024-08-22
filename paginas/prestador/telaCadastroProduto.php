<?php

include '../../padroes/head.php';
include '../../padroes/nav.php';

?>

<body class="bodyCadastroProdutos">

    <style>
        textarea {
            resize: none;
        }

        .img-container {
            position: relative;
            display: inline-block;
            cursor: move;
        }

        .selected-thumbnail::after {
            content: '';
            position: absolute;
            top: 8px;
            right: 8px;
            width: 15px;
            height: 15px;
            background-color: blue;
            border-radius: 50%;
            border: 2px solid white;
        }

        #mainImagePreview {
            text-align: center;
            margin-top: 15px;
        }

        #mainImagePreview img {
            max-width: 100px;
            height: auto;
            display: none;
            border: 2px solid #007bff;
            padding: 5px;
            margin-top: 10px;
        }

        .preview img {
            max-width: 100px;
            height: auto;
            margin: 5px;
        }
    </style>

    <div class="container d-flex justify-content-center">
        <div class="form-container formularioCadastroProdutos col-12 col-md-10 col-lg-8">
            <h1 class="text-center py-2">Cadastro de Serviço / Produto</h1>
            <form action="save_service.php" method="post" enctype="multipart/form-data">
                <div class="mb-3 col-md-3">
                    <label for="productType" class="form-label">Tipo</label>
                    <select class="form-select" id="productType" name="productType" required onchange="toggleFields()">
                        <option value="" disabled selected>Selecione o tipo</option>
                        <option value="Produto">Produto</option>
                        <option value="Serviço">Serviço</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="serviceName" class="form-label">Título</label>
                        <input type="text" class="form-control" id="serviceName" name="serviceName" required
                            placeholder="Digite o título do produto / serviço">
                    </div>
                    <div class="col-md-4">
                        <label for="serviceCategory" class="form-label">Categoria</label>
                        <select class="form-select" id="serviceCategory" name="serviceCategory" required>
                            <option value="" disabled selected>Selecione uma categoria</option>
                            <option value="Consultoria">Consultoria</option>
                            <option value="Treinamento">Treinamento</option>
                            <option value="Manutenção">Manutenção</option>
                            <option value="Desenvolvimento">Desenvolvimento</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3" id="priceField" style="display: none;">
                    <div class="col-md-6">
                        <label for="servicePrice" class="form-label">Valor</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control" id="servicePrice" name="servicePrice"
                                placeholder="0,00" onkeyup="formatPrice(this)">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="serviceDescription" class="form-label">Descrição</label>
                    <textarea class="form-control" id="serviceDescription" name="serviceDescription" rows="4"
                        maxlength="900" required></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="serviceImages" class="form-label">Imagens</label>
                        <input type="file" class="form-control" id="serviceImages" name="serviceImages[]" multiple
                            accept="image/*" onchange="previewImages()">
                        <div id="imagePreview" class="preview d-flex flex-wrap"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="serviceVideos" class="form-label">Vídeos</label>
                        <input type="file" class="form-control" id="serviceVideos" name="serviceVideos[]" multiple
                            accept="video/*" onchange="previewVideos()">
                        <div id="videoPreview" class="preview d-flex flex-wrap"></div>
                    </div>
                </div>

                <!-- Campo de visualização da imagem selecionada -->
                <div id="mainImagePreview">
                    <h5>Miniatura Principal</h5>
                    <img id="mainThumbnail" src="" alt="Selecione uma imagem para visualizar">
                </div>

                <div class="text-center py-3">
                    <button type="submit" class="btn text-light"
                        style="background-color: #1B3C54; width: 57%;">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <?php include '../../padroes/footer.php'; ?>

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
            var mainImagePreview = document.getElementById("mainImagePreview");
            var mainThumbnail = document.getElementById("mainThumbnail");
            preview.innerHTML = "";
            var files = document.getElementById("serviceImages").files;
            var selectedThumbnail = null;

            if (files.length === 0) {
                mainImagePreview.style.display = "none"; // Oculta o campo se não houver imagens
                return;
            } else {
                mainImagePreview.style.display = "block"; // Exibe o campo se houver imagens
            }

            function selectThumbnail(imgElement, src) {
                if (selectedThumbnail) {
                    selectedThumbnail.classList.remove("selected-thumbnail");
                }
                selectedThumbnail = imgElement;
                selectedThumbnail.classList.add("selected-thumbnail");

                // Exibir a imagem selecionada no campo de visualização principal
                mainThumbnail.src = src;
                mainThumbnail.style.display = "block";
            }

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();

                reader.onload = function (e) {
                    var imgContainer = document.createElement("div");
                    imgContainer.classList.add("img-container");
                    imgContainer.setAttribute("draggable", "true");

                    var img = document.createElement("img");
                    img.src = e.target.result;
                    img.style.cursor = "pointer";

                    // Adiciona um listener de clique para selecionar a miniatura principal
                    img.addEventListener("click", function () {
                        selectThumbnail(imgContainer, e.target.result);
                    });

                    imgContainer.appendChild(img);
                    preview.appendChild(imgContainer);

                    // Funções de arrastar e soltar
                    imgContainer.addEventListener("dragstart", function (e) {
                        e.dataTransfer.setData("text/plain", e.target.id);
                        setTimeout(function () {
                            imgContainer.style.visibility = "hidden";
                        }, 50);
                    });

                    imgContainer.addEventListener("dragend", function (e) {
                        imgContainer.style.visibility = "visible";
                    });

                    imgContainer.addEventListener("dragover", function (e) {
                        e.preventDefault();
                    });

                    imgContainer.addEventListener("drop", function (e) {
                        e.preventDefault();
                        var draggedId = e.dataTransfer.getData("text");
                        var draggedElement = document.getElementById(draggedId);
                        this.parentNode.insertBefore(draggedElement, imgContainer.nextSibling);
                    });
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

                reader.onload = function (e) {
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