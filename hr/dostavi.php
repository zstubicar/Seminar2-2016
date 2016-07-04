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
		$user_id = clean_input($conn, $_SESSION['id']);
		$mjesto = clean_input($conn, $_POST['mjesto']);

		$vrijeme = clean_input($conn, $_POST['vrijeme']);
		if($vrijeme == '-') $vrijeme = 8;
		if($vrijeme < 8 || $vrijeme > 20) $vrijeme = 8;

		$placanje = clean_input($conn, $_POST['placanje']);
		if($placanje == 'po pouzeću' || $placanje != 'po pouzeću') $placanje = 'po pouzeću';

		if(empty($_POST['stvari'])){
			echo "<script>
					alert('Lista stvari ne moze biti prazna.');
					window.location = '/Seminar2-2016/hr/dostavi.php';
				  </script>";				  
			die;
		}

		$stvari = [];
		foreach($_POST['stvari'] as $stvar){
			array_push($stvari, clean_input($conn, $stvar));
		}

		$lista_stvari = implode(" ", $stvari);

		// racunanje cijene narudzbe
		$cijena = 0;
		foreach ($stvari as $stvar) {
			$sql_data_query = "SELECT dimenzije, tezina, dana, lomljivo FROM stvari WHERE id = ".clean_input($conn, $stvar)."";
            $sql_data_result = mysqli_query($conn, $sql_data_query);
            $row_data = mysqli_fetch_assoc($sql_data_result);

			if($row_data['dimenzije'] == 'malo') $dimenzija = 0.5;
			else if($row_data['dimenzije'] == 'srednje') $dimenzija = 1;
			else if($row_data['dimenzije'] == 'veliko') $dimenzija = 1.5;

			$row_data['lomljivo'] == 'da' ? $lomljivo = 2 : $lomljivo = 1;

			if($row_data['tezina'] <= 2) $tezina = 0.5;
			else if($row_data['tezina'] > 2 && $row_data['tezina'] <= 10) $tezina = 1;
			else $tezina = 1.5;


			$cijena += ($dimenzija * $lomljivo + $tezina) * (int)$row_data['dana'];
		}

		$sql_query = "INSERT INTO narudzbe (korisnik_id, mjesto, vrijeme, lista_id, nacin_placanja, cijena) 
						VALUES (".$user_id.", '".$mjesto."', ".$vrijeme.", '".$lista_stvari."', '".$placanje."', ".$cijena.")";
		$sql_result = mysqli_query($conn, $sql_query) or die("Dogodila se greška");
		

			if($sql_result){
					echo "<script>
								alert('Narudzba uspjesno izvrsena.');
								window.location = '/Seminar2-2016/hr/dostavi.php';
						  </script>";				  
					die;
			}
			else{
					echo "<script>
								alert('Dogodila se greska. Pokusajte ponovo.');
								window.location = '/Seminar2-2016/hr/ddostavi.php';
						  </script>";				  
					die;	
			}

	}

	include "header.php";
	include "navigation.php";
?>

    <div class="container">
      <!-- Example row of columns -->
		<h1>Dostava stvari</h1>

			<form class="form-horizontal" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="mjesto">Mjesto</label>  
				  <div class="col-md-4">
				  <input id="mjesto" name="mjesto" placeholder="Mjesto" class="form-control input-md" required="" type="text">
				    
				  </div>
				</div>

				<div class="form-group">
				  <label class="col-md-4 control-label" for="vrijeme">Vrijeme dostave (8 - 20h)</label>  
					<div class="col-md-4 control-label">
						 <select name="vrijeme" class="form-control input-md">
						 <option value="-"></option>
						 <?php
						 	for($i = 8; $i <= 20; $i++){
						 		echo "<option value='".$i."'>u ".$i." sati</option>";
						 	}
						 ?>
						</select>
				  	  </div>
				</div>

				<div class="form-group">
					  <label class="col-md-4 control-label" for="placanje">Način plaćanja</label>  
					<div class="col-md-4 control-label">  
						 <label class="radio-inline"><input type="radio" name="placanje" checked="true" value="pouzece">Po pouzeću</label>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label" for="stvari">Stvari za dostavu</label>  
					<div class="col-md-4 control-label">  
						<?php

								//dohvati ID-eve stvari vec koje se nalaze na narudzbi
								$id_temp_iskoristeni = [];
				                $sql_lista = "SELECT lista_id FROM narudzbe WHERE korisnik_id = ".clean_input($conn, $_SESSION['id'])."";
				                $sql_lista_result = mysqli_query($conn, $sql_lista);
				                while($row_lista = mysqli_fetch_assoc($sql_lista_result)){
				                	$id_lista = explode(" ", $row_lista['lista_id']);
				                	array_push($id_temp_iskoristeni, $id_lista);				                	
				                }				                
				                $id_iskoristeni = convert_multi_array($id_temp_iskoristeni);
				                

								$sql_data_query = "SELECT id, ime_stvari FROM stvari WHERE korisnik_id = ".clean_input($conn, $_SESSION['id'])." AND id NOT IN(".$id_iskoristeni.")";
               					$sql_data_result = mysqli_query($conn, $sql_data_query);
                				while($row_data = mysqli_fetch_assoc($sql_data_result)){
                					echo "<label class='checkbox-inline'><input type='checkbox' name='stvari[]' value='".$row_data['id']."'>".$row_data['ime_stvari']."</label>";

                				}
						?>
					</div>
				</div>

				<button type="submit" class="btn btn-primary">Submit</button>
				<button type="reset" class="btn btn-danger">Reset</button>
				</form>


<?php
	include "footer.php";
?>
