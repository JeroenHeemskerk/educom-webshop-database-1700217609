<?php
  
  function doLoginUser($name, $userId) { 
    $_SESSION["name"] = $name; 
    $_SESSION["userId"] = $userId;
  }
  function doLogoutUser() {
    unset($_SESSION["name"]);
    unset($_SESSION["cart"]);
  }
  function isUserLoggedIn() {
    return isset($_SESSION["name"]); 
  } 
  
  function getLoggedInUserName() {
    return $_SESSION["name"];
  } 
  function getLoggedInUserId() {
    return $_SESSION["userId"];
  } 

  function showBIfLoggedIn ()
{
    if (isset($_SESSION['name'])) {
    return true;
    }
}

function storeItemInSession($id)
{
  if (!(isset($_SESSION['cart'])))
  {
    $_SESSION['cart'] = array();
  }
  if (isset($_SESSION['cart'][$id])) {
      $_SESSION['cart'][$id] += 1;
  } else {
    $_SESSION['cart'][$id] = 1;
  }
}

  ?>