<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Userbase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand  text-info">Userbase</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admin.php">Admin</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <?php
                    session_start();
                    if (!isset($_SESSION['loggedIn'])) { ?>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="registra.php">Register</a>
                            </li>
                        </ul>
                    <?php } else { ?>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item d-flex align-items-center">
                                Welcome, <span class="text-info mx-3">
                                    <?= $_SESSION['loggedIn']['name'] ?>
                                </span>
                            </li>
                            <li class="nav-item">
                               
                                <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><img src=<?= $_SESSION['loggedIn']['image']; ?> class="rounded-circle" width="40px"height="40px"></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="modifica.php?id=<?= $_SESSION['loggedIn']['id'] ?>">Edit profile</a></li>
                                        <li><a class="dropdown-item" href="gestione.php?action=logout">logout</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <?php
                    } ?>
                </span>
            </div>
        </div>
    </nav>
    <div class="min-vh-100">