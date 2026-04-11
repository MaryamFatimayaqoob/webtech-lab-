<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$users = file_exists("user.txt") ? file("user.txt") : [];
$totalUsers = count($users);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<nav class="navbar navbar-dark bg-black shadow">
  <div class="container-fluid">
    <span class="navbar-brand">User Data System</span>
    <div>
      <span class="me-3">Welcome, <?php echo $_SESSION['username']; ?></span>
      <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <div class="row g-4">

    <div class="col-md-4">
      <div class="card bg-primary text-white shadow-lg p-4">
        <h4>Total Users</h4>
        <h2><?php echo $totalUsers; ?></h2>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card bg-success text-white shadow-lg p-4">
        <h4>Status</h4>
        <h2>Active</h2>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card bg-warning text-dark shadow-lg p-4">
        <h4>System</h4>
        <h2>Operational</h2>
      </div>
    </div>

  </div>
</div>

</body>
</html>
