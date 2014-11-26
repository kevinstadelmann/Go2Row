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

            <script language="javascript" type="text/javascript">
              var d = new Date();
              var datum = d.getDate()+"."+d.getMonth()+"."+(d.getYear()+1900);
              $.post('index.php', {variable: datum});
            </script>

    
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
    
      <!-- Hauptinhalt - Rechts -->
      <div class="col-xs-12 col-sm-9">
        <p class="pull-right visible-xs">
          <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">
            Toggle nav
          </button>
        </p>

        <!-- Jumbotron
        <div class="jumbotron">
          <h1>Seeclub Luzern</h1>
          <p>Am 
            <script language="javascript" type="text/javascript">
              var d = new Date();
              document.write(d.getDate()+"."+d.getMonth()+"."+(d.getYear()+1900));
            </script>
          wurden 199km gerudert</p>
        </div
      -->


<!-- Button to trigger modal --> 
    <a href="#myModal" role="button" class="btn btn-default btn-sm" data-toggle="modal"> <span class="glyphicon glyphicon-plus"></span>Ausfahrt eintragen</a>

    <!-- Modal -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Ausfahrt eintragen</h4>
   </div>


    <div class="modal-body">

          <form class="form-horizontal" id="ausfahrt_form" name="commentform" method="post" action="index.php">
            
            <div class="form-group">
              <label class="control-label col-md-4" for="datum_txt">Datum</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="datum_txt" name="datum_txt" value="<?=date("d.m.Y")?>" readonly/>
                </div>
            </div>

               <div class="form-group">
             <label class="control-label col-md-4" for="boot">Boot</label>
              <div class="col-md-6">
      <input type="text" value="" id="boot" div class="form-control" />
        <a href="javascript:void(0);"></a>
      </div>
    </div>

            <div class="form-group">
             <label class="control-label col-md-4" for="boot">Boot</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="boot_txt" name="boot_txt" placeholder="Boot"/>
              </div>
            </div>
          
            <div class="form-group">
              <label class="control-label col-md-4" for="name_txt">Name</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="name_txt" name="name_txt" placeholder="Name"/>
                </div>
            </div>
            
            <div class="form-group">
             <label class="control-label col-md-4" for="boot">Kilometer</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="km_txt" name="km_txt" placeholder="km"/>
              </div>
            </div>
          
            <div class="form-group">
              <label class="control-label col-md-4" for="ruderziel_txt">Ruderziel</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="ruderziel_txt" name="ruderziel_txt" placeholder="Ruderziel"/>
                </div>
            </div>

            <div class="form-group">
            <label class="control-label col-md-4" for="abfahrt_txt">Abfahrt</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="abfahrt_txt" name="abfahrt_txt" placeholder="hh:mm"/>
              </div>
            </div>
          
            <div class="form-group">
              <label class="control-label col-md-4" for="ankunft_txt">Ankunft</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="ankunft_txt" name="ankunft_txt" placeholder="hh:mm"/>
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="bemerkung_txt">Bemerkung</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="bemerkung_txt" name="bemerkung_txt" placeholder="..."/>
                </div>
            </div>

            <div class="form-group">
              <div class="col-md-6">
                <input type="submit" name="ausfahrt_speichern" class="btn btn-primary btn-xs">
              </div>
            </div>
          </form>
        
      </div><!-- End of Modal body -->
    </div><!-- End of Modal content -->
  </div><!-- End of Modal dialog -->
</div><!-- End of Modal -->



    </br>

        <!-- Colapse 1-3 -->
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <!-- Colapse 1 -->
          <div class="panel panel-primary">
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
          <div class="panel panel-primary">
            <div class="panel-heading" role="tab" id="headingTwo">
              <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Aktuelle Ausfahrten
                <span style="float: right" class="badge">14</span> 
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
          <div class="panel panel-primary">
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

        <tr> 
        <td><b> Boot </b></td> 
        <td><b> Steuernmann </b></td> 
        <td><b> KM </b></td>
        <td><b> Ruderziel </b></td>
        <td><b> Abfahrt </b></td>
        <td><b> Ankunft </b></td>
        </tr>
        <?php
          $datum = date("20y-m-d");
          $auswahl_sql = "SELECT * FROM m_ausfahrt";
          $ausfahrt = mysql_query($auswahl_sql);
     
          while($row = mysql_fetch_array($ausfahrt)){
            echo"<tr>";
            echo "<td>" . $row['datum'] . "</td>";
            echo "<td>" . $row['boot_id'] . "</td>";
            echo "<td>" . $row['boot_id'] . "</td>";
            echo "<td>" . $row['boot_id'] . "</td>";

            echo "</tr>";
           }
        ?>



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

    <!-- Eigene Javascript Datei zum überprüfen der Formulardaten -->
    <script src="frames/validation.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
  
     <script src="bower_components/bootstrap/js/inputosaurus.js"></script>

  
       <?php
          $auswahl_sql = "SELECT b_name FROM boot";
          $boot = mysql_query($auswahl_sql);
     
     $array = array();
         while($row = mysql_fetch_array($boot)){
    array_push($array, $row['b_name']);
         }


    
        ?>






<script>
    $('#boot').inputosaurus({
      width : '350px',
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
