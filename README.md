ICS 325-02 Spring 2019 - Assignment 7
=========================

Purpose
-------
* Learn how JavaScript and PHP can interact via JSON.
* Learn the basics of JSON.
* Learn the basics of asynchronous browser requests (AJAX).
* Learn how to maintain a counter file.

Resources and Examples
----------------------
* w3cschools [JSON examples](https://www.w3schools.com/js/js_json_intro.asp).

Collaboration
-------------
You can work with 1 or 2 other students on this assignment.  Make sure to mention who you worked with when you submit your assignment in D2L.

Prerequisites
-------------
You need to use your Bob's Order code from Assignment 3 Part 1 or you can use the code I've provided.

Instructions
------------
### Instructions to set up the code to run


Next you need to set up PhpStorm.  We will be using the built-in PHP CGI server for this assignment.  To do so, first make sure you have the git repo open in PhpStorm by using the Open Directory menu item under File in PhpStorm (`File->Open Directory`).  Next go to `Run->Edit Configurations...` Click the green `+` to create a new configuration.  Select `PHP Built-in Web Server`.  Change the name to `Cookies and Sessions Lab`.  Leave host as `localhost`.  Set the port to `8080`.  Set the `Document root` to your git repo directory by clicking the `...` button next to the field and using the file chooser to select it.  If there is a red ! icon near the bottom right of the window, click the `Fix` button and specify your PHP interpreter.  Once done, click `Ok` to exit the Edit Configurations window.  Next hit the green run button to start the PHP CGI web server.  Then go to your web browser and enter this url [http://localhost:8080/orderform_json.html](http://localhost:8080/orderform_json.html).  

`orderform_json.html` is broken down into 4 sections:
* The Bob's Auto Parts HTML form
* JSON sent to PHP from JavaScript: The JSON string that PHP will receive from JavaScript.
* JSON received from PHP to JavaScript: The JSON string that PHP sent to JavaScript.
* Order Result (JSON parsed from PHP by JavaScript): The order results output that would normally be shown to the user.  For demo purposes, a random number is generated for the order number.

`process_order_json.php` is the PHP script that `orderform_json.html` interacts with via JSON requests.

### Assignment Work
You should first read the w3cschools [JSON examples](https://www.w3schools.com/js/js_json_intro.asp).  Read all sections except for "JSON JSONP".  Then experiment with the example code I've provided.  Read the code and all the code comments to gain an understanding of the code.

You will then modify your Bob's Auto Parts order program from Assignment 3 Part 1.  Your program will contain the following files:
* `orderform_v2.html` that I've provided or yours from Assignment 3 Part 1.  You won't need to make any changes to this file.
* `processorder_v4.php` that I've provided or yours from Assignment 3 Part 1.  You will need to modify this file to handle order numbers.
* `next_order_number.txt` keeps a record of the next order number to be used.
* `orders.txt` is used to keep a record of each order.
* `vieworder_json.php` is similar to `vieworders.php` from Assignment 3 Part 1.  It should accept a JSON object that specifies which order to look up, and then return that order as a JSON object.
* `vieworder.html` is used to send a JSON request to `vieworder_json.php` and then display the JSON response.
* `get_order_number.php` provides a function you need to finish and use in the `processorder_v4.php` file.

You should start by modifying your `processorder_v4.php` from Assignment 3 Part 1 **if you don't use** the `processorder_v4.php` I've provided. You need to use `require_once` to pull in the code from `get_order_number.json`.  Then you need to use the `get_order_number()` function to get the next order number.  It will throw an exception if there is an error.  You should report that there is an error and not continue with the order if an exception is thrown.

`get_order_number.php` provides the `get_order_number()` function which keeps track of the current order number.  Whenever an order is successful, an order number should be assigned to the current order and written to the `orders.txt` file along with all the other order information.  The order number should be the first thing written before the order date.  It should be separated from date by a tab.  Then the next order number available should be written to `next_order_number.txt`.

Next, make a copy of `orderform_json.html` and name it `vieworder.html`.  Modify the form to only have 1 text input field: order number.  Then modify the JavaScript code to send a JSON object with just the order number to `vieworder_json.php`.  You can leave the parts of the page **JSON sent to PHP from JavaScript** and **JSON received from PHP to JavaScript** the same.  Use the section **Order Result (JSON parsed from PHP by JavaScript)** to display the order information returned by `vieworder_json.php` as you would show it to the user.

Next you will create a new version of `vieworders.php` named `vieworder_json.php` that will accept a single JSON object that specifies which order to view.  `vieworder_json.php` should then read the `orders.txt` file, find the correct order number, and send back a JSON response containing the order.  If any errors occur, those should be sent back instead of the order information.  You can look at `process_order_json.php` to see how to receive and send JSON.  Make sure to update the code that reads `orders.txt` to read the order number for each order.

Note that I've set up a `.gitignore` file in the git repository for this assignment that will prevent certain files from being added to the git repo.  The following files will not show up in GitKraken in the staging area:
`json_input_to_php.txt`
`php_decoded_json.txt`
`next_order_number.txt`
`orders.txt`

Grading
-------
Points|Requirement
------|-----------
1 | `processorder_v4.php` writes all order information to orders.txt including the order number.
1 | `vieworder_json.php` reads all order information from orders.txt including the order number.
1 | The next order number to use is read from `next_order_number.txt`.
1 | After a successful order, then next order number to use is incremented and written to `next_order_number.txt`.
3 | The code to read from and write to `next_order_number.txt` handles errors as specified in the given code `get_order_number.php`. (The YOUR CODE HERE sections)
2 | `vieworder.html` sends a proper JSON request to `vieworder_json.php` containing the order number to look up.
2 | `vieworder_json.php` sends a proper JSON response with the order information from the order requested.
1 | `vieworder_json.php` sends an error JSON response when appropriate such as when an error occurred trying to read from orders.txt or the specified order number is not found.
1 | `vieworder.html` displays an error to the user when an error is sent as part of the JSON response from `vieworder_json.php`.
5 | `vieworder.html` displays the order information from the JSON response from `vieworder_json.php`.
2 |  Turn in via github.
**20**| **Total**
