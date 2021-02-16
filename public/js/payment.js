//On initialise stripe
var stripe = Stripe("pk_test_51IE8KAI8TVU6byzq3U7F5fdyZjcAiFRWstSxWZGXlHWARGSknG2eMLlUgkjuCa2OLkO5cNnkZ6nFmx7LxEMESRG300BlCd38Iv");


var elements = stripe.elements();
var card = elements.create('card', {
    style: {
        base: {
            lineHeight: 1.75,
        }
    }
});

card.mount('#stripe-card');

card.on('change', function (event){
    $('#stripe-pay').attr('disabled', event.empty);

    $('#card-error').text(event.error ? event.error.message : '');
});

$('#stripe-pay').click(function(){
    var clientSecret = $(this).data('client-secret');
    stripe.confirmCardPayment(clientSecret, {
        payment_method: {card: card}
    }).then(function(result){
        if(result.error){
            $('#card-error').text(result.error.message);
        }else{
           // alert('Paiement OK');

            window.location = '/cart/success/' + result.paymentIntent.id;
        }
    });
});