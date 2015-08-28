<?php if (!defined('THINK_PATH')) exit();?>

<div class="box-mask">
    <div class="modal-header">
        <a class="close" onclick="return X.boxClose();">×</a>
        <h4><?php echo ($title); ?></h4>
    </div>
    <div class="modal-body">

<?php $type_option = OptionArray(D('User')->managerRole(),'type','name'); $role_selected = $user ? $user['role'] : $manager_role; ?>

<form method="post" action="<?php echo U('user/submit_edit');?>" class="form-horizontal post_ajax_form">
    <table class="table table-noborder">
        <tr>
            <td class="item-label">类型</td>
            <td>
                <select class="form-control input-sm span2 type_choose" name="manager_role">
                    <?php echo select_option($type_option,$role_selected);?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="item-label">用户名</td>
            <td>
                <input type="text" value="<?php echo ($user['username']); ?>" name="username" class="form-control input-sm"  placeholder="请输入用户名" >
            </td>
        </tr>
        <?php if(!$user): ?><tr>
                <td class="item-label">密码</td>
                <td>
                    <input type="text" value="" name="password" class="form-control input-sm"  placeholder="请输入密码" >
                </td>
            </tr><?php endif; ?>
        <tr>
            <td class="item-label">邮箱</td>
            <td>
                <input type="text" value="<?php echo ($user['email']); ?>" name="email" class="form-control input-sm" placeholder="请输入邮箱">
            </td>
        </tr>
        <tr>
            <td class="item-label">栏目权限</td>
            <td>
                <div class="manage-display text-success" style="padding-top:6px;">全部栏目</div>
                <div class="edit-display">
                    <div class="list-cid">
                        <?php if(is_array($user['category_display'])): foreach($user['category_display'] as $key=>$one): ?><span cid='<?php echo ($key); ?>'><?php echo ($one); ?></span><?php endforeach; endif; ?>
                    </div>
                    <div style="position:relative;">
                        <div class="choose_category" >选择栏目<i style="float:right;margin-top:2px;" class="fa fa-caret-down"></i></div>
                        <div class="category-select" style="display:none;"><?php echo content_category_select($category, '',0, $category_id);?></div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <input type="hidden" name="id" value="<?php echo ($user_id); ?>" />
    <input id="cids" type="hidden" name="cids" value="<?php if($user[category_ids]): echo implode(',',$user[category_ids]); endif; ?>" />
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
<script type="text/javascript">
    <?php if($user['role'] == 'manager' || $manager_role == 'manager' ): ?>$('.edit-display').hide();
    <?php else: ?>
        $('.manage-display').hide();<?php endif; ?>
    $('.type_choose').change(function(){
        if($(this).val() == 'manager') {
            $('.manage-display').show();
            $('.edit-display').hide();
        }else {
            $('.edit-display').show();
            $('.manage-display').hide();
        }
    });

    $('.choose_category').click(function(event){
        if($('.category-select').css('display') == 'none'){
            $('.category-select').show();
        }else {
            $('.category-select').hide();
        }
        event.stopPropagation()
    })

    function select_category(id,name) {
        // var self =$('#'+id);
        // alert(self.html())
    }

    //下面是选择时候的js
    topArr = [];
    var listSpan = $('.list-cid span');
    $.each(listSpan,function(i,v){
        topArr.push($(this).attr('cid'));
    })

    $.each($('.category-select div'),function(i,v){
        if($.inArray($(this).attr('id'),topArr) != -1) {
            $(this).addClass('active');
        }
    })
    //批量选择或取消，如果有子栏目就一直往下找，找到最低级的子栏目都选上或取消
    $('.category-select div').click(function(){
        var self = $(this);
        var selfId  = self.attr('id');
        var selfPid = self.attr('pid');
        var arrBox = [];
        var child = $(".category-select div[pid="+selfId+"]");
  
        if(child.length) {
                $.each(child,function(i,v){
                    var childId = $(this).attr('id');
                    var childPid = $(this).attr('pid');
                    var grand = $(".category-select div[pid="+childId+"]");
                    if(grand.length) {
                        $.each(grand,function(i,v) {
                            arrBox.push($(this).attr('id'));
                        })
                    }else {
                        arrBox.push($(this).attr('id'));
                    }
                })
            }else {
                arrBox.push($(this).attr('id'));
        }

        // alert(arrBox)
        var status = false;
        $.each(arrBox,function(i,v){
            if(!$('.category-select div[id='+v+']').hasClass('active')) {
                status =true;
            }
            return;
        })

        if(status) {
            $.each(arrBox,function(i,v){
                var one = $('.category-select div[id='+v+']');
                one.addClass('active');
                if($.inArray(v,topArr) == -1){
                    topArr.push(v);
                }
            })
        }else {
            $.each(arrBox,function(i,v){
                var one = $('.category-select div[id='+v+']');
                one.removeClass('active');
                topArr.splice($.inArray(v,topArr),1);
            })
        }
        
        var list = '';
        $.each(topArr,function(i,v) {
            list+= "<span cid='"+v+"'>"+$('.category-select div[id='+v+']').text()+"</span>";
        })
        $('.list-cid').html(list);

        var ids = topArr.join(','); 
        $('#cids').val(ids);
    })

</script>