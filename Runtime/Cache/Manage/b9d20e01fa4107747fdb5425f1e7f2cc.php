<?php if (!defined('THINK_PATH')) exit();?>

<div class="box-mask">
    <div class="modal-header">
        <a class="close" onclick="return X.boxClose();">×</a>
        <h4><?php echo ($title); ?></h4>
    </div>
    <div class="modal-body">


<form method="post" action="<?php echo U('banner/submit_edit');?>" class="form-horizontal post_ajax_form">
    <table class="table table-noborder">
        <tr>
            <td class="item-label">显示名称</td>
            <td><input type="text" value="<?php echo ($banner['title']); ?>" name="title" class="form-control input-sm"></td>
        </tr>
        <tr>
            <td class="item-label">读取关键字(英文)</td>
            <td>
                <input type="text" value="<?php echo ($banner['name']); ?>" name="name" class="form-control input-sm" placeholder="仅限英文和下划线">
            </td>
        </tr>
        <tr>
            <td class="item-label">描述</td>
            <td><textarea name="description" class="form-control input-sm" rows="3"><?php echo ($banner['description']); ?></textarea></td>
        </tr>
    </table>
    <input type="hidden" name="id" value="<?php echo ($banner['id']); ?>" />
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