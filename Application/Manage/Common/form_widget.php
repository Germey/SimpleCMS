<?php

// from to可以依次显示部分items，便于中间插入某个不规则的item
function display_all_items($all_items, $array_value, $from, $to) {
    foreach($all_items as $k => $v) {
        // 不显示在这里的 if
        // from - to
        if($v['edit_hide']) {
            continue;
        }
        form_block($k, $v, $array_value[$k]);
    }
}

function form_block($name, $item, $value) {

    if(!$name || !$item) {
        return;
    }

    if(!isset($value) && $item['default_value']) {
        $value = $item['default_value'];
    }

    if($item['hidden']) {
        $tr_class = 'class="myhide"';
    }

    $title = $item['title'];
    if($item['required']) {
        $title = '<span class="text-danger">*</span>&nbsp;' . $title;
    }

    $html .= "<tr id='tr{$name}' {$tr_class}>";
    $html .= "<td class='item-label'>{$title}</td><td>";
    if($item['type'] == 'group') {
        $html .= form_group_edit($name, '', $item['param']['options'], $value, $item['param']['placeholder']);
    } else {
        $html .= form_item($name, $value, $item);
    }

    $html .= "</td>";
    $html .= "</tr>";

    echo $html;
}

function form_item($name, $value, $item) {
    $type = $item['type'];
    if(!$type) {
        $type = 'string';
    }

    $default_class = array(
            'textarea' => 'span6',
            'select' => 'span1',
            'date' => 'span1 datetime',
            'datetime' => 'span1 datetime',
            'number' => 'span1',
            'file' => '',
            // 'image' => '',
            'radio' => '',
            'checkbox' => '',
            'string' => 'span6',
        );

    $class = $item['class'];
    if(!$class) {
        $class = $default_class[$type];
    }
    if($item['class'] !== 'editor' && $item['type'] != 'checkbox') {
        $class .= ' form-control input-sm';
    }

    if($item['disabled']) {
        $attr_string = "disabled='disabled' ";
        $class .= ' disabled';
    } else if($item['type'] == 'checkbox'){
         $name = "name='".$name."[]'";
    } else {
        $attr_string = "id='$name' name='$name'";
    }

    if(is_null($value) && $item['default']) {
        $value = $item['default'];
    }

    if($type !== "textarea" && $type !== "checkbox" && $value) {
        $attr_string .= " value='$value'";
    }

    $attr_string .= " class='$class'  " . gen_extra_attribute($item['extra_attribute']);

    if($item['placeholder']) {
        $attr_string .= " placeholder='{$item['placeholder']}'";
    }

    if($type == "textarea") {
        $html = form_textarea($attr_string, $value);
    } else if($type == "select") {
        $html = form_select($attr_string, $value, $item['options']);
    } else if($type == 'checkbox') {
        if(unserialize($value) !== false) {
            $value = unserialize($value);
        }
        $html = form_checkbox($name, $value, $class, $item['options']);
    } else if($type == "date") {
        $html = form_date($attr_string, $value);
    } else if($type == "datetime") {
        $html = form_date($attr_string, $value, 'yyyy-mm-dd hh:ii');
    } else if($type == "number") {
        $html = form_number($attr_string, $value, $param);
    } else if($type == "file") {
        $html = form_file($name, $class, $value, $param);
    } else if($type == "radio") {
        $html = form_radio($name, $class, $value, $item);
    } else if($type == "image") {
        $html = form_image_upload($name, $value, $item['placeholder']);
    } else if($type == "gallery") {
        $html = form_gallery($name, $value);
    } else if($type == "address") {
        $html = form_address($name, $value);
    } else {
        $html = form_text($attr_string, $value);
    }

    if($item['append_tip']) {
        $html .= '<span class="text-muted">&nbsp;' . $item['append_tip'] . '</span>';
    }

    if($item['extra_html']) {
        $html .=  '&nbsp;&nbsp;'  . $item['extra_html'];
    }

    return $html;
}

function gen_extra_attribute($extra_attribute) {
    $str = '';
    if ($extra_attribute) {
        foreach ($extra_attribute as $key => $property) {
            $str .= ' ' . $key . '=' . $property;
        }
    }
    return $str;
}

