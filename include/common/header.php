<header>

<a href="/restomatic/index.php" class="home"> Home </a>
<?php
    $html='';
    if( isset($_SESSION['login']) && $_SESSION['login']) {
        $html.= '<div class="headerLogin">';
        if($_SESSION['roles'] == 'admin') {
            $html.='<a href="'.APP_ROUTE.'reportedReviews.php"> Reports </a>';
        }
        if( $_SESSION['roles']=='owner' || $_SESSION['roles']=='admin' ) {
            $html.="<a href='".APP_ROUTE."owner.php' class='ownerButton'>My restaurants</a>";
        }
       
           
        $html.='<a href="/restomatic/logout.php" class="headerLogoutButton">
         Logout </a></div>';
    }
    else
    $html.= '
<div class="headerLogin">
<a href="'.APP_ROUTE.'login.php" class="headerLoginButton"> Login </a>
<a href="'.APP_ROUTE.'register.php" class="headerRegisterButton"> Register </a>
</div>';
echo $html
?>
</header>
