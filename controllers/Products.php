<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	function check_session(){
		if(!$this->session->userdata('admin_logged_in')){
			redirect('admin/login');
		}
	}

	public function index()	{
		$this->check_session();
		$page = 'products';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('admin_firstname');
		$data['last_name'] = $this->session->userdata('admin_lastname');
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $this->session->userdata('admin_position');
		$data['settings'] = $this->settings_model->get_settings();

		$data['products'] = $this->product_model->get_products();
		$data['types'] = $this->product_model->get_types();

		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
        $this->load->view('templates/admin/page_scripts/default');
	}

	public function edit($id) {
        $this->check_session();
        $page = 'products';
        $data['title'] = ucwords($page);
        $data['first_name'] = $this->session->userdata('admin_firstname');
        $data['last_name'] = $this->session->userdata('admin_lastname');
        $data['admin_id'] = $this->session->userdata('admin_id');
        $data['admin_status'] = $this->session->userdata('admin_position');
        $data['settings'] = $this->settings_model->get_settings();

        $data['product'] = $this->product_model->get_products($id);
        $data['images'] = $this->product_model->get_images($id);
        $data['products_to_categories'] = $this->product_model->get_products_to_categories($id);
        $data['types'] = $this->product_model->get_types();

        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
        $this->load->view('admin/products-edit', $data);
        $this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
    }

	public function create() {
        $this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('name', 'name', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('multi',validation_errors());
            redirect('admin/products');
        } else {
            if(isset($_FILES['image'])) {
                if (!file_exists('./assets/img/products/'.strtolower(url_title($this->input->post('name'))))) {
                    mkdir('./assets/img/products/'. strtolower(url_title($this->input->post('name'))), 0777, true);
                }

                $image = "main.".pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); 
                $config['allowed_types'] = 'gif|jpg|png';
                $config['upload_path'] = './assets/img/products/'.strtolower(url_title($this->input->post('name')));
                $config['file_name'] = $image;
                $this->upload->initialize($config);
                $this->upload->overwrite = true;
                if(!($this->upload->do_upload('image'))){
                    $error=array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error',$error['error']);
                } else {
                    $data = $this->upload->data();
                    //Compress photo
                    $config['photo_library']='gd2';
                    $config['source_image']='./assets/img/products/'.strtolower(url_title($this->input->post('name')))."/".$image;
                    $config['create_thumb']= FALSE;
                    $config['maintain_ratio']= TRUE;
                    $config['new_image']= './assets/img/products/'.strtolower(url_title($this->input->post('name')))."/".$image;
                    $config['quality']= '70%';
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                }
            }

            $images = array();
            if(isset($_FILES['images'])) {
                if (!file_exists('./assets/img/products/'.strtolower(url_title($this->input->post('name'))))) {
                    mkdir('./assets/img/products/'. strtolower(url_title($this->input->post('name'))), 0777, true);
                }
                
                $files = $_FILES;
                $count = count($_FILES ['images'] ['name']);
                $uploads = $_FILES['images']['name'];

                for ($i = 0; $i < $count; $i ++) {
                    $_FILES['images']['name'] = $files['images']['name'][$i];
                    $_FILES['images']['type'] = $files['images']['type'][$i];
                    $_FILES['images']['tmp_name'] = $files['images']['tmp_name'][$i];
                    $_FILES['imges']['error'] = $files['images']['error'][$i];
                    $_FILES['images']['size'] = $files['images']['size'][$i];

                    $image_name = $i.".".pathinfo($_FILES['images']['name'], PATHINFO_EXTENSION); 
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['upload_path'] = './assets/img/products/'.strtolower(url_title($this->input->post('name')));
                    $config['file_name'] = $image_name;
                    $this->upload->initialize($config);
                    $this->upload->overwrite = true;

                    if(!($this->upload->do_upload('images'))){
                        $error=array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('error',$error['error']);
                    } else {
                        $data = $this->upload->data();
                        //Compress photo
                        $config['photo_library'] = 'gd2';
                        $config['source_image'] = './assets/img/products/'.strtolower(url_title($this->input->post('name')))."/".$image_name;
                        $config['create_thumb'] = FALSE;
                        $config['maintain_ratio'] = TRUE;
                        $config['new_image'] = './assets/img/products/'.strtolower(url_title($this->input->post('name')))."/".$image_name;
                        $config['quality'] = '70%';
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();

                        $images[] = $image_name; 
                    }
                }
            }

            $create = $this->product_model->create($this->input->post('name'), $this->input->post('description'), $image, $this->input->post('price'), $this->input->post('type'), $this->input->post('category'), $images, $this->session->userdata('admin_id'));

            if($create){
                $this->session->set_flashdata('success', 'Product created successfully');
            } else {
                $this->session->set_flashdata('error', 'Product already exist.');
            }
            redirect('admin/products');
        }
    }

    public function update() {
        rename("./assets/img/products/".url_title($this->input->post('old_name')), "./assets/img/products/".strtolower(url_title($this->input->post('name'))));
        $create=$this->product_model->update($this->input->post('product_ID'), $this->input->post('name'), $this->input->post('description'), $this->input->post('price'), $this->input->post('type'), $this->input->post('category'), $this->session->userdata('admin_id'));

        if($create){
            $this->session->set_flashdata('success', 'Product created successfully');
        } else {
            $this->session->set_flashdata('error', 'Product already exist.');
        }
        redirect('admin/products/'.$this->input->post('product_ID'));
    }

    function get_categories() {
		$data = $this->product_model->get_categories($this->input->post('type_ID'));
		echo json_encode($data);
	}

	function create_category() {
        if(empty($this->input->post('name'))){
            $data = array(
                'error' => true,
                'message' => 'Category name required'
            );
        } else {
            $data = $this->product_model->create_category($this->input->post('name'), $this->input->post('type_ID'));
            if(!$data){
                $data = array(
                    'error' => true,
                    'message' => 'Category name already exist!'
                );
            }
        }
        echo json_encode($data);
    }

    function change_status() {
        $data = $this->product_model->change_status($this->input->post('product_ID'), $this->input->post('status'));
        echo json_encode($data);
    }

    function delete_image() {
        $this->load->helper("file");
        $data = $this->product_model->delete_image($this->input->post('image_ID'));

        $path_to_file = './assets/img/products/'.$this->input->post('product_slug')."/".$this->input->post('image_name');
        unlink($path_to_file);

        echo json_encode($data);
    }

    //Upload image summernote
    function upload_image($slug, $last, $product_ID){
        if(isset($_FILES["image"]["name"])){
            if (!file_exists('./assets/img/products/'.strtolower($slug))) {
                mkdir('./assets/img/products/'.strtolower($slug), 0777, true);
            }

            $new_name = pathinfo($last, PATHINFO_FILENAME) + 1;
            $image_name = $new_name.".".pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION); 
            $config['allowed_types'] = 'gif|jpg|png';
            $config['upload_path'] = './assets/img/products/'.strtolower($slug);
            $config['file_name'] = $image_name;

            $this->upload->initialize($config);
            if(!$this->upload->do_upload('image')){
                $this->upload->display_errors();
                echo FALSE;
            }else{
                $data = $this->upload->data();
                $config['photo_library']='gd2';
                $config['source_image']='./assets/img/products/'.strtolower($slug)."/".$image_name;
                $config['create_thumb']= FALSE;
                $config['maintain_ratio']= TRUE;
                $config['new_image']= './assets/img/products/'.strtolower($slug)."/".$image_name;
                $config['quality']= '60%';
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $this->product_model->add_image($image_name, $product_ID);
                echo $config['file_name'];
            }
        }
    }
}