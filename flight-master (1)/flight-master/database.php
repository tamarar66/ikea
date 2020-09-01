<?php
class Database
{
private $hostname="localhost";
private $username="root";
private $password="";
private $dbname="ikea";
private $dblink; // veza sa bazom
private $result=true; // Holds the MySQL query result
private $records; // Holds the total number of records returned
private $affected; // Holds the total number of affected rows
function __construct($dbname)
{
$this->dbname = $dbname;
                $this->Connect();
}
/*
function __destruct()
{
$this->dblink->close();
//echo "Konekcija prekinuta";
}
*/
public function getResult()
{
return $this->result;
}
//konekcija sa bazom
function Connect()
{
$this->dblink = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
if ($this->dblink ->connect_errno) {
    printf("Konekcija neuspešna: %s\n", $mysqli->connect_error);
    exit();
}
$this->dblink->set_charset("utf8");
//echo "Uspesna konekcija";
}
//select funkcija
function unesiAdmina($data) {
    $mysqli = new mysqli("localhost", "root", "", "ikea");
    $cols = '(idUser,username,password,idAdmin,city)';

    $ime = 0;
    $username = mysqli_real_escape_string($mysqli,$data['username']);
    $password = mysqli_real_escape_string($mysqli,$data['password']);
    $idAdmin=0;
    $city = 0;


    $values = "('".$id."','".$name."','".$username."',".$password.")";

    $query = 'INSERT into admins '.$cols. ' VALUES '.$values;

    if($mysqli->query($query))
    {
        $this ->result = true;
    }
    else
    {
        $this->result = false;
    }
    $mysqli->close();
}



function taskovi() {
$mysqli = new mysqli("localhost", "root", "", "ikea");
$q = 'SELECT a.id, a.username FROM admins a join tasks t on a.id=t.id';
$this ->result = $mysqli->query($q);
$mysqli->close();
}

function delete ($table,  $keys, $values)
{
$delete = "DELETE FROM ".$table." WHERE ".$keys[0]." = '".$values[0]."'";
//echo $delete;
if ($this->ExecuteQuery($delete))
return true;
else return false;
}

//funkcija za izvrsavanje upita
function ExecuteQuery($query)
{
if($this->result = $this->dblink->query($query)){
if (isset($this->result->num_rows)) $this->records         = $this->result->num_rows;
if (isset($this->dblink->affected_rows)) $this->affected        = $this->dblink->affected_rows;
// echo "Uspesno izvrsen upit";
return true;
}
else
{
return false;
}
}

function CleanData()
{
//mysql_string_escape () uputiti ih na skriptu vezanu za bezbednost i sigurnost u php aplikacijama!!
}

}
?>
