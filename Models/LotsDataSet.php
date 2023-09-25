<?php
require_once('DbConnection.php');
require_once('LotData.php');

class LotsDataSet
{
    protected $_dbHandle, $_dbInstance;

    function __construct()
    {
        $this->_dbInstance = new DbConnection();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }


    //get all lots from table
     function  getAllLots()
     {

         $sqlQuery =
             'select * FROM (SELECT Lots.*, max(amountBidded)
        FROM bids
        right JOIN Lots on bids.lotsid = Lots.lotsid
        group by Lots.lotsid
        )AS T';
         $statment = $this->_dbHandle->prepare($sqlQuery);
         $statment->execute();
         $data = [];
         while($row = $statment->fetch())
         {

             $data[] = new LotData($row);
         }
         return $data;
     }


     //get all lots with the corresponding auction id
    function getLotsByAuctionid($auctionsid)
    {

        $sqlQuery = "select * FROM (SELECT Lots.*, max(amountBidded)
        FROM bids
        right JOIN Lots on bids.lotsid = Lots.lotsid
        group by Lots.lotsid
        )AS T
        where T.auctionsid =". $auctionsid;
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->execute();
        $data = [];
        while($row = $statment->fetch())
        {

            $data[] = new LotData($row);
        }
        return $data;
    }


    //get the values of a single lot with the specified id
    function getLotById($lotsid)
    {
        $sqlQuery =
            'select * FROM (SELECT Lots.*, max(amountBidded)
        FROM bids
        right JOIN Lots on bids.lotsid = Lots.lotsid
        group by Lots.lotsid
        )AS T
        where T.lotsid =  '.$lotsid;
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->execute();
        $row = $statment->fetch();
        $row = new LotData($row);
        return $row;
    }






    //search functions

    //search comparing the search value to the title of the lot
    function searchLots($searchValue)
    {

        $sqlQuery =
            "select * FROM (SELECT Lots.*, max(amountBidded)
        FROM bids
        right JOIN Lots on bids.lotsid = Lots.lotsid
        group by Lots.lotsid
        )AS T
        where T.itemtitle LIKE ?" ;
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $searchValue = "%".$searchValue."%";
        $statment->bindParam(1, $searchValue);
        $statment->execute();
        $data = array();
        while($row = $statment->fetch())
        {
            $data[] = new LotData($row);
        }
        return $data;
    }


    //search compaing the search value to the id of the lot
    function searchLotsById($searchValue)
    {

        $sqlQuery =
            "select * FROM (SELECT Lots.*, max(amountBidded)
        FROM bids
        right JOIN Lots on bids.lotsid = Lots.lotsid
        group by Lots.lotsid
        )AS T
        where T.lotsid LIKE ?" ;
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $searchValue = $searchValue."%";
        $statment->bindParam(1, $searchValue);
        $statment->execute();
        $data = [];
        while($row = $statment->fetch())
        {
            $data[] = new LotData($row);
        }
        return $data;
    }

    //search compaing the search value to the id of the lot
    function limitedSearchId($searchValue)
    {

        $sqlQuery =
            "select * FROM (SELECT Lots.*, max(amountBidded)
        FROM bids
        right JOIN Lots on bids.lotsid = Lots.lotsid
        group by Lots.lotsid
        )AS T
        where T.lotsid LIKE ? LIMIT 10" ;
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $searchValue = $searchValue."%";
        $statment->bindParam(1, $searchValue);
        $statment->execute();
        $data = [];
        while($row = $statment->fetch())
        {
            $data[] = new LotData($row);
        }
        return $data;
    }


    function limitedSearchDesc($searchValue)
    {
        $sqlQuery =
            "select * FROM (SELECT Lots.*, max(amountBidded)
        FROM bids
        right JOIN Lots on bids.lotsid = Lots.lotsid
        group by Lots.lotsid
        )AS T
        where T.itemdescription LIKE ? LIMIT 10" ;
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $searchValue = "%". $searchValue."%";
        $statment->bindParam(1, $searchValue);
        $statment->execute();
        $data = [];
        while($row = $statment->fetch())
        {
            $data[] = new LotData($row);
        }
        return $data;
    }




    //search compaing the search value to the description of the lot
    function searchLotsByDescription($searchValue)
    {
        $sqlQuery =
            "select * FROM (SELECT Lots.*, max(amountBidded)
        FROM bids
        right JOIN Lots on bids.lotsid = Lots.lotsid
        group by Lots.lotsid
        )AS T
        where T.itemdescription LIKE ?" ;
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $searchValue = "%".$searchValue."%";
        $statment->bindParam(1, $searchValue);
        $statment->execute();
        $data = [];
        while($row = $statment->fetch())
        {
            $data[] = new LotData($row);
        }
        return $data;
    }



    function limitedSearch($searchValue)
    {
        $sqlQuery =
            "select * FROM (SELECT Lots.*, max(amountBidded)
        FROM bids
        right JOIN Lots on bids.lotsid = Lots.lotsid
        group by Lots.lotsid
        )AS T
        where T.itemtitle LIKE ?
        LIMIT 10" ;
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $searchValue = $searchValue."%";
        $statment->bindParam(1, $searchValue);
        $statment->execute();
        $data = array();
        while($row = $statment->fetch())
        {
            $data[] = new LotData($row);
        }
        return $data;
    }



    function getauctionId($lotsid)
    {
        $sqlQuery = 'select auctionsid from Lots where lotsid = '. $lotsid ;
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->execute();
        $data = $statment->fetch();
        return $data;

    }

    function setWinner($userid, $lotsid)
    {
        $sqlQuery = 'UPDATE Lots SET winner = ? WHERE lotsid = ?' ;
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->bindParam(1, $userid);
        $statment->bindParam(1, $lotsid);
        $statment->execute();
    }


    //search comparing the search value to the title of the lot
   /* function searchLots($searchValue)
    {

        $sqlQuery =
            "select * FROM (SELECT Lots.*, max(amountBidded)
        FROM bids
        right JOIN Lots on bids.lotsid = Lots.lotsid
        group by Lots.lotsid
        )AS T
        where T.itemtitle LIKE ?" ;
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $searchValue = "%".$searchValue."%";
        $statment->bindParam(1, $searchValue);
        $statment->execute();
        $data = array();
        while($row = $statment->fetch())
        {
            array_push($data, new LotData($row)) ;
        }
        return $data;
    }*/




}