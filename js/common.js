
var Common = {
	init: function() {;
        Common.menu();
        Common.main();
	},

    menu: function() {
        $('.btn-mob').on('click',function(){
            $('.body').toggleClass('menu_open');
            $(this).toggleClass('menu_open');
        });
    },
    main: function() {
        $(function() {
            setTimeout(function() {
	           $('select').styler();
            }, 100)
        });
    },
    
};

$(function() {
	Common.init();
});