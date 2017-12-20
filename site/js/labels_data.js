var producer = ["Avery", "Herma", "Sigel", "Tower"];
var format = [];
format["Avery"] = ["A4","Letter"];
format["Avery-Zweckform"] = ["A4"];
format["Herma"] = ["A4","A5","Endless"];
format["Sigel"] = ["A4"];
format["Tower"] = ["A4"];
var settings = [];
format["Empty|"] = [
	{
		name:"",
		pageWidth:"", pageHeight:"", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait|landscape",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	}
];
format["Avery|A4"] = [
	{
		name:"",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait|landscape",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	}
];
format["Avery|Letter"] = [
	{
		name:"",
		pageWidth:"", pageHeight:"", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait|landscape",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	}
];
format["Avery-Zweckform|A4"] = [
	{
		name:"3422 Universal-Etiketten",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"8.4", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"8", columns:"3", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"70", labelHeight:"35"
	},
	{
		name:"3424 Universal-Etiketten",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"4.4", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"6", columns:"2", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"105", labelHeight:"48"
	},
	{
		name:"3425 Universal-Etiketten",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"5.9", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"5", columns:"2", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"105", labelHeight:"57"
	},
	{
		name:"3426 Universal-Etiketten",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"8.4", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"4", columns:"2", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"105", labelHeight:"70"
	},
	{
		name:"3427 Universal-Etiketten",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"4", columns:"2", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"105", labelHeight:"74"
	},
	{
		name:"3474 Universal-Etiketten",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"8", columns:"3", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"70", labelHeight:"37"
	},
	{
		name:"3475 Universal-Etiketten",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"4.4", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"8", columns:"3", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"70", labelHeight:"36"
	},
	{
		name:"3481 Universal-Etiketten",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"4.9", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"7", columns:"3", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"70", labelHeight:"41"
	},
	{
		name:"3490 Universal-Etiketten",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"4.4", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"8", columns:"3", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"70", labelHeight:"36"
	},
	{
		name:"3652 Universal-Etiketten",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"7", columns:"3", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"70", labelHeight:"42.3"
	},
	{
		name:"3659 Universal-Etiketten",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"21.5", pageMarginLeft:"8", pageOrientation:"portrait",
		rows:"6", columns:"2", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"97", labelHeight:"42.3"
	},
	{
		name:"4781 Universal-Etiketten",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"21.5", pageMarginLeft:8"", pageOrientation:"portrait",
		rows:"6", columns:"2", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"97", labelHeight:"42.3"
	},
	{
		name:"4782 Universal-Etiketten",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"13", pageMarginLeft:"8", pageOrientation:"portrait",
		rows:"4", columns:"2", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"97", labelHeight:"67.7"
	}
];
format["Herma|A4"] = [
	{
		name:"4103 Labels, gold foil, glossy",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"15", pageMarginLeft:"7.2", pageOrientation:"portrait",
		rows:"7", columns:"3", spacingHorizontal:"2.5", spacingVertical:"0", labelWidth:"63.5", labelHeight:"38.1"
	},
	{
		name:"4113 Labels, silver foil, glossy",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"15", pageMarginLeft:"7.2", pageOrientation:"portrait",
		rows:"7", columns:"3", spacingHorizontal:"2.5", spacingVertical:"0", labelWidth:"63.5", labelHeight:"38.1"
	},
	{
		name:"4114 Labels, silver foil, glossy",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"13", pageMarginLeft:"4.7", pageOrientation:"portrait",
		rows:"4", columns:"2", spacingHorizontal:"2.5", spacingVertical:"0", labelWidth:"99.1", labelHeight:"67.7"
	},
	{
		name:"4250 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"9.5", pageMarginLeft:"4.5", pageOrientation:"portrait",
		rows:"2", columns:"2", spacingHorizontal:"0.28", spacingVertical:"0", labelWidth:"99.1", labelHeight:"139"
	},
	{
		name:"4254 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4265 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4267 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4268 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4269 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4348 Labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4349 Address labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4406 Labels, colored",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4407 Labels, colored",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4408 Labels, colored",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4409 Labels, colored",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4466 Labels, colored",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4467 Labels, colored",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4468 Labels, colored",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4469 Labels, colored",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4472 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4479 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4500 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4501 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4502 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4503 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4504 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4627 Labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4645 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4653 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4666 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4667 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4676 Labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4677 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4678 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4681 Labels, transparent, matt",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4682 Labels, transparent, matt",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4685 Labels, transparent, matt",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4814 Labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4815 Labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4816 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4820 Labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"4823 Labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"5029 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"5063 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"5074 Address labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"5075 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"5076 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"5077 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8330 Shipping labels, white, weatherproof",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8331 Shipping labels, white, weatherproof",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8332 Shipping labels, white, weatherproof",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8628 Labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8630 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8632 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8634 Labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8635 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8638 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8644 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8670 Address labels, transparent, matt",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8671 Address labels, transparent, matt",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8805 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8807 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8838 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"8842 Address labels, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10009 Labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10010 Labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10016 Address labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10017 Address labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10018 Address labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10301 Address labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10302 Labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10303 Labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10304 Labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10309 Address labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10307 Address labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10310 Address labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10311 Address labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10312 Address labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10316 Address labels, white, removable",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10822 Address labels, white, recycled",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10825 Address labels, white, recycled",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10826 Address labels, white, recycled",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	},
	{
		name:"10827 Address labels, white, recycled",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"", labelHeight:""
	}
];
format["Herma|A5"] = [
	{
		name:"4628 PREMIUM, white",
		pageWidth:"210", pageHeight:"148", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"landscape",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"4282 PREMIUM, white",
		pageWidth:"", pageHeight:"148", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"landscape",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"5064 PREMIUM, white",
		pageWidth:"", pageHeight:"148", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"landscape",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"8636 PREMIUM, white",
		pageWidth:"", pageHeight:"148", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"landscape",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"4683 Transparent, matt",
		pageWidth:"", pageHeight:"148", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"landscape",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	}
];
format["Sigel|A4"] = [
	{
		name:"DE115 Design-Etiketten",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"23.6", pageMarginLeft:"19.8", pageOrientation:"portrait",
		rows:"10", columns:"3", spacingHorizontal:"4.2", spacingVertical:"4.2", labelWidth:"54", labelHeight:"21.2"
	},
	{
		name:"DE141 Design-Etiketten",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"18", pageMarginLeft:"12", pageOrientation:"portrait",
		rows:"8", columns:"3", spacingHorizontal:"3", spacingVertical:"3", labelWidth:"60", labelHeight:"30"
	}
];
format["Tower|A4"] = [
	{
		name:"CIL-W100 Mailing Label",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"8", columns:"3", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"70", labelHeight:"37"
	},
	{
		name:"CIL-W101 Mailing Label",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"0", pageMarginLeft:"0", pageOrientation:"portrait",
		rows:"8", columns:"2", spacingHorizontal:"0", spacingVertical:"0", labelWidth:"105", labelHeight:"37"
	},
	{
		name:"CIL-W102 Freight Label",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"2", pageMarginLeft:"4.2", pageOrientation:"portrait",
		rows:"6", columns:"2", spacingHorizontal:"4", spacingVertical:"1.2", labelWidth:"101", labelHeight:"46"
	}
];

