<?php
require __DIR__ . '/config.php';
 
if (!isset($_SESSION['id_utilizador'])) {
    redirecionar('login.php');
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Painel — CiberFixe</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700&family=Inter:wght@400;500;600&display=swap">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="validacao.css">
</head>
<body>
  <main class="painel-simples">
    <h1>Olá, <?= e($_SESSION['nome']) ?>!</h1>
    <p>Sessão iniciada como <strong><?= e($_SESSION['login']) ?></strong> (<?= e($_SESSION['perfil']) ?>).</p>
    <p>Este painel é provisório e serve para testar o login. O painel real vem a seguir.</p>
 
    <form method="post" action="logout.php">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <button type="submit" class="btn btn-primary">Terminar sessão</button>
    </form>
  </main>
</body>
</html>
 