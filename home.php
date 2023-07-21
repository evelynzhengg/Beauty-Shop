<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php"; //connected
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}"; //retrive users with id
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc(); 
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div class="topnav">
    <a class="active" href="home.php">Home</a>
    <a href="makeup.php">Makeup</a>
    <div class="topnav-right">
        <a href="Bag.php">Bag</a>
        <a href="login.php">Log Out</a>
    </div>
    </div>
    <br><br>
    
    <?php if (isset($user)): ?>
        
        <p>Hello, <?= htmlspecialchars($user["name"]) ?>!</p>
        
    <?php else: ?>
        
        <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
        
    <?php endif; ?>

    <img class="homelogo" src="logo-transparent-png.png" alt="logo" >
    <div class="motto">
        Popular brands at afforable prices. 
    </div>
    
    <div>
    <div class="gfeature">
        <img class="logo" src="../pictures/glossier/glossier-logo.png" alt="glossierlogo" width=25%>
        <img class="product" src="../pictures/glossier/cloud-paint.png" alt="glossier-blush">
        <h1>Featured: Cloud Paint</h1>
        <p>Seamless cheek color</p>
        <p>A seamless, buildable gel-cream blush that leaves cheeks with a gorgeous dewy glow, 
            that’s never streaky or chalky. Coverage is just sheer enough to easily blend and 
            layer without overdoing it. Simply dab it onto cheeks and tap into skin for a natural, 
            flushed-from-within, golden hour glow.</p>
        <button class="gbutton"><a href="makeup.php">Makeup</a></button>
  
    </div>
    <div class="fb-feature">
        <img class="logo" src="../pictures/fenty/fenty-logo.png" alt="fentylogo" width=25%>
        <img class="product" src="./pictures/fenty/glassbomb.png" alt="glossbomb" width=25%>
        <h1>Featured: Glass bomb universal lip luminizer</h1>
        <p>The stop-everything, give-it-to-me lip gloss that feels as good as it looks. 
            Fenty Beauty Gloss Bomb Universal Lip Luminizer delivers explosive shine, in seven universal shades 
            handpicked by Rihanna herself to be the ultimate finishing touch to any look.</p>
        <p>One luscious swipe of Gloss Bomb’s XXL wand gives lips more to love, while conditioning 
        shea butter enriches from within. Wearing Gloss Bomb makes lips look instantly fuller, 
        with a non-sticky formula that’s super shiny and has an addictive peach-vanilla 
        scent you just can’t get enough of.</p>
        <button class="fb-button"><a href="makeup.php">Makeup</a></button>
     
    </div>
    <div class="rb-feature">
        <img class="logo" src="../pictures/rarebeauty/rb-logo.png" alt="rarebeautylogo"width=25%>
        <img class="product" src="./pictures/rarebeauty/warm-bronzer.png" alt="bronzer" width=25%>
        <h1>Featured: Warm Wishes Effortless Bronzer Stick</h1>
        <p>A breakthrough bronzing stick that creates an instant sun-kissed glow and 
            blends seamlessly for a second-skin finish—just swipe on, blend, and go!</p>
        <button class="rb-button"><a href="makeup.php">Makeup</a></button>
      
    </div>
    </div>
</body>
</html>
    
    
    
    
    
    