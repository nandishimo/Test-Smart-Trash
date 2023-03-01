<?php
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 01 - Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="login.js"></script>
    <link href="style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <header>Lab 01 - Login</header>
    <div class = 'container'>
        <div class = 'form'>
            <input type="hidden" name="login" id="inputhidden">
            <label for="username">User Name : </label><input type="text" name="username" id="username" placeholder="Enter your user name here">
            <label for="password">Password : </label><input type="password" name="password" id="password" placeholder="Enter a password">
            <button type="submit">Login</button>
        </div>
    </div>
    <div>
        <a href="register.php">New User? Click here to register</a>
    </div>
    <footer>Nandish Patel - Oct 2022</footer>
    
</body>
</html>