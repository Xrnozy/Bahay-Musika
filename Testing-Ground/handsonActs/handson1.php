<!DOCTYPE html>
<html>

<head>
</head>

<body>

    <form action="handson2.php" method="post">
        <fieldset>
            <legend><b>Basic Information</b></legend>
            <ol>
                <li><b>Name:</b> <input type="text" name="name" size="20"></li>
                <li><b>Email:</b> <input type="email" name="email" size="20"></li>
                <li><b>Phone:</b> <input type="number" name="phone" size="20"></li>
            </ol>
        </fieldset>

        <fieldset>
            <legend><b>Home Address</b></legend>
            <ol>
                <li><b>Address:</b> <textarea name="address" cols="30" rows="9"></textarea></li>
                <li><b>Post Code:</b> <input type="number" name="postcode" size="20"></li>
                <li><b>Country:</b> <input type="text" name="country" size="20"></li>
            </ol>
        </fieldset>

        <fieldset>
            <legend><b>Type of Payment</b></legend>
            <ol>
                <li>
                    <fieldset>
                        <legend><b>Payment</b></legend>
                        <ol class="radio">
                            <li>
                                <input type="radio" value="Credit" name="payment">
                                <b>Credit</b>
                            </li>
                            <li>
                                <input type="radio" value="Cash" name="payment">
                                <b>Cash</b>
                            </li>
                            <li>
                                <input type="radio" value= "Gcash" name="payment">
                                <b>Gcash</b>
                            </li>
                        </ol>
                    </fieldset>
                </li>
                <li><b>Account Number:</b> <input type="number" name="account_number" size="20"></li>
                <li><b>Account Name:</b> <input type="text" name="account_name" size="20"></li>
                <li><b>Amount:</b> <input type="number" name="amount" size="20"></li>
            </ol>
        </fieldset>

        <fieldset>
            <input type="submit" name="submit" value="Submit">
        </fieldset>
    </form>
</body>
</html>