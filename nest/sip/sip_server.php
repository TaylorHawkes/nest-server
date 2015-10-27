<?php
namespace nest\sip;   

class sip_server{

    public function __construct(){
        $this->response_codes=new response_codes();
    }
    
    
  public function process(packet $packet){
       $method=strtolower($packet->req_method);
       return $this->$method($packet);
  }
    
  public function get_response(packet $packet)
  {
    
    $r=$this->response_codes->get_response_code(200);
    foreach ($packet->request_via as $via)
    {
      $r.= 'Via: '.$via."\r\n";
    }
    $r.= 'From: '.$packet->from.';tag='.$packet->to_tag."\r\n";
    $r.= 'To: '.$packet->to.';tag='.$packet->from_tag."\r\n";
    $r.= 'Call-ID: '.$packet->call_id."\r\n";
    $r.= 'CSeq: '.$packet->req_cseq_number.' '.$packet->req_cseq_method."\r\n";
    $r.= 'Max-Forwards: 70'."\r\n";
    $r.= 'User-Agent: '.$packet->user_agent."\r\n";
    $r.= 'Content-Length: 0'."\r\n";
    $r.= "\r\n";

    return $r;
    
  }
  

    //13.2.1 Creating the Initial INVITE
    private function invite(packet $packet){
        return $this->get_response($packet);
    }

    private function notify(){
    }
    private function cancel(){
    }
    private function bye(){
    }
    private function refer(){
    }
    private function options(){
    }
    private function subscribe(){
    }
    private function message(){
    }
        

    





    
}

