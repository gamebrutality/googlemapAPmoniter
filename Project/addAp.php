<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>แผนที่ Google</title>

<style type="text/css">
body
	{
		font-family:Tahoma, Geneva, sans-serif;
		font-size:14px;
	}
#contain_map2 
	{
		position:relative;
		width:550px;
		Right:350px;
		margin:auto;
		margin-top:10px;
	}

</style>
<?php
	$conn=mysql_connect('localhost','root');
	mysql_select_db('project',$conn);
	mysql_query('SET NAMES utf8');
	
	if(isset($_GET['bu_id'])) {
			$bu_id = $_GET['bu_id'];
			$floor = $_GET['floor'];
			$longit = $_GET['x'];
			$latit = $_GET['y'];
		//echo $bu_id;
		//echo $floor;
	}

?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA6M92k8lcjbhKz3-jGXpjWxOXRGWH76Cw&sensor=true&language=th"></script> <!-- key google map api -->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript">

	function myMaps() {
		var mapsGoo=google.maps;
		var Position=new mapsGoo.LatLng(<?php echo $latit?>,<?php echo $longit?>);//ละติจูด,ลองติจูด เริ่มต้น 
		var myOptions = {
			center:Position,//ตำแหน่งแสดงแผนที่เริ่มต้น
			scrollwheel: false,
			zoom:20,//
			mapTypeId: mapsGoo.MapTypeId.ROADMAP  //ชนิดของแผนที่
		};
		
		var map = new mapsGoo.Map(document.getElementById("map_canvas"),myOptions);
		//var infowindow = new mapsGoo.InfoWindow();
		
		var marker = new mapsGoo.Marker({//เรียกเมธอดMarker(ปักหมุด)
			position: Position,
			draggable:true,
			title:"คลิกแล้วเคลื่อนย้ายหมุดไปยังตำแหน่งที่ต้องการ",
			})
			
		var Posi=marker.getPosition();//เลือกเมธอดแสดงตำแหน่งของตัวปักหมุด
			myMaps_locat(Posi.lat(),Posi.lng());
			marker.setMap(map);//แสดงตัวปักหมุดโลด!!
			//ตรวจจับเหตุการณ์ต่างๆ ที่เกิดใน google maps
			
		mapsGoo.event.addListener(marker, 'dragend', function(ev){//ย้ายหมุด
			var location =ev.latLng;
			myMaps_locat(location.lat(),location.lng());
		});
		
		mapsGoo.event.addListener(marker, 'click', function(ev) {//คลิกที่หมุด
			var location =ev.latLng;
			myMaps_locat(location.lat(),location.lng());
		});
		
		mapsGoo.event.addListener(map,'zoom_changed',function(ev){//ซูมแผนที่
			zoomLevel = map.getZoom();//เรียกเมธอด getZoom จะได้ค่าZoomที่เป็นตัวเลข
			$('#mapsZoom').val(zoomLevel);//เอาค่า Zoom Level ไปแสดงที่ Tag HTML ที่มีแอตทริบิวต์ id ชื่อ mapsZoom
		});
	}
	
	function myMaps_locat(lat,lng){
		$('#mapsLat').val(lat);//เอาค่าละติจูดไปแสดงที่ Tag HTML ที่มีแอตทริบิวต์ id ชื่อ mapsLat
		$('#mapsLng').val(lng);//เอาค่าลองติจูดไปแสดงที่ Tag HTML ที่มีแอตทริบิวต์ id ชื่อ mapsLng
	}
	$(document).ready(function(){
		myMaps();//แสดงแผนที่
		$('#maps_form').myMaps_submit();//ตรวจสอบการSubmit Form
	});
	
</script>
	ชั้นที่ <?php echo $floor ?>
</head>

<body>
	</br>
	<table border="0" cellpadding="1" cellspacing="1" align = "left">
		<tr>
			<td valign ="top" width = "700" align = "left"> 
				<div id="map_canvas" style="width:600px; height:450px; left : 20px;"></div>
				<div id="contain_map2" style="width:650px; left : 20px; ">
					<form action="saveap.php" method="post" id="maps_form">	
					<table border="0" cellpadding="3" cellspacing="0" style="border:1px;dashed #999;">
					AP Name
					<input type="text" name="ap_name" id="ap_name" />
					<select name="interface">
						<option value="10001">FastEthernet 0/1</option>
						<option value="10002">FastEthernet 0/2</option>
						<option value="10003">FastEthernet 0/3</option>
						<option value="10004">FastEthernet 0/4</option>
						<option value="10005">FastEthernet 0/5</option>
						<option value="10006">FastEthernet 0/6</option>
						<option value="10007">FastEthernet 0/7</option>
						<option value="10008">FastEthernet 0/8</option>
						<option value="10009">FastEthernet 0/9</option>
						<option value="10010">FastEthernet 0/10</option>
						<option value="10011">FastEthernet 0/11</option>
						<option value="10012">FastEthernet 0/12</option>
						<option value="10013">FastEthernet 0/13</option>
						<option value="10014">FastEthernet 0/14</option>
						<option value="10015">FastEthernet 0/15</option>
						<option value="10016">FastEthernet 0/16</option>
						<option value="10017">FastEthernet 0/17</option>
						<option value="10018">FastEthernet 0/18</option>
						<option value="10019">FastEthernet 0/19</option>
						<option value="10020">FastEthernet 0/20</option>
						<option value="10021">FastEthernet 0/21</option>
						<option value="10022">FastEthernet 0/22</option>
						<option value="10023">FastEthernet 0/23</option>
						<option value="10024">FastEthernet 0/24</option>	
					</select>
					<?php 
					//จำนวนชั้น
					//<input type="text" name="floors" id="floors" />
					?>
					<td><input name="bt_savemaps" id="bt_savemaps" type="submit" value="บันทึกข้อมูล" />
					<span id="loadding"></span></td>
					<input type="hidden" name="bu_id" id="bu_id" value=<?php echo $bu_id?> />
					<input type="hidden" name="floor" id="floor" value=<?php echo $floor?> />
					<input type="hidden" name="mapsLat" id="mapsLat" />
					<input type="hidden" name="mapsLng" id="mapsLng" />
					<input type="hidden" name="mapsZoom" id="mapsZoom" value="20" />
					</table>
					</form>		
					<br>
				</div>	
			</td>				
		</tr>
	</table>

	
</body>





</html>