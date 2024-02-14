<?php
namespace model\User;

use model\App;
use model\Auth\JWT;
use sys\store\AppData;

class User extends Role
{

    private $TableName = "tbl_user";
    private bool $UserIsActivated = false;

    public function __construct()
    {
        parent::__construct();
        $this->__initialize();
    }

    public function __login($username, $password)
    {
            $password = $this->__secure($password);
            $result=AppData::__select_fields()->__from_table($this->TableName)->__where(["username"=>$username, "password"=>$password])->__fetch();
            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();
                extract($row);
                $payload = array(
                    "data" => array(
                        "iat" => time(),
                        "exp" => time() + (60),
                        "user_id" => $id,
                        "role_id" => $role_id,
                        "username" => $username,
                    )
                );

                $token = JWT::encode($payload, getenv('JWT_SECRET'));
                $this->Success = "Login successful";
                $this->__update_token($id, $token);
                return $token;
            }


            
            $this->Error = "Enter correct username and password";
            return false;
       
    }


    private function __create($first_name, $last_name, $username, $password, $role_id)
    {
        $data=[
            "first_name"=>$first_name,
            "last_name"=>$last_name,
            "username"=>$username,
            "password"=>$this->__secure($password),
            "role_id"=>$role_id
        ];

        return AppData::__create($this->TableName, $data);
    }

    private function __secure($key)
    {
        return md5(sha1($key));
    }


    private function __update_token($user_id, $token)
    {
        $data = [
            "token" => $token
        ];

        return AppData::__update($this->TableName, $data, $user_id);
    }



    public function __get_user_token($user_id)
    {
        if (!$objUser = AppData::__get_row($this->TableName, $user_id)) :
            $this->Error = "User does not exist!";
            return false;
        endif;

        return $objUser->token;
    }


    public function __get_user_info($id)
    {
        if(!$objUser = AppData::__get_row($this->TableName, $id)):
            $this->Error="User not found";
            return false;
        endif;
        return $this->__std_data_format($objUser);
    }


    public function __user_is_activated()
    {
        return $this->UserIsActivated;
    }


    private function __std_data_format($data){
        $data = (object) $data;
        $this->UserIsActivated = $data->is_active*1==1?true:false;
        return [
            "id"=>$data->id,
            "first_name"=>$data->first_name,
            "last_name"=>$data->last_name,
            "username"=>$data->username,
            "role_id"=>$data->role_id
        ];
    }


    private function __initialize()
    {
        if (!AppData::__table_exists($this->TableName)) {
            $query = "CREATE TABLE `$this->TableName` (";
            $query .= "`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
            $query .= "`first_name` VARCHAR(255) NOT NULL,";
            $query .= "`last_name` VARCHAR(255) NOT NULL,";
            $query .= "`username` VARCHAR(255) NOT NULL,";
            $query .= "`password` VARCHAR(255) NOT NULL DEFAULT 1234,";
            $query .= " `role_id` INT(11) NOT NULL,";
            $query .= "`photo` VARCHAR(255) NOT NULL DEFAULT 'avatar.png',";
            $query .= " `is_active` INT(1) NOT NULL DEFAULT 1,";
            $query .= " `is_secure` INT(1) NOT NULL DEFAULT 0,";
            $query .= "`token` VARCHAR(500) NULL,";
            $query .= " `created_at` timestamp NOT NULL DEFAULT current_timestamp(),";
            $query .= " `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),";
            $query .= " CONSTRAINT `FK_user_has_role` FOREIGN KEY(`role_id`) REFERENCES `tbl_role`(`id`)";
            $query .= ") ENGINE=InnoDB";
            AppData::__execute($query);


            //create default user
            $this->__create("System", "Admin", "root", "Admin", "1");
        }
    }



}

?>