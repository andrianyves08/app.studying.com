<?php
	class Product_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function get_all_products($limit, $start, $id = FALSE){
    	$this->db->order_by('name', 'ASC');
    	if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
		if($id === FALSE){
			$query = $this->db->get('products');
			return $query->result_array();
		}
		$query = $this->db->get_where('products', array('id' => $id));
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

	public function get_categories($slug = FALSE){
		$this->db->order_by('name', 'ASC');
		if($slug === FALSE){
			$query = $this->db->get('products_category');
			return $query->result_array();
		}
		$query = $this->db->get_where('products_category', array('slug' => $slug));

		return $query->row_array();
	}

	public function get_categories_products($slug = FALSE){
		$this->db->select('*');
		$this->db->join('products_categories', 'products_category.id = products_categories.product_category_ID', 'LEFT');
		if($slug === FALSE){
			$this->db->group_by('products_category.name');
			$query = $this->db->get('products_category');
			return $query->result_array();
		}
		$this->db->order_by('products_category.name', 'ASC');
		$query = $this->db->get_where('products_category', array('slug' => $slug));

		return $query->result_array();
	}

	public function get_product_categories($id = FALSE){
		$this->db->select('*');
		$this->db->join('products_category', 'products_category.id = products_categories.product_category_ID', 'LEFT');
		if($id !== FALSE){
			$this->db->where('products_categories.product_ID', $id);
		}
		$query = $this->db->get('products_categories');
		return $query->result_array();
	}

	public function search_products($search){
    	$this->db->select('*');
		$this->db->like('name', $search);
    	$this->db->order_by('name', 'ASC');
    	
    	$query = $this->db->get('products');
		return $query->result_array();
    }

	public function create($name, $description, $rating, $category, $images){
		$this->db->trans_begin();
		$slug = url_title($name);
		$data = array(
			'name' => $name,
			'description' => $description,
			'slug' => strtolower($slug),
			'rating' => $rating
		);
		$this->db->insert('products', $data);

		$query = $this->db->select('id')->where('name',$name)->get('products')->row_array();

		$total = count($category);
		for($i=0; $i<$total; $i++) {
			if(trim($category[$i] != '')) {
		        $category_ID = $category[$i];

		        $data2 = array(
					'product_category_ID' => $category_ID,
					'product_ID' => $query['id']
				);
		    	
				$this->db->insert('products_categories', $data2);
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

	public function update($product_ID, $name, $description, $rating, $category, $images){
		$this->db->trans_begin();

		$slug = url_title($name);
		$data = array(
			'name' => $name,
			'description' => $description,
			'slug' => strtolower($slug),
			'rating' => $rating
		);
		$this->db->where('id', $product_ID);
		$this->db->update('products', $data);

		$total = count($category);
		for($i=0; $i<$total; $i++) {
			if(trim($category[$i] != '')) {
		        $category_ID = $category[$i];

		        $data2 = array(
					'product_category_ID' => $category_ID,
					'product_ID' => $product_ID
				);
		    	
				$this->db->replace('products_categories', $data2);
			}
		}

		if(!empty($images)){
			$sql = $this->upload_images($images, $product_ID);
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

	public function delete($product_ID){
		$this->db->delete('products', array('id' => $product_ID));
	}

	public function image_delete($image_ID){
		$this->db->delete('products_images', array('id' => $image_ID));
	}
}