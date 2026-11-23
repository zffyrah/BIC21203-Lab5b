<?php
session_start();
include 'db.php';

$error = "";

if (isset($_POST['login'])) {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE matric = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $matric);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

        $_SESSION['matric'] = $user['matric'];
        header ("Location: display.php");
        exit();

        } else {
            $error = "Invalid username or password";

        }

    } else {
        $error = "Invalid username or password";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
    </head>
    <body>

    <form method="POST" action="">
        Matric: <input type="text" name="matric" required>
        <br>

        Password: <input type="password" name="password" required>
        <br>

        <input type="submit" name="login" value="login">
        <br><br><br>

        <a href="register.php">Register</a> here if you have not.
    </form>

    <p><?php if($error != "") { ?>
        <p><?php echo htmlspecialchars($error); ?>,
        try <a href="login.php">login</a> again.
    </p>
    <?php } ?>

    </body>
</html>