
<?php
	$conn=mysql_connect('localhost','root');
	mysql_select_db('test',$conn);
	mysql_query('SET NAMES utf8');
	
	if(isset($_POST['ap_name'])){
			$apName=$_POST['ap_name'];
			$interface=$_POST['interface'];
			$bu_id=$_POST['bu_id'];
			$floor=$_POST['floor'];
			$lat=$_POST['mapsLat'];
			$lng=$_POST['mapsLng'];
			//echo $interface;
			//echo $floor;
			mysql_query("INSERT INTO ap_maps(ap_name,bu_id,floor,ap_lat,ap_lng,Interface) VALUES('$apName',$bu_id,'$floor','$lat','$lng','$interface')");
			echo 	'<script language="javascript">
						window.alert("บันทึกข้อมูลเรียบร้อย");
						opener.location.reload(true);
						window.close();
					</script>';
	}
	
	
	if(isset($_POST['edit_ap_id'])){
		$editapId=$_POST['edit_ap_id'];
		$nlocatName=$_POST['new_ap_name'];
		$nlat=$_POST['new_apLat'];
		$nlng=$_POST['new_apLng'];
		$newInterface=$_POST['new_interface'];
		$nmapsZoom=$_POST['new_mapsZoom'];	
		//echo $editapId;
		//echo $nlocatName;
		//echo $nlat;
		//echo $nlng;
		mysql_query("UPDATE ap_maps SET ap_name='".$nlocatName."',ap_lat ='".$nlat."',ap_lng='".$nlng."',Interface='".$newInterface."' WHERE ap_id = '".$editapId."'");		
		echo 	'<script language="javascript">
					window.alert("แก้ไขข้อมูลเรียบร้อย");
					opener.location.reload(true);
					window.close();
				</script>';
	}
	

	if(isset($_POST['delete'])) {
	$result = "DELETE FROM ap_maps WHERE ap_id ='".$_POST['delete']."'";
	mysql_query($result);
	}
	if(isset($_POST['edit'])) {
	$result = "DELETE FROM tb_mapsgoo WHERE id_mps ='".$_POST['delete']."'";
	mysql_query($result);
	}
?>
<table width="100%" border="1" cellpadding="3" cellspacing="0" style="border:1px solid #CCC;background-color:#E4E4E4; "  align = "left">
  
	<?php 
	  if(isset($_GET['f'])) {
		//echo $_GET['f'];
		 $select_ap = "SELECT * FROM ap_maps WHERE bu_id ='".$_GET['this_bu_id']."' AND floor ='".$_GET['f']."'";
		 $rsMapsGoo=mysql_query($select_ap) or die(mysql_error());
	  }
	  if(isset($_POST['f'])){
		//echo $_POST['this_bu_id'];
		//echo $_POST['f'];
		$select_ap = "SELECT * FROM ap_maps WHERE bu_id ='".$_POST['this_bu_id']."' AND floor ='".$_POST['f']."'";
		$rsMapsGoo=mysql_query($select_ap) or die(mysql_error());
	  }
	 if(isset($rsMapsGoo)){
	 ?>
	  <tr>
		<div style="width:100%">
		<td align="center"><strong>AP</strong></td>
		<td align="center"><strong></strong></td>
		<td align="center"><strong></strong></td>
		<div>
	  </tr>
	<?php
	  while($showMapsGoo=mysql_fetch_array($rsMapsGoo)){

	?>
	  <tr>
		<td><a><?=$showMapsGoo['ap_name']?></a></td>
		<td><form>
			<input type="submit" value="แก้ไข"; onClick="js_popup('edit-ap.php?edit=<?php echo $showMapsGoo['ap_id']?>',720,600); return false;">
		</form></td>
		<td><form action="?" method = "post">
			<input type="hidden" name="delete" value="<?php echo $showMapsGoo['ap_id']?>" />
			<input type="hidden" name="this_bu_id" value="<?php echo $showMapsGoo['bu_id']?>" />
			<input type="hidden" name="f" value="<?php echo $showMapsGoo['floor']?>" />
			<input type="submit" value="ลบ" onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')";>
		</form></td>
	  <tr>
	  <?php } mysql_close($conn);}?>
</table>
</div>
<script language="javascript">
function js_popup(theURL,width,height) { //v2.0
	leftpos = (screen.availWidth - width) / 2;
    	toppos = (screen.availHeight - height) / 2;
  	window.open(theURL, "viewdetails","width=" + width + ",height=" + height + ",left=" + leftpos + ",top=" + toppos);
}
</script>