<?php
require_once 'config.php';

$error = '';

if ($_POST) {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    try {

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$login, $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {

            unset($user['password_hash']); 
            $_SESSION['user'] = $user;
            $_SESSION['flash_success'] = 'Вы вошли';

            $redirect = $_SESSION['redirect_after_login'] ?? 'index.php';
            unset($_SESSION['redirect_after_login']);
            header('Location: ' . $redirect);
            exit;
        } else {
            $error = "Неверный логин или пароль";
        }
    } catch (Exception $e) {
        $error = "Ошибка входа: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="body_log">
    <div class="form-container_log">
        <h2 class="log_log">Вход</h2>

        <?php if ($error): ?>
            <div class="error_log"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <input class="input_log" type="text" name="login" placeholder="Имя пользователя или email" required>
            <input class="input_log" type="password" name="password" placeholder="Пароль" required>
            <button class="but_log" type="submit">Войти</button>
        </form>

        <div class="register-link_log">
            Нет аккаунта? <a href="register.php">Регистрация</a>
        </div>
    </div>
</body>
</html>