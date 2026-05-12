<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
requireLogin();

$error = '';
$courses = $pdo->query("SELECT course_name FROM courses ORDER BY course_name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $course = trim($_POST['course']);
    $semester = (int)$_POST['semester'];
    $gpa = (float)$_POST['gpa'];
    $enrollment_date = $_POST['enrollment_date'];
    $guardian_name = trim($_POST['guardian_name']);
    $guardian_phone = trim($_POST['guardian_phone']);
    $guardian_relation = trim($_POST['guardian_relation']);
    $status = $_POST['status'];
    
    // Check if student_id exists
    $check = $pdo->prepare("SELECT id FROM students WHERE student_id = ?");
    $check->execute([$student_id]);
    
    if ($check->rowCount() > 0) {
        $error = "Student ID already exists!";
    } else {
        $sql = "INSERT INTO students (student_id, name, email, phone, date_of_birth, gender, address, city, course, semester, gpa, enrollment_date, guardian_name, guardian_phone, guardian_relation, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$student_id, $name, $email, $phone, $date_of_birth, $gender, $address, $city, $course, $semester, $gpa, $enrollment_date, $guardian_name, $guardian_phone, $guardian_relation, $status])) {
            $_SESSION['message'] = "Student added successfully!";
            $_SESSION['message_type'] = "success";
            header("Location: list.php");
            exit;
        } else {
            $error = "Failed to add student.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - Student Management System</title>
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
        <div class="form-container">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">➕ Add New Student</h2>
                    <a href="list.php" class="btn btn-warning">← Back</a>
                </div>
                
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <h3 style="margin-bottom: 15px; color: var(--primary);">Personal Information</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Student ID *</label>
                            <input type="text" name="student_id" placeholder="e.g., STU-24001" required>
                        </div>
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="name" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth">
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <select name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city">
                        </div>
                    </div>
                    
                    <h3 style="margin: 20px 0 15px; color: var(--primary);">Academic Information</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Course *</label>
                            <select name="course" required>
                                <option value="">Select Course</option>
                                <?php foreach($courses as $course): ?>
                                    <option value="<?php echo htmlspecialchars($course['course_name']); ?>">
                                        <?php echo htmlspecialchars($course['course_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Semester *</label>
                            <select name="semester" required>
                                <?php for($i = 1; $i <= 8; $i++): ?>
                                    <option value="<?php echo $i; ?>">Semester <?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>GPA</label>
                            <input type="number" step="0.01" min="0" max="4" name="gpa" placeholder="0.00">
                        </div>
                        <div class="form-group">
                            <label>Enrollment Date</label>
                            <input type="date" name="enrollment_date">
                        </div>
                    </div>
                    
                    <h3 style="margin: 20px 0 15px; color: var(--primary);">Guardian Information</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Guardian Name</label>
                            <input type="text" name="guardian_name">
                        </div>
                        <div class="form-group">
                            <label>Guardian Phone</label>
                            <input type="text" name="guardian_phone">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Guardian Relation</label>
                        <input type="text" name="guardian_relation" placeholder="e.g., Father, Mother">
                    </div>
                    
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Graduated">Graduated</option>
                            <option value="Suspended">Suspended</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Add Student</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>