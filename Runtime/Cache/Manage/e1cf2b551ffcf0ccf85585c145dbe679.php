<?php if (!defined('THINK_PATH')) exit();?>

<div class="box-mask">
    <div class="modal-header">
        <a class="close" onclick="return X.boxClose();">×</a>
        <h4><?php echo ($title); ?></h4>
    </div>
    <div class="modal-body">


<form method="post" action="<?php echo U('extend/submit_edit');?>" class="form-horizontal post_ajax_form">
    <table class="table table-noborder">
        <tr>
            <td class="item-label">方案名称</td>
            <td><input type="text" value="<?php echo ($extend['title']); ?>" name="title" class="form-control input-sm"></td>
        </tr>
        <tr>
            <td class="item-label">方案描述</td>
            <td><textarea name="description" class="form-control input-sm" rows="3"><?php echo ($extend['description']); ?></textarea></td>
        </tr>
    </table>
    <input type="hidden" name="id" value="<?php echo ($extend['id']); ?>" />
</form>

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