<?php

require 'braintree_php-master/lib/Braintree.php';

$gateway = new Braintree\Gateway([
    'environment' => 'sandbox',
    'merchantId' => '9r5qj2rbsj8yf8mw',
    'publicKey' => '9qqxznsc4frp8tmh',
    'privateKey' => '9588f39d4a0a15d1791d701012eed4d3'
]);

$clientToken = $gateway->clientToken()->generate();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://js.braintreegateway.com/js/braintree-2.31.0.min.js"></script>
    <script>
        braintree.setup('<?php echo $clientToken ?>', 'dropin', {
            container: 'dropin-container'
        });
    </script>
    <title>Pagar</title>
</head>

<body>
    <div class="container">
        <form id="realizarPago" action="pay.php" method="POST">
            <div class="container">
                <h3>Metodo de pago</h3>

                <select class="form-select" onclick="selct()" id="selll">
                    <option value="" selected disabled hidden>Metodo de pago</option>
                    <option value="1">Tarjeta</option>
                    <option value="2">Contraentrega</option>
                    <option value="3">Deposito</option>
                </select>

            </div>
            <br>

            <div hidden id="dataCard" class="container">
                <h3>Datos de tarjeta</h3>
                <div class="row">
                    <div class="col">
                        <input id="firstName" name="firstName" type="text" class="form-control" placeholder="Nombre" aria-label="First name">
                    </div>
                    <div class="col">
                        <input id="lastName" name="lastName" type="text" class="form-control" placeholder="Apellido" aria-label="Last name">
                    </div>
                </div>
                <br>
                <div id="dropin-container"></div>
            </div>

            <div class="container">
                <h3>Datos de envio</h3>
                <div class="mb-3">
                    <input name="dni" type="number" class="form-control" id="exampleFormControlInput1" placeholder="Numero de documento">
                </div>
                <div class="mb-3">
                    <input name="address" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Direccion">
                </div>
                <div class="mb-3">
                    <input name="phone" type="number" class="form-control" id="exampleFormControlInput1" placeholder="Numero de contacto">
                </div>
            </div>

            <br>
            <div class="container">
                <input class="btn btn-primary mb-3" type="submit" value="Confirmar compra" onclick="return confirm('Estas seguro de confirmar la compra?')">
            </div>
        </form>
        <a href="cart.php">Regresar</a>
    </div>


    <script>
        function selct() {
            if (document.getElementById("selll").value == "1") {
                document.getElementById("dataCard").hidden = false;
            } else {
                document.getElementById("dataCard").hidden = true;
            }
        }
    </script>
</body>

</html>