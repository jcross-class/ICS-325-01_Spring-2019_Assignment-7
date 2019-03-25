<?php

// a helper function to decode the "how find bob" field from the HTML form
function how_find_bob_decode($how_find_bob)
{
    switch ($how_find_bob) {
        case 'a':
            return 'I\'m a regular customer';
            break;
        case 'b':
            return 'TV advertising';
            break;
        case 'c':
            return 'Phone directory';
            break;
        case 'd':
            return 'Word of mouth';
            break;
        default:
            throw new Exception("An invalid value was sent for how you found Bob's.");
    }
}