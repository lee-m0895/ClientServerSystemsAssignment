<?php
require_once('DbConnection.php');
require_once ('AuctionData.php');

class AuctionsDataSet
{
    //create protected fields for conection
    protected $_dbHandle, $_dbInstance;


    function __construct()
    {
        //create connection
        $this->_dbInstance = new DbConnection();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }

    //get all auctions  from auctions
    function getAllAuctions()
    {

        $sqlQuery = 'SELECT * FROM Auctions';
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->execute();
        $data = [];

        //split auctions into array
        while ($row = $statment->fetch()) {
            //create auction data object for ease of use
            $data[] = new AuctionData($row);
        }
        //return array of auctiondata
        return $data;

    }


    //get auction using users id
    function getAuctionsByUser($usersid)
    {
        $sqlQuery = 'SELECT * FROM Auctions WHERE postingUser = ?';
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->bindParam(1, $usersid);
        $statment->execute();
        $data = [];
        while ($row = $statment->fetch()) {

            $data[] = new AuctionData($row);
        }
        return $data;
    }





    //search for auctions by title
    function searchAuctions($searchValue)
    {
        $sqlQuery =
            "select * FROM Auctions
        where auctionName LIKE ?";
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $searchValue = $searchValue ."%";
        $statment->bindParam(1, $searchValue);
        $statment->execute();
        $data = [];
        while ($row = $statment->fetch()) {
            $data[] = new AuctionData($row);
        }
        return $data;
    }


    //search auction by id
    function searchID($searchValue)
    {
        $sqlQuery = "select * FROM Auctions
        where auctionsid = '%".$searchValue."%'";
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->execute();
        $data = [];
        while ($row = $statment->fetch()) {
            $data[] = new AuctionData($row);
        }
        return $data;

    }

    //search auction by description
    function searchDescription($searchValue)
    {
        $sqlQuery = "select * FROM Auctions
        where auctionDescription LIKE '%".$searchValue."%'";
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->execute();
        $data = [];
        while ($row = $statment->fetch()) {
            $data[] = new AuctionData($row);
        }
        return $data;
    }


    function getEndDate($auctionId)
    {
        $sqlQuery = 'select auctionStartDate from Auctions where auctionsid = '. $auctionId;
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->execute();
        $data = $statment->fetch();
        return $data;
    }





}