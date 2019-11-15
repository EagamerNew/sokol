
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
	           $('input').filter('[type=date]').datepicker({
                   // showOn:"button",
                   monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                   dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                   beforeShow: function (textbox, instance) {
                       $('#datepicker').append($('#ui-datepicker-div')).addClass('active');
                   }
               });
            }, 100);

        });
    },
    
};

$(function() {
	Common.init();
});