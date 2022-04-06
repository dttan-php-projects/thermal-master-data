<?php
echo "
[
	{type: 'settings', position: 'label-left', labelWidth: 'auto', inputWidth: 'auto'},
	{type: 'block', width: 'auto', blockOffset: 0,label:'Detail', offsetLeft: '20',offsetTop: '20',list: [
		{type: 'settings', position: 'label-left', labelWidth: '140', inputWidth: 200, labelAlign: 'left'},
		{type: 'input', label: 'GLID:', labelAlign: 'left', icon: 'icon-input', name:'GLID',id:'GLID',className: '',value:''},		
		{type: 'input', label: 'CUSTOMER NAME:', labelAlign: 'left', icon: 'icon-input', name:'CUSTOMER_NAME',id:'CUSTOMER_NAME',className: '',value:''},		
		{type: 'input', label: 'DATE:', labelAlign: 'left', icon: 'icon-input', name:'DATE',id:'DATE',className: '',value:''},		
		{type: 'input', label: 'APPROVED BY:', labelAlign: 'left', icon: 'icon-input', name:'APPROVED_BY',id:'APPROVED_BY',className: '',value:''},		
		{type: 'newcolumn', offset: 20},
		{type: 'input', label: 'RBO:', labelAlign: 'left', icon: 'icon-input', name:'RBO',id:'RBO',className: '',value:''},		
		{type: 'input', label: 'NOTE:', labelAlign: 'left', icon: 'icon-input', name:'NOTE',id:'NOTE',className: '',value:'',required:true,validate:'NotEmpty'},		
		{type: 'input', label: 'REQUEST FROM:', labelAlign: 'left', icon: 'icon-input', name:'REQUEST_FROM',id:'REQUEST_FROM',className: '',value:''},	
	]}
]";
?>