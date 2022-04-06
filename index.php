<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once ("./Database.php");

function getUser() 
{
	$email = isset($_COOKIE["VNRISIntranet"]) ? trim($_COOKIE["VNRISIntranet"]) : "";
	return $email;
}

function planning_user_statistics($email, $program )
{
	if (!empty($email) ) {
		$table = 'planning_user_statistics';
		$ip = $_SERVER['REMOTE_ADDR'];

		$url = "http://" .$_SERVER["SERVER_ADDR"] .$_SERVER["REQUEST_URI"];

		$METADATA = "HTTP_COOKIE: " . $_SERVER["HTTP_COOKIE"]. "PATH: " .$_SERVER["PATH"]. "SERVER_ADDR" .$_SERVER["SERVER_ADDR"]. "SERVER_PORT" .$_SERVER["SERVER_PORT"]. "DOCUMENT_ROOT" .$_SERVER["DOCUMENT_ROOT"]. "SCRIPT_FILENAME" .$_SERVER["SCRIPT_FILENAME"];
		$METADATA = mysqli_real_escape_string(_conn("au_avery"), $METADATA);

		// update data
		$key = $email . $program;
		$updated = date('Y-m-d H:i:s');
		$check = MiQuery("SELECT `email` FROM $table WHERE CONCAT(`email`,`program`) = '$key';", _conn('au_avery') );
		if (!empty($check) ) {
			$sql = "UPDATE $table SET `ip` = '$ip', `url` = '$url', `METADATA` = '$METADATA', `updated` = '$updated'  WHERE `email` = '$email' AND `program` = '$program';";
		} else {
			// Thêm mới. Tự động nên không trả về kết quả
			$sql = "INSERT INTO $table (`email`, `program`, `ip`, `url`, `METADATA`, `updated`) VALUE ('$email', '$program', '$ip',  '$url', '$METADATA', '$updated');";
		}

		return MiNonQuery2( $sql,_conn("au_avery"));
		
	}
	
	
}

$email = getUser();


