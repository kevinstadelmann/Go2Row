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
    <link href="css/style.css" rel="stylesheet">

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

  // var_dump($_POST);
  
  if(isset($_POST['ausfahrt_speichern'])){
    
    // Tabelle Ausfahrt mit einfach Daten füllen
    $datum = date("20y-m-d");
    $abfahrt = $_POST['abfahrt_txt'] . ":00";
    $ankunft = $_POST['ankunft_txt'] . ":00";
    
    // Steuermann_id abfragen
    $steuermann = explode(" ", $_POST['steuermann_txt']);
    //print_r($steuermann);
    //echo $steuermann[0];
    //echo $steuermann[1];
    $steuermann_sqlid = mysql_query("SELECT `mitglied_id` FROM `mitglied` WHERE ( name = '$steuermann[0]') AND ( vorname = '$steuermann[1]' )");
    $steuermann_id = mysql_result($steuermann_sqlid, 0);
    //echo $steuermann_id;

    //Boot_id abfragen
    $boot = $_POST['boot_txt'];
    $boot_result = mysql_query("SELECT `boot_id` FROM `boot` WHERE `b_name` = '$boot'");
    $boot_id = mysql_result($boot_result, 0);
    //echo $boot_id;

    $sql =  "INSERT INTO `m_ausfahrt`(`m_ausfahrt_id`, `datum`, `mitglied_id`, `steuermann`, `km`, `ruderziel`, `abfahrt`, `ankunft`, `bemerkung`, `boot_boot_id`)";
    $sql .= "VALUES (NULL, '$datum', '0', '$steuermann_id', '".$_POST["km_txt"]."', '".$_POST["ruderziel_txt"]."', '".$_POST["abfahrt_txt"]."', '".$_POST["ankunft_txt"]."', '".$_POST["bemerkung_txt"]."', '$boot_id')";

    mysql_query($sql,$connection);


    // Zwischentabelle mit der Mannschaft befüllen
    $last_insert = mysql_insert_id();
    //echo $last_insert;
    $ms_array = explode(",", $_POST['mannschaft_txt']);
    //print_r($ms_array); 

    // god ned wil ich mit ms_array ned cha go db abfroge
    //while($row = mysql_fetch_array($ms_array)){
    //for($i=1;$i<count($ms_array);$i++) {
        
foreach($ms_array as $ms_string) {

         // $n = 0;
         $ms_result = mysql_query("SELECT mitglied_id FROM mitglied WHERE (concat(name, ' ', vorname)) = '$ms_string'");
         $ms_id = mysql_result($ms_result, 0);
         //echo $ms_id;
         $ms_sql =  "INSERT INTO `mitglied_has_m_ausfahrt` (`mitglied_mitglied_id`, `m_ausfahrt_m_ausfahrt_id`)";
         $ms_sql .= "VALUES ('$ms_id', '$last_insert')";
         mysql_query($ms_sql,$connection);
         //$n++;


         // Mitglied 2 => last insert id verändert sich!!
         // $ms_result2 = mysql_query("SELECT mitglied_id FROM mitglied WHERE (concat(name, ' ', vorname)) = '$ms_array[1]'");
         // $ms_id2 = mysql_result($ms_result2, 0);
         // echo $ms_id2;
         // $ms_sql2 =  "INSERT INTO `mitglied_has_m_ausfahrt` (`mitglied_mitglied_id`, `m_ausfahrt_m_ausfahrt_id`)";
         // $ms_sql2 .= "VALUES ('$ms_id', '$last_insert')";
         // mysql_query($ms_sql2,$connection);

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
          <a class="navbar-brand" href="index.php">Go2Row</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Logbuch</a></li>
            <li><a href="statistik.php">Statistik</a></li>
            <li><a href="admin_mitglied.php">Admin</a></li>
            <li><a href="help.php">Hilfe</a></li>
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
            <li><a>Heute wurden insgesamt 
            <?php
            $select_km = mysql_query("SELECT sum(km) as gesamt_km FROM m_ausfahrt WHERE datum = '" . date("20y-m-d") . "'");
            $km = mysql_result($select_km, 0);
            if(empty($km)){
              echo 0;
            }
            echo $km;
            ?>
            km gerudert</a></li>

          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

  <!-- HAUPTINHALT -->
  <div class="container">
    <div class="row">
      <!-- Seiten-Inhaltsverzeichnis -->
      <div class="col-sm-4" id="sidebar" role="navigation">
        <div class="list-group">

<div class="panel panel-primary">
       <div class="panel-heading">
        <h4 class="panel-title">Filter</h4>
      </div>
    </br>
<div class='kalender' style="margin:0 auto;"></div>
</div>
<p><button class="btn btn-default btn-sm show-date"> <span class="glyphicon glyphicon-calendar"></span>  Anzeigen</button></p>
<!-- Button to trigger modal --> 
    <a href="#myModal" role="button" class="btn btn-default btn-sm" data-toggle="modal"> <span class="glyphicon glyphicon-plus"></span>Ausfahrt eintragen</a>

        </div>
      </div><!--Seiten-Inhaltsverzeichnis -->

      <!-- Hauptinhalt - Rechts -->
      <div class="col-xs-12 col-sm-8">
        <p class="pull-right visible-xs">
          <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">
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
             <label class="control-label col-md-4" for="boot_txt">Boot</label>
              <div class="col-md-6">
                  <input type="text" value="" id="boot_txt" name="boot_txt" class="form-control" placeholder="Suchen"/>
              </div>
          </div>

                      <div class="form-group">
              <label class="control-label col-md-4" for="name_txt">Steuermann</label>
                <div class="col-md-6">
                <input type="text" class="form-control" id="steuermann_txt" name="steuermann_txt" placeholder="Suchen"/>
                  <!-- <input type="text" class="form-control" id="tokenfield"/> -->
                </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-4" for="mannschaft_txt">Mannschaft</label>
                <div class="col-md-6">
                <input type="text" class="form-control" id="mannschaft_txt" name="mannschaft_txt" placeholder="Suchen"/>
                  <!-- <input type="text" class="form-control" id="tokenfield"/> -->
                </div>
            </div>
            
            <div class="form-group">
             <label class="control-label col-md-4" for="km_txt">Kilometer</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="km_txt" name="km_txt" placeholder="km"/>
              </div>
            </div>
          
            <div class="form-group">
              <label class="control-label col-md-4" for="ruderziel_txt">Ruderziel</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="ruderziel_txt" name="ruderziel_txt" placeholder="Ort"/>
                </div>
            </div>

            <div class="form-group">
            <label class="control-label col-md-4" for="abfahrt_txt">Abfahrt</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="abfahrt_txt" name="abfahrt_txt" value="<?php $datum = date("H:i"); echo $datum;?>"
                placeholder="hh:mm"/>
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


 
        <!-- Colapse 1-3 -->
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <!-- Colapse 1 -->
          <div class="panel panel-primary">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Aktuelle Ausfahrten
               <span style="float: right" class="badge">
               <?php
                if (isset($_POST['kalender'])){
                  $kalender = $_POST['kalender'];
                  $cut = explode(" ", $kalender);
                  $js_date = $cut[1] . "-" . $cut[2] . "-" . $cut[3];
                  $date_false = date_create_from_format('M-d-Y', $js_date);
                  $cal_date = date_format($date_false, 'Y-m-d');
                  } else {
                    $cal_date = date("20y-m-d");
                  }
                $auswahl_sql = "SELECT * FROM m_ausfahrt WHERE ankunft = '00:00:00' AND datum = '$cal_date'";
                $ausfahrt = mysql_query($auswahl_sql);
                $menge_aktuell = mysql_num_rows($ausfahrt);
                echo $menge_aktuell;
              ?>
               </span> 
              </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse 
            <?php
                if (isset($_POST['kalender'])){
                  echo "";
                } else {
                  echo "in";
                }
              ?>
            " role="tabpanel" aria-labelledby="headingOne">
              <!-- Colapse 1 - Inhalt -->
              <div class="panel-body">
                <table class="table table-striped">
                  <tr class="danger">
                     <tr> 
        <td><b> Boot </b></td> 
        <td><b> Steuernmann </b></td> 
        <td><b> Mannschaft </b></td> 
        <td><b> KM </b></td>
        <td><b> Ruderziel </b></td>
        <td><b> Abfahrt </b></td>
        <td><b> Ankunft </b></td>
        <td><b>  </b></td>
        </tr>
        <?php
        if (isset($_POST['kalender'])){
                  $kalender = $_POST['kalender'];
                  $cut = explode(" ", $kalender);
                  $js_date = $cut[1] . "-" . $cut[2] . "-" . $cut[3];
                  $date_false = date_create_from_format('M-d-Y', $js_date);
                  $cal_date = date_format($date_false, 'Y-m-d');
                } else {
                  $cal_date = date("20y-m-d");
                }
          
          $auswahl_sql = "SELECT * FROM m_ausfahrt WHERE ankunft = '00:00:00' AND datum = '$cal_date'";
          $ausfahrt = mysql_query($auswahl_sql);
          $menge_aktuell = mysql_num_rows($ausfahrt);
     
          while($row = mysql_fetch_array($ausfahrt)){
            echo"<tr>";

            // Boot anzeigen
            $boot_sql = "SELECT b_name FROM boot WHERE boot_id = '" . $row['boot_boot_id'] . "'";
            $boot_result = mysql_query($boot_sql);
            $boot = mysql_result($boot_result, 0);
            echo "<td>" . $boot . "</td>";

            // Steuermann anzeigen
            $sm_sql = "SELECT (concat(name, ' ', vorname)) AS name_vorname FROM mitglied WHERE mitglied_id = '" . $row['steuermann'] . "'";
            $sm_result = mysql_query($sm_sql);
              while($sm = mysql_fetch_array($sm_result)){
                echo "<td>" . $sm['name_vorname'] . "</td>";
              }

            // Mannschaft anzeigen
            echo "<td>";
            $id_abfrage = "SELECT `mitglied_mitglied_id` FROM `mitglied_has_m_ausfahrt` WHERE `m_ausfahrt_m_ausfahrt_id` = '" . $row['m_ausfahrt_id'] . "'";
            $id_abfrage_result = mysql_query($id_abfrage);
            while ($id = mysql_fetch_array($id_abfrage_result)) {
              $ms_sql = "SELECT (concat(name, ' ', vorname)) AS name_vorname FROM mitglied WHERE mitglied_id = '" . $id['mitglied_mitglied_id'] . "'";
              $ms_result = mysql_query($ms_sql);
                while($ms = mysql_fetch_array($ms_result)){
                  echo $ms['name_vorname'];
                  echo "<br/>";
                }
            }
            echo "</td>";
            
            echo "<td>" . $row['km'] . "</td>";
            echo "<td>" . $row['ruderziel'] . "</td>";

            $abfahrt = explode(":", $row['abfahrt']);
            echo "<td>" . $abfahrt[0] . ":" . $abfahrt[1] . "</td>";
            echo "<td>" . "-" . "</td>";
            echo "<td><a href='ausfahrt_edit.php?action=bearbeiten&id=".$row['m_ausfahrt_id']."'><span class='glyphicon glyphicon-pencil'></span></a></td>";
            echo "</tr>";
           }
        ?>
                   </tr>
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
                 Reservationen
                <span style="float: right" class="badge">0
   <!--             <?php
               $auswahl_sql = "SELECT * FROM m_ausfahrt WHERE ankunft = '00:00:00'";
               $ausfahrt = mysql_query($auswahl_sql);
                $menge_aktuell = mysql_num_rows($ausfahrt);
               echo $menge_aktuell;
                ?>-->
               </span>  
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
              <!-- Colapse 2 - Inhalt -->
              <div class="panel-body">
                <table class="table table-striped">
                  <tr class="warning">

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
              <span style="float: right" class="badge">
               <?php
                if (isset($_POST['kalender'])){
                  $kalender = $_POST['kalender'];
                  $cut = explode(" ", $kalender);
                  $js_date = $cut[1] . "-" . $cut[2] . "-" . $cut[3];
                  $date_false = date_create_from_format('M-d-Y', $js_date);
                  $cal_date = date_format($date_false, 'Y-m-d');
                  } else {
                    $cal_date = date("20y-m-d");   
                  }
                $auswahl_sql = "SELECT * FROM m_ausfahrt WHERE ankunft != '00:00:00' AND datum = '$cal_date'";
                $ausfahrt = mysql_query($auswahl_sql);
                $menge_aktuell = mysql_num_rows($ausfahrt);
                echo $menge_aktuell;
              ?>
               </span> 
              </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse
            <?php
            // Wenn ein Datum gewählt ausgewählt wurde wird automatisch abgeschlossene Ausfahrten angezeigt
                if (isset($_POST['kalender'])){
                  echo "in";
                } else {
                  echo "";
                }
              ?>
            " role="tabpanel" aria-labelledby="headingThree">
              <!-- Colapse 3 - Inhalt -->
              <div class="panel-body">
                <table class="table table-striped">
                  <tr class="success">

        <tr> 
        <td><b> Boot </b></td> 
        <td><b> Steuernmann </b></td> 
        <td><b> Mannschaft </b></td> 
        <td><b> KM </b></td>
        <td><b> Ruderziel </b></td>
        <td><b> Abfahrt </b></td>
        <td><b> Ankunft </b></td>
        </tr>
        <?php
           if (isset($_POST['kalender'])){
                  $kalender = $_POST['kalender'];
                  $cut = explode(" ", $kalender);
                  $js_date = $cut[1] . "-" . $cut[2] . "-" . $cut[3];
                  $date_false = date_create_from_format('M-d-Y', $js_date);
                  $cal_date = date_format($date_false, 'Y-m-d');
                } else {
                  $cal_date = date("20y-m-d");
                }
          $auswahl_sql = "SELECT * FROM m_ausfahrt WHERE ankunft != '00:00:00' AND datum = '$cal_date'";
          $ausfahrt = mysql_query($auswahl_sql);
     
          while($row = mysql_fetch_array($ausfahrt)){
            echo"<tr>";

            // Boot anzeigen
            $boot_sql = "SELECT b_name FROM boot WHERE boot_id = '" . $row['boot_boot_id'] . "'";
            $boot_result = mysql_query($boot_sql);
            $boot = mysql_result($boot_result, 0);
            echo "<td>" . $boot . "</td>";

            // Steuermann anzeigen
            $sm_sql = "SELECT (concat(name, ' ', vorname)) AS name_vorname FROM mitglied WHERE mitglied_id = '" . $row['steuermann'] . "'";
            $sm_result = mysql_query($sm_sql);
              while($sm = mysql_fetch_array($sm_result)){
                echo "<td>" . $sm['name_vorname'] . "</td>";
              }

            // Mannschaft anzeigen
            echo "<td>";
            $id_abfrage = "SELECT `mitglied_mitglied_id` FROM `mitglied_has_m_ausfahrt` WHERE `m_ausfahrt_m_ausfahrt_id` = '" . $row['m_ausfahrt_id'] . "'";
            $id_abfrage_result = mysql_query($id_abfrage);
            while ($id = mysql_fetch_array($id_abfrage_result)) {
              $ms_sql = "SELECT (concat(name, ' ', vorname)) AS name_vorname FROM mitglied WHERE mitglied_id = '" . $id['mitglied_mitglied_id'] . "'";
              $ms_result = mysql_query($ms_sql);
                while($ms = mysql_fetch_array($ms_result)){
                  echo $ms['name_vorname'];
                  echo "<br/>";
                }
            }
            echo "</td>";


            // $ms_sql = "SELECT (concat(name, ' ', vorname)) AS name_vorname FROM mitglied WHERE mitglied_id = '" . $row['mitglied_id'] . "'";
            // $ms_result = mysql_query($ms_sql);
            //   while($ms = mysql_fetch_array($ms_result)){
            //     echo "<td>" . $ms['name_vorname'] . "</td>";
            //   }
            
            echo "<td>" . $row['km'] . "</td>";
            echo "<td>" . $row['ruderziel'] . "</td>";


            $abfahrt = explode(":", $row['abfahrt']);
            echo "<td>" . $abfahrt[0] . ":" . $abfahrt[1] . "</td>";
            $ankunft = explode(":", $row['ankunft']);
            echo "<td>" . $ankunft[0] . ":" . $ankunft[1] . "</td>";
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
      <p>© Go2Row Project Team</p>
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
    

    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/js/bootstrapValidator.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>

    <script src="js/validation.js"></script>
  
    <script src="js/inputosaurus.js"></script>
    <script src="jquery.supercal.js"></script>



<!-- Kalender -->

<script>
  $('.kalender').supercal({
      todayButton: false,
      showInput: false,
      transition: 'crossfade'
  });
  var myRedirect = function(redirectUrl, arg, value) {
  var form = $('<form action="' + redirectUrl + '" method="post">' +
  '<input type="hidden" name="'+ arg +'" value="' + value + '"></input>' + '</form>');
  $('body').append(form);
  $(form).submit();
};

    $("button.show-date").click(function(){

    //$.post("index.php", { kalender: $('.supercal').data('date') } ).done(function(res){window.location="index.php"});
    //alert($('.supercal').data('date'));
myRedirect("/Go2Row/index.php", "kalender", $('.supercal').data('date'));
});
</script>


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

    //prettyPrint();
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

    //prettyPrint();
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

    //prettyPrint();
  </script>


<!-- Autocomplete Bootstrap Variante.. goht aber ned!!!!! -->




  </body>
</html>