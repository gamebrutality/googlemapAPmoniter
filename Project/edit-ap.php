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

	if(isset($_GET['edit'])) {
	$result = "SELECT * FROM ap_maps WHERE ap_id ='".$_GET['edit']."'";
	$edit_data = mysql_query($result);
	$show_edit_data=mysql_fetch_array($edit_data);
	}
?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA6M92k8lcjbhKz3-jGXpjWxOXRGWH76Cw&sensor=true&language=th"></script> <!-- key google map api -->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

<script type="text/javascript">

	function myMaps(lat_show_mps,lng_show_mps) {
		var mapsGoo=google.maps;
		var Position=new mapsGoo.LatLng(lat_show_mps,lng_show_mps);//ละติจูด,ลองติจูด เริ่มต้น 
		var myOptions = {
			center:Position,//ตำแหน่งแสดงแผนที่เริ่มต้น
			//scrollwheel: false,
			zoom:20,//
			mapTypeId: mapsGoo.MapTypeId.ROADMAP //ชนิดของแผนที่
		};
		
		var map = new mapsGoo.Map(document.getElementById("map_canvas"),myOptions);
		//var infowindow = new mapsGoo.InfoWindow();
		
		var marker = new mapsGoo.Marker({//เรียกเมธอดMarker(ปักหมุด)
			position: Position,
			draggable:true,
			title:"คลิกแล้วเคลื่อนย้ายหมุดไปยังตำแหน่งที่ต้องการ",
			});
			
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
		myMaps(<?php echo $show_edit_data['ap_lat']?>,<?php echo $show_edit_data['ap_lng']?>);//แสดงแผนที่
		$('#maps_form').myMaps_submit();//ตรวจสอบการSubmit Form
	});
	
</script>
</head>

<body>
	</br>
	<table border="0" cellpadding="1" cellspacing="1" align = "left">
		<tr>
			<td valign ="top" width = "700"> 
				<div id="map_canvas" style="width:680px; height:450px; left : 20px;"></div>
				<div id="contain_map2" style="width:650px; left : 20px; ">
					<form action="saveAp.php" method="post" id="maps_form">	
					<table border="0" cellpadding="3" cellspacing="0" style="border:1px;dashed #999;">
					ตึก/อาคาร
					<input type="text" name="new_ap_name" id="local_name" value="<?php echo $show_edit_data['ap_name'] ?>" />
					<select name="new_interface">
						<option value="<?php echo $show_edit_data['Interface'] ?>">FastEthernet 0/<?php echo ($show_edit_data['Interface']-10000) ?></option>
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
					<td><input name="new_bt_savemaps" id="bt_savemaps" type="submit" value="บันทึกข้อมูล" />
					<span id="loadding"></span></td>
					<input type="hidden" name="edit_ap_id" value="<?php echo $show_edit_data['ap_id'] ?>"/>
					<input type="hidden" name="new_apLat" id="mapsLat" />
					<input type="hidden" name="new_apLng" id="mapsLng" />
					<input type="hidden" name="new_mapsZoom" id="mapsZoom" value="20" />
					</table>
					</form>		
					<br>
				</div>	
			</td>
			<td valign ="top" width ="500">
				<div id="show_locat" ></div>
			</td>				
		</tr>
	</table>
	<div id="show_locat"></div>	
</body>
</html>