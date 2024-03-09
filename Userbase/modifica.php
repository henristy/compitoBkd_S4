<?php
require_once 'classes/database.php';
require_once 'config.php';
require_once 'classes/usersDTO.php';

use usersDTO\usersDTO;
use db\DB_PDO;

$PDOConn = DB_PDO::getInstance($config);
$conn = $PDOConn->getConnection();
$usersDTO = new usersDTO($conn);

$user = $usersDTO->getUserByID($_REQUEST['id']);


include 'header.php';
?>

<h1 class="my-5 text-center">Edit User Profile</h1>
<div class="container px-5 w-50 mx-auto mb-5">
    <form class="row g-3 w-75 mx-auto" validate action="gestione.php?action=modifyUser&id=<?= $user['id'] ?>"
        method="POST" enctype="multipart/form-data">
        <div>
            <label for="validationCustomUsername" class="form-label">Username</label>
            <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input value="<?= $user['username'] ?>" type="text" class="form-control" id="validationCustomUsername"
                    name="username" aria-describedby="inputGroupPrepend" required>
                <div class="invalid-feedback">
                    Please choose a username.
                </div>
            </div>
        </div>
        <div>
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" value="<?= $user['password'] ?>" class="form-control" id="validationCustom11"
                aria-describedby="passwordHelp" name="password" required>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>
        <div class="mb-5">
            <?php
            if ($_SESSION['loggedIn']['role'] == 'admin') { ?>
                <label for="validationCustom05" class="form-label">Role</label>
                <select class="form-select" id="validationCustom05" name="role" required>
                    <option selected value="<?= $user['role'] ?>">
                        <?= $user ? 'Administrator' : 'Choose...' ?>
                    </option>
                    <option value="admin">Administrator</option>
                    <option value="utente">User</option>
                </select>
            <?php } else { ?>
                <input type="hidden" class="form-control" id="validationCustom05" name="role" value="utente" required>
            <?php } ?>
        </div>
        <div>
            <label for="validationCustom01" class="form-label">Full name</label>
            <input type="text" value="<?= $user['name'] ?>" class="form-control" id="validationCustom01"
                name="name" required>
        </div>

        <div>
            <label for="validationCustom03" class="form-label">City</label>
            <input type="text" value="<?= $user['city'] ?>" class="form-control" id="validationCustom03" name="city"
                required>
            <div class="invalid-feedback">
                Please provide a valid city.
            </div>
        </div>
        <div>
            <label for="validationCustom04" class="form-label">State</label>
            <select class="form-select" id="validationCustom04" name="state" required>
                <option selected value="<?= $user['state'] ?>">
                    <?= $user ? $user['state'] : 'Choose...' ?>
                </option>
                <option value="Abruzzo">Abruzzo</option>
                <option value="Basilicata">Basilicata</option>
                <option value="Calabria">Calabria</option>
                <option value="Campania">Campania</option>
                <option value="Emilia-Romagna">Emilia-Romagna</option>
                <option value="Friuli-Venezia Giulia">Friuli-Venezia Giulia</option>
                <option value="Lazio">Lazio</option>
                <option value="Liguria">Liguria</option>
                <option value="Lombardy">Lombardy</option>
                <option value="Marche">Marche</option>
                <option value="Molise">Molise</option>
                <option value="Piemonte">Piemonte</option>
                <option value="Puglia">Puglia</option>
                <option value="Sardegna">Sardegna</option>
                <option value="Sicilia">Sicilia</option>
                <option value="Toscana">Toscana</option>
                <option value="Trentino-Alto Adige">Trentino-Alto Adige</option>
                <option value="Umbria">Umbria</option>
                <option value="Valle d'Aosta">Valle d'Aosta</option>
                <option value="Veneto">Veneto</option>
            </select>
            <div class="invalid-feedback">
                Please select a valid state.
            </div>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload an avatar image</label>
            <input type="file" class="form-control" id="image" name="image">
            <input type="hidden" name="previous_image" value="<?= $user['image'] ?>">
        </div>

        <div>
            <button class="btn btn-primary" type="submit">Update profile</button>
        </div>
    </form>
</div>
</div>

<?php
if (isset($_SESSION["errMsg"]) && $_SESSION["errMsg"] !== "") {
    echo "<div class='alert alert-danger' role='alert'>";
    echo $_SESSION['errMsg'];
    echo "</div>";
    $_SESSION['errMsg'] = '';

}

include 'footer.php';
?>