<?php

include '../../padroes/head.php';
include '../../padroes/nav.php';

?>

<body class="bodyCadastroProdutos">
    <div class="container d-flex justify-content-center">
        <div class="form-container formularioCadastroProdutos col-12 col-md-10 col-lg-8">
            <h1 class="text-center py-2">Cadastro de Serviço</h1>
            <form action="save_service.php" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="serviceName" class="form-label">Título</label>
                        <input type="text" class="form-control" id="serviceName" name="serviceName" required
                            placeholder="Digite o título do serviço">
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
                    <img id="mainThumbnail" src="" alt="Selecione uma imagem para visualizar">
                </div>

                <div class="text-center py-3">

                        <button type="submit" class="btn btn-primary " style="background-color: #1B3C54;">Cadastrar</button>
                        <button type="button" class="btn btn-secondary ">Cancelar</button>
                </div>
                </div>
                <div class="text-center py-3">
                    
            </form>
        </div>
    </div>

    <?php include '../../padroes/footer.php'; ?>
    <script src="../../assets/JS/global.js"></script>
</body>
</html>