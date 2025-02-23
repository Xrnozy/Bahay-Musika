<?php
    $name = $_POST['name'];
    $selected_radio = $_POST['payment'];
    $address = $_POST['address'];
    $postcode = $_POST['postcode'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $amount = $_POST['amount'];
    $account_name = $_POST['account_name'];
    $account_number = $_POST['account_number'];

    echo "My name is <b>$name</b> </br>
    I am living at $address, $postcode, $country. </br> 
    My mobile number is +63$phone </br>
    </br>
    The total Amount that I need to pay is $amount. </br>
    </br>
    <b>Mode of payment:</b> $selected_radio </br>
    <b>Account Name:</b> $account_name </br>
    <b>Account Number:</b> $account_number </br>";
?>