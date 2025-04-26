<?php
require_once 'includes/config.php';
require_once 'includes/auth_functions.php';

redirectIfNotLoggedIn();
?>

<?php include 'includes/header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-8 col-lg-6">
        <div class="auth-card fade-in">
            <div class="auth-header">
                <h2><i class="fas fa-user-circle me-2"></i>Личный кабинет</h2>
            </div>
            
            <div class="auth-body">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Информация о пользователе</h5>
                        <hr>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">ФИО</h6>
                            <p><?php echo htmlspecialchars($_SESSION['full_name']); ?></p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">Логин</h6>
                            <p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">Департамент</h6>
                            <p><?php echo htmlspecialchars($_SESSION['department']); ?></p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">Роль</h6>
                            <p><?php echo htmlspecialchars($_SESSION['role']); ?></p>
                        </div>
                    </div>
                </div>
                
                <a href="logout.php" class="btn btn-danger w-100">
                    <i class="fas fa-sign-out-alt me-2"></i>Выйти
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>