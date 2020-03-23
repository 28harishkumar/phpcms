<?php

/**
 * @author Harish Kumar
 * @copyright Flowkl
 * @link https://www.flowkl.com
 * @version 1.0
 * This is core file which manupulate database instructions
 * It is using PDO connection
 * MAll functions are using prepare statements
 */

// security check
if (!isset($security_check)) {
  echo "This is restricted file";
  exit();
}

/**
 * class for mysql database
 */
class MysqlDatabase
{

  // defining secrete variables
  private $db_name = DATABASE_NAME;
  private $db_user = DATABASE_USER;
  private $db_pass = DATABASE_PASS;
  private $db_server = DATABASE_SERVER;

  // protected PDO connection
  protected $con;

  /**
   * setting database configuration
   */
  function set_config($server, $db, $user, $pass)
  {
    $this->db_server = $server;
    $this->db_name = $db;
    $this->db_user = $user;
    $this->db_pass = $pass;
  }

  /**
   * connecting with a mysql database
   */
  private function connect()
  {
    $info = 'mysql:host=' . $this->db_server . ';dbname=' . $this->db_name;
    try {
      $this->con = new PDO($info, $this->db_user, $this->db_pass); //data server connection
    } catch (PDOException $Exception) {
      header('HTTP/1.1 500 Database Error');
      exit;
    }


    if (!$this->con) {
      die('Could not connect: ' . mysql_error());
    }
  }

  /**
   * disconnecting database connection
   */
  private function disconnect()
  {
    $this->con = null;
  }

  /**
   * quoting string
   * @param string $args
   * @return sting $args
   */
  function quote($arg)
  {
    $this->connect();
    $arg = $this->con->quote($arg);
    $this->disconnect();
    return $arg;
  }

  /**
   * prepare statement for single fetch
   * @param string $sql
   * @param array $args
   * @return query $q
   */
  function prepare($sql, $args)
  {
    $this->connect();
    $q = $this->con->prepare($sql);
    $q->execute($args);
    $this->disconnect();
    return $q;
  }

  /**
   * Return array of results
   * @param string $sql
   * @param array $args
   * @return query array $rows
   */
  function load_result($sql, $args)
  {
    $this->connect();
    $q = $this->con->prepare($sql);
    $q->execute($args);
    $rows = $q->fetchAll();
    $this->disconnect();
    return $rows;
  }

  /**
   * Return single result
   * @param string $sql
   * @param array $args
   * @return query $row
   */
  function load_single_result($sql, $args)
  {
    $this->connect();
    $q = $this->con->prepare($sql);
    $q->execute($args);
    $row = $q->fetch();
    $this->disconnect();
    return $row;
  }
}
