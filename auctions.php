<?php
require('Models/LotsDataSet.php');
require ('Models/AuctionsDataSet.php');

session_start();
$view = new stdClass();
$view->pageTitle = 'Auctions';
$view->auctions = new AuctionsDataSet();

if(isset($_GET['select']))
{
    $auctionId = $_GET['idHolder'];
    $_SESSION['id'] = $auctionId;
    $view->singular = true;
    $view->lots = new LotsDataSet();
    $view->lots = $view->lots->getLotsByAuctionid($auctionId);
}



if (isset($_GET['search']))
{
        $searchValue = $_GET['searchValue'];
        $selection = $_GET['searchBy'];
        switch ($selection)
        {
            case "SearchByName";
                $view->auctions = $view->auctions->searchAuctions($searchValue);
                break;

            case "SearchById";
                $view->auctions = $view->auctions->searchDescription($searchValue);
                break;

            case "SearchByDescription";
                $view->lots = $view->auctions->searchID($searchValue);
                break;
        }
        $view->search = true;
}



if (!(isset($view->search)))
{
    $view->auctions = $view->auctions->getAllAuctions();
}




require_once('Views/auctions.phtml');
?>