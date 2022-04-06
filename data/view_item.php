<?php   
require_once ("../Database.php");
$script = basename($_SERVER['PHP_SELF']);
$urlRoot = str_replace($script,'',$_SERVER['PHP_SELF']);
$urlRoot = str_replace('data/','',$urlRoot);
header("Content-type:text/xml");//set content type and xml tag
echo "<?xml version=\"1.0\"?>";
$fields = '*';
// to do process so kho if(type_worst_vertical = 100-SB1) 10,5
$print_type=$_GET['print_type'];
if($print_type=='master'){
	$sql = "SELECT $fields FROM master_bom";
}elseif($print_type=='request'){
	$sql = "SELECT $fields FROM special_request";
}
// echo $sql;      die;  
$rowsResult = MiQuery($sql, $dbMi_138);
/*
echo "<pre>";
print_r($rowsResult);die;
*/
if(count($rowsResult)>0){ 
	echo("<rows>");
	if(!empty($rowsResult)){ 
		$cellStart = "<cell><![CDATA[";
        $cellEnd = "]]></cell>";
		foreach ($rowsResult as $row){
			$ID = $row['ID'];
			if($print_type=='master')
			{
				$INTERNAL_ITEM = $row['INTERNAL_ITEM'];
				$ITEM_DES = $row['ITEM_DES'];
				$RBO = $row['RBO'];
				$ORDERED_ITEM = $row['ORDERED_ITEM'];
				$MATERIAL_CODE = $row['MATERIAL_CODE'];
				$MATERIAL_DES = $row['MATERIAL_DES'];
				$RIBBON_CODE = $row['RIBBON_CODE'];
				$RIBBON_DES = $row['RIBBON_DES'];
				$CHIEU_DAI = $row['CHIEU_DAI'];
				$CHIEU_RONG = $row['CHIEU_RONG'];
				$KICH_THUOC_SHEET = $row['KICH_THUOC_SHEET'];
				$GAP = $row['GAP'];
				$UPS = $row['UPS'];
				$ONE_TWO_SITE_PRINTING = $row['ONE_TWO_SITE_PRINTING'];
				$MACHINE = $row['MACHINE'];
				$FORMAT = $row['FORMAT'];
				$LOAI_VAT_TU = $row['LOAI_VAT_TU'];
				$STANDARD_SPEED_INCH = $row['STANDARD_SPEED_INCH'];
				$STANDARD_SPEED_PCS = $row['STANDARD_SPEED_PCS'];
				$CUTTER = $row['CUTTER'];
				$NHOM = $row['NHOM'];
				$MATERIAL_UOM = $row['MATERIAL_UOM'];
				$SECURITY = $row['SECURITY'];
				$FG_IPPS = $row['FG_IPPS'];
				$PCS_SET = $row['PCS_SET'];
				$CHIEU_IN_NHAN_THUC_TE = $row['CHIEU_IN_NHAN_THUC_TE'];
				$MATERIAL_CODE_2 = $row['MATERIAL_CODE_2'];
				$MATERIAL_DES_2 = $row['MATERIAL_DES_2'];
				$RIBBON_CODE_2 = $row['RIBBON_CODE_2'];
				$RIBBON_DES_2 = $row['RIBBON_DES_2'];
				$MATERIAL_UOM_2 = $row['MATERIAL_UOM_2'];
				$LAYOUT_PREPRESS = $row['LAYOUT_PREPRESS'];
				$REMARK_1_ITEM = $row['REMARK_1_ITEM'];			
				$REMARK_2_SHIPPING = $row['REMARK_2_SHIPPING'];			
				$REMARK_3_PACKING = $row['REMARK_3_PACKING'];			
				$REMARK_4_SAN_XUAT = $row['REMARK_4_SAN_XUAT'];			
				$GHI_CHU = $row['GHI_CHU'];			
				$BASE_ROLL = $row['BASE_ROLL'];			
				$RIBBON_MT_KIT = $row['RIBBON_MT_KIT'];			
				$CHI_TIET_KIT = $row['CHI_TIET_KIT'];			
				$COLOR_BY_SIZE = $row['COLOR_BY_SIZE'];		
				$UPDATED_BY = $row['UPDATED_BY'];		
				$CREATED_DATE_TIME = date('d-M-y H:i:s',strtotime($row['CREATED_DATE_TIME']));		
			}elseif($print_type=='request'){
				$GLID = $row['GLID'];
				$RBO = $row['RBO'];
				$CUSTOMER_NAME = $row['CUSTOMER_NAME'];
				$NOTE = $row['NOTE'];
				$DATE = $row['DATE'];
				$REQUEST_FROM = $row['REQUEST_FROM'];
				$APPROVED_BY = $row['APPROVED_BY'];
				$UPDATED_BY = $row['UPDATED_BY'];
				$CREATED_DATE_TIME = date('d-M-y H:i:s',strtotime($row['CREATED_DATE_TIME']));
			}
			echo("<row id='".$ID."'>");
				echo $cellStart;  // LENGTH
					echo(0);  //value for product name                 
				echo $cellEnd;
				if($print_type=='master')
				{
					echo($cellStart);  // LENGTH
						echo($INTERNAL_ITEM);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($ITEM_DES);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($RBO);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($ORDERED_ITEM);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($MATERIAL_CODE);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($MATERIAL_DES);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($RIBBON_CODE);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($RIBBON_DES);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($CHIEU_DAI);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($CHIEU_RONG);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($KICH_THUOC_SHEET);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($GAP);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($UPS);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($ONE_TWO_SITE_PRINTING);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($MACHINE);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($FORMAT);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($LOAI_VAT_TU);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($STANDARD_SPEED_INCH);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($STANDARD_SPEED_PCS);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($CUTTER);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($NHOM);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($MATERIAL_UOM);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($SECURITY);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($FG_IPPS);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($PCS_SET);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($CHIEU_IN_NHAN_THUC_TE);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($MATERIAL_CODE_2);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($MATERIAL_DES_2);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($MATERIAL_UOM_2);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($RIBBON_CODE_2);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($RIBBON_DES_2);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($LAYOUT_PREPRESS);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($REMARK_1_ITEM);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($REMARK_2_SHIPPING);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($REMARK_3_PACKING);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($REMARK_4_SAN_XUAT);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($GHI_CHU);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($BASE_ROLL);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($RIBBON_MT_KIT);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($CHI_TIET_KIT);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($COLOR_BY_SIZE);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($UPDATED_BY);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($CREATED_DATE_TIME);  //value for product name                 
					echo($cellEnd);
				}elseif($print_type=='request'){
					echo($cellStart);  // LENGTH
						echo($GLID);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($RBO);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($CUSTOMER_NAME);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($NOTE);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($DATE);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($REQUEST_FROM);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($APPROVED_BY);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($UPDATED_BY);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($CREATED_DATE_TIME);  //value for product name                 
					echo($cellEnd);					
				}
			echo("</row>");
		}
		// add 10 
		for($i=1;$i<=20;$i++){
			$ID = 'new_id_'.$i;
			if($print_type=='master')
			{
				$INTERNAL_ITEM = '';
				$ITEM_DES = '';
				$RBO = '';
				$ORDERED_ITEM = '';
				$MATERIAL_CODE = '';
				$MATERIAL_DES = '';
				$RIBBON_CODE = '';
				$RIBBON_DES = '';
				$CHIEU_DAI = '';
				$CHIEU_RONG = '';
				$KICH_THUOC_SHEET = '';
				$GAP = '';
				$UPS = '';
				$ONE_TWO_SITE_PRINTING = '';
				$MACHINE = '';
				$FORMAT = '';
				$LOAI_VAT_TU = '';
				$STANDARD_SPEED_INCH = '';
				$STANDARD_SPEED_PCS = '';
				$CUTTER = '';
				$NHOM = '';
				$MATERIAL_UOM = '';
				$SECURITY = '';
				$FG_IPPS = '';
				$PCS_SET = '';
				$CHIEU_IN_NHAN_THUC_TE = '';
				$MATERIAL_CODE_2 = '';
				$MATERIAL_DES_2 = '';
				$MATERIAL_UOM_2 = '';
				$RIBBON_CODE_2 = '';
				$RIBBON_DES_2 = '';
				$LAYOUT_PREPRESS = '';
				$REMARK_1_ITEM = '';
				$REMARK_2_SHIPPING = '';
				$REMARK_3_PACKING = '';
				$REMARK_4_SAN_XUAT = '';
				$GHI_CHU = '';
				$BASE_ROLL = '';
				$RIBBON_MT_KIT = '';
				$CHI_TIET_KIT = '';
				$COLOR_BY_SIZE = '';
			}elseif($print_type=='request'){
				$GLID = '';
				$RBO = '';
				$CUSTOMER_NAME = '';
				$NOTE = '';
				$DATE = '';
				$REQUEST_FROM = '';
				$APPROVED_BY = '';
			}
			echo("<row id='".$ID."'>");
				echo $cellStart;  // LENGTH
					echo(0);  //value for product name                 
				echo $cellEnd;
				if($print_type=='master')
				{
					echo($cellStart);  // LENGTH
						echo($INTERNAL_ITEM);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($ITEM_DES);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($RBO);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($ORDERED_ITEM);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($MATERIAL_CODE);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($MATERIAL_DES);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($RIBBON_CODE);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($RIBBON_DES);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($CHIEU_DAI);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($CHIEU_RONG);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($KICH_THUOC_SHEET);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($GAP);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($UPS);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($ONE_TWO_SITE_PRINTING);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($MACHINE);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($FORMAT);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($LOAI_VAT_TU);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($STANDARD_SPEED_INCH);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($STANDARD_SPEED_PCS);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($CUTTER);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($NHOM);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($MATERIAL_UOM);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($SECURITY);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($FG_IPPS);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($PCS_SET);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($CHIEU_IN_NHAN_THUC_TE);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($MATERIAL_CODE_2);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($MATERIAL_DES_2);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($MATERIAL_UOM_2);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($RIBBON_CODE_2);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($RIBBON_DES_2);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($LAYOUT_PREPRESS);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($REMARK_1_ITEM);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($REMARK_2_SHIPPING);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($REMARK_3_PACKING);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($REMARK_4_SAN_XUAT);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($GHI_CHU);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($BASE_ROLL);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($RIBBON_MT_KIT);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($CHI_TIET_KIT);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($COLOR_BY_SIZE);  //value for product name                 
					echo($cellEnd);
				}elseif($print_type=='request'){
					echo($cellStart);  // LENGTH
						echo($GLID);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($RBO);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($CUSTOMER_NAME);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($NOTE);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($DATE);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($REQUEST_FROM);  //value for product name                 
					echo($cellEnd);
					echo($cellStart);  // LENGTH
						echo($APPROVED_BY);  //value for product name                 
					echo($cellEnd);
				}
			echo("</row>");
		}
	}
	echo("</rows>");
}else{
	echo("<rows></rows>");
}
?>