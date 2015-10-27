<?php
namespace nest\sip;   

class packet{
    private $allowed_methods = array(
    "CANCEL","NOTIFY", "INVITE","BYE","REFER","OPTIONS","SUBSCRIBE","MESSAGE"
    );

    public $dialog = false;
    public $socket;
    public $src_ip;
    public $user_agent = 'PHP SIP';
    public $cseq = 20;
    public $src_port;
    public $call_id;
    public $contact;
    public $uri;
    public $host;
    public $port = 5060;
    public $proxy;
    public $method;
    public $username;
    public $password;
    public $to;
    public $to_tag;
    public $from;
    public $from_user;
    public $from_tag;
    public $via;
    public $content_type;
    public $body;
    public $response;
    public $res_code;
    public $res_contact;
    public $res_cseq_method;
    public $res_cseq_number;
    public $req_method;
    public $req_cseq_method;
    public $req_cseq_number;
    public $req_contact;
    public $auth;
    public $routes = array();
    public $request_via = array();
    public $extra_headers = array();
    public $raw_packet;

       public function parse($raw_packet){
        $this->raw_packet=$raw_packet; 
        $temp = explode("\r\n",$raw_packet);
        $temp = explode(" ",$temp[0]);
        $this->req_method = trim($temp[0]);
        $this->parse_routes();
        $this->parse_via();
        $this->parse_contact();
        $this->parse_cseq();
    } 
 
    
    private function parse_routes(){
      if (preg_match_all('/^Record-Route: (.*)$/im',$this->raw_packet,$result))
        {
          foreach ($result[1] as $route)
          {
            if (!in_array(trim($route),$this->routes))
            {
              $this->routes[] = trim($route);
            }
          }
        }
    }

    private function parse_via(){
      $this->request_via = array();
        if (preg_match_all('/^Via: (.*)$/im',$this->raw_packet,$result))
        {
          foreach ($result[1] as $via)
          {
            $this->request_via[] = trim($via);
          }
        }
    }

    private function parse_contact(){
       if (preg_match('/^Contact: <(.*)>/im',$this->raw_packet,$result))
        {
          $this->req_contact = trim($result[1]);
          
          $semicolon = strpos($this->res_contact,";");
          
          if ($semicolon !== false)
          {
            $this->res_contact = substr($this->res_contact,0,$semicolon);
          }
        }
    }

    private function parse_cseq(){
        if (preg_match('/^CSeq: [0-9]+ (.*)$/im',$this->raw_packet,$result))
        {
          $this->req_cseq_method = trim($result[1]);
        }
 
        if (preg_match('/^CSeq: ([0-9]+) .*$/im',$this->raw_packet,$result))
        {
          $this->req_cseq_number = trim($result[1]);
        }
    }

}

?>
