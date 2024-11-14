let newImageIdCounter = 0;

function previewImages(inputId, previewId) {
    var fileInput = document.getElementById(inputId);
    var preview = document.getElementById(previewId);

    preview.innerHTML = ""; // Limpa o conteúdo do preview
    var files = fileInput.files;

    if (files.length === 0) {
        console.log("Nenhum arquivo selecionado.");
        return;
    }

    // Loop através dos arquivos selecionados
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();

        reader.onload = function(e) {
            var container = document.createElement("div");
            var uniqueId = "newImage" + newImageIdCounter++;
            container.classList.add("image-container");
            container.id = uniqueId;

            var img = document.createElement("img");
            img.src = e.target.result;
            img.className = "product-image";
            img.style.width = "100px";
            img.style.height = "100px";

            var removeButton = document.createElement("button");
            removeButton.className = "btn btn-danger btn-sm";
            removeButton.textContent = "Remover";
            removeButton.onclick = function() {
                removeImage(uniqueId);
            };

            container.appendChild(img);
            container.appendChild(removeButton);
            preview.appendChild(container);
        };

        reader.readAsDataURL(file); // Lê o arquivo como URL de dados
    }
}



