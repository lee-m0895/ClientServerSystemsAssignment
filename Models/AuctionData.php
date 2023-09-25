<?php


class AuctionData
{
    //fields
    private $auctionid, $auctionStartDate, $auctionDescription, $postingUser, $auctionImage, $auctionName;

    function __construct($row)
    {
        //set fields from row
        $this->auctionid = $row['auctionsid'];
        $this->auctionStartDate = $row['auctionStartDate'];
        $this->auctionDescription = $row['auctionDescription'];
        $this->postingUser = $row['postingUser'];
        $this->auctionImage = $row['auctionImage'];
        $this->auctionName = $row['auctionName'];
    }

    /**
     * @return mixed
     */
    public function getAuctionid()
    {
        return $this->auctionid;
    }

    /**
     * @return mixed
     */
    public function getAuctionDescription()
    {
        return $this->auctionDescription;
    }

    /**
     * @return mixed
     */
    public function getAuctionImage()
    {
        return $this->auctionImage;
    }

    /**
     * @return mixed
     */
    public function getAuctionStartDate()
    {
        return $this->auctionStartDate;
    }

    /**
     * @return mixed
     */
    public function getPostingUser()
    {
        return $this->postingUser;
    }

    /**
     * @return mixed
     */
    public function getAuctionName()
    {
        return $this->auctionName;
    }
}