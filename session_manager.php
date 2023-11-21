<?php
  
  function doLoginUser($name, $userId) { 
    $_SESSION["name"] = $name; 
    $_SESSION["userId"] = $userId;
  }
  function doLogoutUser() {
    unset($_SESSION["name"]);
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
  ?>