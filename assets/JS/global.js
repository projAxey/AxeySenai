//footer autaliza de forma automatica
document.addEventListener("DOMContentLoaded", function () {
  var currentYear = new Date().getFullYear();
  document.getElementById("copyright").innerHTML =
    "&copy; " + currentYear + " Axey. Todos os direitos reservados.";
});



function previewImages() {
  var preview = document.getElementById("imagePreview");
  preview.innerHTML = "";
  var files = document.getElementById("serviceImages").files;

  for (var i = 0; i < files.length; i++) {
    var file = files[i];
    var reader = new FileReader();

    reader.onload = function (e) {
      var img = document.createElement("img");
      img.src = e.target.result;
      img.classList.add("m-2");
      preview.appendChild(img);
    };

    reader.readAsDataURL(file);
  }
}



//PREVIEW IMAGEM DO CADASTRO DE SERVICOS
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

//PREVIER VIDEO DO CADASTRO DE SERVICOS
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


//  FIM DOS PREVIEW ----------------------------
