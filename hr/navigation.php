<?php

echo "<nav class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
      <div class='container'>
        <div class='navbar-header'>
          <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar' aria-expanded='false' aria-controls='navbar'>
            <span class='sr-only'>Toggle navigation</span>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
          </button>
          <a class='navbar-brand' href='index.php'>Save my stuff</a>
        </div>";

    if(isset($_SESSION['username'])){
        echo    "<div id='navbar' class='navbar-collapse collapse white'>
            	<span class='pull-right'>Pozdrav ".$_SESSION['username']."

                <a href='moj_panel.php'>
                    <button class='btn btn-info'>Moj panel</button>
                </a>
            	<a href='logout.php'>
    				<button class='btn btn-default'>Odjava</button>
    			</a>
                <a href='".str_replace("hr", "eng", $_SERVER['REQUEST_URI'])."' id='language_pick'>
                    <button class='btn btn-warning'>English</button>
                </a>
    			</span>
            </div>";
        }
    else{
        echo    "<div id='navbar' class='navbar-collapse collapse white'>
                <span class='pull-right'>
                    <a href='register.php'>
                        <button class='btn btn-success'>Registracija</button>
                    </a>
                    <a href='login.php'>
                        <button class='btn btn-success'>Prijava</button>
                    </a>
                    <a href='".str_replace("hr", "eng", $_SERVER['REQUEST_URI'])."' id='language_pick'>
                    <button class='btn btn-warning'>English</button>
                </a>
                </span>
            </div>";    
    }

echo"   </div>
    </nav>";
?>