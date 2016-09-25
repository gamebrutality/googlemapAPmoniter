<!doctype html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css">
<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6M92k8lcjbhKz3-jGXpjWxOXRGWH76Cw&sensor=SET_TO_TRUE_OR_FALSE">  <!-- key google map api -->
</script>
<script type="text/javascript" src="<?php echo base_url();?>bootstrap/js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
<script>
	var lat='<?=$rs->lat_mps?>';
	var lng='<?=$rs->lng_mps?>';

	function myMaps() {
		var mapsGoo=google.maps;
		var Position=new mapsGoo.LatLng(lat,lng);//ละติจูด,ลองติจูด เริ่มต้น
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
</head>

<body>
	<div class="container" style="margin-top:20px">
    <div class="row">
      <div class="col-md-12">
				<div id="map_canvas" style="width:100%; height:450px;"></div>
				<div id="contain_map2"></div>
			</div>
			</br>
		</div>
		<div class=row>
				<form action="<?php echo site_url("project/addAp/".$bu_id."/".$floor);?>" method="post" id="maps_form">
					<div class"col-xs-2">
						AP Name
						<input type="text" name="ap_name" id="ap_name" />
					</div>
					</br>
					<div class"col-xs-2">
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
					</div>
				</div>
			</br>
			<div class="row">
						<input name="bt_savemaps" id="bt_savemaps" type="submit" value="บันทึกข้อมูล" />
						<span id="loadding"></span></td>
						<input type="hidden" name="bu_id" id="bu_id" value=<?php echo $bu_id?> />
						<input type="hidden" name="floor" id="floor" value=<?php echo $floor?> />
						<input type="hidden" name="mapsLat" id="mapsLat" />
						<input type="hidden" name="mapsLng" id="mapsLng" />
						<input type="hidden" name="mapsZoom" id="mapsZoom" value="20" />
				</form>
			</div>
		</div>


</body>





</html>
