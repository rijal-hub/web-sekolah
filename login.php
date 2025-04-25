<?php
session_start();

// Header Keamanan
// Header Keamanan
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");

include 'admin/lomba_sekolah/db_connect.php';

// Inisialisasi rate limiting
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt'] = time();
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cek rate limiting sebelum proses login
    if ($_SESSION['login_attempts'] > 3 && (time() - $_SESSION['last_attempt']) < 300) {
        $message = "Terlalu banyak percobaan login. Silakan coba lagi setelah 5 menit.";
    } else {
        // Validasi reCAPTCHA
        $recaptcha_secret = "6LdNBCMrAAAAAK2dhOlXYsnbTlOWLaQfwQb7wfsf";
        $recaptcha_response = $_POST['g-recaptcha-response'];
        
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_data = [
            'secret' => $recaptcha_secret,
            'response' => $recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];
        
        $recaptcha_options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($recaptcha_data)
            ]
        ];
        
        $recaptcha_context = stream_context_create($recaptcha_options);
        $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
        $recaptcha_json = json_decode($recaptcha_result);
        
        if (!$recaptcha_json->success) {
            $message = "Silakan verifikasi bahwa Anda bukan robot!";
            $_SESSION['login_attempts']++;
            $_SESSION['last_attempt'] = time();
        } else {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $sql = "SELECT username, password FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    // Reset login attempts on successful login
                    $_SESSION['login_attempts'] = 0;
                    
                    $_SESSION['username'] = $user['username'];

                    if (isset($_POST['remember'])) {
                        setcookie('username', $username, time() + (86400 * 30), "/");
                    } else {
                        setcookie('username', '', time() - 3600, "/");
                    }

                    header("Location: admin/beranda/beranda.php");
                    exit;
                } else {
                    $message = "Password salah!";
                    $_SESSION['login_attempts']++;
                    $_SESSION['last_attempt'] = time();
                    
                    // Logging untuk percobaan gagal
                    $log = date('Y-m-d H:i:s') . " - Failed login attempt for username: " . $username . " from IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
                    file_put_contents('admin/login_attempts.log', $log, FILE_APPEND);
                }
            } else {
                $message = "Username tidak ditemukan!";
                $_SESSION['login_attempts']++;
                $_SESSION['last_attempt'] = time();
                
                // Logging untuk percobaan gagal
                $log = date('Y-m-d H:i:s') . " - Failed login attempt for non-existent username: " . $username . " from IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
                file_put_contents('admin/login_attempts.log', $log, FILE_APPEND);
            }

            $stmt->close();
            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: url('admin/beranda/uploads/PLANG SEKOLAH.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .login-container {
            display: flex;
            flex-direction: row;
            width: 90%;
            max-width: 800px;
            height: 450px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease-in-out;
            position: relative;
            z-index: 1;
        }

        .login-image {
            flex: 1;
            overflow: hidden;
        }

        .login-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .login-box {
            flex: 1;
            padding: 40px;
            display: flex;
            align-items: center;
        }

        .login-form {
            width: 100%;
        }

        .login-form h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 28px;
        }

        .input-field {
            margin-bottom: 20px;
        }

        .input-field input {
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            border: none;
            border-radius: 10px;
            background: #f1f1f1;
            font-size: 16px;
        }

        .input-field input:focus {
            outline: none;
            background: #e1e1e1;
            box-shadow: 0 0 0 2px #3498db;
        }

        .options {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            color: #555;
            font-size: 14px;
        }

        .options input {
            margin-right: 10px;
        }

        .g-recaptcha {
            margin: 20px 0;
            display: flex;
            justify-content: center;
        }

        .login-button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #3498db, #2c3e50);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .login-button:hover {
            background: linear-gradient(135deg, #2980b9, #1a252f);
            transform: translateY(-2px);
        }

        .error-message {
            color: #e74c3c;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .back-button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            display: inline-flex;
            align-items: center;
            padding: 12px 25px;
            background: linear-gradient(135deg, #3498db, #2c3e50);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            z-index: 1000;
            font-size: 14px;
        }

        .back-button:hover {
            background: linear-gradient(135deg, #2980b9, #1a252f);
            transform: translateY(-3px);
        }

        .back-button .arrow {
            margin-right: 8px;
            font-size: 18px;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
            }

            .login-image {
                height: 200px;
            }

            .login-box {
                padding: 30px 20px;
            }

            .back-button {
                padding: 10px 20px;
                font-size: 12px;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <a href="index.php" class="back-button">
        <span class="arrow">←</span> Kembali
    </a>

    <div class="login-container">
        <div class="login-image">
            <img src="admin/lomba_sekolah/uploads/LAPANGAN.jpg" alt="Foto Lapangan">
        </div>
        <div class="login-box">
            <div class="login-form">
                <h2>ADMIN LOGIN</h2>

                <?php if (!empty($message)): ?>
                    <p class="error-message"><?php echo $message; ?></p>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="input-field">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="options">
                        <label><input type="checkbox" name="remember"> Remember Me</label>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LdNBCMrAAAAAP5ZQi-o1ucVJ97DxqPG3AIDfm2h"></div>
                    <button type="submit" class="login-button">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
