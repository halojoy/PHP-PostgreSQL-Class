<?php

class PgSql
{
    private $db;       //The db handle
    public  $num_rows; //Number of rows
    public  $last_id;  //Last insert id
    public  $aff_rows; //Affected rows

    public function __construct()
    {
        require 'config.php';
        $this->db = pg_connect("host=$host port=$port dbname=$dbname 
                                user=$user password=$password");
        if (!$this->db) exit();
    }

    public function close()
    {
        pg_close($this->db);
    }

    // For SELECT
    // Returns one row as object
    public function getRow($sql)
    {
        $result = pg_query($this->db, $sql);
        $row = pg_fetch_object($result);
        if (pg_last_error()) exit(pg_last_error());
        return $row;
    }

    // For SELECT
    // Returns an array of row objects
    // Gets number of rows
    public function getRows($sql)
    {
        $result = pg_query($this->db, $sql);
        if (pg_last_error()) exit(pg_last_error());
        $this->num_rows = pg_num_rows($result);
        $rows = array();
        while ($item = pg_fetch_object($result)) {
            $rows[] = $item;
        }
        return $rows;
    }

    // For SELECT
    // Returns one single column value as a string
    public function getCol($sql)
    {
        $result = pg_query($this->db, $sql);
        $col = pg_fetch_result($result, 0);
        if (pg_last_error()) exit(pg_last_error());
        return $col;
    }

    // For SELECT
    // Returns array of all values in one column
    public function getColValues($sql)
    {
        $result = pg_query($this->db, $sql);
        $arr = pg_fetch_all_columns($result);
        if (pg_last_error()) exit(pg_last_error());
        return $arr;
    }

    // For INSERT
    // Returns last insert $id
    public function insert($sql, $id='id')
    {
        $sql .= ' RETURNING '.$id;
        $result = pg_query($this->db, $sql);
        if (pg_last_error()) exit(pg_last_error());
        $this->last_id = pg_fetch_result($result, 0);
        return $this->last_id;
    }

    // For UPDATE, DELETE and CREATE TABLE
    // Returns number of affected rows
    public function exec($sql)
    {
        $result = pg_query($this->db, $sql);
        if (pg_last_error()) exit(pg_last_error());
        $this->aff_rows = pg_affected_rows($result);
        return $this->aff_rows;
    }

}
        