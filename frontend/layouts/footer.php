<?php include 'frontend/auth/visualizarDocs.php' ?>

<footer class="footer-custom">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Sobre Nós</h5>
                <p>Aqui você encontra diversas variedades de serviços para seu dia a dia.</p>
            </div>
            <div class="col-md-4">
                <h5>Links Úteis</h5>
                <ul class="list-unstyled">
                    <li><a href="\projAxeySenai\index.php">Início</a></li>
                    <li><a href="\projAxeySenai\frontend\planos\planos.php">Planos</a></li>
                    <li><a href="#">Contato</a></li>
                    <!-- Link que abre a modal de "Termos de Uso" -->
                    <?php if ($termos): ?>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="openDocument('<?= $termos['caminho_arquivo'] ?>')">Termos de Uso</a></li>
                    <?php else: ?>
                        <li>Termos de Uso não disponível</li>
                    <?php endif; ?>
                    <?php if ($politica): ?>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="openDocument('<?= $politica['caminho_arquivo'] ?>')">Politica de Privacidade</a></li>
                    <?php else: ?>
                        <li>Politica de Privacidade</li>
                    <?php endif; ?>
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
            <p>© <span id="current-year"></span> Axey. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>

