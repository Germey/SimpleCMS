<?php
namespace Manage\Model;
use Think\Model;

class ExcelParserModel extends Model{

	protected $excelSheet = null;
    protected $rowIterator = null;
    protected $max_row = 2000; //最大处理行数

    //必须先执行一下init方法，传入file参数
	function init($file){
		$this->excelSheet = $this->_getPhpExcel($file);
        if(!$this->excelSheet){
            Session::Set("error", "文件损坏或格式错误");
            redirect("/import");
        }
		$this->rowIterator = $this->excelSheet->getRowIterator();
    }

    //这里获取的最大行数不一定准确，有时候有空行
    function getMaxRow(){
        $highest_row = $this->excelSheet->getHighestRow();
        //如果检测的最大高度还不到max_row,那就不用进行下面的检测了，省的下面还得把内容都读一遍。
        if($highest_row < $this->max_row){
            return $highest_row;
        }
        //通过循环获得最大行书，如果中间有空50行，就判定结束了
        $blank_count = 0;
        $total_number = 0;
        //如果比能够处理的最大的行数还多了50行，就不要处理了，否则遇到个20000个数据的excel，内存都消耗完了
        for ($i=0; $i < $highest_row && $i < $this->max_row + 50; $i++) {
            $row_one = $this->getRowIterator();
            $total_number = $total_number + 1;
            //删除数组空白元素
            $filtered_row = array_filter($row_one);
            if(empty($filtered_row)){
                $blank_count = $blank_count + 1;
            }else{
                $blank_count = 0;
            }
            if($blank_count >= 50){
                $total_number = $total_number - 50;
                break;
            }
        }
        // $native_hightstrow = $this->excelSheet->getHighestRow();
        $this->rowIterator->rewind();
        return $total_number;
    }

    //使用PhpExcel自带的轮询方法按顺序取出行记录
    //记录都trim过
    public function getRowIterator(){
        $row_one = $this->rowIterator->current();
        if(!$this->rowIterator->valid()){
            return null;
        }else{
            $cellIterator = $row_one->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
            $details = array();
            foreach ($cellIterator as $idx => $cell) {
                if($idx >= 100){
                    break;
                }
                if (!is_null($cell)) {
                    $value = $cell->getValue();
                    if($value!==''){
                        $details[$idx] = trim($cell->getValue());
                    }
                }
            }
            $this->rowIterator->next();
            return empty($details) ? null : $details;
        }
	}

	private function _getPhpExcel($file){
        Vendor('PHPExcel.PHPExcel');
        $type_match = array("xls" => "Excel5", "xlsx" => "Excel2007");

        /*
        重要代码 解决Thinkphp M、D方法不能调用的问题
        如果在thinkphp中遇到M 、D方法失效时就加入下面一句代码
        */
        // spl_autoload_register ( array ('Think', 'autoload' ) );
        $file_info = pathinfo($file);
        $extension = strtolower($file_info['extension']);

        //导入量比较大的时候，会出现out of memory，用gzip存储稍微减小一些内存使用量
        $cacheMethod = \PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( ' memoryCacheSize '  => '64MB' );
        \PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $objReader = \PHPExcel_IOFactory::createReader($type_match[$extension]);
        $objReader->setReadDataOnly(true);
        $objPHP = $objReader->load($file);
        $worksheet = $objPHP->getActiveSheet();
        return $worksheet;
    }
}