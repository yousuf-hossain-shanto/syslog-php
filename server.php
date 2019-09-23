<?php
//Reduce errors
error_reporting(E_ALL);

//Create a UDP socket
if(!($sock = socket_create(AF_INET, SOCK_DGRAM, 0)))
{
	$errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    
    die("Couldn't create socket: [$errorcode] $errormsg \n");
}

echo "Socket created \n";

// Bind the source address
if( !socket_bind($sock, "192.168.0.106" , 514) )
{
	$errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    
    die("Could not bind socket : [$errorcode] $errormsg \n");
}

echo "Socket bind OK \n";

//Do some communication, this loop can handle multiple clients
echo "Waiting for data ... \n\n";


/*
 * All patterns
 * */

/*
 * ^<%{POSINT:syslog_pri}>%{SYSLOGTIMESTAMP:syslog_timestamp} %{WORD:log_source} %{GREEDYDATA:syslog_message}
 * 1= syslog_pri, 2= syslog_timestamp, 3=log_source, 4=syslog_message
 * */
$microtik_bsd = '/^<(.+)>(.+) (.+) (.+)/';
/*
 * %{DATA:LogPrefix} %{DATA:LogChain}: in:%{DATA:src_zone} out:%{DATA:dst_zone}, src-mac %{MAC}, proto %{DATA:proto}, %{IP:src_ip}:%{INT:src_port}->%{IP:dst_ip}:%{INT:dst_port}, len %{INT:length}
 * 1=LogPrefix, 2=LogChain, 3=src_zone, 4=dst_zone, 5=mac, 6=proto, 7=src_ip, 8=src_port, 9=dst_ip, 10=dst_port, 11=length
 * */
$microtik_firewal_log_without_nat = '/(.+) (.+): in:(.+) out:(.+), src-mac (.+), proto (.+), (.+):(.+)->(.+):(.+), len (.+)/';


while(1)
{
	
	//Receive some data
	$r = socket_recvfrom($sock, $buf, 1000000, 0, $remote_ip, $remote_port);
    // $d = [];
    echo $buf;
    echo "\n\n";
}

socket_close($sock);