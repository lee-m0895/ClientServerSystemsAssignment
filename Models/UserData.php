<?php


class UserData
{
    private $userid, $name, $email;

    function __construct($userid, $name, $email)
    {
        $this->userid = $userid;
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }
}