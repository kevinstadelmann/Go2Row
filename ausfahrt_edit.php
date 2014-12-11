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

//  echo "Erfolgreich zur Datenbank verbunden!";

  //Dankenbankauswahl
  $db = mysql_select_db($database, $connection);

  if (!$db)
   {
    echo "Konnte die Datenbank nicht auswählen.";
   }

//   var_dump($_POST);

   // Form initialsieren mit Basis Werten
   $edit_sql = mysql_query("SELECT * FROM m_ausfahrt WHERE m_ausfahrt_id='".mysql_real_escape_string($_GET['id'])."'");
   $edit_array = mysql_fetch_array($edit_sql);

   // Wenn Speichern Button gedrück wird - Ausfahrt updaten
   if(isset($_POST['ausfahrt_updaten'])){
    $abfahrt = $_POST['abfahrt_txt'] . ":00";
    $ankunft = $_POST['ankunft_txt'] . ":00";

    // Steuermann_id abfragen
    $steuermann = explode(" ", $_POST['steuermann_txt']);
    $steuermann_sqlid = mysql_query("SELECT `mitglied_id` FROM `mitglied` WHERE ( name = '$steuermann[0]') AND ( vorname = '$steuermann[1]' )");
    $steuermann_id = mysql_result($steuermann_sqlid, 0);

    //Boot_id abfragen
    $boot = $_POST['boot_txt'];
    $boot_result = mysql_query("SELECT `boot_id` FROM `boot` WHERE `b_name` = '$boot'");
    $boot_id = mysql_result($boot_result, 0);

    // Ausfahrt mit den Änderungen speichern
    $sql = "UPDATE `m_ausfahrt` SET `datum`='".$_POST["datum_txt"]."',`steuermann`='$steuermann_id',`km`='".$_POST["km_txt"]."',`ruderziel`='".$_POST["ruderziel_txt"]."',`abfahrt`='$abfahrt',`ankunft`='$ankunft',`bemerkung`='".$_POST["bemerkung_txt"]."',`boot_boot_id`='$boot_id' WHERE `m_ausfahrt_id`=".$edit_array['m_ausfahrt_id'];

    mysql_query($sql, $connection);
    //header("Location: index.php");

    // Die Eingabe der Mannschaft in ein Array splitten
    //$last_insert = mysql_insert_id();
    $ms_array = explode(",", $_POST['mannschaft_txt']);

    // Mannschaft der entsprechenden Ausfahrt löschen
    $ms_delete_sql = mysql_query("DELETE FROM `mitglied_has_m_ausfahrt` WHERE `m_ausfahrt_m_ausfahrt_id`='" . $edit_array['m_ausfahrt_id'] . "'");
    
    // Jedes Mitglied der Ausfahrt neu in die Zwischentabelle speichern    
    foreach($ms_array as $ms_string) {
         $ms_result = mysql_query("SELECT mitglied_id FROM mitglied WHERE (concat(name, ' ', vorname)) = '$ms_string'");
         $ms_id = mysql_result($ms_result, 0);
         echo $ms_id;
         $ms_sql =  "INSERT INTO `mitglied_has_m_ausfahrt` (`mitglied_mitglied_id`, `m_ausfahrt_m_ausfahrt_id`)";
         $ms_sql .= "VALUES ('$ms_id', '" . $edit_array['m_ausfahrt_id'] . "')";
         mysql_query($ms_sql,$connection);
    }
    header("Location: index.php");
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
          <a class="navbar-brand" href="index.php">Go2Row</a>
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
          <a href="index.php" class="list-group-item active">Zurück</a>
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
              <label class="control-label col-md-4" for="boot_txt">Boot</label>
                <div class="col-md-6">
                  <input type='text' value=
                  "<?php 
                  // Bootsname abfragen
                  $edit_boot_sql = mysql_query("SELECT b_name FROM boot WHERE boot_id='" . $edit_array['boot_boot_id'] . "'");
                  $edit_boot = mysql_fetch_array($edit_boot_sql);
                  echo $edit_boot['b_name']; 
                  ?>" 
                  div class='form-control' id='boot_txt' name='boot_txt'/>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="steuermann_txt">Steuermann</label>
                <div class="col-md-6">
                  <input type='text' value=
                  "<?php 
                  // Steuernmann abfragen
                  $edit_sm_sql = mysql_query("SELECT (concat(name, ' ', vorname)) AS name_vorname FROM mitglied WHERE mitglied_id = '" . $edit_array['steuermann'] . "'");
                  $edit_sm = mysql_fetch_array($edit_sm_sql);
                  echo $edit_sm['name_vorname']; 
                  ?>"  
                  div class='form-control' id='steuermann_txt' name='steuermann_txt'/>
                </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-md-4" for="mannschaft_txt">Mannschaft</label>
                <div class="col-md-6">
                  <input type='text' value=
                  "<?php 
                  // Mannschaft abfragen
                  $id_abfrage = "SELECT `mitglied_mitglied_id` FROM `mitglied_has_m_ausfahrt` WHERE `m_ausfahrt_m_ausfahrt_id` = '" . $edit_array['m_ausfahrt_id'] . "'";
                  $id_abfrage_result = mysql_query($id_abfrage);
                  while ($id = mysql_fetch_array($id_abfrage_result)) {
                    $ms_sql = "SELECT (concat(name, ' ', vorname)) AS name_vorname FROM mitglied WHERE mitglied_id = '" . $id['mitglied_mitglied_id'] . "'";
                    $ms_result = mysql_query($ms_sql);
                    while($ms = mysql_fetch_array($ms_result)){
                      echo $ms['name_vorname'];
                      echo ",";
                }
            }
                  ?>"

                  div class='form-control' id='mannschaft_txt' name='mannschaft_txt'/>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="km_txt">Kilometer</label>
                <div class="col-md-6">
                  <input type='text' value="<?php 
                  if($edit_array['km'] != '0'){
                    echo $edit_array['km']; 
                  }
                  ?>" class='form-control' id='km_txt' name='km_txt' placeholder="KM eintragen"/>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="ruderziel_txt">Ruderziel</label>
                <div class="col-md-6">
                  <input type='text' value="<?php echo $edit_array['ruderziel']; ?>" class='form-control' id='ruderziel_txt' name='ruderziel_txt' placeholder="Ruderziel eintragen"/>
                </div>
            </div>
 
            <div class="form-group">
              <label class="control-label col-md-4" for="abfahrt_txt">Abfahrt</label>
                <div class="col-md-6">
                  <input type='text' value=
                  "<?php 
                  if($edit_array['abfahrt'] != '00:00:00'){
                    $abfahrt = explode(":", $edit_array['abfahrt']);
                    echo "" . $abfahrt[0] . ":" . $abfahrt[1] . "";
                  }
                  ?>" 
                  class='form-control' id='abfahrt_txt' name='abfahrt_txt' placeholder="hh:mm"/>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="ankunft_txt">Ankunft</label>
                <div class="col-md-6">
                  <input type='text' value="" class='form-control' id='ankunft_txt' name='ankunft_txt' placeholder="hh:mm"/>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="bemerkung_txt">Bemerkung</label>
                <div class="col-md-6">
                  <input type='text' value="<?php echo $edit_array['bemerkung']; ?>" class='form-control' id='bemerkung_txt' name='bemerkung_txt' placeholder="Bemerkung eintragen"/>
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


<!-- Autocomplete Boot -->
  
<?php
  $auswahl_sql = "SELECT b_name FROM boot";
  $boot = mysql_query($auswahl_sql);
     
  $array = array();
  while($row = mysql_fetch_array($boot)){
    array_push($array, $row['b_name']);
  }
?>

<script>
    $('#boot_txt').inputosaurus({
      width : '270px',
      autoCompleteSource : <?php print(json_encode($array)); ?>,
      activateFinalResult : true,
      change : function(ev){
        $('#widget2_reflect').val(ev.target.value);
      }
    });

    $('.form-control').on('click', 'a', function(ev){ $(ev.currentTarget).next('div').toggle(); });

    prettyPrint();
</script>


<!-- Autocomplete Steuermann -->

<?php
  $auswahl_sql = "SELECT name, vorname FROM mitglied";
  $boot = mysql_query($auswahl_sql);
     
  $array = array();
  while($row = mysql_fetch_array($boot)){
    array_push($array, $row['name'] . " " . $row['vorname']);
  }
?>

<script>
    $('#steuermann_txt').inputosaurus({
      width : '270px',
      autoCompleteSource : <?php print(json_encode($array)); ?>,
      activateFinalResult : true,
      change : function(ev){
        $('#widget2_reflect').val(ev.target.value);
      }
    });

    $('.form-control').on('click', 'a', function(ev){ $(ev.currentTarget).next('div').toggle(); });

    prettyPrint();
</script>


<!-- Autocomplete Mannschaft -->

<?php
  $auswahl_sql = "SELECT name, vorname FROM mitglied";
  $boot = mysql_query($auswahl_sql);
     
  $array = array();
  while($row = mysql_fetch_array($boot)){
    array_push($array, $row['name'] . " " . $row['vorname']);
  }
?>

<script>
    $('#mannschaft_txt').inputosaurus({
      width : '270px',
      autoCompleteSource : <?php print(json_encode($array)); ?>,
      activateFinalResult : true,
      change : function(ev){
        $('#widget2_reflect').val(ev.target.value);
      }
    });

    $('.form-control').on('click', 'a', function(ev){ $(ev.currentTarget).next('div').toggle(); });

    prettyPrint();
</script>
  

  </body>
</html>