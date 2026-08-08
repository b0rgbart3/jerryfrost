<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../css/review.css" />
</head>
<body>
<a href='../index.php'><div class='backContainer'><div class='goBack'><img src='../interface/backArrow.svg'></div><div class='goBackText'>Go Back Home</div></div></a>
</a>
    <br>

    <div class='loginForm'>
    <h2>Admin Login</h2>
        <form action="authenticate.php" method="post">
            <div class='labelDiv'>
            <label for="username">Username:</label></div>
            <input type="text" id="username" name="username" required>
            <br>
            <div class='labelDiv'>
            <label for="password">Password:</label></div>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit" class='loginButton'>Login</button>
        </form>
    </div>
</body>
</html>
