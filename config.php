<?php
// config.php — ligação à base de dados, sessão e funções partilhadas.
// Todas as páginas PHP começam com:  require __DIR__ . '/config.php';
 
const DB_HOST = 'localhost';
const DB_NOME = 'ciberfixe';
const DB_USER = 'root';   // XAMPP: utilizador padrão
const DB_PASS = 'Mario@123';       // XAMPP: sem senha por padrão
 
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');
 
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure'   => !empty($_SERVER['HTTPS']),
]);
session_start();
 
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NOME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    error_log($e->getMessage());   // o detalhe fica no log, não no ecrã
    http_response_code(500);
    exit('Não foi possível ligar à base de dados.');
}
 
// Escapa texto antes de o mostrar no HTML (proteção contra XSS).
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}
 
function redirecionar(string $url): void
{
    header('Location: ' . $url);
    exit;
}
 
// Token CSRF: cada formulário leva um, e o servidor confirma-o.
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}
 
function csrf_ok(): bool
{
    return isset($_POST['csrf'], $_SESSION['csrf'])
        && hash_equals($_SESSION['csrf'], $_POST['csrf']);
}
 
// Para onde vai cada perfil depois de entrar.
function destino_por_perfil(string $perfil): string
{
    $existe_admin = is_file(__DIR__ . '/admin/index.php');
    return ($perfil === 'admin' && $existe_admin) ? 'admin/index.php' : 'painel.php';
}
 
// Guarda o utilizador na sessão (e muda o identificador da sessão).
function iniciar_sessao(int $id, string $login, string $nome, string $perfil): void
{
    session_regenerate_id(true);
    unset($_SESSION['csrf']);
    $_SESSION['id_utilizador'] = $id;
    $_SESSION['login']         = $login;
    $_SESSION['nome']          = $nome;
    $_SESSION['perfil']        = $perfil;
}
 