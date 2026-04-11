<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = $username . "," . $hashedPassword . PHP_EOL;
        file_put_contents("user.txt", $data, FILE_APPEND | LOCK_EX);

        header("Location: login.php");
        exit();
    } else {
        $error = "All fields are required!";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex justify-content-center align-items-center vh-100">

<div class="card shadow-lg p-4" style="width: 400px;">
    <h3 class="text-center mb-3">Create Account</h3>

    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="POST">
        <div class="mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button class="btn btn-dark w-100">Register</button>
    </form>

    <div class="text-center mt-3">
        <a href="login.php">Already have an account?</a>
    </div>
</div>

</body>
</html>
