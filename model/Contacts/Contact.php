<?php
namespace model\Contacts;

use model\App;
use sys\store\AppData;

class Contact extends App
{

    private $TableName = "tbl_contacts";

    public function __construct()
    {
        parent::__construct();
        $this->__initialize();
    }

    public function __create_contacts($first_name,$last_name,$email,$role_id,)
    {
        if(len($first_name)):
            $this->Error - "Please fill in all contact details";
            return false;
        endif;
        $data=[
            "first_name"=>$first_name,
            "last_name"=>$last_name,
            "email"=>$email,
            "role_id"=>$role_id,
            
        ];
        if ($id = AppData::__create($this->TableName, $data)) :
            $this->Success = "Contact created successfully!!";
            
            return ['id'=>$id];
        endif;
        $this->Error = "An error occurred while creating user";
        return false;

    }


    public function __get_contact_info()
    {
        if(!$objContact  = AppData::__get_rows($this->TableName)):
            $this->Error="Contact  not found";
            return false;
        endif;

     $list =[];

        while($row =$objContact->fetch_assoc() ){
            $list [] =$this->__std_data_format($row);
        }
        return $list;
    }


    public function __get_user_info($id)
    {
        if(!$objUser = AppData::__get_row($this->TableName, $id)):
            $this->Error="User not found";
            return false;
        endif;
        return $this->__std_data_format($objUser);
    }

    // public function __get_contact_info()
    // {
    //     if(!$objUser = AppData::__get_rows($this->TableName)):
    //         $this->Error="User not found";
    //         return false;
    //     endif;
    //     return $this->__std_data_format($objUser);
    

    public function __update_contact($id, $first_name ,$last_name ,$email ){

            if($id<=0 || len($first_name)):
                $this->Error = "Please fill in all contact details";
                return false;
            endif;

            $data=[
                "id"=>$id,
                "first_name"=>$first_name,
                "last_name"=>$last_name,
                "email"=>$email
                
            ];
            if ($user_id = AppData::__update($this->TableName, $data, $id)) :
                $this->Success = "Contact updated successfully!!";
                
                return $user_id;
            endif;
            $this->Error = "An error occurred while updating user";
            return false;
        }

        public function __delete_contact($id){

            if($id  = AppData::__delete($this->TableName, $id)):
                $this->Success="Contact deleted";
                return true;  
            endif;
            $this->Error = "Contact not found";
    
            return false;
    
        }

    //     public function __upload_picture($user_id, $image)
    // {
    //     if (len($user_id) || len($image)) :
    //         $this->Error = "Select an image";
    //         return false;
    //     endif;

    //     $data = [
    //         "photo" => $image
    //     ];

    //     if (!(is_null($image)) && isset($image)) :
    //         if (!$image_path = (new DataFile)->__upload_image($image, "profilePic_")) :
    //             $this->Error = "Failed to upload profile picture, please try again";
    //             return false;
    //         endif;

    //         $data["photo"] = $image_path;
    //     endif;

    //     if ($photo_id = AppData::__update($this->TableName, $data, $user_id)) :
    //         $this->Success = "Profile picture uploaded successfully!!";
    //         return $photo_id;
    //     endif;
    //     $this->Error = "An error occurred while uploading image";
    //     return false;
    // }
    

    private function __std_data_format($data){
        $data = (object) $data;
        return [
            "id"=>$data->id,
            "first_name"=>$data->first_name,
            "last_name"=>$data->last_name,
            "email"=>$data->email,
              
        ];
    }



    private function __initialize()
    { 
        if (!AppData::__table_exists($this->TableName)) {
            $query = "CREATE TABLE `$this->TableName` (";
            $query .= "`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
            $query .= "`first_name` VARCHAR(255) NOT NULL,";
            $query .= "`last_name` VARCHAR(255) NOT NULL,";
            $query .= " `role_id` INT(11) NOT NULL,";
            $query .= "`photo` VARCHAR(255) NOT NULL DEFAULT 'avatar.png',";
            $query .= "`email` VARCHAR(255) NOT NULL,";
            $query .= "`photo` VARCHAR(255) NOT NULL DEFAULT 'avatar.png',";
            $query .= " `created_at` timestamp NOT NULL DEFAULT current_timestamp(),";
            $query .= " `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),";
            $query .= " CONSTRAINT `FK_user_has_role1` FOREIGN KEY(`role_id`) REFERENCES `tbl_role`(`id`)";
            $query .= ") ENGINE=InnoDB";
            AppData::__execute($query);


            //create default user
            // $this->__create_contacts("Akello");
        }
    }



}

?>