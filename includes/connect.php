<?php

//Connect to database
class ConnectionHandler
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "quotes";
    private $connected = false;
    private $connection;

    public function connectToQuotes()
    {
        if ($this->connected) return;
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $this->connection = $conn;
        if ($conn->connect_error) {
            $this->connected = false;
        } else {
            $this->connected = true;
        }
    }

    public function connectToUsers()
    {
        if ($this->connected) return;

        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $this->connection = $conn;
        mysqli_set_charset($conn, "utf8");

        if ($conn->connect_error) {
            $this->connected = false;
        } else {
            $this->connected = true;
        }
    }

    /**
     * @return mysqli
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     *Close connection with current db
     */
    public function close()
    {
        if (!is_null($this->connection)) {
            $this->connection->close();
            $this->connected = false;
        }
    }
}