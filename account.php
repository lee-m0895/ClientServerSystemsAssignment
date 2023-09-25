<?php
require('Models/UserDataSet.php');
require ('Models/BidDataSet.php');
require ('Models/AuctionsDataSet.php');

$view = new stdClass();
session_start();
$view->pageTitle = 'Account';
$view->user = new UserDataSet();
$view->bids = new BidDataSet();
$view->auctions = new AuctionsDataSet();

$view->user = $view->user->getUserById($_SESSION['userid']);
$view->name = $view->user->getName();
$view->email = $view->user->getEmail();
$view->userid = $view->user->getUserid();
$view->bids = $view->bids->bidsByUser($view->userid);
$view->auctions = $view->auctions-> getAuctionsByUser($view->userid);



if(isset($_POST['logoutButton'])) {

    session_destroy();
    echo '<script type="text/javascript">
        window.location.replace("login.php");
        </script>>';
}



require_once('Views/account.phtml');