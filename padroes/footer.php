<style> 
    /* Estilo do footer */
.footer-custom {
  background-color: #002b5c; /* Cor de fundo personalizada */
  color: #fff; /* Cor do texto */
  padding: 2rem 0; /* Padding superior e inferior */
}

.footer-custom h5 {
  font-size: 1.25rem; /* Tamanho da fonte dos títulos */
  margin-bottom: 1rem; /* Espaçamento abaixo dos títulos */
}

.footer-custom p {
  font-size: 1rem; /* Tamanho da fonte dos parágrafos */
  line-height: 1.5; /* Altura da linha para melhor legibilidade */
}

.footer-custom ul {
  padding: 0; /* Remove o padding padrão das listas */
  list-style: none; /* Remove os marcadores de lista */
}

.footer-custom ul li {
  margin-bottom: 0.5rem; /* Espaçamento entre os itens da lista */
}

.footer-custom ul li a {
  color: #fff; /* Cor dos links */
  text-decoration: none; /* Remove o sublinhado dos links */
  transition: color 0.3s ease; /* Transição suave para a cor dos links */
}

.footer-custom ul li a:hover {
  color: #d1d1d1; /* Cor dos links ao passar o mouse */
}

.footer-custom .social-links {
  display: flex; /* Exibe os ícones de redes sociais em linha */
  gap: 1rem; /* Espaçamento entre os ícones */
}

.footer-custom .social-links a {
  color: #fff; /* Cor dos ícones das redes sociais */
  font-size: 1.5rem; /* Tamanho dos ícones */
  transition: color 0.3s ease; /* Transição suave para a cor dos ícones */
}

.footer-custom .social-links a:hover {
  color: #d1d1d1; /* Cor dos ícones ao passar o mouse */
}

.footer-custom .footer-bottom {
  border-top: 1px solid #004080; /* Borda superior para separar o texto */
  padding-top: 1rem; /* Padding superior */
  margin-top: 1rem; /* Margem superior */
}

.footer-custom .footer-bottom p {
  margin: 0; /* Remove a margem do parágrafo */
}

.footer-custom .footer-bottom span {
  font-weight: bold; /* Destaca o texto */
}
</style>

<footer class="footer-custom">
    <div>
        <div class="row">
            <div class="col-md-4">
                <h5>Sobre Nós</h5>
                <p>Aqui você encontra diversas variedades de serviços para seu dia a dia.</p>
            </div>
            <div class="col-md-4">
                <h5>Links Úteis</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Início</a></li>
                    <li><a href="#">Planos</a></li>
                    <li><a href="#">Contato</a></li>
                    <li><a href="#">Termos de Uso</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Redes Sociais</h5>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center mt-3">
            <p>&copy; <span id="current-year"></span> Axey. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    var currentYear = new Date().getFullYear();
    document.getElementById("current-year").textContent = currentYear;
  });
</script>
