<?php
require_once ("Models/LotsDataSet.php");
require_once ("Models/BidDataSet.php");
require_once ("Models/bidData.php");
require_once ("Models/AuctionsDataSet.php");
require_once ("Models/LotData.php");
require_once ("Models/UserDataSet.php");
require_once ("Models/UserData.php");

session_start();


//get bids that have not been notified to the user if the user is logged in
if (isset($_GET['notifications']) && isset($_SESSION['userid']))
{
    //get user id from session
    $userid = $_SESSION['userid'];

    //get the bids that havent been used to notify the user
    $bidData = new BidDataSet();
    $data = $bidData->getLotsidByUsers($userid);

    //loop through each bid and see how to notify the user
    $array = array();
    foreach ($data as $a)
    {



        $outbid = $bidData->getWinnerObj($a->getLotsid());
        // if the user has been outbid create this notification
        if ($outbid->getAmountBidded() > $a->getAmountBidded() && $outbid->getUsersid() != $a->getUsersid())
        {

            $msg = array(
                "message" => "you have been outbid on lot:". $a->getLotsid(),
                "lotid" => $a->getLotsid(),
                "bidid" => $a->getBidid()
            );

            array_push($array, $msg);
        }

        //otherwise creat this notification
        else
        {
            $msg = array(
                "message" => "you are winning lot:". $a->getLotsid(),
                "lotid" => $a->getLotsid(),
                "bidid" => $a->getBidid()
            );

            array_push($array, $msg);
        }



    }
    //send results to js
    print_r(json_encode($array)) ;

}



//get the total number of notifications to be made
if (isset($_GET['count']) && isset($_SESSION['userid']))
{
    $userid = $_SESSION['userid'];
    $bidData = new BidDataSet();
    $data = $bidData->getLotsidByUsers($userid);
    $array = array();
    $total = 0;
    foreach ($data as $a) {
        $total += 1;
    }
    echo $total;
}


//clear old notifications that have been seen by the user.
if (isset($_GET['wipe']) and isset($_SESSION['userid']))
{
    $userid = $_SESSION['userid'];
    $bidData = new BidDataSet();
    $data = $bidData->getLotsidByUsers($userid);
    $array = array();
    foreach ($data as $a) {
        $bidData->setNotification($a->getBidid());
    }
    echo "test";


}