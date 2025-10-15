<?php
require_once 'config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

session_destroy();
session_start();
$_SESSION['flash_success'] = 'Вы вышли';

header('Location: index.php');
exit();

?>