<?php
// create short variable names
$tireqty = (int) $_POST['tireqty'];
$oilqty = (int) $_POST['oilqty'];
$sparkqty = (int) $_POST['sparkqty'];
$notes = htmlspecialchars($_POST['notes']);
$how_find_bob = htmlspecialchars($_POST['find']);

require_once "how_find_bob_decode.php";
require_once "get_order_number.php";

?>
<!DOCTYPE html>
<html>
<head>
    <title>Bob's Auto Parts - Order Results</title>
</head>
<body>
<h1>Bob's Auto Parts</h1>
<h2>Order Results</h2>
<?php
try {
    // check for errors in the submitted data first
    if ($tireqty < 0 || $oilqty < 0 || $sparkqty < 0) {
        throw new Exception("All quantities must be 0 or greater.");
    }

    if (($tireqty + $oilqty + $sparkqty) == 0) {
        throw new Exception("You must order at least 1 of something.");
    }

    $how_find_bobs_string = how_find_bob_decode($how_find_bob);

    // next open and lock the file
    $orders_file = fopen('orders.txt', 'ab');
    if ($orders_file === false) {
        throw new Exception("Could not open the orders file!");
    }
    $lock_result = flock($orders_file, LOCK_EX | LOCK_NB);
    if ($lock_result === false) {
        throw new Exception("Could not get a lock on the orders file!");
    }

    try {
        $order_number = get_order_number();
    } catch (Exception $exception) {
        throw new Exception("Couldn't get the order number for this order: " . $exception->getMessage());
    }

    // things look good, calculate the order totals
    $order_date = date('H:i, jS F Y');
    $totalqty = 0;
    $totalqty = $tireqty + $oilqty + $sparkqty;
    echo "<p>Items ordered: " . $totalqty . "<br />";
    $totalamount = 0.00;

    define('TIREPRICE', 100);
    define('OILPRICE', 10);
    define('SPARKPRICE', 4);

    $totalamount = $tireqty * TIREPRICE
        + $oilqty * OILPRICE
        + $sparkqty * SPARKPRICE;

    // write out the order results to orders.txt
    // YOUR CODE HERE: make sure to write out the $order_number before the $order_data
    $fputs_result = fputs($orders_file, "$order_date\t$tireqty\t$oilqty\t$sparkqty\t$totalamount\t$how_find_bob\t$notes" . PHP_EOL);
    if ($fputs_result === false) {
        throw new Exception("Could not write the order to the orders file!");
    }

    // show the user the order results
    echo "<p>Order processed at ";
    echo "$order_date";
    echo "</p>";

    echo '<p>Your order is as follows: </p>';

    echo $tireqty . ' tires<br />';
    echo $oilqty . ' bottles of oil<br />';
    echo $sparkqty . ' spark plugs<br />';

    echo "Subtotal: $" . number_format($totalamount, 2) . "<br />";

    $taxrate = 0.10;  // local sales tax is 10%
    $totalamount = $totalamount * (1 + $taxrate);
    echo "Total including tax: $" . number_format($totalamount, 2) . "</p>";
    echo "You found Bob's via: " . $how_find_bobs_string . "<br />\n";
    echo "Order notes: " . $notes . "<br />\n";


    // for safety, flush the file write buffer before unlocking
    fflush($orders_file);
    // unlock and close the file
    flock($orders_file, LOCK_UN);
    fclose($orders_file);
} catch (Exception $exception) {
    echo "Sorry, there was a problem with your order.<br />\n";
    echo "Error: " . $exception->getMessage() . "\n";
}
?>
</body>
</html>