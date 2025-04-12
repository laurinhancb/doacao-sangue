<?php
require_once 'init.php'; // Substitui o session_start()

if (!isset($_SESSION['doador'])) {
    // Armazena a URL atual para redirecionamento pós-login
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; 
    header('Location: login.php?erro=acesso_negado');
    exit();
}
?>