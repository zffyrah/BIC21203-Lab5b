<?php
session_start();

if(!isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
if(!isset($_GET['matric']) && !isset($_POST['update'])) {
    header("Location: display.php");
    exit();
}

if(isset($_POST['update'])) {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "sss", $name, $role, $matric);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: display.php");
        exit();
    } else {
        echo "Error updating user: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {

$matric = $_GET['matric'];

$sql = "SELECT * FROM users WHERE matric = ?";
$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "s", $matric);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if(!$user) {
    die("User not found.");
}
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Update User</title>
    </head>
    <body>
        <h2>Update User</h2>
        <form method="POST" action="">

        Matric: <input type="text" name="matric" value="<?php echo htmlspecialchars($user['matric'] ?? $matric); ?>"readonly>
        <br>

        Name: <input type="text" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>"required>
        <br>

        Access Level: <input type="text" name="role" value="<?php echo htmlspecialchars($user['role'] ?? ''); ?>"required>
        <br>
        
        <input type="submit" name="update" value="Update">

        <a href="display.php">Cancel</a>
        
        </form>
    </body>
</html>