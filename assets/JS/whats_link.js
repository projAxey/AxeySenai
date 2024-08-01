document.getElementById('whatsappButton').addEventListener('click', function() {
    const phoneNumber = '5547996522605'; // Número de telefone com código do país (55 para Brasil)
    const message = encodeURIComponent('Olá, gostaria de mais informações.'); // Mensagem opcional
    const url = `https://wa.me/${phoneNumber}?text=${message}`;
    window.open(url, '_blank');
  });