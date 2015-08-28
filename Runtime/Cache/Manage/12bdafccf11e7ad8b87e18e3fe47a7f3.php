<?php if (!defined('THINK_PATH')) exit();?>

<div class="box-mask">
    <div class="modal-header">
        <a class="close" onclick="return X.boxClose();">×</a>
        <h4><?php echo ($title); ?></h4>
    </div>
    <div class="modal-body">


<form method="post" action="<?php echo U('user/submit_profile');?>" class="form-horizontal post_ajax_form">
    <input type="hidden" name="id" value="<?php echo ($user['id']); ?>" />
    <table class="table table-noborder">
        <tr>
            <td class="item-label"><span class="text-danger">*</span>&nbsp;用户名</td>
            <td><input type="text" value="<?php echo ($user['username']); ?>" name="username" class="span6 form-control input-sm"></td>
        </tr>
        <tr>
            <td class="item-label"><span class="text-danger">*</span>&nbsp;新密码</td>
            <td><input type="password" name="password" id="password" class="span6 form-control input-sm"></td>
        </tr>
        <tr>
            <td class="item-label"><span class="text-danger">*</span>&nbsp;确认新密码</td>
            <td><input type="password" name="password2" id="password2" class="span6 form-control input-sm"></td>
        </tr>
    </table>
</form>

<script type="text/javascript">
    $("#password2").blur(function() {
        if($("#password2").val() !== $("#password").val()) {
            display_noty('两次密码不一致');
        }
    });

</script>

    </div>
    <div class="modal-footer">
        <a href="javascript:void(0)" onclick="box_submit_form();" class="btn btn-sm btn-primary">
            <i class="fa fa-angle-right"></i>
            <?php if(empty($confirm_button_display)): ?>提交<?php else: echo ($confirm_button_display); endif; ?>
        </a>
        <a style="margin-left:5px" href="#" onclick="return X.boxClose();">取消</a>
    </div>
</div>
<script type="text/javascript">
    function box_submit_form(){
        $(".modal-body form:first").submit();
    }
</script>