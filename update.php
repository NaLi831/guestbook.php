<?php
require_once 'config.php';
requireLogin();

if ($_POST) {
    $id = $_POST['id'] ?? null;
    $message_text = trim($_POST['message'] ?? '');

    if (!$id || !is_numeric($id) || empty($message_text)) die("Некорректные данные");

    $stmt = $pdo->prepare("SELECT user_id FROM messages WHERE id = ?");
    $stmt->execute([$id]);
    $msg = $stmt->fetch();

    if (!$msg) die("Сообщение не найдено");
    requireOwnerOrAdmin($msg['user_id']);

    $stmt = $pdo->prepare("UPDATE messages SET message = ? WHERE id = ?");
    $stmt->execute([$message_text, $id]);

    header('Location: index.php?success=1');
    exit;
}
?>