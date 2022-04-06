<?php
set_time_limit(6000); date_default_timezone_set('Asia/Ho_Chi_Minh');
require("../Database.php");
require_once('../spreadsheet/php-excel-reader/excel_reader2.php');
require_once('../spreadsheet/SpreadsheetReader.php');

$UPDATED_BY = isset($_COOKIE["VNRISIntranet"]) ? $_COOKIE["VNRISIntranet"] : "";

if (isset($_POST["submit"])) {

    $allowedFileType = ['application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

    if (in_array($_FILES["file"]["type"], $allowedFileType)) {

        // $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/minhvo/thmf_test/Excel/' . $file_name;
        $file_name = 'Master_file_' . $UPDATED_BY . '_' . date('Y-m-d_H-i-s') . '.xlsx';
        $targetPath = '../Excel/' . $file_name;
        
        // hàm move_uploaded_file k sử dụng được (có thể do bị hạn chế quyền của thư mục tmp)
        if (copy($_FILES['file']['tmp_name'], $targetPath)) {
            // echo "Đã upload file : $targetPath <br />\n";
        } else {
            $type = "Error";
            $message = "Problem in Importing Excel Data";
        }
        
        $Reader = new SpreadsheetReader($targetPath);
        $sheetCount = count($Reader->sheets());
        for ($i = 1; $i <= $sheetCount; $i++) {
            $Reader->ChangeSheet($i);

            foreach ($Reader as $Row) {
                $INTERNAL_ITEM = "";
                if (isset($Row[0])) {
                    $INTERNAL_ITEM = mysqli_real_escape_string($dbMi_138, $Row[0]);
                }
                $ITEM_DES = "";
                if (isset($Row[1])) {
                    $ITEM_DES = mysqli_real_escape_string($dbMi_138, $Row[1]);
                }
                $RBO = "";
                if (isset($Row[2])) {
                    $RBO = mysqli_real_escape_string($dbMi_138, $Row[2]);
                }
                $ORDERED_ITEM = "";
                if (isset($Row[3])) {
                    $ORDERED_ITEM = mysqli_real_escape_string($dbMi_138, $Row[3]);
                }
                $MATERIAL_CODE = "";
                if (isset($Row[4])) {
                    $MATERIAL_CODE = mysqli_real_escape_string($dbMi_138, $Row[4]);
                }
                $MATERIAL_DES = "";
                if (isset($Row[5])) {
                    $MATERIAL_DES = mysqli_real_escape_string($dbMi_138, $Row[5]);
                }
                $RIBBON_CODE = "";
                if (isset($Row[6])) {
                    $RIBBON_CODE = mysqli_real_escape_string($dbMi_138, $Row[6]);
                }
                $RIBBON_DES = "";
                if (isset($Row[7])) {
                    $RIBBON_DES = mysqli_real_escape_string($dbMi_138, $Row[7]);
                }
                $CHIEU_DAI = "";
                if (isset($Row[8])) {
                    $CHIEU_DAI = mysqli_real_escape_string($dbMi_138, $Row[8]);
                }
                $CHIEU_RONG = "";
                if (isset($Row[9])) {
                    $CHIEU_RONG = mysqli_real_escape_string($dbMi_138, $Row[9]);
                }

                $KICH_THUOC_SHEET = "";
                if (isset($Row[10])) {
                    $KICH_THUOC_SHEET = mysqli_real_escape_string($dbMi_138, $Row[10]);
                }
                $GAP = "";
                if (isset($Row[11])) {
                    $GAP = mysqli_real_escape_string($dbMi_138, $Row[11]);
                }
                $UPS = "";
                if (isset($Row[12])) {
                    $UPS = mysqli_real_escape_string($dbMi_138, $Row[12]);
                }
                $ONE_TWO_SITE_PRINTING = "";
                if (isset($Row[13])) {
                    $ONE_TWO_SITE_PRINTING = mysqli_real_escape_string($dbMi_138, $Row[13]);
                }
                $MACHINE = "";
                if (isset($Row[14])) {
                    $MACHINE = mysqli_real_escape_string($dbMi_138, $Row[14]);
                }
                $FORMAT = "";
                if (isset($Row[15])) {
                    $FORMAT = mysqli_real_escape_string($dbMi_138, $Row[15]);
                }
                $LOAI_VAT_TU = "";
                if (isset($Row[16])) {
                    $LOAI_VAT_TU = mysqli_real_escape_string($dbMi_138, $Row[16]);
                }
                $STANDARD_SPEED_INCH = "";
                if (isset($Row[17])) {
                    $STANDARD_SPEED_INCH = mysqli_real_escape_string($dbMi_138, $Row[17]);
                }
                $STANDARD_SPEED_PCS = "";
                if (isset($Row[18])) {
                    $STANDARD_SPEED_PCS = mysqli_real_escape_string($dbMi_138, $Row[18]);
                }
                $CUTTER = "";
                if (isset($Row[19])) {
                    $CUTTER = mysqli_real_escape_string($dbMi_138, $Row[19]);
                }

                $NHOM = "";
                if (isset($Row[20])) {
                    $NHOM = mysqli_real_escape_string($dbMi_138, $Row[20]);
                }
                $MATERIAL_UOM = "";
                if (isset($Row[21])) {
                    $MATERIAL_UOM = mysqli_real_escape_string($dbMi_138, $Row[21]);
                }
                $SECURITY = "";
                if (isset($Row[22])) {
                    $SECURITY = mysqli_real_escape_string($dbMi_138, $Row[22]);
                }
                $FG_IPPS = "";
                if (isset($Row[23])) {
                    $FG_IPPS = mysqli_real_escape_string($dbMi_138, $Row[23]);
                }
                $PCS_SET = "";
                if (isset($Row[24])) {
                    $PCS_SET = mysqli_real_escape_string($dbMi_138, $Row[24]);
                }
                $CHIEU_IN_NHAN_THUC_TE = "";
                if (isset($Row[25])) {
                    $CHIEU_IN_NHAN_THUC_TE = mysqli_real_escape_string($dbMi_138, $Row[25]);
                }
                $MATERIAL_CODE_2 = "";
                if (isset($Row[26])) {
                    $MATERIAL_CODE_2 = mysqli_real_escape_string($dbMi_138, $Row[26]);
                }
                $MATERIAL_DES_2 = "";
                if (isset($Row[27])) {
                    $MATERIAL_DES_2 = mysqli_real_escape_string($dbMi_138, $Row[27]);
                }
                $MATERIAL_UOM_2 = "";
                if (isset($Row[28])) {
                    $MATERIAL_UOM_2 = mysqli_real_escape_string($dbMi_138, $Row[28]);
                }
                $RIBBON_CODE_2 = "";
                if (isset($Row[29])) {
                    $RIBBON_CODE_2 = mysqli_real_escape_string($dbMi_138, $Row[29]);
                }

                $RIBBON_DES_2 = "";
                if (isset($Row[30])) {
                    $RIBBON_DES_2 = mysqli_real_escape_string($dbMi_138, $Row[30]);
                }
                $LAYOUT_PREPRESS = "";
                if (isset($Row[31])) {
                    $LAYOUT_PREPRESS = mysqli_real_escape_string($dbMi_138, $Row[31]);
                }
                $REMARK_1_ITEM = "";
                if (isset($Row[32])) {
                    $REMARK_1_ITEM = mysqli_real_escape_string($dbMi_138, $Row[32]);
                }
                $REMARK_2_SHIPPING = "";
                if (isset($Row[33])) {
                    $REMARK_2_SHIPPING = mysqli_real_escape_string($dbMi_138, $Row[33]);
                }
                $REMARK_3_PACKING = "";
                if (isset($Row[34])) {
                    $REMARK_3_PACKING = mysqli_real_escape_string($dbMi_138, $Row[34]);
                }
                $REMARK_4_SAN_XUAT = "";
                if (isset($Row[35])) {
                    $REMARK_4_SAN_XUAT = mysqli_real_escape_string($dbMi_138, $Row[35]);
                }
                $GHI_CHU = "";
                if (isset($Row[36])) {
                    $GHI_CHU = mysqli_real_escape_string($dbMi_138, $Row[36]);
                }
                $BASE_ROLL = "";
                if (isset($Row[37])) {
                    $BASE_ROLL = mysqli_real_escape_string($dbMi_138, $Row[37]);
                }
                $RIBBON_MT_KIT = "";
                if (isset($Row[38])) {
                    $RIBBON_MT_KIT = mysqli_real_escape_string($dbMi_138, $Row[38]);
                }
                $CHI_TIET_KIT = "";
                if (isset($Row[39])) {
                    $CHI_TIET_KIT = mysqli_real_escape_string($dbMi_138, $Row[39]);
                }

                $COLOR_BY_SIZE = "";
                if (isset($Row[40])) {
                    $COLOR_BY_SIZE = mysqli_real_escape_string($dbMi_138, $Row[40]);
                }

                // Kiểm tra dữ liệu tồn tại hay chưa, dựa vào internal_item, material_code, nếu tồn tại thì update
                // Chưa tồn tại thì thêm mới
                if (!empty($INTERNAL_ITEM)) {
                    if (strpos(strtoupper($INTERNAL_ITEM), 'INTERNAL') !== false) continue;

                    $query_check = "SELECT INTERNAL_ITEM FROM `master_bom` WHERE INTERNAL_ITEM = '" . $INTERNAL_ITEM . "' ";
                    $result_check = mysqli_query($dbMi_138, $query_check);
                    if (mysqli_num_rows($result_check) > 0) {
                        $query = "UPDATE `master_bom` 
                        SET  `ITEM_DES` = '" . $ITEM_DES . "', `RBO` = '" . $RBO . "', `ORDERED_ITEM` = '" . $ORDERED_ITEM . "', `MATERIAL_CODE` = '" . $MATERIAL_CODE . "', `MATERIAL_DES` = '" . $MATERIAL_DES . "', `RIBBON_CODE` = '" . $RIBBON_CODE . "',
                            `RIBBON_DES` = '" . $RIBBON_DES . "', `CHIEU_DAI` = '" . $CHIEU_DAI . "', `CHIEU_RONG` = '" . $CHIEU_RONG . "', `KICH_THUOC_SHEET` = '" . $KICH_THUOC_SHEET . "', `GAP` = '" . $GAP . "',
                            `UPS` = '" . $UPS . "', `ONE_TWO_SITE_PRINTING` = '" . $ONE_TWO_SITE_PRINTING . "', `MACHINE` = '" . $MACHINE . "', `FORMAT` = '" . $FORMAT . "', `LOAI_VAT_TU` = '" . $LOAI_VAT_TU . "',
                            `STANDARD_SPEED_INCH` = '" . $STANDARD_SPEED_INCH . "', `STANDARD_SPEED_PCS` = '" . $STANDARD_SPEED_PCS . "', `CUTTER` = '" . $CUTTER . "', `NHOM` = '" . $NHOM . "', `MATERIAL_UOM` = '" . $MATERIAL_UOM . "',
                            `SECURITY` = '" . $SECURITY . "', `FG_IPPS` = '" . $FG_IPPS . "', `PCS_SET` = '" . $PCS_SET . "', `CHIEU_IN_NHAN_THUC_TE` = '" . $CHIEU_IN_NHAN_THUC_TE . "', `MATERIAL_CODE_2` = '" . $MATERIAL_CODE_2 . "',
                            `MATERIAL_DES_2` = '" . $MATERIAL_DES_2 . "', `MATERIAL_DES_2` = '" . $MATERIAL_DES_2 . "', `RIBBON_CODE_2` = '" . $RIBBON_CODE_2 . "', `RIBBON_DES_2` = '" . $RIBBON_DES_2 . "', `LAYOUT_PREPRESS` = '" . $LAYOUT_PREPRESS . "',

                            `REMARK_1_ITEM` = '" . $REMARK_1_ITEM . "', `REMARK_2_SHIPPING` = '" . $REMARK_2_SHIPPING . "', `REMARK_3_PACKING` = '" . $REMARK_3_PACKING . "', `REMARK_4_SAN_XUAT` = '" . $REMARK_4_SAN_XUAT . "', `GHI_CHU` = '" . $GHI_CHU . "',
                            `BASE_ROLL` = '" . $BASE_ROLL . "', `RIBBON_MT_KIT` = '" . $RIBBON_MT_KIT . "', `CHI_TIET_KIT` = '" . $CHI_TIET_KIT . "', `COLOR_BY_SIZE` = '" . $COLOR_BY_SIZE . "', `UPDATED_BY` = '" . $UPDATED_BY . "', `CREATED_DATE_TIME` = NOW()

                        WHERE INTERNAL_ITEM = '" . $INTERNAL_ITEM . "'  ";
                    } else {
                        $query = "INSERT INTO `master_bom` 
                        (   `INTERNAL_ITEM`, `ITEM_DES`, `RBO`, `ORDERED_ITEM`, `MATERIAL_CODE`, `MATERIAL_DES`, `RIBBON_CODE`, `RIBBON_DES`, `CHIEU_DAI`, `CHIEU_RONG`,
                            `KICH_THUOC_SHEET`, `GAP`, `UPS`, `ONE_TWO_SITE_PRINTING`, `MACHINE`, `FORMAT`, `LOAI_VAT_TU`, `STANDARD_SPEED_INCH`, `STANDARD_SPEED_PCS`, `CUTTER`,
                            `NHOM`, `MATERIAL_UOM`, `SECURITY`, `FG_IPPS`, `PCS_SET`, `CHIEU_IN_NHAN_THUC_TE`, `MATERIAL_CODE_2`, `MATERIAL_DES_2`, `MATERIAL_UOM_2`, `RIBBON_CODE_2`,
                            `RIBBON_DES_2`, `LAYOUT_PREPRESS`, `REMARK_1_ITEM`, `REMARK_2_SHIPPING`, `REMARK_3_PACKING`, `REMARK_4_SAN_XUAT`, `GHI_CHU`, `BASE_ROLL`, `RIBBON_MT_KIT`, `CHI_TIET_KIT`,
                            `COLOR_BY_SIZE`, `UPDATED_BY`)

                        VALUES 
                        (
                            '" . $INTERNAL_ITEM . "', '" . $ITEM_DES . "', '" . $RBO . "', '" . $ORDERED_ITEM . "', '" . $MATERIAL_CODE . "', '" . $MATERIAL_DES . "', '" . $RIBBON_CODE . "', '" . $RIBBON_DES . "', '" . $CHIEU_DAI . "', '" . $CHIEU_RONG . "',
                            '" . $KICH_THUOC_SHEET . "', '" . $GAP . "', '" . $UPS . "', '" . $ONE_TWO_SITE_PRINTING . "', '" . $MACHINE . "', '" . $FORMAT . "', '" . $LOAI_VAT_TU . "', '" . $STANDARD_SPEED_INCH . "', '" . $STANDARD_SPEED_PCS . "', '" . $CUTTER . "',
                            '" . $NHOM . "', '" . $MATERIAL_UOM . "', '" . $SECURITY . "', '" . $FG_IPPS . "', '" . $PCS_SET . "', '" . $CHIEU_IN_NHAN_THUC_TE . "', '" . $MATERIAL_CODE_2 . "', '" . $MATERIAL_DES_2 . "', '" . $MATERIAL_UOM_2 . "', '" . $RIBBON_CODE_2 . "',
                            '" . $RIBBON_DES_2 . "', '" . $LAYOUT_PREPRESS . "', '" . $REMARK_1_ITEM . "', '" . $REMARK_2_SHIPPING . "', '" . $REMARK_3_PACKING . "', '" . $REMARK_4_SAN_XUAT . "', '" . $GHI_CHU . "', '" . $BASE_ROLL . "', '" . $RIBBON_MT_KIT . "', '" . $CHI_TIET_KIT . "',
                            '" . $COLOR_BY_SIZE . "', '" . $UPDATED_BY . "'
                        )";
                    }

                    $error_row = $i + 1;
                    //query
                    $result = mysqli_query($dbMi_138, $query);
                    if (!$result) break;
                } else {
                    $type = "Error";
                    $message = " Empty the " . $error_row . "th row Internal_item data";
                }
            } // for 

        } // for

        if ($result == true) {
            $type = "Success";
            $message = "Excel Data Imported into the Database";
        } else {
            $type = "Error";
            $message = "Problem in Importing Excel Data, the " . $error_row . "th row ";
        }
    } else {
        $type = "Error";
        $message = "Invalid File Type. Upload Excel File.";
    }
}

if (isset($message)) {
    $result = $type . '. ' . $message;
} else {
    $result = '';
}

?>
<script>
    var message = '<?php  echo $result; ?>';
    
    alert(message);
    window.location="../";
    
</script>
