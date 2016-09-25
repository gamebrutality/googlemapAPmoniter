<!doctype html>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css">
  <script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6M92k8lcjbhKz3-jGXpjWxOXRGWH76Cw&sensor=SET_TO_TRUE_OR_FALSE">  <!-- key google map api -->
  </script>
  <script type="text/javascript" src="<?php echo base_url();?>bootstrap/js/jquery-3.1.0.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
  <script>
		var name='<?=$rs->name_mps?>';
		var lat='<?=$rs->lat_mps?>';
		var lng='<?=$rs->lng_mps?>';
		var zoom='<?=$rs->zoom_mps?>';


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
.row {
background-color: #e3e3e3;
}

</style>

</head>

<body>
  <div class="container".bg-info style="margin-top:20px">
    <div class="row">
      <div class="col-md-2">
        <p class="bg-primary"></p>
      </div>
      <div class="col-md-10">
        <p><h1><?=$rs->name_mps?></h1></p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-2">
      			<p><strong>แสดงผลการทำงานของ AP</strong></p>
      </div>
      <div class="col-md-8">
        	<td bgcolor="#E1E1E1"><div id="map_canvas" style="height:400px"></div></td>
      </div>
    </div>
    <?php
    for($i=0;$i < $rs->floors; $i++){ ?>
      <div class="row">
        <div class="col-md-2">
    			<p><strong>แสดงการทำงานของ AP ที่ช้ัน  <?php echo $i+1 ?></strong></p>
        </div>
        <div class="col-md-8">
    			<p><iframe src="<?php echo site_url("project/showfloor/".$rs->id_mps."/".($i+1)); ?>" height="650" width="100%" frameborder="0"></></iframe></p>
        </div>
      </div>
    <?php }  ?>
  </div>




</body>

</html>
