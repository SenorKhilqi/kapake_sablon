<?php
// includes/auth.php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

function require_login() {
    if (!is_logged_in()) {
        $return = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'products.php';
        header('Location: ' . BASE_URL . '/login.php?return=' . urlencode($return));
        exit;
    }
}

function require_admin() {
    if (!is_logged_in() || !is_admin()) {
        header('Location: ' . BASE_URL . '/login.php');
        exit;
    }
}

?>
