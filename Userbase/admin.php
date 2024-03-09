<?php
include 'header.php';
if (!isset($_SESSION['loggedIn']) || ($_SESSION['loggedIn']['role'] !== 'admin')) {
    $_SESSION['errMsg'] = 'You are not authorized to access this page, please login as an admin';
    session_write_close();
    header('Location: login.php');
}

require_once 'classes/database.php';
require_once 'config.php';
require_once 'classes/usersDTO.php';

use usersDTO\usersDTO;
use db\DB_PDO;

$PDOConn = DB_PDO::getInstance($config);
$conn = $PDOConn->getConnection();
$usersDTO = new usersDTO($conn);

$users = $usersDTO->getAllUsers();
$i = 0;
?>


<div class="mt-5 pt-5">
    <h1 class='text-center text-info'>All users are shown here where you can manage them</h1>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col-1">#</th>
                    <th scope="col-2">Image</th>
                    <th scope="col-4">Username</th>
                    <th scope="col-2">Name</th>
                    <th scope="col-1">City</th>
                    <th scope="col-1">State</th>
                    <th scope="col-1">Role</th>
                    <th scope="col-1"><a href="registra.php" class='btn btn-success'>Add User</a></th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php foreach ($users as $user) { ?>
                    <tr>
                        <th scope="row">
                            <?= $i += 1 ?>
                        </th>
                        <td>
                            <img src=<?= $user["image"]; ?> alt="avatar Image" class="rounded-circle" width="50" height="50">
                        </td>
                        <td>
                            <?= $user["username"] ?>
                        </td>
                        <td>
                            <?= $user['name'] ?>
                        </td>
                        <td>
                            <?= $user['city'] ?>
                        </td>
                        <td>
                            <?= $user['state'] ?>
                        </td>
                        <td>
                            <?= $user['role'] ?>
                        </td>
                        <td class="fs-3">
                            <a href="modifica.php?id=<?= $user['id'] ?>"><i
                                    class="bi bi-pen me-2 btn btn-outline-light"></i></a>
                            <a href="gestione.php?action=deleteUser&id=<?= $user['id'] ?>"><i
                                    class="bi bi-trash btn btn-outline-danger"></i></a>
                        </td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
        <?php if (isset($_SESSION["errMsg"]) && $_SESSION["errMsg"] != "") {
            echo "<div class='alert alert-danger' role='alert'>";
            echo $_SESSION['errMsg'];
            echo "</div>";
            $_SESSION['errMsg'] = '';
        } ?>
    </div>
</div>

<?= include 'footer.php' ?>