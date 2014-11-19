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

  if(isset($_POST['boot_speichern'])){

    $name = $_POST['name_txt'];
    $kategorie = $_POST['kategorie_slc'];
    // Formular-Eingabe überprüfen

    if($name == "" || $kategorie == "" ){
      echo "Bitte einen Namen eingeben";
    }else{
    	if($kategorie == "Leistungssport"){
        $kategorie = 1;

      } 
    $sql =  "INSERT INTO boot (b_name, kategorie_kategorie_id, schaden)";
    $sql .= "VALUES ('".$_POST["name_txt"]."', '$kategorie', '0')";

      mysql_query($sql, $connection);
      

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
            <li> <a href="index.php">Logbuch</a></li>
            <li><a href="#about">Statistik</a></li>
            <li class="active"><a href="admin.php">Admin</a></li>
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
          <a href="#" class="list-group-item">Benutzerverwaltung</a>
          <a href="#" class="list-group-item">Reservationenverwalten</a>
          <a href="#" class="list-group-item active">Bootsverwaltung</a>
          <a href="#" class="list-group-item">Bootsschaden verwalten</a>
        </div>
      </div><!--Seiten-Inhaltsverzeichnis -->

      <!-- Hauptinhalt - Rechts -->
      <div class="col-xs-12 col-sm-9">
        <p class="pull-right visible-xs">
          <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">
            Toggle nav
          </button>
        </p>



<!-- Button to trigger modal --> 
    <a href="#myModal" role="button" class="btn btn-default btn-sm" data-toggle="modal"> <span class="glyphicon glyphicon-plus"></span> Boot hinzufügen</a>
<br></br>
    <!-- Modal -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Boot erstellen</h4>
   </div>
    <div class="modal-body">


          <form class="form-horizontal" id="boot_form" name="commentform" method="post" action="admin_boot.php">
            <div class="form-group">

             <label class="control-label col-md-4" for="name">Name</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="name_txt" name="name_txt" placeholder="Name"/>
              </div>
            </div>
          

            <div class="form-group">
              <label class="control-label col-md-4" for="kategorie_slc">Kategorie</label>
                <div class="col-md-6">           
                  <select name="kategorie_slc" size="5" class="form-control">
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
                <input type="submit" name="boot_speichern" class="btn btn-primary btn-xs">
              </div>
            </div>
          </form>
        
      </div><!-- End of Modal body -->
    </div><!-- End of Modal content -->
  </div><!-- End of Modal dialog -->
</div><!-- End of Modal -->


        <!-- Bereits enthaltene Mitglieder in Tabelle anzeigen -->

        <table class="table table-striped">
        <tr> <td><b> Name </b></td> <td><b> Kategorie </b></td> <td><b> Löschen </b></td></tr>
        <?php
          $auswahl_sql = "SELECT * FROM boot";
          $boot = mysql_query($auswahl_sql);
     
          while($row = mysql_fetch_array($boot)){
            echo"<tr>";
            echo "<td>" . $row['b_name'] . "</td>";
            echo "<td>" . $row['kategorie_kategorie_id'] . "</td>";
            echo "<td>" . $row['boot_id']."<a href='delete.php?boot_id=".$row['boot_id']."'><span class='glyphicon glyphicon-fire'></span></a></td>";
            echo "</tr>";
           }
        ?>
        </table>
        
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


  

  </body>
</html>
