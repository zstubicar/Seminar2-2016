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


	include "header.php";
	include "navigation.php";
?>

    <div class="container">
      <!-- Example row of columns -->
      	<h2>List of things of all users</h2>
		<table class="table table-bordered table-stripped">
			<tr class="text-center">
				<td>ID</td>
				<td>User name</td>
				<td>Name</td>
				<td>Picture</td>
				<td>Dimension</td>
				<td>Fragile</td>
				<td>Weight</td>
				<td>Number of days</td>
			</tr>
			<?php
                $sql_data_query = "SELECT stvari.*, korisnici.`username`, korisnici.`ime_prezime` FROM stvari
									INNER JOIN korisnici
									ON stvari.`korisnik_id` = korisnici.`id`";
                $sql_data_result = mysqli_query($conn, $sql_data_query);
                while($row_data = mysqli_fetch_assoc($sql_data_result)){
						echo "<tr>
								<td>".$row_data['id']."</td>
								<td>".$row_data['ime_prezime']."<i> (".$row_data['username'].")</i></td>
								<td>".$row_data['ime_stvari']."</td>
								<td><img src='../slike_upload/".$row_data['slika']."' class='img-thumbnail small_img' /></td>
								<td>".$row_data['dimenzije']."</td>
								<td>".$row_data['lomljivo']."</td>
								<td>".$row_data['tezina']." KG</td>
								<td>".$row_data['dana']."</td>
							</tr>";
					
				}
			?>
		</table>

<?php
	include "footer.php";
?>
