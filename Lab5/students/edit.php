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

$error = '';
$courses = $pdo->query("SELECT course_name FROM courses ORDER BY course_name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    
    $sql = "UPDATE students SET name=?, email=?, phone=?, date_of_birth=?, gender=?, address=?, city=?, course=?, semester=?, gpa=?, enrollment_date=?, guardian_name=?, guardian_phone=?, guardian_relation=?, status=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$name, $email, $phone, $date_of_birth, $gender, $address, $city, $course, $semester, $gpa, $enrollment_date, $guardian_name, $guardian_phone, $guardian_relation, $status, $id])) {
        $_SESSION['message'] = "Student updated successfully!";
        $_SESSION['message_type'] = "success";
        header("Location: list.php");
        exit;
    } else {
        $error = "Failed to update student.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - Student Management System</title>
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
                    <h2 class="card-title">✏️ Edit Student: <?php echo htmlspecialchars($student['name']); ?></h2>
                    <a href="list.php" class="btn btn-warning">← Back</a>
                </div>
                
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <h3 style="margin-bottom: 15px; color: var(--primary);">Personal Information</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>">
                        </div>
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth" value="<?php echo $student['date_of_birth']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Gender</label>
                            <select name="gender">
                                <option value="Male" <?php echo $student['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo $student['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo $student['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" value="<?php echo htmlspecialchars($student['city']); ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" rows="2"><?php echo htmlspecialchars($student['address']); ?></textarea>
                    </div>
                    
                    <h3 style="margin: 20px 0 15px; color: var(--primary);">Academic Information</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Course *</label>
                            <select name="course" required>
                                <?php foreach($courses as $course): ?>
                                    <option value="<?php echo htmlspecialchars($course['course_name']); ?>" 
                                        <?php echo $student['course'] == $course['course_name'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($course['course_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Semester *</label>
                            <select name="semester" required>
                                <?php for($i = 1; $i <= 8; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php echo $student['semester'] == $i ? 'selected' : ''; ?>>
                                        Semester <?php echo $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>GPA</label>
                            <input type="number" step="0.01" min="0" max="4" name="gpa" value="<?php echo $student['gpa']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Enrollment Date</label>
                            <input type="date" name="enrollment_date" value="<?php echo $student['enrollment_date']; ?>">
                        </div>
                    </div>
                    
                    <h3 style="margin: 20px 0 15px; color: var(--primary);">Guardian Information</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Guardian Name</label>
                            <input type="text" name="guardian_name" value="<?php echo htmlspecialchars($student['guardian_name']); ?>">
                        </div>
                        <div class="form-group">
                            <label>Guardian Phone</label>
                            <input type="text" name="guardian_phone" value="<?php echo htmlspecialchars($student['guardian_phone']); ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Guardian Relation</label>
                        <input type="text" name="guardian_relation" value="<?php echo htmlspecialchars($student['guardian_relation']); ?>" placeholder="e.g., Father, Mother">
                    </div>
                    
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="Active" <?php echo $student['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                            <option value="Inactive" <?php echo $student['status'] == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                            <option value="Graduated" <?php echo $student['status'] == 'Graduated' ? 'selected' : ''; ?>>Graduated</option>
                            <option value="Suspended" <?php echo $student['status'] == 'Suspended' ? 'selected' : ''; ?>>Suspended</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>