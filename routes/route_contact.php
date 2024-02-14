<?php

switch($request):
           
    case "login"://login route
        include_once "api/login.php";//Login Endpoint
        break;

     case "user/role/list"://user role route
        include_once "api/list_roles.php";//User role Endpoint
        break;

    case "contact/create"://user role route
        include_once "api/contacts/create_contact.php";//User role Endpoint
        break;

    case "contact/info"://user role route
        include_once "api/contacts/get_contact_info.php";//User role Endpoint
        break;

    case "contact/user"://user role route
        include_once "api/contacts/get_user_info.php";//User role Endpoint
        break;
    

    case "contact/update"://user role route
        include_once "api/contacts/update_contact.php";//User role Endpoint
        break;

    case "contact/delete"://user role route
        include_once "api/contacts/delete_contact.php";//User role Endpoint
        break;  
         
endswitch;

?>