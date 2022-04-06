<?php
function existPartNumber($ID,$PART_NUMBER,$dbMi_138,$print_type,$INSERT=1){
	if($INSERT==1){
		if($print_type=='master'){
			$sql = "SELECT count(ID) AS count_item FROM master_bom WHERE INTERNAL_ITEM='$PART_NUMBER'";						
		}
		//echo $sql;die;
		$rowsCount = $dbMi_138->query($sql);
	}else{
		if($print_type=='master'){
			$sql = "SELECT count(ID) AS count_item FROM master_bom WHERE INTERNAL_ITEM='$PART_NUMBER' AND ID!=$ID";						
		}
		//echo $sql;die;
		$rowsCount = $dbMi_138->query($sql);
	}
	$results = mysqli_fetch_all($rowsCount,MYSQLI_ASSOC);
	return $results[0]['count_item'];
}
header("Content-Type: application/json");
if(empty($_COOKIE["VNRISIntranet"])){
	$response = [
		'status' => false,
		'mess' =>  'VUI LÒNG ĐĂNG NHẬP VÀO HỆ THỐNG ĐỂ UPDATE!!!'// use to debug code
	];
	echo json_encode($response);
}elseif(empty($_COOKIE["print_type_thermal_mf"])){
	$response = [
		'status' => false,
		'mess' =>  'VUI LÒNG CHỌN SHEET CẦN UPDATE!!!'// use to debug code
	];
	echo json_encode($response);
}

