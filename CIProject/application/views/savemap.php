<!doctype html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css">
<script type="text/javascript"
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6M92k8lcjbhKz3-jGXpjWxOXRGWH76Cw&sensor=SET_TO_TRUE_OR_FALSE">  <!-- key google map api -->
</script>
<script type="text/javascript" src="<?php echo base_url();?>bootstrap/js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
<script>
  var jsonurl = "<?php echo site_url("project/getjson/");?>";
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
    var AMarkers = [];
    function getjsondata(){
      for (var i = 0; i < AMarkers.length; i++) {
				AMarkers[i].setMap(null);
			}
			AMarkers = [];
        $.ajax({
          url:jsonurl,
          data:"",
          type:"POST",
          success:function(result){

            var obj = jQuery.parseJSON(result);
            if(obj != ''){
              $.each(obj, function(key, val) {
                //alert(val["name_mps"]);
                var loca = new mapsGoo.LatLng(parseFloat(val["lat_mps"]),parseFloat(val["lng_mps"]));
									//alert(parseFloat(val["traffic_max"]));
									var tit = val["name_mps"]+"\nUp: "+val["sUp"]+"\nDown: "+val["sDown"];
                  var icon_image = val["iconimage"];
									var marker = new mapsGoo.Marker({//เรียกเมธอดMarker(ปักหมุด)
											position: loca,
											icon: icon_image,
											draggable:false,
											title:tit,
											//title:val['maxBandwidth'],
											})

									AMarkers.push(marker);


              });
              for (var i = 0; i < AMarkers.length; i++) {
							AMarkers[i].setMap(map);
						}
            }
          },
          error:function(err){
            alert("ERROR"+err);
          }
        });
      }setInterval(getjsondata, 3000);

  }
    $(document).ready(function(){
      myMaps()
    });
    </script>
<head>
    <title>Google Map</title>
</head>
</br>
<body>
  <div class="container" style="margin-top:20px">
    <div class="row">
      <div class="col-md-6">
        <div id="map_canvas" style="height:500px ;"></div>
        <div id="contain_map2"></div>
        <br>
        <input type="submit" value="เพิ่ม marker" onclick=;window.open("<?php echo site_url("project/add/");?>","popup","width=720,height=650"); return false;)>
        </br>
        <br>
        <input type="submit" value="Setting" onclick=;window.open("<?php echo site_url("project/setting/");?>","popup","width=400,height=300"); return false;)>
        </br>
        <br>
        </br>
      </div>
      <div class="col-md-6">
        <table width="100%" border="1" cellpadding="3" cellspacing="0" style="border:1px solid #CCC;background-color:#E4E4E4; ">
            <thead>
                <tr>
                      <td align="center"><strong>ชื่อสถานที่</strong></td>
                      <td align="center"><strong>ละติจูด</strong></td>
                      <td align="center"><strong>ลองติจูด</strong></td>
                  	  <td align="center"><strong>จำนวนชั้น</strong></td>
                      <td align="center"><strong>ซูม</strong></td>
                  	  <td align="center"><strong></strong></td>
                  	  <td align="center"><strong></strong></td>
                </tr>
            </thead>
                <?php if(count($rs)>0):
                ?>
                    <?php foreach($rs as $r):?>
                        <tr>
                            <td align="center"><a href="<?php echo site_url("project/showbuilding/".$r->id_mps)?>" target="_blank"><?php echo $r->name_mps;?></a></td>
                            <td align="center"><?php echo $r->lat_mps;?></td>
                            <td align="center"><?php echo $r->lng_mps;?></td>
                            <td align="center"><?php echo $r->floors;?></td>
                            <td align="center"><?php echo $r->zoom_mps;?></td>
                            <td align="center">
                              <form action=<?php echo site_url("project/delete/".$r->id_mps);?>>
                          			<input type="submit" value="ลบ" onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')";>
                          		</form>
                            </td>
                            <td align="center">
                              <input type="submit" value="แก้ไข" onclick=;window.open("<?php echo site_url("project/edit/".$r->id_mps);?>","popup","width=720,height=650"); return false;)>
                            </td>
                        </tr>
                    <?php
                    endforeach;?>
                <?php endif;?>
          </table>
      </div>
    </div>
  </div>
</body>
</br>
</html>
