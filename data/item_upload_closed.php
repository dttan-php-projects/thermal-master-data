<?php
function getFileExcel($fileName){	
	//Nhúng file PHPExcel
	require_once $_SERVER["DOCUMENT_ROOT"]."/Module/PHPExcel/IOFactory.php";
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
	if($fileSize>2000000){
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
		if(count($data[1])!=43){
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
			//$sql_delete = "TRUNCATE master_bom_test";
			//$dbMi_138->query($sql_delete);
			/*
			echo "<pre>";
			print_r($data);die;
			*/
			$UPDATED_BY  = '';
			$user = $_COOKIE["VNRISIntranet"];
			if(!empty($user)){
				$UPDATED_BY = $user;
			}
			$SQL_COUNT_ITEM = "SELECT count(ID) AS COUNT_ITEM FROM master_bom_test;";
			$COUNT_ITEM = MiQuery($SQL_COUNT_ITEM,$dbMi_138);
			if(!count($data)>=($COUNT_ITEM-5)){
				$response = [
					'state' 	=>	false,	
					'name'   	=>	$filename,			
					'extra'		=>	[
						'mess' => 'Số item upload phải lớn hơn số item trên hệ thống!!!',
					]
				];
				echo json_encode($response);die;
			}
			$SQL_MAX_ID = "SELECT max(ID) AS MAX_ID FROM master_bom_test;";
			$MAX_ID = MiQuery($SQL_MAX_ID,$dbMi_138);
			foreach($data as $key => $value){
				$INTERNAL_ITEM = !empty($value[0])?addslashes($value[0]):'';
				$ITEM_DES = !empty($value[1])?addslashes($value[1]):'';
				$RBO = !empty($value[2])?addslashes($value[2]):'';
				$ORDERED_ITEM = !empty($value[3])?addslashes($value[3]):'';
				$MATERIAL_CODE = !empty($value[4])?addslashes($value[4]):'';
				$MATERIAL_DES = !empty($value[5])?addslashes($value[5]):'';
				$RIBBON_CODE = !empty($value[6])?addslashes($value[6]):'';
				$RIBBON_DES = !empty($value[7])?addslashes($value[7]):'';
				$CHIEU_DAI = !empty($value[8])?addslashes($value[8]):0;
				$CHIEU_RONG = !empty($value[9])?addslashes($value[9]):0;
				$KICH_THUOC_SHEET = !empty($value[10])?addslashes($value[10]):'';
				$GAP = !empty($value[11])?addslashes($value[11]):'';
				$UPS = !empty($value[12])?addslashes($value[12]):'';
				$ONE_TWO_SITE_PRINTING = !empty($value[13])?addslashes($value[13]):'';
				$MACHINE = !empty($value[14])?addslashes($value[14]):'';
				$FORMAT = !empty($value[15])?addslashes($value[15]):'';
				$LOAI_VAT_TU = !empty($value[16])?addslashes($value[16]):'';
				$STANDARD_SPEED_INCH = !empty($value[17])?addslashes($value[17]):'';
				$STANDARD_SPEED_PCS = !empty($value[18])?addslashes($value[18]):'';
				$CUTTER = !empty($value[19])?addslashes($value[19]):'';
				$NHOM = !empty($value[20])?addslashes($value[20]):'';
				$MATERIAL_UOM = !empty($value[21])?addslashes($value[21]):'';
				$MATERIAL_UOM = strtoupper($MATERIAL_UOM);
				$SECURITY = !empty($value[22])?addslashes($value[22]):'';
				$FG_IPPS = !empty($value[23])?addslashes($value[23]):'';
				$PCS_SET = !empty($value[24])?addslashes($value[24]):'';
				$CHIEU_IN_NHAN_THUC_TE = !empty($value[25])?addslashes($value[25]):'';
				$MATERIAL_CODE_2 = !empty($value[26])?addslashes($value[26]):'';
				$MATERIAL_DES_2 = !empty($value[27])?addslashes($value[27]):'';
				$MATERIAL_UOM_2 = !empty($value[28])?addslashes($value[28]):'';
				$MATERIAL_UOM_2 = strtoupper($MATERIAL_UOM_2);
				$RIBBON_CODE_2 = !empty($value[29])?addslashes($value[29]):'';
				$RIBBON_DES_2 = !empty($value[30])?addslashes($value[30]):'';
				$LAYOUT_PREPRESS = !empty($value[31])?addslashes($value[31]):'';
				$REMARK_1_ITEM = !empty($value[32])?addslashes($value[32]):'';
				$REMARK_2_SHIPPING = !empty($value[33])?addslashes($value[33]):'';
				$REMARK_3_PACKING = !empty($value[34])?addslashes($value[34]):'';
				$REMARK_4_SAN_XUAT = !empty($value[35])?addslashes($value[35]):'';
				$GHI_CHU = !empty($value[36])?addslashes($value[36]):'';
				$BASE_ROLL = !empty($value[37])?addslashes($value[37]):'';
				$RIBBON_MT_KIT = !empty($value[38])?addslashes($value[38]):'';
				$CHI_TIET_KIT = !empty($value[39])?addslashes($value[39]):'';
				$COLOR_BY_SIZE = !empty($value[40])?addslashes($value[40]):'';
				if(!empty($INTERNAL_ITEM)){
					$sql = "INSERT INTO `master_bom_test` 
							(`INTERNAL_ITEM`,`ITEM_DES`,`RBO`,`ORDERED_ITEM`,`MATERIAL_CODE`,`MATERIAL_DES`,`RIBBON_CODE`,`RIBBON_DES`,`CHIEU_DAI`,`CHIEU_RONG`,`KICH_THUOC_SHEET`,`GAP`,`UPS`,`ONE_TWO_SITE_PRINTING`,`MACHINE`,`FORMAT`,`LOAI_VAT_TU`,`STANDARD_SPEED_INCH`,`STANDARD_SPEED_PCS`,`CUTTER`,`NHOM`,`MATERIAL_UOM`,`SECURITY`,`FG_IPPS`,`PCS_SET`,`CHIEU_IN_NHAN_THUC_TE`,`MATERIAL_CODE_2`,`MATERIAL_DES_2`,`MATERIAL_UOM_2`,`RIBBON_CODE_2`,`RIBBON_DES_2`,`LAYOUT_PREPRESS`,`REMARK_1_ITEM`,`REMARK_2_SHIPPING`,`REMARK_3_PACKING`,`REMARK_4_SAN_XUAT`,`GHI_CHU`,`BASE_ROLL`,`RIBBON_MT_KIT`,`CHI_TIET_KIT`,`COLOR_BY_SIZE`,`UPDATED_BY`) VALUES ('$INTERNAL_ITEM','$ITEM_DES','$RBO','$ORDERED_ITEM','$MATERIAL_CODE','$MATERIAL_DES','$RIBBON_CODE','$RIBBON_DES','$CHIEU_DAI','$CHIEU_RONG','$KICH_THUOC_SHEET','$GAP','$UPS','$ONE_TWO_SITE_PRINTING','$MACHINE','$FORMAT','$LOAI_VAT_TU','$STANDARD_SPEED_INCH','$STANDARD_SPEED_PCS','$CUTTER','$NHOM','$MATERIAL_UOM','$SECURITY','$FG_IPPS','$PCS_SET','$CHIEU_IN_NHAN_THUC_TE','$MATERIAL_CODE_2','$MATERIAL_DES_2','$MATERIAL_UOM_2','$RIBBON_CODE_2','$RIBBON_DES_2','$LAYOUT_PREPRESS','$REMARK_1_ITEM','$REMARK_2_SHIPPING','$REMARK_3_PACKING','$REMARK_4_SAN_XUAT','$GHI_CHU','$BASE_ROLL','$RIBBON_MT_KIT','$CHI_TIET_KIT','$COLOR_BY_SIZE','$UPDATED_BY')";			
					$check = $dbMi_138->query($sql);
					//backup data
					$sql_backup = "INSERT INTO `master_bom_backup` 
					(`INTERNAL_ITEM`,`ITEM_DES`,`RBO`,`ORDERED_ITEM`,`MATERIAL_CODE`,`MATERIAL_DES`,`RIBBON_CODE`,`RIBBON_DES`,`CHIEU_DAI`,`CHIEU_RONG`,`KICH_THUOC_SHEET`,`GAP`,`UPS`,`ONE_TWO_SITE_PRINTING`,`MACHINE`,`FORMAT`,`LOAI_VAT_TU`,`STANDARD_SPEED_INCH`,`STANDARD_SPEED_PCS`,`CUTTER`,`NHOM`,`MATERIAL_UOM`,`SECURITY`,`FG_IPPS`,`PCS_SET`,`CHIEU_IN_NHAN_THUC_TE`,`MATERIAL_CODE_2`,`MATERIAL_DES_2`,`MATERIAL_UOM_2`,`RIBBON_CODE_2`,`RIBBON_DES_2`,`LAYOUT_PREPRESS`,`REMARK_1_ITEM`,`REMARK_2_SHIPPING`,`REMARK_3_PACKING`,`REMARK_4_SAN_XUAT`,`GHI_CHU`,`BASE_ROLL`,`RIBBON_MT_KIT`,`CHI_TIET_KIT`,`COLOR_BY_SIZE`,`UPDATED_BY`) VALUES ('$INTERNAL_ITEM','$ITEM_DES','$RBO','$ORDERED_ITEM','$MATERIAL_CODE','$MATERIAL_DES','$RIBBON_CODE','$RIBBON_DES','$CHIEU_DAI','$CHIEU_RONG','$KICH_THUOC_SHEET','$GAP','$UPS','$ONE_TWO_SITE_PRINTING','$MACHINE','$FORMAT','$LOAI_VAT_TU','$STANDARD_SPEED_INCH','$STANDARD_SPEED_PCS','$CUTTER','$NHOM','$MATERIAL_UOM','$SECURITY','$FG_IPPS','$PCS_SET','$CHIEU_IN_NHAN_THUC_TE','$MATERIAL_CODE_2','$MATERIAL_DES_2','$MATERIAL_UOM_2','$RIBBON_CODE_2','$RIBBON_DES_2','$LAYOUT_PREPRESS','$REMARK_1_ITEM','$REMARK_2_SHIPPING','$REMARK_3_PACKING','$REMARK_4_SAN_XUAT','$GHI_CHU','$BASE_ROLL','$RIBBON_MT_KIT','$CHI_TIET_KIT','$COLOR_BY_SIZE','$UPDATED_BY')";										
					
					// $check_backup = $dbMi_138->query($sql_backup);
					if(!$check){
						$response = [
								'state' 	=>	false,	
								'name'   	=>	$filename,			
								'extra'		=>	[
									'mess' => 'Có lỗi xảy ra trong quá trình import: '.$dbMi_138->error." SQL: $sql",
							]
						];
						echo json_encode($response);die;
					}
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
				// delete max				
				$DELETE_SQL  = "DELETE FROM master_bom_test WHERE ID<=$MAX_ID";
				$dbMi_138->query($DELETE_SQL);
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
