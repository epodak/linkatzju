<?php
	ignore_user_abort(); 	//即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行.
	set_time_limit(0); // 执行时间为无限制，php默认执行时间是30秒，可以让程序无限制的执行下去
	$interval=5*60; // 每隔一天运行一次
	do{
		sleep($interval); // 按设置的时间等待一小时循环执行
		$link=mysql_connect("localhost","root","dHIoPOi7Ej3n");
		mysql_select_db("app_wcjdemo",$link);    //选择数据库
	
		//查找窗户状态
		$result=mysql_query("SELECT * FROM status");
		while($result_array=mysql_fetch_array($result)){
			if($result_array['Id']==1){
				$Windowstatus=$result_array['Windowstatus'];
			}
		}

		//如果窗户有人，则发送邮件
		if($Windowstatus==1)
		{
			$to='wcj.zju@foxmail.com';
			$subject='安全警告！';
			$body='有人从家里窗户边经过，请注意安全！\r\n--sent from arduino';
			mail($to,$subject,$body);
		}
		mysql_close($link);
	}while(true);
?>