// check role
$rolesItem = ['duc.le','tuan.vi','quang.phan','tan.doan', 'duy.dang', 'son.tran'];
if(!empty($_COOKIE["VNRISIntranet"])){
	$user = $_COOKIE["VNRISIntranet"];
	if(!empty($user)&&in_array($user,$rolesItem)){
		$updateItem = 1;
	}else{
		$updateItem = 0;
	}
}else{
	$updateItem = 0;
}
// get print_type
if(empty($_COOKIE['print_type_thermal_mf'])){
	setcookie('print_type_thermal_mf','master', time() + (86400 * 365), "/"); // 86400 = 1 day
}
// get print_type
if(!empty($_COOKIE['print_type_thermal_mf'])){
	$print_type = $_COOKIE['print_type_thermal_mf'];
	if($print_type=='master'){
		$print_type_text = 'Master File';
	}elseif($print_type == 'request'){
		$print_type_text = 'Special Request';
	}
}else{
	$print_type ='master';
	$print_type_text = 'Master File';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>THERMAL MASTER FILE</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="google" content="notranslate" />
	<link rel="STYLESHEET" type="text/css" href="./dhtmlx/skins/skyblue/dhtmlx.css">
	<script src="./dhtmlx/codebase/dhtmlx.js" type="text/javascript"></script>
	<script src="./dhtmlx/codebase/Date.format.min.js" type="text/javascript"></script>
	<script src="./dhtmlx/js/jquery.min.js"></script>

<style>
    html, body {
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 0;
		font-family: "Source Sans Pro","Helvetica Neue",Helvetica;
		background-repeat: no-repeat;
		background-size: 100%;
    }
    .formShow input,.formShow select{ 
            font-size:12px !important; 
            font-weight:bold;
    }
    @media only screen and (max-width: 1600px) {
        
    }
	.dhxtoolbar_btn_pres .dhxtoolbar_text{
		font-weight:bold!important;
	}
	.cls_test .dhxform_label_align_left label{
		font-weight:bold!important;
	}

</style>
<script>
var updateItem = <?php echo $updateItem;?>;
var LayoutMain;
var MainMenu;
var ToolbarMain;
var RootPath = '<?php echo str_replace('index__.php','',$_SERVER['REQUEST_URI']);?>';  
var RootDataPath = RootPath+'data/';
var SoGridLoad = RootDataPath+'grid_so.php';
var print_type = getCookie('print_type_thermal_mf');
var check_gg = 0;
<?php

	if(!isset($_COOKIE["VNRISIntranet"])) {
        echo 'var HeaderTile = "<a style=\'color:blue;font-style:italic;padding-left:10px\'>Hi Guest | <a href=\"./module/login/index.php?URL=THMF\">Login</a></a>";var UserVNRIS = "";';
    } else {
        echo 'var HeaderTile = "<a style=\'color:blue;font-style:italic;padding-left:10px\'>Hi '.$_COOKIE["VNRISIntranet"].' | <a href=\"./module/login/Logout.php\">Logout</a></a>";var UserVNRIS = "'.$_COOKIE["VNRISIntranet"].'";';
    }
?>
	var window_width = window.innerWidth;
	function setCookie(cname,cvalue,exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires=" + d.toGMTString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	function getCookie(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return -1;
	}	
	// xxxx document.cookie = "auto_sample=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    function initLayout(){
        LayoutMain = new dhtmlXLayoutObject({
            parent: document.body,
            pattern: "2U",
            offsets: {
                top: 65
            },
            cells: [
                {id: "a", header: true, text: "<?php echo $print_type_text;?>", width: 1160}, 				
                {id: "b", header: true, text: "Detail"}, 				
            ]
        });
    }
    function initMenu(){
        MainMenu = new dhtmlXMenuObject({
				parent: "menuObj",
				icons_path: "./dhtmlx/common/imgs_Menu/",
				json: "/FileHome/Menu.json",
				top_text: HeaderTile
        });
    }
    function initToolbar(){		
        ToolbarMain = new dhtmlXToolbarObject({
            parent: "ToolbarBottom",
            icons_path: "./dhtmlx/common/imgs/",
            align: "left",
        });	
        // end 
        var opts = [['master', 'obj', 'Master File'],['request', 'obj', 'Special Request']];
		ToolbarMain.addText("", 1, "<a style='font-size:20pt;font-weight:bold'>Avery Dennison THERMAL</a>");
		ToolbarMain.addButton("spacer",2, "", "");
		ToolbarMain.addSpacer("spacer");
		ToolbarMain.addButtonSelect('select_print', 10, 'SHEET', opts, "combobox.png", null);
		if(print_type!==-1){
			var selectedPrintType = print_type;
			ToolbarMain.setListOptionSelected('select_print', selectedPrintType);
		}else{
			ToolbarMain.setListOptionSelected('select_print','master');
		}
		if(updateItem){			
			ToolbarMain.addButton("save_item",11, "Save Item", "save.gif");	
			ToolbarMain.addButton("save_form",12, "Save Form", "save.gif");						
			ToolbarMain.addButton("delete_item",13, "Delete Item", "save.gif");	
			ToolbarMain.addButton("import_item",14, "Import Item", "import.gif");
		}			
		ToolbarMain.addButton("export_item",15, "Export Item", "export.png");	
		/*
		if(print_type=='ready'||print_type=='inkjet'||print_type=='stock'){
			ToolbarMain.addButton("active_item",14, "Active Item", "save.gif");	
			ToolbarMain.addButton("no_active_item",15, "No Active Item", "save.gif");
		}
		*/
		ToolbarMain.attachEvent("onClick", function(name)
		{
			//console.log(name);
			if(name == "master"||name == "request"){
				setCookie('print_type_thermal_mf',name,365);
				ToolbarMain.setListOptionSelected('select_print', name);
				location.reload();
			}else if(name == "save_item"){
				saveItem();
			}else if(name == "save_form"){
				saveForm();
			}else if(name == "copy_item"){
				copyPasteItem();
			}else if(name == "delete_item"){
				deleteItem();
			}else if(name == "active_item"){
				activeItem();
			}else if(name == "no_active_item"){
				noActiveItem();
			}else if(name == "import_item"){
				//importItem();
				UploadExcel();
			}else if(name == "export_item"){
				if(print_type=='master'){
					var url_export = RootDataPath+'export_item.php';
				}else if(print_type=='request'){
					var url_export = RootDataPath+'export_request.php';
				}				
				document.location.href = url_export;
			}						
		});
    }

	var dhxWins;
	function UploadExcel() {
		if(!dhxWins){
            dhxWins= new dhtmlXWindows();// show window form to add length
        }

		var id = "WindowsDetail";
		var w = 400;	var h = 100;	var x = Number(($(window).width()-400)/2);	var y = Number(($(window).height()-50)/2);
		var Popup = dhxWins.createWindow(id, x, y, w, h);
		dhxWins.window(id).setText("Import data");


		Popup.attachHTMLString('<div style="width:500%;margin:20px ">' +
		'<form action="data/item_upload.php" enctype="multipart/form-data" method="post">' +
			'<input id="file" name="file" type="file"/>' +
			'<input name="submit" type="submit" value="Upload" />' +
		'</form></div></div>'); 
	}
	
	var dhxWinsItem;
	function importItem(){		
        if(!dhxWinsItem){
            dhxWinsItem= new dhtmlXWindows();// show window form to add length
        }
        if (!dhxWinsItem.isWindow("windowMachine")){
            // var win = myWins.createWindow(string id, int x, int y, int width, int height); // Creating New Window              
            windowMachine = dhxWinsItem.createWindow("windowMachine", 1523,65,395,160);
            windowMachine.setText("Window Import Master File");
            /*necessary to hide window instead of remove it*/
            windowMachine.attachEvent("onClose", function(win){
                if (win.getId() == "windowMachine") 
                    win.hide();
            });	
			if(print_type=='master'){
				var url_upload = "data/item_upload.php";
			}else if(print_type=='request'){				
				var url_upload = "data/request_upload.php";
			}
			formData = [
				{type: "fieldset", label: "Uploader", list:[
					{type: "upload", name: "myFiles", autoStart: true, inputWidth: 330, url: url_upload}
				]}
			];
			MachineForm = windowMachine.attachForm(formData, true);			
			MachineForm.attachEvent("onFileAdd",function(realName){
				// your code here
				dhxWinsItem.window("windowMachine").progressOn();
			});
			MachineForm.attachEvent('onUploadFail', function(fileName,extra){
				//console.log(extra.mess);
				alert(extra.mess);
				var myUploader = MachineForm.getUploader('myFiles');
				myUploader.clear();
				dhxWinsItem.window("windowMachine").progressOff();
			});
			MachineForm.attachEvent('onUploadFile', function(state,fileName,extra){
				//console.log(extra.mess);
				alert(extra.mess);
				dhxWinsItem.window("windowMachine").progressOff();
				location.reload();
			});
			
        }else{
            dhxWinsItem.window("windowMachine").show(); 
        } 
    }
	
	function activeItem(){
		var checkIDs = [];
		SoGrid.forEachRow(function(id){
			if(SoGrid.cells(id,0).getValue()==1){
				checkIDs.push(id);
			}
		});
		if(!checkIDs.length>0){
			alert("Vui lòng chọn dòng để ACTIVE");
			return false;
		}else{
			var url_delete = RootDataPath+'active_item.php';
			// get all checkbox
			$.ajax({
				url: url_delete,
				type: "POST",
				data: {data: JSON.stringify(checkIDs)},
				dataType: "json",
				beforeSend: function(x) {
					if (x && x.overrideMimeType) {
						x.overrideMimeType("application/j-son;charset=UTF-8");
					}
				},
				success: function(result) {
					if(result.status){
						alert('ACTIVE ITEM THÀNH CÔNG, WEBSITE CẦN RELOAD');
						location.reload();
						return false;
					}else{
						alert(result.mess);							
					}
				}
			});	
		}
	}
	
	function noActiveItem(){
		var checkIDs = [];
		SoGrid.forEachRow(function(id){
			if(SoGrid.cells(id,0).getValue()==1){
				checkIDs.push(id);
			}
		});
		if(!checkIDs.length>0){
			alert("Vui lòng chọn dòng để UN ACTIVE");
			return false;
		}else{
			var url_delete = RootDataPath+'un_active_item.php';
			// get all checkbox
			$.ajax({
				url: url_delete,
				type: "POST",
				data: {data: JSON.stringify(checkIDs)},
				dataType: "json",
				beforeSend: function(x) {
					if (x && x.overrideMimeType) {
						x.overrideMimeType("application/j-son;charset=UTF-8");
					}
				},
				success: function(result) {
					if(result.status){
						alert('UN ACTIVE ITEM THÀNH CÔNG, WEBSITE CẦN RELOAD');
						location.reload();
						return false;
					}else{
						alert(result.mess);							
					}
				}
			});	
		}
	}
	
	var checked_ids = [];
	function copyPasteItem(){
		if(!checked_ids.length>0){
			alert('VUI LÒNG CHỌN ITEM ĐỂ COPY!!!');
			return false;
		}		
		var count_grid = SoGrid.getRowsNum();
		for(var i=0;i<checked_ids.length;i++){
			var ITEM_ID = checked_ids[i];
			// get data
			// count 
			var index = 0;
			for(var j=0;j<count_grid;j++){
				if(print_type=='ready'||print_type=='inkjet'||print_type=='stock'){
					if(!SoGrid.cellByIndex(j,3).getValue()){
						index = j;
						break;
					}
				}else if(print_type=='description'){
					if(!SoGrid.cellByIndex(j,1).getValue()){
						index = j;
						break;
					}
				}				
			}
			AddItem(ITEM_ID,SoGrid.getRowId(index));			
		}
		/*
		for(var i=0;i<count_grid;i++){
			SoGrid.cellByIndex(i,0).setValue(0);
		}
		*/
		// clear 
	}
	
	var item_save_arr = [];
	function saveItem(){
		// stop
		var url_save = RootDataPath+'save_item.php';
		SoGrid.editStop();
		if(!item_save_arr.length>0){
			alert("DỮ LIỆU CHƯA CÓ THAY ĐỔI ĐỂ UPDATE!!!");
			return false;
		}
		LayoutMain.cells("a").progressOn();
		$.ajax({
		url: url_save,
			type: "POST",
			data: {data: JSON.stringify(item_save_arr) },
			dataType: "json",
			beforeSend: function(x) {
				if (x && x.overrideMimeType) {
					x.overrideMimeType("application/j-son;charset=UTF-8");
				}
			},
			success: function(result) {
				if(result.status){
					alert("UPDATE DỮ LIỆU THÀNH CÔNG!!!");	
					location.reload();
				}else{
					alert(result.mess);
				}
				LayoutMain.cells("a").progressOff();
			}
		});
	}	
	
	function saveForm(){		
		SoForm.enableLiveValidation(true);
		checkValid = SoForm.validate();
		if(!checkValid){
			return false;
		}
		if(print_type=='master'){
			var INTERNAL_ITEM = SoForm.getItemValue('INTERNAL_ITEM');
			var ITEM_DES = SoForm.getItemValue('ITEM_DES');						
			var RBO = SoForm.getItemValue('RBO');	
			var ORDERED_ITEM = SoForm.getItemValue('ORDERED_ITEM');	
			var MATERIAL_CODE = SoForm.getItemValue('MATERIAL_CODE');	
			var MATERIAL_DES = SoForm.getItemValue('MATERIAL_DES');	
			var RIBBON_CODE = SoForm.getItemValue('RIBBON_CODE');	
			var RIBBON_DES = SoForm.getItemValue('RIBBON_DES');	
			var CHIEU_DAI = SoForm.getItemValue('CHIEU_DAI');	
			var CHIEU_RONG = SoForm.getItemValue('CHIEU_RONG');	
			var KICH_THUOC_SHEET = SoForm.getItemValue('KICH_THUOC_SHEET');	
			var GAP = SoForm.getItemValue('GAP');	
			var UPS = SoForm.getItemValue('UPS');	
			var ONE_TWO_SITE_PRINTING = SoForm.getItemValue('ONE_TWO_SITE_PRINTING');	
			var MACHINE = SoForm.getItemValue('MACHINE');	
			var FORMAT = SoForm.getItemValue('FORMAT');	
			var LOAI_VAT_TU = SoForm.getItemValue('LOAI_VAT_TU');	
			var STANDARD_SPEED_INCH = SoForm.getItemValue('STANDARD_SPEED_INCH');	
			var STANDARD_SPEED_PCS = SoForm.getItemValue('STANDARD_SPEED_PCS');	
			var CUTTER = SoForm.getItemValue('CUTTER');	
			var NHOM = SoForm.getItemValue('NHOM');	
			var MATERIAL_UOM = SoForm.getItemValue('MATERIAL_UOM');	
			var SECURITY = SoForm.getItemValue('SECURITY');	
			var FG_IPPS = SoForm.getItemValue('FG_IPPS');	
			var PCS_SET = SoForm.getItemValue('PCS_SET');						
			var CHIEU_IN_NHAN_THUC_TE = SoForm.getItemValue('CHIEU_IN_NHAN_THUC_TE');	
			var MATERIAL_CODE_2 = SoForm.getItemValue('MATERIAL_CODE_2');	
			var MATERIAL_DES_2 = SoForm.getItemValue('MATERIAL_DES_2');	
			var MATERIAL_UOM_2 = SoForm.getItemValue('MATERIAL_UOM_2');	
			var RIBBON_CODE_2 = SoForm.getItemValue('RIBBON_CODE_2');	
			var RIBBON_DES_2 = SoForm.getItemValue('RIBBON_DES_2');							
			var LAYOUT_PREPRESS = SoForm.getItemValue('LAYOUT_PREPRESS');	
			var REMARK_1_ITEM = SoForm.getItemValue('REMARK_1_ITEM');	
			var REMARK_2_SHIPPING = SoForm.getItemValue('REMARK_2_SHIPPING');	
			var REMARK_3_PACKING = SoForm.getItemValue('REMARK_3_PACKING');	
			var REMARK_4_SAN_XUAT = SoForm.getItemValue('REMARK_4_SAN_XUAT');	
			var GHI_CHU = SoForm.getItemValue('GHI_CHU');	
			var BASE_ROLL = SoForm.getItemValue('BASE_ROLL');	
			var RIBBON_MT_KIT = SoForm.getItemValue('RIBBON_MT_KIT');	
			var CHI_TIET_KIT = SoForm.getItemValue('CHI_TIET_KIT');	
			var COLOR_BY_SIZE = SoForm.getItemValue('COLOR_BY_SIZE');	
			var obj_item_data = {
				data:{
					ID_SAVE_ITEM:id_to_save,
					INTERNAL_ITEM:INTERNAL_ITEM,
					ITEM_DES:ITEM_DES,
					RBO:RBO,
					ORDERED_ITEM:ORDERED_ITEM,
					MATERIAL_CODE:MATERIAL_CODE,
					MATERIAL_DES:MATERIAL_DES,
					RIBBON_CODE:RIBBON_CODE,
					RIBBON_DES:RIBBON_DES,
					CHIEU_DAI:CHIEU_DAI,
					CHIEU_RONG:CHIEU_RONG,
					KICH_THUOC_SHEET:KICH_THUOC_SHEET,
					GAP:GAP,
					UPS:UPS,
					ONE_TWO_SITE_PRINTING:ONE_TWO_SITE_PRINTING,
					MACHINE:MACHINE,
					FORMAT:FORMAT,
					LOAI_VAT_TU:LOAI_VAT_TU,
					STANDARD_SPEED_INCH:STANDARD_SPEED_INCH,
					STANDARD_SPEED_PCS:STANDARD_SPEED_PCS,
					CUTTER:CUTTER,
					NHOM:NHOM,
					MATERIAL_UOM:MATERIAL_UOM,
					SECURITY:SECURITY,
					FG_IPPS:FG_IPPS,
					PCS_SET:PCS_SET,
					CHIEU_IN_NHAN_THUC_TE:CHIEU_IN_NHAN_THUC_TE,
					MATERIAL_CODE_2:MATERIAL_CODE_2,
					MATERIAL_DES_2:MATERIAL_DES_2,
					MATERIAL_UOM_2:MATERIAL_UOM_2,
					RIBBON_CODE_2:RIBBON_CODE_2,
					RIBBON_DES_2:RIBBON_DES_2,
					LAYOUT_PREPRESS:LAYOUT_PREPRESS,
					REMARK_1_ITEM:REMARK_1_ITEM,
					REMARK_2_SHIPPING:REMARK_2_SHIPPING,
					REMARK_3_PACKING:REMARK_3_PACKING,
					REMARK_4_SAN_XUAT:REMARK_4_SAN_XUAT,
					GHI_CHU:GHI_CHU,
					BASE_ROLL:BASE_ROLL,
					RIBBON_MT_KIT:RIBBON_MT_KIT,
					CHI_TIET_KIT:CHI_TIET_KIT,
					COLOR_BY_SIZE:COLOR_BY_SIZE,
				}
			};	
		}else if(print_type=='request'){
			var GLID = SoForm.getItemValue('GLID');
			var RBO = SoForm.getItemValue('RBO');						
			var CUSTOMER_NAME = SoForm.getItemValue('CUSTOMER_NAME');	
			var NOTE = SoForm.getItemValue('NOTE');	
			var DATE = SoForm.getItemValue('DATE');	
			var REQUEST_FROM = SoForm.getItemValue('REQUEST_FROM');	
			var APPROVED_BY = SoForm.getItemValue('APPROVED_BY');
			var obj_item_data = {
				data:{
					ID_SAVE_ITEM:id_to_save,
					GLID:GLID,
					RBO:RBO,
					CUSTOMER_NAME:CUSTOMER_NAME,
					NOTE:NOTE,
					DATE:DATE,
					REQUEST_FROM:REQUEST_FROM,
					APPROVED_BY:APPROVED_BY
				}
			};
		}
		var url_save = RootDataPath+'save_form.php';
		$.ajax({
		url: url_save,
			type: "POST",
			data: {data: JSON.stringify(obj_item_data)},
			dataType: "json",
			beforeSend: function(x) {
				if (x && x.overrideMimeType) {
					x.overrideMimeType("application/j-son;charset=UTF-8");
				}
			},
			success: function(result) {
				if(result.status){
					alert("UPDATE DỮ LIỆU THÀNH CÔNG!!!");	
					location.reload();
				}else{
					alert(result.mess);
				}
			}
		});
	}
	
	function getDataItemToSave(){
		if(print_type=='master'){
			SoGrid.attachEvent("onEditCell", function(stage,rId,cInd,nValue,oValue){             
				if(stage==2){
					if(nValue!=oValue){	
						//console.log(rId);
						var INTERNAL_ITEM = SoGrid.cells(rId,1).getValue();
						var ITEM_DES = SoGrid.cells(rId,2).getValue();						
						var RBO = SoGrid.cells(rId,3).getValue();
						var ORDERED_ITEM = SoGrid.cells(rId,4).getValue();
						var MATERIAL_CODE = SoGrid.cells(rId,5).getValue();
						var MATERIAL_DES = SoGrid.cells(rId,6).getValue();
						var RIBBON_CODE = SoGrid.cells(rId,7).getValue();
						var RIBBON_DES = SoGrid.cells(rId,8).getValue();
						var CHIEU_DAI = SoGrid.cells(rId,9).getValue();
						var CHIEU_RONG = SoGrid.cells(rId,10).getValue();
						var KICH_THUOC_SHEET = SoGrid.cells(rId,11).getValue();
						var GAP = SoGrid.cells(rId,12).getValue();
						var UPS = SoGrid.cells(rId,13).getValue();
						var ONE_TWO_SITE_PRINTING = SoGrid.cells(rId,14).getValue();
						var MACHINE = SoGrid.cells(rId,15).getValue();
						var FORMAT = SoGrid.cells(rId,16).getValue();
						var LOAI_VAT_TU = SoGrid.cells(rId,17).getValue();
						var STANDARD_SPEED_INCH = SoGrid.cells(rId,18).getValue();
						var STANDARD_SPEED_PCS = SoGrid.cells(rId,19).getValue();
						var CUTTER = SoGrid.cells(rId,20).getValue();
						var NHOM = SoGrid.cells(rId,21).getValue();
						var MATERIAL_UOM = SoGrid.cells(rId,22).getValue();
						var SECURITY = SoGrid.cells(rId,23).getValue();
						var FG_IPPS = SoGrid.cells(rId,24).getValue();
						var PCS_SET = SoGrid.cells(rId,25).getValue();						
						var CHIEU_IN_NHAN_THUC_TE = SoGrid.cells(rId,26).getValue();
						var MATERIAL_CODE_2 = SoGrid.cells(rId,27).getValue();
						var MATERIAL_DES_2 = SoGrid.cells(rId,28).getValue();
						var MATERIAL_UOM_2 = SoGrid.cells(rId,29).getValue();
						var RIBBON_CODE_2 = SoGrid.cells(rId,30).getValue();
						var RIBBON_DES_2 = SoGrid.cells(rId,31).getValue();						
						var LAYOUT_PREPRESS = SoGrid.cells(rId,32).getValue();
						var REMARK_1_ITEM = SoGrid.cells(rId,33).getValue();
						var REMARK_2_SHIPPING = SoGrid.cells(rId,34).getValue();
						var REMARK_3_PACKING = SoGrid.cells(rId,35).getValue();
						var REMARK_4_SAN_XUAT = SoGrid.cells(rId,36).getValue();
						var GHI_CHU = SoGrid.cells(rId,37).getValue();
						var BASE_ROLL = SoGrid.cells(rId,38).getValue();
						var RIBBON_MT_KIT = SoGrid.cells(rId,39).getValue();
						var CHI_TIET_KIT = SoGrid.cells(rId,40).getValue();
						var COLOR_BY_SIZE = SoGrid.cells(rId,41).getValue();
						var obj_item_data = {
							id:rId,
							data:{
								INTERNAL_ITEM:INTERNAL_ITEM,
								ITEM_DES:ITEM_DES,
								RBO:RBO,
								ORDERED_ITEM:ORDERED_ITEM,
								MATERIAL_CODE:MATERIAL_CODE,
								MATERIAL_DES:MATERIAL_DES,
								RIBBON_CODE:RIBBON_CODE,
								RIBBON_DES:RIBBON_DES,
								CHIEU_DAI:CHIEU_DAI,
								CHIEU_RONG:CHIEU_RONG,
								KICH_THUOC_SHEET:KICH_THUOC_SHEET,
								GAP:GAP,
								UPS:UPS,
								ONE_TWO_SITE_PRINTING:ONE_TWO_SITE_PRINTING,
								MACHINE:MACHINE,
								FORMAT:FORMAT,
								LOAI_VAT_TU:LOAI_VAT_TU,
								STANDARD_SPEED_INCH:STANDARD_SPEED_INCH,
								STANDARD_SPEED_PCS:STANDARD_SPEED_PCS,
								CUTTER:CUTTER,
								NHOM:NHOM,
								MATERIAL_UOM:MATERIAL_UOM,
								SECURITY:SECURITY,
								FG_IPPS:FG_IPPS,
								PCS_SET:PCS_SET,
								CHIEU_IN_NHAN_THUC_TE:CHIEU_IN_NHAN_THUC_TE,
								MATERIAL_CODE_2:MATERIAL_CODE_2,
								MATERIAL_DES_2:MATERIAL_DES_2,
								MATERIAL_DES_2:MATERIAL_DES_2,
								MATERIAL_UOM_2:MATERIAL_UOM_2,
								RIBBON_CODE_2:RIBBON_CODE_2,
								RIBBON_DES_2:RIBBON_DES_2,
								LAYOUT_PREPRESS:LAYOUT_PREPRESS,
								REMARK_1_ITEM:REMARK_1_ITEM,
								REMARK_2_SHIPPING:REMARK_2_SHIPPING,
								REMARK_3_PACKING:REMARK_3_PACKING,
								REMARK_4_SAN_XUAT:REMARK_4_SAN_XUAT,
								GHI_CHU:GHI_CHU,
								BASE_ROLL:BASE_ROLL,
								RIBBON_MT_KIT:RIBBON_MT_KIT,
								CHI_TIET_KIT:CHI_TIET_KIT,
								COLOR_BY_SIZE:COLOR_BY_SIZE,
							}
						};						
						if(item_save_arr.length){
							for(var j=0;j<item_save_arr.length;j++){
								if(rId==item_save_arr[j]['id']){
									item_save_arr.splice(j, 1);
								}
							}
						}
						item_save_arr.push(obj_item_data);
					}					
				}
				return true;
			});
		}else if(print_type=='request'){			
			SoGrid.attachEvent("onEditCell", function(stage,rId,cInd,nValue,oValue){             
				if(stage==2){
					if(nValue!=oValue){
						var GLID = SoGrid.cells(rId,1).getValue();
						var RBO = SoGrid.cells(rId,2).getValue();
						var CUSTOMER_NAME = SoGrid.cells(rId,3).getValue();
						var NOTE = SoGrid.cells(rId,4).getValue();
						var DATE = SoGrid.cells(rId,5).getValue();
						var REQUEST_FROM = SoGrid.cells(rId,6).getValue();
						var APPROVED_BY = SoGrid.cells(rId,7).getValue();
						var obj_item_data = {
							id:rId,
							data:{
								GLID:GLID,
								RBO:RBO,
								CUSTOMER_NAME:CUSTOMER_NAME,
								NOTE:NOTE,
								DATE:DATE,
								REQUEST_FROM:REQUEST_FROM,
								APPROVED_BY:APPROVED_BY,
							}
						};
						if(item_save_arr.length){
							for(var j=0;j<item_save_arr.length;j++){
								if(rId==item_save_arr[j]['id']){
									item_save_arr.splice(j, 1);
								}
							}
						}
						item_save_arr.push(obj_item_data);
					}
				}
				return true;
			});
		}		
	}
	
	function deleteItem(){
		var checkIDs = [];
		SoGrid.forEachRow(function(id){
			if(SoGrid.cells(id,0).getValue()==1){
				checkIDs.push(id);
			}
		});
		if(!checkIDs.length>0){
			alert("Vui lòng chọn dòng để XÓA");
			return false;
		}else{
			confirm_delete = confirm("Bạn có muốn XÓA những item đã chọn!!!");
			if(confirm_delete){
				var url_delete = RootDataPath+'delete_item.php';
				// get all checkbox
				$.ajax({
					url: url_delete,
					type: "POST",
					data: {data: JSON.stringify(checkIDs)},
					dataType: "json",
					beforeSend: function(x) {
						if (x && x.overrideMimeType) {
							x.overrideMimeType("application/j-son;charset=UTF-8");
						}
					},
					success: function(result) {
						if(result.status){
							// reload	
							for(var i=0;i<checkIDs.length;i++){
								SoGrid.deleteRow(checkIDs[i]);
							}
						}else{
							alert(result.mess);							
						}
					}
				});					
			}
		}	
	}
	var id_to_save = '';
	var SoGrid;
    function initSoGrid(){
		LayoutMain.cells("a").progressOn();
        SoGrid = LayoutMain.cells("a").attachGrid();
		if(print_type=='master'){
			SoGrid.attachHeader(",#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter");	
			SoGrid.setHeader(',INTERNAL ITEM,ITEM DESCRIPTION,RBO,ORDER ITEM,MATERIAL CODE,MATERIAL DESCRIPTION,RIBBON CODE,RIBBON DESCRIPTION,CHIEU DAI,CHIEU RONG,KICH THUOC SHEET,GAP,UPS,ONE OR TWO SITE PRINTING,MACHINE,FORMAT,LOAI VAT TU,STANDARD SPEED INCH,STANDARD SPEED PCS,CUTTER,NHOM,MATERIAL UOM,SECURITY,FG IPPS,PCS SET,CHIEU IN NHAN THUC TE,MATERIAL CODE 2,MATERIAL DES 2,MATERIAL UOM 2,RIBBON CODE 2,RIBBON DES 2,LAYOUT PREPRESS,REMARK_1_ITEM,REMARK_2_SHIPPING,REMARK_3_PACKING,REMARK_4_SAN_XUAT,GHI_CHU,BASE_ROLL,RIBBON_MT_KIT,CHI_TIET_KIT,COLOR BY SIZE,UPDATED BY,CREATED TIME');
			SoGrid.setImagePath("./dhtmlx/skins/skyblue/imgs/");	
			SoGrid.setInitWidths("30,150,280,85,135,125,165,200,180,85,90,135,50,55,180,70,75,95,155,140,70,60,100,70,60,65,155,120,110,110,110,100,125,120,120,120,120,120,120,120,120,120,120,120");
			SoGrid.setColAlign("left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left,left");
			SoGrid.setColTypes("ch,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ed,ro,ro");
			SoGrid.setColSorting("na,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str,str");		
		}else if(print_type=='request'){
			SoGrid.attachHeader(",#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter");	
			SoGrid.setHeader(',GLID,RBO,CUSTOMER NAME,NOTE,START FROM DATE,REQUEST FROM,APPROVED BY, UPDATED BY,CREATED TIME');
			SoGrid.setImagePath("./dhtmlx/skins/skyblue/imgs/");	
			SoGrid.setInitWidths("30,100,100,150,*,150,150,150,150,120,120");
			SoGrid.setColAlign("left,left,left,left,left,left,left,left,left,left");
			SoGrid.setColTypes("ch,ed,ed,ed,ed,ed,ed,ed,ro,ro");
			SoGrid.setColSorting("na,str,str,str,str,str,str,str,str,str");
		}	
		//SoGrid.enableEditEvents(true,true,true);
		//SoGrid.enableMultiline(true);
		SoGrid.enableSmartRendering(true);		
		SoGrid.init();	
		//SoGrid.splitAt(2);
		SoGrid.load(RootDataPath+'view_item.php?print_type='+print_type,function(){
			//dhxWinsListItem.window('windowViewItem').maximize();					
			//update_Item();
			LayoutMain.cells("a").progressOff();
			// load last row
			var state=SoGrid.getStateOfView();
			if(state[2]>0){
				SoGrid.showRow(SoGrid.getRowId(state[2]-1));
			}
			//testAdd();
		});				
		SoGrid.attachEvent("onRowSelect", function(id,ind){ // Fire When user click on row in grid            
			//console.log(id);
			// load form 
			id_to_save = id;
			if(print_type=='master'){								
				SoForm.setItemValue('INTERNAL_ITEM',SoGrid.cells(id,1).getValue());
				SoForm.setItemValue('ITEM_DES',SoGrid.cells(id,2).getValue());
				SoForm.setItemValue('RBO',SoGrid.cells(id,3).getValue());
				SoForm.setItemValue('ORDERED_ITEM',SoGrid.cells(id,4).getValue());
				SoForm.setItemValue('MATERIAL_CODE',SoGrid.cells(id,5).getValue());
				SoForm.setItemValue('MATERIAL_DES',SoGrid.cells(id,6).getValue());
				SoForm.setItemValue('RIBBON_CODE',SoGrid.cells(id,7).getValue());
				SoForm.setItemValue('RIBBON_DES',SoGrid.cells(id,8).getValue());
				SoForm.setItemValue('CHIEU_DAI',SoGrid.cells(id,9).getValue());
				SoForm.setItemValue('CHIEU_RONG',SoGrid.cells(id,10).getValue());
				SoForm.setItemValue('KICH_THUOC_SHEET',SoGrid.cells(id,11).getValue());
				SoForm.setItemValue('GAP',SoGrid.cells(id,12).getValue());
				SoForm.setItemValue('UPS',SoGrid.cells(id,13).getValue());
				SoForm.setItemValue('ONE_TWO_SITE_PRINTING',SoGrid.cells(id,14).getValue());
				SoForm.setItemValue('MACHINE',SoGrid.cells(id,15).getValue());
				SoForm.setItemValue('FORMAT',SoGrid.cells(id,16).getValue());
				SoForm.setItemValue('LOAI_VAT_TU',SoGrid.cells(id,17).getValue());
				SoForm.setItemValue('STANDARD_SPEED_INCH',SoGrid.cells(id,18).getValue());
				SoForm.setItemValue('STANDARD_SPEED_PCS',SoGrid.cells(id,19).getValue());
				SoForm.setItemValue('CUTTER',SoGrid.cells(id,20).getValue());
				SoForm.setItemValue('NHOM',SoGrid.cells(id,21).getValue());
				SoForm.setItemValue('MATERIAL_UOM',SoGrid.cells(id,22).getValue());
				SoForm.setItemValue('SECURITY',SoGrid.cells(id,23).getValue());
				SoForm.setItemValue('FG_IPPS',SoGrid.cells(id,24).getValue());
				SoForm.setItemValue('PCS_SET',SoGrid.cells(id,25).getValue());
				SoForm.setItemValue('CHIEU_IN_NHAN_THUC_TE',SoGrid.cells(id,26).getValue());
				SoForm.setItemValue('MATERIAL_CODE_2',SoGrid.cells(id,27).getValue());
				SoForm.setItemValue('MATERIAL_DES_2',SoGrid.cells(id,28).getValue());
				SoForm.setItemValue('MATERIAL_UOM_2',SoGrid.cells(id,29).getValue());
				SoForm.setItemValue('RIBBON_CODE_2',SoGrid.cells(id,30).getValue());
				SoForm.setItemValue('RIBBON_DES_2',SoGrid.cells(id,31).getValue());
				SoForm.setItemValue('LAYOUT_PREPRESS',SoGrid.cells(id,32).getValue());
				SoForm.setItemValue('REMARK_1_ITEM',SoGrid.cells(id,33).getValue());
				SoForm.setItemValue('REMARK_2_SHIPPING',SoGrid.cells(id,34).getValue());
				SoForm.setItemValue('REMARK_3_PACKING',SoGrid.cells(id,35).getValue());
				SoForm.setItemValue('REMARK_4_SAN_XUAT',SoGrid.cells(id,36).getValue());
				SoForm.setItemValue('GHI_CHU',SoGrid.cells(id,37).getValue());
				SoForm.setItemValue('BASE_ROLL',SoGrid.cells(id,38).getValue());
				SoForm.setItemValue('RIBBON_MT_KIT',SoGrid.cells(id,39).getValue());
				SoForm.setItemValue('CHI_TIET_KIT',SoGrid.cells(id,40).getValue());
				SoForm.setItemValue('COLOR_BY_SIZE',SoGrid.cells(id,41).getValue());
				if(id.indexOf("new")!==-1){
					SoForm.setReadonly('INTERNAL_ITEM',false);
				}else{
					//SoForm.setReadonly('INTERNAL_ITEM',true);
				}
			}else{
				SoForm.setItemValue('GLID',SoGrid.cells(id,1).getValue());
				SoForm.setItemValue('RBO',SoGrid.cells(id,2).getValue());
				SoForm.setItemValue('CUSTOMER_NAME',SoGrid.cells(id,3).getValue());
				SoForm.setItemValue('NOTE',SoGrid.cells(id,4).getValue());
				SoForm.setItemValue('DATE',SoGrid.cells(id,5).getValue());
				SoForm.setItemValue('REQUEST_FROM',SoGrid.cells(id,6).getValue());
				SoForm.setItemValue('APPROVED_BY',SoGrid.cells(id,7).getValue());
				if(id.indexOf("new")!==-1){
					SoForm.setReadonly('GLID',false);
				}else{
					SoForm.setReadonly('GLID',true);					
				}
			}						
		});  
		SoGrid.attachEvent("onCheck", function(rId,cInd,state){// fires after the state of a checkbox has been changed     
			if(state){
				checked_ids.push(rId);
			}else{
				if(checked_ids.length>0){
					for(var j=0;j<checked_ids.length;j++){
						if(rId==checked_ids[j]){
							checked_ids.splice(j,1);
						}
					}
				}				
			}
        });
    }
	
	
	function AddItem(id_item_copy,id_item_paste){
		console.log('id_item_copy:'+id_item_copy);		
		console.log('id_item_paste:'+id_item_paste);		
		rId = id_item_copy;
		rId_2 = id_item_paste;
		if(print_type=='ready'||print_type=='inkjet'||print_type=='stock'){
			SoGrid.cells(rId_2,1).setValue(SoGrid.cells(rId,1).getValue());		
			SoGrid.cells(rId_2,2).setValue(SoGrid.cells(rId,2).getValue());		
			SoGrid.cells(rId_2,3).setValue(SoGrid.cells(rId,3).getValue());		
			SoGrid.cells(rId_2,4).setValue(SoGrid.cells(rId,4).getValue());		
			SoGrid.cells(rId_2,5).setValue(SoGrid.cells(rId,5).getValue());		
			SoGrid.cells(rId_2,6).setValue(SoGrid.cells(rId,6).getValue());		
			SoGrid.cells(rId_2,7).setValue(SoGrid.cells(rId,7).getValue());		
			SoGrid.cells(rId_2,8).setValue(SoGrid.cells(rId,8).getValue());		
			SoGrid.cells(rId_2,9).setValue(SoGrid.cells(rId,9).getValue());		
			SoGrid.cells(rId_2,10).setValue(SoGrid.cells(rId,10).getValue());		
			SoGrid.cells(rId_2,11).setValue(SoGrid.cells(rId,11).getValue());		
			SoGrid.cells(rId_2,12).setValue(SoGrid.cells(rId,12).getValue());		
			SoGrid.cells(rId_2,13).setValue(SoGrid.cells(rId,13).getValue());		
			SoGrid.cells(rId_2,14).setValue(SoGrid.cells(rId,14).getValue());		
			SoGrid.cells(rId_2,15).setValue(SoGrid.cells(rId,15).getValue());		
			SoGrid.cells(rId_2,16).setValue(SoGrid.cells(rId,16).getValue());		
			SoGrid.cells(rId_2,17).setValue(SoGrid.cells(rId,17).getValue());		
			SoGrid.cells(rId_2,18).setValue(SoGrid.cells(rId,18).getValue());		
			SoGrid.cells(rId_2,19).setValue(SoGrid.cells(rId,19).getValue());		
			SoGrid.cells(rId_2,20).setValue(SoGrid.cells(rId,20).getValue());		
			SoGrid.cells(rId_2,21).setValue(SoGrid.cells(rId,21).getValue());		
			SoGrid.cells(rId_2,22).setValue(SoGrid.cells(rId,22).getValue());		
			SoGrid.cells(rId_2,23).setValue(SoGrid.cells(rId,23).getValue());		
			SoGrid.cells(rId_2,24).setValue(SoGrid.cells(rId,24).getValue());		
			SoGrid.cells(rId_2,25).setValue(SoGrid.cells(rId,25).getValue());		
			SoGrid.cells(rId_2,26).setValue(SoGrid.cells(rId,26).getValue());		
			SoGrid.cells(rId_2,27).setValue(SoGrid.cells(rId,27).getValue());		
			SoGrid.cells(rId_2,28).setValue(SoGrid.cells(rId,28).getValue());		
			SoGrid.cells(rId_2,29).setValue(SoGrid.cells(rId,29).getValue());		
			SoGrid.cells(rId_2,30).setValue(SoGrid.cells(rId,30).getValue());		
			SoGrid.cells(rId_2,31).setValue(SoGrid.cells(rId,31).getValue());		
			SoGrid.cells(rId_2,32).setValue(SoGrid.cells(rId,32).getValue());		
			SoGrid.cells(rId_2,33).setValue(SoGrid.cells(rId,33).getValue());		
			SoGrid.cells(rId_2,34).setValue(SoGrid.cells(rId,34).getValue());		
			SoGrid.cells(rId_2,35).setValue(SoGrid.cells(rId,35).getValue());		
			SoGrid.cells(rId_2,36).setValue(SoGrid.cells(rId,36).getValue());		
			SoGrid.cells(rId_2,37).setValue(SoGrid.cells(rId,37).getValue());		
			SoGrid.cells(rId_2,38).setValue(SoGrid.cells(rId,38).getValue());		
			SoGrid.cells(rId_2,39).setValue(SoGrid.cells(rId,39).getValue());		
			SoGrid.cells(rId_2,40).setValue(SoGrid.cells(rId,40).getValue());		
			SoGrid.cells(rId_2,41).setValue(SoGrid.cells(rId,41).getValue());		
			SoGrid.cells(rId_2,42).setValue(SoGrid.cells(rId,42).getValue());		
			SoGrid.cells(rId_2,43).setValue(SoGrid.cells(rId,43).getValue());		
			SoGrid.cells(rId_2,44).setValue(SoGrid.cells(rId,44).getValue());		
			SoGrid.cells(rId_2,45).setValue(SoGrid.cells(rId,45).getValue());		
			SoGrid.cells(rId_2,46).setValue(SoGrid.cells(rId,46).getValue());		
			SoGrid.cells(rId_2,47).setValue(SoGrid.cells(rId,47).getValue());		
			SoGrid.cells(rId_2,48).setValue(SoGrid.cells(rId,48).getValue());		
			SoGrid.cells(rId_2,49).setValue(SoGrid.cells(rId,49).getValue());		
			SoGrid.cells(rId_2,50).setValue(SoGrid.cells(rId,50).getValue());		
			SoGrid.cells(rId_2,51).setValue(SoGrid.cells(rId,51).getValue());		
			SoGrid.cells(rId_2,52).setValue(SoGrid.cells(rId,52).getValue());		
			SoGrid.cells(rId_2,53).setValue(SoGrid.cells(rId,53).getValue());		
			SoGrid.cells(rId_2,54).setValue(SoGrid.cells(rId,54).getValue());		
			SoGrid.cells(rId_2,55).setValue(SoGrid.cells(rId,55).getValue());		
			SoGrid.cells(rId_2,56).setValue(SoGrid.cells(rId,56).getValue());		
			SoGrid.cells(rId_2,57).setValue(SoGrid.cells(rId,57).getValue());		
			SoGrid.cells(rId_2,58).setValue(SoGrid.cells(rId,58).getValue());		
			SoGrid.cells(rId_2,59).setValue(SoGrid.cells(rId,59).getValue());		
			SoGrid.cells(rId_2,60).setValue(SoGrid.cells(rId,60).getValue());
			SoGrid.cells(rId_2,61).setValue(SoGrid.cells(rId,61).getValue());
		}else if(print_type=='description'){
			SoGrid.cells(rId_2,1).setValue(SoGrid.cells(rId,1).getValue());		
			SoGrid.cells(rId_2,2).setValue(SoGrid.cells(rId,2).getValue());		
			SoGrid.cells(rId_2,3).setValue(SoGrid.cells(rId,3).getValue());		
			SoGrid.cells(rId_2,4).setValue(SoGrid.cells(rId,4).getValue());		
		}		
	}
	var SoForm;
	function initDetailForm(){
		SoForm = LayoutMain.cells("b").attachForm();
		if(print_type=='master'){
			var FILE_NAME = 'frm_master_file.php';
		}else{
			var FILE_NAME = 'frm_special_request.php';
		}		
        SoForm.loadStruct(RootDataPath+FILE_NAME,function(){
			
		});
	}
	
    $(document).ready(function(){	
		
		var VNRISIntranet = '<?php echo getUser(); ?>';
        console.log("VNRISIntranet: "+VNRISIntranet);
        if (!VNRISIntranet ) {
            var pr = prompt('Nhập tiền tố email trước @. Ví dụ: hang.nguyen', '');
            pr = pr.trim();
            if (!pr || pr.indexOf('@') !== -1 ) {
                alert('Bạn vui lòng nhập đúng tiền tố email là phần trước @');
            } else {
                // Save email đến bảng thống kê (au_avery.planning_user_statistics)
                setCookie('VNRISIntranet', pr, 30 );
                // setCookie('VNRISIntranet', pr, 30 );
                var VNRISIntranet = '<?php echo getUser(); ?>';
                var pr_s = '<?php echo planning_user_statistics($email, "Thermal_MasterFile"); ?>';
                console.log('save planning_user_statistics: ' + pr_s);
                
                check_gg = 1;
				updateItem = 1;
            }
            
           
        }
		
		if (check_gg) location.href = './';

        initLayout();
        initMenu();
        initToolbar();	
		initSoGrid();
		initDetailForm();
		getDataItemToSave();
		

		if(!updateItem){
			if (!check_gg ) {
				alert("BẠN CHƯA ĐƯỢC CẤP QUYỀN CHỈNH SỬA MASTER FILE!");
				return false;
			} else {
				location.href = './';
			}
			
		}
    });    
</script>
</head>
<body>
    <div style="height: 30px;background:#205670;font-weight:bold">
		<div id="menuObj"></div>
    </div>
    <div style="position:absolute;width:100%;top:35;background:white">
		<div id="ToolbarBottom" ></div>
    </div>
</body>
</html>