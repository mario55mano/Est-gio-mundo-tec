<?php
// Painel lateral dos ecrãs de login e registo.
// Antes de o incluir, defina $lat_titulo e $lat_texto.
?>
<aside class="auth-side">
  <a class="logo" href="index.html">
    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2DD4BF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 3v6c0 4.5-3.2 8-8 9-4.8-1-8-4.5-8-9V6z"/><path d="M9 12l2 2 4-4"/></svg>
    CiberFixe
  </a>
 
  <div class="side-conteudo">
    <h2><?= e($lat_titulo) ?></h2>
    <p><?= e($lat_texto) ?></p>
 
    <ul class="side-lista">
      <li>Casos reais de burlas em Angola</li>
      <li>Missões curtas, de poucos minutos</li>
      <li>Pontos, medalhas e níveis</li>
    </ul>
 
    <div class="side-bolha">
      <small>+244 9XX XXX XXX</small>
      Parabéns! Ganhou um prémio de 500.000 Kz. Clique no link para o levantar hoje.
    </div>
    <span class="side-chip">Ignorar e denunciar</span>
  </div>
</aside>