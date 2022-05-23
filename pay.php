<?php

    require "funcs.php";
    require 'braintree_php-master/lib/Braintree.php';
    require "fpdf.php";
    require 'database.php';


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
        $ran =rand();
        $pdf = new FPDF();
        $pdf->AddPage();
        $adx = "C:\ ";
        $dirrr = trim($adx)."xampp\htdocs\caps\boletas\ ";
        $finald = trim($dirrr). $ran.'.pdf';

        $header= array('Codigo', 'Producto','Cantidad','Precio','Subtotal');
        $datos = array('adawdaw','awdawd','awdawdaw','dawdawdaw','dawdawd','dwadwa','dwdwawd');

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Boleta de compra numero '. $ran, 0, 1, 'C');
        $pdf->Ln();

        $customer = $conn->prepare('SELECT * FROM caps_login WHERE id=' . $_SESSION['user_id']);
        $customer->execute();
        $customerResults = $customer->fetch(PDO::FETCH_ASSOC);

        $pdf->Cell(0, 10, 'Cliente: '. $customerResults['email'], 0, 1, 'L');
        $pdf->Ln();
        date_default_timezone_set("America/Lima");
        $pdf->Cell(0, 10, 'Fecha de compra: '. date("d/m/Y H:i"), 0, 1, 'L');
        $pdf->Ln();
        for($i=0;$i<count($header);$i++){
            $pdf->Cell(38,7,$header[$i],1,0);
        }
        $pdf->Ln();
        for ($i = 0; $i < count($_SESSION['cart']) / 2; $i++) {
            $products = $conn->prepare('SELECT * FROM caps_products WHERE id=' . $_SESSION['cart'][$i * 2]);
            $products->execute();
            $productsResults = $products->fetch(PDO::FETCH_ASSOC);
            $pdf->Cell(38,7,$productsResults['id'],1,0);
            $pdf->Cell(38,7,$productsResults['nombre'],1,0);
            $pdf->Cell(38,7,$_SESSION['cart'][($i * 2)+1],1,0);
            $pdf->Cell(38,7,$productsResults['precio'],1,0);
            $pdf->Cell(38,7,"S/ ".$_SESSION['cart'][($i * 2)+1]*$productsResults['precio'],1,0);
            $pdf->Ln();
        }


        $pdf->Ln();
        $pdf->Cell(0, 10, 'Total: S/ '. calcularPrecioTotal(), 0, 1, 'R');
        $pdf->Output('F', $finald);

        $products = $conn->prepare('SELECT * FROM caps_login WHERE id=' . $_SESSION['user_id']);
        $products->execute();
        $productsResults = $products->fetch(PDO::FETCH_ASSOC);

        $receiver = $productsResults['email'];
        $subject = "Comprobante de pago de compra " . $ran;
        $body = "Se le adjunta su comprobante de pago de la compra " . $ran . PHP_EOL . "http://localhost/caps/boletas/" . $ran . ".pdf";
        $sender = "From:kevmks902@gmail.com";
        if(mail($receiver, $subject, $body, $sender)){
            echo "\n Se envia comprobante de pago a su correo $receiver";
        }else{
            echo "Sorry, failed while sending mail!";
        }


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