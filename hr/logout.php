<?php
	session_start();
	session_destroy();
	
	echo "<script>
				alert('Odlogirani ste.')
				window.location = 'index.php';
		   </script>";	
?>