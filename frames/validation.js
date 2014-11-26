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


