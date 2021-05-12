<?php
	class Admin_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    function enrolled_programs(){
		$this->db->select('sum(users_programs.amount) as program_sales, programs.name as program_name, count(users_programs.user_ID) as total_enrolled');
		$this->db->join('programs', 'programs.id = users_programs.program_ID');
		$this->db->group_by('program_ID');
		$this->db->order_by('total_enrolled', 'desc');
		$data = $this->db->get('users_programs');
		
		return $sql = $data->result_array();
	}

    function summary(){
    	$this->db->select_sum('amount');
		$data = $this->db->get('users_programs');
		$sql = $data->row();

		$sql2 = $this->db->count_all('users');  

		$this->db->select('*');
		$this->db->where('login_status', '1');
		$this->db->from('users');
		$sql3 = $this->db->count_all_results();

		$this->db->select('*');
		$this->db->where('status', '1');
		$this->db->from('course');
		$sql4 = $this->db->count_all_results(); 

		$this->db->select_sum('amount');
    	$this->db->where('MONTH(created_at)', date('m'));
    	$this->db->where('YEAR(created_at)', date('Y'));
		$data = $this->db->get('users_programs');
		$sql5 = $data->row();

		$this->db->select_sum('amount');
    	$this->db->where('YEAR(created_at)', date('Y'));
		$data = $this->db->get('users_programs');
		$sql6 = $data->row();

		$this->db->select('sum(amount) as yearly_sales, year(created_at) as year');
		$this->db->group_by('year(created_at)');
		$data1 = $this->db->get('users_programs');

		$this->db->select('sum(amount) as monthly_sales, monthname(created_at) as month');
		$this->db->group_by('month(created_at)');
    	$this->db->where('YEAR(created_at)', date('Y'));
		$data2 = $this->db->get('users_programs');

		$yearly_sales = array();
		$year = array();
		$monthly_sales = array();
		$month = array();

		foreach ($data1->result_array() as $row){
			$yearly_sales[] = $row['yearly_sales'];
			$year[] = $row['year'];
		}

		foreach ($data2->result_array() as $row2){
			$monthly_sales[] = $row2['monthly_sales'];
			$month[] = $row2['month'];
		}

		$data = array(
			'this_month_sales' => $sql5->amount,
			'this_year_sales' => $sql6->amount,
			'total_sales' => $sql->amount,
		    'total_students' => $sql2,
		    'current_online' => $sql3,
		    'total_modules' => $sql4,
		    'yearly_sales' => $yearly_sales,
		    'year' => $year,
		    'monthly_sales' => $monthly_sales,
		    'month' => $month
		);

		return $data;
		
	}

	public function login($email, $password){
		// Validate
		$this->db->where('email', strtolower($email));
		$query = $this->db->get('admin');

		$result = $query->row_array();

		if(!empty($result) && password_verify($password, $result['password'])){
			return $query->row_array();
		} else {
			return false;
		}
	}

	public function get_admins($email = FALSE){
		if($email === FALSE){
			$query = $this->db->get('admin');
			return $query->result_array();
		}
			
		$this->db->where('email', $email);
		$this->db->or_where('id', $email);
		$query = $this->db->get('admin');
		return $query->row_array();
	}

	function get_software_ratings(){	
		$this->db->select('*');
		$this->db->join('users', 'users.email = software_rating.email', 'left');

		$query = $this->db->get('software_rating');
		return $query->result_array();
	}

	function create_admin($email, $new_password, $first_name, $last_name, $position){
		$this->db->trans_begin();

		$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

		$data = array(
			'email' => strtolower($email),
			'password' => $hashed_password,
			'first_name' => strtolower($first_name),
			'last_name' => strtolower($last_name),
			'status' => 1,
			'position' => $position
		);

		$this->db->insert('admin', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	function update_admin($admin_ID, $email, $first_name, $last_name, $status, $position){
		$this->db->trans_begin();

		$data = array(
			'email' => strtolower($email),
			'first_name' => strtolower($first_name),
			'last_name' => strtolower($last_name),
			'status' => $status,
			'position' => $position
		);

		$this->db->where('id', $admin_ID);
		$this->db->update('admin', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	function change_password($new_password, $email){
		$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

		$this->db->set('password', $hashed_password);
		$this->db->where('email', strtolower($email));
		return $this->db->update('admin');
	}


}