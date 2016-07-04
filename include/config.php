<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'initializr2';

$conn = mysqli_connect($host, $username, $password, $database) or die('Ne mogu se povezati s bazom!');
mysqli_set_charset($conn, "utf8");
date_default_timezone_set('Europe/Zagreb');

// za podatke
function clean_input($conn, $data) {
  $data = htmlspecialchars($data);
  $data = mysqli_real_escape_string($conn, $data);
  return $data;
}

// za lozinke
function escape($conn, $data) {
  $data = mysqli_real_escape_string($conn, $data);
  return $data;
}

// admin-user ovlasti
function ovlasti($conn){
    $sql_ovlasti = "SELECT ovlasti FROM korisnici WHERE id = ".clean_input($conn, $_SESSION['id'])."";
    $sql_ovlasti_result = mysqli_query($conn, $sql_ovlasti);
    $data_user = mysqli_fetch_assoc($sql_ovlasti_result);

    return $data_user['ovlasti'];
}

function convert_multi_array($arrays){
	$imploded = array();
	foreach($arrays as $array) {
		$imploded[] = implode(', ', $array);
	}
	
	return implode(", ", $imploded);
}
?>