<!doctype html>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css">
  <script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6M92k8lcjbhKz3-jGXpjWxOXRGWH76Cw&sensor=SET_TO_TRUE_OR_FALSE">  <!-- key google map api -->
  </script>
  <script type="text/javascript" src="<?php echo base_url();?>bootstrap/js/jquery-3.1.0.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
  <script>
    var jsonurl = "<?php echo site_url('project/getjsonap/'.$bus->id_mps.'/'.$floor);?>";
    var lat='<?php echo $bus->lat_mps ?>';
    var lng='<?php echo $bus->lng_mps ?>';
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
    var AMarkers = [];
    function getjsondata(){
      for (var i = 0; i < AMarkers.length; i++) {
				AMarkers[i].setMap(null);
			}
			AMarkers = [];
        //alert(jsonurl);
        $.ajax({
          url:jsonurl,
          data:"",
          type:"POST",
          success:function(result){

            var obj = jQuery.parseJSON(result);
            if(obj != ''){
              $.each(obj, function(key, val) {
                var showInterface = val["Interface"]-10000;
                //alert(val["ap_name"]);
                var loca = new mapsGoo.LatLng(parseFloat(val["ap_lat"]),parseFloat(val["ap_lng"]));
									//alert(parseFloat(val["traffic_max"]));
									var tit = "AP: "+val['ap_name']+"\nInterface: Fa0/"+showInterface+"\nstatus: "+val['status']+"\nBanwidth: "+val['OutOctets']+" Mbps";
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
<html lang="th">
<head>
    <meta charset="utf-8"/>
    <title>savemap</title>
</head>
</br>
<body>
  <td bgcolor="#E1E1E1"><h1>ชั้น <?php echo $floor;?></h1></td>
	<td bgcolor="#E1E1E1"></td>

  <div class="container" style="margin-top:20px">
    <div class="row">
      <div class="col-xs-9">
        <div id="map_canvas" style="height:400px"></div>
        <div id="contain_map2"></div>
        <br>
          <input type="submit" value="เพิ่ม AP" onclick=;window.open("<?php echo site_url("project/addAp/".$bus->id_mps."/".$floor);?>","popup","width=720,height=650"); return false;)>
        </br>
        <br>
        </br>
      </div>
      <div class="col-xs-3">
        <table width="100%" border="1" cellpadding="3" cellspacing="0" style="border:1px solid #CCC;background-color:#E4E4E4; ">
            <thead>
                <tr>
                  <div style="width:100%">
                    <td align="center"><strong>AP</strong></td>
                </tr>
            </thead>
            <tbody>
                <?php if(count($rs)>0):
                ?>
                    <?php foreach($rs as $r):?>
                        <tr>
                          <td><?php echo $r->ap_name;?></td>
                            <td align="center">
                              <form action=<?php echo site_url("project/deleteap/".$r->ap_id."/".$bus->id_mps."/".$floor);?>>
                          			<input type="submit" value="ลบ" onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')";>
                          		</form>
                            </td>
                            <td align="center">
                              <input type="submit" value="แก้ไข" onclick=;window.open("<?php echo site_url("project/editAp/".$r->ap_id);?>","popup","width=720,height=650"); return false;)>
                            </td>
                        </tr>
                    <?php
                    endforeach;?>
                <?php endif;?>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</br>
</html>
