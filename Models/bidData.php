<?php


class bidData
{
    private $bidid , $usersid, $lotsid, $amountBidded, $notification;

    function __construct($row)
    {
        $this->bidid = $row['bidid'];
        $this->usersid = $row['usersid'];
        $this->lotsid = $row['lotsid'];
        $this->amountBidded = $row['amountBidded'];
        $this->notification = $row['notification'];
    }

    /**
     * @return mixed
     */

    /**
     * @return mixed
     */
    public function getNotification()
    {
        return $this->notification;
    }


    public function getLotsid()
    {
        return $this->lotsid;
    }

    /**
     * @return mixed
     */
    public function getAmountBidded()
    {
        return $this->amountBidded;
    }

    /**
     * @return mixed
     */
    public function getBidid()
    {
        return $this->bidid;
    }

    /**
     * @return mixed
     */
    public function getUsersid()
    {
        return $this->usersid;
    }


}