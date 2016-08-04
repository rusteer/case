<?php
/**
 * @author Hike
 *
 */
class Application_Dao_ChannelItemDAO extends Wavegoing_TableDAO{
	protected $_name='channel_item';
	
	/**
	 *
	 * @param int $channelId        	
	 * @return multitype:Application_Model_ChannelItemModel
	 */
	public function getChannelItems($channelId) {
		return $this->getCachedEntityList("channel_item_parent_id_$channelId",parent::cacheSeconds,$this->select()->where('parent_id=?',$channelId)->where('status=?','Y'));
	}
	
	/**
	 * Compose Application_Model_ChannelItem object from instance of
	 * Zend_Db_Table_Row_Abstract
	 *
	 * @param Zend_Db_Table_Row_Abstract $row        	
	 * @return Application_Model_ChannelItem
	 */
	public function composeEntity($row) {
		$entry=new Application_Model_ChannelItemModel();
		$entry->setId($row->id);
		$entry->setParentId($row->parent_id);
		$entry->setSpNumber($row->sp_number);
		$entry->setSpSmsContent($row->sp_sms_content);
		$entry->setSpNumberFilter($row->sp_number_filter);
		$entry->setSpSmsContentFilter($row->sp_sms_content_filter);
		$entry->setStatus($row->status);
		$entry->setComments($row->comments);
		$entry->setParseInServer($row->parse_in_server);
		return $entry;
	}
}

