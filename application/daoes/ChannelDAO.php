<?php
class Application_Dao_ChannelDAO extends Wavegoing_TableDAO{
	protected $_name='channel';
	const cacheAllChannel='channel_all';
	const cacheAllEnabled='channel_all_enabled';
	public function getPartners(){
		$sql="select distinct partner from channel";
		$rows=$this->getAdapter()->fetchAll($sql);
		$result=array();
		foreach($rows as $row){
			$result[]=$row['partner'];
		}
		return $result;
	}
	
	/**
	 *
	 * @see Wavegoing_TableDAO::composeRow()
	 * @param Application_Model_ChannelModel $channel        	
	 *
	 */
	public function composeRow(Application_Model_ChannelModel $channel){
		$result=array(
				"id"=>$channel->id,
				"name"=>$channel->name,
				"status"=>$channel->status,
				"daily_limit"=>$channel->dailyLimit,
				"monthly_limit"=>$channel->monthlyLimit,
				"user_daily_limit"=>$channel->userDailyLimit,
				"user_monthly_limit"=>$channel->userMonthlyLimit,
				"interval"=>$channel->interval,
				"user_interval"=>$channel->userInterval,
				"area_rule"=>$channel->areaRule,
				"sp_number"=>$channel->spNumber,
				"command"=>$channel->command,
				"version"=>$channel->version,
				"start_hour"=>$channel->startHour,
				"end_hour"=>$channel->endHour,
				"partner"=>$channel->partner,
				"price"=>$channel->price,
				"sharing"=>$channel->sharing,
				"comments"=>$channel->comments,
				"start_date"=>$channel->startDate,
				"create_time"=>$channel->createTime,
		        "payment_cycle"=>$channel->paymentCycle,
		        "request_per_time"=>$channel->requestPerTime
		);
		return $result;
	}
	
	/**
	 * Compose Application_Model_Channel object from instance of
	 * Zend_Db_Table_Row_Abstract
	 *
	 * @param Zend_Db_Table_Row_Abstract $row        	
	 * @return Application_Model_Channel
	 */
	public function composeEntity($row){
		$result=new Application_Model_ChannelModel();
		$result->setId($row->id*1);
		$result->setName($row->name);
		$result->setUserDailyLimit($row->user_daily_limit*1);
		$result->setUserMonthlyLimit($row->user_monthly_limit*1);
		$result->setInterval($row->interval*1);
		$result->setUserInterval($row->user_interval*1);
		$result->setAreaRule($row->area_rule);
		$result->setStatus($row->status);
		$result->setSpNumber($row->sp_number);
		$result->setCommand($row->command);
		$result->setVersion($row->version);
		$result->setStartHour($row->start_hour*1);
		$result->setEndHour($row->end_hour*1);
		$result->setDailyLimit($row->daily_limit*1);
		$result->setMonthlyLimit($row->monthly_limit*1);
		$result->setPartner($row->partner);
		$result->setPrice($row->price*1);
		$result->setSharing($row->sharing*1);
		$result->setStartDate($row->start_date);
		$result->setPaymentCycle($row->payment_cycle);
		$result->setRequestPerTime($row->request_per_time*1);
		return $result;
	}
	
	/**
	 * Returns all channles, include enalbed/disalbed
	 *
	 * @return multitype:Application_Model_Channel
	 */
	public function getAllChannels(){
		return $this->getEntityList();
	}
	public function getEnabledList(){
		return $this->getCachedEntityList(self::cacheAllEnabled,parent::cacheSeconds,$this->select()->where("status=?",'Y'));
	}
	
	/**
	 * Returns an instance of a Application_Model_Channel object.
	 *
	 * @param string $spNumber        	
	 * @param string $command        	
	 * @return Application_Model_Channel
	 */
	public function loadChannelBySpNumberAndCommand($spNumber,$command){
		if($command!=null&&$spNumber!=null)
			return $this->getEntity($this->select()->where('sp_number=?',$spNumber)->where('command=?',$command));
		else if($spNumber!=null)
			return $this->getEntity($this->select()->where('sp_number=?',$spNumber));
		else if($command!=null)
			return $this->getEntity($this->select()->where('command=?',$command));
		return null;
	}
}

