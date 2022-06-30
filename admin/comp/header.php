<?php
$is_admin = $_SESSION['is_admin'];
if($is_admin == 1){
    $user = $_SESSION['name'] .' (Administrator)';
}else{
    $user = $_SESSION['name'];
}

$menu = '<header>
    <div class="Logo">
        <a id="logo" href="dashboard"><img src="" alt="Ben Movies DB"></a>
    </div>
    <nav class="main-nav">
        <a href="/admin/dashboard.php">Dashboard</a>
        <a href="/admin/movies.php">Movies</a>';
    if($is_admin == 1){
        $menu .='<a href="/admin/subscriptions.php">Active Subscriptions</a><a href="/admin/users.php">Manage users</a>';
    }
$menu .='</nav>
    <nav class="sub-nav">
        <span class="my-5">Hi, <b>'.$user .'</b></span>
        <a href="/admin/my_details.php">My details</a>
        <a href="/admin/logout.php">Logout</a>
    </nav>
</header>';


echo $menu;
?>
