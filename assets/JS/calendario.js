// async function capturarResposta(event) {
//     // Previne o comportamento padrão do formulário
//     event.preventDefault();

//     try {
//         // Faz uma requisição para o arquivo PHP
//         const response = await fetch('/projAxeySenai/backend/calendario/disponibilidadeInserir.php');

//         // Verifica se a resposta foi bem-sucedida
//         if (response.ok) {
//             const data = await response.text(); // Converte a resposta para JSON
//             console.log(data);

//             // Verifica a resposta e exibe a mensagem
//             if (data.status === 'sucesso') {
//                 console.log(data.mensagem);  // Exibe a mensagem no console
//                 alert(data.mensagem);        // Exibe a mensagem em um alerta
//             } else {
//                 console.log('Erro:', data.mensagem); // Se houver erro, exibe a mensagem de erro
//             }
//         } else {
//             console.log('Erro na requisição:', response.statusText); // Se a resposta falhar
//         }
//     } catch (error) {
//         console.error('Erro ao buscar a resposta do PHP:', error);
//     }
// }

function abreFormulario() {
    document.getElementById('popupForm').style.display = 'block';
}

function fechaFormulario() {
    document.getElementById('popupForm').style.display = 'none';
}

// function exibeSolicitacao() {
//     document.getElementById('exibe-solicitacao').style.display = 'block';
// }

document.addEventListener('DOMContentLoaded', function () {
// Associa a função ao evento de submit do formulário
// document.getElementById('saveEventDisponibilidade').addEventListener('submit', capturarResposta);

// Associa a função ao clique no botão que abre o formulário
document.getElementById('show-calendar').addEventListener('click', abreFormulario);
document.getElementById('close-cadastro-disponibilidade').addEventListener('click', fechaFormulario);
// document.getElementById('exibe-solicitacao').addEventListener('click', exibeSolicitacao);


});

