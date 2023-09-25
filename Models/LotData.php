<?php


class LotData
{
 private $lotsid, $postinguser,
     $itemtitle, $itemdescription, $imageurl,
     $auctionid, $currentMaxBid, $lotEndDate;

 function __construct($row)
 {
     $this->lotsid = $row['lotsid'];
     $this->itemtitle = $row['itemtitle'];
     $this->itemdescription = $row['itemdescription'];
     $this->imageurl = $row['imageurl'];
     $this->auctionid = $row['auctionsid'];
     $this->lotEndDate = $row['lotEndDate'];
     if (isset($row['max(amountBidded)']))
     {
         $this->currentMaxBid= $row['max(amountBidded)'];
     }
     else if(isset($row['amountBidded']))
     {
         $this->currentMaxBid = $row['amountBidded'];
     }
     else if(isset($row['max(bids.amountBidded)']))
     {
         $this->currentMaxBid = $row['max(bids.amountBidded)'];
     }
     else
     {
         $this->currentMaxBid = 0;
     }
 }




    /**
     * @return mixed
     */
    public function getAuctionid()
    {
        return $this->auctionid;
    }

    public function getDate()
    {
        return $this->lotEndDate;
    }

    /**
     * @return mixed
     */
    public function getImageurl()
    {
        return $this->imageurl;
    }

    /**
     * @return mixed
     */
    public function getItemdescription()
    {
        return $this->itemdescription;
    }

    /**
     * @return mixed
     */
    public function getItemtitle()
    {
        return $this->itemtitle;
    }

    /**
     * @return mixed
     */
    public function getLotsid()
    {
        return $this->lotsid;
    }

    /**
     * @return mixed
     */
    public function getPostinguser()
    {
        return $this->postinguser;
    }


    /**
     * @return mixed
     */
    public function getCurrentMaxBid()
    {
        return $this->currentMaxBid;
    }

    /**
     * @param mixed $currentMaxBid
     */
    public function setCurrentMaxBid($currentMaxBid)
    {
        $this->currentMaxBid = $currentMaxBid;
    }
}