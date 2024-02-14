<?php

use model\Contacts\Contact;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['id']);


$NewRequest=new Contact;
$result=$NewRequest->__get_user_info(clean($data->id));
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>