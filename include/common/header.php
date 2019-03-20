<header>
<a href="index.php" class="home"> Home </a>
<?php 
    if( isset($_SESSION['login']) && $_SESSION['login']) {
        echo '<div class="headerLogin">Welcome'.$_SESSION['name'].'<a href="logout.php" > Logout </a></div>';
    }
    else 
    echo '
<div class="headerLogin">
<a href="login.php" > Login </a>
<a href="register.php"> Register </a>
</div>';
?>
</header>