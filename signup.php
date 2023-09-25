<?php
require ('Models/UserDataSet.php');
$view = new stdClass();
session_start();
$view->pageTitle = 'Homepage';


if(isset($_POST['submitButton'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $reEnterPassword = $_POST['re-enter-password'];
        $fullname = $_POST['fullname'];
    $user = new UserDataSet();
    if(isset($username, $password, $reEnterPassword, $fullname))
    {
        if ($password == $reEnterPassword)
        {
            if(filter_var($username, FILTER_VALIDATE_EMAIL))
            {
                $password = password_hash($password, PASSWORD_BCRYPT);
                $user = $user->adduser($username, $password, $fullname);
                if ($user == true)
                {
                    echo '<script >window.location.replace("login.php");</script>';
                }

            }

        }

    }


}

require_once('Views/signup.phtml');