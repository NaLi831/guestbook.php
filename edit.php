<?php
require_once 'config.php';
requireLogin();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) die("Некорректный ID");

$stmt = $pdo->prepare("SELECT m.*, u.username FROM messages m JOIN users u ON m.user_id = u.id WHERE m.id = ?");
$stmt->execute([$id]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$message) die("Сообщение не найдено");

requireOwnerOrAdmin($message['user_id']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать сообщение</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="body_edit">
    <div class="container_edit">
        <h2 class="Red_edit">Редактировать сообщение</h2>

        <form action="update.php" method="POST">

            <input class="input_edit" type="hidden" name="id" value="<?= htmlspecialchars($message['id']) ?>">

            <label for="name" class="label_edit">Имя:</label>
            <input class="input_edit" type="text" id="name" name="name" value="<?= htmlspecialchars($message['username']) ?>" required>

            <label for="message" class="label_edit">Сообщение:</label>
            <textarea class="textarea_edit" id="message" name="message" rows="5" required><?= htmlspecialchars($message['message']) ?></textarea>

            <button type="submit" class="btn_edit btn-save_edit">Сохранить изменения</button>
            <a href="index.php" class="btn_edit btn-cancel_edit">Отмена</a>
        </form>
    </div>
</body>
</html>