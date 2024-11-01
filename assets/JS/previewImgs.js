  
// Função de pré-visualização de imagens
function previewImages() {
    var preview = document.getElementById("imagePreview");
    preview.innerHTML = ""; // Limpa a pré-visualização anterior
    var fileInput = document.getElementById("serviceImages") || document.getElementById("bannerImage"); // Verifica qual input foi utilizado
    var files = fileInput.files; // Pega os arquivos selecionados
    var isServiceImages = fileInput.id === "serviceImages"; // Verifica se o input é o serviceImages

    if (files.length === 0) {
        return; // Se nenhum arquivo for selecionado, não faz nada
    }

    // Loop sobre todos os arquivos selecionados
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();

        (function(file) {
            reader.onload = function(e) {
                // Criação do contêiner para a imagem
                var container = document.createElement("div");
                container.style.position = "relative";
                container.style.display = "inline-block";
                container.style.margin = "1.5vh";
                container.setAttribute("data-imagem-capa", "0"); // Inicializa como imagemCapa = 0
                
                var img = document.createElement("img");
                img.src = e.target.result; 
                img.style.maxWidth = "22vh";
                img.style.maxHeight = "22vh";

                // Se for serviceImages, cria o checkbox, senão, não cria
                // if (isServiceImages) {
                   
                //     var checkbox = document.createElement("input");
                //     checkbox.type = "radio";
                //     checkbox.name = "highlightImage"; // Todos os checkboxes compartilham o mesmo nome para permitir a seleção única
                //     checkbox.style.position = "absolute";
                //     checkbox.style.top = "1.5vh";  
                //     checkbox.style.right = "1.5vh";  
                //     checkbox.style.width = "3vh"; 
                //     checkbox.style.height = "3vh";
                //     checkbox.style.cursor = "pointer";

                    
                //     checkbox.onclick = function() {
                //         var currentlyMarked = preview.querySelector(".marked");
                //         if (currentlyMarked) {
                //             currentlyMarked.classList.remove("marked");
                //             currentlyMarked.setAttribute("data-imagem-capa", "0"); 
                //         }
                        
                //         container.classList.add("marked");
                //         container.setAttribute("data-imagem-capa", "1"); 
                //     };

                //     container.appendChild(checkbox);
                // }

                // Adiciona a imagem ao contêiner
                container.appendChild(img);

                // Adiciona o contêiner ao contêiner de pré-visualização
                preview.appendChild(container);
            };

            reader.readAsDataURL(file); // Lê o arquivo selecionado como URL de dados
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