function form_checkbox($name='cb', $value='', $class=null, $param) {
    $cbox = null;
    if(is_string($value)) $value = preg_split('/[\s,]+/', $value, -1, PREG_SPLIT_NO_EMPTY);
    settype($value, 'array');
    foreach($param AS $key=>$option) {
        if (is_array($option)) {
            $key = strval($option['id']);
            $option = strval($option['name']);
        }
        $checked = in_array($option, $value) ? 'checked' : null;
        $readonly = $class=='fix'?'onclick="return false;"':null;
        $checked = $class=='fix'?'checked':$checked;
        $cbox .= "<label class='inline radio_label {$class}'><input type='checkbox' {$name} value='{$option}' {$checked} {$readonly} />&nbsp;{$option}</label>";
    }
    return $cbox;
}

function form_file($name, $class, $value, $param) {
    $html .= "<input $class >";
    if ($param["sub_class"] || $param["sub_content"]) {
        $html .= "<span class='{$param["sub_class"]}'>{$param["sub_content"]}</span>";   //extra_desc
    }
    if ($param['show_img']) {
        $html .= "<p class='show_img'><img src='{$param['show_img']}'/></p>";
    }
    return $html;
}

function form_gallery() {
    // 在html中写了，内容比较多
}

function form_textarea($class, $value) {

    $html .= "<textarea $class rows=3>";
    $html .= $value;
    $html .= "</textarea>";

    return $html;
}

function form_select($class, $value, $options) {

    $html .= "<select $class >";
    $html .= select_option($options, $value);
    $html .="</select>";

    return $html;
}

function form_text($attr_string, $value) {
    $html = "<input type='text' value='{$value}'  $attr_string />";
    return $html;
}

function form_number($class, $value, $param) {

    $html .="<input type='number' $class' value='{$value}' />";
    return $html;
}

function form_date($attr_string, $value, $format) {
    if(!$format) {
        $format = 'yyyy-mm-dd';
    }

    $date = '';
    if($value) {
        $date = substr($value,0, strlen($format));
    }

    $html .= "<input type='text' data-datepicker-format='{$format}' data-datepicker-nodefault='-' value='{$date}'  $attr_string />";
    return $html;
}



function form_address($name, $value) {
    // TODO 样式待调，最好是下拉的,不方便放到这里，就直接写到HTML里面
    if(!is_array($value)) {
        $value = explode('///', $value);
    }

    $html = '<div class="span7">
                <div class="input-group">
                <span class="input-group-addon">省/直辖市</span>
                <input type="text" name="address[]" class="form-control input-sm" value="'.$value[0].'">
                <span class="input-group-addon">地级市</span>
                <input type="text" name="address[]" class="form-control input-sm" value="'.$value[1].'">
                <span class="input-group-addon">地址</span>
                <input type="text" name="address[]" class="form-control input-sm" value="'.$value[2].'">
                </div></div>';
    // $html = "<input type='text' value='{$value}'  $attr_string />";
    return $html;
}

function form_latlng() {
   // 在html中
}

function form_group_edit($key,$label_name, $options, $value, $placeholder) {
    $table = '<table style="margin-bottom:5px" class="table table-noborder" id="group_new_table_'.$key.'"><thead><tr>';
    foreach ($options as $k => $v) {
        $table .= '<th>'.$v['name'].'</th>';
    }
    $table .= '</thead></tr>';

    $name_prefix = $key . '_group_';

    // $vs = unserialize($value);
    foreach ($value as $v) {
        $table .= '<tr>';
        foreach ($options as $ok => $ov) {
            if($ov['type']=='select') {
                $table .= '<td>'. group_edit_select($name_prefix . $ok, $v[$ok], $ov['class'], $ov['options']) .'</td>';
            } else if($ov['type'] == 'textarea') {
                $table .= '<td>'. group_edit_textarea($name_prefix . $ok, $v[$ok], $ov['class']) .'</td>';
            } else {
                $table .= '<td>'. group_edit_input($name_prefix . $ok, $v[$ok], $ov['class']) .'</td>';
            }
        }
        $table .= '</tr>';
    }

    $table .= '<tr id="group_new_line_'. $key .'">';
    foreach ($options as $k => $v) {
        if($v['type']=='select') {
            $table .= '<td>'. group_edit_select($name_prefix . $k, '', $v['class'], $v['options']) .'</td>';
        }  else if($v['type'] == 'textarea') {
            $table .= '<td>'. group_edit_textarea($name_prefix . $k,'', $v['class']) .'</td>';
        } else {
            $table .= '<td>'. group_edit_input($name_prefix . $k,'', $v['class']) .'</td>';
        }
    }

    $table .= '</tr></table>';
    $table .= '<p><a href="javascript:void(0);" onclick="add_group_line(\''.$key.'\')">增加新记录</a>&nbsp;&nbsp;<span class="muted">（若要删除某行，将该行的每个输入框清空即可）</span></p>';

    $str .= '<div class="muted">'. $placeholder .'</div>';
    $str .= '<div class="control-group">';
    $str .= '<label class="control-label">' . $label_name . '</label>';
    $str .= '<div class="controls">';
    $str .= $table;
    $str .= '</div></div>';

    return $str;
}

