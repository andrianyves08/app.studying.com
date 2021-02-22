<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rated_products extends CI_Controller {
    function check_session(){
        if(!$this->session->userdata('admin_logged_in')){
            redirect('admin/login');
        }
    }

    public function index() {
        $this->check_session();
        $page = 'rated products';
        $data['title'] = ucwords($page);
        $data['first_name'] = $this->session->userdata('admin_firstname');
        $data['last_name'] = $this->session->userdata('admin_lastname');
        $data['admin_id'] = $this->session->userdata('admin_id');
        $data['admin_status'] = $this->session->userdata('admin_position');
        $data['settings'] = $this->settings_model->get_settings();
        $data['products'] = $this->rated_product_model->get_all_products(NULL, 0, FALSE);

        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
        $this->load->view('admin/rated-products', $data);
        $this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
    }

    public function edit($id) {
        $this->check_session();
        $page = 'rated products';
        $data['title'] = ucwords($page);
        $data['first_name'] = $this->session->userdata('admin_firstname');
        $data['last_name'] = $this->session->userdata('admin_lastname');
        $data['admin_id'] = $this->session->userdata('admin_id');
        $data['admin_status'] = $this->session->userdata('admin_position');
        $data['settings'] = $this->settings_model->get_settings();

        $data['product'] = $this->rated_product_model->get_all_products(NULL, 0, $id);
        $data['images'] = $this->rated_product_model->get_images($id);
        $data['categories'] = $this->rated_product_model->get_product_categories($id);

        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
        $this->load->view('admin/rated-products-edit', $data);
        $this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
    }

    public function create() {
        $this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('multi',validation_errors());
            redirect('admin/rated-products');
        } else {
            $photos = array();

            if(isset($_FILES['photos'])) {
                if (!file_exists('./assets/img/rated-products/'.url_title($this->input->post('name')))) {
                    mkdir('./assets/img/rated-products/'. url_title($this->input->post('name')), 0777, true);
                }
                
                $files = $_FILES;
                $count = count($_FILES ['photos'] ['name']);
                $uploads = $_FILES['photos']['name'];

                for ($i = 0; $i < $count; $i ++) {
                    $_FILES['photos']['name'] = $files['photos']['name'][$i];
                    $_FILES['photos']['type'] = $files['photos']['type'][$i];
                    $_FILES['photos']['tmp_name'] = $files['photos']['tmp_name'][$i];
                    $_FILES['imges']['error'] = $files['photos']['error'][$i];
                    $_FILES['photos']['size'] = $files['photos']['size'][$i];

                    $image_name = $i.".".pathinfo($_FILES['photos']['name'], PATHINFO_EXTENSION); 
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['upload_path'] = './assets/img/rated-products/'.url_title($this->input->post('name'));
                    $config['file_name'] = $image_name;
                    $this->upload->initialize($config);
                    $this->upload->overwrite = true;

                    if(!($this->upload->do_upload('photos'))){
                        $error=array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('error',$error['error']);
                    } else {
                        $data = $this->upload->data();
                        //Compress photo
                        $config['photo_library']='gd2';
                        $config['source_image']='./assets/img/rated-products/'.url_title($this->input->post('name'))."/".$image_name;
                        $config['create_thumb']= FALSE;
                        $config['maintain_ratio']= TRUE;
                        $config['new_image']= './assets/img/rated-products/'.url_title($this->input->post('name'))."/".$image_name;
                        $config['quality']= '70%';
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();

                        $photos[] = $image_name; 
                    }
                }
            }

            $create=$this->rated_product_model->create($this->input->post('name'), $this->input->post('description'), $this->input->post('rating'), $this->input->post('category'), $photos);

            if($create){
                $this->session->set_flashdata('success', 'Product created successfully');
            } else {
                $this->session->set_flashdata('error', 'Product already exist.');
            }
            redirect('admin/rated-products');
        }
    }

    public function update() {
        $this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('multi',validation_errors());
            redirect('admin/rated-products');
        } else {
            rename("./assets/img/rated-products/".url_title($this->input->post('old_name')), "./assets/img/rated-products/".url_title($this->input->post('name')));

            $create=$this->rated_product_model->update($this->input->post('product_ID'), $this->input->post('name'), $this->input->post('description'), $this->input->post('rating'), $this->input->post('category'));

            if($create){
                $this->session->set_flashdata('success', 'Product created successfully');
            } else {
                $this->session->set_flashdata('error', 'Product already exist.');
            }
            redirect('admin/rated-products/'.$this->input->post('product_ID'));
        }
    }

    function get_category() {
        $data = $this->rated_product_model->get_categories();
        echo json_encode($data);
    }

    function get_images() {
        $data = $this->rated_product_model->get_images($this->input->post('id'));
        echo json_encode($data);
    }

    function get_product_categories() {
        $data = $this->rated_product_model->get_product_categories($this->input->post('id'));
        echo json_encode($data);
    }

    function create_category() {
        if(empty($this->input->post('name'))){
            $data = array(
                'error' => true,
                'message' => 'Category name required'
            );
        } else {
            $data = $this->rated_product_model->create_category($this->input->post('name'), $this->input->post('type'));
            if(!$data){
                $data = array(
                    'error' => true,
                    'message' => 'Category name already exist!'
                );
            }
        }
        echo json_encode($data);
    }

    function delete() {
        $data = $this->rated_product_model->delete($this->input->post('id'));
        echo json_encode($data);
    }

    //Upload image summernote
    function upload_image($slug, $last, $product_ID){
        if(isset($_FILES["image"]["name"])){
            if (!file_exists('./assets/img/rated-products/'.$slug)) {
                mkdir('./assets/img/rated-products/'.$slug, 0777, true);
            }

            $new_name = pathinfo($last, PATHINFO_FILENAME) + 1;
            $image_name = $new_name.".".pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION); 
            $config['allowed_types'] = 'gif|jpg|png';
            $config['upload_path'] = './assets/img/rated-products/'.$slug;
            $config['file_name'] = $image_name;

            $this->upload->initialize($config);
            if(!$this->upload->do_upload('image')){
                $this->upload->display_errors();
                echo FALSE;
            }else{
                $data = $this->upload->data();
                $config['photo_library']='gd2';
                $config['source_image']='./assets/img/rated-products/'.$slug."/".$image_name;
                $config['create_thumb']= FALSE;
                $config['maintain_ratio']= TRUE;
                $config['new_image']= './assets/img/rated-products/'.$slug."/".$image_name;
                $config['quality']= '60%';
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $this->rated_product_model->add_image($image_name, $product_ID);
                echo $config['file_name'];
            }
        }
    }

    function image_delete() {
        $this->load->helper("file");
        $data = $this->rated_product_model->image_delete($this->input->post('image_ID'));
        $path_to_file = './assets/img/rated-products/'.$this->input->post('product_slug')."/".$this->input->post('image_name');
        unlink($path_to_file);
        echo json_encode($data);
    }

    function load_more() {
        $products = $this->rated_product_model->get_all_products(10, $this->input->post('start'), FALSE);
        $images = $this->rated_product_model->get_images();
        $output = '';

        foreach($products as $product){
            $output .= '<div class="col-lg-3 col-md-4 col-sm-6 products"> 
                            <div class="card text-center mb-4">
                              <div class="view overlay">';
                                foreach ($images as $image) {
                                  if($image['product_ID'] == $product['id']){
            $output .= '<img class="card-img-top chat-mes-id-3" src="'.base_url().'/assets/img/rated-products/'.$product['slug'].'/'.$image['image'].'"
                                              alt="Card image cap">
                                            <a href="#!">
                                              <div class="mask rgba-white-slight"></div>
                                            </a>';
                                break;}}
            $output .= '</div>
                              <div class="card-body">
                                <p class="mb-1"><a href="" class="font-weight-bold black-text">'.$product['name'].'</a></p>
                                <div class="amber-text fa-xs mb-1">';
                                  $star = '';
                                  if($product['rating'] == 0){
                                    $star .= '<i class="far fa-star amber-text"></i>';
                                  } else {
                                    $i = 0;
                                    while($product['rating'] > $i){
                                    $star .= '<i class="fas fa-star amber-text"></i>';
                                      $i++;
                                    }
                                  }
            $output .= $star;
                               
            $output .=  '</div> 
                                <button type="button" class="btn btn-outline-indigo btn-rounded btn-sm px-1 waves-effect view_more" data-product-id="'.$product['id'].'" data-product-description="'.$product['description'].'" data-product-slug="'.$product['slug'].'" data-product-name="'.$product['name'].'">View Details</button>
                              </div>
                            </div><!-- Card -->
                        </div>';

        }
        echo $output;
    }
}