<?php require_once "page_not_found.php"; ?>
<?php require_once "../content/connect_database.php"; ?>
<?php session_start();
if (isset($_SESSION['id'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $amount = $_POST['amount'];
    $user = getUserBalance($_SESSION['id']);

    if ($user && $user[$from] >= $amount && $from != $to) {
        $fee = round($amount * 0.01, 2);
        $converted = convertCurrency($amount - $fee, $from, $to);

        $result = updateCurrency($_SESSION['id'], $from, $to, $user[$from] - $amount, $converted - $fee + $user[$to]);
        $result = updateBalance(1, $from, $fee);//transfer surcharge into admin account
        
        insertPayment($_SESSION['id'], null, time(), "currency exchange from ".$from.", with ".$fee." ".$from." surcharge.", $amount, $from, 'Captured');
        insertPayment($_SESSION['id'], null, time(), "currency exchange to ".$to, $converted - $fee, $to, 'Captured');
        header("Location: wallet.php");
    } else if(!$user){
        echo "<script> alert('no such user');parent.location.href='wallet.php'; </script>";
    } else if($user[$from] < $amount){
        echo "<script> alert('no enough balance');parent.location.href='wallet.php'; </script>";
    } else {
        echo "<script> alert('cannot exchange same currency');parent.location.href='wallet.php'; </script>";
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