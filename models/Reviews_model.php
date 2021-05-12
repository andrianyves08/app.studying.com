<?php
	class Reviews_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

	public function get_reviews($id = FALSE){
		$this->db->order_by('timestamp', 'ASC');
		if($id === FALSE){
			$query = $this->db->get('reviews');;
			return $query->result_array();
		}

		$query = $this->db->get_where('reviews', array('id' => $id));

		return $query->row_array();
	}

	public function create_review($title, $name, $description, $testimonial, $rating, $niche, $location, $url, $date, $admin_ID){
		$this->db->trans_begin();

		$data = array(
			'title' => $title,
			'reviewers_name' => $name,
			'description' => $description,
			'testimonial' => $testimonial,
			'rating' => strtolower($rating),
			'niche' => strtolower($niche),
			'location' => $location,
			'url' => $url,
			'date' => $date,
			'admin_ID' => $admin_ID
		);

		$this->db->insert('reviews', $data);
		
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
		
	}

	public function update_review($id, $title, $name, $description, $testimonial, $rating, $niche, $location, $url, $date, $admin_ID){
		$this->db->trans_begin();
		
		$data = array(
			'title' => strtolower($title),
			'reviewers_name' => strtolower($name),
			'description' => strtolower($description),
			'testimonial' => strtolower($testimonial),
			'rating' => strtolower($rating),
			'niche' => strtolower($niche),
			'location' => strtolower($location),
			'url' => $url,
			'date' => $date,
			'admin_ID' => $admin_ID
		);

		$this->db->where('id', $id);
		$this->db->update('reviews', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function delete_review($id){
		$this->db->delete('reviews', array('id' => $id));
	}
}