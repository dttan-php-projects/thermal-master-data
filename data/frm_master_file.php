<?php
require_once ("../Database.php");
$sql = "SELECT distinct machine FROM master_bom order by machine";
$rowsResult = MiQuery($sql, $dbMi_138);
$options_machine = [
	
];
if(!empty($rowsResult)){
	foreach($rowsResult as $key=>$value){
		$options_machine[] = [
			'value' => $value['machine'],
			'text' => $value['machine'],
		];
	}
}
$json_encode_machine  = json_encode($options_machine);
echo "
[
	{type: 'settings', position: 'label-left', labelWidth: 'auto', inputWidth: 'auto'},
	{type: 'block', width: 'auto', blockOffset: 0,label:'Detail', offsetLeft: '20',offsetTop: '20',list: [
		{type: 'settings', position: 'label-left', labelWidth: '170', inputWidth: 170, labelAlign: 'left'},
		{type: 'input', label: 'INTERNAL ITEM:', labelAlign: 'left', icon: 'icon-input', name:'INTERNAL_ITEM',id:'INTERNAL_ITEM',className: '',value:'',required:true,validate:'NotEmpty'},		
		{type: 'input', label: 'RBO:', labelAlign: 'left', icon: 'icon-input', name:'RBO',id:'RBO',className: '',value:'',required:true,validate:'NotEmpty'},		
		{type: 'input', label: 'MATERIAL CODE:', labelAlign: 'left', icon: 'icon-input', name:'MATERIAL_CODE',id:'MATERIAL_CODE',className: '',value:'',required:true,validate:'NotEmpty'},		
		{type: 'input', label: 'RIBBON CODE:', labelAlign: 'left', icon: 'icon-input', name:'RIBBON_CODE',id:'RIBBON_CODE',className: '',value:''},		
		{type: 'input', label: 'CHIEU DAI:', labelAlign: 'left', icon: 'icon-input', name:'CHIEU_DAI',id:'CHIEU_DAI',className: '',value:''},		
		{type: 'input', label: 'KICH THUOC SHEET:', labelAlign: 'left', icon: 'icon-input', name:'KICH_THUOC_SHEET',id:'KICH_THUOC_SHEET',className: '',value:''},		
		{type: 'input', label: 'UPS:', labelAlign: 'left', icon: 'icon-input', name:'UPS',id:'UPS',className: '',value:''},	
		{type: 'select', label: 'MACHINE:',name:'MACHINE',id:'MACHINE',options:$json_encode_machine
		},
		{type: 'input', label: 'LOAI VAT TU:', labelAlign: 'left', icon: 'icon-input', name:'LOAI_VAT_TU',id:'LOAI_VAT_TU',className: '',value:''},		
		{type: 'input', label: 'STANDARD SPEED PCS:', labelAlign: 'left', icon: 'icon-input', name:'STANDARD_SPEED_PCS',id:'STANDARD_SPEED_PCS',className: '',value:''},		
		{type: 'input', label: 'NHOM:', labelAlign: 'left', icon: 'icon-input', name:'NHOM',id:'NHOM',className: '',value:''},		
		{type: 'input', label: 'SECURITY:', labelAlign: 'left', icon: 'icon-input', name:'SECURITY',id:'SECURITY',className: '',value:''},		
		{type: 'input', label: 'PCS SET:', labelAlign: 'left', icon: 'icon-input', name:'PCS_SET',id:'PCS_SET',className: '',value:''},		
		{type: 'input', label: 'MATERIAL CODE 2:', labelAlign: 'left', icon: 'icon-input', name:'MATERIAL_CODE_2',id:'MATERIAL_CODE_2',className: '',value:''},		
		{type: 'input', label: 'MATERIAL UOM 2:', labelAlign: 'left', icon: 'icon-input', name:'MATERIAL_UOM_2',id:'MATERIAL_UOM_2',className: '',value:''},
		{type: 'input', label: 'RIBBON DES 2:', labelAlign: 'left', icon: 'icon-input', name:'RIBBON_DES_2',id:'RIBBON_DES_2',className: '',value:''},			
		{type: 'input', label: 'REMARK 1 ITEM:', labelAlign: 'left', icon: 'icon-input', name:'REMARK_1_ITEM',id:'REMARK_1_ITEM',className: '',value:''},
		{type: 'input', label: 'REMARK 3 PACKING:', labelAlign: 'left', icon: 'icon-input', name:'REMARK_3_PACKING',id:'REMARK_3_PACKING',className: '',value:''},
		{type: 'input', label: 'GHI CHU:', labelAlign: 'left', icon: 'icon-input', name:'GHI_CHU',id:'GHI_CHU',className: '',value:''},
		{type: 'input', label: 'RIBBON MT KIT:', labelAlign: 'left', icon: 'icon-input', name:'RIBBON_MT_KIT',id:'GHI_CHU',className: '',value:''},
		{type: 'select', label: 'COLOR BY SIZE:',name:'COLOR_BY_SIZE',id:'COLOR_BY_SIZE',options:[
			{value: 'Yes', text: 'Yes'},
			{value: 'No', text: 'No'},
		]},
		{type: 'newcolumn', offset: 20},
		{type: 'input', label: 'ITEM DES:', labelAlign: 'left', icon: 'icon-input', name:'ITEM_DES',id:'ITEM_DES',className: '',value:''},		
		{type: 'input', label: 'ORDERED ITEM:', labelAlign: 'left', icon: 'icon-input', name:'ORDERED_ITEM',id:'ORDERED_ITEM',className: '',value:'',required:true,validate:'NotEmpty'},		
		{type: 'input', label: 'MATERIAL DES:', labelAlign: 'left', icon: 'icon-input', name:'MATERIAL_DES',id:'MATERIAL_DES',className: '',value:''},		
		{type: 'input', label: 'RIBBON DES:', labelAlign: 'left', icon: 'icon-input', name:'RIBBON_DES',id:'RIBBON_DES',className: '',value:''},		
		{type: 'input', label: 'CHIEU RONG:', labelAlign: 'left', icon: 'icon-input', name:'CHIEU_RONG',id:'CHIEU_RONG',className: '',value:''},		
		{type: 'input', label: 'GAP:', labelAlign: 'left', icon: 'icon-input', name:'GAP',id:'GAP',className: '',value:''},		
		{type: 'input', label: 'ONE TWO SITE PRINTING:', labelAlign: 'left', icon: 'icon-input', name:'ONE_TWO_SITE_PRINTING',id:'ONE_TWO_SITE_PRINTING',className: '',value:''},		
		{type: 'input', label: 'FORMAT:', labelAlign: 'left', icon: 'icon-input', name:'FORMAT',id:'FORMAT',className: '',value:''},		
		{type: 'input', label: 'STANDARD SPEED INCH:', labelAlign: 'left', icon: 'icon-input', name:'STANDARD_SPEED_INCH',id:'STANDARD_SPEED_INCH',className: '',value:''},		
		{type: 'input', label: 'CUTTER:', labelAlign: 'left', icon: 'icon-input', name:'CUTTER',id:'CUTTER',className: '',value:''},		
		{type: 'input', label: 'MATERIAL UOM:', labelAlign: 'left', icon: 'icon-input', name:'MATERIAL_UOM',id:'MATERIAL_UOM',className: '',value:''},		
		{type: 'input', label: 'FG IPPS:', labelAlign: 'left', icon: 'icon-input', name:'FG_IPPS',id:'FG_IPPS',className: '',value:''},		
		{type: 'input', label: 'CHIEU IN NHAN:', labelAlign: 'left', icon: 'icon-input', name:'CHIEU_IN_NHAN_THUC_TE',id:'CHIEU_IN_NHAN_THUC_TE',className: '',value:''},		
		{type: 'input', label: 'MATERIAL DES 2:', labelAlign: 'left', icon: 'icon-input', name:'MATERIAL_DES_2',id:'MATERIAL_DES_2',className: '',value:''},		
		{type: 'input', label: 'RIBBON CODE 2:', labelAlign: 'left', icon: 'icon-input', name:'RIBBON_CODE_2',id:'RIBBON_CODE_2',className: '',value:''},			
		{type: 'select', label: 'LAYOUT PREPRESS:',name:'LAYOUT_PREPRESS',id:'LAYOUT_PREPRESS',options:[
			{value: 'Yes', text: 'Yes'},
			{value: 'No', text: 'No'},
			{value: '', text: 'Non Detected'},
		]},
		{type: 'input', label: 'REMARK 2 SHIPPING:', labelAlign: 'left', icon: 'icon-input', name:'REMARK_2_SHIPPING',id:'REMARK_2_SHIPPING',className: '',value:''},	
		{type: 'input', label: 'REMARK 4 SAN XUAT:', labelAlign: 'left', icon: 'icon-input', name:'REMARK_4_SAN_XUAT',id:'REMARK_4_SAN_XUAT',className: '',value:''},
		{type: 'input', label: 'BASE ROLL:', labelAlign: 'left', icon: 'icon-input', name:'BASE_ROLL',id:'BASE_ROLL',className: '',value:''},
		{type: 'input', label: 'CHI TIET KIT:', labelAlign: 'left', icon: 'icon-input', name:'CHI_TIET_KIT',id:'CHI_TIET_KIT',className: '',value:''},
	]}
]";
?>