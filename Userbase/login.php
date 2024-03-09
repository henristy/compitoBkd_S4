<?php include 'header.php'?>

<div class="mt-5 pt-2 container">
    <h1 class="mb-5 text-center py-5 text-info">Login to your account</h1>
    <div class="container w-25 mx-auto mb-5">
        <form class="row g-3 pb-5" action="gestione.php?action=login" method="POST">
            <div class="col-12">
                <label for="validationCustom01" class="form-label">Username</label>
                <input type="text" class="form-control" id="validationCustom01" value="" name="username" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-12">
                <label for="validationCustom02" class="form-label">Password</label>
                <input type="password" class="form-control" id="validationCustom02" value="" name="password" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-12 d-flex justify-content-between align-items-center ">
                <button class="btn btn-primary" type="submit">Log In</button>
                <span class="text-center">Or</span>
                <a class="btn btn-primary" href="registra.php">Sign Up</a>
            </div>
        </form>
        <?php
    if (isset($_SESSION["errMsg"]) && $_SESSION["errMsg"] != "") {
        echo "<div class='alert alert-danger' role='alert'>";
        echo $_SESSION['errMsg'];
        echo "</div>";
        $_SESSION['errMsg'] = '';
    }
?>
    </div>
</div>


    <?php include 'footer.php';?>