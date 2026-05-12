<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
requireLogin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) {
    $_SESSION['message'] = "Student not found!";
    $_SESSION['message_type'] = "error";
    header("Location: list.php");
    exit;
}

$initial = strtoupper(substr($student['name'], 0, 1));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($student['name']); ?> - Student Profile</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="../dashboard.php" class="logo">📚 <span>SMS</span></a>
            <ul class="nav-menu">
                <li><a href="../dashboard.php">Dashboard</a></li>
                <li><a href="list.php" class="active">Students</a></li>
                <li><a href="../reports/">Reports</a></li>
                <li><a href="../settings/profile.php">Profile</a></li>
            </ul>
            <div class="user-info">
                <span class="user-name">👋 <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <a href="../logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <div class="profile-view">
            <div class="profile-header">
                <div class="profile-avatar"><?php echo $initial; ?></div>
                <h1 class="profile-name"><?php echo htmlspecialchars($student['name']); ?></h1>
                <div class="profile-id"><?php echo $student['student_id']; ?></div>
            </div>
            
            <div class="profile-content">
                <div class="info-section">
                    <h3>Personal Information</h3>
                    <div class="info-grid">
                        <div class="info-label">Full Name:</div>
                        <div class="info-value"><?php echo htmlspecialchars($student['name']); ?></div>
                        
                        <div class="info-label">Student ID:</div>
                        <div class="info-value"><?php echo $student['student_id']; ?></div>
                        
                        <div class="info-label">Email:</div>
                        <div class="info-value"><?php echo htmlspecialchars($student['email']); ?></div>
                        
                        <div class="info-label">Phone:</div>
                        <div class="info-value"><?php echo $student['phone'] ?: 'Not provided'; ?></div>
                        
                        <div class="info-label">Date of Birth:</div>
                        <div class="info-value"><?php echo $student['date_of_birth'] ?: 'Not provided'; ?></div>
                        
                        <div class="info-label">Gender:</div>
                        <div class="info-value"><?php echo $student['gender'] ?: 'Not provided'; ?></div>
                        
                        <div class="info-label">Address:</div>
                        <div class="info-value"><?php echo nl2br(htmlspecialchars($student['address'] ?: 'Not provided')); ?></div>
                        
                        <div class="info-label">City:</div>
                        <div class="info-value"><?php echo $student['city'] ?: 'Not provided'; ?></div>
                    </div>
                </div>
                
                <div class="info-section">
                    <h3>Academic Information</h3>
                    <div class="info-grid">
                        <div class="info-label">Course:</div>
                        <div class="info-value"><?php echo htmlspecialchars($student['course']); ?></div>
                        
                        <div class="info-label">Current Semester:</div>
                        <div class="info-value">Semester <?php echo $student['semester']; ?></div>
                        
                        <div class="info-label">GPA:</div>
                        <div class="info-value"><?php echo $student['gpa']; ?> / 4.0</div>
                        
                        <div class="info-label">Enrollment Date:</div>
                        <div class="info-value"><?php echo $student['enrollment_date'] ?: 'Not provided'; ?></div>
                        
                        <div class="info-label">Status:</div>
                        <div class="info-value"><span class="badge badge-<?php echo strtolower($student['status']); ?>"><?php echo $student['status']; ?></span></div>
                    </div>
                </div>
                
                <div class="info-section">
                    <h3>Guardian Information</h3>
                    <div class="info-grid">
                        <div class="info-label">Guardian Name:</div>
                        <div class="info-value"><?php echo $student['guardian_name'] ?: 'Not provided'; ?></div>
                        
                        <div class="info-label">Guardian Phone:</div>
                        <div class="info-value"><?php echo $student['guardian_phone'] ?: 'Not provided'; ?></div>
                        
                        <div class="info-label">Relation:</div>
                        <div class="info-value"><?php echo $student['guardian_relation'] ?: 'Not provided'; ?></div>
                    </div>
                </div>
                
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-warning">✏️ Edit Student</a>
                    <a href="list.php" class="btn btn-primary">← Back to List</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>