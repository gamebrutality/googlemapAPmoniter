<?php
class Project_model extends CI_MODEL
{
    public function __construct(){
        parent::__construct();
    }
    public function getall(){
        return $this->db->get("tb_mapsgoo")->result();
    }
    public function getone($id=''){
        return $this->db->where("id_mps",$id)->get("tb_mapsgoo")->row();
    }
    public function getsetting(){
        return $this->db->get("setting")->result();
    }
    public function save($ar = array()){
        $this->db->insert("tb_mapsgoo",$ar);
    }
    public function update($id,$ar = array()){
        $this->db->where("id_mps",$id)->update("tb_mapsgoo",$ar);
    }
    public function updatesetting($ar = array()){
        $this->db->update("setting",$ar);
    }
    public function getjson(){

        $results = array();
        $aps = array();
        $query = $this->db->get('setting');
        foreach ($query->result() as $row)
        {
                $setR  = $row->red;
                $setY = $row->yellow;
        }


        $rs = $this->db->get("tb_mapsgoo")->result();
        $i = 0;
        $red = 0;
        foreach ($rs as $r) {
          $maxBandwidth = 0;
          $sUp = 0;
          $sDown = 0;
          $aps = json_encode($this->db->where("bu_id",$r->id_mps)->get("ap_maps")->result());
          $ap2s = json_decode($aps);
          foreach($ap2s as $ap2){
            if($ap2->status == 2){
              $sDown++;
            }
            else
            {
              $sUp++;
            }
            $bandWidth = $ap2->OutOctets;
					  if($bandWidth>$maxBandwidth){
              $maxBandwidth = $bandWidth;
            }
          }
          if($maxBandwidth<$setY){
            $icon_image = "images/darkgreen_MarkerO.png"; //marker สีเขียว
          }
          else if($maxBandwidth>$setR){
            $icon_image = "images/red_MarkerO.png"; //marker สีแดง
          }
          else{
            $icon_image = "images/yellow_MarkerO.png"; //marker สีเหลือง
          }
          $newArr = array(
            "iconimage"=>$icon_image,
            "id_mps"=>$r->id_mps,
            "sUp"=>$sUp,
            "sDown"=>$sDown,
            "maxBandwidth"=>$maxBandwidth,
            "name_mps"=>$r->name_mps,
            "lat_mps"=>$r->lat_mps,
            "lng_mps"=>$r->lng_mps,
            "floors"=>$r->floors,
            "zoom_mps"=>$r->zoom_mps,
            "traffic_max"=>$r->traffic_max,
          );

          $results[$i] = $newArr;
          $i++;
      }
        echo json_encode($results);
    }

}
?>
