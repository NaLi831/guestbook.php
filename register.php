<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_POST) {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (strlen($username) < 3) {
        $error = "Имя пользователя должно быть не короче 3 символов";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Некорректный email";
    } elseif (strlen($password) < 6) {
        $error = "Пароль должен быть не короче 6 символов";
    } elseif ($password !== $password_confirm) {
        $error = "Пароли не совпадают";
    } else {
        try {

            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetch()) {
                $error = "Пользователь с таким именем или email уже существует";
            } else {

                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
                $stmt->execute([$username, $email, $password_hash]);

                $success = "Регистрация успешна! Теперь вы можете <a href='login.php'>войти</a>.";
            }
        } catch (Exception $e) {
            $error = "Ошибка регистрации: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="body_reg">
    <div class="form-container">
        <h2 class="reg_reg">Регистрация</h2>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php else: ?>
            <form method="POST">
                <input class="input_reg" type="text" name="username" placeholder="Имя пользователя" required minlength="3">
                <input class="input_reg" type="email" name="email" placeholder="Email" required>
                <input class="input_reg" type="password" name="password" placeholder="Пароль (мин. 6 символов)" required minlength="6">
                <input class="input_reg" type="password" name="password_confirm" placeholder="Подтвердите пароль" required>
                <button class="but_reg" type="submit">Зарегистрироваться</button>
            </form>
        <?php endif; ?>

        <div class="login-link">
            Уже есть аккаунт? <a href="login.php">Войти</a>
        </div>
    </div>
</body>
</html>