<?php
foreach ($settings as $set)
{
        $setY=$set->yellow;
        $setR=$set->red;
}
?>
<h1>Setting</h1>
<form action="<?php echo site_url("project/setting");?>" method="post" id="maps_form">
  <img src = <?php echo site_url("images/yellow_MarkerO.png");?>> เมื่อ Bandwidth >
	<input type="text" name="new_setting_yellow" id="new_setting_yellow" value="<?php echo $setY ?>" /> Mbps.</br></br>
	<img src = <?php echo site_url("images/red_MarkerO.png");?>> เมื่อ Bandwidth >
	<input type="text" name="new_setting_red" id="new_setting_red" value="<?php echo $setR ?>" /> Mbps.</br></br></br>
	<input name="new_bt_savemaps" id="bt_savemaps" type="submit" value="บันทึกข้อมูล" /><span id="loadding"></span>
</form>
