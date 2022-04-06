<?php	
	//ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	
	ini_set('max_execution_time',3000);  // 
	ini_set('memory_limit', '512M');

	date_default_timezone_set('Asia/Ho_Chi_Minh');
	
	require_once "../Database.php";
	
	//Nhúng file PHPExcel
	
	require_once "../Module/PHPExcel.php";
	// CALL QUERY
	$sql = "SELECT * FROM master_bom";	
	$rowsResult = MiQuery($sql, $dbMi_138);
	if(count($rowsResult)>0){ 
		foreach ($rowsResult as $row){
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
			$MATERIAL_UOM_2 = $row['MATERIAL_UOM_2'];
			$RIBBON_CODE_2 = $row['RIBBON_CODE_2'];
			$RIBBON_DES_2 = $row['RIBBON_DES_2'];
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
			$CREATED_DATE_TIME = $row['CREATED_DATE_TIME'];
			$data[]=[
				$INTERNAL_ITEM,$ITEM_DES,$RBO,$ORDERED_ITEM,$MATERIAL_CODE,$MATERIAL_DES,$RIBBON_CODE,$RIBBON_DES,$CHIEU_DAI,$CHIEU_RONG,$KICH_THUOC_SHEET,$GAP,$UPS,$ONE_TWO_SITE_PRINTING,$MACHINE,$FORMAT,$LOAI_VAT_TU,$STANDARD_SPEED_INCH,$STANDARD_SPEED_PCS,$CUTTER,$NHOM,$MATERIAL_UOM,$SECURITY,$FG_IPPS,$PCS_SET,$CHIEU_IN_NHAN_THUC_TE,$MATERIAL_CODE_2,$MATERIAL_DES_2,$MATERIAL_UOM_2,$RIBBON_CODE_2,$RIBBON_DES_2,$LAYOUT_PREPRESS,$REMARK_1_ITEM,$REMARK_2_SHIPPING,$REMARK_3_PACKING,$REMARK_4_SAN_XUAT,$GHI_CHU,$BASE_ROLL,$RIBBON_MT_KIT,$CHI_TIET_KIT,$COLOR_BY_SIZE,$UPDATED_BY,$CREATED_DATE_TIME
			];
		}
	}
	//Khởi tạo đối tượng
	$excel = new PHPExcel();
	//Chọn trang cần ghi (là số từ 0->n)
	$excel->setActiveSheetIndex(0);
	//Tạo tiêu đề cho trang. (có thể không cần)
	//$excel->getActiveSheet()->setTitle('demo ghi dữ liệu');

	//Xét chiều rộng cho từng, nếu muốn set height thì dùng setRowHeight()
	//$excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	//$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	//$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);

	//Xét in đậm cho khoảng cột
	//$excel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
	//Tạo tiêu đề cho từng cột
	//Vị trí có dạng như sau:
	/**
	 * |A1|B1|C1|..|n1|
	 * |A2|B2|C2|..|n1|
	 * |..|..|..|..|..|
	 * |An|Bn|Cn|..|nn|
	 */
	$excel->getActiveSheet()->setCellValue('A1', 'Internal Item');
	$excel->getActiveSheet()->setCellValue('B1', 'Item Decription');
	$excel->getActiveSheet()->setCellValue('C1', 'RBO');
	$excel->getActiveSheet()->setCellValue('D1', 'Ordered Item');
	$excel->getActiveSheet()->setCellValue('E1', 'Material');
	$excel->getActiveSheet()->setCellValue('F1', 'Material Des.');
	$excel->getActiveSheet()->setCellValue('G1', 'Ribbon');
	$excel->getActiveSheet()->setCellValue('H1', 'Ribbon Des.');
	$excel->getActiveSheet()->setCellValue('I1', 'Chieu Dai');
	$excel->getActiveSheet()->setCellValue('J1', 'Chieu Rong');
	$excel->getActiveSheet()->setCellValue('K1', 'Kích thước sheet');
	$excel->getActiveSheet()->setCellValue('L1', 'Gap');
	$excel->getActiveSheet()->setCellValue('M1', 'Ups');
	$excel->getActiveSheet()->setCellValue('N1', '1 or 2 site printing');
	$excel->getActiveSheet()->setCellValue('O1', 'Machine');
	$excel->getActiveSheet()->setCellValue('P1', 'Format');
	$excel->getActiveSheet()->setCellValue('Q1', 'Loại vật tư');
	$excel->getActiveSheet()->setCellValue('R1', 'Standard Speed (inch / s)');
	$excel->getActiveSheet()->setCellValue('S1', 'Standard Speed (pcs[sheet]/hour)');
	$excel->getActiveSheet()->setCellValue('T1', 'Cutter');
	$excel->getActiveSheet()->setCellValue('U1', 'Nhóm');
	$excel->getActiveSheet()->setCellValue('V1', 'Material UOM');
	$excel->getActiveSheet()->setCellValue('W1', 'Security');
	$excel->getActiveSheet()->setCellValue('X1', 'FG/IPPS');
	$excel->getActiveSheet()->setCellValue('Y1', 'Pcs/set');
	$excel->getActiveSheet()->setCellValue('Z1', 'Chiều in nhãn thực tế');
	$excel->getActiveSheet()->setCellValue('AA1', 'Material 2');
	$excel->getActiveSheet()->setCellValue('AB1', 'Material 2 Des.');
	$excel->getActiveSheet()->setCellValue('AC1', 'Material 2 UOM.');
	$excel->getActiveSheet()->setCellValue('AD1', 'Ribbon 2');
	$excel->getActiveSheet()->setCellValue('AE1', 'Ribbon 2 Des.');
	$excel->getActiveSheet()->setCellValue('AF1', 'Layout need be done by Prepress');
	$excel->getActiveSheet()->setCellValue('AG1', 'Remark 1 (cố định theo item)');
	$excel->getActiveSheet()->setCellValue('AH1', 'Remark 2 oracle (shipping intruction)');
	$excel->getActiveSheet()->setCellValue('AI1', 'Remark 3 oracle (packing intruction)');
	$excel->getActiveSheet()->setCellValue('AJ1', 'Remark 4 (Remark data từ SX)');
	$excel->getActiveSheet()->setCellValue('AK1', 'Ghi chú');
	$excel->getActiveSheet()->setCellValue('AL1', 'Baserol-pcs/ KIT');
	$excel->getActiveSheet()->setCellValue('AM1', 'Ribbon-MT/KIT');
	$excel->getActiveSheet()->setCellValue('AN1', 'Chi tiet KIT');
	$excel->getActiveSheet()->setCellValue('AO1', 'COLOR BY SIZE');
	$excel->getActiveSheet()->setCellValue('AP1', 'UPDATED BY');
	$excel->getActiveSheet()->setCellValue('AQ1', 'CREATED TIME');
	// thực hiện thêm dữ liệu vào từng ô bằng vòng lặp
	// dòng bắt đầu = 2
	$numRow = 2;
	foreach ($data as $row){
		$excel->getActiveSheet()->setCellValue('A' . $numRow, $row[0]);
		$excel->getActiveSheet()->setCellValue('B' . $numRow, $row[1]);
		$excel->getActiveSheet()->setCellValue('C' . $numRow, $row[2]);
		$excel->getActiveSheet()->setCellValue('D' . $numRow, $row[3]);
		$excel->getActiveSheet()->setCellValue('E' . $numRow, $row[4]);
		$excel->getActiveSheet()->setCellValue('F' . $numRow, $row[5]);
		$excel->getActiveSheet()->setCellValue('G' . $numRow, $row[6]);
		$excel->getActiveSheet()->setCellValue('H' . $numRow, $row[7]);
		$excel->getActiveSheet()->setCellValue('I' . $numRow, $row[8]);
		$excel->getActiveSheet()->setCellValue('J' . $numRow, $row[9]);
		$excel->getActiveSheet()->setCellValue('K' . $numRow, $row[10]);
		$excel->getActiveSheet()->setCellValue('L' . $numRow, $row[11]);
		$excel->getActiveSheet()->setCellValue('M' . $numRow, $row[12]);
		$excel->getActiveSheet()->setCellValue('N' . $numRow, $row[13]);
		$excel->getActiveSheet()->setCellValue('O' . $numRow, $row[14]);
		$excel->getActiveSheet()->setCellValue('P' . $numRow, $row[15]);
		$excel->getActiveSheet()->setCellValue('Q' . $numRow, $row[16]);
		$excel->getActiveSheet()->setCellValue('R' . $numRow, $row[17]);
		$excel->getActiveSheet()->setCellValue('S' . $numRow, $row[18]);
		$excel->getActiveSheet()->setCellValue('T' . $numRow, $row[19]);
		$excel->getActiveSheet()->setCellValue('U' . $numRow, $row[20]);
		$excel->getActiveSheet()->setCellValue('V' . $numRow, $row[21]);
		$excel->getActiveSheet()->setCellValue('W' . $numRow, $row[22]);
		$excel->getActiveSheet()->setCellValue('X' . $numRow, $row[23]);
		$excel->getActiveSheet()->setCellValue('Y' . $numRow, $row[24]);
		$excel->getActiveSheet()->setCellValue('Z' . $numRow, $row[25]);
		$excel->getActiveSheet()->setCellValue('AA' . $numRow, $row[26]);
		$excel->getActiveSheet()->setCellValue('AB' . $numRow, $row[27]);
		$excel->getActiveSheet()->setCellValue('AC' . $numRow, $row[28]);
		$excel->getActiveSheet()->setCellValue('AD' . $numRow, $row[29]);
		$excel->getActiveSheet()->setCellValue('AE' . $numRow, $row[30]);
		$excel->getActiveSheet()->setCellValue('AF' . $numRow, $row[31]);
		$excel->getActiveSheet()->setCellValue('AG' . $numRow, $row[32]);
		$excel->getActiveSheet()->setCellValue('AH' . $numRow, $row[33]);
		$excel->getActiveSheet()->setCellValue('AI' . $numRow, $row[34]);
		$excel->getActiveSheet()->setCellValue('AJ' . $numRow, $row[35]);
		$excel->getActiveSheet()->setCellValue('AK' . $numRow, $row[36]);
		$excel->getActiveSheet()->setCellValue('AL' . $numRow, $row[37]);
		$excel->getActiveSheet()->setCellValue('AM' . $numRow, $row[38]);
		$excel->getActiveSheet()->setCellValue('AN' . $numRow, $row[39]);
		$excel->getActiveSheet()->setCellValue('AO' . $numRow, $row[40]);
		$excel->getActiveSheet()->setCellValue('AP' . $numRow, $row[41]);
		$excel->getActiveSheet()->setCellValue('AQ' . $numRow, $row[42]);
		$numRow++;
	}

	ob_clean();
	// Khởi tạo đối tượng PHPExcel_IOFactory để thực hiện ghi file
	// ở đây mình lưu file dưới dạng excel2007
	$filename = "master_bom_".date("d_m_Y__H_i_s");
	header('Content-type: application/vnd.ms-excel;charset=utf-8');	
	header('Content-Encoding: UTF-8');
	header("Cache-Control: no-store, no-cache");
	header("Content-Disposition: attachment; filename=$filename.xlsx");
	PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save('php://output');
?>
