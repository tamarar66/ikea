<?php
session_start();
 

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include("config.php");

 $sql2 = "SELECT * FROM tbl_product";
    $result2 = $connect->query($sql2);
 


   
    $name = $image = $price="";
    $name_err = $image_err = $price_err= "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["name"]))){
        $name_err = "Molimo Vas unesite naziv.";     
    } else{
        $name = trim($_POST["name"]);
    }
    
    if(empty(trim($_POST["image"]))){
        $image_err = "Molimo Vas unesite sliku.";     
    } else{
        $image = trim($_POST["image"]);
    }
    if(empty(trim($_POST["price"]))){
        $price_err = "Molimo Vas unesite cenu.";     
    } else{
        $price = trim($_POST["price"]);
    }

    
 
    
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($image_err)  && empty($price_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO tbl_product (name, image, price) VALUES (?,?,?)";
         
        if($stmt = mysqli_prepare($connect, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_image, $param_price);
            
            $param_name = $name;
            $param_image = $image;
            $param_price= $price;
           
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: adminPage.php");
            } else{
                echo "Greška! Molimo Vas pokušajte ponovo.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    
    mysqli_close($connect);
}
 ?>

<!DOCTYPE html>
<html>
	<head>
		<title>IKEA SHOP</title>
		<script src="js/jquery.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<script src="js/bootstrap.min.js"></script>

                
		<style>
                table {
                  border-collapse: collapse;
                  width: 100%;
                  margin-top: 30px;
                }

                td {
                  text-align: left;
                  padding: 8px;

                }


                tr:nth-child(even){background-color: yellow; color: blue;}
                tr:nth-child(even) a{color: blue;}

                th {
                  background-color: yellow;
                  color: blue;
                  text-align: left;
                  padding: 8px;
                }
		.popover
		{
		    width: 100%;
		    max-width: 800px;
		}
		</style>
	</head>
	<body>

		<div class="container" style="border: #337ab7 solid 2px; background-color: #0057A4;">
                        <div style=" width: 100%;height: 80px; margin-right: "><img src="images/ikea.png" style="height: 80px;"></div>
                        <h6><a href="logout.php">Izlogujte se</a></h6>
                        <h6><a href="change.php">Promenite sifru</a></h6>
                        <h6><a href="klijent.php">Pogledajte vase obaveze</a></h6>
                        
                        <div>
			<div class="admin" style="width: 300px;">
                     <h2>Unesite nov komad namestaja</h2>
                    <p>Molimo Vas popunite sva polja.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Naziv</label>
                            <br>
                            <input type="text" name="name" class="form-control" onkeyup="showHint(this.value)" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err; ?></span>
                            
                        </div>  
                        <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                            <label>Slika</label>
                            <br>
                            <input type="text" name="image" class="form-control" value="<?php echo $image; ?>">
                            <span class="help-block"><?php echo $image_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                            <label>Cena</label>
                            <br>
                            <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
                            <span class="help-block"><?php echo $price_err; ?></span>
                        </div>
                        
                        <br>
                        <div class="form-group">
                            <input type="submit" style="background-color: yellow; color: blue;" value="Dodajte proizvod">
                            <br>
                            
                        </div>
                        
                    </form>
                   </div>
                   <br>
                   <div id="contentdash">
                        <h2>Proizvodi na lageru</h2>
                        <br>

                        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Pretraži po nazivu">
                    <div class="table">
                        <table id="myTable" width="100%;">
                            <thead>
                            <tr>
                            <th><strong>Br.</strong></th>
                            <th><strong>Naziv</strong></th>   
                            <th><strong>Cena</strong></th>
                            <th><strong>Obriši</strong></th>
                            
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $count=1;
                            
                            while($row2 = mysqli_fetch_assoc($result2)) { ?>
                            <tr><td><?php echo $count; ?></td>
                            <td ><?php echo $row2["name"]; ?></td>
                            <td ><?php echo $row2["price"]; ?></td>
                            <td>
                            <a href="deletep.php?id=<?php echo $row2["id"]; ?>">Obriši</a>
                            </td>
                            </tr>
                            <?php $count++; } ?>
                            </tbody>
                            </table>

                    <div>
                        

                </div>
            </div>

 
                

        </div>

        <h2>Konvertor</h2>
<form method="GET" action="">
Iznos: <input style="margin-left: 17px;" type = "text" name = "iznos"/><br/>
<br>
Iz valute: <input type = "text" name = "izvalute"/><br/>
<br>
U valutu: <input type = "text" name = "uvalutu"/><br/>
<br>
<input style="background-color: yellow; color: blue;" type = "submit" value="Konvertuj"/>
</form>
<?php if (!empty ($_GET['iznos'])&&!empty ($_GET['izvalute'])&&!empty ($_GET['uvalutu'])){?>
<?php
$iznos = $_GET['iznos'];
$izvalute = $_GET['izvalute'];
$uvalutu = $_GET['uvalutu'];
$url = 'https://api.kursna-lista.info/38f8d1fc2fe551cb41622c765e3fd42e/konvertor/'.$izvalute.'/'.$uvalutu.'/'.$iznos;

$curl = curl_init($url);
//za FON-ovu mrezu treba podesiti proksi. Za ostale mreze linije za proksi treba da budu pod komentarom
//curl_setopt($curl, CURLOPT_PROXY, 'proxy.fon.rs:8080');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, false);
$curl_odgovor = curl_exec($curl);
$parsiran_json = json_decode ($curl_odgovor);

?>
<h2>Rezultat:</h2>
<p><?php echo $iznos;?> <?php echo $izvalute;?> vredi <?php echo $parsiran_json->result->value;?> <?php echo $uvalutu;?>.</p>

<?php
}
?>


                   </div> 

	       </div>
			
		</div>
	</body>

        <script>
        function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
        </script>
</html>