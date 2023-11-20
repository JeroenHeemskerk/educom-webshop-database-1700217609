<?php

  function doLoginUser($name) { 
    $_SESSION["name"] = $name; 
  }
  function doLogoutUser() {
    unset($_SESSION["name"]);
  }
  function isUserLoggedIn() {
    return isset($_SESSION["login"]) && $_SESSION['login']; 
  } 
  
  function getLoggedInUserName() {
    return $_SESSION["name"];
  } 

  ?>