<?php
require_once 'config.php';
requireLogin();

if ($_POST) {
    $id = $_POST['id'] ?? null;
    if (!$id || !is_numeric($id)) die("Некорректный ID");

    $stmt = $pdo->prepare("SELECT user_id FROM messages WHERE id = ?");
    $stmt->execute([$id]);
    $msg = $stmt->fetch();

    if (!$msg) die("Сообщение не найдено");
    requireOwnerOrAdmin($msg['user_id']);

    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: index.php');
    exit;
}
?>