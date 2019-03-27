<header>

<a href="index.php" class="home"> Home </a>
<a href="template.php" class = "template"> Test: Restaurant </a>
<?php
    if( isset($_SESSION['login']) && $_SESSION['login']) {
        echo '<div class="headerLogin">'."<a href='owner.php' class='ownerButton'>My restaurants</a>"
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
