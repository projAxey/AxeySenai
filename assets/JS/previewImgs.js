  
// Função de pré-visualização de imagens
function previewImages() {
    var preview = document.getElementById("imagePreview");
    preview.innerHTML = "";  // Limpa a pré-visualização anterior
    var files = document.getElementById("serviceImages").files;  // Pega os arquivos selecionados

    if (files.length === 0) {
        return;  // Se nenhum arquivo for selecionado, não faz nada
    }

    // Loop sobre todos os arquivos selecionados
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();

        // Fechar o contexto do 'file' usando uma função imediata
        (function(file) {
            reader.onload = function(e) {
                var img = document.createElement("img");
                img.src = e.target.result;  // Define o src da imagem como o resultado do FileReader
                img.classList.add("m-2");   // Adiciona uma classe para estilo
                img.style.maxWidth = "150px";  // Define um tamanho máximo (opcional)
                img.style.maxHeight = "150px"; // Define um tamanho máximo (opcional)
                img.style.border = "1px solid #ddd"; // Adiciona borda (opcional)

                // Adiciona a imagem ao contêiner de pré-visualização
                preview.appendChild(img);
            };

            reader.readAsDataURL(file);  // Lê o arquivo selecionado como URL de dados
        })(file);
    }
}

// Função de pré-visualização de vídeos
function previewVideos() {
    var preview = document.getElementById("videoPreview");
    preview.innerHTML = "";  // Limpa a pré-visualização anterior
    var files = document.getElementById("serviceVideos").files;  // Pega os arquivos selecionados

    if (files.length === 0) {
        return;  // Se nenhum arquivo for selecionado, não faz nada
    }

    // Loop sobre todos os arquivos selecionados
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();

        (function(file) {
            reader.onload = function(e) {
                var video = document.createElement("video");
                video.src = e.target.result;  // Define o src do vídeo como o resultado do FileReader
                video.classList.add("m-2");
                video.controls = true;  // Adiciona controles ao vídeo
                video.style.maxWidth = "300px";  // Tamanho máximo do vídeo (opcional)
                
                // Adiciona o vídeo ao contêiner de pré-visualização
                preview.appendChild(video);
            };

            reader.readAsDataURL(file);  // Lê o arquivo selecionado como URL de dados
        })(file);
    }
}