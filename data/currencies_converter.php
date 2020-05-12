<?php require_once "../content/connect_database.php"; ?>
<?php session_start();
if (isset($_SESSION['id'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $amount = $_POST['amount'];
    $user = getUserBalance($_SESSION['id']);

    if ($user && $user[$from] >= $amount) {
        $converted = convertCurrency($amount, $from, $to);
        $fee = $converted * 0.01;

        $balance_from = $user[$from] - $amount;
        $balance_to = $converted - $fee + $user[$to];
        $result = updateCurrency($_SESSION['id'], $from, $to, $balance_from, $balance_to);

        insertPayment($_SESSION['id'], time(), "currency exchange from", $balance_from, $from, 'Captured');
        insertPayment($_SESSION['id'], time(), "currency exchange to", $balance_to, $to, 'Captured');
        header("Location: wallet.php");
    } else {
        echo "<script> alert('no such user or not enough balance');parent.location.href='wallet.php'; </script>";
    }
}

function convertCurrency($amount, $from, $to){
    $API = 'ae1f68b927a056b743020990dd16ed6a';
    $curl = file_get_contents("http://data.fixer.io/api/latest?access_key=$API&symbols=$from,$to");

    if($curl)
    {
        $arr = json_decode($curl,true);
        if($arr['success'])
        {
            $from = $arr['rates'][$from];
            $to = $arr['rates'][$to];

            $rate = $to / $from;
            $result = round($amount * $rate, 6);
            return $result;
        }else{
            echo $arr['error']['info'];
        }
    }else{
        echo "Error reaching api";
    }
}
?>