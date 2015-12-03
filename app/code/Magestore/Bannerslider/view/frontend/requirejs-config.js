var config = {
	map: {
		'*': {
			'magestore/note': 'Magestore_Bannerslider/js/jquery/slider/jquery-ads-note',
			'magestore/impress': 'Magestore_Bannerslider/js/report/impress',
			'magestore/clickbanner': 'Magestore_Bannerslider/js/report/clickbanner',
		},
	},
	paths: {
		'magestore/flexslider': 'Magestore_Bannerslider/js/jquery/slider/jquery-flexslider-min',
		'magestore/evolutionslider': 'Magestore_Bannerslider/js/jquery/slider/jquery-slider-min',
		'magestore/popup': 'Magestore_Bannerslider/js/jquery.bpopup.min',
	},
	shim: {
		'magestore/flexslider': {
			deps: ['jquery']
		},
		'magestore/evolutionslider': {
			deps: ['jquery']
		},
		'magestore/zebra-tooltips': {
			deps: ['jquery']
		},
	}
};
