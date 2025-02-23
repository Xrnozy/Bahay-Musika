<?php
$firstname = $_POST["firstname"];
$middlename = $_POST["middlename"];
$lastname = $_POST["lastname"];
$course = $_POST["course-selection"];
$gender = $_POST["gender"];
$phone = $_POST["phone1"] . $_POST["phone2"];
$address = $_POST["address"];

echo "My name is <b> $firstname $middlename. $lastname </b>. 
My course is <b>$course </b>.
I am a $gender student and my mobile number is $phone.
I am living at $address.";
?>