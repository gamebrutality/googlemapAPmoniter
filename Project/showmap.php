<!DOCTYPE html>
<html>
<head>
<title>Traffic Monitoring</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA6M92k8lcjbhKz3-jGXpjWxOXRGWH76Cw&sensor=true&language=th"></script> <!-- key google map api -->
<script src="http://code.jquery.com/jquery-latest.js"></script>
<meta charset=utf-8 />
<?php
	$conn=mysql_connect('localhost','root');
	mysql_select_db('project',$conn);
	mysql_query('SET NAMES utf8');
	
	$settingSQL = 'SELECT * FROM setting';
	$settingQuery = mysql_query($settingSQL) or die (mysql_error());
	$setting = mysql_fetch_array($settingQuery);
	//echo $setting['yellow'];
?>
<script>
	var setY = <?php echo $setting['yellow']; ?>;
	var setR = <?php echo $setting['red']; ?>;
	function myMaps() {
		var mapsGoo=google.maps;
		var Position=new mapsGoo.LatLng(18.795328925316536,98.95223134589389);//ละติจูด,ลองติจูด เริ่มต้น 
		var myOptions = {
			center:Position,//ตำแหน่งแสดงแผนที่เริ่มต้น
			//scrollwheel: false,
			zoom:17,//
			mapTypeId: mapsGoo.MapTypeId.SATELLITE //ชนิดของแผนที่
		};
		
		var map = new mapsGoo.Map(document.getElementById("map_canvas"),myOptions);
		//var infowindow = new mapsGoo.InfoWindow();
		
	var AMarkers = [];
	function getDataFromDb(){
			for (var i = 0; i < AMarkers.length; i++) {
				AMarkers[i].setMap(null);
			}
			AMarkers = [];
			
	$.ajax({ 
				url: "getdata.php" ,
				type: "POST",
				data: ''
			})
			.success(function(result) { 
				var obj = jQuery.parseJSON(result);
					if(obj != '')
					{
						  //$("#myTable tbody tr:not(:first-child)").remove();
						  //$("#myBody").empty();
						  $.each(obj, function(key, val) {
									var loca = new mapsGoo.LatLng(parseFloat(val["lat_mps"]),parseFloat(val["lng_mps"]));
									//alert(parseFloat(val["traffic_max"]));
									if(parseFloat(val["maxBandwidth"])<setY){   
										var icon_image = "images/darkgreen_MarkerO.png"; //marker สีเขียว
									}
									else if(parseFloat(val["maxBandwidth"])>setR){
										var icon_image = "images/red_MarkerO.png"; //marker สีแดง
									}
									else{
										var icon_image = "images/yellow_MarkerO.png"; //marker สีเหลือง
									}
									var tit = val["name_mps"]+"\nUp: "+val["sUp"]+"\nDown: "+val["sDown"];
									var marker = new mapsGoo.Marker({//เรียกเมธอดMarker(ปักหมุด)
											position: loca,
											icon: icon_image,
											draggable:false,
											title:tit,
											//title:val['maxBandwidth'],
											})
											
									AMarkers.push(marker);	
										//แสดงตัวปักหมุดโลด!!
										//ตรวจจับเหตุการณ์ต่างๆ ที่เกิดใน google maps
						});
						for (var i = 0; i < AMarkers.length; i++) {
							AMarkers[i].setMap(map);
						}
					}
					

			});

		}setInterval(getDataFromDb, 5000);   // 1000 = 1 second			
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
	});
</script>
</head>
<body>
 <center>

<table border="0" cellpadding="1" cellspacing="1" align = "left">
		<tr>
			<td valign ="top" width = "650" align = "left"> 
			</br>
				<div id="map_canvas" style="width:640px; height:500px; left : 20px;"></div>
				<div id="contain_map2" style="width:620px; left : 20px; ">	
					</br>
					<form>
						<input type ="submit" value="add marker" onClick="window.open('add_building.php','Windowname','width=720,height=600');">
					</form>
					</br>
					<form>
						<input type="submit" value="setting"; onClick="window.open('setting.php','Windowname','width=400,height=300');">
				</form>
					</br>
				</div>	
			</td>
			<td valign ="top" width ="650" align = "right">
			</br>
				<iframe src="savemaps.php" height="550; overflow-y: scroll; " width="600 overflow-y: scroll;" frameborder="0"></iframe>
			</td>				
	</table>

</body>
</html>