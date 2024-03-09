<?php
include 'header.php';
require_once 'classes/database.php';
require_once 'config.php';
require_once 'classes/usersDTO.php';

use usersDTO\usersDTO;
use db\DB_PDO;

$PDOConn = DB_PDO::getInstance($config);
$conn = $PDOConn->getConnection();
$usersDTO = new usersDTO($conn);

$users = $usersDTO->getAllUsers();
?>


<div class='container p-5'>
    <div class="text-center">
        <h1 class="display-4 text-info">Userbase</h1>
        <p class="lead">
            View users here
        </p>
        <hr class="my-4" />
        <p>
            <button class="btn btn-info" type='button'>Learn more</button>
        </p>
    </div>

    <div class="p-5 row row-cols-1 row-cols-md-3 row-cols-xl-4">
        <?php
        foreach ($users as $user) { ?>
            <div class="col mb-3">
                <div class="card">
                    <img src="<?= $user['image'] ?>" height="200px" alt="...">
                    <div class="card-body">
                        <h5 class="card-title text-center">
                            <?= $user['name'] ?>
                        </h5>
                        <p>
                            @<?= $user['username'] ?>
                        </p>
                        <p class="text-end">
                            <?= $user['role']?>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>


<?= include 'footer.php'; ?>