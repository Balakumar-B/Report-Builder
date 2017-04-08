<?php
	function capitalize($var)
	{
		return str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($var))));
	}
	function db_date($original_date)
	{
		return date('Y-m-d',strtotime(str_replace('/', '-',$original_date)));
	}
	function moneytodouble($money)
	{
		return str_replace(array(',',' ','Rs.','-'),"",$money);
	}
?>	