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
