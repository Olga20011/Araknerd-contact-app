<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
use model\Products\Product;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['prd_name','prd_category','price','prd_quantity','role_id']);


$NewRequest=new Product;
$result=$NewRequest->__create_products(clean($data->prd_name),
                                       clean($data->prd_category),
                                       clean($data->price),
                                       clean($data->prd_quantity),
                                       clean($data->role_id));
                            
$info = format_api_return_data($result, $NewRequest);


//make json
print_r(json_encode($info));

?>