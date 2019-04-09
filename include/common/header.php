<header>

<a href="/restomatic/index.php" class="home"> Home </a>
<?php
    $html='';
    if( isset($_SESSION['login']) && $_SESSION['login']) {
        $html.= '<div class="headerLogin">';
        if( $_SESSION['roles']=='owner' || $_SESSION['roles']=='admin' ) {
            $html.="<a href='/restomatic/owner.php' class='ownerButton'>My restaurants</a>";
        }
           
        $html.='</span><a href="/restomatic/logout.php" class="headerLogoutButton">
         Logout </a></div>';
    }
    else
    $html.= '
<div class="headerLogin">
<a href="/restomatic/login.php" class="headerLoginButton"> Login </a>
<a href="/restomatic/register.php" class="headerRegisterButton"> Register </a>
</div>';
echo $html
?>
</header>
