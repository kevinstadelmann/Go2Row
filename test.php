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

    <script src="../../assets/js/ie-emulation-modes-warning.js"></script><style type="text/css"></style>


  </head>

  <body>



  <!-- NAVIGATION -->
  

  <!-- HAUPTINHALT -->
  <div class="container">
    <div class="row">
      

      <!-- Hauptinhalt - Rechts -->
      <div class="col-xs-12 col-sm-9">
        <p class="pull-right visible-xs">
          <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">
            Toggle nav
          </button>
        </p>

        <!-- Button to trigger modal --> 
    <a href="#myModal" role="button" class="btn btn-custom" data-toggle="modal">Open Contact Form</a>
    <!-- Modal -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Contact Form</h4>
        </div>
        <div class="modal-body">

    <form class="form-horizontal" id="IDofyourform" name="commentform" method="post" action="test.php"

    >

   <div class="form-group">
        <label class="control-label col-md-4" for="first_name">First Name</label>
        <div class="col-md-6">
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-4" for="last_name">Last Name</label>
        <div class="col-md-6">
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name"
            
            />
        
    </div>

    </div>

    <div class="form-group">
        <label class="control-label col-md-4" for="comment">Question or Comment</label>
        <div class="col-md-6">
            <textarea rows="6" class="form-control" id="comments" name="comments" placeholder="Your question or comment here"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <button type="submit" value="Submit" class="btn btn-custom pull-right">Send</button>
        </div>
    </div>
</form>


        </div>
        </div><!-- End of Modal body -->
        </div><!-- End of Modal content -->
        </div><!-- End of Modal dialog -->
    </div><!-- End of Modal -->
        
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


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

    <script src="offcanvas.js"></script>

    <!-- Kalender -->
    <script src="dhtmlxcalendar.js"></script>  
    <script>
    $('#IDofyourform').bootstrapValidator({
    message: 'This value is not valid', 
    feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
    fields: {
        first_name: {
          validators: {
            notEmpty: {
              message: "You're required to fill in a first name!"
                  }, // notEmpty
            regexp: {
              regexp: /^[A-Za-z\s.'-]+$/,
              message: "Alphabetical characters, hyphens and spaces"
            }
                } // validators
              },  // firstname
        last_name: {
          validators: {
            notEmpty: {
              message: "You've forgotten to provide your last name!"
                  } // notEmpty
                } // validators
              },  // lastname
        email: {
          validators: {
            notEmpty: {
              message: "An email address is mandatory."
                  }, // notEmpty
            emailAddress: {
              message: "This is not a valid email address"
                    } // emailAddress     
                } // validators
              },  // email
        comments: {
          validators: {
            notEmpty: {
              message: "Are you sure? No comment?"
                  } // notEmpty
                } // validators
              } //comments
        } // fields
        });
    $('#myModal').on('shown.bs.modal', function() {
    $('#contactform').bootstrapValidator('resetForm', true);
    });
    </script>
  </body>
</html>