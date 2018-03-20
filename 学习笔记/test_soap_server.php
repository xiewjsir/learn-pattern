<?php
/**
 * @desc 分润同步test
 */
defined('InShopNC') or exit('Access Invalid!');
class member_frControl extends BaseHomeControl{
	
	/**
	 * 服务端 
	 */
	public function frServiceOp(){
		$s = new SoapServer(null, array("location"=>"http://v3.dt.dld.com/index.php?act=member_fr&op=frService","uri"=>"Server.php"));
		$s -> setClass("frControl");
		$s -> handle();
	}
}

/**
 * 分润同步类test
 */
class frControl
{
	public $authFlag	= FALSE;//是否已认证
	public $account		= '';//帐号
	public $pwd			= '';
	public $returnType	= 'array';//接口返回类型 默认数组
	
	//设置帐号
	public function auth($data){
		$account		= $data->account;
		$pwd			= $data->pwd;
		$this->account 	= $data->account;
		$this->returnType = $data->return_type;
		if ($account == '' || $pwd == '') {
			return true;
		}
		$pwd		= UtilD::encryptPwd($data->pwd);
		$accounts	= Model('sms_account')->getAllAccount();
		$clientIp	= getIp();
		if (!isset($accounts[$account]) || $accounts[$account]['pwd'] != $pwd) {
			return true;
		}
		if ($accounts[$account]['white_ip'] != '' && in_array($clientIp,  explode(",", $accounts[$account]['white_ip']))) {
			$this->authFlag	= 2;
			return true;
		}
		$this->authFlag		= true;
		return true;
	}
	
	//供调用的方法
	public function sendSms($phonex, $msg, $num = 1, $ref = 'dld', $sendTime = '', $type = 'public'){
		return UtilD::sendSMS($phonex, $msg, $num , $ref, $sendTime, $type); 
	}
	
	/***
	 * 供调用的方法 加入帐号验证
	 * @author Jack.W
	 * @version 2014-12-19
	 */
	public function sendSms2($phonex, $msg, $num = 1, $sendTime = '', $type = ''){
		
		$ref	= $this->account;
		$return	= UtilD::handleResult(0, 'ccc001', false);
		return $ref;
		exit;
				
		if ($type == '') {
			$type	= $ref;
		}
		if (!$this->authFlag) {
			$return	= UtilD::handleResult(0, '帐号或者密码错误！', false);
		}else{
			$return = UtilD::sendSMS($phonex, $msg, $num , $ref, $sendTime, $type);
		}
		switch ($this->returnType){
			case 'xml':
				$xmlData = '<?xml version="1.0" encoding="utf-8"?>
								<body>
					   				<key>'.$return['key'].'</key>
					   				<keyMain>'.$return['keyMain'].'</keyMain>
							</body>';
				$return	= $xmlData;
				break;
			default:
				
		}
		return $return;
	}
}
?>