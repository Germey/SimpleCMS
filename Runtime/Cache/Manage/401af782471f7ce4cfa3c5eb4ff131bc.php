<?php if (!defined('THINK_PATH')) exit();?>

<div class="box-mask">
    <div class="modal-header">
        <a class="close" onclick="return X.boxClose();">×</a>
        <h4><?php echo ($title); ?></h4>
    </div>
    <div class="modal-body">


<form method="post" action="<?php echo U('content/submit_copy');?>" class="form-horizontal post_ajax_form">
    <input type="text" id="to_category_names" class="form-control input-sm" placeholder="请选择" value="" readonly="readonly" style="cursor: pointer;"/>
    <div id="category-select-wrapper">
      <input type="hidden" name="to_category_ids" id="to_category_ids" value="" />
      <div class="category-select"><?php echo content_category_select($category_tree, '',0, $category_id);?></div>
    </div>
    <input type="hidden" name="content_id" value="<?php echo ($content_id); ?>" />
</form>
<script type="text/javascript">
    $('#to_category_names').click(function(e){
        $("#category-select-wrapper").toggle();
    });

    // 初始化已经选择的
    var category_map = new Map();

    show_select_category();

    function select_category(category_id, category_name) {
        if(category_map.containsKey(category_id)) {
            category_map.remove(category_id);
            $("#"+category_id).removeClass('select');
        } else {
            category_map.put(category_id, category_name);
            $("#"+category_id).addClass('select');
        }
        show_select_category();
    }

    function show_select_category() {
        var ids = category_map.keys();
        var names = category_map.values();

        $("#to_category_ids").val(ids.join(','));
        $("#to_category_names").val(names.join(' '));
    }

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