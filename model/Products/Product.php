<?php
namespace model\Products;

use model\App;
use sys\store\AppData;

class Product extends App
{

    private $TableName = "tbl_products";

    public function __construct()
    {
        parent::__construct();
        $this->__initialize();
    }

    public function __create_products($prd_name, $prd_category, $price, $prd_quantity, $role_id)
    {
        if(len($prd_name<0)&& len($prd_category<0) && $price<0&& $prd_quantity<0):
            $this->Error - "Please fill in all product details";
            return false;
        endif;
        
        $data=[
            "prd_name"=>$prd_name,
            "prd_category"=>$prd_category,
            "price"=>$price,
            "prd_quantity"=>$prd_quantity,
            "role_id"=>$role_id,
        ];
        if ($id = AppData::__create($this->TableName, $data)) :
            $this->Success = "Product created successfully!!";
            
            return ['id'=>$id];
        endif;
        $this->Error = "An error occurred while product user";
        return false;

    }


    public function __get_prd_list()
    {
        if(!$objContact  = AppData::__get_rows($this->TableName)):
            $this->Error="product  not found";
            return false;
        endif;

     $list =[];

        while($row =$objContact->fetch_assoc() ){
            $list [] =$this->__std_data_format($row);
        }
        return $list;
    }


    public function __get_prd_info($id)
    {
        if(!$objUser = AppData::__get_row($this->TableName, $id)):
            $this->Error="User not found";
            return false;
        endif;
        return $this->__std_data_format($objUser);
    }


    public function __update_contact($id,$prd_name,$prd_category,$price,$prd_quantity ){

            if($id<=0 || len($$prd_name)):
                $this->Error = "Please fill in all contact details";
                return false;
            endif;

            $data=[
                "id"=>$id,
                "prd_name"=>$prd_name,
                "prd_category"=>$prd_category,
                "price"=>$price,
                "prd_quantity"=>$prd_quantity,
                
            ];
            if ($user_id = AppData::__update($this->TableName, $data, $id)) :
                $this->Success = "product updated successfully!!";
                
                return $user_id;
            endif;
            $this->Error = "An error occurred while updating product";
            return false;
        }

        public function __delete_product($id){

            if($id = AppData::__delete($this->TableName, $id)):
                $this->Success="product deleted";
                return true;
            endif;
            $this->Error ="Error";

            return false;
    
        }
    

    private function __std_data_format($data){
        $data = (object) $data;
        return [
            "id"=>$data->id,
            "prd_name"=>$data->first_name,
            "prd_category"=>$data->last_name,
              
        ];
    }

    private function __initialize()
    { 
        if (!AppData::__table_exists($this->TableName)) {
            $query = "CREATE TABLE `$this->TableName` (";
            $query .= "`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
            $query .= "`prd_name` VARCHAR(255) NOT NULL,";
            $query .= "`prd_category` VARCHAR(255) NOT NULL,";
            $query .= " `role_id` INT(11) NOT NULL,";
            $query .= " `price` INT(11) NOT NULL,";
            $query .= " `prd_quantity` INT(11) NOT NULL,";
            $query .= "`photo` VARCHAR(255) NOT NULL DEFAULT 'avatar.png',";
            $query .= " `created_at` timestamp NOT NULL DEFAULT current_timestamp(),";
            $query .= " `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),";
            $query .= " CONSTRAINT `FK_product_has_role1` FOREIGN KEY(`role_id`) REFERENCES `tbl_role`(`id`)";
            $query .= ") ENGINE=InnoDB";
            AppData::__execute($query);


            // create default user
            // $this->__create_products("omo");
        }
    }



}

?>