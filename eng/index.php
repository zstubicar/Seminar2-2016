<?php
session_start();
  require_once "../include/config.php";

    include "header.php";
    include "navigation.php";
?>

    <!-- Main jumbotron for a primary marketing message or call to action -->

    <div class="jumbotron main">
      <div class="container">
        <h1>Welcome to the place that save your space!</h1>
        <p>This is a site for a simple and effective storage of your privat possesions. Here u can easily and quickly store stuff that you dont need at the moement at your place. We pick your stuff and storage them to our wharehouses. Cheep, easy, quick, effective. We are here for YOU.</p>
        <p><a class="btn btn-primary btn-lg" href="register.php" role="button">Join us here! &raquo;</a></p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Jonh Doe1</h2>
          <p>Rly a great tool! i enjoy useing it. Saves me so many space, and so easy to use. </p>
          <!-- <p><a clasDoe1s="btn btn-default" href="#" role="button">View details &raquo;</a></p> -->
        </div>
        <div class="col-md-4">
          <h2>Jonh Doe2</h2>
          <p>I'm a paragraph. Great app. Some other dummy text that can be replaced whit anything. </p>
       </div>
        <div class="col-md-4">
          <h2>Jonh Doe3</h2>
          <!-- <p><img src="" class=".img-circle .img-responsive"> </p> -->
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        </div>
      </div>

      <hr>

<?php
  include "footer.php";
?>
