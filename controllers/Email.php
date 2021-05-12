<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {

	function  __construct(){
        parent::__construct();
    }

	function send(){
		$verification_code = '0123456789';
	    $verification_code = str_shuffle($verification_code);
	    $verification_code = substr($verification_code, 0, 5);
	    $user = $this->user_model->get_users($this->input->post('email'));

	    if(!$user){
	    	$this->session->set_flashdata('error', 'Your email is not registered.');
	    	redirect('login');
	    }
        //Load PHPMailer library
        $this->load->library('phpmailer_lib');
        
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com'; // Which SMTP server to use.
        $mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
        $mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
        $mail->Username = 'support@studying.com';
		$mail->Password = '4;XT01Bem';
        $mail->setFrom('support@studying.com', 'Studying Support');
        $mail->addAddress($email); 
        $mail->Subject = "Reset Password";
        $mail->Body = "
        Your Verification Code:

        $verification_code

        NOTE: Once you verified your email, Your password will reset to learnecom.
        ";

        if($mail->send()){
            $create = $this->user_model->create_verification($email, $verification_code);
            $user_data2 = array(
                'email_verify' => $email
            );
            $this->session->set_userdata($user_data2);
            $this->session->set_flashdata('success', 'Verification code sent to your email!');
            redirect('verification');
        } else {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
       }
    }

    function verify(){
		$create = $this->user_model->verify($this->input->post('email'), $this->input->post('verify'));
		if($create){
			$this->session->set_flashdata('success', 'Your password has been reset to learnecom.');
			redirect('login');
		} else {
			$this->session->set_flashdata('error', 'Wrong verification code.');
			redirect('verification');
		}
    }

    function resend(){
    	$verification_code = '0123456789';
	    $verification_code = str_shuffle($verification_code);
	    $verification_code = substr($verification_code, 0, 5);
	    $email = $this->input->post('email');
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');
        
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com'; // Which SMTP server to use.
        $mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
        $mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
        $mail->Username = 'support@studying.com';
		$mail->Password = '4;XT01Bem';
        $mail->setFrom('support@studying.com', 'Studying Support');
        $mail->addAddress($email); 
        $mail->Subject = "Reset Password";
        $mail->Body = "
        Your Verification Code:

        $verification_code

        NOTE: Once you verified your email, Your password will reset to learnecom.
        ";
        if($mail->send()){
            $create = $this->user_model->create_verification($email, $verification_code);
            
            echo json_encode($create);
        }else{
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;	    
		}
    }
	

    function support(){
        $this->load->library('phpmailer_lib');
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        $email = $this->session->userdata('email');
        $first_name = $this->session->userdata('first_name');
        $last_name = $this->session->userdata('last_name');
        $message = $this->input->post('message');
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com'; // Which SMTP server to use.
        $mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
        $mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
        $mail->Username = 'support@studying.com';
        $mail->Password = '4;XT01Bem';
        $mail->setFrom('support@studying.com', 'Studying Support');
        $mail->addReplyTo($email, $first_name.' '.$last_name);
        $mail->addAddress('consulting@andymai.org'); 
        $mail->Subject = "Customer Support";
        $mail->Body = "$message

        Do not replay here.
        This message is sent by $email. Using the support page.
        Please replay to: $email";
        if($mail->send()){
            $this->support_model->send_message($this->session->userdata('user_id'), nl2br(htmlentities($this->input->post('message'), ENT_QUOTES, 'UTF-8')));
            $this->session->set_flashdata('success', 'Message Sent!');
            redirect('support');
        } else {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
       }
    }

    function customer_support(){
        $this->load->library('phpmailer_lib');
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        $email = $this->input->post('email');
        $message = $this->input->post('message');
        $fullname = $this->input->post('full_name');
        
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com'; // Which SMTP server to use.
        $mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
        $mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
        $mail->Username = 'support@studying.com';
        $mail->Password = '4;XT01Bem';
        $mail->setFrom('support@studying.com', 'Studying Support');
        $mail->addReplyTo($email, $fullname);
        $mail->addAddress('consulting@andymai.org'); 
        $mail->Subject = "Customer Support";
        $mail->Body = "$message

        Do not replay here.
        This message is sent by $email. Using the support page.
        Please replay to: $email";

        if($mail->send()){
            $this->session->set_flashdata('success', 'Message Sent!');
            echo json_encode(true);
        } else {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
       }
    }
}