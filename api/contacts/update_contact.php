<?php

use model\Contacts\Contact;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['id','first_name','last_name','email']);


$NewRequest=new Contact;
$result=$NewRequest->__update_contact(clean($data->id),
                                     clean($data->first_name),
                                     clean($data->last_name),
                                     clean($data->email));
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>