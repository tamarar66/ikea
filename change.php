<?php
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: logina.php");
    exit;
}
 
include("config.php");

    $sql1 = "SELECT * FROM admins WHERE username='".$_SESSION['username']."'";
    $sth = $connect->query($sql1);
    $result=mysqli_fetch_array($sth);
    $getit = mysqli_query($connect,$sql1);
    $row = mysqli_fetch_array($getit);

    $id=$row['id'];


$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Molimo Vas unesite novu lozinku.";     
    } elseif(strlen(trim($_POST["new_password"])) < 8){
        $new_password_err = "Lozinka mora da ima manje od 8 karaktera.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Molimo Vas ponovite lozinku.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Lozinke se ne poklapaju.";
        }
    }
        
    if(empty($new_password_err) && empty($confirm_password_err)){
        $sql = "UPDATE admins SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($connect, $sql)){
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            if(mysqli_stmt_execute($stmt)){
                session_destroy();
                header("location: loginA.php");
                exit();
            } else{
                echo "Greška! Pokušajte ponovo.";
            }
        }
        
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

                
		
	</head>
	<body>

		<div class="container" style="border: #337ab7 solid 2px; background-color: #0057A4;">
            <div style="width: 300px;">
                       <h2>Promenite lozinku</h2>
                            <p>Molimo Vas unesite validne podatke.</p>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                                <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                                    <label>Nova lozinka</label>
                                    <br>
                                    <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                                    <span class="help-block"><?php echo $new_password_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                    <label>Potvrdite lozinku</label>
                                    <br>
                                    <input type="password" name="confirm_password" class="form-control">
                                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Promeni">
                                  
                                </div>
                            </form>
                            </div>
	       </div>
			
		</div>
	</body>

        
</html>