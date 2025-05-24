<?php
require_once 'lib/Db_connection.php';
require_once 'lib/Auth.php';

// Handle logout
if (isset($_GET['logout'])) {
    $auth = new Auth($conn);
    $auth->logout();
    header('Location: login.php');
    exit();
}

$auth = new Auth($conn);

// Redirect if already logged in
if ($auth->isAuthenticated()) {
    header('Location: dashboard.php');
    exit();
}

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error_message = 'Please enter both username and password.';
    } else {
        $result = $auth->login($username, $password);

        if ($result['success']) {
            header('Location: dashboard.php');
            exit();
        } else {
            $error_message = $result['message'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bahay Musika - Admin Login</title>
    <link rel="icon" href="https://scontent.fmnl17-4.fna.fbcdn.net/v/t39.30808-6/326550258_1211873573075989_6677191777421434541_n.png?_nc_cat=104&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeE6Urt2xxcxoLN8MjGWaK1K_DUXngsHECb8NReeCwcQJvRQ_toAsM5tsfVUWOQGNwfSWmpHmXy7nJB9cZoOvIDo&_nc_ohc=KZTZvuXVbMQQ7kNvgEsQxgG&_nc_zt=23&_nc_ht=scontent.fmnl17-4.fna&_nc_gid=AGbVG-ASeBS2vQfqePKkcRX&oh=00_AYCcaHCKgb-d8RBvxut-kIycO77cVquYY86DHb1wc8TodA&oe=675D887B" type="image/x-icon">

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background-image: radial-gradient(circle,
                    rgba(12, 12, 12, 0.87) 0%,
                    rgba(13, 13, 13, 0.945) 60%,
                    #101010 100%),
                url("../App/img/homeBackground.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            animation: slideUp 0.8s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, #333 0%, #555 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        }

        .login-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: 600;
            position: relative;
            z-index: 1;
        }

        .login-header p {
            opacity: 0.9;
            font-size: 16px;
            position: relative;
            z-index: 1;
        }

        .login-form {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            font-family: "Poppins", sans-serif;
        }

        .form-group input:focus {
            outline: none;
            border-color: #555;
            background: white;
            box-shadow: 0 0 0 3px rgba(85, 85, 85, 0.1);
            transform: translateY(-2px);
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #333 0%, #555 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
            font-family: "Poppins", sans-serif;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(51, 51, 51, 0.4);
            background: linear-gradient(135deg, #444 0%, #666 100%);
        }

        .login-btn:active {
            transform: translateY(-1px);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-error {
            background: linear-gradient(135deg, #fee 0%, #fdd 100%);
            color: #c33;
            border: 1px solid #fcc;
        }

        .alert-success {
            background: linear-gradient(135deg, #efe 0%, #dfd 100%);
            color: #363;
            border: 1px solid #cfc;
        }

        .setup-notice {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 1px solid #ffeaa7;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
            text-align: center;
        }

        .setup-notice h3 {
            color: #856404;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .setup-notice p {
            color: #856404;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .setup-btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #856404 0%, #b8860b 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }

        .setup-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(133, 100, 4, 0.3);
            color: white;
            text-decoration: none;
        }

        .default-accounts {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #dee2e6;
        }

        .default-accounts h3 {
            color: #495057;
            margin-bottom: 15px;
            font-size: 16px;
            text-align: center;
        }

        .account-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .account-item:last-child {
            border-bottom: none;
        }

        .account-role {
            font-weight: 600;
            color: #495057;
        }

        .account-username {
            color: #6c757d;
            font-size: 14px;
            font-family: monospace;
            background: rgba(0, 0, 0, 0.05);
            padding: 4px 8px;
            border-radius: 4px;
        }

        .footer-note {
            text-align: center;
            color: #6c757d;
            font-size: 12px;
            margin-top: 15px;
            padding: 10px;
            background: rgba(0, 0, 0, 0.05);
            border-radius: 8px;
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 10px;
                max-width: 100%;
            }

            .login-header {
                padding: 30px 20px;
            }

            .login-form {
                padding: 30px 20px;
            }

            .login-header h1 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Bahay Musika</h1>
            <p>Admin Panel Access</p>
        </div>

        <div class="login-form">
            <?php if ($error_message): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username or Email</label>
                    <input type="text" id="username" name="username" required
                        value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                        placeholder="Enter your username or email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required
                        placeholder="Enter your password">
                </div>

                <button type="submit" class="login-btn">Login to Dashboard</button>
            </form>

            <div class="setup-notice">
                <h3>First Time Setup?</h3>
                <p>If you're setting up the system for the first time, you need to create the admin users first.</p>
                <a href="setup_admin_users.php" class="setup-btn">Setup Admin Users</a>
            </div>

            <div class="default-accounts">
                <h3>Default Login Accounts</h3>
                <div class="account-item">
                    <div class="account-role">Head Administrator</div>
                    <div class="account-username">admin</div>
                </div>
                <div class="account-item">
                    <div class="account-role">Content Manager</div>
                    <div class="account-username">content_manager</div>
                </div>
                <div class="account-item">
                    <div class="account-role">Social Manager</div>
                    <div class="account-username">social_manager</div>
                </div>
                <div class="footer-note">
                    Default password for all accounts: <strong>123</strong><br>
                    <small>Please change passwords after first login</small>
                </div>
            </div>
        </div>
    </div>
</body>

</html>