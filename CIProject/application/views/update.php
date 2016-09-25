<!doctype html>
<title>แผนที่ Google</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css">
<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6M92k8lcjbhKz3-jGXpjWxOXRGWH76Cw&sensor=SET_TO_TRUE_OR_FALSE">  <!-- key google map api -->
</script>
<script type="text/javascript" src="<?php echo base_url();?>bootstrap/js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
<script>

	function myMaps(lat_show_mps,lng_show_mps) {
		var mapsGoo=google.maps;
		var Position=new mapsGoo.LatLng(lat_show_mps,lng_show_mps);//ละติจูด,ลองติจูด เริ่มต้น
		var myOptions = {
			center:Position,//ตำแหน่งแสดงแผนที่เริ่มต้น
			//scrollwheel: false,
			zoom:18,//
			mapTypeId: mapsGoo.MapTypeId.SATELLITE //ชนิดของแผนที่
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
		myMaps(<?php echo $rs->lat_mps?>,<?php echo $rs->lng_mps  ?>);//แสดงแผนที่
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
		</div>
		</br>
		<div class=row>
			<form action=<?php echo site_url("project/edit/".$rs->id_mps)?> method="post" id="maps_form">
			<div class"col-xs-2">
				ตึก/อาคาร
				<input type="text" name="new_locat_name" id="locat_name" value="<?php echo $rs->name_mps ?>" />
			</div>
		</br>
			<div class"col-xs-2">
				จำนวนชั้น
				<input type="text" name="new_floors" id="floors" value="<?php echo $rs->floors ?>"/>
			</div>
	</div>
	</br>
	<div class="row">
		<input name="new_bt_savemaps" id="bt_savemaps" type="submit" value="บันทึกข้อมูล" />
		<span id="loadding"></span></td>
		<input type="hidden" name="edit_map_id" value="<?php echo $rs->id_mps ?>"/>
		<input type="hidden" name="new_mapsLat" id="mapsLat" />
		<input type="hidden" name="new_mapsLng" id="mapsLng" />
		<input type="hidden" name="new_mapsZoom" id="mapsZoom" value="20" />
		</form>
	</div>
</div>
</body>
</html>
