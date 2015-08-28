$(document).ready(
    function(){
        
    $(".post_ajax_form").submit(function() {
        var self = $(this);
        $.post(self.attr("action"), self.serialize(), form_submit_result, "json");
        return false;
    });

    $('.post_ajax_form')
        .ajaxStart(function(event) {
            $("button:submit").button('loading');
        })
        .ajaxStop(function(){
            $("button:submit").button('reset');
    });
});

function form_submit_result(data) {
    if(data.status) {
        if(data.url=='refresh') {
            display_noty(data.info, 'success');
            setTimeout("window.location.reload()", 2000);
        } else {
            display_noty(data.info + '  页面即将跳转...', 'success');
            setTimeout("window.location.href='"+data.url+"'", 2222);
        }
        // window.location.href = data.url;
    } else {
        display_noty(data.info);
        $("#captcha_img").click();
    }
}