function group_edit_input($name, $value, $class) {
    return '<input type="text" class="'.$class.'" name="'. $name .'[]" value="'.$value.'"/>';
}

function group_edit_select($name, $value, $class, $options) {
    return '<select type="text" class="'.$class.'" name="'. $name .'[]" />'.Utility::Option($options,$value).'</select>';
}

function group_edit_textarea($name, $value, $class) {
    return '<textarea type="text" class="'.$class.'" name="'. $name .'[]" >'. $value .'</textarea>';
}

function form_radio($name, $class, $value, $param) {
	if(strpos($name,'extend') !== false) {
		// 如果是扩展  就把value赋值给key
		foreach($param['options'] as $extend_key=>$extend_value){
			$extend_options[$extend_value] = $extend_value;
		}
		$param['options'] = $extend_options;
	}
    if(is_null($value)) {
        if($param['default']) {
            $value = $param['default'];
        } else {
            // 默认第一个选中
            $keys = $param['options'];
            $value = $keys[0];
        }
    }

    foreach ($param['options'] as $v => $display) {
        //找到了match或者到了最后一个radio
        if($value == $v) {
            $checked = "checked";
        } else {
            $checked = "";
        }

        $html .= "<label class='inline radio_label {$param['class']}'>";
        $html .= "<input type='radio' $checked name='$name' value='$v'/>$display";
        $html .= "</label>";
    }

    return $html;
}

function display_group($value, $options) {
    // $value = unserialize($value);

    $table = '<table class="table table-bordered"><thead><tr>';
    foreach ($options as $ok => $ov) {
        $table .= '<th>'.$ov['name'].'</th>';
    }
    $table .= '</thead></tr>';

    foreach ($value as $v) {
        $table .= '<tr>';
        foreach ($options as $ok => $ov) {
            $wrap="";
            if(strlen($v[$ok]) < 20) {
                $wrap = 'nowrap';
            }
            $table .= '<td '. $wrap .'>'.nl2br($v[$ok]).'</td>';
        }
        $table .= '</tr>';
    }
    $table .= '</table>';

    return $table;
}


// function post_block($name, $form_items, $value) {
//     $item = $form_items[$name];
//     if($item) {
//         if ($item['param']['style']) {
//             $html .= "<div class='small_wrap'  style='{$item['param']['style']}'><div class='{$item['div_class']}'>";
//         } else  {
//             $html .= "<div class='small_wrap'><div class='{$item['div_class']}'>";
//         }
//         $html .= "<label class='inline_label' for='$name'>{$item['display']}</label>";
//         $html .= form_item($name, $item['type'], $item['class'], $value, $item['param']);
//         $html .= "</div>";
//         $html .= '</div>';
//     }
//     echo $html;
// }

function genereate_view_element( $name, $basic_fields, $register, $col=1, $colspan = true, $tall = true) {
        $width = 200;
        if ($name != '') {

            $html .= '<td  width="120"><div class="title">';
            $html .= $basic_fields[$name]['view_name']?$basic_fields[$name]['view_name']:$basic_fields[$name]['display'];
            $html .= '</div></td>';
        }
        // $content_class = $basic_fields[$name]['colspan'] || ($basic_fields[$name]['type']) ? "long_content" : "content";
        if ($col > 1 && $colspan == true && $tall == true) {
            $height = 120;
            $style='vertical-align:top;';
        }
        $html .= "<td width='$width' colspan='$col' style='$style' height='$height'><div class='value'>";
        $html .= $register;
        $html .= '</div></td>';
        echo $html;
}

function display_table_header($items) {
    $options = $items['options'];
    foreach ($options as $key => $option) {
        $html .= '<td>';
        $html .= $option['name'];
        $html .= '</td>';
    }
    echo $html;
}

function display_table_tr($values, $items) {

    foreach ($values as $value) {
        $html .="<tr>";
        foreach ($items['options'] as $key => $option) {
            $html .= '<td>';
            $html .= $value[$key];
            $html .= '</td>';
        }
        $html .="</tr>";
    }
    echo $html;

}
