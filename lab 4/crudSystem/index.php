<?php
require "db.php";

$search = $_GET['search'] ?? '';

if($search){
    $stmt = $pdo->prepare("SELECT * FROM students 
        WHERE name LIKE ? OR email LIKE ?
        ORDER BY id DESC");

    $stmt->execute(["%$search%","%$search%"]);
}else{
    $stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
}

$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student CRUD</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<h2>Student List</h2>
<a href="create.php">Add New Student</a>
<form method="GET" class="mb-3">
<input type="text" name="search" class="form-control"
placeholder="Search student...">
</form>

<table border="1">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Course</th>
    <th>Actions</th>
</tr>

<?php foreach($students as $student): ?>
<tr>
    <td><?= $student['id'] ?></td>
    <td><?= $student['name'] ?></td>
    <td><?= $student['email'] ?></td>
    <td><?= $student['course'] ?></td>
    <td>
        <a href="edit.php?id=<?= $student['id'] ?>">Edit</a>
        <a href="delete.php?id=<?= $student['id'] ?>">Delete</a>
    </td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>