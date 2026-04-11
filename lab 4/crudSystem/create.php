<?php
require "db.php";

if(isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    $sql = "INSERT INTO students (name, email, course)
            VALUES (:name, :email, :course)";

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'course' => $course
        ]);

        header("Location: index.php");
        exit;

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>

<h2>Add Student</h2>

<form method="POST">
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Course: <input type="text" name="course"><br><br>
    <button type="submit" name="submit">Save</button>
</form>

<a href="index.php">Back</a>

</body>
</html>