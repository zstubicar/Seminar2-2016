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
		$id_narudzbe = clean_input($conn, $_POST['id_narudzbe']);
		$odgovor = clean_input($conn, $_POST['odg']);

		//provjera jel to naruzdba od korisnika
		$sql_query_check = "SELECT korisnik_id FROM narudzbe WHERE id = ".$id_narudzbe."";
		$sql_result_check = mysqli_query($conn, $sql_query_check) or die("Dogodila se greška");
		$row_result_check = mysqli_fetch_assoc($sql_result_check);

		if($row_result_check['korisnik_id'] != $_SESSION['id']){
				echo "<script>
							alert('Nevazeca akcija!');
							window.location = '/Seminar2-2016/hr/moj_panel.php';
					  </script>";				  
				die;	
		}

		// prihvacanje ili odbijanje narudzbe
		if($odgovor == 1){
			$sql_query = "UPDATE narudzbe SET status = 'na dostavi' WHERE id = ".$id_narudzbe."";
			$sql_result = mysqli_query($conn, $sql_query) or die("Dogodila se greška");

			if($sql_result){
					echo "<script>
								alert('Stanje naruzdbe uspjesno izmjenjeno.');
								window.location = '/Seminar2-2016/hr/moj_panel.php';
						  </script>";				  
					die;
			}
			else{
					echo "<script>
								alert('Dogodila se greska. Pokusajte ponovo.');
								window.location = '/Seminar2-2016/hr/moj_panel.php';
						  </script>";				  
					die;	
			}
		}
		else{
			$sql_query = "DELETE FROM narudzbe WHERE id = ".$id_narudzbe."";
			$sql_result = mysqli_query($conn, $sql_query) or die("Dogodila se greška");

			if($sql_result){
					echo "<script>
								alert('Narudzba uspjesno obrisana.');
								window.location = '/Seminar2-2016/hr/moj_panel.php';
						  </script>";				  
					die;
			}
			else{
					echo "<script>
								alert('Dogodila se greska. Pokusajte ponovo.');
								window.location = '/Seminar2-2016/hr/moj_panel.php';
						  </script>";				  
					die;	
			}
		}
	}


	include "header.php";
	include "navigation.php";
?>


    <div class="container">
      <!-- Example row of columns -->

		<a href="dodaj.php">
			<button class="btn btn-info">Pohrani stvar</button>
		</a>

		<a href="dostavi.php">
			<button class="btn btn-info">Dostavi stvari</button>
		</a>

		<?php
			if(ovlasti($conn) == 1){				
				echo "<hr><h4>Administracija</h4><br>

						<a href='sve_stvari.php'>
							<button class='btn btn-success'>Stvari svih korisnika</button>
						</a>
						<a href='sve_narudzbe.php'>
							<button class='btn btn-success'>Narudžbe svih korisnika</button>
						</a>";
			}
		?>


		<h2>Lista mojih narudžbi</h2>
		<table class="table table-bordered table-stripped">
			<tr class="text-center">
				<td>ID</td>
				<td>Mjesto</td>
				<td>Vrijeme</td>
				<td>Lista stvari</td>
				<td>Status</td>
				<td>Način plaćanja</td>
				<td>Cijena</td>
				<td>Opcije</td>
			</tr>
			<?php
                $sql_data_query = "SELECT * FROM narudzbe WHERE korisnik_id = ".clean_input($conn, $_SESSION['id'])."";
                $sql_data_result = mysqli_query($conn, $sql_data_query);
                while($row_data = mysqli_fetch_assoc($sql_data_result)){

                	// ispis stvari
                	$id_lista = explode(" ", $row_data['lista_id']);
                	$stvari_lista = [];
                	foreach ($id_lista as $id_stvari) {
                		$sql_data_query_lista = "SELECT ime_stvari FROM stvari WHERE id = ".$id_stvari."";
                		$sql_data_result_lista = mysqli_query($conn, $sql_data_query_lista);
                		$row_data_lista = mysqli_fetch_assoc($sql_data_result_lista);
                		array_push($stvari_lista, $row_data_lista['ime_stvari']);
                	}

						echo "<tr>
								<td>".$row_data['id']."</td>
								<td>".$row_data['mjesto']."</td>
								<td>u ".$row_data['vrijeme']." sati</td>
								<td>".implode(", ", $stvari_lista)."</td>
								<td>".$row_data['status']."</td>
								<td>".$row_data['nacin_placanja']."</td>
								<td>".$row_data['cijena']." KN</td>
								<td>
									<form class='form-horizontal' method='POST' action='".htmlspecialchars($_SERVER["PHP_SELF"])."'>
										<input type='hidden' name='id_narudzbe' value='".$row_data['id']."'>
										".($row_data['status'] == 'u tijeku' ? '<button type="submit" class="btn btn-success" name="odg" value="1">Prihvati narudžbu</button>' : ($row_data['status'] == 'na stanju' ? '<button class="btn btn-success disabled">Dostavljeno u skladište</button>' : '<button class="btn btn-default disabled">Čeka se potvrda admina</button>'))."
										".($row_data['status'] == 'u tijeku' ? '<button type="submit" class="btn btn-danger" name="odg" value="0">Odbij narudžbu</button>' : '')."
									</form>
								</td>
							</tr>";
					
				}
			?>
		</table>

		<hr>

		<h2>Lista mojih stvari (čekaju dostavu)</h2>
		<table class="table table-bordered table-stripped">
			<tr class="text-center">
				<td>ID</td>
				<td>Ime</td>
				<td>Slika</td>
				<td>Dimenzija</td>
				<td>Lomljivo</td>
				<td>Status</td>
				<td>Težina</td>
				<td>Broj dana</td>
			</tr>
			<?php

				$id_temp_iskoristeni = [];
				$sql_lista = "SELECT lista_id FROM narudzbe WHERE korisnik_id = ".clean_input($conn, $_SESSION['id'])."";
				$sql_lista_result = mysqli_query($conn, $sql_lista);
				while($row_lista = mysqli_fetch_assoc($sql_lista_result)){
					$id_lista = explode(" ", $row_lista['lista_id']);
				     array_push($id_temp_iskoristeni, $id_lista);				                	
				}				                
				$id_iskoristeni = convert_multi_array($id_temp_iskoristeni);
				if(empty($id_iskoristeni)){
    			$id_iskoristeni = 0;
				}

                $sql_data_query = "SELECT * FROM stvari WHERE korisnik_id = ".clean_input($conn, $_SESSION['id'])." AND id NOT IN (".$id_iskoristeni.")";
                $sql_data_result = mysqli_query($conn, $sql_data_query);
                while($row_data = mysqli_fetch_assoc($sql_data_result)){
						echo "<tr>
								<td>".$row_data['id']."</td>
								<td>".$row_data['ime_stvari']."</td>
								<td><img src='../slike_upload/".$row_data['slika']."' class='img-thumbnail small_img' /></td>
								<td>".$row_data['dimenzije']."</td>
								<td>".$row_data['lomljivo']."</td>
								<td>u tijeku</td>
								<td>".$row_data['tezina']." KG</td>
								<td>".$row_data['dana']."</td>
							</tr>";
					
				}
			?>
		</table>

<?php
	include "footer.php";
?>
