<?php
header('Content-type: text/html; charset=utf-8');


function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        )
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    echo ($result);
    $jsonResult = json_decode($result, true);
    if ($jsonResult['payUrl'] != null)
        header('Location: ' . $jsonResult['payUrl']);
    return $result;
}

$endpoint = 'https://payment.pay2s.vn/v1/gateway/api/create';
$merchantName = "TEST";
$accessKey = 'e222c2c10059cca0e27bf43d0438bba372d58187b137d2c57ef1726f89a82885';
$secretKey = 'e2a4188d15170df363336df866166c2d1f876d638bb5b6d1a029878f84fae24c';
$orderInfo = 'pay with Pay2S';
$order_desc = 'DH{{orderid}}';
$partnerCode = 'PAY2S72MLKFJFURCGPEM';
$redirectUrl = 'https://webhook.site/dd3de633-0a13-40e8-996d-ccd195d7237b';
$ipnUrl = 'https://webhook.site/dd3de633-0a13-40e8-996d-ccd195d7237b';
$amount = '50000';
$bank_accounts = "9877644888|vcb";
$orderId = time() . "";
$requestId = time() . "";
$extraData = '';
$requestType = 'pay2s';
$partnerName = 'Pay2S Payment';
$orderGroupId = '';
$autoCapture = True;
$lang = 'vi';

if (!empty($_POST)) {

    $accessKey = $_POST["accessKey"];
    $secretKey = $_POST["secretKey"];
    $orderInfo = $_POST["orderInfo"];
    $partnerCode = $_POST["partnerCode"];
    $redirectUrl = $_POST["redirectUrl"];
    $amount = $_POST["amount"];
    $orderId = $_POST["orderId"];
    $order_desc = $_POST['order_desc'];
    $orderInfo = str_replace('{{orderid}}', $orderId, $_POST['order_desc']);
    $bank_accounts = $_POST['bank_accounts'];
    $lines = explode("\n", $bank_accounts);
    $bankList = [];
    foreach ($lines as $line) {

        // Tách từng dòng thành account_number và bank_id
        list($accountNumber, $bankId) = explode('|', trim($line));

        // Đưa các giá trị này vào mảng kết quả
        $bankList[] = [
            'account_number' => trim($accountNumber),
            'bank_id' => trim($bankId)
        ];
    }
    $requestId = time() . '';
    $extraData = "";

    //before sign HMAC SHA256 signature
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&bankAccounts=Array&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    $data = array(
        'accessKey' => $accessKey,
        'partnerCode' => $partnerCode,
        'partnerName' => $merchantName,
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'orderType' => $requestType,
        'bankAccounts' => $bankList,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'requestType' => $requestType,
        'signature' => $signature,
    );
    $result = execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);  // decode json

    //Just a example, please check more in there
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./assets/style/style.css" />
</head>

<body>
    <nav class="navbar container navbar-expand-lg justify-content-center">
        <div class="container">
            <a class="navbar-brand" href="https://pay2s.vn"><img src="./assets/pay2s-logo.png" width="120" alt="pay2s"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-2">
                    <li class="nav-item"><a class="nav-link" href="https://pay2s.vn/" aria-current="page">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://pay2s.vn/#tinh-nang" aria-current="page">Tính năng</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://pay2s.vn/#bang-gia" aria-current="page">Bảng giá</a></li>
                    <li class="nav-item"><a class="nav-link" target="_blank" rel="noopener" href="https://docs.pay2s.vn">Tài liệu</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Thông tin
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" rel="privacy-policy" href="https://pay2s.vn/chinh-sach-bao-mat/">Chính sách bảo mật</a></li>
                            <li><a class="dropdown-item" href="https://pay2s.vn/dieu-khoan-dieu-kien/">Điều khoản &amp; điều kiện</a></li>
                        </ul>
                    </li>
                    <li class="nav-item" aria-current="page"><a class="nav-link" href="https://pay2s.vn/tin-tuc/">Tin tức</a></li>
                    <li class="nav-item" aria-current="page"><a class="nav-link" href="https://pay2s.vn/lien-he/">Liên hệ</a></li>
                </ul>
                <a class="btn text-white" href="https://my.pay2s.vn" target="_blank" rel="noopener noreferrer">Đăng nhập</a>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        <h1 class="heading-1 mb-5 mx-auto text-center">Collection Link</h1>
        <div class="wrapper">
            <form class="" method="POST" target="_blank" enctype="application/x-www-form-urlencoded"
                action="index.php">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="partnerCode" class="form-label fw-medium">PartnerCode</label>
                        <input type='text' class="form-control" id="partnerCode" name="partnerCode" value="<?php echo $partnerCode; ?>" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="accessKey" class="form-label fw-medium">AccessKey</label>
                        <input type='text' class="form-control" id="accessKey" name="accessKey" value="<?php echo $accessKey; ?>" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="secretKey" class="form-label fw-medium">SecretKey</label>
                        <input type='text' class="form-control" id="secretKey" name="secretKey" value="<?php echo $secretKey; ?>" class="form-control" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="orderId" class="form-label fw-medium">OrderId</label>
                        <input type='text' class="form-control" id="orderId" name="orderId" value="<?php echo $orderId; ?>" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="order_desc" class="form-label fw-medium">OrderDesc</label>
                        <input type='text' class="form-control" id="order_desc" name="order_desc" value="<?php echo $order_desc; ?>" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="bank_accounts" class="form-label fw-medium">bank_accounts</label>
                        <input type='text' class="form-control" id="bank_accounts" name="bank_accounts" value="<?php echo $bank_accounts; ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="amount" class="form-label fw-medium">Amount</label>
                        <input type='text' class="form-control" id="amount" name="amount" value="<?php echo $amount; ?>" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ipnUrl" class="form-label fw-medium">IPNUrl</label>
                        <input type='text' class="form-control" id="ipnUrl" name="ipnUrl" value="<?php echo $ipnUrl; ?>" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="redirectUrl" class="form-label fw-medium">RedirectUrl</label>
                        <input type='text' class="form-control" id="redirectUrl" name="redirectUrl" value="<?php echo $redirectUrl; ?>" />
                    </div>
                </div>
                <div class="my-md-5 mt-3 mx-auto text-center">
                    <button type="submit" class="btn btn-success btn-block btn-lg" style="min-width:250px">Start Pay2S payment</button>
                </div>
            </form>
            <div class="social text-center mx-auto d-flex flex-md-row flex-column justify-content-center gap-3 mt-5 pt-md-5 pt-0">
                <div class="doc">
                    <a class="d-inline-flex align-items-center gap-2" href="https://docs.pay2s.vn/api/collection-link.html" target="_blank">
                        <i class="bi bi-journal-text" style="font-size: 1.2rem"></i>Documentation</a>
                </div>
                <div class="github">
                    <a class="d-inline-flex align-items-center gap-2" href="https://docs.pay2s.vn/api/collection-link.html" target="_blank">
                        <i class="bi bi-github" style="font-size: 1.2rem"></i>Github</a>
                </div>
                <div class="facebook">
                    <a class="d-inline-flex align-items-center gap-2" href="https://www.facebook.com/pay2s" target="_blank">
                        <i class="bi bi-facebook" style="font-size: 1.2rem"></i>Facebook</a>
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>