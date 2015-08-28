var X = {}; 
X.hook = function() {
    var pre_init_str = 'x_init_hook_';
    for ( var h in window ) {
        if ( 0 != h.indexOf(pre_init_str) )
            continue;
        var func = window[h];
        if ( typeof func == 'function' ) {
            try { func(); }catch(e){}
        }       
    }
};

X.get = function(u, is_sync) { return X.ajax(u, 'GET', is_sync); };
X.post = function(u, is_sync) { return X.ajax(u, 'POST', is_sync); };
X.ajax = function(u, method, is_sync) {
    if(!is_sync || is_sync == undefined) {
        is_sync = false;
    }
    var post_data = '';
    if('POST' == method) {
        //查找第一个问号，把Post信息摘出来
        var arr = u.split('?',2);
        u = arr[0];
        post_data = arr[1];
    }
    jQuery.ajax({
        url: u,
        dataType: "json",
        data: post_data,
        async: !is_sync,
        success: X.json,
        type : method
    });
    return false;
};

X.json = function(r) {

    if (X.onloading == true) {
        X.boxClose();
        X.onloading = false;
    };

    if (typeof(r) == 'undefined' || !r) {
        return;
    }

    var type = r['data']['type'];
    if (r['data']['data']) { // when type = refresh there is no data
        var data = r['data']['data'];
    }
    if ( type == 'alert' ) {
        alert(data);
    } else if ( type == 'eval' ) { 
        eval(data);
    } else if ( type == 'refresh') {
        window.location.reload();
    } else if ( type == 'redirect') {
        window.location.href = data;
    } else if ( type == 'updater' ) {
        var id = data['id'];
        var inner = data['html'];
        jQuery('#' + id).html(inner);
    } else if ( type == 'dialog' ) {
        X.boxShow(data, true);
    } else if ( type == 'mix' ) {
        for (var x in data) {
            r['data'] = data[x];
            X.json(r);
        }
    } else if ( type == 'replacer' ) {
        var id = data['id'];
        var inner = data['html'];
        jQuery('#' + id).replaceWith(inner);
    }
};

X.getXY = function() {
    var x,y;
    if(document.body.scrollTop){
        x = document.body.scrollLeft;
        y = document.body.scrollTop;
    }
    else{
        x = document.documentElement.scrollLeft;
        y = document.documentElement.scrollTop;
    }
    return {x:x,y:y};
};

var window_mask_id = "";
X.windowMask = function(display){
    if(display == "block"){
        var height = jQuery('body').height() + 'px';
        var width = jQuery(window).width() + 'px';
        var mask = $(document.createElement("div"));
        var timestamp = Date.parse(new Date());
        var mask_id = "mask_" + timestamp.toString() + timestamp.toString();
        mask.attr("id", mask_id);
        window_mask_id = mask_id;
        mask.css({'position':'absolute', 'z-index': 9999, 'width':width, 'height':height, 'filter':'alpha(opacity=0.5)', 'opacity':0.5, 'top':0, 'left':0, 'background':'#CCC'});
        $("body").append(mask);
        mask.css('display', 'block');
    }else{
        jQuery("#" + window_mask_id).replaceWith("");
    }
};

X.boxMask = function(display)
{
    var height = jQuery('body').height() + 'px';
    var width = jQuery(window).width() + 'px';
    jQuery('#modaldialog').css({'position':'absolute', 'z-index': 9000 + (boxList.length * 10)-1, 'width':width, 'height':height, 'filter':'alpha(opacity=0.5)', 'opacity':0.5, 'top':0, 'left':0, 'background':'#CCC', 'display':display});
};

var boxList = new Array();
X.boxShow = function(innerHTML, mask)
{ 
    // var dialog = jQuery('#dialog');

    //random dialog id
    var rand = parseInt(Math.random() * 1000);
    var timestamp = Date.parse(new Date());
    var dialog_id = "dialog_" + timestamp.toString() + timestamp.toString();
    var inner_dialog = $(document.createElement("div"));
    inner_dialog.attr("id", dialog_id);
    // inner_dialog.attr("class", "dialog");
    boxList.push(dialog_id);
    inner_dialog.html(innerHTML);
    setTimeout(function(){
        var ew = inner_dialog.width();
        var lt = (ww/2 - ew/2) + 'px';
        inner_dialog.css('left',lt);
    },0);
    $("body").append(inner_dialog);
    if (mask) { X.boxMask('block'); };
    var ww = jQuery(window).width();
    var wh = jQuery(window).height();
    var xy = X.getXY();
    var tp = (wh*0.15 + xy.y) + 'px';
    inner_dialog.css('top', tp);
    inner_dialog.css('position', "absolute");
    inner_dialog.css('z-index', 9000 + boxList.length * 10);
    inner_dialog.css('background-color', '#FFF');
    inner_dialog.css('display', 'block');

    return false;
};

X.boxClose = function()
{   
    var dialog_id = boxList.pop();
    jQuery("#" + dialog_id).remove();
    // jQuery('#dialog').html('').css('z-index', -9999);
    if(boxList.length == 0){
        X.boxMask('none');
    }else{
        jQuery('#modaldialog').css({'z-index': 9000 + (boxList.length * 10)-1});
    }
    return false;
};

/* 在弹出框中若需要validate，需手动调用此方法*/
function dialog_validator(){
    jQuery('form.dialog_validator').each(function(){
        jQuery.fn.checkForm(this);
    });
}

jQuery(document).ready(X.hook);