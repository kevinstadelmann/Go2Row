<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Go2Row</title>

    <!-- Bootstrap core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Vailidator -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css" rel="stylesheet"/>


    <!-- Custom styles for this template -->
    <link href="offcanvas.css" rel="stylesheet">

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

  //echo "Erfolgreich zur Datenbank verbunden!";

  //Dankenbankauswahl
  $db = mysql_select_db($database, $connection);

  if (!$db)
   {
    echo "Konnte die Datenbank nicht auswählen.";
   }

   //var_dump($_POST);

   // Form initialsieren
   $edit_sql = mysql_query("SELECT * FROM boot WHERE boot_id='".mysql_real_escape_string($_GET['id'])."'");
   $edit_array = mysql_fetch_array($edit_sql);
   
   // bearbeitete Daten speichern
   

   if(isset($_POST['boot_updaten'])){
    $kategorie = $_POST['kategorie_slc'];
 
    if($kategorie == "Leistungssport"){
        $kategorie = 1;
    }else{
      $kategorie = 2;
    }

    $sql =  "UPDATE boot ";
    $sql .= "SET b_name='".$_POST["boot_txt"]."',kategorie_kategorie_id=$kategorie ";
    $sql .= "WHERE boot_id=".$edit_array['boot_id'];

    //echo $sql;

    mysql_query($sql, $connection);
    header("Location: admin_boot.php");
   

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
          <a class="navbar-brand" href="index.php">Go2Row</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li> <a href="index.php">Logbuch</a></li>
            <li><a href="statistik.php?name_txt=&name_txt=&jahr_slc=2014&filter_anwenden=">Statistik</a></li>
            <li class="active"><a href="admin_mitglied.php">Admin</a></li>
            <li><a href="help.php">Hilfe</a></li>
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
          <a href="admin_mitglied.php" class="list-group-item">Benutzerverwaltung</a>
<!--           <a href="#" class="list-group-item">Reservationenverwalten</a> -->
          <a href="admin_boot.php" class="list-group-item active">Bootsverwaltung</a>
<!--           <a href="#" class="list-group-item">Bootsschaden verwalten</a> -->

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
        <div class="panel-heading">Boot bearbeiten</div>
          <div class="panel-body">
            
            <form class="form-horizontal" id="mitglied_bearb" name="commentform" method="post">
            <div class="form-group">

             <label class="control-label col-md-4" for="name">Name</label>
              <div class="col-md-6">
                <input type="text" value="<?php echo $edit_array['b_name']; ?>" class="form-control" id="boot_txt" name="boot_txt" placeholder="Name"/>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="kategorie_slc">Kategorie</label>
                <div class="col-md-6">           
                  <select name="kategorie_slc" size="1" class="form-control">
                    <?php
                    $auswahl_sql = "SELECT kategorie FROM kategorie";
                    $kategorie = mysql_query($auswahl_sql);
               
                    while($row = mysql_fetch_array($kategorie)){
                    echo"<option>" . $row['kategorie'] . "</option>";
                    }

                    ?>
                  </select>
                </div>
            </div>

            <div class="form-group">
              <div class="col-md-6">
                <input type="submit" value="Speichern" name="boot_updaten" class="btn btn-primary btn-xs">
              </div>
            </div>
          </form>

          </div>
      </div>



        
      </div> <!-- Hauptinhalt - Rechts -->
    </div> <!-- row -->

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


  

  </body>
</html>
