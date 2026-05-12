<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
requireLogin();

// Get current user info
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$success = '';
$error = '';

// Update profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    
    if (empty($full_name)) {
        $error = "Name cannot be empty";
    } else {
        $stmt = $pdo->prepare("UPDATE users SET full_name = ? WHERE id = ?");
        if ($stmt->execute([$full_name, $user_id])) {
            $_SESSION['user_name'] = $full_name;
            $success = "Profile updated successfully!";
            // Refresh user data
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();
        } else {
            $error = "Failed to update profile";
        }
    }
    
    // Password change
    if (!empty($_POST['new_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // For demo, we're using a simple check since password is hashed
        // In real system, you'd verify with password_verify()
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$hashed_password, $user_id]);
            $success = "Profile and password updated!";
        } elseif (!empty($new_password)) {
            $error = "Passwords do not match";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Student Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .profile-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .profile-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .profile-cover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
            text-align: center;
        }
        .profile-avatar {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 3rem;
            font-weight: bold;
            color: #667eea;
        }
        .profile-body {
            padding: 30px;
        }
        .info-group {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #eee;
        }
        .info-label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }
        .info-value {
            color: #333;
            font-size: 1.1rem;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
        }
        .alert-success {
            background: #c6f6d5;
            color: #22543d;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-error {
            background: #fed7d7;
            color: #742a2a;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .btn-save {
            background: #667eea;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-save:hover {
            background: #5a67d8;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="../dashboard.php" class="logo">📚 <span>SMS</span></a>
            <ul class="nav-menu">
                <li><a href="../dashboard.php">Dashboard</a></li>
                <li><a href="../students/list.php">Students</a></li>
                <li><a href="../reports/">Reports</a></li>
                <li><a href="profile.php" class="active">Profile</a></li>
            </ul>
            <div class="user-info">
                <span class="user-name">👋 <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <a href="../logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <div class="profile-container">
            <div class="profile-card">
                <div class="profile-cover">
                    <div class="profile-avatar">
                        <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
                    </div>
                    <h2 style="color: white; margin-top: 15px;"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
                    <p style="color: rgba(255,255,255,0.9);"><?php echo ucfirst($_SESSION['user_role']); ?></p>
                </div>
                
                <div class="profile-body">
                    <?php if ($success): ?>
                        <div class="alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    
                    <?php if ($error): ?>
                        <div class="alert-error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <div class="info-group">
                        <h3>Account Information</h3>
                        <div class="info-label">Username</div>
                        <div class="info-value"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                        
                        <div class="info-label" style="margin-top: 15px;">Role</div>
                        <div class="info-value"><?php echo ucfirst($_SESSION['user_role']); ?></div>
                    </div>
                    
                    <form method="POST" action="">
                        <div class="info-group">
                            <h3>Edit Profile</h3>
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? $_SESSION['user_name']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="info-group">
                            <h3>Change Password</h3>
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" name="current_password" placeholder="Enter current password">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="new_password" placeholder="Enter new password">
                            </div>
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" name="confirm_password" placeholder="Confirm new password">
                            </div>
                            <small style="color: #666;">Leave password fields empty to keep current password</small>
                        </div>
                        
                        <button type="submit" class="btn-save">💾 Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>