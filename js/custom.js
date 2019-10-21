$(document).ready(function () {
    localStorage.setItem('loginPage', '#step1')

    if (localStorage.getItem("formName") === null) {
        $('#step1').addClass('active');
    }
    else if (localStorage.getItem("currentStep") === '#reg-step1') {
        $('.steps').hide();
        $('#registration-form').fadeIn()
        $('.form-step').html('Шаг <span class="violet">1</span> из 3');
        $('#reg-step1').fadeIn()
        $(localStorage.setItem('#reg-step2'));
    }
    else if (localStorage.getItem("currentStep") === '#reg-step2') {
        $('.steps').hide();
        $('#registration-form').fadeIn()
        $('.form-step').html('Шаг <span class="violet">2</span> из 3');
        $('#reg-step2').fadeIn()
        $(localStorage.removeItem('nextStep'));
    }
    else if (localStorage.getItem("currentStep") === '#reg-step3') {
        $('.steps').hide();
        $('#registration-form').fadeIn()
        $('.form-step').html('Шаг <span class="violet">3</span> из 3');
        $('#reg-step3').fadeIn()
        $(localStorage.removeItem('nextStep'));
    }
    else {
        $('.steps').hide();
        var current = localStorage.getItem('formName');
        var currentStep = localStorage.getItem('nextStep');
        var prevStep = localStorage.getItem('prevStep');
        $(current).fadeIn();
        $(prevStep).hide();
        $(currentStep).fadeIn();
    }
})
var currentStep = localStorage.getItem('nextStep');
var prevStep = localStorage.getItem('prevStep');
function showRegistration() {
    if ($('#step1').is(':hidden')) {
        $('#registration-form').fadeIn();
    }
}

$('button').on('click', function () {
    objectId = $(this).attr('data-id')
    localStorage.setItem('formName', '#' + objectId);
})
$('button[type="submit"').on('click', function(){
    localStorage.removeItem('formName');
    localStorage.removeItem('prevStep');
    localStorage.removeItem('nextStep');
    localStorage.removeItem('loginPage');
    localStorage.removeItem('currentStep');
})
$('.registration').on('click', function () {
    $('#step1').hide();
    setTimeout(showRegistration, 500);
    localStorage.setItem('nextStep', '#reg-step1')
    $(localStorage.getItem('nextStep')).show();
    $('.form-step').html('Шаг <span class="violet">' + count + '</span> из 3');
})
function Steps() {
    if (localStorage.getItem("currentStep") === '#reg-step1') {
        $('.form-step').html('Шаг <span class="violet">1</span> из 3');
    }
    else if (localStorage.getItem("currentStep") === '#reg-step2') {

        $('.form-step').html('Шаг <span class="violet">2</span> из 3');
    }
    else if (localStorage.getItem("currentStep") === '#reg-step3') {
        $('.form-step').html('Шаг <span class="violet">3</span> из 3');
    }
}
$('.back').on('click', function () {
    objectId = $(this).attr('data-id');
    $('.steps').hide();

    localStorage.setItem('currentStep', '#' + objectId);
    $('.form-step').html('Шаг <span class="violet">1</span> из 3');

    if (objectId == 'step1') {
        $(localStorage.getItem('loginPage')).fadeIn();
        localStorage.removeItem('formName');
    } else if (objectId == 'reg-step1') {

        $(localStorage.getItem('formName')).fadeIn();
        $('#reg-step1').fadeIn()
        $('#reg-step2').fadeOut()
    }
    else if (objectId == 'reg-step2') {
        Steps()
        $(localStorage.getItem('formName')).fadeIn();
        $('#reg-step2').fadeIn()
        $('#reg-step3').fadeOut()
        $(localStorage.getItem('nextStep')).hide();
        $(localStorage.removeItem('prevStep'));
        $(localStorage.setItem('nextStep', '#reg-step2'));
        $(localStorage.setItem('nextStep', '#reg-step3'));

    }
})

$(document).ready(function () {
    objectId = $(this).attr('data-id');
    if (objectId == 'step1') {
    }
    else {
        if (localStorage.getItem("count") === null) {
            Steps()
        } else {

            Steps()
        }
    }

});

