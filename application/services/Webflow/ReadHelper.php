<?php
class Application_Service_Webflow_ReadHelper extends Application_Service_Webflow_AbstractHelper{
	private $preChargeChapters=0;
	private function getChapterTitles(){
		if($this->webflow->getOption2()){
			return explode(",",$this->webflow->getOption2());
		}else{
			return array();
		}
	}
	private function composeReadOutput($indexes){
		$variables=array();
		$chapterTitles=$this->getChapterTitles();
		foreach($indexes as $index)
			$variables[]='/iread/^^">'.$chapterTitles[$index];
		$this->appendPage($this->webflow->getOption1(),$variables);
		$pageIndex=1;
		foreach($indexes as $index){
			$variable='${v'.($pageIndex++).'}';
			if(rand()%2==0){
				//$this->appendPage("http://wap.cmread.com/iread/$variable",'/iread/^^">余下全文');
				//$variable='${v1}';
			}
			$this->appendPage("http://wap.cmread.com/iread/$variable");
		}
	}
	protected function composePreChargeOutput(){
		$count=count($this->getChapterTitles());
		if($count>0){
			$tryCount=rand(1,$count/2);
			$indexes=array();
			while($this->preChargeChapters<$tryCount)
				$indexes[]=$this->preChargeChapters++;
			$this->composeReadOutput($indexes);
		}else{
			$list=$this->dao->getItems($this->webflow->getId());
			foreach($list as $item){
				if($item->getOption1()=="pre")
					$this->appendPage($item->getUrl());
			}
		}
		if($this->webflow->getOption3()=='only-confirm-page'){
			$this->appendPage($this->webflow->getOption1(),'/iread/^^">确认订购');
		}else{
			$this->appendPage($this->webflow->getOption1(),'/iread/wml/l/readbook2.jsp;^"');
			$this->appendPage('http://wap.cmread.com/iread/wml/l/readbook2.jsp;${v1}','/iread/^^">确认订购',2);			
		}
	}
	protected function composeChargeOutput(){
		$this->appendPage('http://wap.cmread.com/iread/${v1}');
		$this->appendResponsePage();
	}
	protected function composePostChargeOutput(){
		$count=count($this->getChapterTitles());
		if($count>0){
			$indexes=array();
			while($this->preChargeChapters<$count)
				$indexes[]=$this->preChargeChapters++;
			$this->composeReadOutput($indexes);
		}else{
			$list=$this->dao->getItems($this->webflow->getId());
			foreach($list as $item){
				if($item->getOption1()=="post")
					$this->appendPage($item->getUrl());
			}
		}
	}
}

