<?php

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    $menu = '<header>
    <div class="Logo">
        <a id="logo" href="/"><img src="" alt="Ben Movies DB"></a>
    </div>
    <nav class="main-nav">
        <span>Welcome to our online movie DB. Interested? See out pricing list -> </span>
        <a href="/price.php">Pricing</a>

    </nav>
    <nav class="sub-nav">';
    if(isset($_SESSION['cart_items']) && count($_SESSION['cart_items']) > 0){
        $aa = $_SESSION['cart_items'] && count($_SESSION['cart_items']) > 0 ? count($_SESSION['cart_items']):'';
        $menu.= '<a class="cart-notice" href="/cart.php" style="color:#ffffff">
                    <i class="fas fa-shopping-basket"></i><span style="margin-left:5px">'.$aa.'</span></a>';
    };
    $menu .='<a href="myaccount/welcome.php">My account</a>
        <a href="register.php">Don`t have an accout yet? Register</a>
    </nav>
</header>';
}else{
    $user = $_SESSION["name"].' '.$_SESSION['surname'];
    $menu = '<header>
    <div class="Logo">
        <a id="logo" href="/myaccount/welcome.php"><img src="" alt="Ben Movies DB"></a>
    </div>
    <nav class="main-nav">
        <a href="movies.php">Movies</a>
        <a href="recent.php">Recent added</a>
        <a href="/price.php">Pricing</a>
    </nav>
    <nav class="sub-nav">
            <span class="my-5">Hi, <b>'.$user .'</b></span>';
    if(isset($_SESSION['cart_items']) && count($_SESSION['cart_items']) > 0){
        $aa = $_SESSION['cart_items'] && count($_SESSION['cart_items']) > 0 ? count($_SESSION['cart_items']):'';
        $menu.= '<a class="cart-notice" href="/cart.php" style="color:#ffffff">
                    <i class="fas fa-shopping-basket"></i><span style="margin-left:5px">'.$aa.'</span></a>';
    };
        $menu .='<a href="my_details.php">My details</a>
            <a href="/myaccount/logout.php">Log out</a>
        </nav>
</header>';
}
echo $menu;
?>