$data = $_POST['data'];
// $data = '{"item":{"AB1":"WV","ORDER_TYPE":"VN INTERCO","BOARD":"","AD1":"29.2T","SIZE":"SIZE","SCRAP":"6","PD":"16-10-2018","REQ":"16-10-2018","ORDERED":"27-09-2018","ITEM":"WX025250A","item_length":"WX025250A98","RBO":"NIKE","NUMBER_SIZE":0,"NUM_WIRE":"28","NUMBER_PATTERN":"1T24/5219","HEIGHT_BTP":"33","HEIGHT_TP":"33","CHI_DOC_CAN":0,"WATER":0,"glue":0,"TYPE_WORST_VERTICAL":"75-B2","PAPER_SIZE":"5","SO_SOI_DOC":144,"gear_density":"70D","width_BTP":"98","width_TP":"49","folding_type":"CL","laser_cutting":0,"ultra_sonic":1,"glue1":"0","glue2":"0","note1":"0","note2":"0","iron_temp":"90-120","Q44":"38","S44":"39.6T","Q45":"28","S45":"29.2T","PROCESS":[{"name":"Dệt","display":"1"},{"name":"Cắt nóng","display":"0"},{"name":"Xẻ sonic","display":"1"},{"name":"Qua hồ","display":"0"},{"name":"Qua nước","display":"0"},{"name":"Nối đầu","display":"1"},{"name":"Dán keo","display":"0"},{"name":"Cắt gấp: CL","display":"1"},{"name":"Đóng gói","display":"1"}],"SAVE_DATE":"","NUMBER_NO":"","NUMBER_PICKS":1120},"size":[{"size":"","qty":"42014","qty_so_1":"8027","qty_so_2":"15607","qty_so_3":"6094","qty_so_4":"12286","qty_so_5":"","qty_so_6":"","qty_so_7":"","qty_so_8":"","qty_so_9":"","qty_so_10":"","qty_so_11":"","qty_so_12":"","qty_so_13":"","qty_so_14":"","qty_so_15":"","qty_row":"1611","qty_row_1":"309","qty_row_2":"596","qty_row_3":"236","qty_row_4":"470","qty_row_5":"","qty_row_6":"","qty_row_7":"","qty_row_8":"","qty_row_9":"","qty_row_10":"","qty_row_11":"","qty_row_12":"","qty_row_13":"","qty_row_14":"","qty_row_15":"","scrap":"7%"}],"supply":[{"code_supply":"YRCP07009001","density":"70D","number_picks":"602","chieu_dai_chi":"120000","chi_ngang_can":"0"},{"code_supply":"LY070220001053","density":"70D","number_picks":"518","chieu_dai_chi":"128571","chi_ngang_can":"0"}],"so":[{"so_line":"27031435-1","qty":"8027","item":"WX025250A"},{"so_line":"27031435-2","qty":"15607","item":"WX025250A"},{"so_line":"27031435-3","qty":"6094","item":"WX025250A"},{"so_line":"27031435-4","qty":"12286","item":"WX025250A"}]}';
if(!empty($data)){		
    $formatiItem = json_decode($data,true);    
    // save date process after that
    if($formatiItem){
		/*
		echo "<pre>";
		print_r($formatiItem);die;
		*/
		if(!empty($formatiItem)){
			require_once ("../Database.php");
			$print_type = $_COOKIE["print_type_thermal_mf"];
			$UPDATED_BY  = '';
			$user = $_COOKIE["VNRISIntranet"];
			if(!empty($user)){
				$UPDATED_BY = $user;
			}
			foreach($formatiItem as $key => $format){
				$formatData = $format['data'];
				$ID = $format['id'];
				if($print_type=='master'){					
					$INTERNAL_ITEM = !empty($formatData['INTERNAL_ITEM'])?addslashes($formatData['INTERNAL_ITEM']):'';
					$INTERNAL_ITEM = trim($INTERNAL_ITEM);
					$ITEM_DES = !empty($formatData['ITEM_DES'])?addslashes($formatData['ITEM_DES']):'';
					$ITEM_DES = trim($ITEM_DES);
					$RBO = !empty($formatData['RBO'])?addslashes($formatData['RBO']):'';
					$RBO = trim($RBO);
					$ORDERED_ITEM = !empty($formatData['ORDERED_ITEM'])?addslashes($formatData['ORDERED_ITEM']):'';
					$ORDERED_ITEM = trim($ORDERED_ITEM);
					$MATERIAL_CODE = !empty($formatData['MATERIAL_CODE'])?addslashes($formatData['MATERIAL_CODE']):'';
					$MATERIAL_CODE = trim($MATERIAL_CODE);
					$MATERIAL_DES = !empty($formatData['MATERIAL_DES'])?addslashes($formatData['MATERIAL_DES']):'';
					$MATERIAL_DES = trim($MATERIAL_DES);
					$RIBBON_CODE = !empty($formatData['RIBBON_CODE'])?addslashes($formatData['RIBBON_CODE']):'';
					$RIBBON_CODE = trim($RIBBON_CODE);
					$RIBBON_DES = !empty($formatData['RIBBON_DES'])?addslashes($formatData['RIBBON_DES']):'';
					$RIBBON_DES = trim($RIBBON_DES);
					$CHIEU_DAI = !empty($formatData['CHIEU_DAI'])?addslashes($formatData['CHIEU_DAI']):'';
					$CHIEU_DAI = trim($CHIEU_DAI);
					$CHIEU_RONG = !empty($formatData['CHIEU_RONG'])?addslashes($formatData['CHIEU_RONG']):'';
					$CHIEU_RONG = trim($CHIEU_RONG);
					$KICH_THUOC_SHEET = !empty($formatData['KICH_THUOC_SHEET'])?addslashes($formatData['KICH_THUOC_SHEET']):'';
					$KICH_THUOC_SHEET = trim($KICH_THUOC_SHEET);
					$GAP = !empty($formatData['GAP'])?addslashes($formatData['GAP']):'';
					$GAP = trim($GAP);
					$UPS = !empty($formatData['UPS'])?addslashes($formatData['UPS']):'';
					$UPS = trim($UPS);
					$ONE_TWO_SITE_PRINTING = !empty($formatData['ONE_TWO_SITE_PRINTING'])?addslashes($formatData['ONE_TWO_SITE_PRINTING']):'';
					$ONE_TWO_SITE_PRINTING = trim($ONE_TWO_SITE_PRINTING);
					$MACHINE = !empty($formatData['MACHINE'])?addslashes($formatData['MACHINE']):'';
					$MACHINE = trim($MACHINE);
					$FORMAT = !empty($formatData['FORMAT'])?addslashes($formatData['FORMAT']):'';
					$FORMAT = trim($FORMAT);
					$LOAI_VAT_TU = !empty($formatData['LOAI_VAT_TU'])?addslashes($formatData['LOAI_VAT_TU']):'';
					$LOAI_VAT_TU = trim($LOAI_VAT_TU);
					$STANDARD_SPEED_INCH = !empty($formatData['STANDARD_SPEED_INCH'])?addslashes($formatData['STANDARD_SPEED_INCH']):'';
					$STANDARD_SPEED_INCH = trim($STANDARD_SPEED_INCH);
					$STANDARD_SPEED_PCS = !empty($formatData['STANDARD_SPEED_PCS'])?addslashes($formatData['STANDARD_SPEED_PCS']):'';
					$STANDARD_SPEED_PCS = trim($STANDARD_SPEED_PCS);
					$CUTTER = !empty($formatData['CUTTER'])?addslashes($formatData['CUTTER']):'';
					$CUTTER = trim($CUTTER);
					$NHOM = !empty($formatData['NHOM'])?addslashes($formatData['NHOM']):'';
					$NHOM = trim($NHOM);
					$MATERIAL_UOM = !empty($formatData['MATERIAL_UOM'])?addslashes($formatData['MATERIAL_UOM']):'';
					$MATERIAL_UOM = trim($MATERIAL_UOM);
					$SECURITY = !empty($formatData['SECURITY'])?addslashes($formatData['SECURITY']):'';
					$SECURITY = trim($SECURITY);
					$FG_IPPS = !empty($formatData['FG_IPPS'])?addslashes($formatData['FG_IPPS']):'';
					$FG_IPPS = trim($FG_IPPS);
					$PCS_SET = !empty($formatData['PCS_SET'])?addslashes($formatData['PCS_SET']):'';
					$PCS_SET = trim($PCS_SET);
					$CHIEU_IN_NHAN_THUC_TE = !empty($formatData['CHIEU_IN_NHAN_THUC_TE'])?addslashes($formatData['CHIEU_IN_NHAN_THUC_TE']):'';
					$CHIEU_IN_NHAN_THUC_TE = trim($CHIEU_IN_NHAN_THUC_TE);
					$MATERIAL_CODE_2 = !empty($formatData['MATERIAL_CODE_2'])?addslashes($formatData['MATERIAL_CODE_2']):'';
					$MATERIAL_CODE_2 = trim($MATERIAL_CODE_2);
					$MATERIAL_DES_2 = !empty($formatData['MATERIAL_DES_2'])?addslashes($formatData['MATERIAL_DES_2']):'';
					$MATERIAL_DES_2 = trim($MATERIAL_DES_2);
					$MATERIAL_UOM_2 = !empty($formatData['MATERIAL_UOM_2'])?addslashes($formatData['MATERIAL_UOM_2']):'';
					$MATERIAL_UOM_2 = trim($MATERIAL_UOM_2);
					$RIBBON_CODE_2 = !empty($formatData['RIBBON_CODE_2'])?addslashes($formatData['RIBBON_CODE_2']):'';
					$RIBBON_CODE_2 = trim($RIBBON_CODE_2);
					$RIBBON_DES_2 = !empty($formatData['RIBBON_DES_2'])?addslashes($formatData['RIBBON_DES_2']):'';
					$RIBBON_DES_2 = trim($RIBBON_DES_2);
					$LAYOUT_PREPRESS = !empty($formatData['LAYOUT_PREPRESS'])?addslashes($formatData['LAYOUT_PREPRESS']):'';
					$LAYOUT_PREPRESS = trim($LAYOUT_PREPRESS);
					$REMARK_1_ITEM = !empty($formatData['REMARK_1_ITEM'])?addslashes($formatData['REMARK_1_ITEM']):'';
					$REMARK_1_ITEM = trim($REMARK_1_ITEM);
					$REMARK_2_SHIPPING = !empty($formatData['REMARK_2_SHIPPING'])?addslashes($formatData['REMARK_2_SHIPPING']):'';
					$REMARK_2_SHIPPING = trim($REMARK_2_SHIPPING);
					$REMARK_3_PACKING = !empty($formatData['REMARK_3_PACKING'])?addslashes($formatData['REMARK_3_PACKING']):'';
					$REMARK_3_PACKING = trim($REMARK_3_PACKING);
					$REMARK_4_SAN_XUAT = !empty($formatData['REMARK_4_SAN_XUAT'])?addslashes($formatData['REMARK_4_SAN_XUAT']):'';
					$REMARK_4_SAN_XUAT = trim($REMARK_4_SAN_XUAT);
					$GHI_CHU = !empty($formatData['GHI_CHU'])?addslashes($formatData['GHI_CHU']):'';
					$GHI_CHU = trim($GHI_CHU);
					$BASE_ROLL = !empty($formatData['BASE_ROLL'])?addslashes($formatData['BASE_ROLL']):'';
					$BASE_ROLL = trim($BASE_ROLL);
					$RIBBON_MT_KIT = !empty($formatData['RIBBON_MT_KIT'])?addslashes($formatData['RIBBON_MT_KIT']):'';
					$RIBBON_MT_KIT = trim($RIBBON_MT_KIT);
					$CHI_TIET_KIT = !empty($formatData['CHI_TIET_KIT'])?addslashes($formatData['CHI_TIET_KIT']):'';
					$CHI_TIET_KIT = trim($CHI_TIET_KIT);
					$COLOR_BY_SIZE = !empty($formatData['COLOR_BY_SIZE'])?addslashes($formatData['COLOR_BY_SIZE']):'';
					$COLOR_BY_SIZE = trim($COLOR_BY_SIZE);
				}elseif($print_type=='request'){
					$GLID = !empty($formatData['GLID'])?addslashes($formatData['GLID']):'';
					$GLID = trim($GLID);
					$RBO = !empty($formatData['RBO'])?addslashes($formatData['RBO']):'';
					$RBO = trim($RBO);
					$CUSTOMER_NAME = !empty($formatData['CUSTOMER_NAME'])?addslashes($formatData['CUSTOMER_NAME']):'';
					$CUSTOMER_NAME = trim($CUSTOMER_NAME);
					$NOTE = !empty($formatData['NOTE'])?addslashes($formatData['NOTE']):'';
					$NOTE = trim($NOTE);
					$DATE = !empty($formatData['DATE'])?addslashes($formatData['DATE']):'';
					$DATE = trim($DATE);
					$REQUEST_FROM = !empty($formatData['REQUEST_FROM'])?addslashes($formatData['REQUEST_FROM']):'';
					$REQUEST_FROM = trim($REQUEST_FROM);
					$APPROVED_BY = !empty($formatData['APPROVED_BY'])?addslashes($formatData['APPROVED_BY']):'';
					$APPROVED_BY = trim($APPROVED_BY);
				}
				if($print_type=='master'){
					$table_name = 'master_bom';
				}elseif($print_type=='request'){
					$table_name = 'special_request';
				}
				//$check_1 = true;
				$idUA = $ID;
				if(strpos($idUA,'new_id_')!==false){  // insert
					if($print_type=='master'){
						$checkExist = existPartNumber($ID,$INTERNAL_ITEM,$dbMi_138,$print_type,1);
						if($checkExist>0){
							$response = [
								'status' => false,
								'mess' =>  "INTERNAL ITEM: $INTERNAL_ITEM ĐÃ TỒN TẠI TRÊN HỆ THỐNG"
							];
							echo json_encode($response);die;
						}
					}				
					if($print_type=='master'){
						$sql = "INSERT INTO `master_bom` 
							(`INTERNAL_ITEM`,`ITEM_DES`,`RBO`,`ORDERED_ITEM`,`MATERIAL_CODE`,`MATERIAL_DES`,`RIBBON_CODE`,`RIBBON_DES`,`CHIEU_DAI`,`CHIEU_RONG`,`KICH_THUOC_SHEET`,`GAP`,`UPS`,`ONE_TWO_SITE_PRINTING`,`MACHINE`,`FORMAT`,`LOAI_VAT_TU`,`STANDARD_SPEED_INCH`,`STANDARD_SPEED_PCS`,`CUTTER`,`NHOM`,`MATERIAL_UOM`,`SECURITY`,`FG_IPPS`,`PCS_SET`,`CHIEU_IN_NHAN_THUC_TE`,`MATERIAL_CODE_2`,`MATERIAL_DES_2`,`MATERIAL_UOM_2`,`RIBBON_CODE_2`,`RIBBON_DES_2`,`LAYOUT_PREPRESS`,`REMARK_1_ITEM`,`REMARK_2_SHIPPING`,`REMARK_3_PACKING`,`REMARK_4_SAN_XUAT`,`GHI_CHU`,`BASE_ROLL`,`RIBBON_MT_KIT`,`CHI_TIET_KIT`,`COLOR_BY_SIZE`,`UPDATED_BY`) VALUES ('$INTERNAL_ITEM','$ITEM_DES','$RBO','$ORDERED_ITEM','$MATERIAL_CODE','$MATERIAL_DES','$RIBBON_CODE','$RIBBON_DES','$CHIEU_DAI','$CHIEU_RONG','$KICH_THUOC_SHEET','$GAP','$UPS','$ONE_TWO_SITE_PRINTING','$MACHINE','$FORMAT','$LOAI_VAT_TU','$STANDARD_SPEED_INCH','$STANDARD_SPEED_PCS','$CUTTER','$NHOM','$MATERIAL_UOM','$SECURITY','$FG_IPPS','$PCS_SET','$CHIEU_IN_NHAN_THUC_TE','$MATERIAL_CODE_2','$MATERIAL_DES_2','$MATERIAL_UOM_2','$RIBBON_CODE_2','$RIBBON_DES_2','$LAYOUT_PREPRESS','$REMARK_1_ITEM','$REMARK_2_SHIPPING','$REMARK_3_PACKING','$REMARK_4_SAN_XUAT','$GHI_CHU','$BASE_ROLL','$RIBBON_MT_KIT','$CHI_TIET_KIT','$COLOR_BY_SIZE','$UPDATED_BY')";
					}elseif($print_type=='request'){
						$sql = "INSERT INTO `special_request` 
								(`GLID`,`RBO`,`CUSTOMER_NAME`,`NOTE`,`DATE`,`REQUEST_FROM`,`APPROVED_BY`,`UPDATED_BY`) VALUES ('$GLID','$RBO','$CUSTOMER_NAME','$NOTE','$DATE','$REQUEST_FROM','$APPROVED_BY','$UPDATED_BY')";
					}
					$check_1 = $dbMi_138->query($sql);		
				}else{
					if($print_type=='master'){
						// check PART_NUMBER
						$checkExist = existPartNumber($ID,$INTERNAL_ITEM,$dbMi_138,$print_type,0);
						if($checkExist>0){
							$response = [
								'status' => false,
								'mess' =>  "INTERNAL ITEM: $INTERNAL_ITEM ĐÃ TỒN TẠI TRÊN HỆ THỐNG"
							];
							echo json_encode($response);die;
						}
					}					
					// update
					if($print_type=='master'){
						$sql = "UPDATE `$table_name` SET `INTERNAL_ITEM`='$INTERNAL_ITEM',`ITEM_DES`='$ITEM_DES',`RBO`='$RBO',`ORDERED_ITEM`='$ORDERED_ITEM',`MATERIAL_CODE`='$MATERIAL_CODE',`MATERIAL_DES`='$MATERIAL_DES',`MATERIAL_UOM_2`='$MATERIAL_UOM_2',`RIBBON_CODE`='$RIBBON_CODE',`RIBBON_DES`='$RIBBON_DES',`CHIEU_DAI`='$CHIEU_DAI',`CHIEU_RONG`='$CHIEU_RONG',`KICH_THUOC_SHEET`='$KICH_THUOC_SHEET',`GAP`='$GAP',`UPS`='$UPS',`ONE_TWO_SITE_PRINTING`='$ONE_TWO_SITE_PRINTING',`MACHINE`='$MACHINE',`FORMAT`='$FORMAT',`LOAI_VAT_TU`='$LOAI_VAT_TU',`STANDARD_SPEED_INCH`='$STANDARD_SPEED_INCH',`STANDARD_SPEED_PCS`='$STANDARD_SPEED_PCS',`CUTTER`='$CUTTER',`NHOM`='$NHOM',`MATERIAL_UOM`='$MATERIAL_UOM',`SECURITY`='$SECURITY',`FG_IPPS`='$FG_IPPS',`PCS_SET`='$PCS_SET',`CHIEU_IN_NHAN_THUC_TE`='$CHIEU_IN_NHAN_THUC_TE',`MATERIAL_CODE_2`='$MATERIAL_CODE_2',`MATERIAL_DES_2`='$MATERIAL_DES_2',`MATERIAL_UOM_2`='$MATERIAL_UOM_2',`RIBBON_CODE_2`='$RIBBON_CODE_2',`RIBBON_DES_2`='$RIBBON_DES_2',`LAYOUT_PREPRESS`='$LAYOUT_PREPRESS',`REMARK_1_ITEM`='$REMARK_1_ITEM',`REMARK_2_SHIPPING`='$REMARK_2_SHIPPING',`REMARK_3_PACKING`='$REMARK_3_PACKING',`REMARK_4_SAN_XUAT`='$REMARK_4_SAN_XUAT',`GHI_CHU`='$GHI_CHU',`BASE_ROLL`='$BASE_ROLL',`RIBBON_MT_KIT`='$RIBBON_MT_KIT',`CHI_TIET_KIT`='$CHI_TIET_KIT',`COLOR_BY_SIZE`='$COLOR_BY_SIZE',`UPDATED_BY`='$UPDATED_BY',`CREATED_DATE_TIME`=now() WHERE ID='$idUA'";
					}elseif($print_type=='request'){
						$sql = "UPDATE `$table_name` SET `GLID`='$GLID',`RBO`='$RBO',`CUSTOMER_NAME`='$CUSTOMER_NAME',`NOTE`='$NOTE',`DATE`='$DATE',`REQUEST_FROM`='$REQUEST_FROM',`APPROVED_BY`='$APPROVED_BY',`UPDATED_BY`='$UPDATED_BY',`CREATED_DATE_TIME`=now() where ID='$idUA'";
					}
					//echo $sql;die;
					$check_1 = $dbMi_138->query($sql);
				}
				//echo $sql;die;
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
					echo json_encode($response);die;
				}
			}
			
		}
    }
    echo json_encode($response);die;
}
?>