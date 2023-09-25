<?php
require('Models/UserDataSet.php');

$view = new stdClass();
$view->pageTitle = 'login';
$view->user = new UserDataSet();



if(isset($_POST['submitButton'])) {
    $nameEntered = $_POST['username'];
    $passwordEntered = $_POST['password'];
    $profile = $view->user->getUser($nameEntered, $passwordEntered);
    if ($profile != null)
    {
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['userid'] = $profile->getUserid();
        echo '<script src="js/redirect.js"></script>';
    }
    else
    {
        $view->error = "failed to log in, check your email or password";
    }
}





require_once('Views/login.phtml');



