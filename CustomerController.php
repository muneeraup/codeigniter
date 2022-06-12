<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomerController extends CI_Controller
{
    public function customerform(){
        if(isset($_POST['name']) && isset($_POST['email'])){
            $data = array(
                    'email' => $this->input->post('email'),
                    'name' => $this->input->post('name'),
                    'address' => $this->input->post('address')
                    );
            if(!empty($_FILES['avatar']['tmp_name'])){
                print_r('$_FILES');
                $original_file=$_FILES['avatar']['tmp_name'];
                $type=explode("/",$_FILES['avatar']['type']);
                $file_name=time().".".$type[1];
                $data['file']=$file_name;
                $directory = "./assets/admin_assets/img/";
                $uploading_path = $directory . $file_name;
                if(!file_exists($uploading_path))
                {
                    move_uploaded_file($original_file,$uploading_path);
                }
            }
            $this->db->insert('profile', $data);
            $response['status']=1;
        }else{
            $response['status']=0;
        }
        echo json_encode($response);
    }
    public function get_data() {
        $data['all_profiles'] = $this->db->get("profile")->result();
        $this->load->view('Admin/dashboard',$data);
      }
}