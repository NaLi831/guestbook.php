<?php
require_once 'config.php';

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("Некорректный ID сообщения");
}

$stmt = $pdo->prepare("SELECT * FROM messages WHERE id = ?");
$stmt->execute([$id]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$message) {
    die("Сообщение не найдено");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать сообщение</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Редактировать сообщение</h2>

        <form action="update.php" method="POST">

            <input class="input_edit" type="hidden" name="id" value="<?= htmlspecialchars($message['id']) ?>">

            <label for="name">Имя:</label>
            <input class="input_edit" type="text" id="name" name="name" value="<?= htmlspecialchars($message['name']) ?>" required>

            <label for="message">Сообщение:</label>
            <textarea class="textarea_edit" id="message" name="message" rows="5" required><?= htmlspecialchars($message['message']) ?></textarea>

            <button type="submit" class="btn_edit btn-save_edit">Сохранить изменения</button>
            <a href="index.php" class="btn_edit btn-cancel_edit">Отмена</a>
        </form>
    </div>
</body>
</html>