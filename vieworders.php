<!DOCTYPE html>
<html>
<head>
    <title>Bob's Auto Parts - View Orders</title>
</head>
<body>
<?php

require_once "how_find_bob_decode.php";

try {
    // open and lock the file
    $orders_file = fopen('orders.txt', 'rb');
    if ($orders_file === false) {
        throw new Exception("Could not open the orders file!");
    }
    $lock_result = flock($orders_file, LOCK_SH | LOCK_NB);
    if ($lock_result === false) {
        throw new Exception("Could not get a lock on the orders file!");
    }

    // loop through the lines in the file
    while(feof($orders_file) === false) {
        // only strip \n or \r so we don't strip off any empty fields (normally \t would be stripped)
        $line = trim(fgets($orders_file), "\n\r");
        // don't process $line if we didn't read any data
        if ($line === false) {
            continue;
        }

        // put the order into an array
        $order = explode("\t", $line);
        // unpack the array into individual variables
        list($order_date, $tireqty, $oilqty, $sparkqty, $totalamount, $how_find_bob, $notes) = $order;

        // print out the order for this line
        echo "Date: $order_date<br/>\n";
        echo "Tire Qty: $tireqty<br/>\n";
        echo "Oil Qty: $oilqty<br/>\n";
        echo "Spark Qty: $sparkqty<br/>\n";
        echo "Total Cost: $totalamount<br/>\n";
        echo "How did you find Bob's?:" . how_find_bob_decode($how_find_bob) . "<br/>\n";
        echo "Notes: $notes<br/>\n<br/>\n";
    }

    // unlock and close the file
    flock($orders_file, LOCK_UN);
    fclose($orders_file);
} catch (Exception $exception) {
    echo "Sorry, there was a problem retrieving the orders.<br />\n";
    echo "Error: " . $exception->getMessage() . "\n";
}

?>
</body>
</html>
