<?php
require_once 'auth.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система заметок</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-brand">
                <h1>📝 Система заметок</h1>
            </div>
            <div class="nav-menu">
                <?php if (isLoggedIn()): ?>
                    <a href="dashboard.php">Личный кабинет</a>
                    <a href="notes.php">Мои заметки</a>
                    <a href="note_create.php">Создать заметку</a>
                    <span class="user-info"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="logout.php" class="logout-btn">Выйти</a>
                <?php else: ?>
                    <a href="index.php">Главная</a>
                    <a href="login.php">Войти</a>
                    <a href="register.php">Регистрация</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    
    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>