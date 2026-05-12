<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
requireLogin();

$search = isset($_GET['search']) ? $_GET['search'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

$sql = "SELECT * FROM students WHERE 1=1";
$params = [];

if ($search) {
    $sql .= " AND (name LIKE ? OR student_id LIKE ? OR email LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($status) {
    $sql .= " AND status = ?";
    $params[] = $status;
}

$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students List - Student Management System</title>
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
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">👨‍🎓 All Students</h2>
                <a href="add.php" class="btn btn-primary">+ Add New Student</a>
            </div>
            
            <form method="GET" action="" class="search-bar">
                <input type="text" name="search" placeholder="Search by name, ID, or email..." value="<?php echo htmlspecialchars($search); ?>">
                <select name="status">
                    <option value="">All Status</option>
                    <option value="Active" <?php echo $status == 'Active' ? 'selected' : ''; ?>>Active</option>
                    <option value="Inactive" <?php echo $status == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                    <option value="Graduated" <?php echo $status == 'Graduated' ? 'selected' : ''; ?>>Graduated</option>
                </select>
                <button type="submit" class="btn btn-primary">Search</button>
                <?php if ($search || $status): ?>
                    <a href="list.php" class="btn btn-warning">Clear</a>
                <?php endif; ?>
            </form>
            
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Semester</th>
                            <th>GPA</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($students) > 0): ?>
                            <?php foreach($students as $student): ?>
                                <tr>
                                    <td><?php echo $student['student_id']; ?></td>
                                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                                    <td><?php echo htmlspecialchars($student['course']); ?></td>
                                    <td><?php echo $student['semester']; ?></td>
                                    <td><?php echo $student['gpa']; ?></td>
                                    <td><span class="badge badge-<?php echo strtolower($student['status']); ?>"><?php echo $student['status']; ?></span></td>
                                    <td>
                                        <a href="view.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-primary">View</a>
                                        <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="delete.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this student?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center;">No students found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>