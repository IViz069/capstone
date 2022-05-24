<?php

    require "funcs.php";
    require 'braintree_php-master/lib/Braintree.php';
    require "fpdf.php";
    require 'database.php';

    require_once('vendor/autoload.php');

    date_default_timezone_set("America/Lima");

    use Docxmerge\Docxmerge;

    $docxmerge = new Docxmerge("UkRQnkKy5VWmkChGfdqPCkPWKpajlu", "default-jk_vile", "https://api.docxmerge.com");


    $gateway = new Braintree\Gateway([
        'environment' => 'sandbox',
        'merchantId' => '9r5qj2rbsj8yf8mw',
        'publicKey' => '9qqxznsc4frp8tmh',
        'privateKey' => '9588f39d4a0a15d1791d701012eed4d3'
      ]);

    $result = $gateway->transaction()->sale([
        'amount' => calcularPrecioTotal(),
        'paymentMethodNonce' => $_POST['payment_method_nonce'],
        'deviceData' => '',
        'options' => [ 'submitForSettlement' => True ]
    ]);

    if ($result->success) {
        print_r("Su compra se realizo con exito, codigo de transaccion " . $result->transaction->id);

        $data = array();
        $data["dni"] = "dni";
        $data["igv"] = calcularPrecioTotal()*0.18;
        $data_data = array();
        $data_data_0 = array();
        $data_data_0["desc"] = "desc";
        $data_data_0["puni"] = "puni";
        $data_data_0["quant"] = "quant";
        $data_data_0["total"] = "total";
        array_push($data_data, $data_data_0);
        $data_data_1 = array();
        $data_data_1["desc"] = "desc";
        $data_data_1["puni"] = "puni";
        $data_data_1["quant"] = "quant";
        $data_data_1["total"] = "total";
        array_push($data_data, $data_data_1);
        $data["data"] = $data_data;
        $data["date"] = date("d/m/Y");
        $data["name"] = "name";
        $data["time"] = date("G:i");
        $data["email"] = "email";
        $data["phone"] = "phone";
        $data["number"] = "number";
        $data["ttotal"] = calcularPrecioTotal() + calcularPrecioTotal()*0.18;
        $data["address"] = "address";
        $data["cardnum"] = "**** **** **** ". $result->transaction->creditCardDetails->last4;
        $data["subtotal"] = calcularPrecioTotal();

    $fp = fopen("./bole4.pdf", "w");

    $docxmerge->renderTemplate(
        $fp,
        "bole4",
        $data,
        "PDF",
        "latest"
    );

        ?> <a href="index.php"><button>Regresar al inicio</button></a>
        <button type="submit" onclick="window.open('http://localhost/caps/boletas/<?php echo $ran; ?>.pdf')">Descargar Boleta</button>
        <?php
    } else if ($result->transaction) {
        print_r("Error processing transaction:");
        print_r("\n  code: " . $result->transaction->processorResponseCode);
        print_r("\n  text: " . $result->transaction->processorResponseText);
    } else {
        foreach($result->errors->deepAll() AS $error) {
          print_r($error->code . ": " . $error->message . "\n");
        }
    }
?>