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
  
  // Tela Perf Prestador
//   document.addEventListener("DOMContentLoaded", () => {
//     const prevMonth = document.getElementById("prevMonth");
//     const nextMonth = document.getElementById("nextMonth");
//     const monthYear = document.getElementById("monthYear");
//     const datesContainer = document.getElementById("dates");
  
//     let currentDate = new Date();
  
//     prevMonth.addEventListener("click", () => {
//       currentDate.setMonth(currentDate.getMonth() - 1);
//       renderCalendar();
//     });
  
//     nextMonth.addEventListener("click", () => {
//       currentDate.setMonth(currentDate.getMonth() + 1);
//       renderCalendar();
//     });
  
//     function renderCalendar() {
//       const month = currentDate.getMonth();
//       const year = currentDate.getFullYear();
//       monthYear.textContent = `${new Intl.DateTimeFormat("pt-BR", {
//         month: "long",
//       }).format(currentDate)} ${year}`;
  
//       const firstDayOfMonth = new Date(year, month, 1).getDay();
//       const lastDateOfMonth = new Date(year, month + 1, 0).getDate();
//       const lastDayOfLastMonth = new Date(year, month, 0).getDate();
  
//       datesContainer.innerHTML = "";
  
//       for (let i = firstDayOfMonth; i > 0; i--) {
//         const dateElement = document.createElement("div");
//         dateElement.className = "calendar-date text-muted";
//         dateElement.textContent = lastDayOfLastMonth - i + 1;
//         datesContainer.appendChild(dateElement);
//       }
  
//       for (let i = 1; i <= lastDateOfMonth; i++) {
//         const dateElement = document.createElement("div");
//         dateElement.className = "calendar-date";
//         dateElement.textContent = i;
//         datesContainer.appendChild(dateElement);
//       }
//     }
  
