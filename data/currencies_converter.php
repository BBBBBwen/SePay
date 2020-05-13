<?php require_once "page_not_found.php"; ?>
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

        $result = updateCurrency($_SESSION['id'], $from, $to, $user[$from] - $amount, $converted - $fee + $user[$to]);

        insertPayment($_SESSION['id'], null, time(), "currency exchange from", $amount, $from, 'Captured');
        insertPayment($_SESSION['id'], null, time(), "currency exchange to", $converted - $fee, $to, 'Captured');
        header("Location: wallet.php");
    } else {
        echo "<script> alert('no such user or not enough balance');parent.location.href='wallet.php'; </script>";
    }
}

function convertCurrency($amount, $from, $to)
{
    $API = 'ae1f68b927a056b743020990dd16ed6a';
    $curl = file_get_contents("http://data.fixer.io/api/latest?access_key=$API&symbols=$from,$to");

    if ($curl) {
        $arr = json_decode($curl, true);
        if ($arr['success']) {
            $from = $arr['rates'][$from];
            $to = $arr['rates'][$to];

            $rate = $to / $from;
            $result = round($amount * $rate, 6);
            return $result;
        } else {
            echo $arr['error']['info'];
        }
    } else {
        echo "Error reaching api";
    }
}

?>