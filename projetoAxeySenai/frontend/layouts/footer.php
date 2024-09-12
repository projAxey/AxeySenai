<style> 

.footer-custom {
  background-color: #002b5c;
  color: #fff;
  padding: 2rem 0;
}

.footer-custom h5 {
  font-size: 1.25rem;
  margin-bottom: 1rem;
}

.footer-custom p {
  font-size: 1rem;
  line-height: 1.5;
}

.footer-custom ul {
  padding: 0;
  list-style: none;
}

.footer-custom ul li {
  margin-bottom: 0.5rem;
}

.footer-custom ul li a {
  color: #fff;
  text-decoration: none;
  transition: color 0.3s ease;
}

.footer-custom ul li a:hover {
  color: #d1d1d1;
}

.footer-custom .social-links {
  display: flex;
  gap: 1rem;
}

.footer-custom .social-links a {
  color: #fff;
  font-size: 1.5rem;
  transition: color 0.3s ease;
}

.footer-custom .social-links a:hover {
  color: #d1d1d1;
}

.footer-custom .footer-bottom {
  border-top: 1px solid #004080;
  padding-top: 1rem;
  margin-top: 1rem;
}

.footer-custom .footer-bottom p {
  margin: 0;
}

.footer-custom .footer-bottom span {
  font-weight: bold;
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