<?php
require('Models/LotsDataSet.php');
require ('Models/BidDataSet.php');
session_start();
$view = new stdClass();
$view->pageTitle = 'Lots';
$view->lots = new LotsDataSet();
$view->userid = "";

if (isset($_SESSION['userid']))
{
    $view->userid = $_SESSION['userid'];
}
else
{
    $view->userid = "";
}




//select a lot to view
if(isset($_GET['select']))
{
    $lotsId = $_GET['idHolder'];
    //set up $view for this lot
    $view->lots = $view->lots->getLotById($lotsId);
    $view->title = $view->lots->getItemtitle();
    $view->image = $view->lots->getImageurl();
    $view->maxBid = $view->lots->getCurrentMaxBid();
    $view->description = $view->lots->getItemdescription();
    $view->id = $view->lots->getLotsid();
    $view->lotEndDate = $view->lots->getDate();
    $view->auctionId = $view->lots->getAuctionid();
    $view->singular = true;
    //get whether loggged in user is winning
    if(isset($_SESSION['loggedin']))
    {
        $view->winner = new BidDataSet();
        $view->winner = $view->winner->getWinner($_SESSION['userid'], $view->id );
    }

}



//search lots
if (isset($_GET['search'])) {
    $searchValue = $_GET['searchValue'];
    $selection = $_GET['searchBy'];

    //run correct query  based on search option
    switch ($selection) {
        case "SearchByName";
            $view->lots = $view->lots->searchLots($searchValue);
            break;

        case "SearchById";
            $view->lots = $view->lots->searchLotsById($searchValue);
            break;

        case "SearchByDescription";
            $view->lots = $view->lots->searchLotsByDescription($searchValue);
            break;
    }
    $view->search = true;
}




if (isset($_POST['submitBid']))
{
        $amount = $_POST['bid'];
        $bid = new BidDataSet();
        $view->bidMade = $bid->checkIfBidOk($view->id, $amount, $view->userid);
}


if (isset($_SESSION['loggedin'] ))
{
    $userid = $_SESSION['userid'];
}

if (!(isset($view->search)))
{
   $allLots = new LotsDataSet();
   $allLots = $allLots->getAllLots();
}






require_once ('Views/lots.phtml');