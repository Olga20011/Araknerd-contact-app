<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
use model\Contacts\Contact;


// Function to set CORS headers

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['id']);


$NewRequest=new Contact;
$result=$NewRequest->__delete_contact(clean($data->id));
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>