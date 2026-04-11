<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (file_exists("user.txt")) {

        $users = file("user.txt", FILE_IGNORE_NEW_LINES);

        foreach ($users as $user) {

            list($stored_user, $stored_hash) = explode(",", $user);

            if ($username === $stored_user && password_verify($password, $stored_hash)) {

                $_SESSION['username'] = $username;
                header("Location: dashboard.php");
                exit();
            }
        }
    }

    $error = "Invalid username or password!";
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex justify-content-center align-items-center vh-100">

<div class="card shadow-lg p-4" style="width: 400px;">
    <h3 class="text-center mb-3">Login</h3>

    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="POST">
        <div class="mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button class="btn btn-dark w-100">Login</button>
    </form>

    <div class="text-center mt-3">
        <a href="signup.php">Create account</a>
    </div>
</div>

</body>
</html>

