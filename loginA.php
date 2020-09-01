<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: prodavnica.php");
  exit;
}
 
include("config.php");
 
$username = $password = "";
$username_err = $password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Molimo Vas unesite koriničko ime.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Molimo Vas unesite lozinku.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM admins WHERE username = ?";
        
        if($stmt = mysqli_prepare($connect, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            header("location: adminPage.php");
                        } else{
                            $password_err = "Lozinka nije tačna.";
                        }
                    }
                } else{
                    $username_err = "Ne postoji korisnik sa ovim korisničkim imenom.";
                }
            } else{
                echo "Greška! Molimo Vas pokušajte ponovo.";
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
		<style>
		.popover
		{
		    width: 100%;
		    max-width: 800px;
		}
		</style>
	</head>
	<body>
		<div class="container" style="border: #337ab7 solid 2px; background-color: #0057A4;">
			<br />
			<h3 align="center"><a href="#" style="color: yellow;">Dobro došli u IKEA online prodavnicu</a></h3>
			<br />

			<div class="img"><img style="margin-left: 180px;margin-top: 30px; width: 800px; margin-bottom: 50px; -webkit-box-shadow: 20px 20px 20px 20px #E5FF00;
box-shadow: 20px 20px 20px 20px #E5FF00;" src="images/emp.jpg"></div>
			
				<div class="login">
        				<div class="log" style="margin-left: 180px; margin-bottom: 50px;">
        						        <h2>Ulogujte se</h2>
        						        <p>Molimo Vas popunite sva polja.</p>
        						        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        						            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
        						                <label>Koriničko ime</label>
                                                <br>
        						                <input style="width: 200px;" type="text" name="username" class="form-control" value="<?php echo $username; ?>">
        						                <span class="help-block"><?php echo $username_err; ?></span>
        						            </div>    
        						            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
        						                <label>Lozinka</label>
                                                <br>
        						                <input style="width: 200px;" type="password" name="password" class="form-control">
        						                <span class="help-block"><?php echo $password_err; ?></span>
        						            </div>
        						            <div class="form-group1">
        						                <input type="submit" class="btn btn-primary" value="Ulogujte se">
                                                <br>
                                                
                                               
        						            </div>
        						            
        						        </form>
        			    </div>
                        
                </div> 

	</div>
			
		</div>
	</body>
</html>

