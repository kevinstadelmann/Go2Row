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

  
if(isset($_POST['test'])){



}




  if(isset($_POST['ausfahrt_speichern'])){

    $boot = $_POST['datum_txt'];
    echo $boot;
    // Formular-Eingabe überprüfen
    if($boot == ""){
    }else{

    $sql =  "INSERT INTO m_ausfahrt (datum, steuermann, km, ruderziel, abfahrt, ankunft, bemerkung, boot_boot_id)";
    $sql .= "VALUES ('".$_POST["datum_txt"]."','".$_POST["steuermann_txt"]."','".$_POST["km_txt"]."','".$_POST["ruderziel_txt"]."','".$_POST["abfahrt_txt"]."','".$_POST["ankunft_txt"]."', '".$_POST["bemerkung_lst"]."','".$_POST["boot_txt"]."')";

      mysql_query($sql,$connection);
    }
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
            <li class="active"><a href="#">Logbuch</a></li>
            <li><a href="#about">Statistik</a></li>
            <li><a href="admin.php">Admin</a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

  <!-- HAUPTINHALT -->
  <div class="container">
    <div class="row">
      <!-- Seiten-Inhaltsverzeichnis
      <div class="col-sm-3" id="sidebar" role="navigation">
        <div class="list-group">
          <a href="#" class="list-group-item active">Link</a>
          <a href="#" class="list-group-item">Link</a>
          <a href="#" class="list-group-item">Link</a>
          <a href="#" class="list-group-item">Link</a>
          <p>
          Filter Möglichkeiten
          Kalender
          Nicht Abgeschlossene Ausfahrten auf einen Blick
          Reservationen auf einen Blick
          Suche nach Ausfahrten
        </p>
        </div>
      </div><!--Seiten-Inhaltsverzeichnis 
    -->
      <!-- Hauptinhalt - Rechts -->
      <div class="col-xs-12 col-sm-9">
        <p class="pull-right visible-xs">
          <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">
            Toggle nav
          </button>
        </p>

        <!-- Jumbotron -->
        <div class="jumbotron">
          <h1>Seeclub Luzern</h1>
          <p>Am 01.10.2014 wurden 199km gerudert</p>
        </div

        <!-- Large modal - Fenster das aufpopt -->
        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target=".bs-example-modal-lg">
            <span class="glyphicon glyphicon-plus"></span>Ausfahrt hinzufügen
        </button>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <!-- Ausfahrt eintragen Formular -->
                Hier Formular aufbauen
                 <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <div class="col-md-6">
                        <form name="Ausfahrt_Formular" method="post">
                          <div class="input-group">
                            <input type="text" name="name_txt" class="form-control" placeholder="Name">
                            <div class="input-group-addon">
                              <button type="input" name="add_name" class="btn btn-primary btn-xs">
                                <span class="glyphicon glyphicon-plus"></span>
                              </button>
                            </div>                   
                          </div>
                          Boot
                          <input name="boot_txt" type="text" class="form-control" placeholder="Boot">
                          Mannschaft
                          <select multiple class="form-control">
                            <?php
                            // Ausfahrt Eintragen Formular in DB schreiben
                            if(isset($_POST['add_name'])){
                              $name = $_POST['name_txt'];
                              // Überprüfen ob Name in Mitglieder Tabelle vorhanden
                              echo "<option>$name</option>";
                            }
                              ?>
                          </select>
                          <input name="datum_txt" type="text" class="form-control" placeholder="Datum">
                          <input name="steuermann_txt" type="text" class="form-control" placeholder="Steuermann/frau">

                          Zeit
                          <input name="abfahrt_txt" type="text" class="form-control" placeholder="Abfahrtszeit hh:mm">
                          <input name="ankunft_txt" type="text" class="form-control" placeholder="Ankunftszeit hh:mm">

                          Statistik
                          <input name="ruderziel_txt" type="text" class="form-control" placeholder="Ruderziel">
                          <input name="km_txt" type="text" class="form-control" placeholder="KM">

                          Bemerkung
                          <textarea name="bemerkung_lst" class="form-control" rows="3"></textarea>
                          <input type="submit" name="ausfahrt_speichern" class="btn btn-primary btn-xs">

                        </form>
                      </div> <!-- col-md-6 -->
                    </div> <!-- form group -->
                  </div> <!-- col-md-8 -->
                </div> <!-- row -->
            </div>
          </div>
        </div>

        <!-- Colapse 1-3 -->
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <!-- Colapse 1 -->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Reservationen
              </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <!-- Colapse 1 - Inhalt -->
              <div class="panel-body">
                <table class="table table-striped">
                  <tr class="danger">
                    <td>Boot</td>
                    <td>Datum</td>
                  </tr>
                </table>
              </div><!-- Colapse 1 - Inhalt -->
            </div>
          </div> <!-- Colapse 1 --> 

          <!-- Colapse 2 -->    
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
              <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Aktuelle Ausfahrten
                <span class="badge">14</span> 
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
              <!-- Colapse 2 - Inhalt -->
              <div class="panel-body">
                <table class="table table-striped">
                  <tr class="warning">
                    <td>Kevin</td>
                    <td>10km</td>
                  </tr>
                </table>
              </div><!-- Colapse 2 - Inhalt -->
            </div>
          </div><!-- Colapse 2 -->

          <!-- Colapse 3 -->
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
              <h4 class="panel-title">
              <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Abgeschlossene Ausfahrten
              </a>
              </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
              <!-- Colapse 3 - Inhalt -->
              <div class="panel-body">
                <table class="table table-striped">
                  <tr class="success">
                   </tr>

                </table>
              </div><!-- Colapse 3 - Inhalt -->
            </div>
          </div> <!-- Colapse 3 -->
        </div> <!-- Colapse 1-3 -->
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

    <!-- Kalender -->
    <script src="dhtmlxcalendar.js"></script>  
  

  </body>
</html>
