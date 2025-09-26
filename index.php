<?php
require_once('config.php');
// var_dump($_POST);

if ($_POST) {
    $name = trim($_POST['name']);
    $message = trim($_POST['message']);

    if ($name && $message) {
        $stmt = $pdo->prepare("INSERT INTO messages (name, message) VALUES (?, ?)");
        $stmt->execute([$name, $message]);

        header('Location: index.php');
        exit;
    } else {
        $error = "Пожалуйста, заполните все поля.";
    }
}

$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt->fetchALL(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            box-sizing: border-box;
        }
        
        body { font-family: Arial; margin:40px; background: #f0f0f0;}
        .container { max-width: 600px; margin:auto; background: white; padding: 20px; border-radius: 8px; }
        .message { padding: 15px; border-bottom: 1px solid #eee; }
        .name { font-weight: bold; color: #333; }
        .date { font-size: 0.8em; color: #888; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0 15px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
            <form method="POST">
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
                    <div class="name"> <?= htmlspecialchars($msg['name']) ?> </div>
                    <div><?= htmlspecialchars($msd['message']) ?></div>
                    <div class="date"> <?= $msd['created-at'] ?> </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>