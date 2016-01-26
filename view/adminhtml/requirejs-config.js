var config = {
    map: {
        '*': {
            'magestore/note': 'Magestore_Bannerslider/js/jquery/slider/jquery-ads-note',
        },
    },
    paths: {
        'magestore/flexslider': 'Magestore_Bannerslider/js/jquery/slider/jquery-flexslider-min',
        'magestore/evolutionslider': 'Magestore_Bannerslider/js/jquery/slider/jquery-slider-min',
        'magestore/zebra-tooltips': 'Magestore_Bannerslider/js/jquery/ui/zebra-tooltips',
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
