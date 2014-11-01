<?php

include_once("settings.php");

class lib {

    function lib() {
        $this->connectDB();
    }

    function connectDB() {
        global $dbName, $dbUsername, $dbPassword, $dbServer;

        $this->dbConnect = mysql_connect($dbServer, $dbUsername, $dbPassword);
        if (!$this->dbConnect)
            die($this->error_db(mysql_error()));
        $dbSelectDB = mysql_select_db($dbName);
        mysql_query("set names utf8");
        if (!$dbSelectDB) {
            die($this->error_db(mysql_error()));
        }
    }

    function error_db($_Err) {
        echo "<html><title>DataBase Error</title><body>
		<h1 style='color: red;'>DataBase Error</h1>
         <div  style='background-color:#FFFFCC;  height: 100px; border: 1px solid #000000; font-size: 14px; padding: 10px;'><b>" . $_Err . "</div>
		 </body></html>";
    }

// Execute Sql Statment 
    function ExecuteSqlCommand($StrSql) {
        $conn = $this->dbConnect;
        $Result = mysql_query($StrSql, $conn);
        return $Result;
    }

    function query($query) {
        $conn = $this->dbConnect;
        $query = @mysql_query($query, $conn);
        if ($query) {
            return true;
        } else {
            die($this->error_db(mysql_error()));
        }
    }

    function fetch_array($query) {
        $dat = $this->ExecuteSqlCommand($query);
        while ($rss = @mysql_fetch_array($dat, MYSQL_ASSOC)) {
            foreach ($rss as $key => $val) {
                $rs[$key] = stripslashes(urldecode($val));
            }
            $data[] = $rs;
        }
        return $data;
    }

    function redirectPage($page) {
        echo "<META HTTP-EQUIV='refresh' content='0;URL=$page'>";
    }

    function alertText($txt) {
        echo "<script language='javascript'>alert('$txt');</script>";
    }

    function Back() {
        echo "<script language='javascript'>history.go(-1);</script>";
    }

    function get_countries($appr = false) {

        $countries = array(
            'eg' => 'egypt',
            'sa' => 'ksa',
            'kw' => 'kwait',
            'ae' => 'uae',
            'bh' => 'bahrain',
            'qa' => 'qatar'
        );
        if (!$appr) {
            return $countries;
        } else {
            return $countries[$appr];
        }
    }

}

?>