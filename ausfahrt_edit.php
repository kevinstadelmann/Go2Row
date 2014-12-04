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

    <!-- Bootstrap Vailidator -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css" rel="stylesheet"/>


    <!-- Custom styles for this template -->
    <link href="offcanvas.css" rel="stylesheet">
    <link href="css/inputosaurus.css" rel="stylesheet">
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

   // Form initialsieren
   $edit_sql = mysql_query("SELECT * FROM m_ausfahrt WHERE m_ausfahrt_id='".mysql_real_escape_string($_GET['id'])."'");
   $edit_array = mysql_fetch_array($edit_sql);
   
   // Wenn Speichern Button gedrück wird - Ausfahrt updaten
   if(isset($_POST['ausfahrt_updaten'])){
    $abfahrt = $_POST['abfahrt_txt'] . ":00";
    $ankunft = $_POST['ankunft_txt'] . ":00";

    // Ausfahrt mit den Änderungen speichern
    $sql = "UPDATE `m_ausfahrt` SET `datum`='".$_POST["datum_txt"]."',`mitglied_id`='".$_POST["mannschaft_txt"]."',`steuermann`='".$_POST["steuermann_txt"]."',`km`='".$_POST["km_txt"]."',`ruderziel`='".$_POST["ruderziel_txt"]."',`abfahrt`='$abfahrt',`ankunft`='$ankunft',`bemerkung`='".$_POST["bemerkung_txt"]."',`boot_boot_id`='".$_POST["boot_txt"]."' WHERE `m_ausfahrt_id`=".$edit_array['m_ausfahrt_id'];

    mysql_query($sql, $connection);
    //header("Location: index.php");
  }
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
            <li class="active"><a href="index.php">Logbuch</a></li>
            <li><a href="statistik.php">Statistik</a></li>
            <li><a href="admin_mitglied.php">Admin</a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

  <!-- HAUPTINHALT -->
  <div class="container">
    <div class="row">
      <!-- Seiten-Inhaltsverzeichnis -->
      <div class="col-sm-3" id="sidebar" role="navigation">
        <div class="list-group">
          <a href="admin_mitglied.php" class="list-group-item active">Benutzerverwaltung</a>
          <a href="#" class="list-group-item">Reservationenverwalten</a>
          <a href="admin_boot.php" class="list-group-item">Bootsverwaltung</a>
          <a href="#" class="list-group-item">Bootsschaden verwalten</a>
          <p>
          Filter Möglichkeiten
          Kalender
          Nicht Abgeschlossene Ausfahrten auf einen Blick
          Reservationen auf einen Blick
          Suche nach Ausfahrten
        </p>
        </div>
      </div><!--Seiten-Inhaltsverzeichnis -->

      <!-- Hauptinhalt - Rechts -->
      <div class="col-xs-12 col-sm-9">
        <p class="pull-right visible-xs">
          <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">
            Toggle nav
          </button>
        </p>

      <div class="panel panel-primary">
        <div class="panel-heading">Ausfahrt bearbeiten</div>
          <div class="panel-body">
            
            <form class="form-horizontal" id="ausfahrt_bearb" name="commentform" method="post">
            <div class="form-group">

             <label class="control-label col-md-4" for="name">Datum</label>
              <div class="col-md-6">
                <input type="text" value="<?php echo $edit_array['datum']; ?>" class="form-control" id="datum_txt" name="datum_txt" placeholder="Datum"/>
              </div>
            </div>
          
            <div class="form-group">
              <label class="control-label col-md-4" for="vorname_txt">Boot</label>
                <div class="col-md-6">
                  <input type='text' value="<?php echo $edit_array['boot_boot_id']; ?>" class='form-control' id='boot_txt' name='boot_txt'/>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="vorname_txt">Steuermann</label>
                <div class="col-md-6">
                  <input type='text' value="<?php echo $edit_array['steuermann']; ?>" class='form-control' id='steuermann_txt' name='steuermann_txt'/>
                </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-md-4" for="vorname_txt">Mannschaft</label>
                <div class="col-md-6">
                  <input type='text' value="<?php echo $edit_array['mitglied_id']; ?>" class='form-control' id='mannschaft_txt' name='mannschaft_txt'/>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="vorname_txt">Kilometer</label>
                <div class="col-md-6">
                  <input type='text' value="<?php echo $edit_array['km']; ?>" class='form-control' id='km_txt' name='km_txt'/>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="vorname_txt">Ruderziel</label>
                <div class="col-md-6">
                  <input type='text' value="<?php echo $edit_array['ruderziel']; ?>" class='form-control' id='ruderziel_txt' name='ruderziel_txt'/>
                </div>
            </div>
 
            <div class="form-group">
              <label class="control-label col-md-4" for="vorname_txt">Abfahrt</label>
                <div class="col-md-6">
                  <input type='text' value="<?php echo $edit_array['abfahrt']; ?>" class='form-control' id='abfahrt_txt' name='abfahrt_txt'/>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="vorname_txt">Ankunft</label>
                <div class="col-md-6">
                  <input type='text' value="<?php echo $edit_array['ankunft']; ?>" class='form-control' id='ankunft_txt' name='ankunft_txt'/>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="vorname_txt">Bemerkung</label>
                <div class="col-md-6">
                  <input type='text' value="<?php echo $edit_array['bemerkung']; ?>" class='form-control' id='bemerkung_txt' name='bemerkung_txt'/>
                </div>
            </div>

            <div class="form-group">
              <div class="col-md-6">
                <input type="submit" value="Abschliessen" name="ausfahrt_updaten" class="btn btn-primary btn-xs">
              </div>
            </div>
          </form>

          </div>
      </div>



        
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

    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/js/bootstrapValidator.min.js" type="text/javascript"></script>

    <script>

</script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

    <script src="offcanvas.js"></script>
    <!-- Eigene Javascript Datei zum überprüfen der Formulardaten -->
    <script src="frames/validation.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
    <script src="js/inputosaurus.js"></script>


  

  </body>
</html>