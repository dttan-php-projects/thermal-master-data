<?php
header("Content-Type: application/json");
if(!empty($_POST['data'])){
	$formatData = json_decode($_POST['data'],true);
	if(!empty($formatData)){
		$listID = implode(',',$formatData);
		if(!empty($listID)){
			require_once ("../Database.php");
			$print_type = $_COOKIE["print_type_thermal_mf"];
			if($print_type=='master'){
				$delete_ms = "delete from master_bom where id IN ($listID);";
			}elseif($print_type=='request'){
				$delete_ms = "delete from special_request where id IN ($listID);";
			}			
			$check_1 = $dbMi_138->query($delete_ms);
			if($check_1){
				$response = [
					'status' => true,
					'mess' =>''  
				];
			}else{
				$response = [
						'status' => false,
						'mess' =>  $dbMi_138->error
					];
			}
			echo json_encode($response);
		}
	}
}