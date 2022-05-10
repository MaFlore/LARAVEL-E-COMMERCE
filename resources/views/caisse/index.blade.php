@extends('layouts.master')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('contenu')

<div class="mx-auto">
    <h1>Procéder au payement !</h1>
    <div class="row">
        <div style="text-align: center">
            <form action="{{ route('caisse.enregistrer') }}" method="POST" class="my-4" id="payment-form">
                @csrf
                @method('POST')
                <!-- Stripe Elements Placeholder -->
                <div id="card-element"></div>

                <div id="card-errors" role="alert"></div>

                <button class="btn btn-success mt-4" id="submit"><i class="fa fa-credit-card" aria-hidden="true"></i>Payer maintenant la somme de {{ getPrix(Cart::total()) }}</button>
            </form>
        </div>
    </div>
@endsection

@section('contenu_js')
<script src="https://js.stripe.com/v3/"></script>

<script>
    var stripe =  Stripe('pk_test_51KlTNFDqbyJ3QlcEqWD78LR7hbAgNSx0UmS0rkHzUVGbB2q5OAGShu025CjEycaNzvtMIMGYuXO71R0uVHmXpY2K00O9teD0KX');
    var elements = stripe.elements();
        var style = {
            base : {
            color : "#32325d",
            fontFamily : '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing : "antialiased",
            fontSize : "16px",
            "::placeholder":{
                color : "#aab7c4"
            }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            }
        };

        var card = elements.create("card", { style: style });
        card.mount("#card-element");
        card.addEventListener('change', ({error}) =>{
        const displayError = document.getElementById('card-errors');
            if (error){
                displayError.classList.add('alert', 'alert-warning');
                displayError.textContent = error.message;
            }else{
                displayError.classList.remove('alert', 'alert-warning');
                displayError.textContent = "";
            }
        });

        var submitButton = document.getElementById('submit');
        submitButton.addEventListener('click', function(event){
        event.preventDefault();
        submitButton.disabled = true;

        stripe.confirmCardPayment("{{ $clientSecret }}", {
            payment_method: {
                card: card
            }
            }).then(function(result){
                if (result.error){

                    submitButton.disabled = false;
                    console.log(result.error.message);

                }else{

                    if (result.paymentIntent.status === "succeeded"){
                        var paymentIntent = result.paymentIntent;
                        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        var form = document.getElementById('payment-form');
                        var url = form.action;
                        var redirect = '/merci';

                        fetch(
                            url,
                            {
                                headers: {
                                    "Content-Type": "application/json",
                                    "Accept": "application/json, text-plain, */*",
                                    "X-Requested-With": "XMLHttpRequest",
                                    "X-CSRF-TOKEN": token
                                },
                                method: "POST",
                                body: JSON.stringify({
                                    paymentIntent: paymentIntent,
                                }),

                            }).then((data) => {
                            console.log(data)
                            window.location.href = redirect;
                            }).catch((error) => {
                            console.log(error)
                            })

                    }
                }
            });
        });
</script>
@endsection
