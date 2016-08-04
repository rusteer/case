<?php
class Application_Model_UserStatisticsModel extends Wavegoing_Model{
	public $id; // `id` bigint(20) NOT NULL AUTO_INCREMENT,
	public $userId; // `user_id` bigint(20) NOT NULL,
	public $statTime; // `stat_time` varchar(20) NOT NULL,
	public $requestCount=0; // `request_count` int(11) DEFAULT '0',
	public $responseCount=0; // `response_count` bigint(20) NOT NULL,
	public $requestSpending=0; // `fee_count` bigint(20) NOT NULL,
	public $requestSharing=0; // `sharing_count` bigint(20) NOT NULL,
	public $responseSpending=0; // `fee_count` bigint(20) NOT NULL,
	public $responseSharing=0; // `sharing_count` bigint(20) NOT NULL,
	public $updateTime; // `update_time` timestamp NOT NULL,
	public $createTime; // //`create_time` timestamp NOT NULL DEFAULT
	                    // CURRENT_TIMESTAMP,
}

