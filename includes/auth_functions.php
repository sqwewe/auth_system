<?php
function registerUser($pdo, $username, $full_name, $password, $department_id, $role_id) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, full_name, password, department_id, role_id) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$username, $full_name, $hashed_password, $department_id, $role_id]);
}

function loginUser($pdo, $username, $password) {
    $stmt = $pdo->prepare("SELECT users.*, departments.name as department_name, roles.name as role_name 
                          FROM users 
                          LEFT JOIN departments ON users.department_id = departments.id
                          LEFT JOIN roles ON users.role_id = roles.id
                          WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['department'] = $user['department_name']; 
        $_SESSION['role'] = $user['role_name']; 
        return true;
    }
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirectIfLoggedIn() {
    if (isLoggedIn()) {
        header("Location: dashboard.php");
        exit();
    }
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}
?>