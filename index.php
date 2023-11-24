<?php
session_start();
$page = getRequestedPage ();
$data = processRequest ($page);
showResponsePage($data);

function getRequestedPage () 
{
    $requested_type = $_SERVER['REQUEST_METHOD'];
    if ($requested_type == 'POST')
    {
        $requested_page = getPostVar('page', 'home');
    }
    else 
    {
        $requested_page = getUrlVar('page', 'home');
    }
    return $requested_page;
}

function processRequest($page) 
{
    switch ($page) 
    {
        case "contact":
            require_once ('validation.php');
            $data = validateContact();
            if ($data['valid']){                                                
                $page = 'thanks';
            }
            break;
        case "register":
            require_once ('validation.php');
            $data = validateRegister();
            if ($data['valid']){                                                
                require_once ('file_repository.php');
                storeUser($data['email'], $data['name'], $data['password']);          
                $page = 'login';
            }
            break;  
        case "login":
            require_once ('validation.php');
            $data = validateLogin();
            if ($data['valid']){                                               
                $page = 'home';
                require_once('session_manager.php');
                doLoginUser($data['name'], $data['id']);
                //createCart();
            }
            break;
        case "logout":
            require_once('session_manager.php');
            doLogoutUser();
            $page = 'home';
            break;
        case "password":
            require_once ('validation.php');
            $data = validatePassword();
            if ($data['valid']){
                updatePassword($data['password']);
                $page = 'confirmed';               
            }
            break;
        case "details":      
                handleActions();
                $requested_type = $_SERVER['REQUEST_METHOD'];
                if ($requested_type == 'POST') {
                    $id = getPostvar('id');
                } else {
                    $id = getUrlvar('id');
                }
                require_once('file_repository.php');
                $data['item'] = getItemDetails ($id);
                
            break;
        case "cart":
            $requested_type = $_SERVER['REQUEST_METHOD'];
            if ($requested_type =='POST') {
                require_once ('file_repository.php');
                storeOrderInDb ();
                require_once ('session_manager.php');
                clearSessionFromItems ();
                $page = 'shop';
            } /*if  (get verzoek op de cart pagina){
                $id = getUrlvar('id');
                require_once('file_repository.php');
                $data['item'] = getItemDetails ($id);
                $page = 'details';
            }*/
            break;
    }
    require_once ('session_manager.php');
    $data['login'] = isUserLoggedIn();                                       
    $data['page']= $page;
    return $data;
}

function handleActions ()
{
    $action = getPostVar("action");
    switch ($action) {
        case "storeItemInSession":
            $id = getPostVar("id");
            include_once ('session_manager.php');
            storeItemInSession ($id);
            break;
        //hier kan ook een eraf halen
    }
}

function showResponsePage($data)
{
    echo '<!doctype html><html>' . PHP_EOL;                //beginDocument
    showHeadSection();              
    showBodySection($data);
    echo '</html>' . PHP_EOL;                               //endDocument
}

function getArrayVar($array, $key, $default=' ')
{
    return isset($array[$key]) ? $array[$key] : $default;
}

function getPostVar($key, $default=' ')
{
    return getArrayVar($_POST, $key, $default);
} 

function getUrlVar($key, $default=' ')              
{
    return getArrayVar($_GET, $key, $default);
} 

function showHeadSection ()
{
    echo '<head>' . PHP_EOL;             
    echo '<link rel="stylesheet" href="CSS/stylesheet.css">' . PHP_EOL; //showCssFile          
    echo '</head>' . PHP_EOL;   
    var_dump($_SESSION);
}

function showBodySection($data)
{
    echo '  <body>' . PHP_EOL;         //openBody    
    showHeader($data);           
    showMenu($data);             
    showContent($data);          
    showFooter();           
    echo '  </body.' . PHP_EOL;         //closeBody        
}

function showHeader($data)
{
    echo '<header>' . PHP_EOL;          //openHeader
    showHeaderContent($data);            
    echo '</header>' . PHP_EOL;         //closeHeader
}

function showHeaderContent ($data)
{
    switch ($data['page'])
    {
        case 'home':
            require_once ('home.php');  
            showHomeHeader(); 
            break;
        case 'about':
            require_once ('about.php');
            showAboutHeader();     
            break;
        case 'contact':
            require_once ('contact.php');
            showContactHeader();
            break;
        case 'register':
            require_once ('register.php');
            showRegisterHeader();
            break;
        case 'login':
            require_once ('login.php');
            showLoginHeader();
            break;
        case 'thanks':
            require_once ('thanks.php');
            showThanksHeader ();
            break;
        /*case 'password':
            require_once ('change_password.php');
            showPasswordHeader();
            break;*/
        /*case 'confirmed':
            require_once ('confirmed.php');
            showConfirmedHeader ();
            break;*/
        case 'shop':
            require_once ('shop.php');
            showShopHeader();
            break;
        case 'details':
            require_once ('details.php');
            showDetailsHeader();
            break;
        case 'cart';
            require_once ('cart.php');
            showCartHeader();
            break;
        default:
            echo '<p>Pagina niet gevonden</P>';
    }
}

function showMenu($data)
{  
    $data['menu']= array('home' => 'Startpagina', 'about' => 'Over mij', 'contact' => 'Contact', 'shop' => 'Spellenwinkel');  //nieuwe pagina's kunnen hier toegevoegd worden
    if ($data["login"]) {                                                                          
        /*$data['menu']['Password'] = 'Instellingen'; */$data['menu']['cart'] = 'Winkelwagen'; $data['menu']['logout'] = getLoggedInUserName() . ' uitloggen'; 
    } else {
        $data['menu']['register'] = 'Aanmelden' ; $data['menu']['login'] = 'Inloggen'; 
    }
    echo '<nav>' . PHP_EOL;                
    showNavigateList ($data);
    echo '</nav>' . PHP_EOL;
}

function showNavigateList($data)
{
    echo    '<ul class="menu">';
    foreach ($data['menu'] as $link => $label)
    {
        showNavigateItem($link, $label);
    }
    echo    '</ul>';
}

function showNavigateItem($link, $label) 
{
        echo '<li><a class="navigateMenu" href="index.php?page=' . $link . '">' . $label . '</a></li>';
}     
   
function showContent($data)
{
    switch ($data['page'])
    {
        case 'home':
            require_once('home.php');           
            showHomeContent();      
            break;
        case 'about':
            require_once('about.php');
            showAboutContent();     
            break;
        case 'contact':
            require_once('contact.php');
            showContactForm($data);                           
            break;
        case 'register':
            require_once ('register.php');      
            showRegisterForm($data);
            break;
        case 'login':
            require_once ('login.php');         
            showLoginForm($data);
            break;
        case 'thanks':                                                      
            require_once ('thanks.php');
            showThanksContent ($data);
            break;
        /*case 'password':
            require_once('change_password.php');
            showPasswordContent ($data);         
            break;*/
        /*case 'confirmed':
            require_once('confirmed.php');
            showConfirmedContent ();
            break;*/ 
        case 'shop':
            require_once('shop.php');
            showShopContent ($data);
            break;
        case 'details':
            require_once ('details.php');
            showItemDetails ($data);
            break;
        case 'cart':
            require_once ('cart.php');
            showCartContent ($data);
            break;
        default:
            echo '<p>Pagina niet gevonden</P>';
    }
}

function showFooter()           
{
    echo '<footer>' . PHP_EOL;                   
    echo '<p>&copy; 2023 Nicole Goris</p>';              
    echo '</footer>' . PHP_EOL;               
}

?>