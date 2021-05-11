<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends CI_Controller {

	function import(){
		if(isset($_FILES['facebook_csv'])) {
			$assoc_array = [];
			if (($handle = fopen($_FILES['facebook_csv']['tmp_name'], "r")) !== false) {                 // open for reading
			    if (($data = fgetcsv($handle, 1000, ",")) !== false) {         // extract header data
			        $keys = $data;                                             // save as keys
			    }
			    while (($data = fgetcsv($handle, 1000, ",")) !== false) {      // loop remaining rows of data
			        $assoc_array[] = array_combine($keys, $data);              // push associative subarrays
			    }
			    fclose($handle);                                               // close when done
			}

		    echo json_encode($assoc_array);	
		}
	}
}