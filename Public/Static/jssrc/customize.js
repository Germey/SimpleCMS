var WEB_ROOT = WEB_ROOT || '';
window.x_init_hook_validator = function() {
    jQuery('form.validator').each(function(){jQuery.fn.checkForm(this);});
};

window.x_init_hook_customize = function() {
    //Fix IE下Bootstrap显示
    $('input, textarea').placeholder();

    $('[title]').colorTip({color:'black'});
};

window.x_init_hook_click = function() {

    jQuery('a.ajaxlink').click(function() {
        if (jQuery(this).attr('no') == 'yes')
            return false;
        var link = jQuery(this).attr('href');
        var ask = jQuery(this).attr('ask');
        if (ask && !confirm(ask)) {
            return false;
        }
        X.get(jQuery(this).attr('href'));
        return false;
    });
    jQuery('a.remove').click(function(){
        var u = jQuery(this).attr('href');
        if (confirm('确定删除该条记录吗？')){X.get(u);}
        return false;
    });

};


var editor_map = new Map();
var ueditor;
window.x_init_hook_editor = function() {
    if(!UE) return;
    jQuery('textarea.editor').each(function(index, e){
        ueditor = UE.getEditor(jQuery(e).prop('id'));
        editor_map.put(jQuery(e).prop('id'), ueditor);
    });

    // TODO 宽度可以从标签中根据自定义属性读取，不必写死
    jQuery('textarea.simpleeditor').each(function(index, e) {
        var width = jQuery(e).width() + 10;
        ueditor = UE.getEditor(jQuery(e).prop('id'), {
            toolbars: [
            ['fullscreen', 'source', '|',
            'fontfamily', 'fontsize', 'bold', 'italic', 'underline', '|',
            'forecolor', 'insertorderedlist', 'insertunorderedlist', 'removeformat', '|',
            'justifyleft', 'justifycenter', 'link', 'unlink', 'inserttable', 'simpleupload',
            ]
            ],
            initialFrameWidth: width,
            initialStyle: 'p{line-height:1.5em;font-size:14px;font-family:微软雅黑;}',
        });

        editor_map.put(jQuery(e).prop('id'), ueditor);
    });
};


/* 根据数据index删除值 */
Array.prototype.remove = function(from, to) {
  var rest = this.slice((to || from) + 1 || this.length);
  this.length = from < 0 ? this.length + from : from;
  return this.push.apply(this, rest);
};

Array.prototype.indexOf = function (val) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] == val) {
            return i;
        }
    }
    return -1;
};


/* 根据值删除数组里面的值 */
Array.prototype.removevalue = function (val) {
    var index = this.indexOf(val);
    if (index > -1) {
        this.splice(index, 1);
    }
};