$('.next').on('click', function () {

    var next = $(this).parent().parent().next().prop('id');
    var current = $(this).parent().parent().prop('id');
    var isFormValid = true;


    function setValid() {
        $("#" + current + " input").each(function () {
            if ($.trim($(this).val()).length == 0) {
                $(this).addClass("highlight");
                var highlight = $('.highlight').eq(0);
                isFormValid = false;
                highlight.focus();
            }
            else {
                isFormValid = true;
            }
            return
        });
    }
    setValid();
    function showSecond() {
        if ($("#" + current).is(':hidden')) {
            $("#" + next).fadeIn()
        }
    }



    if (isFormValid) {
        $("#" + current + " input").removeClass("highlight");
        if (isFormValid !== false) {
            $("#" + current).hide();
            setTimeout(showSecond, 500);


            objectId = $(this).attr('data-id')


            localStorage.setItem('prevStep', '#' + current);
            localStorage.setItem('currentStep', '#' + next);
            Steps()
        }
    }



});

(($) => {

    class Toggle {

        constructor(element, options) {

            this.defaults = {
                icon: 'fa-eye'
            };

            this.options = this.assignOptions(options);

            this.$element = element;
            this.$button = $(`<span class="btn-toggle-pass"><i class="fa ${this.options.icon}"></i></span>`);

            this.init();
        };

        assignOptions(options) {

            return $.extend({}, this.defaults, options);
        }

        init() {

            this._appendButton();
            this.bindEvents();
        }

        _appendButton() {
            this.$element.after(this.$button);
        }

        bindEvents() {

            this.$button.on('click touchstart', this.handleClick.bind(this));
        }

        handleClick() {

            let type = this.$element.prop('type');

            type = type === 'password' ? 'text' : 'password';

            this.$element.prop('type', type);
            this.$button.toggleClass('active');
        }
    }

    $.fn.togglePassword = function (options) {
        return this.each(function () {
            new Toggle($(this), options);
        });
    }

})(jQuery);

$(document).ready(function () {
    $('#password').togglePassword({
        'icon': 'fa-eye-slash'
    });
})

// Get  files params
function getFileParam() {
    try {
        var file = document.getElementById('uploaded-file1').files[0];
        if (file) {
            var fileSize = 0;

            if (file.size > 1024 * 1024) {
                fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
            } else {
                fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
            }

            document.getElementById('file-name1').innerHTML = 'Имя файла: <br>' + file.name;

        }


    } catch (e) {
        var file = document.getElementById('uploaded-file1').value;
        file = file.replace(/\\/g, "/").split('/').pop();
        document.getElementById('file-name1').innerHTML = 'Файл: <br>' + file;
    }
}
function getFileParam2() {
    try {
        var file2 = document.getElementById('uploaded-file2').files[0];
        if (file2) {
            var fileSize = 0;

            if (file2.size > 1024 * 1024) {
                fileSize = (Math.round(file2.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
            } else {
                fileSize = (Math.round(file2.size * 100 / 1024) / 100).toString() + 'KB';
            }

            document.getElementById('file-name2').innerHTML = 'Имя файла: <br>' + file2.name;


        }
    }
    catch (e) {
        var file2 = document.getElementById('uploaded-file2').value;
        file2 = file2.replace(/\\/g, "/").split('/').pop();
        document.getElementById('file-name2').innerHTML = 'Файл: <br>' + file2;
    }
}
function getFileParam3() {
    try {
        var file3 = document.getElementById('uploaded-file3').files[0];
        if (file3) {
            var fileSize = 0;

            if (file3.size > 1024 * 1024) {
                fileSize = (Math.round(file3.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
            } else {
                fileSize = (Math.round(file3.size * 100 / 1024) / 100).toString() + 'KB';
            }

            document.getElementById('file-name3').innerHTML = 'Имя файла: <br>' + file3.name;


        }
    }
    catch (e) {
        var file3 = document.getElementById('uploaded-file2').value;
        file3 = file3.replace(/\\/g, "/").split('/').pop();
        document.getElementById('file-name2').innerHTML = 'Файл: <br>' + file3;
    }
}
$("#datepicker").datepicker({
    // showOn:"button",
    monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
    dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
    beforeShow: function (textbox, instance) {
        $('.datepicker').append($('#ui-datepicker-div')).addClass('active');
    }
});
$(".custom-select").selectmenu({ placeholder: 'Select a speed' });
