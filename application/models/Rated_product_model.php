<?php
	class Rated_product_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function get_all_products($limit, $start, $id = FALSE){
    	$this->db->order_by('name', 'ASC');
    	if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
		if($id === FALSE){
			$query = $this->db->get('rated_products');
			return $query->result_array();
		}
		$query = $this->db->get_where('rated_products', array('id' => $id));
		return $query->row_array();
	}

	public function search_products($limit, $start, $name){
    	$this->db->select('*');
		if(!empty($limit)){
			$this->db->limit($limit, $start);
		}

		$this->db->like('name', $name);
    	$this->db->order_by('name', 'ASC');
    	
    	$query = $this->db->get('rated_products');
		return $query->result_array();
	}

	public function get_images($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('rated_products_images');
			return $query->result_array();
		}
		$query = $this->db->get_where('rated_products_images', array('product_ID' => $id));
		return $query->result_array();
	}

	public function create($name, $description, $rating, $url, $images){
		$this->db->trans_begin();
		$slug = url_title($name);
		$data = array(
			'name' => $name,
			'description' => $description,
			'slug' => strtolower($slug),
			'rating' => $rating,
			'url' => $url
		);
		$this->db->insert('rated_products', $data);

		$query = $this->db->select('id')->where('name',$name)->get('rated_products')->row_array();

		if(!empty($images)){
			$sql = $this->upload_images($images, $query['id']);
			if(!$sql){
				return false;
			}
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update($product_ID, $name, $description, $rating, $url){
		$this->db->trans_begin();

		$slug = url_title($name);
		$data = array(
			'name' => $name,
			'description' => $description,
			'slug' => strtolower($slug),
			'rating' => $rating,
			'url' => $url
		);
		$this->db->where('id', $product_ID);
		$this->db->update('rated_products', $data);

		$data2 = array(
			'product_ID' => $product_ID,
		);
		$this->db->where('product_ID', $product_ID);
		$this->db->update('rated_products_images', $data2);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function upload_images($images, $product_ID){
		$this->db->trans_begin();

		$total = count($images);
		for($i=0; $i<$total; $i++) {
			if(trim($images[$i] != '')) {
		        $image = $images[$i];

		        $data = array(
		        	'product_ID' => $product_ID,
					'image' => $image
				);
		    	
				$this->db->insert('rated_products_images', $data);
			}
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
		
	}

	public function add_image($image, $product_ID){
		$this->db->trans_begin();

        $data = array(
        	'product_ID' => $product_ID,
			'image' => $image
		);
		$this->db->insert('rated_products_images', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function delete($product_ID){
		$this->db->delete('rated_products', array('id' => $product_ID));
	}

	public function image_delete($image_ID){
		$this->db->delete('rated_products_images', array('id' => $image_ID));
	}
}