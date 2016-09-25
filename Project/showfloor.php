<?php
	$conn=mysql_connect('localhost','root');
	mysql_select_db('project',$conn);
	mysql_query('SET NAMES utf8');
	
	if($_GET['mapsId2']!=''){
		$f = $_GET['fo']+1;
		$showMaps=mysql_fetch_array(mysql_query('SELECT * FROM tb_mapsgoo WHERE id_mps ='.$_GET['mapsId2']));
		$buId=$_GET['mapsId2'];
		$name=$showMaps['name_mps'];
		$lat=$showMaps['lat_mps'];
		$lng=$showMaps['lng_mps'];
		//$zoom=$showMaps['zoom_mps'];
		$zoom = 20;
		$floors=$showMaps['floors'];
		
		$showAP=mysql_fetch_array(mysql_query('SELECT * FROM ap_maps WHERE bu_id ='.$_GET['mapsId2']));
		$APName=$showAP['ap_name'];
		$APlat=$showAP['ap_lat'];
		$APlng=$showAP['ap_lng'];
	}else{
		header('Location:showbuilding.php'); 
		exit();
	}
	$settingSQL = 'SELECT * FROM setting';
	$settingQuery = mysql_query($settingSQL) or die (mysql_error());
	$setting = mysql_fetch_array($settingQuery);
	//echo $setting['yellow'];
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA6M92k8lcjbhKz3-jGXpjWxOXRGWH76Cw&sensor=false&language=th"></script> <!-- key google map api -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<title>แสดงจุด Access Point</title>
	<?php $oldOutOctets = 0 ?>;
	<script type="text/javascript">
		var thisBuild = '<?=$buId?>';
		var name='<?=$name?>';
		var lat='<?=$lat?>';
		var lng='<?=$lng?>';
		var zoom='<?=$zoom?>';
		var thisfloor='<?=$f?>';
		var setY = <?php echo $setting['yellow']; ?>;
		var setR = <?php echo $setting['red']; ?>;	
	function myMaps(){
	
		var mapsGoo=google.maps;
		var Position=new mapsGoo.LatLng(lat,lng);
		var myOptions = {
			center:Position,
			zoom:parseInt(zoom),
			mapTypeId: mapsGoo.MapTypeId.ROADMAP  //ชนิดของแผนที่
			};
		var map = new mapsGoo.Map(document.getElementById("map_canvas"),myOptions);
		//var infowindow = new mapsGoo.InfoWindow();
		//var marker = new mapsGoo.Marker({//เรียกเมธอดMarker(หมุด)
		//	position: Position,
	//});
	var AMarkers = [];
	var oldOutOctets = [];
	var j=0;
	var banW=0;
	function getDataFromDb(){	
			for (var i = 0; i < AMarkers.length; i++) {
				AMarkers[i].setMap(null);
			}
			AMarkers = [];
			
	$.ajax({ 
				url: base_url + "project/getjson" ,
				type: "POST",
				data: ''
			})
			.success(function(result) { 
				var obj = jQuery.parseJSON(result);
					if(obj != '')
					{
						j=0;
						  //$("#myTable tbody tr:not(:first-child)").remove();
						  //$("#myBody").empty();
						  $.each(obj, function(key, val) {
									var showInterface = val["Interface"]-10000;
									if( thisfloor == parseFloat(val['floor'])&&thisBuild == parseFloat( val["bu_id"])){
									var loca = new mapsGoo.LatLng(parseFloat(val["ap_lat"]),parseFloat(val["ap_lng"]));
									//alert(parseFloat(val["traffic_max"]));
									var tit;
									banW = (val['OutOctets']-oldOutOctets[j])/5;
									if(val['status']==2)
									{
										var icon_image = "images/red_MarkerX.png";
										tit = val['ap_name']+"\nInterface: Fa0/"+showInterface+"\nstatus: Down\nBanwidth: "+banW+" Mbps"; 
									}else{
										if(parseFloat(banW)<setY)
										{
											var icon_image = "images/darkgreen_MarkerO.png"; //marker สีเขียว
										}
										else if(parseFloat(banW)>setR){
											var icon_image = "images/red_MarkerO.png"; //marker สีแดง
										}
										else{
											var icon_image = "images/yellow_MarkerO.png"; //marker สีเหลือง
										}
										tit = "AP: "+val['ap_name']+"\nInterface: Fa0/"+showInterface+"\nstatus: Up\nBanwidth: "+banW+" Mbps";
									}	
									var marker = new mapsGoo.Marker({//เรียกเมธอดMarker(ปักหมุด)
											position: loca,
											icon: icon_image,
											draggable:false,
											title: tit,
											})	
									AMarkers.push(marker);	
									}
										//แสดงตัวปักหมุด	
										oldOutOctets[j] = val['OutOctets'];
										j++;
							}	
							);
						for (var i = 0; i < AMarkers.length; i++) {
							AMarkers[i].setMap(map);
						}	
					}
			});
}setInterval(getDataFromDb, 5000);	

	}
	$(document).ready(function(){
		myMaps();
	});

</script>

<style type="text/css">
body{
font-size:12px;
color:#333; 
}
</style>

</head>

<body>
	<table width=600" border="0" align="center" cellpadding="5" cellspacing="0">
		<tr>
			<td bgcolor="#E1E1E1"><h1>ชั้น <?php echo $f;?></h1></td>
			<td bgcolor="#E1E1E1"></td>
			
		</tr>
		
		<tr>
			<td bgcolor="#E1E1E1">
				<div id="map_canvas" style="width:500px; height:400px"></div>
				</br>
				<form>
						<input type="submit" value="add marker"; onClick="js_popup('addAp.php?bu_id=<?php echo $_GET['mapsId2']?>&floor=<?php echo $f?>&x=<?php echo $lng?>&y=<?php echo $lat?>',720,600); return false;">
				</form>
			</td>
			<td bgcolor="#E1E1E1" valign ="top" width ="200" align = "right">
				<iframe src="saveap.php?f=<?php echo $f ?>&this_bu_id=<?php echo $_GET['mapsId2'] ?>" height="400; overflow-y: scroll; " width="200 overflow-y: scroll;" frameborder="0"></iframe>
			</td>
				
		</tr>				
	</table>
</body>
<script language="javascript">
function js_popup(theURL,width,height) { //v2.0
	leftpos = (screen.availWidth - width) / 2;
    	toppos = (screen.availHeight - height) / 2;
  	window.open(theURL, "viewdetails","width=" + width + ",height=" + height + ",left=" + leftpos + ",top=" + toppos);
}
</script>

</html>

<?php mysql_close($conn);?>