<?php
include "connect.php";

class DBController
{

    private $connectionHandler;

    /**
     * DBController constructor.
     */
    function __construct()
    {
        $this->connectionHandler = new ConnectionHandler();

    }

    /**
     * @param $quote
     * @param $user_id
     */
    public function insertQuote($quote, $user_id)
    {
        $this->connectionHandler->connectToQuotes();
        $conn = $this->connectionHandler->getConnection();
        if ($stmt = $conn->prepare('INSERT INTO discord (quote, user_id) VALUES (?,?)')) {
            $message = mysqli_real_escape_string($conn, $quote);
            $stmt->bind_param("ss", $message, $user_id);
            $stmt->execute();
            constructResponse(true);
            $stmt->close();
        }
    }

    /**
     * @param $amount
     * @param $accepted
     * @return array|null
     */
    public function getQuote($amount, $accepted)
    {
        if ($amount > 50) {
            $amount = 50;
        }
        $this->connectionHandler->connectToQuotes();
        $conn = $this->connectionHandler->getConnection();
        $query = $conn->prepare("SELECT id,quote,user_id,date FROM discord WHERE accepted=? LIMIT ?");
        $query->bind_param("ii", $accepted, $amount);
        $query->execute();
        $res = $query->get_result();
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
        return $result;
    }


    /**
     * @param $amount
     * @param $search
     * @param $accepted
     * @return array|null
     */
    public function getQuoteDetails($amount, $search, $accepted)
    {
        if ($amount > 50) {
            $amount = 50;
        }
        $this->connectionHandler->connectToQuotes();
        $conn = $this->connectionHandler->getConnection();
        $query = $conn->prepare("SELECT * FROM discord WHERE user_id LIKE ? AND accepted=?");
        $query->bind_param("si", $search, $accepted);
        $query->execute();
        $res = $query->get_result();
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $this->connectionHandler->close();
        return $result;
    }

    /**
     * @return integer
     */
    public function getAccepted()
    {
        $this->connectionHandler->connectToQuotes();
        $conn = $this->connectionHandler->getConnection();
        $result = $conn->query("SELECT id FROM discord WHERE accepted=1");
        $this->connectionHandler->close();
        return $result->num_rows;
    }

    /**
     * @return integer
     */
    public function getPending()
    {
        $this->connectionHandler->connectToQuotes();
        $conn = $this->connectionHandler->getConnection();
        $resultQuery = $conn->query("SELECT id FROM discord WHERE accepted=0");
        $result = $resultQuery->num_rows;
        $this->connectionHandler->close();

        return $result;
    }

    /**
     * @return integer
     */
    public function getTotal()
    {
        $this->connectionHandler->connectToQuotes();
        $conn = $this->connectionHandler->getConnection();
        $result = $conn->query("SELECT id FROM discord");
        $this->connectionHandler->close();
        return $result->num_rows;
    }

    /**
     * @param $user
     * @param $pass
     * @return bool
     */
    public function validateUser($user, $pass)
    {
        $this->connectionHandler->connectToUsers();
        $conn = $this->connectionHandler->getConnection();
        if ($stmt = $conn->prepare('SELECT username,password,admin FROM users where username=?')) {
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $stmt->bind_result($username, $password, $admin);
            $stmt->fetch();
            if ($admin && password_verify($pass, $password)) {
                return true;
            } else {
                return false;
            }
        }
        $this->connectionHandler->close();
        return false;
    }
}