<?php
session_start();
 

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include("konekcija.php");

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
                  background-color: blue;
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
	<body >
 

		<?php
//Zameniti URL putanjom serverskog dela REST servisa
$url = 'http://localhost/ikea/server.php';
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, false);
$curl_odgovor = curl_exec($curl);
curl_close($curl);
// ucitavanje SimpleXML objekta
// prvi parametar se odnosi na XML koji se ucitava, drugi parametar prosleduje dodatne opcije, a treci parametar je true ako se XML uzima
// iz URL-a (eksterni XML fajl), a false ukoliko se XML uzima iz string promenljive
$tasks = new SimpleXMLElement($curl_odgovor,null,false);
if (property_exists($tasks,"Error")){
echo ($tasks->greska);
} else {
// ako nema greske, generise se tabela
?>

<img src="images/ikea.png" style="width: 200px; height: 80px;">
<br>
<h2>Obaveze</h2>
<table>
<tr>
<td>Id</td>
<td>Naziv</td>
</tr>
<?php
foreach ($tasks as $p){
// prolazi se kroz cvorove XML dokumenta i cvorovi se prikazuju u tabeli
?>
<tr>
<td><?php echo $p->idTask;?></td>
<td><?php echo $p->name;?></td>
</tr>
<?php
}
?>
</table>
<?php
}
?>

<?php
//Zameniti URL putanjom serverskog dela REST servisa i zameniti vrednost API ključa
$url='api.worldweatheronline.com/premium/v1/weather.ashx?q=44.804%2C20.4651&format=json&num_of_days=5&key=882fca5885d44e34b7302950200507';
$curl = curl_init($url);
//za FON-ovu mrezu treba podesiti proksi. Za ostale mreze linije za proksi treba da budu pod komentarom
//curl_setopt($curl, CURLOPT_PROXY, 'proxy.fon.rs:8080');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, false);
$curl_odgovor = curl_exec($curl);
curl_close($curl);
$parsiran_json = json_decode ($curl_odgovor);
$temperatura = $parsiran_json->data->current_condition[0]->temp_C;

  ?>

<p style="text-align: center;">Trenutna temperatura u Beogradu je <?php echo $temperatura;?> C.</p>


	</body>

        
</html>
