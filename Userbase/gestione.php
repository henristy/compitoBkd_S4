<?php

require_once 'classes/database.php';
require_once 'config.php';
require_once 'classes/usersDTO.php';
session_start();

use usersDTO\usersDTO;
use db\DB_PDO;

$PDOConn = DB_PDO::getInstance($config);
$conn = $PDOConn->getConnection();
$usersDTO = new usersDTO($conn);

$usersDTO->createTable();
function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}



$action = isset($_REQUEST['action']) ? sanitizeInput($_REQUEST['action']) : '';
$username = isset($_REQUEST['username']) ? sanitizeInput($_REQUEST['username']) : '';
$password = isset($_REQUEST['password']) ? sanitizeInput($_REQUEST['password']) : '';
$fullname = isset($_REQUEST['name']) ? sanitizeInput($_REQUEST['name']) : '';
$city = isset($_REQUEST['city']) ? sanitizeInput($_REQUEST['city']) : '';
$state = isset($_REQUEST['state']) ? sanitizeInput($_REQUEST['state']) : '';
$role = isset($_REQUEST['role']) ? sanitizeInput($_REQUEST['role']) : '';
$id = isset($_REQUEST['id']) ? sanitizeInput($_REQUEST['id']) : '';

if ($action === 'login') {
    if (empty($username) || empty($password)) {
        $_SESSION['errMsg'] = 'Username and password are required';
        header('Location: login.php');
        exit;
    } else {
        $res = $usersDTO->login($username, $password);
        if ($res) {
            $_SESSION['loggedIn'] = $res;
            $_SESSION['loggedIn']['role'] === 'admin' ? header('Location: admin.php') : header('Location: index.php');
            exit;
        } else {
            
            $_SESSION['errMsg'] = 'Username or password is incorrect';
            header('Location: login.php');
            exit;
        }
    }
} elseif ($action === 'logout') {
    session_unset();
    header('Location: index.php');
    exit;
} elseif ($action === 'addUser' || $action === 'modifyUser') {
    if (!empty($username) && !empty($password) && !empty($fullname) && !empty($city) && !empty($state) && !empty($role)) {
        $user = [
            'username' => $username,
            'password' => $password,
            'name' => $fullname,
            'city' => $city,
            'state' => $state,
            'role' => $role
        ];
        $target_dir = "uploads/";
        $image = $target_dir . 'pfp.png';
        if (!empty($_FILES['image']['name'])) {
            
            $image = $target_dir . basename($_FILES['image']['name']);
            $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES['image']['tmp_name']);
            if ($check === false) {
                $_SESSION['errMsg'] = 'File is not an image';
                $action === 'modifyUser' ? header('Location: modifica.php') : header('Location: registra.php');
                exit;
            }

            if ($_FILES['image']['size'] > 4000000) {
                $_SESSION['errMsg'] = 'Image is too big, max 4MB';
                $action === 'modifyUser' ? header('Location: modifica.php') : header('Location: registra.php');
                exit;
            }

            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $_SESSION['errMsg'] = 'Invalid image type, only JPG, JPEG, PNG files are allowed';
                $action === 'modifyUser' ? header('Location: modifica.php') : header('Location: registra.php');
                exit;
            }

    
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
                $_SESSION['errMsg'] = 'Failed to upload image, try again';
                $action === 'modifyUser' ? header('Location: modifica.php') : header('Location: registra.php');
                exit;
            }
        } else {
            $image = isset($_REQUEST['previous_image']) ? sanitizeInput($_REQUEST['previous_image']) : $target_dir .'pfp.png';
        }
        $user['image'] = $image;
        if ($action === 'modifyUser') {
            $user['id'] = $id;
            $usersDTO->modifyUser($user);
        } else {
            $usersDTO->addUser($user);
        }
        $_SESSION['loggedIn']['id'] == $id || !isset($_SESSION['loggedIn']) ? $_SESSION['loggedIn'] = $usersDTO->login($username, $password): '';
        $_SESSION['loggedIn']['role'] === 'admin' ? header('Location: admin.php') : header('Location: index.php');
        exit;
    } else {
        $_SESSION['errMsg'] = 'Missing required fields';
        $action === 'modifyUser' ? header('Location: modifica.php') : header('Location: registra.php');
        exit;
    }
} elseif ($action === 'deleteUser') {
    if (!empty($id)) {
        $usersDTO->deleteUser($id);
        header('Location: admin.php');
        exit;
    } else {
        $_SESSION['errMsg'] = 'Could not delete user. Try again.';
        header('Location: admin.php');
        exit;
    }
}

?>
