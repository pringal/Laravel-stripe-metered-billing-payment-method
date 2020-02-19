<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
              @if(!empty($successMessage))
                <div id="success-message">{{$successMessage }}</div>
              @endif
<div id="error-message"></div>
 <form method="POST"  action="{{ url('payment') }}" aria-label="{{ __('PaymentSubmit') }}" id="pay-submit" >
        @csrf
    <input type="hidden" name="user_id" value="1">
    <!-- If you need any value you can add it like this -->
    
    <input type="hidden" name="stripeToken" id="stripeToken" value="" />
</form>

              
            </div>
        </div>
    </body>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" type="text/javascript"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script>

        // Handling and displaying error during form submit.
        function subscribeErrorHandler(jqXHR, textStatus, errorThrown) {
            try {
                var resp = JSON.parse(jqXHR.responseText);
                if ('error_param' in resp) {
                    var errorMap = {};
                    var errParam = resp.error_param;
                    var errMsg = resp.error_msg;
                    errorMap[errParam] = errMsg;
                } else {
                    var errMsg = resp.error_msg;
                }
            } catch (err) {
                
            }
        }

        // Forward to thank you page after receiving success response.
        function subscribeResponseHandler(responseJSON) {

            if (responseJSON.state == 'success') {
        
            }
            if (responseJSON.state == 'error') {
               
            }
        }
        var handler = StripeCheckout.configure({
        //Replace it with your stripe publishable key
            key: "{{ env('STRIPE_PUBLISHABLE_KEY') }}",
            // image: '{{asset('logo.png')}}', // add your company logo here
            allowRememberMe: false,
            token: handleStripeToken
        });


        submitpayment();
        function submitpayment() {
            handler.open({
                name: 'Laravel-Stripe',
                description: 'Metered Blling',
                amount: '15000'
            });
            return false;
        }
        function handleStripeToken(token, args) {
            form = $("#pay-submit");
            $("input[name='stripeToken']").val(token.id);
            var options = {
                error: subscribeErrorHandler,
                // post-submit callback when success returns
                success: subscribeResponseHandler,
                // complete: hideProcessing,
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                dataType: 'json'
            };
            // form.ajaxSubmit(options);
            form.submit();
            // return false;
        }

</script>
</html>
