<?php
namespace nest\sip;   

class packet{
    private $allowed_methods = array(
    "CANCEL","NOTIFY", "INVITE","BYE","REFER","OPTIONS","SUBSCRIBE","MESSAGE"
    );

    private $dialog = false;
    private $socket;
    private $src_ip;
    private $user_agent = 'PHP SIP';
    private $cseq = 20;
    private $src_port;
    private $call_id;
    private $contact;
    private $uri;
    private $host;
    private $port = 5060;
    private $proxy;
    private $method;
    private $username;
    private $password;
    private $to;
    private $to_tag;
    private $from;
    private $from_user;
    private $from_tag;
    private $via;
    private $content_type;
    private $body;
    private $response;
    private $res_code;
    private $res_contact;
    private $res_cseq_method;
    private $res_cseq_number;
    private $req_method;
    private $req_cseq_method;
    private $req_cseq_number;
    private $req_contact;
    private $auth;
    private $routes = array();
    private $request_via = array();
    private $extra_headers = array();
    
    public function parse($raw_packet){
        print_r($raw_packet);
    }


}

?>
