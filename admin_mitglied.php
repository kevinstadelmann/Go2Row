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

  if (!$connection){
     die("Konnte die Datenbank nicht öffnen.
         Fehlermeldung: ". mysql_error());
   }
  echo "Erfolgreich zur Datenbank verbunden!";

  //Dankenbankauswahl
  $db = mysql_select_db($database, $connection);

  if (!$db){
    echo "Konnte die Datenbank nicht auswählen.";
   }
   var_dump($_POST);

  // Wenn Mitglied speichern gedrückt wurde - Mitglied hinzufügen
  if(isset($_POST['mitglied_speichern'])){

    $kategorie = $_POST['kategorie_slc'];

    // ID der Kategorie suchen und in Variable speichern
    $kat_sql = mysql_query("SELECT kategorie_id FROM kategorie where kategorie='$kategorie'");
    $kat_arr = mysql_fetch_array($kat_sql);
    $kat_id = $kat_arr['kategorie_id'];

    // Datensatz in die DB speichern
    $sql =  "INSERT INTO mitglied (name,vorname,kategorie_kategorie_id)";
    $sql .= "VALUES ('".$_POST["name_txt"]."','".$_POST["vorname_txt"]."', $kat_id)";
    mysql_query($sql, $connection);
    }

  // Benutzer Löschen
  if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    mysql_query("DELETE FROM mitglied WHERE mitglied_id='".mysql_real_escape_string($_GET['id'])."'");
    //header("Location: admin.php");
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
            <li><a href="statistik.php">Statistik</a></li>
            <li class="active"><a href="admin_mitglied.php">Admin</a></li>
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

        </div>
      </div><!--Seiten-Inhaltsverzeichnis -->

      <!-- Hauptinhalt - Rechts -->
      <div class="col-xs-12 col-sm-9">
        <p class="pull-right visible-xs">
          <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">
            Toggle nav
          </button>
        </p>





    <!-- Modal - Mitglieder hinzufügen-->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Mitglied erstellen</h4>
   </div>
    <div class="modal-body">


          <form class="form-horizontal" id="mitglied_form" name="commentform" method="post" action="admin_mitglied.php">
            <div class="form-group">

             <label class="control-label col-md-4" for="name">Name</label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="name_txt" name="name_txt" placeholder="Name"/>
              </div>
            </div>
          
            <div class="form-group">
              <label class="control-label col-md-4" for="vorname_txt">Vorname</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="vorname_txt" name="vorname_txt" placeholder="Vorname"/>
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
                <input type="submit" name="mitglied_speichern" class="btn btn-primary btn-xs">
              </div>
            </div>
          </form>
        
      </div><!-- End of Modal body -->
    </div><!-- End of Modal content -->
  </div><!-- End of Modal dialog -->
</div><!-- End of Modal -->


<!-- Modal zum Löschen bestätigen -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h3 class="modal-title" id="myModalLabel">Bitte bestätigen</h3>

            </div>
            <div class="modal-body">
                 <h4>Sind Sie sicher, dass sie diesen Datensatz löschen wollen?</h4>

            </div>
            <!--/modal-body-collapse -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnDelteYes" href="#">Ja</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Nein</button>
            </div>
            <!--/modal-footer-collapse -->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->





      <!-- HAUPTINHALT RECHTS -->
      <div class="panel panel-primary">
       <div class="panel-heading">
        Mitglieder Liste

        <!-- Button to trigger modal -->
            <a href="#myModal"  role="button" style="float: right;color: #FFFFFF" data-toggle="modal">
            <span class="glyphicon glyphicon-plus-sign"></span> Mitglied hinzufügen</a>
          </b></td>
        
        </div>
        </br>
       <!-- Bereits enthaltene Mitglieder in Tabelle anzeigen -->
        <table class="table table-striped">
        <tr> 
          <td><b> Name   </b></td>
          <td><b> Vorname</b></td>
          <td><b> Kategorie </b></td>
          <td><b>
            
        </tr>

        <?php
          $auswahl_sql = "SELECT m.mitglied_id,m.name, m.vorname, k.kategorie FROM mitglied m, kategorie k WHERE m.kategorie_kategorie_id = k.kategorie_id";
          $mitglieder = mysql_query($auswahl_sql);
         
     
          while( $row = mysql_fetch_array($mitglieder)){
            echo"<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['vorname'] . "</td>";
            echo "<td>" . $row['kategorie'] . "</td>";
            //echo "<td>" . $row['mitglied_id']."<a href='delete.php?action=hinzufuegen=".$row['mitglied_id']."'><span class='glyphicon glyphicon-fire'></span></a></td>";
            // altes löschenecho "<td><a href='?action=delete&id=".$row['mitglied_id']."'><span class='glyphicon glyphicon-minus'></span></a>";
            echo "<td id=" . $row['mitglied_id']."><button type='button' class='delete-row'><span class='glyphicon glyphicon-remove-circle'></span></button>";
            echo " ";
            echo "<a href='admin_mitglied_edit.php?action=bearbeiten&id=".$row['mitglied_id']."'><span class='glyphicon glyphicon-pencil'></span></a></td>";
            echo "</tr>";
           }
        ?>
        </table>
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
// delete row
$("table").on('click', 'button.delete-row', function(e){
  e.preventDefault();
  var id = $(this).closest('td').attr('id');
  $('#deleteModal').data('id', id).modal('show');
  $('#editModal input[type="name"]').text()
});

$('#btnDelteYes').click(function () {

    var id = $('#deleteModal').data('id');
    
    if(id > 0){
      $.ajax({
        type: "POST",
        url: document.URL+'?action=delete&id='+id,
        async: false,
        data: {}
      });
    }
    $('#deleteModal').modal('hide');

     $('table td[id=' + id + ']').closest('tr').remove();
    //location.reload();

});
</script>


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

    <script src="offcanvas.js"></script>
    <!-- Eigene Javascript Datei zum überprüfen der Formulardaten -->
    <script src="js/validation.js"></script>


  

  </body>
</html>
