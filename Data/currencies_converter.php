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

        $result = $converted - $fee + $user[$to];
        $sql = "UPDATE currency SET ".$from."=" . ($user[$from] - $amount) . " , ".$to."=" . $result . "WHERE user_id='" . $_SESSION['id'] . "'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        header("Location: wallet.php");
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