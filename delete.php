<?php

require_once 'config.php';

if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Некорректный ID");
}

$id = (int)$_GET['id']; 

$stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
$stmt->execute([$id]);

header('Location: index.php');
exit;

?>