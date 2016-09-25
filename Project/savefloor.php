
<?php
	$conn=mysql_connect('localhost','root');
	mysql_select_db('project',$conn);
	mysql_query('SET NAMES utf8');
	
	if(isset($_POST['locat_name'])){
		$locatName=$_POST['locat_name'];
		$floors=$_POST['floors'];
		$lat=$_POST['mapsLat'];
		$lng=$_POST['mapsLng'];
		$mapsZoom=$_POST['mapsZoom'];
		//echo $locatName;
		mysql_query("INSERT INTO tb_mapsgoo(name_mps,lat_mps,lng_mps,floors,zoom_mps) VALUES('$locatName','$lat','$lng','$floors','$mapsZoom')");
		echo 	'<script language="javascript">
					window.alert("บันทึกข้อมูลเรียบร้อย");
					opener.location.reload(true);
					window.close();
				</script>';
	}
	
	if(isset($_POST['edit_map_id'])){
		$editMapId=$_POST['edit_map_id'];
		$nlocatName=$_POST['new_locat_name'];
		$nfloors=$_POST['new_floors'];
		$nlat=$_POST['new_mapsLat'];
		$nlng=$_POST['new_mapsLng'];
		$nmapsZoom=$_POST['new_mapsZoom'];	
		//echo $locatName;
		mysql_query("UPDATE tb_mapsgoo SET name_mps='".$nlocatName."',lat_mps ='".$nlat."',lng_mps='".$nlng."',floors='".$nfloors."',zoom_mps='".$nmapsZoom."' WHERE id_mps = '".$editMapId."'");		
		echo 	'<script language="javascript">
					window.alert("แก้ไขข้อมูลเรียบร้อย");
					opener.location.reload(true);
					window.close();
				</script>';
	}
	

	if(isset($_POST['delete'])) {
	$result = "DELETE FROM tb_mapsgoo WHERE id_mps ='".$_POST['delete']."'";
	mysql_query($result);
	}
	if(isset($_POST['edit'])) {
	$result = "DELETE FROM tb_mapsgoo WHERE id_mps ='".$_POST['delete']."'";
	mysql_query($result);
	}
?>
<table width="100%" border="1" cellpadding="3" cellspacing="0" style="border:1px solid #CCC;background-color:#E4E4E4; "  align = "left">
  <tr>
	<div style="width:100%">
    <td align="center"><strong>AP</strong></td>
	<td align="center"><strong></strong></td>
	<td align="center"><strong></strong></td>
	<div>
  </tr> 
	<?php 
	  $rsMapsGoo=mysql_query('SELECT * FROM tb_mapsgoo ORDER BY name_mps ASC') or die(mysql_error());
	  while($showMapsGoo=mysql_fetch_array($rsMapsGoo)){

	?>
	  <tr>
		<td><a href="showbuilding.php?mapsId=<?=$showMapsGoo['id_mps']?>" target="_blank"><?=$showMapsGoo['name_mps']?></a></td>
		<td><form>
			<input type="submit" value="แก้ไข"; onClick="js_popup('edit-map.php?edit=<?php echo $showMapsGoo['id_mps']?>',720,600); return false;">
		</form></td>
		<td><form action="?" method = "post">
			<input type="hidden" name="delete" value="<?php echo $showMapsGoo['id_mps']?>" />
			<input type="submit" value="ลบ" onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')";>
		</form></td>
	  <tr>
	  <?php } mysql_close($conn);?>
</table>
</div>
<script language="javascript">
function js_popup(theURL,width,height) { //v2.0
	leftpos = (screen.availWidth - width) / 2;
    	toppos = (screen.availHeight - height) / 2;
  	window.open(theURL, "viewdetails","width=" + width + ",height=" + height + ",left=" + leftpos + ",top=" + toppos);
}
</script>