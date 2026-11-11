<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CiberFixe — Aprenda a reconhecer burlas digitais jogando</title>
  <meta name="description" content="Missões curtas com burlas reais de Angola. Faça o diagnóstico, siga o seu percurso e proteja-se jogando.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700&family=Inter:wght@400;500;600&display=swap">
  <link rel="stylesheet" href="style.css">
  <script>document.documentElement.classList.add("js");</script>
</head>
<body>
 
  <header class="hero">
    <div class="container">
 
      <nav class="nav">
        <a class="logo" href="#">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2DD4BF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 3v6c0 4.5-3.2 8-8 9-4.8-1-8-4.5-8-9V6z"/><path d="M9 12l2 2 4-4"/></svg>
          CiberFixe
        </a>
        <div class="nav-links">
          <a href="#como">Como funciona</a>
          <a href="#modulos">Módulos</a>
          <a class="btn btn-ghost" href="login.php">Entrar</a>
        </div>
      </nav>
 
      <div class="hero-grid">
        <div class="hero-text">
          <h1>Reconheça a burla <span class="accent">antes</span> que ela o apanhe.</h1>
          <p>Missões curtas com mensagens, e-mails e chamadas falsas como as que circulam todos os dias. Treine a reacção certa, ganhe pontos e proteja a sua conta, o seu dinheiro e o seu trabalho.</p>
          <div class="actions">
            <a class="btn btn-primary" href="registro.php">Começar o diagnóstico</a>
            <a class="btn btn-ghost" href="#como">Ver como funciona</a>
          </div>
          <small>Gratuito para começar · Sem conhecimentos técnicos</small>
        </div>
 
        <div class="game-card">
          <div class="game-top">
            <span class="game-title">Detetive de burlas</span>
            <span class="game-points">Nível 2 · 340 pts</span>
          </div>
          <div class="message">
            <span class="message-from">+244 9XX XXX XXX</span>
            Parabéns! Ganhou um prémio de 500.000 Kz. Clique no link para o levantar hoje.
          </div>
          <p class="game-question">O que faz?</p>
          <div class="options">
            <button type="button" class="option">Clicar no link</button>
            <button type="button" class="option option-right">Ignorar e denunciar</button>
            <button type="button" class="option">Responder a perguntar</button>
          </div>
          <div class="progress"><span></span></div>
        </div>
      </div>
 
    </div>
  </header>
 
  <main>
 
    <section id="como" class="section container reveal">
      <h2>Três passos para se proteger</h2>
      <p class="section-sub">Cada pessoa começa num ponto diferente. A plataforma descobre o seu.</p>
      <div class="grid">
        <article class="card reveal">
          <span class="step step-1">1</span>
          <h3>Faça o diagnóstico</h3>
          <p>Algumas situações rápidas mostram onde está mais vulnerável.</p>
        </article>
        <article class="card reveal">
          <span class="step step-2">2</span>
          <h3>Siga o seu percurso</h3>
          <p>Recebe os módulos certos para si: telemóvel, trabalho, escola e mais.</p>
        </article>
        <article class="card reveal">
          <span class="step step-3">3</span>
          <h3>Jogue e evolua</h3>
          <p>Ganhe pontos, medalhas e níveis, e veja a sua evolução no teste final.</p>
        </article>
      </div>
    </section>
 
    <section id="modulos" class="section container reveal">
      <h2>Escolha onde quer estar mais seguro</h2>
      <div class="grid grid-4">
        <article class="card card-sm reveal">
          <span class="tag tag-hot">Mais jogado</span>
          <h3>Burlas no telemóvel</h3>
          <p>WhatsApp, SMS, falsos prémios e dinheiro móvel.</p>
        </article>
        <article class="card card-sm reveal">
          <span class="tag">Profissional</span>
          <h3>Proteção no trabalho</h3>
          <p>E-mails falsos, falso chefe e fuga de informação.</p>
        </article>
        <article class="card card-sm reveal">
          <span class="tag">Estudantes</span>
          <h3>Proteção na escola</h3>
          <p>Contas académicas, falsas bolsas e cyberbullying.</p>
        </article>
        <article class="card card-sm reveal">
          <span class="tag">Para todos</span>
          <h3>Redes sociais</h3>
          <p>Perfis falsos, contas roubadas e privacidade.</p>
        </article>
      </div>
    </section>
 
    <section class="cta reveal">
      <h2>Pronto para a primeira missão?</h2>
      <p>Leva poucos minutos e pode mesmo evitar uma burla.</p>
      <a class="btn btn-primary" href="registro.php">Criar conta e começar</a>
    </section>
 
  </main>
 
  <footer class="footer">CiberFixe - Projeto de Mário Quiangala</footer>
 
  <script>
    var items = document.querySelectorAll(".reveal");
    if ("IntersectionObserver" in window) {
      var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("visible");
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.15 });
      items.forEach(function (el) { observer.observe(el); });
    } else {
      items.forEach(function (el) { el.classList.add("visible"); });
    }
  </script>
 
</body>
</html>
 