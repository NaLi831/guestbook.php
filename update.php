<?php

require_once 'config.php';

if ($_POST) {
    $id = $_POST['id'] ?? null;
    $name = trim($_POST['name'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$id || !is_numeric($id)) {
        die("Некорректный ID");
    }
    if (empty($name) || empty($message)) {
        die("Имя и сообщение не могут быть пустыми");
    }

    $stmt = $pdo->prepare("UPDATE messages SET name = ?, message = ? WHERE id = ?");
    $result = $stmt->execute([$name, $message, $id]);

    if ($result) {

        header('Location: index.php?success=1');
        exit;
    } else {
        die("Ошибка при обновлении");
    }
} else {

    header('Location: index.php');
    exit;
}
?>