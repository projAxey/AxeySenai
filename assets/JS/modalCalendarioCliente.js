document.addEventListener("DOMContentLoaded", function () {
    const exibeSolicitacao = document.querySelectorAll('.editaDisponibilidade');
    // alert("teste");

    exibeSolicitacao.forEach(function (botao) {
        botao.addEventListener("click", async (event) => {
            event.preventDefault();
            const disponibilidadeId = botao.value;
            alert(disponibilidadeId);
            alert("teste");
            
            try {
                const dados = await fetch(`../../backend/calendario/buscaAgendamentos.php?id=${disponibilidadeId}`);
                const resposta = await dados.json();
               
                if (resposta.error) {
                    Swal.fire({
                        icon: "error",
                        title: "Erro",
                        text: resposta.error
                    });
                } else {
                    document.getElementById('idAgendamento').value = resposta.agendamento_id
                    
                    console.log(resposta); // Corrigido: substituído "print" por "console.log"
                    const popupForm = document.getElementById('popupForm');
                    popupForm.style.display = "block";  
                }
            } catch (jsonError) {
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "Houve um problema ao tentar buscar os dados da disponibilidade."
                });
            }
        });
    });

    // Fechar o modal ao clicar no botão "Fechar"
    document.getElementById('close-cadastro-disponibilidade').addEventListener("click", function () {
        const popupForm = document.getElementById('popupForm'); // Corrigido: usou o id correto do modal
        popupForm.style.display = "none"; // Esconde o modal
    });
});
