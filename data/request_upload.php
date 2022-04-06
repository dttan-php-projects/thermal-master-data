<?php
function getFileExcel($fileName){	
	//Nhúng file PHPExcel
	require_once "../Module/PHPExcel.php";
	//Tiến hành xác thực file
	$objFile = PHPExcel_IOFactory::identify($fileName);
	$objData = PHPExcel_IOFactory::createReader($objFile);
	//Chỉ đọc dữ liệu
	$objData->setReadDataOnly(true);

	// Load dữ liệu sang dạng đối tượng
	$objPHPExcel = $objData->load($fileName);
	//Chọn trang cần truy xuất
	$sheet = $objPHPExcel->setActiveSheetIndex(0);

	//Lấy ra số dòng cuối cùng
	$Totalrow = $sheet->getHighestRow();
	//Lấy ra tên cột cuối cùng
	$LastColumn = $sheet->getHighestColumn();
	//Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
	$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);
	//Tạo mảng chứa dữ liệu
	$data = [];
	//Tiến hành lặp qua từng ô dữ liệu
	//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2 , nếu có Tiêu Đề , 1 không có tiêu đề
	$firstRow = $sheet->getCellByColumnAndRow(0, 1)->getValue();
	$checkColumD = $sheet->getCellByColumnAndRow(3, 1)->getValue();
	for ($i = 2; $i <= $Totalrow; $i++) {
    //----Lặp cột
		for ($j = 0; $j < $TotalCol; $j++) {
			// Tiến hành lấy giá trị của từng ô đổ vào mảng
			$dataValue = $sheet->getCellByColumnAndRow($j, $i)->getValue();
			$dataValue = trim($dataValue);
			$data[$i - 1][$j] = $dataValue;
		}	
	}
	//Hiển thị mảng dữ liệu
	return $data;
}

if (@$_REQUEST["mode"] == "html5" || @$_REQUEST["mode"] == "flash") {
	header("Content-Type: text/json");
	$filename = date("d_m_Y__H_i_s");
	$excelType = ['d/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel','application/vnd.ms-excel.sheet.macroEnabled.12'];
	$fileSize = $_FILES['file']['size'];
	$fileType = $_FILES['file']['type'];
	if($fileSize>1000000){
		$response = [
			'state' 	=>	false,
			'name'   	=>	$filename,
			'extra' 	=>	[
				'mess' => 'File dữ liệu import quá lớn, Vui lòng kiểm tra lại',
			]
		];
	}elseif(!in_array($fileType,$excelType)){
		$response = [
			'state' 	=>	false,
			'name'   	=>	$filename,
			'extra'		=>	[
				'mess' => 'File dữ liệu phải là EXCEL, Vui lòng kiểm tra lại',
			]
		];
	}else{
		// move_uploaded_file($_FILES["file"]["tmp_name"],"uploaded/".$filename);
		$data = getFileExcel($_FILES['file']["tmp_name"]);
		if(count($data[1])!=7){
			$response = [
				'state' 	=>	false,	
				'name'   	=>	$filename,			
				'extra'		=>	[
					'mess' => 'Kiểm tra lại dữ liệu file EXCEL',
				]
			];
			echo json_encode($response);die;
		}
		if(!empty($data)){
			// delete 
			require_once ("../Database.php");
			$sql_delete = "TRUNCATE special_request";
			$dbMi_138->query($sql_delete);
			/*
			echo "<pre>";
			print_r($data);die;
			*/
			$UPDATED_BY  = '';
			$user = $_COOKIE["VNRISIntranet"];
			if(!empty($user)){
				$UPDATED_BY = $user;
			}
			foreach($data as $key => $value){
				$GLID = !empty($value[0])?addslashes($value[0]):'';
				$RBO = !empty($value[1])?addslashes($value[1]):'';
				$CUSTOMER_NAME = !empty($value[2])?addslashes($value[2]):'';
				$NOTE = !empty($value[3])?addslashes($value[3]):'';
				$DATE = !empty($value[4])?addslashes($value[4]):'';
				$REQUEST_FROM = !empty($value[5])?addslashes($value[5]):'';
				$APPROVED_BY = !empty($value[6])?addslashes($value[6]):'';
				$sql = "INSERT INTO `special_request` 
						(`GLID`,`RBO`,`CUSTOMER_NAME`,`NOTE`,`DATE`,`REQUEST_FROM`,`APPROVED_BY`,`UPDATED_BY`) VALUES ('$GLID','$RBO','$CUSTOMER_NAME','$NOTE','$DATE','$REQUEST_FROM','$APPROVED_BY','$UPDATED_BY')";			
				$check = $dbMi_138->query($sql);
				if(!$check){
					$response = [
							'state' 	=>	false,	
							'name'   	=>	$filename,			
							'extra'		=>	[
								'mess' => 'Có lỗi xảy ra trong quá trình import: '.$dbMi_138->error,
						]
					];
					echo json_encode($response);die;
				}
			}		
			if($check){
				$response = [
					'state' 	=>	true,	
					'name'   	=>	$filename,			
					'extra'		=>	[
						'mess' => 'Import dữ liệu thành công, Website sẽ reload!!!!',
					]
				];
			}
		}else{
			$response = [
				'state' 	=>	false,	
				'name'   	=>	$filename,			
				'extra'		=>	[
					'mess' => 'Kiểm tra lại dữ liệu file EXCEL',
				]
			];
		}				
	}
	echo json_encode($response);
}

/*

HTML4 MODE

response format:

to cancel uploading
{state: 'cancelled'}

if upload was good, you need to specify state=true, name - will passed in form.send() as serverName param, size - filesize to update in list
{state: 'true', name: 'filename', size: 1234}

*/

if (@$_REQUEST["mode"] == "html4") {
	header("Content-Type: text/html");
	if (@$_REQUEST["action"] == "cancel") {
		print_r("{state:'cancelled'}");
	} else {
		$filename = $_FILES["file"]["name"];
		move_uploaded_file($_FILES["file"]["tmp_name"], "uploaded/".$filename);
		print_r("{state: true, name:'".str_replace("'","\\'",$filename)."', size:".$_FILES["file"]["size"]/*filesize("uploaded/".$filename)*/.", extra: {info: 'just a way to send some extra data', param: 'some value here'}}");
	}
}
?>
