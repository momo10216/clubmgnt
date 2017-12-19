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
		pageWidth:"", pageHeight:"", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait|landscape",
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
format["Herma|A4"] = [
	{
		name:"4631 PREMIUM, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"4428 PREMIUM, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"5065 PREMIUM, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"4117 Silver foil, glossy",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"8637 PREMIUM, white",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"4107 Gold foil, glossy",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"4401 Coloured",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"4402 Coloured",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"4422 Coloured",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"4421 Coloured",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"4404 Coloured",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"4403 Coloured",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"4424 Coloured",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
	},
	{
		name:"4423 Coloured",
		pageWidth:"210", pageHeight:"297", pageMarginTop:"", pageMarginLeft:"", pageOrientation:"portrait",
		rows:"", columns:"", spacingHorizontal:"", spacingVertical:"", labelWidth:"", labelHeight:""
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

