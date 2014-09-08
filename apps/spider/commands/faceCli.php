<?php
require_once(__DIR__ . "/FacePPClientDemo.php");
class faceCli extends backgroundCli{
	function actionIndex($method){
		$data = "目标执行时间：".date("Y-m-d H:i:s")."\r\n";
		file_put_contents('/tmp/cli.log', $data,FILE_APPEND);		
		if(method_exists($this,$method)){
			$this->$method();
		}
	}
	public function faceTest(){
		$api_key = "80794efcf1c350268dc976b8fedd5617";
		$api_secret = "E2GkxairkHBryPMvFQ35uRwnEpNembgR";
		// initialize client object
		$api = new FacePPClientDemo($api_key, $api_secret);

		$person_name = "wgc";
		$group = "wgc_group";
		
		$this->create_person($api,$person_name);

		$this->create_group($api, $group, array($person_name));
		$urls = array(
			'http://bcs.duapp.com/lightbro/2013/11/08/4989946e2218613a1f2e1fc6ff6534b3.jpg',			
			'http://bcs.duapp.com/lightbro/2013/11/08/ff4b9772f6f2b81b7fc575ed0720c13e.jpg',
			'http://bcs.duapp.com/lightbro/2013/11/08/11e9916c5aa77de796b67fed324dc1f9.jpg',
			'http://bcs.duapp.com/lightbro/2013/11/08/3d262f691fc04be9a1608f390c7da549.jpg',
			'http://bcs.duapp.com/lightbro/2013/11/08/86d3ec189de9b75465008da336e73bd2.jpg'
			);
		$face_ids = array();
		foreach ($urls as $key => $value) {
			$this->detect($api, $person_name, $face_ids,$value);
			// generate training model for group
			$this->train($api, $group);		
		}
		// finally, identify people in the group
		$url = "http://bcs.duapp.com/lightbro/2013/11/08/8311de3ced5c92bd0640ad81d750798d.jpg";
		$this->identify($api, $group,$url);
	}
	private function detect(&$api, $person_name, &$face_ids,$url) 
	{
		// obtain photo_url to train
	    //$url = getTrainingUrl($person_name);
	    
	    // detect faces in this photo
	    $result = $api->face_detect($url);
	    // skip errors
	    if (empty($result->face))
	        return false;
	    // skip photo with multiple faces (we are not sure which face to train)
	   	if (count($result->face) > 1)
	   		return false;
	   	
	   	// obtain the face_id
	   	$face_id = $result->face[0]->face_id;

	   	$face_ids[] = $face_id;
	    // delete the person if exists
	    //$api->person_delete($person_name);
	   	// create a new person for this face
	   	//$api->person_create($person_name);
	   	// add face into new person
	   	$api->person_add_face($face_id, $person_name);
	}

	function train(&$api, $group_name)
	{
	   	// train model
	   	$session = $api->train_identify($group_name);
	    if (empty($session->session_id))
	    {
	        // something went wrong, skip
	        return false;
	    }
	    $session_id = $session->session_id;
	    // wait until training process done
	    while ($session=$api->info_get_session($session_id)) 
	    {
	        sleep(1);

	        if (!empty($session->status)) {
	            if ($session->status != "INQUEUE")
	                break;
	        }
	    }
		// done
	    return true;
	}
	/*
	 *	identify a person in group
	 */
	function identify(&$api, $group_name,$url)
	{
		// obtain photo_url to identify
		//$url = getPhotoUrl($person_name);
		
		// recoginzation
		$result = $api->recognition_identify($url, $group_name);
		
		// skip errors
		if (empty($result->face))
			return false;
		// skip photo with multiple faces
		if (count($result->face) > 1)
			return false;
		$face = $result->face[0];
		// skip if no person returned
		if (count($face->candidate) < 1)
			return false;
			
		// print result
		foreach ($face->candidate as $candidate) 
			echo "$candidate->person_name was found in $group_name with ".
	        "confidence $candidate->confidence\n";
	}

	/*
	 *	generate a new group with group_name, add all people into group
	 */
	function create_person(&$api, $person_name) 
	{
		$api->person_delete($person_name);
		// create new group
		$api->person_create($person_name);

	}
	function create_group(&$api, $group_name, $person_names) 
	{
		// delete the group if exists
		$api->group_delete($group_name);
		// create new group
		$api->group_create($group_name);
	   	// add new person into the group
		foreach ($person_names as $person_name)
		   	$api->group_add_person($person_name, $group_name);
	}

	/*
	 *	return the train data(image_url) of $person_name
	 */
	function getTrainingUrl($person_name)
	{
	    // TODO: here is just the fake url
		return "http://cn.faceplusplus.com/wp-content/themes/faceplusplus.zh/assets/img/demo/".$person_name.".jpg";
	}

	/*
	 *	return the photo_url of $person_name to identify for
	 */
	function getPhotoUrl($person_name)
	{
	    // TODO: here is just the fake url
		return "http://cn.faceplusplus.com/wp-content/themes/faceplusplus.zh/assets/img/demo/".$person_name.".jpg";
	}	
}