<?php
include("vendor/autoload.php");

$packet=new nest\sip\packet();
set_time_limit (0);

$ip = '50.116.4.129';
$port = 5060;

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
    //$dns_message->decode_dns_message($buf,$remote_ip,$remote_port);
    //echo "$remote_ip : $remote_port -- " . $buf;
    //$dns_packet= build_dns_packet($id);
    //Send back the data to the client
    //$server=new DNS\Server();
    //$answer=$server->respond($dns_message);
    $packet->parse($buf);

    //socket_sendto($sock, $answer, strlen($answer), 0 , $remote_ip , $remote_port);
}

socket_close($sock);


