<?php
	$conn=mysql_connect('localhost','root');
	mysql_query('SET NAMES UTF8');
	$objDB = mysql_select_db('project',$conn);
	$strSQL = 'SELECT * FROM ap_maps ORDER BY ap_name ASC';
	$objQuery = mysql_query($strSQL) or die (mysql_error());
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	$settingSQL = 'SELECT * FROM setting';
	$settingjQuery = mysql_query($settingSQL) or die (mysql_error());
	$setting = mysql_fetch_array($settingjQuery);
	$host = $setting['host']; 
	$community = "ServerCacti";  
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
			if(mysql_field_name($objQuery,$i)=="Interface"){
				$oidOutOctets = "1.3.6.1.2.1.2.2.1.16.".$obResult[$i];
				$oidstatus = "1.3.6.1.2.1.2.2.1.8.".$obResult[$i];
				$ifOutOctets = snmpwalk("$host","$community","$oidOutOctets");
				$ifOperStatus = snmpwalk("$host","$community","$oidstatus");
				
				//echo $oidstatus;
				list($prefOutOctets,$outOctetsByte) = explode(": ", $ifOutOctets[0]);
				$outOctets = (floatval($outOctetsByte)/8000000); //เปลี่ยนหน่วยเป็น Mbps
				list($prefStatus,$status) = explode(": ", $ifOperStatus[0]);
			}
			//echo mysql_field_name($objQuery,$i);
			
		}
		//echo $ifOperStatus[0];
		$arrCol["OutOctets"] = $outOctets;
		$arrCol["status"] = $status;
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($conn);
	echo json_encode($resultArray);
?>