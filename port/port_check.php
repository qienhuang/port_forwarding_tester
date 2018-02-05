<?php
switch ($_POST['operation'])
{
	case 'test_port':
		test_port();
		exit;
	case 'get_host_ip':
		get_host_ip();
		exit;
	case 'get_wan_ip':
		get_wan_ip();
		exit;
	default:
		exit;	
	
}
/*************** Port open test *******************/
function test_port()
{
	$connection = @pfsockopen($_POST["host"],$_POST["port"],$errno,$errstr,1);
	if(is_resource($connection))
	{
		$result_array = array( "result"=>array("host"=>$_POST["host"],"port"=>$_POST["port"],"button"=>$_POST["button"],"open"=>"yes"));
		$json = json_encode($result_array);
		echo $json;
		fclose($connection);
	}
	else
	{
		$result_array = array("result"=>array("host"=>$_POST["host"],"port"=>$_POST["port"],"button"=>$_POST["button"],"open"=>"no"));
		$json = json_encode($result_array);
		echo $json;
	}
	exit;
}
/*************** Get host IP *******************/
function get_host_ip()
{
	$hostIPs = gethostbynamel ( $_POST['host'] );
	echo $hostIPs [0];
	
}
/*************** Get WAN IP *******************/
function get_wan_ip()
{
	$strURL = 'http://checkip.dyndns.org/';
	$contents = file_get_contents ( $strURL );

	preg_match ( '/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/', $contents, $IPArray );
	if (count ( $IPArray ) > 0) {
		echo $IPArray [0];
	} else {
		echo '';
	}
	//echo $_SERVER['REMOTE_ADDR'];
}
