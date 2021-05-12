<?php
	class Faq_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function get_all_faqs($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('faqs');
			return $query->result_array();
		}
		$query = $this->db->get_where('faqs', array('id' => $id));
		return $query->row_array();
	}

	public function get_portal_faqs($id = FALSE){
		$this->db->where('type', '1');
		$this->db->order_by('faqs.question', 'ASC');
		if($id === FALSE){
			$this->db->where('type', '1');
			$this->db->order_by('faqs.question', 'ASC');
			$query = $this->db->get('faqs');
			return $query->result_array();
		}
		$this->db->where('id', $id);
		$query = $this->db->get('faqs');
		return $query->row_array();
	}

	public function search_faqs($search){
    	$this->db->select('question, answer, id');
		$this->db->where('type', '1');
		$this->db->like('question', $search);
    	$this->db->order_by('question', 'ASC');
    	
    	$query = $this->db->get('faqs');
		return $query->result_array();
    }

    public function search_categories($search){
    	$this->db->select('category.name as name, category.id as id');
		$this->db->join('category', 'faqs.category_ID = category.id');
		$this->db->where('faqs.type', '1');
		$this->db->like('category.name', $search);
		$this->db->group_by('faqs.category_ID');
		$this->db->order_by('category.name', 'ASC');
		$query = $this->db->get('faqs');
		return $query->result_array();
    }


	public function get_categories(){
		$this->db->select('category.name as name, category.id as id');
		$this->db->join('category', 'faqs.category_ID = category.id');
		$this->db->group_by('faqs.category_ID');
		$this->db->order_by('category.name', 'ASC');
		$query = $this->db->get('faqs');
		return $query->result_array();
	}

	public function create_question($type, $category, $question, $answer){
		$this->db->trans_begin();
		$slug = url_title($question);
		$data = array(
			'type' => $type,
			'category_ID' => $category,
			'question' => strtolower($question),
			'slug' => strtolower($slug),
			'answer' => $answer,
			'admin_ID' => $this->session->userdata('admin_id')
		);
		$this->db->insert('faqs', $data);
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update_question($faq_ID, $type, $category, $question, $answer){
		$this->db->trans_begin();
		$slug = url_title($question);
		$data = array(
			'id' => $faq_ID,
			'type' => $type,
			'category_ID' => $category,
			'question' => strtolower($question),
			'slug' => strtolower($question),
			'answer' => $answer,
			'admin_ID' => $this->session->userdata('admin_id')
		);
		$this->db->set('timestamp', 'NOW()', FALSE);
		$this->db->where('id', $faq_ID);
		$this->db->update('faqs', $data);
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function delete_question($faq_ID){
		$this->db->delete('faqs', array('id' => $faq_ID));
	}
}