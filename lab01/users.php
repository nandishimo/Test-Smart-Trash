<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="users.js"></script>
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <title>User Management</title>
</head>
<body>
    <header>
        <h1>User Management</h1>
    </header>
    <div class = 'container'>
        <a href="index.php">Home</a>
        <a href="message.php">Messaging</a>
        <a href="roles.php">Role Management</a>
        <a href="login.php">Logout</a>
        <div class = 'form'>
            <input type="hidden" name="addUser" id="inputhidden">
            <label for="username">User Name : </label><input type="text" name="username" id="username" placeholder="Enter your user name here">
            <label for="password">Password : </label><input type="password" name="password" id="password" placeholder="Enter a password">
            <label for="role">Role : </label>
            <select name="role" id="role">
                <option value="2">Administrator</option>
                <option value="3">Moderator</option>
                <option value="4">User</option>
            </select>
            <button type="submit">Add User</button>
        </div>
        <div id='users'>

        </div>
    </div>
    <div>
        Users need managing!
    </div>
    <footer>
        Nandish Patel - Nov 2022
    </footer>
</body>
</html>