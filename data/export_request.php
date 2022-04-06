<?php	
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	//Nhúng file PHPExcel
	require_once ("../Database.php");
	require_once ("../Module/PHPExcel.php");
	// CALL QUERY
	$sql = "SELECT * FROM special_request";	
	$rowsResult = MiQuery($sql, $dbMi_138);
	if(count($rowsResult)>0){ 
		foreach ($rowsResult as $row){
			$GLID = $row['GLID'];
			$RBO = $row['RBO'];
			$CUSTOMER_NAME = $row['CUSTOMER_NAME'];
			$NOTE = $row['NOTE'];
			$DATE = $row['DATE'];
			$REQUEST_FROM = $row['REQUEST_FROM'];
			$APPROVED_BY = $row['APPROVED_BY'];
			$data[]=[
				$GLID,$RBO,$CUSTOMER_NAME,$NOTE,$DATE,$REQUEST_FROM,$APPROVED_BY
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
	$excel->getActiveSheet()->setCellValue('A1', 'GILD');
	$excel->getActiveSheet()->setCellValue('B1', 'RBO');
	$excel->getActiveSheet()->setCellValue('C1', 'Tên Khách hàng');
	$excel->getActiveSheet()->setCellValue('D1', 'Ghi chú');
	$excel->getActiveSheet()->setCellValue('E1', 'Ngày bắt đầu thực hiện');
	$excel->getActiveSheet()->setCellValue('F1', 'Yêu cầu từ');
	$excel->getActiveSheet()->setCellValue('G1', 'Approved bởi');
	// thực hiện thêm dữ liệu vào từng ô bằng vòng lặp
	// dòng bắt đầu = 2
	$numRow = 2;
	foreach ($data as $row) {
		$excel->getActiveSheet()->setCellValue('A' . $numRow, $row[0]);
		$excel->getActiveSheet()->setCellValue('B' . $numRow, $row[1]);
		$excel->getActiveSheet()->setCellValue('C' . $numRow, $row[2]);
		$excel->getActiveSheet()->setCellValue('D' . $numRow, $row[3]);
		$excel->getActiveSheet()->setCellValue('E' . $numRow, $row[4]);
		$excel->getActiveSheet()->setCellValue('F' . $numRow, $row[5]);
		$excel->getActiveSheet()->setCellValue('G' . $numRow, $row[6]);
		$numRow++;
	}
	// Khởi tạo đối tượng PHPExcel_IOFactory để thực hiện ghi file
	// ở đây mình lưu file dưới dạng excel2007
	$filename = "special_request_".date("d_m_Y__H_i_s");
	header('Content-type: application/vnd.ms-excel;charset=utf-8');	
	header('Content-Encoding: UTF-8');
	header("Cache-Control: no-store, no-cache");
	header("Content-Disposition: attachment; filename=$filename.xls");
	PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save('php://output');
?>
