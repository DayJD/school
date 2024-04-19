<!DOCTYPE html>
<html lang="en">

<head>
    <title>Checkout</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
    <script type="text/javascript">
        var session_id = '{{ $session_id }}';
        var stripe = Stripe('{{ $setPublicKey }}');
        stripe.redirectToCheckout({
            sessionId: session_id
        }).then(function(result) {
            // console.log(result);
        });
    </script>
</body>

</html>
