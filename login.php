<?php

$is_invalid = false; //if pass is invalid

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php"; //connect to db
    
    //insert val from form
    $sql = sprintf("SELECT * FROM user 
                    WHERE email = '%s'", 
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql); // returns a result
    
    $user = $result->fetch_assoc(); //returns record if found
    
    if ($user) {//if record found
        
        if (password_verify($_POST["password"], $user["password_hash"])) { //verify hash matches text
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: home.php");
            exit;
        }
    }

    $is_invalid = true;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="signup.css">
</head>
<body>

    <img src="logo-transparent-png.png" alt="logo" width="90px" height="75px">
    <h1>Login</h1>    
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
    <div class="form-inputs">
    <form method="post">
        <label for="email">EMAIL:</label>
        <input type="email" name="email" id="email" placeholder="abc@mail.com"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"> <br><br>
        
        <label for="password">PASSWORD:</label>
        <input type="password" name="password" id="password" placeholder="type password">
        <br><br>
        
        <button>Log in</button>
        <p>No account? <a href="signup.html">sign up</a></p>
    </form>
    </div>
    
</body>
</html>







