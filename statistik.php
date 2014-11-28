<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>go2row</title>

    <!-- Bootstrap core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="offcanvas.css" rel="stylesheet">
    <link href="bower_components/bootstrap/dist/css/inputosaurus.css" rel="stylesheet">
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/cupertino/jquery-ui.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script><style type="text/css"></style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

<?php
  //Datenbankverbindung
  $server = "localhost";
  $database = "go2row";
  $user = "root";
  $pw = "123";

  $connection = mysql_connect($server, $user, $pw);

  if (!$connection)
   {
     die("Konnte die Datenbank nicht öffnen.
         Fehlermeldung: ". mysql_error());
   }

  echo "Erfolgreich zur Datenbank verbunden!";

  //Dankenbankauswahl
  $db = mysql_select_db($database, $connection);

  if (!$db)
   {
    echo "Konnte die Datenbank nicht auswählen.";
   }

   var_dump($_POST);
  
  if(isset($_POST['ausfahrt_speichern'])){

    $datum = date("20y-m-d");
    $abfahrt = $_POST['abfahrt_txt'] . ":00";
    $abfahrt = $_POST['ankunft_txt'] . ":00";

    $sql =  "INSERT INTO `m_ausfahrt` (`m_ausfahrt_id`, `datum`, `mitglied_id`, `steuermann`, `km`, `ruderziel`, `abfahrt`, `ankunft`, `bemerkung`, `boot_boot_id`)";
    $sql .= "VALUES (NULL, '$datum', '0', '".$_POST["name_txt"]."', '".$_POST["km_txt"]."', '".$_POST["ruderziel_txt"]."', '".$_POST["abfahrt_txt"]."', '".$_POST["ankunft_txt"]."', '".$_POST["bemerkung_txt"]."', '44')";


      mysql_query($sql,$connection);
  }


  //mysql_close($connection);

?>    
  <!-- NAVIGATION -->
  <nav class="navbar navbar-default navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <!-- drei Striche wenn Fenster verkleinert wird für Navigation-->
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Go2Row</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Logbuch</a></li>
            <li class="active"><a href="statistik.php">Statistik</a></li>
            <li><a href="admin_mitglied.php">Admin</a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

  <!-- HAUPTINHALT -->
  <div class="container">
    <div class="row">
   
      <!-- Hauptinhalt - Rechts -->
        <div class="panel panel-primary">
          <div class="panel-heading">
            Statistik
          </div>
          Hier sollten mal Statistiken angezeigt werden...
          Sehr guet
          
          <?php
          echo " ";
          $str = "Aathi, Kevin, Janik";
          $arr = explode(',', $str);

          echo $arr[0];
          echo $arr[1];
          echo $arr[2];
          ?>

          <canvas id="buyers" width="600" height="400"></canvas>



      </div> <!-- Hauptinhalt - Rechts -->
    </div> <!-- row -->
    <footer>
      <p>© Company 2014</p>
    </footer>
  </div> <!-- container-->



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

    <script src="offcanvas.js"></script>

    <!-- Eigene Javascript Datei zum überprüfen der Formulardaten -->
    <script src="frames/validation.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
  
     <script src="bower_components/bootstrap/js/inputosaurus.js"></script>

     <script src="chart.min.js"></script>

     <!-- Statistik Javascript -->
     <script>
     var buyers = document.getElementById('buyers').getContext('2d');
    new Chart(buyers).Line(buyerData);
    var buyerData = {
      labels : ["January","February","March","April","May","June"],
      datasets : [
    {
      fillColor : "rgba(172,194,132,0.4)",
      strokeColor : "#ACC26D",
      pointColor : "#fff",
      pointStrokeColor : "#9DB86D",
      data : [203,156,99,251,305,247]
    }
  ]
}



     </script>

  </body>
</html>
