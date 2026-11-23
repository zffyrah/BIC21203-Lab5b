<?php
include 'db.php';

$message = "";

if (isset($_POST['submit'])){

$matric = $_POST['matric'];
$name = $_POST['name'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];

$sql = "INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ssss", $matric, $name, $password, $role);

if (mysqli_stmt_execute($stmt)) {
    $message = "Resgistration successful!";
} else{
    $message = "Registration failed. Please check your matric number.";
}

mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Registration</title>
    </head>

    <body>

    <h2>Registration Form</h2>
        <form method="POST" action="">

        Matric: <input type="text" name="matric" maxlength="10" required>
        <br>

        Name: <input type="text" name="name" maxlength="100" required>
        <br>

        Password: <input type="password" name="password" required>
        <br>

        Role: <select name="role" required>
            <option value="">Please select</option>
            <option value="student">student</option>
            <option value="lecturer">lecturer</option>
        </select>
        <br>

        <input type="submit" name="submit" value="Submit">
        </form>

        <p><?php echo htmlspecialchars($message); ?></p>
    </body>
</html>