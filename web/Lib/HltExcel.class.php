<?php
 include_once 'Classes/PHPExcel.php';
 include_once 'Classes/PHPExcel/Writer/Excel2007.php';
 include_once 'Classes/PHPExcel/Writer/Excel5.php';
 include_once 'Classes/PHPExcel/Reader/Excel2007.php';
 include_once 'Classes/PHPExcel/Reader/Excel5.php';
 set_time_limit(0);
 ini_set('memory_limit','256M');
 class HltExcel
 {
 	//列配置 自动生成
 	public  $_colArr=NULL;
 	//最大行数
 	private  $_maxRow=NULL;
 	//最大列数
 	private  $_maxCol=NULL;
 	private  $_excelType=NULL;
 	private  $_confArr=array('header'=>array('size'=>12,'color'=>'000000','border_color'=>'333333'),'cell'=>array('size'=>11,'color'=>'000000','border_color'=>'333333'));
 	/**
 	 *构造函数
 	 * @param excelobj $objPHPExcel excel obj
 	 * @param int $col 列数
 	 * @param int  $type 格式 2003  2007
 	 * @param array $conf 样式配置
 	 */
	public function __construct($col=26,$type=2003,$conf=NULL){
 		$col=$col>0?$col:26;
 		switch ($type) {
 			case 2003:
 				$col=$col<=256?$col:256;
 				$this->_maxRow=65535;
 				$this->_excelType=2003;
 				break; 
 			case 2007:
 				$col=$col<=702?$col:702;
 				$this->_maxRow=1048575;
 				$this->_excelType=2007;
 				break;			
 			default:
 				$col=$col<=256?$col:256;
 				$this->_maxRow=65535;
 				$this->_excelType=2003;
 				break;
 		}
 		$this->_maxCol=$col;
 		for ($i=0; $i <$col ; $i++) { 
 			if ($i>=26){
 				break;
 			}
 			$this->_colArr[$i]=chr(65+$i);
 		}
 		if ($col>26) {
 			$index_i=0;
 			$index_j=0;
 			for ($i=26; $i <$col ; $i++) { 
 				if ($index_j>25){
 					$index_j=0;
 					++$index_i;
 				}
 				if ($index_i>25) {
 					break;
 				}
 				$this->_colArr[$i]=$this->_colArr[$index_i].$this->_colArr[$index_j];
 				++$index_j;
 			}
 		}
 		if (!!$conf&&is_array($conf)) {
 			$this->_confArr=$conf;
 		}
 		
 	}
 	/**
 	 *excelObj 转array 
 	 * @param obj $objPHPExcel 
 	 * @param string $starRow 起始行
 	 * @param string $callback 单行回调函数
 	 * @param string $isUnset 是否自动回收内存（有回调函数时启用）
 	 * @param object $callbackParams 回调函数附加参数（作为回调函数第二个参数）
 	 * @return array
 	 */
 	public function ExcelObjToArray(&$objPHPExcel,$starRow=1,$callback=null,$isUnset=true,&$callbackParams=null)
 	{
 		if (!$objPHPExcel) {
 			return NULL;
 		}
 		$count=0;
 		$objWorksheet = $objPHPExcel->getSheet(0);
 		$highestColumn = $objWorksheet->getHighestColumn(); 
 		$highestRow = $objWorksheet->getHighestRow(); 
 		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); 
 		$excelData = array(); 
 		$starRow=$starRow<1?1:$starRow;
 		for ($row =$starRow; $row <= $highestRow; $row++) { 
 			for ($col = 0; $col < $highestColumnIndex; $col++) {
 				$excelData[($row-1)][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
 		    } 
 		    if (!(!$callback)){
 		    	if (function_exists($callback)){
	 		    	$callback($excelData[($row-1)],$callbackParams);
	 		    	if ($isUnset) {
	 		    		unset($excelData[($row-1)]);
	 		    	}
 		    	}
 		    }
 		    $count++;
 		} 
 		unset($objPHPExcel);
 		return array('count'=>$count,'data'=>$excelData) ;
 	}
 	/**
 	 *excel 转array 
 	 * @param string $fileName 文件路径
 	 * @param string $starRow 起始行
 	 * @param string $callback 单行回调函数
 	 * @param string $isUnset 是否自动回收内存（有回调函数时启用）
 	 * @param object $callbackParams 回调函数附加参数（作为回调函数第二个参数）
 	 * @return array
 	 */
 	public function ExcelFileToArray($fileName,$starRow=1,$callback=null,$isUnset=true,&$callbackParams=null)
 	{
 		$t=$this->_excelType;
 		switch ($t) {
 			case 2003:
 				$objReader = new PHPExcel_Reader_Excel5();
 				break;
 			case 2007:
 				$objReader = new PHPExcel_Reader_Excel2007();
 				break;
 			default:
 				$objReader = new PHPExcel_Reader_Excel5();
 				break;
 		}
 		if(!$objReader->canRead($fileName)){
 			return NULL;
 		}
 		$objPHPExcel = new PHPExcel(); 
 		$objPHPExcel=$objReader->load($fileName);
 		return $this->ExcelObjToArray($objPHPExcel,$starRow,$callback,$isUnset,$callbackParams);
 	}
 	/**
 	 *设置单元格样式 
 	 * @param excelobj $objPHPExcel excel obj
 	 * @param string $cell 单元格名  lg：A1
 	 * @param bool  $autoSize 自动列宽
 	 * @param array $confFont 字体样式配置
 	 * @param bool $isBold 是否加粗
 	 * @param bool $isH_Center 是否水平居中
 	 */
 	private function SetCellCss(&$objPHPExcel,$cell,$autoSize,$confFont,$isBold=false,$isH_Center=false)
 	{
 		$objPHPExcel->getActiveSheet()->getColumnDimension($cell)->setAutoSize($autoSize);
 		$objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setBold($isBold);
 		//对齐
 		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 		if ($isH_Center) {
 			$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 		}else{
 			$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
 		}
 		//单元格字体配置
 		$objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setSize($confFont['size']);
 		$objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->getColor()->setARGB($confFont['color']);
 	}
 	/**
 	 *excel obj 转成 excel文件
 	 * @param excelobj $objPHPExcel excel obj
 	 * @param string $fileName 文件名（不包含后缀）
 	 * @return filepath;  
 	 */
	public function ExcelObjToFile(&$objPHPExcel,$fileName=NULL)
	{
		$t=$this->_excelType;
		$e='';
		switch ($t) {
			case 2003:
				$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
				$e='.xls';
				break;
			case 2007:
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				$e='.xlsx';
				break;
			default:
				$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
				$e='.xls';
				break;
		}
		$fileName=(!$fileName)?str_replace('.', '', microtime(true)):$fileName;
		$objWriter->save($fileName .$e);
		unset($objPHPExcel);
		return $fileName .$e;
	}
	/**
	 *向excel obj 中插入数据 
	 * @param excelobj $objPHPExcel excel obj
	 * @param array $dataArr 数据 二维数据，lg：array(0=>array(col1=>'1',col2=>'2'))）
	 * @param int $rowCount 从第几行开始插入
	 */
	public function InsertDataToExcelObj(&$objPHPExcel,$dataArr,$rowCount=1)
	{
		if (!$objPHPExcel) {
			$objPHPExcel = $this->CreateExcelObj();
		}
		$colArr=$this->_colArr;
		$col=count($colArr);
		$rowCount=$rowCount>0?$rowCount:1;
		foreach ($dataArr as $key => $item) {
			if (!is_array($item)||$rowCount>=$this->_maxRow) {
				break;
			}
			$row=(string)($rowCount);
			$item=array_values($item);
	 		$colTf=count($item);
	 		$index=0;
	 		$colFlag=0;
	 		foreach ($item as $k => $v) {
	 			if (($index>=$col)||($index>=$this->_maxCol)||($colFlag>=$colTf)){
	 				break;
	 			}
	 			$objPHPExcel->getActiveSheet()->setCellValueExplicit($colArr[$index].$row, (string)$v,PHPExcel_Cell_DataType::TYPE_STRING);
	 			++$colFlag;
	 			++$index;
	 		}
	 		$rowCount++;
	 		unset($item);
		}
		unset($dataArr);
	}
	/**
	 *创建一个excel obj
	 * @return excelObj  
	 */
	public function CreateExcelObj($uName='Nener',$title='数据咯',$sheetName='Sheet1')
	{
 		$objPHPExcel = new PHPExcel();

		//创建人
		$objPHPExcel->getProperties()->setCreator($uName);
		//最后修改人
		 $objPHPExcel->getProperties()->setLastModifiedBy($uName);
		//标题
		$objPHPExcel->getProperties()->setTitle($title);
		//题目
		 $objPHPExcel->getProperties()->setSubject($title);
		//描述
		 // $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
		 $objPHPExcel->setActiveSheetIndex(0);
		// 设置sheet的name
		 $objPHPExcel->getActiveSheet()->setTitle($sheetName);
		return $objPHPExcel;
	}
	/**
	 *数据转成 excel obj 
	 * @param array $colNameArr 列名配置
	 * @param array $dataArr 数据
	 * @param bool $autoNo 自动列号
	 * @param bool $autoSize 自动列宽
	 * @param int $rowOffset 行偏移
	 * @param int $colOffset 列偏移
	 * @param bool $isSetHeadCss 是否设置头样式
	 * @param bool $isSetCellCss 是否设置单元格样式
	 * @return excelObj  
	 */
 	public function SetDataToExcelObj($colNameArr,$dataArr,$autoNo=false,$autoSize=false,$rowOffset=0,$colOffset=0,$isSetHeadCss=false,$isSetCellCss=false)
 	{
 		if (!is_array($colNameArr)||!$colNameArr) {
 			return NULL;
 		}
 		$conf=$this->_confArr;
 		$col=count($colNameArr);
 		$index=$colOffset>($col-1)?($col-1):$colOffset;
 		$objPHPExcel=$this->CreateExcelObj();
 		$colArr=$this->_colArr;
 		$headRow=$rowOffset>(($this->_maxRow)-1)?(($this->_maxRow)-1):($rowOffset+1);
 		$headRow=(string)($headRow);
 		if ($autoNo) {
 			$objPHPExcel->getActiveSheet()->setCellValueExplicit($colArr[$index].$headRow, '#');
 			if ($isSetHeadCss) {
 				$this->SetCellCss(&$objPHPExcel,$colArr[$index].$headRow,$autoSize,$conf['header'],true,true);
 			}
 			++$index;
 		}
 		foreach ($colNameArr as $k => $v) {
 			if ((($index>=$col)&&!$autoNo)||(($index>=$col+1)&&$autoNo)||($index>=$this->_maxCol)){
 				break;
 			}
 			$objPHPExcel->getActiveSheet()->setCellValueExplicit($colArr[$index].$headRow, (string)$v,PHPExcel_Cell_DataType::TYPE_STRING);
 			if ($isSetHeadCss) {
 				$this->SetCellCss(&$objPHPExcel,$colArr[$index].$headRow,$autoSize,$conf['header'],true,true);
 			}
 			++$index;
 		}
 		if(is_array($dataArr)){
 			$rowCount=(int)($headRow);
 			$dataCount=1;
	 		foreach ($dataArr as $key => $item) {
	 			++$rowCount;
	 			if ($rowCount>$this->_maxRow) {
	 				break;
	 			}
	 			$row=(string)($rowCount);
	 			$index=$colOffset>($col-1)?($col-1):$colOffset;
	 			if ($autoNo) {
	 				$objPHPExcel->getActiveSheet()->setCellValueExplicit($colArr[$index].$row, (string)($dataCount),PHPExcel_Cell_DataType::TYPE_STRING);
	 				if ($isSetCellCss) {
	 					$this->SetCellCss(&$objPHPExcel,$colArr[$index].$row,$autoSize,$conf['cell'],false,false);
	 				}
	 				++$index;
	 				++$dataCount;
	 			}
	 			if (!is_array($item)) {
	 				break;
	 			}
	 			$item=array_values($item);
	 			$colTf=count($item);
	 			$colFlag=0;
	 			foreach ($colNameArr as $k => $v) {
	 				if ((($index>=$col)&&!$autoNo)||(($index>=$col+1)&&$autoNo)||($index>=$this->_maxCol)||($colFlag>=$colTf)){
	 					break;
	 				}
	 				$cllType=PHPExcel_Cell_DataType::TYPE_STRING;
	 				$objPHPExcel->getActiveSheet()->setCellValueExplicit($colArr[$index].$row, (string)$item[$colFlag],$cllType);
	 				if ($isSetCellCss) {
	 					$this->SetCellCss(&$objPHPExcel,$colArr[$index].$row,$autoSize,$conf['cell'],false,false);
	 				}
	 				++$colFlag;
	 				++$index;
	 			}
	 			unset($item);
	 			unset($dataArr[$key]);			
	 		}
 		}
 		unset($dataArr)	;
 		return $objPHPExcel;
 	}

	/**
	 *下载文件
	 * @param string $fn 文件路径
	 * @param string $dn 文件下载重命名
	 */
	public function downFile($fn,$dn='',$delres=true)
	{
		if (!file_exists($fn)) {
			header("Content-type: text/html; charset=utf-8");
			echo '导出失败！';
			exit;
		}
		$fe=pathinfo($fn);
		$fdn=((!$dn)?(str_replace('.', '', microtime(true))):$dn).'.'.$fe['extension'];
		$file = fopen($fn,"r"); 
		$fsize=filesize($fn);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		Header("Accept-Ranges: bytes");
		Header("Accept-Length: ".$fsize);
		Header("Content-Disposition: attachment; filename=".$fdn);
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$buffer=1024; 
		$file_count=0; 
		while(!feof($file) && $file_count<$fsize){ 
			$file_con=fread($file,$buffer); 
			$file_count+=$buffer; 
			echo $file_con; 
		} 
		fclose($file);
		if ($delres){
			unlink($fn);
		}
	}
 }

?>