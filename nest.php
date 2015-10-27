<?php
include("vendor/autoload.php");

$sip_server=new nest\sip\sip_server();

set_time_limit (0);

$ip = '127.0.0.1';
$port = 5061;

//Create a UDP socket
if(!($sock = socket_create(AF_INET, SOCK_DGRAM,SOL_UDP)))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    die("Couldn't create socket: [$errorcode] $errormsg \n");
}
echo "Socket created \n";

if( !socket_bind($sock, $ip , $port) )
{ $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    die("Could not bind socket : [$errorcode] $errormsg \n");
}

echo "Socket bind OK \n";  

while(1)
{
    echo "Waiting for data ... \n";

    $r = socket_recvfrom($sock, $buf, 512, 0, $remote_ip, $remote_port);

    $packet=new nest\sip\packet();
    $packet->parse($buf);

    $response=$sip_server->process($packet);
    echo $response;
    socket_sendto($sock, $response, strlen($answer), 0 , $remote_ip , $remote_port);
}

socket_close($sock);


