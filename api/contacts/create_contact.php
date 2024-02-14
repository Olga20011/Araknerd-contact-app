<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
use model\Contacts\Contact;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['first_name','last_name','email','role_id']);


$NewRequest=new Contact;
$result=$NewRequest->__create_contacts(clean($data->first_name),
                                       clean($data->last_name),
                                       clean($data->email),
                                       clean($data->role_id));
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>