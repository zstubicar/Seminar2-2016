<?php
session_start();
	require_once "../include/config.php";


if(!isset($_SESSION['username'])) {
	echo "<script>
				window.location = 'index.php';
		  </script>";
	die;	  
}
if(ovlasti($conn) != 1){
	echo "<script>
				window.location = 'moj_panel.php';
		  </script>";
	die;	
}

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$id_narudzbe = clean_input($conn, $_POST['id_narudzbe']);

		$sql_query = "UPDATE narudzbe SET status = 'na stanju' WHERE id = ".$id_narudzbe."";

		$sql_result = mysqli_query($conn, $sql_query) or die("Dogodila se greška");

		if($sql_result){
				echo "<script>
							alert('Stanje naruzdbe uspjesno izmjenjeno.');
							window.location = '/Seminar2-2016/hr/sve_narudzbe.php';
					  </script>";				  
				die;
		}
		else{
				echo "<script>
							alert('Dogodila se greska. Pokusajte ponovo.');
							window.location = '/Seminar2-2016/hr/sve_narudzbe.php';
					  </script>";				  
				die;	
		}
	}


	include "header.php";
	include "navigation.php";
?>

    <div class="container">
      <!-- Example row of columns -->
      	<h2>List of orders of all users</h2>
		<table class="table table-bordered table-stripped">
			<tr class="text-center">
				<td>ID</td>
				<td>User name</td>
				<td>Place</td>
				<td>Time</td>
				<td>Stuff List</td>
				<td>Status</td>
				<td>Way of paying</td>
				<td>Price</td>
				<td>Options</td>
			</tr>
			<?php
                $sql_data_query = "SELECT narudzbe.*, korisnici.`username`, korisnici.`ime_prezime` FROM narudzbe
									INNER JOIN korisnici
									ON narudzbe.`korisnik_id` = korisnici.`id`
									 AND status IN ('u tijeku', 'na dostavi')";
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
								<td>".$row_data['ime_prezime']."<i> (".$row_data['username'].")</i></td>
								<td>".$row_data['mjesto']."</td>
								<td>u ".$row_data['vrijeme']." sati</td>
								<td>".implode(", ", $stvari_lista)."</td>
								<td>".$row_data['status']."</td>
								<td>".$row_data['nacin_placanja']."</td>
								<td>".$row_data['cijena']." KN</td>
								<td>
									<form class='form-horizontal' method='POST' action='".htmlspecialchars($_SERVER["PHP_SELF"])."'>
										<input type='hidden' name='id_narudzbe' value='".$row_data['id']."'>
										".($row_data['status'] == 'u tijeku' ? '<button class="btn btn-default disabled">Čeka se potvrda korisnika</button>' : '<button type="submit" class="btn btn-success">Prihvati na stanje</button>')."		
									</form>
								</td>
							</tr>";					
				}
			?>
		</table>

		<hr>

		<h2>List of completed orders of all users</h2>
		<table class="table table-bordered table-stripped">
			<tr class="text-center">
				<td>ID</td>
				<td>Name of user</td>
				<td>Place</td>
				<td>Time</td>
				<td>Stuff list</td>
				<td>Status</td>
				<td>Way of paying</td>
				<td>Price</td>
			</tr>
			<?php
                $sql_data_query = "SELECT narudzbe.*, korisnici.`username`, korisnici.`ime_prezime` FROM narudzbe
									INNER JOIN korisnici
									ON narudzbe.`korisnik_id` = korisnici.`id`
									 AND status = 'na stanju'";
                $sql_data_result = mysqli_query($conn, $sql_data_query);
                $ukupna_cijena = 0;
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
								<td>".$row_data['ime_prezime']."<i> (".$row_data['username'].")</i></td>
								<td>".$row_data['mjesto']."</td>
								<td>u ".$row_data['vrijeme']." sati</td>
								<td>".implode(", ", $stvari_lista)."</td>
								<td>".$row_data['status']."</td>
								<td>".$row_data['nacin_placanja']."</td>
								<td>".$row_data['cijena']." KN</td>
							</tr>";		

							$ukupna_cijena += $row_data['cijena'];			
				}
			?>
		</table>
		<h4 class="text-center">Total income of all deliveries: <b><?php echo $ukupna_cijena; ?></b> KN</h4>

<?php
	include "footer.php";
?>
