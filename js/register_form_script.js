jQuery(document).ready(function ($) {

  $('input.calendar').datepicker({dateFormat: 'dd-mm-yy'});
  $('.type_account').click(function () {
    if ($('#professionnal').is(':checked')) {
      $('#type-entreprise').show();
    }
    else {
      $('#type-entreprise').hide();
    }
  });

  $('#register-button').prop('disabled', true);

  $('#tc_agree').click(function () {
    if ($('#tc_agree').is(':checked')) { console.log('it\'s checked'); }
    else {
      console.log('not checked');
    }
  });

});