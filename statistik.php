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
    <link href="css/inputosaurus.css" rel="stylesheet">

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


// Statistik PHP
  // Arrays für json übergabe:
  $arr_km = array();
  $arr_datum = array();


  // Standard Statistik anzeigen (z.B. Ebene Club)
  $arr_club_sql = mysql_query("SELECT sum(km) as km, month(datum) as datum FROM m_ausfahrt group by MONTH(datum)");
  while( $row = mysql_fetch_array($arr_club_sql)){
      array_push($arr_km, $row['km']);
      array_push($arr_datum, $row['datum']);
    }
    echo print_r($arr_km);
    echo print_r($arr_datum);


  // Wenn Filter_anwenden Button gedrückt wurde
  if(isset($_POST['filter_anwenden'])){

    // bisherige Daten zurücksetzten
    $arr_km = array();
    $arr_datum = array();

    // Jahr Filter auslesen
    $jahr = $_POST['jahr_slc'];

    // Wenn Textbox befüllt ist nach Mitglied filtern, sonst ganzen Club anzeigen
    if($_POST['name_txt'] != ""){

    // Textbox Inhalt wieder aufsplitten um Mitglied in der DB zu finden
    $filter_name = explode(" ", $_POST['name_txt']);
    // Mitglieder ID ermitteln
    $filter_name_sqlid = mysql_query("SELECT `mitglied_id` FROM `mitglied` WHERE ( name = '$filter_name[0]') AND ( vorname = '$filter_name[1]' )");
    $filter_name_id = mysql_result($filter_name_sqlid, 0);

    // Alle Ausfahrt-ID's "sammeln"
    $arr_data_sql = mysql_query("SELECT sum(km) as km , month(datum)as datum FROM m_ausfahrt WHERE year(datum)='$jahr' AND m_ausfahrt_id in (SELECT m_ausfahrt_m_ausfahrt_id FROM mitglied_has_m_ausfahrt WHERE mitglied_mitglied_id = '$filter_name_id') group by MONTH(datum)");

    }else{
      $arr_data_sql = mysql_query("SELECT sum(km) as km , month(datum)as datum FROM m_ausfahrt WHERE year(datum)='$jahr' AND m_ausfahrt_id group by MONTH(datum)");
    }


    // Kilometerdaten in Array "pushen", damit ich es per json der chart.js übergeben kann
    while( $row = mysql_fetch_array($arr_data_sql)){
      array_push($arr_km, $row['km']);
      array_push($arr_datum, $row['datum']);
    }
  } // End of Isset
  


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

      <div class="col-sm-3" id="sidebar" role="navigation">
        <div class="panel panel-primary">
          <div class="panel-heading">
            Filter
          </div> 
        <!-- Filter Formular aufbauen -->
      </br>
          <form class="form-horizontal" id="statistik_form" name="commentform" method="post" action="statistik.php"> 
            <div class="form-group">

              <!-- Name - Filter -->
              <label class="control-label col-md-4" for="name_txt">Name</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="name_txt" name="name_txt"/>
              </div>
              <!-- End Name -->

              <!-- Zeit - Filter -->
              <div class="form-group">
              <label class="control-label col-md-4" for="jahr_slc">Jahr</label>
                <div class="col-md-6">           
                  <select name="jahr_slc" size="1" class="form-control">
                    <?php
                    $filter_jahr_sql = "SELECT distinct year(datum) as jahr FROM m_ausfahrt";
                    $jahre = mysql_query($filter_jahr_sql);
               
                    while($row = mysql_fetch_array($jahre)){
                    echo"<option>" . $row['jahr'] . "</option>";
                    }

                    ?>
                  </select>
                </div>
            </div>

              <!-- Filter Anwenden - Button-->
         
                <div class="col-md-6">
                  <input type="submit" name="filter_anwenden" class="btn btn-primary btn-xs">
                </div>
              
              <!-- End Filter Anwenden Button -->

            </div>
          </form>
        </div>
        
      </div><!--Seiten-Inhaltsverzeichnis
   
      <!-- Hauptinhalt - Rechts -->
      <div class="col-xs-12 col-sm-9">
        <div class="panel panel-primary">
          <div class="panel-heading">
            Statistik
          </div> 

          <!-- Statistik anzeigen -->
          <canvas id="buyers" width="800"height="400"></canvas>
 
      </div> <!-- Hauptinhalt - Rechts -->
    </div>
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
     <script src='Chart.min.js'></script>
     <script src="js/inputosaurus.js"></script>
     <!--<script src="bower_components/chart/chart.js"></script>-->



     <!-- Statistik Javascript -->

          <script type="text/javascript">

      var buyerData = {
          labels : <?php print(json_encode($arr_datum)); ?>,
          datasets: [
        {   
            label: "Jahr1",
            fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: <?php print(json_encode($arr_km)); ?>
        },
        {
            label: "Jahr2",
            fillColor: "rgba(220,220,220,0.2)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            //data: [20,30,40,30,20,5]
        }
    ]
      }
          var buyers = document.getElementById('buyers').getContext('2d');
          new Chart(buyers).Line(buyerData);
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
        $('#name_txt').inputosaurus({
          width : '100px',
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
