<?php
class Project extends CI_CONTROLLER
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("project_model");
  }

  public function index()
  {
    $rs = $this->project_model->getall();
    $data['rs'] = $rs;
    $this->load->view("savemap",$data);
  }

  public function showbuilding($buId){
    $rs = $this->project_model->getone($buId);
    $data['rs'] = $rs;
    $this->load->view("showbuilding",$data);
  }

  public function showfloor($buId,$floor){
    $bus = $this->project_model->getone($buId);
    $data['bus'] = $bus;
    $rs = $this->project_model->getallap($buId,$floor);
    $data['rs'] = $rs;
    $data['buId'] = $buId;
    $data['floor'] = $floor;
    $this->load->view("saveap",$data);
  }

  public function setting()
  {
    if($this->input->POST('new_setting_yellow')!=null)
    {
      $updateSettingArray=array(
        "yellow"=>$this->input->post("new_setting_yellow"),
        "red"=>$this->input->post("new_setting_red"),
      );
      $this->project_model->updatesetting($updateSettingArray);
      echo 	'<script language="javascript">
					window.alert("บันทึกข้อมูลเรียบร้อย");
					opener.location.reload(true);
					window.close();
				</script>';
    }
    $set = $this->project_model->getsetting();
    $data['settings'] = $set;
    $this->load->view("setting",$data);
  }

  public function getallecho()
  {
      $rs = $this->project_model->getall();
        $data['rs'] = $rs;
        echo  json_encode($data);
  }

  public function delete($id)
  {
      $this->db->where("id_mps",$id)->delete("tb_mapsgoo");
      redirect("project");
  }
  public function deleteap($apid,$bu_id,$floor)
  {
      $this->db->where("ap_id",$apid)->delete("ap_maps");
      redirect("project/showfloor/".$bu_id."/".$floor);
  }

  public function edit($id)
  {
    if($this->input->POST('edit_map_id')!=null)
    {
      $updateArray=array(
        "name_mps"=>$this->input->post("new_locat_name"),
        "lat_mps"=>$this->input->post("new_mapsLat"),
        "lng_mps"=>$this->input->post("new_mapsLng"),
        "floors"=>$this->input->post("new_floors"),
        "zoom_mps"=>$this->input->post("new_mapsZoom")
      );
      $this->project_model->update($this->input->POST('edit_map_id'),$updateArray);
      echo 	'<script language="javascript">
					window.alert("บันทึกข้อมูลเรียบร้อย");
					opener.location.reload(true);
					window.close();
				</script>';

    }
    $rs = $this->project_model->getone($id);
    $data['rs'] = $rs;
    $this->load->view("update",$data);
  }

  public function editAp($id)
  {
    if($this->input->POST('edit_ap_id')!=null)
    {
      $updateArray=array(
        "ap_name"=>$this->input->post("new_ap_name"),
        "ap_lat"=>$this->input->post("new_apLat"),
        "ap_lng"=>$this->input->post("new_apLng"),
        "Interface"=>$this->input->post("new_interface")
      );
      $this->project_model->updateAp($this->input->POST('edit_ap_id'),$updateArray);
      echo 	'<script language="javascript">
					window.alert("บันทึกข้อมูลเรียบร้อย");
					opener.location.reload(true);
					window.close();
				</script>';

    }
    $rs = $this->project_model->getoneAp($id);
    $data['rs'] = $rs;
    $this->load->view("updateAp",$data);
  }

  public function add()
  {
    if($this->input->POST('locat_name')!=null)
    {
      if($this->input->POST('floors')==null){
        $ffloors = 1;
      }
      else{
        $ffloors = $this->input->post("floors");
      }
      $inserArray=array(
        "name_mps"=>$this->input->post("locat_name"),
        "lat_mps"=>$this->input->post("mapsLat"),
        "lng_mps"=>$this->input->post("mapsLng"),
        "floors"=>$ffloors,
        "zoom_mps"=>$this->input->post("mapsZoom")
      );
      $this->project_model->save($inserArray);
      echo 	'<script language="javascript">
					window.alert("บันทึกข้อมูลเรียบร้อย");
					opener.location.reload(true);
					window.close();
				</script>';
    }
    $this->load->view("addBuilding",$this);
  }

  public function addAp($bu_id,$floor)
  {
    if($this->input->POST('ap_name')!=null)
    {
      $inserArray=array(
        "ap_name"=>$this->input->post("ap_name"),
        "bu_id"=>$this->input->post("bu_id"),
        "floor"=>$this->input->post("floor"),
        "ap_lat"=>$this->input->post("mapsLat"),
        "ap_lng"=>$this->input->post("mapsLng"),
        "Interface"=>$this->input->post("interface")
      );
      $this->project_model->saveAp($inserArray);
      echo 	'<script language="javascript">
					window.alert("บันทึกข้อมูลเรียบร้อย");
					opener.location.reload(true);
					window.close();
				</script>';
    }
    $rs = $this->project_model->getone($bu_id);
    $data['rs']=$rs;
    $data['bu_id']=$bu_id;
    $data['floor']=$floor;
    $this->load->view("addAp",$data);
  }

  public function getjson()
  {
    $rs = $this->project_model->getjson();
    echo $rs;
  }
  public function getjsonap($id,$floor)
  {
    $rs = $this->project_model->getjsonap($id,$floor);
    echo $rs;
  }

}
?>
