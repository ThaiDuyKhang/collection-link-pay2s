<?php
header('Content-type: text/html; charset=utf-8');


$accessKey = 'e222c2c10059cca0e27bf43d0438bba372d58187b137d2c57ef1726f89a82885';
$secretKey = 'e2a4188d15170df363336df866166c2d1f876d638bb5b6d1a029878f84fae24c';

if (!empty($_GET)) {
    $partnerCode = $_GET["partnerCode"];
    $orderId = $_GET["orderId"];
    $requestId = $_GET["requestId"];
    $amount = $_GET["amount"];
    $orderInfo = $_GET["orderInfo"];
    $orderType = $_GET["orderType"];
    $transId = $_GET["transId"] ?? '';
    $resultCode = $_GET["resultCode"];
    $message = $_GET["message"];
    $payType = $_GET["payType"];
    $responseTime = $_GET["responseTime"];
    $extraData = $_GET["extraData"] ?? '';
    $m2signature = $_GET["m2signature"];

    //Checksum
    $rawHash = "accessKey=$accessKey&amount=$amount&message=$message&orderId=$orderId&orderInfo=$orderInfo&orderType=$orderType&partnerCode=$partnerCode&payType=$payType&requestId=$requestId&responseTime=$responseTime&resultCode=$resultCode";
    $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);

    echo "<script>console.log('Debug huhu Objects: " . $rawHash . "' );</script>";
    echo "<script>console.log('Debug huhu Objects: " . $partnerSignature . "' );</script>";


    if ($m2signature == $partnerSignature) {
        if ($resultCode == '0') {
            $result = '<div class="alert alert-success"><strong>Payment status: </strong>Success</div>';
        } else {
            $result = '<div class="alert alert-danger"><strong>Payment status: </strong>' . $message . '</div>';
        }
    } else {
        $result = '<div class="alert alert-danger">This transaction could be hacked, please check your signature and returned signature</div>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Pay2S Sandbox</title>
    <link rel="icon" type="image/x-icon" href="./assets/favicon_1.ico">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 class="panel-title">Payment status/Kết quả thanh toán</h1>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $result; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">PartnerCode</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="partnerCode" value="<?php echo $partnerCode; ?>"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">AccessKey</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="accessKey" value="<?php echo $accessKey; ?>"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">OrderId</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="orderId" value="<?php echo $orderId; ?>"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">transId</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="transId" value="<?php echo $transId; ?>"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">OrderInfo</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="orderInfo" value="<?php echo $orderInfo; ?>"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">orderType</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="orderType" value="<?php echo $orderType; ?>"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">Amount</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="amount" value="<?php echo $amount; ?>"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">Message</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="message" value="<?php echo $message; ?>"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">payType</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="payType" value="<?php echo $payType; ?>"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">ExtraData</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' type="text" name="extraData" value="<?php echo $extraData; ?>"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">signature</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="signature" value="<?php echo $m2signature; ?>"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="/" class="btn btn-primary">Back to continue payment...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"> Debugger</h3>
                    </div>
                    <div class="panel-body">
                        <?php

                        echo '<b> SecretKey:</b> (This value is hard-coded in the php file. If you need to change it, do it manually)<pre>' . $secretKey . '</pre></br>';

                        echo '<b> RawData: </b><pre>' . $rawHash . '</pre></br>';

                        echo '<b>MoMo signature: </b><pre>' . $m2signature . '</pre></br>';

                        echo '<b>Partner signature: </b><pre>' . $partnerSignature . '</pre></br>';

                        if ($m2signature == $partnerSignature) {
                            echo '<div class="alert alert-success"><strong>INFO: </strong>Pass Checksum</div>';
                        } else {
                            echo '<div class="alert alert-danger" role="alert"> <strong>ERROR!:</strong> Fail checksum</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>