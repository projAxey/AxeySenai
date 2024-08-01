// Espera o carregamento completo do conteúdo do DOM antes de executar o código
document.addEventListener("DOMContentLoaded", () => {
  // Obtém os elementos do DOM pelos seus IDs
  const prevMonth = document.getElementById("prevMonth");
  const nextMonth = document.getElementById("nextMonth");
  const monthYear = document.getElementById("monthYear");
  const datesContainer = document.getElementById("dates");

    let currentDate = new Date();

  // Adiciona um evento de clique ao botão de mês anterior
  prevMonth.addEventListener("click", () => {
    // Decrementa o mês da data atual
        currentDate.setMonth(currentDate.getMonth() - 1);
    // Atualiza o calendário
        renderCalendar();
    });

  // Adiciona um evento de clique ao botão de próximo mês
  nextMonth.addEventListener("click", () => {
    // Incrementa o mês da data atual
        currentDate.setMonth(currentDate.getMonth() + 1);
    // Atualiza o calendário
        renderCalendar();
    });

  // Função para renderizar o calendário
    function renderCalendar() {
    // Obtém o mês e o ano atuais
        const month = currentDate.getMonth();
        const year = currentDate.getFullYear();

    // Atualiza o texto do elemento monthYear para mostrar o mês e ano atuais
    monthYear.textContent = `${new Intl.DateTimeFormat("pt-BR", {
      month: "long",
    }).format(currentDate)} ${year}`;

    // Obtém o primeiro dia do mês atual (0-6, onde 0 é domingo)
        const firstDayOfMonth = new Date(year, month, 1).getDay();
    // Obtém o último dia do mês atual (1-31)
        const lastDateOfMonth = new Date(year, month + 1, 0).getDate();
    // Obtém o último dia do mês anterior (1-31)
        const lastDayOfLastMonth = new Date(year, month, 0).getDate();

    // Limpa todos os elementos dentro do contêiner de datas
    datesContainer.innerHTML = "";

    // Adiciona os dias do mês anterior ao início do calendário
        for (let i = firstDayOfMonth; i > 0; i--) {
      const dateElement = document.createElement("div");
      dateElement.className = "calendar-date text-muted";
            dateElement.textContent = lastDayOfLastMonth - i + 1;
            datesContainer.appendChild(dateElement);
        }

    // Adiciona os dias do mês atual ao calendário
        for (let i = 1; i <= lastDateOfMonth; i++) {
      const dateElement = document.createElement("div");
      dateElement.className = "calendar-date";
            dateElement.textContent = i;
            datesContainer.appendChild(dateElement);
        }
    }

  // Chama a função para renderizar o calendário pela primeira vez com a data atual
    renderCalendar();
});
