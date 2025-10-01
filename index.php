<?php

require_once('config.php');
// var_dump($_POST);



$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt->fetchALL(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
            <form method="POST" action="add.php">
            <input type="text" name="name" placeholder="Ваше имя" required>
            <textarea name="message" rows="4" placeholder="Ваше сообщение" required></textarea>
            <button type="submit">Отправить</button>
        </form>

        <h3>Сообщения (<?= count($messages)?>):</h3>

        <?php if (empty($messages)): ?>
            <p>Пока нет сообщений. Будьте первым!</p>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <div class="message">
                    <div class="name"> 
                        <?= htmlspecialchars($msg['name']) ?> 
                    </div>
                    <div>
                        <?= htmlspecialchars($msg['message']) ?>
                    </div>
                    <div class="date"> 
                        <?= $msg['created_at'] ?> 
                    </div>
                        <a href="delete.php?id=<?= $msg['id'] ?>" 
                            class = "message_delete"
                            onclick="return confirm('Вы уверены, что хотите удалить это сообщение <?= $msg['name'];?> ?')">
                            Удалить
                        </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>