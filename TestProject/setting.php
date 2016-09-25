<title>Setting</title>
<?php
	$conn=mysql_connect('localhost','root');
	mysql_select_db('test',$conn);
	mysql_query('SET NAMES utf8');
	
	$strSQL = 'SELECT * FROM setting';
	$objQuery = mysql_query($strSQL) or die (mysql_error());
	$setting = mysql_fetch_array($objQuery);
?>
<?php
if(isset($_POST['new_setting_yellow'])){
	$updateSQL = 'UPDATE setting SET yellow = '.$_POST["new_setting_yellow"].',red = '.$_POST["new_setting_red"].',host = "'.$_POST["new_setting_host"].'"';
	//echo $updateSQL;
	mysql_query($updateSQL);
	echo 	'<script language="javascript">
					window.alert("แก้ไขข้อมูลเรียบร้อย");
					opener.location.reload(true);
					window.close();
				</script>';
}
?>

<h1>Setting</h1>
<form action="setting.php" method="post" id="maps_form">	
	<img src = "images/yellow_MarkerO.png"> เมื่อ Bandwidth > 
	<input type="text" name="new_setting_yellow" id="new_setting_yellow" value="<?php echo $setting['yellow'] ?>" /> Mbps.</br></br>
	<img src = "images/red_MarkerO.png"> เมื่อ Bandwidth > 
	<input type="text" name="new_setting_red" id="new_setting_red" value="<?php echo $setting['red'] ?>" /> Mbps.</br></br></br>
	host ip :
	<input type="text" name="new_setting_host" id="new_setting_host" value="<?php echo $setting['host'] ?>" /></br></br>
	<input name="new_bt_savemaps" id="bt_savemaps" type="submit" value="บันทึกข้อมูล" /><span id="loadding"></span>
</form>