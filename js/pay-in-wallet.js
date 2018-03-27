jQuery(document).ready(function($){

    var payinInput = $('#total-without-fees');
    var payoutInput = $('#total-without-fees-payout');
    console.log($("#submit-payout-all"));

    //console.log($('.total-wallet')[0].text());

    payinInput.on('input',function(e){
        console.log(payinInput.val());
        if(payinInput.val()) {
            var payin = parseFloat(payinInput.val()).toFixed(2);
            var fees = payin * 0.05;
            fees = fees > 50 ? 50.00 : fees.toFixed(2);
            var total = (parseFloat(payin) + parseFloat(fees));
            $('#fees').text(fees);
            $('#total-with-fees').text(total);
            $('#submit-payin').val(total * 100);
            $('#fees-hidden-payin').val(fees * 100);
            $('#submit-payin').prop("disabled",false);
        }
        else {
            $('#fees').text('0.00');
            $('#total-with-fees').text('0.00');
            $('#submit-payin').val(0);

            $('#submit-payin').prop("disabled",true);

        }
    });

    payoutInput.on('input',function(e){
        console.log(payoutInput.val());
        if(payoutInput.val() && payoutInput.val() >= 2) {
            var payin = parseFloat(payoutInput.val()).toFixed(2);
            var fees = 1;
            fees = fees > 50 ? 50.00 : fees.toFixed(2);
            var total = (parseFloat(payin) - parseFloat(fees));
            $('#fees-payout').text(fees);
            $('#total-with-fees-payout').text(total);
            $('#submit-payout').val(total);
            $('#fees-hidden-payout').val(fees);
            $('#submit-payout').prop("disabled",false);
        }
        else {
            $('#fees-payout').text('0.00');
            $('#total-with-fees-payout').text('0.00');
            $('#submit-payout').val(0);

            $('#submit-payout').prop("disabled",true);

        }
    });
});