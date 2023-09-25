<?php
require_once('DbConnection.php');
require_once('LotData.php');
require_once ('bidData.php');
class BidDataSet
{
    //set up connection variables
    protected  $_dbInstance, $_dbHandle;
    function __construct()
    {
        //create connection
        $this->_dbInstance = new DbConnection();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }


    //check if bid entered is ok and if so make that bid
    function checkIfBidOk($lotsid, $bid, $usersid)
    {
        //check for highest bid of lit
        $sqlQuery = 'SELECT max(amountBidded) FROM bids
WHERE lotsid =' . $lotsid;
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->execute();
        $result = $statment->fetch();
        $result = $result['max(amountBidded)'];

        //compare highet bid to entered bid
        if ($result < $bid or is_null($result) and $bid > 0)
        {
            //insert bid into table if bid is larger then current largest
            $sqlQuery = 'INSERT INTO bids(usersid, lotsid, amountBidded ) VALUES(?,?,?)';
            $statment = $this->_dbHandle->prepare($sqlQuery);
            $statment->bindParam(1, $usersid);
            $statment->bindParam(2, $lotsid);
            $statment->bindParam(3, $bid);
            $statment->execute();
            //return a notification that the bid was made
            return "success";
        }
        else
        {
            //return a notification that the bid failed
            return "Fail";
       }
    }





    //get all bids of a user
    function bidsByUser($userid)
    {
        $sqlQuery ='SELECT * FROM bids
                     right JOIN Lots on bids.lotsid = Lots.lotsid
                    WHERE bids.usersid ='. $userid;

        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->execute();
        $data = [];
        while($row = $statment->fetch())
        {

            $data[] = new LotData($row);
        }
        return $data;

    }

    function getAllBidsLotId($lotid)
    {
        $sqlQuery ='SELECT * FROM bids
                    WHERE bids.lotsid ='. $lotid;
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->execute();
        $data = [];
        while($row = $statment->fetch())
        {
            $data[] = new bidData($row);
        }
        return $data;
    }

    //get the highest bid for a lot
    function getBidLotId($lotid)
    {
        $sqlQuery ='SELECT MAX(amountBidded) FROM bids
                    WHERE bids.lotsid ='. $lotid;
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->execute();
        $data = $statment->fetch();
        return $data;
    }

    //check if current logged in user has the highest bid
    function getWinner($lotid)
    {
        $sqlQuery ='SELECT * from bids WHERE amountBidded = (select MAX(amountBidded) from bids where lotsid ='. $lotid.');';
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->execute();
        $data = $statment->fetch();
        return $data;

    }

    function  checkIfBid($userid, $lotid)
    {
        $sqlQuery = 'SELECT COUNT(usersid) FROM bids WHERE usersid = ? and lotsid = ?';
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->bindParam(1, $userid);
        $statment->bindParam(2,$lotid);
        $statment->execute();
        $data = $statment->fetch();
        return $data[0];
    }


    function getLotsidByUsers($userid)
    {
        $sqlQuery = 'SELECT * FROM bids 
        WHERE usersid = ? and notification = 0';
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->bindParam(1, $userid);
        $statment->execute();
        $data = [];
        while($row = $statment->fetch())
        {
            $data[] = new bidData($row);
        }
        return $data;

    }

    function getWinnerObj($lotid)
    {
        $sqlQuery ='SELECT * from bids WHERE amountBidded = (select MAX(amountBidded) from bids where lotsid ='. $lotid.');';
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->execute();
        $data = [];
        while($row = $statment->fetch())
        {
            $data = new bidData($row);
        }
        return $data;

    }

    function setNotification($bidid)
    {
        $sqlQuery = 'UPDATE bids SET notification = 1 WHERE bidid = ?';
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->bindParam(1, $bidid);
        $statment->execute();
    }


}