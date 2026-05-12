<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
requireLogin();

// Get statistics
$totalStudents = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$activeStudents = $pdo->query("SELECT COUNT(*) FROM students WHERE status = 'Active'")->fetchColumn();
$totalCourses = $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
$avgGPA = $pdo->query("SELECT AVG(gpa) FROM students")->fetchColumn();

// Recent students
$recentStudents = $pdo->query("SELECT * FROM students ORDER BY created_at DESC LIMIT 5")->fetchAll();

// Course distribution
$courseStats = $pdo->query("SELECT course, COUNT(*) as count FROM students GROUP BY course")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="dashboard.php" class="logo">📚 <span>SMS</span></a>
            <ul class="nav-menu">
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="students/list.php">Students</a></li>
                <li><a href="reports/">Reports</a></li>
                <li><a href="settings/profile.php">Profile</a></li>
            </ul>
            <div class="user-info">
                <span class="user-name">👋 <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👨‍🎓</div>
                <div class="stat-info">
                    <h3><?php echo $totalStudents; ?></h3>
                    <p>Total Students</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-info">
                    <h3><?php echo $activeStudents; ?></h3>
                    <p>Active Students</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📚</div>
                <div class="stat-info">
                    <h3><?php echo $totalCourses; ?></h3>
                    <p>Courses</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⭐</div>
                <div class="stat-info">
                    <h3><?php echo number_format($avgGPA, 2); ?></h3>
                    <p>Average GPA</p>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">📊 Course Distribution</h2>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr><th>Course</th><th>Number of Students</th><th>Percentage</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($courseStats as $stat): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($stat['course']); ?></td>
                                <td><?php echo $stat['count']; ?></td>
                                <td><?php echo round(($stat['count']/$totalStudents)*100, 1); ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">🆕 Recently Added Students</h2>
                <a href="students/add.php" class="btn btn-primary">+ Add Student</a>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr><th>Student ID</th><th>Name</th><th>Course</th><th>Semester</th><th>GPA</th><th>Status</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($recentStudents as $student): ?>
                            <tr>
                                <td><?php echo $student['student_id']; ?></td>
                                <td><?php echo htmlspecialchars($student['name']); ?></td>
                                <td><?php echo htmlspecialchars($student['course']); ?></td>
                                <td><?php echo $student['semester']; ?></td>
                                <td><?php echo $student['gpa']; ?></td>
                                <td><span class="badge badge-<?php echo strtolower($student['status']); ?>"><?php echo $student['status']; ?></span></td>
                                <td>
                                    <a href="students/view.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-primary">View</a>
                                    <a href="students/edit.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>