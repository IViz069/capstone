<?php

    require "funcs.php";
    require 'braintree_php-master/lib/Braintree.php';
    require "fpdf.php";
    require 'database.php';

    require_once('vendor/autoload.php');

    date_default_timezone_set("America/Lima");

    use Docxmerge\Docxmerge;

    use Luecano\NumeroALetras\NumeroALetras;

    $formatter = new NumeroALetras();

    $docxmerge = new Docxmerge("UkRQnkKy5VWmkChGfdqPCkPWKpajlu", "default-jk_vile", "https://api.docxmerge.com");


    $gateway = new Braintree\Gateway([
        'environment' => 'sandbox',
        'merchantId' => '9r5qj2rbsj8yf8mw',
        'publicKey' => '9qqxznsc4frp8tmh',
        'privateKey' => '9588f39d4a0a15d1791d701012eed4d3'
      ]);

    $result = $gateway->transaction()->sale([
        'amount' => calcularPrecioTotalConIgv(),
        'paymentMethodNonce' => $_POST['payment_method_nonce'],
        'deviceData' => '',
        'options' => [ 'submitForSettlement' => True ]
    ]);

    if ($result->success) {
        print_r("Su compra se realizo con exito, codigo de transaccion " . $result->transaction->id);

        $cart2 = $conn->prepare('SELECT a.cantidad, b.descr, b.precio FROM caps_cart a INNER JOIN caps_products b ON a.id_item = b.id WHERE a.id_cliente = ' . $_SESSION['user_id']);
        $cart2->execute();
        $cartResults2 = $cart2->fetchAll(PDO::FETCH_ASSOC);

        $nume = $conn->prepare('SELECT `AUTO_INCREMENT` AS NUME FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = "capss" AND   TABLE_NAME   = "caps_venta_cabecera";');
        $nume->execute();
        $numeRes = $nume->fetchAll(PDO::FETCH_ASSOC);

        /*SELECT `AUTO_INCREMENT`
FROM  INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = 'capss'
AND   TABLE_NAME   = 'caps_venta_cabecera';*/


        $data = array();
        $data["dni"] = $_POST['dni'];
        $data["igv"] = number_format(calcularIgv(),2);

        $data_data = array();

        for($i=0;$i<count($cartResults2);$i++){
            $datatemp = array();
            $datatemp["desc"] = $cartResults2[$i]['descr'];
            $datatemp["puni"] = $cartResults2[$i]['precio'];
            $datatemp["quant"] = $cartResults2[$i]['cantidad'];
            $datatemp["total"] = $cartResults2[$i]['cantidad'] * $cartResults2[$i]['precio'];
            array_push($data_data, $datatemp);
        }

        $data["data"] = $data_data;

        $data["date"] = date("d/m/Y");
        $data["name"] = $_SESSION['name'] . " " . $_SESSION['surname'];
        $data["time"] = date("G:i");
        $data["email"] = $_SESSION['email'];
        $data["phone"] = $_POST['phone'];
        $data["number"] = "B001-" . sprintf("%07d", $numeRes[0]['NUME']);
        $data["ttotal"] = number_format(calcularPrecioTotalConIgv(),2);
        $data["address"] = $_POST['address'];
        $data["cardnum"] = "**** **** **** ". $result->transaction->creditCardDetails->last4;
        $data["tottext"] = $formatter->toMoney(number_format(calcularPrecioTotalConIgv(),2), 2, 'SOLES', 'CENTIMOS');
        $data["subtotal"] = number_format(calcularPrecioTotal(),2);

    $fp = fopen("./boletas/" . $numeRes[0]['NUME'] . ".pdf", "w");

    $docxmerge->renderTemplate(
        $fp,
        "bole5",
        $data,
        "PDF",
        "latest"
    );

        ?> <a href="index.php"><button>Regresar al inicio</button></a>
        <button type="submit" onclick="window.open('http://localhost/caps/boletas/<?php echo $numeRes[0]['NUME']; ?>.pdf')">Descargar Boleta</button>
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