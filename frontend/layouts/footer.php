<?php
try {
    // Consulta para buscar os ícones e URLs de redes sociais da tabela LinksUteis
    $sql = "SELECT url_link, icon FROM LinksUteis";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $socialLinks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Caso ocorra um erro, pode-se exibir uma mensagem para desenvolvedores
    error_log("Erro ao buscar links: " . $e->getMessage());
    $socialLinks = [];
}
?>

<footer class="footer-custom">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Sobre Nós</h5>
                <p>Aqui você encontra diversas informações de serviços para seu dia a dia.</p>
            </div>
            <div class="col-md-4">
                <h5>Navegação</h5>
                <ul class="list-unstyled">
                    <li><a href="\projAxeySenai\index.php">Início</a></li>
                    <li><a href="\projAxeySenai\frontend\planos\planos.php">Planos</a></li>
                    <li><a href="#">Contato</a></li>
                    <li><a href="#">Termos de Uso</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Redes Sociais</h5>
                <div class="social-links">
                    <?php
                    // Itera sobre cada link de rede social e exibe o ícone
                    foreach ($socialLinks as $link) {
                        echo '<a href="' . htmlspecialchars($link['url_link']) . '" target="_blank">';
                        echo '<i class="' . htmlspecialchars($link['icon']) . '"></i>';
                        echo '</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center mt-3">
            <p>© <span id="current-year"></span> Axey. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>

<script>
    // Script para exibir o ano atual no footer
    document.getElementById("current-year").textContent = new Date().getFullYear();
</script>
