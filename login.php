<?php
require_once 'includes/header.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (loginUser($username, $password)) {
        $_SESSION['message'] = "Добро пожаловать, " . $_SESSION['username'] . "!";
        $_SESSION['message_type'] = 'success';
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Неверное имя пользователя или пароль";
    }
}
?>

<div class="form-container">
    <h2 style="text-align: center; margin-bottom: 2rem; color: #333;">Вход в систему</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Имя пользователя или Email:</label>
            <input type="text" id="username" name="username" class="form-control" 
                   value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary" style="width: 100%;">Войти</button>
    </form>
    
    <p style="text-align: center; margin-top: 1rem;">
        Нет аккаунта? <a href="register.php">Зарегистрируйтесь здесь</a>
    </p>
</div>

<?php require_once 'includes/footer.php'; ?>