<?php

require_once('config.php');
// var_dump($_POST);

//$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");

$stmt = $pdo->query("
    SELECT m.*, u.username 
    FROM messages m 
    JOIN users u ON m.user_id = u.id 
    ORDER BY m.created_at DESC
");
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
<body class="body_index">
    
    <div class="flash">
        <?php 
            if (isset($_SESSION['flash_success'])) {
                echo $_SESSION['flash_success'];
                unset($_SESSION['flash_success']);
            }
        ?>
    </div>

    <div class="container_index">
    
        <div class="auth-bar">
            <?php if (isUser()): ?>
                Привет, <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong>
                <?php if (isAdmin()): ?>
                    <span class="admin-tag">АДМИН</span>
                <?php endif; ?>
                    <form class="form_inx" action="logout.php" method="POST" style="display:inline;" onsubmit="return confirm('Выйти?')">
                        <button class="in_log_but" type="submit" > Выйти</button>
                    </form>
                
            <?php else: ?>
                <a href="login.php">Войти</a>
                <a href="register.php"> Регистрация</a>
            <?php endif; ?>
        </div>



        <h1 class="index_i">Гостевая книга</h1>


        <?php if (isUser()): ?>
            <form action="add.php" method="POST" class="form_inx">
                <textarea class="text_ar_inx" name="message" rows="3" placeholder="Напишите сообщение..." required></textarea>
                <button class="button_On" type="submit">Отправить</button>
            </form>
        <?php else: ?>
            <p><a href="login.php">Войдите</a> или <a href="register.php">зарегистрируйтесь</a>, чтобы оставить сообщение.</p>
        <?php endif; ?>

        <hr>

        <h3>Сообщения (<?= count($messages) ?>):</h3>
        <?php if (empty($messages)): ?>
            <p>Пока нет сообщений. Будьте первым!</p>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <div class="message">
                    <div class="message-header">
                        <div>
                            <span class="username"><?= htmlspecialchars($msg['username']) ?></span>
                            <?php if ($msg['username'] === 'admin'): ?>
                                <span class="admin-tag">АДМИН</span>
                            <?php endif; ?>
                        </div>
                        <div class="date"> <?= $msg['created_at'] ?></div>
                    </div>
                    <div style="margin: 10px 0;"><?= nl2br(htmlspecialchars($msg['message'])) ?></div>

                    
                    <?php if (isUser() && (isAdmin() || $msg['user_id'] == getCurrentUserId())): ?>
                        <div class="actions">
                            <a class="in_red" href="edit.php?id=<?= $msg['id'] ?>"> Редактировать</a>

                            <form class="form_inx" action="delete.php" method="POST" style="display:inline;" onsubmit="return confirm('Удалить?')">
                                <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                                <button class="message_delete" type="submit" > Удалить</button>
                            </form>
                            
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</body>
</html>