<header>

<a href="index.php" class="home"> Home </a>
<a href="newRestaurant.php" class="newRestaurant"> Test: Add </a>
<a href="template.php" class = "template"> Test: Restaurant
<?php
    if( isset($_SESSION['login']) && $_SESSION['login']) {
        echo '<div class="headerLogin"><span class="headerWelcomeText">
        Welcome '.$_SESSION['name']."<a href='owner.php' class='ownerButton'>My restaurants</a>"
        .'</span><a href="logout.php" class="headerLogoutButton">
         Logout </a></div>';
    }
    else
    echo '
<div class="headerLogin">
<a href="login.php" class="headerLoginButton"> Login </a>
<a href="register.php" class="headerRegisterButton"> Register </a>
</div>';
?>
</header>
