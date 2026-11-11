<?php
require __DIR__ . '/config.php';
 
if (isset($_SESSION['id_utilizador'])) {
    redirecionar(destino_por_perfil($_SESSION['perfil']));
}
 
$erros = [];
$login = $email = $nome = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_ok()) {
        $erros[] = 'A sessão expirou. Recarregue a página e tente de novo.';
    } else {
        $login    = trim($_POST['login'] ?? '');
        $email    = strtolower(trim($_POST['email'] ?? ''));
        $nome     = trim($_POST['nome'] ?? '');
        $senha    = $_POST['senha'] ?? '';
        $confirma = $_POST['confirma'] ?? '';
 
        if (!preg_match('/^[A-Za-z0-9._-]{3,30}$/', $login)) {
            $erros[] = 'O login deve ter entre 3 e 30 caracteres: letras, números, ponto, hífen ou sublinhado.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 120) {
            $erros[] = 'Indique um e-mail válido.';
        }
        if (mb_strlen($nome) > 50) {
            $erros[] = 'O nome de apresentação pode ter no máximo 50 caracteres.';
        }
        if (strlen($senha) < 8 || strlen($senha) > 72
            || !preg_match('/[A-Za-z]/', $senha) || !preg_match('/\d/', $senha)) {
            $erros[] = 'A senha deve ter pelo menos 8 caracteres, com letras e números.';
        }
        if ($senha !== $confirma) {
            $erros[] = 'As duas senhas não coincidem.';
        }
 
        if (!$erros) {
            try {
                $st = $pdo->prepare(
                    'INSERT INTO utilizador (login, email, senha_hash, nome_apresentacao)
                     VALUES (?, ?, ?, ?)'
                );
                $st->execute([
                    $login,
                    $email,
                    password_hash($senha, PASSWORD_DEFAULT),
                    $nome !== '' ? $nome : $login,
                ]);
 
                iniciar_sessao((int) $pdo->lastInsertId(), $login, $nome !== '' ? $nome : $login, 'jogador');
                redirecionar('painel.php');   // quando existir: 'diagnostico.php'
            } catch (PDOException $ex) {
                if ($ex->getCode() === '23000') {   // login ou e-mail já existe (UNIQUE)
                    $erros[] = 'Esse login ou e-mail já está registado.';
                } else {
                    error_log($ex->getMessage());
                    $erros[] = 'Não foi possível criar a conta. Tente mais tarde.';
                }
            }
        }
    }
}
 
$lat_titulo = 'Treine hoje, evite a burla amanhã.';
$lat_texto  = 'Crie a sua conta gratuita e comece pelo diagnóstico: descobrimos onde está mais vulnerável.';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Criar conta — CiberFixe</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700&family=Inter:wght@400;500;600&display=swap">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="validacao.css">
  <script>document.documentElement.classList.add("js");</script>
</head>
<body>
<div class="auth-grid">
 
  <?php require __DIR__ . '/lateral.php'; ?>
 
  <main class="auth-main">
    <div class="auth-card">
      <h1>Criar conta</h1>
      <p class="auth-sub">Leva menos de um minuto. Depois faz o diagnóstico inicial.</p>
 
      <?php if ($erros): ?>
        <div class="alerta" role="alert">
          <ul>
            <?php foreach ($erros as $erro): ?>
              <li><?= e($erro) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
 
      <form method="post" action="registro.php">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
 
        <div class="campo">
          <label for="login">Nome de usuário</label>
          <input type="text" id="login" name="login" value="<?= e($login) ?>"
                 required minlength="3" maxlength="30" pattern="[A-Za-z0-9._\-]{3,30}"
                 autocomplete="username" autocapitalize="none" spellcheck="false">
          <span class="dica">3 a 30 caracteres: letras, números, ponto, hífen ou sublinhado.</span>
        </div>
 
        <div class="campo">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" value="<?= e($email) ?>"
                 required maxlength="120" autocomplete="email">
        </div>
 
        <div class="campo">
          <label for="nome">Nome de apresentação (opcional)</label>
          <input type="text" id="nome" name="nome" value="<?= e($nome) ?>"
                 maxlength="50" autocomplete="nickname">
          <span class="dica">É o nome que aparece no ranking</span>
        </div>
 
        <div class="campo">
          <label for="senha">Senha</label>
          <div class="campo-senha">
            <input type="password" id="senha" name="senha" required minlength="8" maxlength="72"
                   autocomplete="new-password">
            <button type="button" class="mostrar-senha" data-alvo="senha" aria-pressed="false">Mostrar</button>
          </div>
          <span class="dica">Pelo menos 8 caracteres, com letras e números.</span>
        </div>
 
        <div class="campo">
          <label for="confirma">Repita a senha</label>
          <div class="campo-senha">
            <input type="password" id="confirma" name="confirma" required minlength="8" maxlength="72"
                   autocomplete="new-password">
            <button type="button" class="mostrar-senha" data-alvo="confirma" aria-pressed="false">Mostrar</button>
          </div>
        </div>
 
        <button type="submit" class="btn btn-primary btn-bloco">Criar conta e começar</button>
      </form>
 
      <p class="auth-links">Já tem conta? <a href="login.php">Entrar</a></p>
      <p class="auth-links"><a href="index.php">Voltar ao início</a></p>
    </div>
  </main>
 
</div>
<script src="senha.js"></script>
</body>
</html>
 