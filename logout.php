<?php
require __DIR__ . '/config.php';
 
// Só termina a sessão por POST com token válido (evita que um link alheio o desligue).
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_ok()) {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $c = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $c['path'], $c['domain'], $c['secure'], $c['httponly']);
    }
    session_destroy();
}
 
redirecionar('index.php');