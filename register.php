<?php
require_once 'includes/config.php';
require_once 'includes/auth_functions.php';

redirectIfLoggedIn();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $full_name = trim($_POST['full_name']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $department_id = $_POST['department']; 
    $role_id = $_POST['role']; 

    if (empty($username) || empty($full_name) || empty($password) || empty($department_id) || empty($role_id)) {
        $error = 'Все поля обязательны для заполнения!';
    } elseif ($password !== $confirm_password) {
        $error = 'Пароли не совпадают!';
    } elseif (strlen($password) < 6) {
        $error = 'Пароль должен содержать минимум 6 символов!';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);

            if ($stmt->rowCount() > 0) {
                $error = 'Пользователь с таким логином уже существует!';
            } else {
                if (registerUser($pdo, $username, $full_name, $password, $department_id, $role_id)) {
                    $success = 'Регистрация прошла успешно! Теперь вы можете войти.';
                    $_POST = array(); 
                } else {
                    $error = 'Ошибка при регистрации. Попробуйте позже.';
                }
            }
        } catch (PDOException $e) {
            $error = 'Ошибка базы данных: ' . $e->getMessage();
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-8 col-lg-6">
        <div class="auth-card fade-in">
            <div class="auth-header">
                <h2><i class="fas fa-user-plus me-2"></i>Регистрация</h2>
            </div>
            
            <div class="auth-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form action="register.php" method="post">
                    <div class="mb-4 position-relative">
                        <label for="username" class="form-label">Логин</label>
                        <div class="position-relative">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" class="form-control input-with-icon" id="username" name="username" 
                                   value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="full_name" class="form-label">ФИО</label>
                        <div class="position-relative">
                            <i class="fas fa-id-card input-icon"></i>
                            <input type="text" class="form-control input-with-icon" id="full_name" name="full_name" 
                                   value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Пароль</label>
                        <div class="position-relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control input-with-icon" id="password" name="password" required>
                        </div>
                        <div class="form-text">Минимум 6 символов</div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">Подтверждение пароля</label>
                        <div class="position-relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control input-with-icon" id="confirm_password" name="confirm_password" required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="department" class="form-label">Департамент</label>
                        <select class="form-select" id="department" name="department" required>
                            <option value="">Выберите департамент</option>
                            <?php
                            $stmt = $pdo->query("SELECT id, name FROM departments");
                            while ($row = $stmt->fetch()) {
                                $selected = ($_POST['department'] ?? '') == $row['id'] ? 'selected' : '';
                                echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="role" class="form-label">Роль</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Выберите роль</option>
                            <?php
                            $stmt = $pdo->query("SELECT id, name FROM roles");
                            while ($row = $stmt->fetch()) {
                                $selected = ($_POST['role'] ?? '') == $row['id'] ? 'selected' : '';
                                echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                        <i class="fas fa-user-plus me-2"></i>Зарегистрироваться
                    </button>
                    
                    <div class="text-center">
                        Уже есть аккаунт? <a href="login.php" class="text-decoration-none">Войти</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>