//     renderCalendar();
//   });
  
  
  
  
  //INFORMACOES TELA DE PERFIL PRESTADOR E CLIENTE
  document.getElementById('cep').addEventListener('input', function () {
    var cep = this.value.replace(/\D/g, '');
    if (cep.length === 8) {
        this.value = cep.replace(/(\d{5})(\d{0,3})/, '$1-$2');
    }
    if (cep.length === 8) {
        fetch('https://viacep.com.br/ws/' + cep + '/json/')
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('endereco').value = data.logradouro;
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('cidade').value = data.localidade;
                    document.getElementById('estado').value = data.uf;
                    document.getElementById('numero').focus();
                } else {
                    alert('CEP não encontrado. Por favor, verifique o CEP digitado.');
                }
            })
    }
  });
  
  document.getElementById('celular').addEventListener('input', function () {
    var celular = this.value.replace(/\D/g, '');
    this.value = celular.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
  });
  
  document.getElementById('telefone').addEventListener('input', function () {
    var telefone = this.value.replace(/\D/g, '');
    this.value = telefone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
  });
  
  document.getElementById('nome-social-checkbox').addEventListener('change', function () {
    var nomeSocialField = document.getElementById('nome-social-field');
    if (this.checked) {
        nomeSocialField.style.display = 'block';
    } else {
        nomeSocialField.style.display = 'none';
    }
  });
  
  document.getElementById('toggleSenhaAtual').addEventListener('click', function () {
    const senhaAtualInput = document.getElementById('senhaAtual');
    const icon = document.getElementById('iconSenhaAtual');
    if (senhaAtualInput.type === 'password') {
        senhaAtualInput.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    } else {
        senhaAtualInput.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    }
  });
  
  document.getElementById('toggleNovaSenha').addEventListener('click', function () {
    const novaSenhaInput = document.getElementById('novaSenha');
    const icon = document.getElementById('iconNovaSenha');
    if (novaSenhaInput.type === 'password') {
        novaSenhaInput.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    } else {
        novaSenhaInput.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    }
  });
  
  
  function toggleForm(enable) {
    const formFields = document.querySelectorAll('#editForm input');
    formFields.forEach(function (field) {
        field.disabled = !enable;
    });
  }
  
  toggleForm(false);
  
  document.getElementById('editarPerfil').addEventListener('click', function (event) {
    event.preventDefault();
    toggleForm(true); 
  });
  
  const inputFotoPerfil = document.getElementById('inputFotoPerfil');
  const previewFotoPerfil = document.getElementById('previewFotoPerfil');
  const fotoAtual = document.getElementById('fotoPerfil'); 
  
  inputFotoPerfil.addEventListener('change', function(event) {
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewFotoPerfil.src = e.target.result;
            previewFotoPerfil.style.display = "block";
        }
        reader.readAsDataURL(file);
    }
  });
  document.getElementById('salvarFoto').addEventListener('click', function() {
    if (previewFotoPerfil.src) {
        fotoAtual.src = previewFotoPerfil.src;
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalAlterarFoto'));
        modal.hide();
    }
  });
  
  
  //VALIDAR SE JA NÃO TEM ISSO, TEORICAMENTE É DO CALENDARIO DO PRESTADOR
  // Variáveis globais
  var startDate, endDate;
  var today = new Date();
  console.log(today)
  var todayDate = today.toISOString().split('T')[0];
  // console.log(todayDate)
  var currentTime = today.toTimeString().split(' ')[0].substring(0, 5); // Hora atual no formato HH:MM
  // console.log(currentTime)
  
  // Função para capturar e formatar as datas
  function captureAndFormatDates(info) {
      startDate = new Date(info.startStr);
      endDate = new Date(info.endStr);
  
      console.log(startDate);
      console.log(endDate);
  
      // Ajustar a data final para o dia correto
      if (endDate > startDate) {
          startDate.setDate(startDate.getDate() + 1);
          console.log(startDate)
          endDate.setDate(endDate.getDate());
      }
  
      // Função para formatar a data no formato DD-MM-YYYY
      function formatDateToDDMMYYYY(date) {
          const day = date.getDate().toString().padStart(2, '0');
          const month = (date.getMonth() + 1).toString().padStart(2, '0');
          const year = date.getFullYear();
          return `${day}-${month}-${year}`;
      }
  
      var formattedStartDateBRL = formatDateToDDMMYYYY(startDate);
      var formattedEndDateBRL = formatDateToDDMMYYYY(endDate);
  
      // Se a data inicial e a data final são iguais, exibir apenas uma data
      var displayDate = (startDate.getTime() === endDate.getTime()) ?
          formattedStartDateBRL :
          formattedStartDateBRL + " - " + formattedEndDateBRL;
  
      return {
          displayDate: displayDate
      };
  }
  
  document.addEventListener('DOMContentLoaded', function () {
      var userState = 0; // Estado do usuário: 0 para editar, 1 para visualizar
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
          schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
          initialView: 'dayGridMonth',
          locale: 'pt-br',
          height: '100%',
          editable: true,
          headerToolbar: {
              start: 'today',
              center: 'title',
              end: 'prevYear,prev,next,nextYear'
          },
          eventColor: 'green',
          events: [{
              title: 'All Day Event',
              start: '2024-08-01'
          },
          {
              title: 'Long Event',
              start: '2024-08-07',
              end: '2024-08-10'
          },
          {
              title: 'Conference',
              start: '2024-08-11',
              end: '2024-08-13'
          },
          {
              title: 'Meeting',
              start: '2024-08-12T10:30:00',
              end: '2024-08-12T12:30:00'
          },
          {
              title: 'Lunch',
              start: '2024-08-12T12:00:00'
          },
          {
              title: 'Meeting',
              start: '2024-08-12T14:30:00'
          },
          {
              title: 'Happy Hour',
              start: '2024-08-12T17:30:00'
          },
          {
              title: 'Dinner',
              start: '2024-08-12T20:00:00'
          },
          {
              title: 'Birthday Party',
              start: '2024-08-13T07:00:00'
          },
          {
              title: 'Vacation',
              start: '2024-08-13',
              end: '2024-08-17'
          }
          ],
          selectable: true,
          select: function (info) {
              var dates = captureAndFormatDates(info);
              var displayDate = dates.displayDate;
  
              // Verificar se o usuário está no modo de edição (0) ou visualização (1)
              if (userState === 0) {
                  // Definir a data no input do formulário
                  document.getElementById('serviceDate').value = displayDate;
  
                  // Exibir os campos de hora editáveis e esconder os campos de visualização
                  document.getElementById('timeEditableFields').style.display = 'block';
                  document.getElementById('timeDisplayFields').style.display = 'none';
  
                  // Exibir o formulário pop-up
                  document.getElementById('popupForm').style.display = 'block';
              } else if (userState === 1) {
                  Swal.fire({
                      title: 'Detalhes do Serviço',
                      html: `
              <p><strong>Data:</strong> ${displayDate}</p>
              <p><strong>Hora Início:</strong> 08:00</p>
              <p><strong>Hora Fim:</strong> 12:00</p>
              <p><strong>Título:</strong> Meu Título</p>
              <p><strong>Descrição:</strong> Minha Descrição</p>
              `,
                      icon: 'info',
                      confirmButtonText: 'Fechar'
                  });
              }
  
              // console.log(startDate);
              // console.log(endDate);
          }
      });
  
      // Inicializar o calendário
      calendar.render();
      // Evento para abrir o calendário no modal
      var showCalendarButton = document.getElementById('show-calendar');
      if (showCalendarButton) {
          showCalendarButton.addEventListener('click', function () {
              document.getElementById('calendarModal').style.display = 'block';
              calendar.render();
          });
      }
  
      // Evento para fechar o modal
      var closeModalButton = document.querySelector('.close');
      if (closeModalButton) {
          closeModalButton.addEventListener('click', function () {
              document.getElementById('calendarModal').style.display = 'none';
          });
      }
  
      // Evento para fechar o formulário pop-up
      var closePopupButton = document.querySelector('.close-popup');
      if (closePopupButton) {
          closePopupButton.addEventListener('click', function () {
              document.getElementById('popupForm').style.display = 'none';
          });
      }
  
      // Função de validação do formulário
      var serviceForm = document.getElementById('serviceForm');
      if (serviceForm) {
          serviceForm.addEventListener('submit', function (event) {
              event.preventDefault();
  
              var serviceDate = `${startDate} - ${endDate}`;
              // console.log("Service " + serviceDate);
              var startTime = document.getElementById('eventHoraInicio').value;
              var endTime = document.getElementById('eventHoraFim').value;
              var title = document.getElementById('eventTitle').value;
              var description = document.getElementById('eventDesc').value;
  
              // Verificar se todos os campos obrigatórios estão preenchidos
              if (!serviceDate || !startTime || !endTime || !title || !description) {
                  // console.log("01");
                  Swal.fire({
                      title: 'Erro',
                      text: 'Todos os campos devem ser preenchidos.',
                      icon: 'error',
                      confirmButtonText: 'Fechar'
                  });
                  return;
              }
  
              // Verificar se a data inicial é menor que a data final
              if (startDate > endDate) {
                  // console.log("02");
                  Swal.fire({
                      title: 'Erro',
                      text: 'A data inicial não pode ser maior que a data final.',
                      icon: 'error',
                      confirmButtonText: 'Fechar'
                  });
                  return;
              }
  
              // Verificar se a data inicial é menor que a data de hoje
              if (startDate.toISOString().split('T')[0] < today) {
                  // console.log("Start " + startDate);
                  // console.log("today " + today)
                  // console.log("03");
                  // console.log("Start" + startDate.toISOString().split('T')[0]);
                  // console.log(todayDate);
                  Swal.fire({
                      title: 'Erro',
                      text: 'A data inicial não pode ser menor que a data de hoje.',
                      icon: 'error',
                      confirmButtonText: 'Fechar'
                  });
                  return;
              }
  
              // Nova Verificação: Se a data inicial for igual à data atual, a hora inicial não pode ser inferior à hora atual
              if (startDate === today && startTime < currentTime) {
                  // console.log("06");
                  // console.log("Star " + startDate);
                  // console.log(today);
  
                  Swal.fire({
                      title: 'Erro',
                      text: 'A hora inicial não pode ser inferior à hora atual.',
                      icon: 'error',
                      confirmButtonText: 'Fechar'
                  });
                  return;
              }
  
              // Verificar se a data inicial é igual à data final
              if (startDate.getTime() === endDate.getTime()) {
  
                  console.log("07");
  
                  // Verificar se a hora final é menor que a hora inicial
                  if (endTime < startTime) {
                      Swal.fire({
                          title: 'Erro',
                          text: 'A hora final não pode ser menor que a hora inicial.',
                          icon: 'error',
                          confirmButtonText: 'Fechar'
                      });
                      return;
                  }
  
                  // Verificar se a hora inicial é menor que a hora atual
                  if (startTime < currentTime) {
                      Swal.fire({
                          title: 'Erro',
                          text: 'A hora inicial não pode ser menor que a hora atual.',
                          icon: 'error',
                          confirmButtonText: 'Fechar'
                      });
                      return;
                  }
              }
  
              // Verificar se a hora final é menor que a hora inicial
              if (startDate.getTime() == endDate.getTime() && endTime < startTime) {
                  // console.log("08")
                  Swal.fire({
                      title: 'Erro',
                      text: 'A hora final não pode ser menor que a hora inicial.',
                      icon: 'error',
                      confirmButtonText: 'Fechar'
                  });
                  return;
              }
  
              //verifica se as datas sao diferentes e valida o start do serviço
              if (startDate != today) {
                  console.log("09");
                  console.log(todayDate);
                  if (startDate < today) {
                      // console.log("Foi")
                      // console.log("Start " + startDate);
                      // console.log("today " + today);
                      console.log("09");
                      // console.log("Start" + startDate.toISOString().split('T')[0]);
                      // console.log(todayDate);
                      Swal.fire({
                          title: 'Erro',
                          text: 'A data inicial não pode ser menor que a data de hoje.',
                          icon: 'error',
                          confirmButtonText: 'Fechar'
                      });
                      return;
                  }
  
  
              }
              // console.log(startDate);
              // console.log(today);
              // Se tudo estiver correto, você pode prosseguir com o envio ou outra lógica
              Swal.fire({
                  title: 'Sucesso',
                  text: 'Serviço salvo com sucesso.',
                  icon: 'success',
                  confirmButtonText: 'Fechar'
              });
  
              // Limpar os campos do formulário
              serviceForm.reset();
  
              // Fechar o formulário
              document.getElementById('popupForm').style.display = 'none';
          });
      }
  });
  document.addEventListener('DOMContentLoaded', function () {
      const monthYearDiv = document.getElementById('monthYear');
      const datesDiv = document.getElementById('dates');
      const nomeSocialCheckbox = document.getElementById('nome-social-checkbox');
      const nomeSocialField = document.getElementById('nome-social-field');
  
      const date = new Date();
      let currentYear = date.getFullYear();
      let currentMonth = date.getMonth();
  
      function updateCalendar() {
          const firstDay = new Date(currentYear, currentMonth, 1);
          const lastDay = new Date(currentYear, currentMonth + 1, 0);
          const daysInMonth = lastDay.getDate();
          const startDay = firstDay.getDay();
  
          datesDiv.innerHTML = '';
  
          for (let i = 0; i < startDay; i++) {
              const emptyElement = document.createElement('div');
              emptyElement.className = 'calendar-date empty';
              datesDiv.appendChild(emptyElement);
          }
  
          for (let i = 1; i <= daysInMonth; i++) {
              const dateElement = document.createElement('div');
              dateElement.className = 'calendar-date';
              dateElement.innerText = i;
              datesDiv.appendChild(dateElement);
          }
  
          monthYearDiv.innerText = `${date.toLocaleString('default', { month: 'long' })} ${currentYear}`;
      }
  
      document.getElementById('prevMonth').addEventListener('click', function () {
          currentMonth--;
          if (currentMonth < 0) {
              currentMonth = 11;
              currentYear--;
          }
          updateCalendar();
      });
  
      document.getElementById('nextMonth').addEventListener('click', function () {
          currentMonth++;
          if (currentMonth > 11) {
              currentMonth = 0;
              currentYear++;
          }
          updateCalendar();
      });
  
      updateCalendar();
  
      nomeSocialCheckbox.addEventListener('change', function () {
          if (this.checked) {
              nomeSocialField.style.display = 'block';
          } else {
              nomeSocialField.style.display = 'none';
          }
      });
  
      document.getElementById("btnCadastroProduto").addEventListener("click", function () {
          window.location.href = "telaCadastroProduto.php";
      });
  
      document.getElementById('editForm').addEventListener('submit', function (event) {
          // Adicionar lógica de validação e manipulação de submissão de formulário
          event.preventDefault();
          alert('Formulário salvo com sucesso!');
      });
  });
  
  function goBack() {
      alert('Voltar');
      // Aqui você pode adicionar a lógica para voltar à página anterior
  }
  
  function addNewService() {
      alert('Adicionar novo serviço');
      // Aqui você pode adicionar a lógica para adicionar um novo serviço
  }
  
  function editService(id) {
      alert('Editar serviço ' + id);
      // Aqui você pode adicionar a lógica para editar o serviço
  }
  
  function deleteService(id) {
      alert('Excluir serviço ' + id);
      // Aqui você pode adicionar a lógica para excluir o serviço
  }