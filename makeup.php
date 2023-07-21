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
<?php
    session_start();
    $database_name = "product_list"; // name of the database in mySQL
    $con = mysqli_connect("localhost","root","",$database_name); // connect to product_list
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="home.css"> -->
    <style>
        *{
            font-family: Apercu,Gill Sans,sans-serif;
            background-color: hsl(213deg 85% 97%);
        }
        body {
            text-align: left;
            background: hsl(213deg 85% 97%);
            font-family: Apercu,Gill Sans,sans-serif;
            color:hsl(233deg 36% 38%);
        }
        p{
            color:rgb(89, 85, 85);
        }
        .topnav {
            overflow: hidden;
            background-color: hsl(213deg 85% 97%);
            border: 1px solid #7f7fa6;
            position: fixed;
            top: 0px;
            left: 0px;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
        }
        
        .topnav a {
            float: left;
            color: hsl(233deg 36% 38%);
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }
        
        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }
        
        .topnav a.active {
            background-color: #7f7fa6;
            color: white;
        }

        .topnav-right {
            float: right;
        }
        .product{
            border: 1px solid black;
            margin: -1px 19px 3px -1px;
            padding: 10px;
            text-align: center;
            background-color: #efefef;
        }
        table, th, tr{
            text-align: center;
        }
        .title2{
            text-align: center;
            color: white;
            background-color: hsl(233deg 36% 38%);
            padding: 2%;
        }
        h2{
            text-align: center;
            color: hsl(233deg 36% 38%);
            padding: 2%;
        }
        table th{
            background-color: #efefef;
        }
        .btn btn-success{
            color: hsl(233deg 36% 38%);
        }
        .homelogo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width:240px; 
            height:200px;
        }
        .motto {
            text-align: center;
            font-size: 40px;
            font-weight: 6px;
        }
    </style>
</head>
<body>
    <div class="topnav">
        <a href="home.php">Home</a>
        <a class="active" href="makeup.php">Makeup</a>
        <div class="topnav-right">
            <a href="Bag.php">Bag</a>
            <a href="login.php">Log Out</a>
        </div>
        </div>
    </br></br></br></br>
    <img class="homelogo" src="logo-transparent-png.png" alt="logo" >
    <div class="motto">
        Makeup Products. 
    </div>
    <div class="container" style="width: 75%; margin-top: 10px">
        
        <?php
            $query = "SELECT * FROM products ORDER BY id ASC "; // select all from products
            $result = mysqli_query($con,$query); // result of the query 
            if(mysqli_num_rows($result) > 0) { 

                while ($row = mysqli_fetch_array($result)) { // while there are still products left to display

                    ?>
                    <div class="col-lg-4 col-md-4" style="margin-top: 10px">
                        <!-- post request is used to send product id data to successfuly add a product to the cart -->
                        <form method="post" action="Bag.php?action=add&id=<?php echo $row["id"]; ?>">

                            <div class="product">
                                <img style="width:300px; height:350px" src="<?php echo $row["image"]; ?>" class="img-responsive">
                                <h5 class="text-info"><?php echo $row["name"]; ?></h5>
                                <h5 class="text-danger"><?php echo $row["price"]; ?></h5>
                                <input type="text" name="quantity" class="form-control" value="1">
                                <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>">
                                <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>">
                                <input type="submit" name="add" style="margin-top: 5px;" class="btn btn-light"
                                       value="Add to Bag"> 
                                       <!-- displays each product image, price, and quantity and adds to cart -->
                            </div>
                        </form>
                    </div>
                    <?php
                }
            }
        ?>

    </div>


</body>
</html>
