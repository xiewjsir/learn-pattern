	public function actionAdd(){
		try{
			$soap = new SoapClient(null, array('location'=>"http://v3.dt.dld.com/index.php?act=member_fr&op=frService",'uri'=>'Server.php'));
			$var		= new SoapVar(array('account'=>'test', 'pwd'=>"password"), SOAP_ENC_OBJECT);
			$header		= new SoapHeader('http://v3.dt.dld.com/index.php?act=member_fr', 'auth', $var, false, SOAP_ACTOR_NEXT);
			$soap->__setSoapHeaders(array($header));
			$result = $soap->sendSms2('13620200544','���̲��ԣ�140925101273��ԤԼ�绰0755 ����',1, time(), 'find_pwd');
			var_dump($result);
		}catch(SoapFault $e){
			echo $e->getMessage();
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}	