<?php
namespace Home\Model;
use Think\Model;

class PictureMappingModel extends Model {

    public function getMapping($object_id, $object_type='content', $size) {
        if(!$object_type || !$object_id) return;

        $sql = "select * from jxdrcms_picture_mapping g, jxdrcms_picture p where g.picture_id=p.id and g.object_id=$object_id and g.object_type='$object_type' order by sequence";

        $size = intval($size);
        if($size) {
            $sql .= " limit 0, " . $size;
        }
        return $this->query($sql, false);
    }

    /**
     * 文件上传
     * @param  array  $files   要上传的文件列表（通常是$_FILES数组）
     * @param  array  $setting 文件上传配置
     * @param  string $driver  上传驱动名称
     * @param  array  $config  上传驱动配置
     * @return array           文件上传成功后的信息
     */
    public function upload($files, $setting, $driver = 'Local', $config = null){
        
        $setting['callback'] = array($this, 'isFile');
        $setting['removeTrash'] = array($this, 'removeTrash');
        $Upload = new Upload($setting, $driver, $config);
        $info   = $Upload->upload($files);

        if($info){ //文件上传成功，记录文件信息
            foreach ($info as $key => &$value) {
                /* 已经存在文件记录 */
                if(isset($value['id']) && is_numeric($value['id'])){
                    continue;
                }

                /* 记录文件信息 */
                $value['path'] = substr($setting['rootPath'], 1).$value['savepath'].$value['savename']; //在模板里的url路径

                if($this->create($value) && ($id = $this->add())){
                    $value['id'] = $id;
                }
                 // else {
                //     //TODO: 文件上传成功，但是记录文件信息失败，需记录日志
                //     unset($info[$key]);
                // }
            }
            return $info; //文件上传成功
        } else {
            $this->error = $Upload->getError();
            return false;
        }
    }

    public function updateMapping($object_id, $object_type='content', $picture_info) {
        if(!$object_id) return;

        $filter['object_id'] = $object_id;
        $filter['object_type'] = $object_type;
        M("PictureMapping")->where($filter)->delete();

        foreach ($picture_info as $pid => $info) {
            $data['object_id'] = $object_id;
            $data['object_type'] = $object_type;
            $data['picture_id'] = $pid;
            $data['title'] = $info['title'];
            $data['summary'] = $info['summary'];
            $data['link'] = $info['link'];
            $data['sequence'] = ++$seq;
            M("PictureMapping")->add($data);
        }
    }

}