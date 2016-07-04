<?php
session_start();
  require_once "../include/config.php";

    include "header.php";
    include "navigation.php";
?>

    <!-- Main jumbotron for a primary marketing message or call to action -->

    <div class="jumbotron main">
      <div class="container">
        <h1>Dobro došli na mjesto koje štedi vaš prostor!</h1>
        <p>Ovo je stranica za jednostavnu i učinkovitu pohranu vaših privatnih stvari. Ovdje jednostavno i brzo možete pohraniti stvari koje trenutno ne koristitite na sigurno mjesto. Mi ćemo pokupiti vaše stvari i dostaviti ih na naše skaladište. Povoljno, jednostavno, brzo, učinkovito. Mi smo ovdje za vas.</p>
        <p><a class="btn btn-primary btn-lg" href="register.php" role="button">Pridružite nam se ovdje &raquo;</a></p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Jonh Doe1</h2>
          <p>Odličan alat! Uživam ga koristi. Stvara mi toliko prostora, i tako je jednostavan za korištenje. </p>
          <!-- <p><a clasDoe1s="btn btn-default" href="#" role="button">View details &raquo;</a></p> -->
        </div>
        <div class="col-md-4">
          <h2>Jonh Doe2</h2>
          <p>Ja sam forotraf.. Veliki app. Neki drugi probni tekst koji se može zamijeniti s nečim. </p>

       </div>
        <div class="col-md-4">
          <h2>Jonh Doe3</h2><!-- 
          <p><img src="img/jonh doe3.jpg" class=".img-circle .img-responsive"> </p> -->
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        </div>
      </div>

      <hr>

<?php
  include "footer.php";
?>
