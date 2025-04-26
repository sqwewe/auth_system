<?php
require_once 'includes/config.php';
require_once 'includes/auth_functions.php';

redirectIfLoggedIn();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = 'Логин и пароль обязательны!';
    } else {
        if (loginUser($pdo, $username, $password)) {
            header("Location: dashboard.php");
            exit();
        } else {
            $error = 'Неверный логин или пароль!';
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-8 col-lg-6">
        <div class="auth-card fade-in">
            <div class="auth-header">
                <h2><i class="fas fa-sign-in-alt me-2"></i>Авторизация</h2>
            </div>
            
            <div class="auth-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form action="login.php" method="post">
                    <div class="mb-4 position-relative">
                        <label for="username" class="form-label">Логин</label>
                        <div class="position-relative">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" class="form-control input-with-icon" id="username" name="username" 
                                   value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Пароль</label>
                        <div class="position-relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control input-with-icon" id="password" name="password" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i>Войти
                    </button>
                    
                    <div class="text-center">
                        Нет аккаунта? <a href="register.php" class="text-decoration-none">Зарегистрироваться</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>