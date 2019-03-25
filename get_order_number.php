<?php

// You need to use this function in your processorder_v4.php file in order to track
// what the next order number is.  If there are any errors, this function should
// throw an exception with an error messages that matches the error encoded.
// The calling code in processorder_v4.php should catch the exception and deal with it.

function get_order_number(): int
{
    // open the file that stores the order count
    // mode c+ means to open the file for reading and writing, do not truncate it,
    // and if it doesn't exist, create it
    $next_order_number_count_file = fopen("next_order_number.txt", "cb+");
// YOUR CODE HERE: you need to add error checking for fopen (hint: throw an exception!)

// YOUR CODE HERE: you need to get an exclusive lock on $next_order_number_count_file
// YOUR CODE HERE: you need to add error checking for flock (hint: throw an exception!)

    // get the next order number from the file
    // if the file is empty, which happens when it is created by fopen, then false will be returned
    $next_order_number = fgets($next_order_number_count_file);
    if ($next_order_number === false) {
        // since there is no order number, we will assume we are order 0
        $next_order_number = 0;
    }

    // Truncate the file to 0 size.  This deletes everything in the file.
    ftruncate($next_order_number_count_file, 0);
    // rewind the file pointer to the very start of the file
    rewind($next_order_number_count_file);
    // write out the next order number to use by incrementing the one we just read in
    fputs($next_order_number_count_file, $next_order_number + 1);
    // close the file
    fclose($next_order_number_count_file);

    // return the order number that should be used for the order being processed
    return $next_order_number;
}