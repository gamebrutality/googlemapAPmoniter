<?php
	$conn=mysql_connect('localhost','root');
	mysql_select_db('test',$conn);
	mysql_query('SET NAMES utf8');
	
	if($_GET['mapsId']!=''){
		$showMaps=mysql_fetch_array(mysql_query('SELECT * FROM tb_mapsgoo WHERE id_mps='.$_GET['mapsId']));
		$name=$showMaps['name_mps'];
		$lat=$showMaps['lat_mps'];
		$lng=$showMaps['lng_mps'];
		$zoom=$showMaps['zoom_mps'];
		$floors=$showMaps['floors'];
	}else{
		header('Location:google-map-api.php'); 
		exit();
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA6M92k8lcjbhKz3-jGXpjWxOXRGWH76Cw&sensor=false&language=th"></script> <!-- key google map api -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<title>แสดงจุด Access Point</title>
	<script type="text/javascript">
		var name='<?=$name?>';
		var lat='<?=$lat?>';
		var lng='<?=$lng?>';
		var zoom='<?=$zoom?>';

		
	function myMaps(){
	
		var mapsGoo=google.maps;
		var Position=new mapsGoo.LatLng(lat,lng);
		var myOptions = {
			center:Position,
			zoom:parseInt(zoom),
			mapTypeId: mapsGoo.MapTypeId.SATELLITE //ชนิดของแผนที่
			};
		var map = new mapsGoo.Map(document.getElementById("map_canvas"),myOptions);
		var infowindow = new mapsGoo.InfoWindow();
		var marker = new mapsGoo.Marker({//เรียกเมธอดMarker(หมุด)
			position: Position,
	});

	marker.setMap(map);
	infowindow.setContent(name);
	infowindow.open(map, marker);
	
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
	<table width="850" border="0" align="center" cellpadding="5" cellspacing="0">
		<tr>
			<td bgcolor="#E1E1E1"><strong>ชื่อ Access Point :</strong></td>
			<td bgcolor="#E1E1E1"><h1><?=$name?></h1></td>
		</tr>
		
		<tr>
			<td bgcolor="#E1E1E1"><strong>แสดงผลการทำงานของ AP</strong></td>
			<td bgcolor="#E1E1E1"><div id="map_canvas" style="width:500px; height:400px"></div></td>
		</tr>
<?php 
for($i=0;$i < $floors; $i++){ ?>		
		<tr>
			<td bgcolor="#EEEEEE"><strong>แสดงการทำงานของ AP ที่ช้ัน  <?php echo $i+1 ?></strong></td>
			<td bgcolor="#E1E1E1"><iframe src="showfloor.php?mapsId2=<?php echo $_GET['mapsId'] ?>&fo=<?php echo $i ?>" height="650" width="750" frameborder="0"></iframe></td>
		</tr>
<?php }  ?>		
	</table>
</body>

</html>

<?php mysql_close($conn);?>