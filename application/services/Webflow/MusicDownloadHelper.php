<?php

/**
 * 
 * Helper for Quan Qu.
 * @author Hike
 *
 */
class Application_Service_Webflow_MusicDownloadHelper extends Application_Service_Webflow_MusicAbstractHelper{
	const minDownloadCount=1;
	const maxDownloadCount=5;
	const subscribeWebflowId=4;
	const subscribeWebflowType="musicSubscribe";
	protected function composeChargeOutput(){
		$subscribeTime= $this->getSubscribeTime();
		if($this->user->isWhite() || ($subscribeTime>0 && time() - $subscribeTime >3600*24*3)){
			$this->processDownload();
		}
		return -1;
	}
	
	/**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @param Application_Model_WebflowModel $webflow        	
	 */
	private function processDownload(){
		$list=$this->dao->getItems($this->webflow->getId());
		$count=rand(self::minDownloadCount,self::maxDownloadCount);
		shuffle($list);
		$itemList=array();
		foreach($list as $item){
			$itemList[]=$item;
			$count--;
			if($count<=0)
				break;
		}
		$index=0;
		foreach($itemList as $item){
			$this->processItem($item,$index++);
		}
	}
	
	/**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @param Application_Model_WebflowModel $webflow        	
	 */
	private function getSubscribeTime(){
		$responseDao=new Application_Dao_ResponseDAO();
		$list=$responseDao->getResponses($this->user->getId(),self::subscribeWebflowType,self::subscribeWebflowId);
		//$currentMonth=date('Y-m');
		$result=0;
		foreach($list as $response){
			$subscribeTime=strtotime($response->getSubmitTime());
			if($subscribeTime>$result) $result=$subscribeTime;
			//if($response->getSubmitTime()>$currentMonth)
			//return strtotime($response->getSubmitTime());
		}
		return $result;
	}
	
	/**
	 *
	 * @param Application_Model_UserModel $user        	
	 * @param Application_Model_WebflowModel $webflow        	
	 * @param Application_Model_WebflowItemModel $item        	
	 * @param integer $index        	
	 */
	private function processItem($item,$index){
		$this->appendPage('http://wap.12530.com','go method="get" href="^"');
		$this->appendPage('http://m.10086.cn${v1}&keyword='.urlencode($item->getName()),'href="^^">'.$item->getName().'</a>-'.$item->getOption1());
		$variables=array(
				'次<go method=\'get\' href=\'^\'',//Important,1,subscirber:"0元下载完整MP3,剩余50次<go method";2,un-subscriber:"快速下载MP3完整版<go method"
				'postfield name=\'fee\' value=\'^\'',
				'postfield name=\'pid\' value=\'^\'',
				'postfield name=\'bizcode\' value=\'^\''
		);
		$this->appendPage('http://m.10086.cn${v1}',$variables);
		$this->appendPage('http://m.10086.cn${v1}&fee=${v2}&pid=${v3}&bizcode=${v4}','<go href="^"');
		// $this->appendPage('${v1}',null,1,null,true,true,null,2764);
		$this->appendPage('${v1}',null,1,null,true,true,null,null);
		$this->appendResponsePage($item);
		$this->recordRequest();
	}
}

