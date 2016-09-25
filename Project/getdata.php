<?php
	$conn=mysql_connect('localhost','root');
	mysql_query('SET NAMES UTF8');
	$objDB = mysql_select_db('project',$conn);
	$strSQL = 'SELECT * FROM tb_mapsgoo ORDER BY name_mps ASC';
	$objQuery = mysql_query($strSQL) or die (mysql_error());
	
	$settingSQL = 'SELECT * FROM setting';
	$settingjQuery = mysql_query($settingSQL) or die (mysql_error());
	$setting = mysql_fetch_array($settingjQuery);
	
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	$host = $setting['host']; 
	$community = "ServerCacti";  
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
			
			if(mysql_field_name($objQuery,$i)=="id_mps"){
				$maxBandwidth = 0;
				$sUp = 0;
				$sDown = 0;
				$apSQL =' SELECT * FROM ap_maps WHERE bu_id = '.$obResult[$i].' ORDER BY ap_id';
				$apjQuery = mysql_query($apSQL) or die (mysql_error());
				while($apResult = mysql_fetch_array($apjQuery)){	
					//echo $apResult['Interface'];
					$oidOutOctets = "1.3.6.1.2.1.2.2.1.16.".$apResult['Interface'];
					$oidstatus = "1.3.6.1.2.1.2.2.1.8.".$apResult['Interface'];
					//echo $oidOutOctets;
					
					$ifOperStatus = snmpwalk("$host","$community","$oidstatus");
					list($prefStatus,$status) = explode(": ", $ifOperStatus[0]);
					if($status == 2){
						$sDown++;	
					}
					else
					{
						$sUp++;
					}
					
					$ifOutOctets = snmpwalk("$host","$community","$oidOutOctets");
					list($prefOutOctets,$outOctetsByte) = explode(": ", $ifOutOctets[0]);
					$outOctets = (floatval($outOctetsByte)/8000000);
					$bandWidth = ($outOctets-$apResult['ap_traffic'])/5;
					//echo $bandWidth."___________";
					mysql_query("UPDATE ap_maps SET ap_traffic='".$outOctets."' WHERE ap_id = '".$apResult['ap_id']."'");
					if($bandWidth>$maxBandwidth){
						$maxBandwidth = $bandWidth; 
					}
					//echo $bandWidth."_".$maxBandwidth."___________";
				}
				$arrCol["sUp"] = $sUp;
				$arrCol["sDown"] = $sDown;
				$arrCol["maxBandwidth"] = $maxBandwidth;
				
			}	
		}
		
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($conn);
	
	echo json_encode($resultArray);
?>