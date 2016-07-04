<?php
session_start();
	require_once "../include/config.php";

	if(isset($_SESSION['username'])) {
		echo "<script>
					window.location = 'moj_panel.php';
			  </script>";
		die;	  
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$username = clean_input($conn, $_POST['username']);
		$email = clean_input($conn, $_POST['email']);
		$ime_prezime = clean_input($conn, $_POST['ime_prezime']);
		$broj_telefona = clean_input($conn, $_POST['broj_telefona']);
		$lozinka = escape($conn, $_POST['lozinka']);
		$lozinka_opet = escape($conn, $_POST['lozinka_opet']);
		$ovlasti = 0;
		
		if($lozinka != $lozinka_opet){
			echo "<script>
						alert('Unjete lozinke nisu iste!');
						window.location = '/Seminar2-2016/hr/register.php';
				  </script>";				  
			die;
		}
		
		$lozinka = sha1($lozinka);

		$sql_query = "INSERT INTO korisnici (username, broj_telefona, email, ime_prezime, lozinka, ovlasti) VALUES ('".$username."', '".$broj_telefona."', '".$email."', '".$ime_prezime."', '".$lozinka."', ".$ovlasti.")";

		$sql_result = mysqli_query($conn, $sql_query) or die("Dogodila se greška");

		if($sql_result){
				echo "<script>
							alert('Uspjesno ste registrirani! Ulogirajte se za nastavak.');
							window.location = '/Seminar2-2016/hr/login.php';
					  </script>";				  
				die;
		}
		else{
				echo "<script>
							alert('Dogodila se greska. Pokusajte ponovo.');
							window.location = '/Seminar2-2016/hr/register.php';
					  </script>";				  
				die;	
		}
	}

    include "header.php";
    include "navigation.php";
?>

    <div class="container">
      <!-- Example row of columns -->
				<form class="form-horizontal" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="username">Username</label>  
				  <div class="col-md-4">
				  <input id="username" name="username" placeholder="Korisničko ime" class="form-control input-md" required="" type="text">
				    
				  </div>
				</div>

								<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="ime_prezime">Name and Surname</label>  
				  <div class="col-md-4">
				  <input id="ime_prezime" name="ime_prezime" placeholder="Ime i prezime" class="form-control input-md" required="" type="text">
				    
				  </div>
				</div>

								<div class="form-group">
				  <label class="col-md-4 control-label" for="broj_telefona">Telefon number</label>  
				  <div class="col-md-4">
				  <input id="broj_telefona" name="broj_telefona" placeholder="Broj telefona" class="form-control input-md" required="" type="text">
				    
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="email">Email</label>  
				  <div class="col-md-4">
				  <input id="email" name="email" placeholder="Email" class="form-control input-md" required="" type="email">
				    
				  </div>
				</div>

				<!-- Password input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="lozinka">Password</label>
				  <div class="col-md-4">
				    <input id="lozinka" name="lozinka" placeholder="Lozinka" class="form-control input-md" required="" type="password">
				    
				  </div>
				</div>

				<!-- Password input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="lozinka_opet">Repeat password</label>
				  <div class="col-md-4">
				    <input id="lozinka_opet" name="lozinka_opet" placeholder="Ponovite lozinku" class="form-control input-md" required="" type="password">
				    
				  </div>
				</div>

				<button type="submit" class="btn btn-primary">Submit</button>
				<button type="reset" class="btn btn-danger">Reset</button>
				</form>

<?php
	include "footer.php";
?>
