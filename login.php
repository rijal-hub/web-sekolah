<?php
session_start();
include 'admin/lomba_sekolah/db_connect.php';

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Cek password (gunakan password_verify jika password di-hash)
        if ($password === $user['password']) {
            $_SESSION['username'] = $user['username'];

            // Remember me
            if (isset($_POST['remember'])) {
                setcookie('username', $username, time() + (86400 * 30), "/");
            } else {
                setcookie('username', '', time() - 3600, "/");
            }

            header("Location: admin\beranda\beranda.php");
            exit;
        } else {
            $message = "Password salah!";
        }
    } else {
        $message = "Username tidak ditemukan!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="assets/css/login.css">z
</head>
<body>
<a href="index.php" class="blue-oval-btn" 
   style="position: fixed; 
          top: 20px; 
          left: 20px; 
          background: #0000fe; 
          box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
          border-radius: 25px; 
          padding: 8px 20px; 
          display: flex; 
          align-items: center; 
          text-decoration: none; 
          color: white; 
          border: none;
          font-weight: 500;
          transition: all 0.3s ease;">
  <span style="margin-left: 5px;">←</span>
</a>

<style>
.blue-oval-btn:hover {
  background: #2980b9;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
    <div class="login-container">
        <div class="login-box">
            <img src="admin/img/LAPANGAN.jpg" alt="Balai Kota Semarang" class="login-image"/>
            <div class="login-form">
                <h2>ADMIN LOGIN</h2>
                
                <?php if (!empty($message)): ?>
                    <p style="color: red; text-align: center;"><?php echo $message; ?></p>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="input-field">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="options">
                        <label><input type="checkbox" name="remember"> Remember Me</label>
                    </div>
                    <button type="submit" class="login-button" style="background-color: blue; color: white;">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
