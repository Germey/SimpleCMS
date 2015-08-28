<?php if (!defined('THINK_PATH')) exit();?>

<div class="box-mask">
    <div class="modal-header">
        <a class="close" onclick="return X.boxClose();">×</a>
        <h4><?php echo ($title); ?></h4>
    </div>
    <div class="modal-body">

<?php  ?>
<form class="category_form" method="post" action="" class="form-horizontal post_ajax_form">
    <table class="table table-striped" >
            <thead>
                <tr>
                    <th>栏目名称</th>
                    <th>所属类型</th>
                    <th>菜单显示</th>
                </tr>
            </thead>
            <tbody class="content-tbody">
                <tr class="tr-content">
                    <td><input class="form-control" name="title[]" style="width:150px;" /></td>
                      <td>
                        <select class="form-control" style="width:80px;" name="type[]">
                            <?php if(is_array($model_fields['type']['options'])): foreach($model_fields['type']['options'] as $key=>$one): ?><option value="<?php echo ($key); ?>"><?php echo ($one); ?></option><?php endforeach; endif; ?>
                        </select>
                    </td>
                    <td>
                        <label class="switch switch-primary"><input class="is_menu" name="is_menu[]" type="checkbox" checked value=""><span></span></label>
                    </td>
                </tr>
            </tbody>
    </table>
    <input type="hidden" name="pid" value="<?php echo ($pid); ?>" />
</form>
<button type="button" class="btn btn-sm btn-primary" id="add-tr"><i class="hi hi-plus"></i> 添加</button>
<script type="text/javascript">
    $('#add-tr').click(function(){
        $('.tr-content').eq(0).clone().appendTo('.content-tbody');
    })
    $(function(){
        $('.modal-footer .btn').click(function(){
            var isMenu = $('.is_menu');
            $.each(isMenu,function(i,v) {
                $(this).val(i);
            })
            $('.category_form').attr('action','submit_batch_create').submit();
        })
    })
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