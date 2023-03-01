<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 01 - Register</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="register.js"></script>
    <link href="style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <header>Lab 01 - Register New User</header>
    <div class='container'>
        <div class = 'form'>
            <input type="hidden" name="register" id="inputhidden">
            <label for="username">User Name : </label><input type="text" name="username" id="username" placeholder="Enter your user name here">
            <label for="password">Password : </label><input type="password" name="password" id="password" placeholder="Enter a password">
            <button type="submit">Register</button>
        </div>
    </div>
    <div>
        <a href="login.php">Already have an account? Click here to login</a>
    </div>
    <footer>Nandish Patel - Oct 2022</footer>
</body>
</html>