<?php
session_start();

if (!isset($_SESSION['matric'])){
    header("Location: login.php");
    exit();
}

include 'db.php';

$sql = "SELECT matric, name, role FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Display Users</title>
    </head>
    <body>
        <h2>User List</h2>

        <table border="1" cellpadding="5">
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Level</th>
                <th colspan="2">Action</th>
            </tr>

            <?php 
            while ($row = mysqli_fetch_assoc($result)) {
            ?>

                <tr>
                    <td><?php echo htmlspecialchars($row['matric']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['role']); ?></td>
                    <td>
                        <a href="update.php?matric=<?php echo urlencode($row['matric']); ?>">Update</a>
                    </td>
                    <td>
                        <a href="delete.php?matric=<?php echo urlencode($row['matric']); ?>" onclick="return confirm('Are you sure you want to delete this  user?');">Delete</a>
                    </td>
                </tr>

            <?php
            }
            ?>
        </table>
    </body>
</html>