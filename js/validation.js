$(document).ready(function() {

// Validation vom Mitglied hinzufügen Formular

$('#mitglied_form').bootstrapValidator({
message: 'This value is not valid', 
feedbackIcons: {
    valid: 'glyphicon glyphicon-ok',
    invalid: 'glyphicon glyphicon-remove',
    validating: 'glyphicon glyphicon-refresh'
  },
fields: {
    name_txt: {
      validators: {
        notEmpty: {
          message: "Bitte einen Namen eingeben!"
              }, // notEmpty
        regexp: {
          regexp: /^[A-Za-z\s.'-]+$/,
          message: "Alphabetical characters, hyphens and spaces"
        }
            } // validators
          },  // firstname
    vorname_txt: {
      validators: {
        notEmpty: {
          message: "Bitte einen Vornamen eingeben!"
              } // notEmpty
            } // validators
          },  // lastname
    kategorie_slc: {
      validators: {
        notEmpty: {
          message: "Bitte eine Kategorie auswählen!"
              } // notEmpty
            } // validators
          },  // kategorie
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
$('#mitglied_form').on('shown.bs.modal', function() {
$('#mitglied_form').bootstrapValidator('resetForm', true);
});


// Validation vom Boot hinzufügen Formular


$('#boot_form').bootstrapValidator({
message: 'This value is not valid', 
feedbackIcons: {
    valid: 'glyphicon glyphicon-ok',
    invalid: 'glyphicon glyphicon-remove',
    validating: 'glyphicon glyphicon-refresh'
  },
fields: {
    name_txt: {
      validators: {
        notEmpty: {
          message: "Bitte einen Namen eingeben!"
              }, // notEmpty
        regexp: {
          regexp: /^[A-Za-z\s.'-]+$/,
          message: "Alphabetical characters, hyphens and spaces"
        }
            } // validators
          },  // firstname
    kategorie_slc: {
      validators: {
        notEmpty: {
          message: "Bitte eine Kategorie auswählen!"
        } // notEmpty
      } // validators
    },  // kategorie
} // fields
});

$('#boot_form').on('shown.bs.modal', function() {
$('#boot_form').bootstrapValidator('resetForm', true);
});


$('.edit').click(function() {
  $(this)
})

// Validation vom Ausfahrt hinzufügen Formular

// Validation vom Mitglied hinzufügen Formular

$('#ausfahrt_form').bootstrapValidator({
message: 'This value is not valid', 
feedbackIcons: {
    valid: 'glyphicon glyphicon-ok',
    invalid: 'glyphicon glyphicon-remove',
    validating: 'glyphicon glyphicon-refresh'
  },
fields: {
    boot_txt: {
      validators: {
        notEmpty: {
          message: "Bitte ein Boot eingeben!"
              }, // notEmpty
        regexp: {
          regexp: /^[A-Za-z\s.'-]+$/,
          message: "Alphabetical characters, hyphens and spaces"
        }
            } // validators
          },  // km
    mannschaft_txt: {
      validators: {
        notEmpty: {
          message: "Bitte min. 1 Mitglied angeben!"
              }, // notEmpty
            } // validators
          },  // mannschaft
    km_txt: {
      validators: {
        //notEmpty: {
          //message: "Für Kilometer sind nur Zahlen erlaubt!"
          //    }, // notEmpty
        regexp: {
          regexp: /^[1-1000]+$/,
          message: "Nur Zahlen zwischen 1-1000"
        }
            } // validators
          } // km
    } // fields
    });
$('#ausfahrt_form').on('shown.bs.modal', function() {
$('#ausfahrt_form').bootstrapValidator('resetForm', true);
});


});