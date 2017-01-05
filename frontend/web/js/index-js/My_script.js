$(document).ready(function(){
    jQuery('.sidebar-menu .has-sub > a').click(function () {

        var last = jQuery('.has-sub.open', $('.sidebar-menu'));
        last.removeClass("open");
        jQuery('.arrow', last).removeClass("open");
        jQuery('.sub', last).slideUp(200);

        var thisElement = $(this);
        var slideOffeset = -200;
        var slideSpeed = 200;

        var sub = jQuery(this).next();
        if (sub.is(":visible")) {
            jQuery('.arrow', jQuery(this)).removeClass("open");
            jQuery(this).parent().removeClass("open");
            sub.slideUp(slideSpeed, function () {
                if ($('#sidebar').hasClass('sidebar-fixed') == false) {
                    scrollTo(thisElement, slideOffeset);
                }
                handleSidebarAndContentHeight();
            });
        } else {
            jQuery('.arrow', jQuery(this)).addClass("open");
            jQuery(this).parent().addClass("open");
            sub.slideDown(slideSpeed, function () {
                if ($('#sidebar').hasClass('sidebar-fixed') == false) {
                    scrollTo(thisElement, slideOffeset);
                }
                handleSidebarAndContentHeight();
            });
        }
    });
    jQuery('.sidebar-menu .has-sub .sub .has-sub-sub > a').click(function () {
        var last = jQuery('.has-sub-sub.open', $('.sidebar-menu'));
        last.removeClass("open");
        jQuery('.arrow', last).removeClass("open");
        jQuery('.sub', last).slideUp(200);

        var sub = jQuery(this).next();
        if (sub.is(":visible")) {
            jQuery('.arrow', jQuery(this)).removeClass("open");
            jQuery(this).parent().removeClass("open");
            sub.slideUp(200);
        } else {
            jQuery('.arrow', jQuery(this)).addClass("open");
            jQuery(this).parent().addClass("open");
            sub.slideDown(200);
        }
    });
});

function handleSidebarAndContentHeight() {
    var content = $('#content');
    var sidebar = $('#sidebar');
    var body = $('body');
    var height;

    if (body.hasClass('sidebar-fixed')) {
        height = $(window).height() - $('#header').height() + 1;
    } else {
        height = sidebar.height() + 20;
    }
    if (height >= content.height()) {
        content.attr('style', 'min-height:' + height + 'px !important');
    }
}
function scrollTo(el, offeset) {
    pos = (el && el.size() > 0) ? el.offset().top : 0;
    jQuery('html,body').animate({
        scrollTop: pos + (offeset ? offeset : 0)
    }, 'slow');
}
function  scrollTop() {
    scrollTo();
}


$(document).ready(function(){
//--日期和时间选择框----
var start = {
    format: 'YYYY-MM-DD hh:mm:ss',
    minDate: '2014-06-16 23:59:59', //设定最小日期为当前日期
    festival:true,
    //isinitVal:true,
    maxDate: $.nowDate(0), //最大日期
    choosefun: function(elem,datas){
        end.minDate = datas; //开始日选好后，重置结束日的最小日期
    }
};
var end = {
    format: 'YYYY年MM月DD日 hh:mm:ss',
    minDate: $.nowDate(0), //设定最小日期为当前日期
    festival:true,
    //isinitVal:true,
    maxDate: '2099-06-16 23:59:59', //最大日期
    choosefun: function(elem,datas){
        start.maxDate = datas; //将结束日的初始值设定为开始日的最大日期
    }
};
$("#inpstart").jeDate(start);
$("#inpend").jeDate(end);


$("#date01").jeDate({
    isinitVal:true,
    festival:true,
    ishmsVal:false,
    minDate: '2016-06-16 23:59:59',
    maxDate: $.nowDate(0),
    format:"YYYY-MM-DD hh:mm:ss",
    zIndex:3000,
})
$("#date02").jeDate({
    isinitVal:true,
    festival:true,
    ishmsVal:false,
    minDate: '2016-06-16 23:59:59',
    maxDate: $.nowDate(0),
    format:"YYYY-MM-DD hh:mm",
    zIndex:3000,
})
$("#date03").jeDate({
    isinitVal:true,
    festival:true,
    ishmsVal:false,
    minDate: '2016-06-16 23:59:59',
    maxDate: $.nowDate(0),
    format:"YYYY-MM-DD",
    zIndex:3000,
})
$("#date04").jeDate({
    isinitVal:true,
    festival:true,
    ishmsVal:false,
    minDate: '2016-06-16 23:59:59',
    maxDate: $.nowDate(0),
    format:"YYYY-MM",
    zIndex:3000,
})
$("#date05").jeDate({
    isinitVal:true,
    festival:true,
    ishmsVal:false,
    minDate: '2016-06-16 23:59:59',
    maxDate: $.nowDate(0),
    format:"hh:mm:ss",
    zIndex:3000,
})
})



function testShow(elem){
    $.jeDate(elem,{
        insTrigger:false,
        isinitVal:true,
        festival:true,
        ishmsVal:false,
        minDate: '2016-06-16 23:59:59',
        maxDate: $.nowDate(0),
        format:"hh:mm",
        zIndex:3000,
    })
}

