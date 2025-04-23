
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

        // Cek password dengan password_verify (bcrypt)
        if (password_verify($password, $user['password'])) {
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
    <link rel="stylesheet" href="assets/css/login.css">
    <style>
        /* Gaya khusus untuk tombol kembali */
        .back-button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background-color: #0000FF;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            transition: all 0.3s ease;
            font-family: Arial, sans-serif;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        
        .back-button:hover {
            background-color: #0000FF;
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }
        
        .back-button .arrow {
            margin-right: 8px;
            font-size: 18px;
        }
    </style>
</head>
<body>
<a href="index.php" class="back-button">
        <span class="arrow">←</span> Kembali
    </a>

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