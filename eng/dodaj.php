<?php
session_start();
	require_once "../include/config.php";

	if(!isset($_SESSION['username'])) {
		echo "<script>
					window.location = 'index.php';
			  </script>";
		die;	  
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$user_id = (int)$_SESSION['id'];
		$ime_stvari = clean_input($conn, $_POST['ime_stvari']);

		$dimenzija = clean_input($conn, $_POST['dimenzija']);
		$dimenzije = ['malo', 'srednje', 'veliko'];
		if(!in_array($dimenzija, $dimenzije)){
			$dimenzija = 'malo';
		}

		$lomljivo = clean_input($conn, $_POST['lomljivo']);
		$lomljivo_arr = ['ne', 'da'];
		if(!in_array($lomljivo, $lomljivo_arr)){
			$lomljivo = 'ne';
		}

		$dana = clean_input($conn, $_POST['dana']);
		$dana_custom = (int)clean_input($conn, $_POST['dana_custom']);

		$dana_arr = [7, 30, 90];
		if($dana == '-'){
			$dana = $dana_custom;
		}
		else {
			if(!in_array($dana, $dana_arr)){
				$dana = 7;
			}
		}

		$tezina = (int)clean_input($conn, $_POST['tezina']);
		if($tezina <= 0) $tezina = 1;
		if($tezina >= 100) $tezina = 100;

		$target_dir = "../slike_upload/";
		$target_file = $target_dir . basename($_FILES["slika"]["name"]);
		$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
		$check = getimagesize($_FILES["slika"]["tmp_name"]);

		if($check === false) {
				echo "<script>
							alert('File is not picture');
							window.location = '/Seminar2-2016/hr/dodaj.php';
					  </script>";				  
				die;				
        }
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				echo "<script>
							alert('Wrong format of picture');
							window.location = '/Seminar2-2016/hr/dodaj.php';
					  </script>";				  
				die;
		} 

		if (move_uploaded_file($_FILES["slika"]["tmp_name"], $target_file)) {
			$sql_query = "INSERT INTO stvari (korisnik_id, ime_stvari, dimenzije, tezina, slika, lomljivo, dana) VALUES (".$user_id.", '".$ime_stvari."', '".$dimenzija."', ".$tezina.", '".basename($_FILES["slika"]["name"])."', '".$lomljivo."', ".$dana.")";

			$sql_result = mysqli_query($conn, $sql_query) or die("Dogodila se greška");

			if($sql_result){
					echo "<script>
								alert('Stvar uspjesno pohranjena.');
								window.location = '/Seminar2-2016/hr/dodaj.php';
						  </script>";				  
					die;
			}
			else{
					echo "<script>
								alert('Dogodila se greska. Pokusajte ponovo.');
								window.location = '/Seminar2-2016/hr/dodaj.php';
						  </script>";				  
					die;	
			}
    	} 
    	else {
				echo "<script>
							alert('Dogodila se greska. Pokusajte ponovo.');
							window.location = '/Seminar2-2016/hr/dodaj.php';
					  </script>";				  
				die;
    	}


	}

	include "header.php";
	include "navigation.php";
?>

    <div class="container">
      <!-- Example row of columns -->
		<h1>Adding Stuff</h1>


				<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="ime_stvari">Stuff name</label>  
				  <div class="col-md-4">
				  <input id="ime_stvari" name="ime_stvari" placeholder="Ime stvari" class="form-control input-md" required="" type="text">
				    
				  </div>
				</div>

								<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="ime_prezime">Stuff image</label>  
				  <div class="col-md-4">
				  	<input type="file" name="slika" accept="image/*" required="">
				    
				  </div>
				</div>

				<div class="form-group">
					  <label class="col-md-4 control-label" for="dimenzija">Dimension:</label>  
					<div class="col-md-4 control-label">  
						 <label class="radio-inline"><input type="radio" name="dimenzija" checked="true" value="malo">Small</label>
						<label class="radio-inline"><input type="radio" name="dimenzija" value="srednje">Medium</label>
						<label class="radio-inline"><input type="radio" name="dimenzija" value="veliko">Big</label> 
					</div>
				</div>

								<div class="form-group">
					  <label class="col-md-4 control-label" for="lomljivo">Fragile</label>  
					<div class="col-md-4 control-label">  
						 <label class="radio-inline"><input type="radio" name="lomljivo" checked="true" value="ne">No</label>
						<label class="radio-inline"><input type="radio" name="lomljivo" value="da">Yes</label>
					</div>
				</div>

								<div class="form-group">
				  <label class="col-md-4 control-label" for="tezina">Weight:</label>  
				  <div class="col-md-4">
				  <input type="number" class="form-control input-md"  name="tezina" min="1" max="100" required="">
				    
				  </div>
				</div>

				<div class="form-group">
				  <label class="col-md-4 control-label" for="dana">Number od days:</label>  
					<div class="col-md-4 control-label">
						 <select name="dana" class="form-control input-md">
						 <option value="-"></option>
						  <option value="7">week - 7 days</option>
						  <option value="30">Month - 30 days</option>
						  <option value="90">Season - 90 days</option>
						</select> 

						<input type="number" class="form-control input-md" name="dana_custom" min="1" max="500" placeholder="ili specifičan broj dana...">
				  	  </div>
				</div>

				<button type="submit" class="btn btn-primary">Submit</button>
				<button type="reset" class="btn btn-danger">Reset</button>
				</form>

<?php
	include "footer.php";
?>
