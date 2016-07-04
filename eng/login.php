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
		$lozinka = sha1(escape($conn, $_POST['lozinka']));	

		$sql_query = "SELECT * FROM korisnici WHERE username = '".$username."' AND lozinka = '".$lozinka."'";
		$sql_result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));
		$row_data = mysqli_fetch_assoc($sql_result);
        $sql_count = mysqli_num_rows($sql_result);

		if ($sql_count > 0){
				$_SESSION['username'] = $row_data['username'];
				$_SESSION['id'] = $row_data['id'];
				echo "<script>
						alert('Uspjesno ste ulogirani.')
						window.location = '/Seminar2-2016/hr/moj_panel.php';
					 </script>";			  
				die;			
		}
		else {
			echo "<script>
					alert('Krivo korisnicko ime ili lozinka!')
					window.location = '/Seminar2-2016/hr/login.php';
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

				<!-- Password input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="lozinka">Password</label>
				  <div class="col-md-4">
				    <input id="lozinka" name="lozinka" placeholder="Lozinka" class="form-control input-md" required="" type="password">
				    
				  </div>
				</div>


				<button type="submit" class="btn btn-primary">Submit</button>
				<button type="reset" class="btn btn-danger">Reset</button>
				</form>

<?php
    include "footer.php";
?>
