document.addEventListener("DOMContentLoaded", function () {
    const exibeSolicitacao = document.querySelectorAll('.editaDisponibilidade');
    // alert("teste 1");

    exibeSolicitacao.forEach((botao) => {
        botao.addEventListener("click", async (event) => {
            event.preventDefault();
            const disponibilidadeId = botao.value;
            // alert(disponibilidadeId);
            // alert("teste 2");
            
            try {
                alert("try");
                const dados = await fetch(`../../backend/calendario/buscaAgendamentos.php?id=${disponibilidadeId}`);
                const resposta = await dados.json();
                // alert(resposta);
               
                if (resposta.error) {
                    // alert("teste 3");

                    Swal.fire({
                        icon: "error",
                        title: "Erro",
                        text: resposta.error
                    });
                } else {
                    alert("teste 4");
                    document.getElementById('nomeProduto').value = resposta.nome_produto;
                    document.getElementById('categoriaProduto').value = resposta.titulo_categoria;
                    document.getElementById('serviceDate').value = resposta.data_agenda;
                    // document.getElementById('nomePrestador').value = resposta.data_agenda;
                    document.getElementById('descricaoServico').value = resposta.servico_descricao
                
                
                    
                    console.log(resposta); // Corrigido: substituído "print" por "console.log"
                    const popupForm = document.getElementById('popupForm');
                    popupForm.style.display = "block";  
                }
                
            } catch (error) {
                alert("teste 5");
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
