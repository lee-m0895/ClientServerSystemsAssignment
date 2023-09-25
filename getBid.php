<?php
require_once ("Models/LotsDataSet.php");
require_once ("Models/BidDataSet.php");
require_once ("Models/bidData.php");
require_once ("Models/AuctionsDataSet.php");
require_once ("Models/LotData.php");
require_once ("Models/UserDataSet.php");
require_once ("Models/UserData.php");

session_start();


//get winner for lot
if (isset($_GET["q"]))
{

        $q = $_GET["q"];
        $bidData = new BidDataSet();
        $data = $bidData->getWinner($q);
        echo json_encode($data);
}



//get auction end date
if(isset($_GET['auctionId']))
{
   $auctionId = $_GET['auctionId'];
   $auctionData = new AuctionsDataSet();
   $endDate = $auctionData->getEndDate($auctionId);
   echo json_encode($endDate);


}



if(isset($_GET['setWinner']))
{
    $bidData = new BidDataSet();
    $lotsid = $_GET['setWinner'];
    $data = $bidData->getWinner($lotsid);
    $userid = $data[1];
    echo json_encode($data);
}


//live search
if (isset($_GET["str"]) && isset($_GET['searchBy']) && isset($_GET['searchType']))
{
    //search by option
    $searchBy = $_GET['searchBy'];

    //auction or lots
    $searchType = $_GET['searchType'];

    //string to search
    $q = $_GET['str'];

    $array = array();
    //if the search type is for auctions
    if ($searchType == "Server-Side Programming - Auctions")
    {
        //search using a auctiondataset obj
        $auctionData = new AuctionsDataSet();
        switch ($searchBy)
        {
            case"SearchByName":
                $value = $auctionData->searchAuctions($q);
                break;
            case"SearchById":
                $q = (int)$q;
                $value = $auctionData->searchID($q);
                break;
            case "SearchByDescription":
                $value = $auctionData->searchDescription($q);
                break;
        }


        //format data for json
        foreach ($value as $a)
        {
            $myData = array(
                "title" => $a->getAuctionName(),
                "url" => $a->getAuctionImage(),
                "id" => $a->getAuctionid()
            );
            array_push($array, $myData);
        }
    }

    //search for lots
    else if ($searchType == "Server-Side Programming - Lots")
    {
        //search using lotsdataset obj
        $lotData = new LotsDataSet();
        switch ($searchBy)
        {
            case"SearchByName":
                $value = $lotData->limitedSearch($q);
                break;
            case"SearchById":
                $q = (int)$q;
                $value = $lotData->limitedSearchId($q);
                break;
            case "SearchByDescription":
                $value = $lotData->limitedSearchDesc($q);
                break;
        }


        //format data for json
        foreach ($value as $a)
        {
            $myData = array(
                "title" => $a->getItemtitle(),
                "url" => $a->getImageurl(),
                "id" => $a->getLotsid()
            );
            array_push($array, $myData);
        }
    }

    //check if there are any results
    if (json_encode($array) == "")
    {
        //print notification to system there are not results
        echo "no results";
    }
    else
    {
        //print results
        print_r(json_encode($array, JSON_UNESCAPED_UNICODE));
    }



}

//get user information
if (isset($_GET["userid"]))
{
    $userid = $_GET["userid"];
    $userData = new UserDataSet();
    $data = $userData->getUserById($userid);

    //format data for json
    $user = array
    (
      "name" => $data->getName(),
       "userid" => $data->getUserid(),
       "email" => $data->getEmail()

    );
    echo json_encode($user);
}


//check if user has made bid on lot
if (isset($_GET['checkForBid'])&&isset($_GET['lot']))
{
    $userid = $_GET['checkForBid'];
    $lot = $_GET['lot'];
    $bidData = new BidDataSet();
    $data = $bidData->checkIfBid($userid, $lot);

    //send data to system to signify whether user has bid on lot
    if ($data >0)
    {
        echo "Bid";
    }
    else{
        echo "NoBid";
    }

}