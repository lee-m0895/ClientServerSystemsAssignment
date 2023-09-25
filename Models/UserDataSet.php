<?php
require_once('Models/DbConnection.php');
require ('Models/UserData.php');
class UserDataSet
{
    protected $_dbHandle, $_dbInstance;


    function __construct()
    {
        $this->_dbInstance = new DbConnection();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }


    //get user with the following username and password
    function getUser($nameEntered, $passwordEntered)
    {

            $sqlQuery = "SELECT * FROM users WHERE email = ?";
            $statment = $this->_dbHandle->prepare($sqlQuery);
            $statment->bindParam(1, $nameEntered);
            $statment->execute();
            $row = $statment->fetch();
            //hold on to the password
            $password = $row['password'];
            // make sure values where returned
            if ($nameEntered != null and $passwordEntered != null)
            {
                //verify the encrypted password with the entered password
                if (password_verify($passwordEntered, $password))
                {
                    //create a user object and return it
                    $result = $this->createUser($row);
                    return $result;
                }
            }
    }



    //create a new account
    function  adduser($email, $password, $name)
    {
        //look to see if user already exists
        $sqlQuery = "SELECT * FROM users WHERE email = ?";
        $statment = $this->_dbHandle->prepare($sqlQuery);
        $statment->bindParam(1, $email);
        $statment->execute();
        $row = $statment->fetch();
        if (empty($row)) {

            //create a unique id, cant get the table to auto increment so temp solution
            $sqlQuery = "SELECT MAX(usersid) FROM users";
            $statment = $this->_dbHandle->prepare($sqlQuery);
            $statment->execute();
            $row = $statment->fetch();
            $value =  $row[0];
            $usersid = $value+1;


            //pass the values to the query and run
            $sqlQuery ='INSERT INTO users (usersid, name, email, password ) VALUES(?,?,?,?)';
            $statment = $this->_dbHandle->prepare($sqlQuery);
            $statment->bindParam(1,$usersid);
            $statment->bindParam(2, $name);
            $statment->bindParam(3,$email);
            $statment->bindParam(4,$password);
            $statment->execute();
            //tell the user the account was created
            return true;
        }
        else
        {
            //tell the user the account was not created
            return false;
        }
    }



        //get user info at corresponding user id
        function getUserById($userid)
        {
            $sqlQuery = "SELECT * FROM users WHERE usersid = ?";
            $statment = $this->_dbHandle->prepare($sqlQuery);
            $statment->bindParam(1, $userid);
            $statment->execute();
            $row = $statment->fetch();
            $result = $this->createUser($row);
            return $result;
        }



        //create a user data object
        private function createUser($row)
        {
            $userid = $row['usersid'];
            $name = $row['name'];
            $email = $row['email'];
            $result = new UserData($userid, $name, $email);
            return $result;
        }
}
