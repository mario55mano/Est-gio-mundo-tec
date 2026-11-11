<?php
require __DIR__ . '/config.php';
 
if (isset($_SESSION['id_utilizador'])) {
    redirecionar(destino_por_perfil($_SESSION['perfil']));
}
 
const MAX_FALHAS     = 5;    // falhas permitidas...
const JANELA_MINUTOS = 15;   // ...nestes minutos
 
$erros = [];
$identificador = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_ok()) {
        $erros[] = 'A sessão expirou. Recarregue a página e tente de novo.';
    } else {
        $identificador = mb_substr(trim($_POST['identificador'] ?? ''), 0, 120);
        $senha         = $_POST['senha'] ?? '';
 
        if ($identificador === '' || $senha === '') {
            $erros[] = 'Preencha o login (ou e-mail) e a senha.';
        } else {
            // 1. Demasiadas falhas recentes com este login?
            $st = $pdo->prepare(
                'SELECT COUNT(*) FROM tentativa_login
                 WHERE login_usado = ? AND sucesso = 0
                   AND data_hora > (NOW() - INTERVAL ' . JANELA_MINUTOS . ' MINUTE)'
            );
            $st->execute([$identificador]);
 
            if ($st->fetchColumn() >= MAX_FALHAS) {
                $erros[] = 'Demasiadas tentativas falhadas. Tente de novo dentro de ' . JANELA_MINUTOS . ' minutos.';
            } else {
                // 2. Procurar o utilizador pelo login ou pelo e-mail
                $st = $pdo->prepare(
                    'SELECT id_utilizador, login, nome_apresentacao, senha_hash, perfil, estado
                     FROM utilizador WHERE login = ? OR email = ?'
                );
                $st->execute([$identificador, $identificador]);
                $u = $st->fetch();
 
                if ($u) {
                    $ok = password_verify($senha, $u['senha_hash']);
                } else {
                    password_hash($senha, PASSWORD_DEFAULT);   // gasta o mesmo tempo, para não revelar se o login existe
                    $ok = false;
                }
 
                // 3. Registar a tentativa (certa ou errada)
                $pdo->prepare('INSERT INTO tentativa_login (login_usado, sucesso) VALUES (?, ?)')
                    ->execute([$identificador, $ok ? 1 : 0]);
 
                if (!$ok) {
                    $erros[] = 'Login ou senha incorretos.';
                } elseif ($u['estado'] !== 'ativo') {
                    $erros[] = 'Esta conta está bloqueada. Contacte o administrador.';
                } else {
                    $pdo->prepare('UPDATE utilizador SET ultimo_acesso = NOW() WHERE id_utilizador = ?')
                        ->execute([$u['id_utilizador']]);
 
                    iniciar_sessao((int) $u['id_utilizador'], $u['login'], $u['nome_apresentacao'], $u['perfil']);
                    redirecionar(destino_por_perfil($u['perfil']));
                }
            }
        }
    }
}
 
$lat_titulo = 'Bem-vindo de volta.';
$lat_texto  = 'Continue o seu percurso e treine a reacção certa antes que a burla chegue.';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Entrar — CiberFixe</title>
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
      <h1>Entrar</h1>
      <p class="auth-sub">Use o seu nome de usuário ou o seu e-mail.</p>
 
      <?php if ($erros): ?>
        <div class="alerta" role="alert">
          <ul>
            <?php foreach ($erros as $erro): ?>
              <li><?= e($erro) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
 
      <form method="post" action="login.php">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
 
        <div class="campo">
          <label for="identificador">Nome de usuário ou e-mail</label>
          <input type="text" id="identificador" name="identificador" value="<?= e($identificador) ?>"
                 required maxlength="120" autocomplete="username" autocapitalize="none" spellcheck="false">
        </div>
 
        <div class="campo">
          <label for="senha">Senha</label>
          <div class="campo-senha">
            <input type="password" id="senha" name="senha" required autocomplete="current-password">
            <button type="button" class="mostrar-senha" data-alvo="senha" aria-pressed="false">Mostrar</button>
          </div>
        </div>
 
        <a class="link-esqueci" href="recuperar_senha.php">Esqueci a senha</a>
 
        <button type="submit" class="btn btn-primary btn-bloco">Entrar</button>
      </form>
 
      <p class="auth-links">Ainda não tem conta? <a href="registro.php">Criar conta</a></p>
      <p class="auth-links"><a href="index.php">Voltar ao início</a></p>
    </div>
  </main>
 
</div>
<script src="senha.js"></script>
</body>
</html>
 