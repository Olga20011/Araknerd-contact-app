<?php

switch($request):
           
    case "login"://login route
        include_once "api/login.php";//Login Endpoint
        break;

     case "user/role/list"://user role route
        include_once "api/list_roles.php";//User role Endpoint
        break;
endswitch;

?>