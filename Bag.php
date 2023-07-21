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
<?php // guidance from https://www.youtube.com/watch?v=IO5ezsURqyg&t=1221s
    session_start();
    $database_name = "product_list"; // name of the database in mySQL
    $con = mysqli_connect("localhost","root","",$database_name); // connect to product_list

    if (isset($_POST["add"])){ // check if "add to bag" is clicked
        if (isset($_SESSION["cart"])){
            $item_array_id = array_column($_SESSION["cart"],"product_id"); // find IDs of products in the array cart
            if (!in_array($_GET["id"],$item_array_id)){ // if not in cart already
                $count = count($_SESSION["cart"]); // create a new item for the cart and add it to the end of the cart array.
                $item_array = array(
                    'product_id' => $_GET["id"],
                    'item_name' => $_POST["hidden_name"],
                    'product_price' => $_POST["hidden_price"],
                    'item_quantity' => $_POST["quantity"],
                );
                $_SESSION["cart"][$count] = $item_array;
                echo '<script>window.location="Bag.php"</script>'; // redirect to cart page 
            }else{

                $temp_quantity = 0;
                foreach ($_SESSION["cart"] as $keys => $value){
                    if ($value["product_id"] == $_GET["id"]){
                        $temp_quantity = $value['item_quantity'];
                        unset($_SESSION["cart"][$keys]);
                    }
                }
                $count = count($_SESSION["cart"]); // create a new item for the cart and add it to the end of the cart array.
                $item_array = array(
                        'product_id' => $_GET["id"],
                        'item_name' => $_POST["hidden_name"],
                        'product_price' => $_POST["hidden_price"],
                        'item_quantity' => $temp_quantity + $_POST["quantity"],
                        // 'user' => htmlspecialchars($user["name"])
                        );
                $_SESSION["cart"][$count] = $item_array;

                echo '<script>window.location="Bag.php"</script>';
            }
        }else{
            $item_array = array( // if cart session doesn't exist yet create cart
                'product_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'product_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"],
            );
            $_SESSION["cart"][0] = $item_array;
        }
    }

    if (isset($_GET["action"])){
        if ($_GET["action"] == "delete"){
            foreach ($_SESSION["cart"] as $keys => $value){
                if ($value["product_id"] == $_GET["id"]){
                    unset($_SESSION["cart"][$keys]);
                }
            }
        }
    }
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>
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
    </style>
</head>
<body>
    <div class="topnav">
        <a href="home.php">Home</a>
        <a href="makeup.php">Makeup</a>
        <div class="topnav-right">
            <a class="active" href="Bag.php">Bag</a>
            <a href="login.php">Log Out</a>
        </div>
        </div>
    <h2><a href="makeup.php">Back to Products</a></h2>
    <h2><?= htmlspecialchars($user["name"]) ?>'s Cart</h2>
    <div style="clear: both"></div>
        <h3 class="title2">Shopping Cart Details</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
            <tr>
                <th width="28%">Product Name</th>
                <th width="12%">Quantity</th>
                <th width="10%">Price Details</th>
                <th width="13%">Total Price</th>
                <th width="14%">Remove Item</th>
            </tr>

    <?php
                if(!empty($_SESSION["cart"])){
                    $total = 0;
                    foreach ($_SESSION["cart"] as $key => $value) {
                        ?>
                        <tr>
                            <!-- displays name, quantity, price, and total  -->
                            <td><?php echo $value["item_name"]; ?></td> 
                            <td><?php echo $value["item_quantity"]; ?></td>
                            <td>$ <?php echo $value["product_price"]; ?></td>
                            <td>
                                $ <?php echo number_format($value["item_quantity"] * $value["product_price"], 2); ?></td>
                            <td><a href="Bag.php?action=delete&id=<?php echo $value["product_id"]; ?>"><span
                                        class="text-danger">Remove Item</span></a></td>

                        </tr>
                        <?php
                        $total = $total + ($value["item_quantity"] * $value["product_price"]); // calculates cart toal
                    }
                        ?>
                        <tr>
                            <td colspan="3" align="right">Total</td>
                            <th align="right">$ <?php echo number_format($total, 2); ?></th>
                            <td></td>
                        </tr>
                        <?php
                    }
                ?>
        </div>


</body>
</html>