<?php
	class Product_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function get_products($id = FALSE){
    	$this->db->select('*, products.name as product_name, products_type.name as type_name, products.id as product_ID');
		$this->db->join('products_type', 'products.type = products_type.id');
		if($id === FALSE){
			$query = $this->db->get('products');;
			return $query->result_array();
		}

		$query = $this->db->get_where('products', array('products.id' => $id));
		return $query->row_array();
	}

	public function get_images($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('products_images');
			return $query->result_array();
		}
		$query = $this->db->get_where('products_images', array('product_ID' => $id));
		return $query->result_array();
	}

	public function get_types($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('products_type');;
			return $query->result_array();
		}

		$query = $this->db->get_where('products_type', array('id' => $id));
		return $query->row_array();
	}

	public function get_categories($type_ID = FALSE){
		if($type_ID === FALSE){
			$query = $this->db->get('products_category');
			return $query->result_array();
		}

		$query = $this->db->get_where('products_category', array('type' => $type_ID));
		return $query->result_array();
	}

	public function get_products_to_categories($product_ID = FALSE){
		$this->db->select('*');
		$this->db->join('products_category', 'products_category.id = products_to_category.category_ID', 'LEFT');
		if($product_ID !== FALSE){
			$this->db->where('products_to_category.product_ID', $product_ID);
		}
		$query = $this->db->get('products_to_category');
		return $query->result_array();
	}

	public function create_category($name, $type){
		$this->db->trans_begin();
		$slug = url_title($name);

		$data = array(
			'name' => $name,
			'slug' => strtolower($slug),
			'type' => $type
		);
		$this->db->insert('products_category', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function create($name, $description, $image, $price, $type, $category, $images, $admin_ID){
		$this->db->trans_begin();
		$slug = url_title($name);
		$data = array(
			'name' => $name,
			'slug' => strtolower($slug),
			'description' => $description,
			'image' => $image,
			'price' => $price,
			'status' => '1',
			'type' => $type,
			'admin_ID' => $admin_ID
		);
		$this->db->set('date_created', 'NOW()', FALSE);
		$this->db->insert('products', $data);
		$query = $this->db->select('id')->where('name',$name)->get('products')->row_array();

		$total = count($category);
		for($i=0; $i<$total; $i++) {
			if(trim($category[$i] != '')) {
		        $category_ID = $category[$i];

		        $data2 = array(
		        	'product_ID' => $query['id'],
					'category_ID' => $category_ID
				);
		    	
				$this->db->insert('products_to_category', $data2);
			}
		}

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

	public function update($product_ID, $name, $description, $price, $type, $category, $admin_ID){
		$this->db->trans_begin();

		$slug = url_title($name);
		$data = array(
			'name' => $name,
			'slug' => strtolower($slug),
			'description' => $description,
			'price' => $price,
			'status' => '1',
			'type' => $type,
			'admin_ID' => $admin_ID
		);
		$this->db->update('products', $data);
		$this->db->delete('products_to_category', array('product_ID' => $product_ID));

		$total = count($category);
		for($i=0; $i<$total; $i++) {
			if(trim($category[$i] != '')) {
		        $category_ID = $category[$i];
		        $data2 = array(
					'product_ID' => $product_ID,
					'category_ID' => $category_ID
				);
		    	
				$this->db->insert('products_to_category', $data2);
			}
		}

		$data3 = array(
			'product_ID' => $product_ID,
		);
		$this->db->where('product_ID', $product_ID);
		$this->db->update('products_images', $data3);

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
		    	
				$this->db->insert('products_images', $data);
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
		$this->db->insert('products_images', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function change_status($product_ID, $status){
		$this->db->set('status', $status);
		$this->db->where('id', $product_ID);

		return $this->db->update('products');
	}

	public function delete_image($image_ID){
		$this->db->delete('products_images', array('id' => $image_ID));
	}

}