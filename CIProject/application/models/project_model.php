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
    public function getoneAp($id=''){
        return $this->db->where("ap_id",$id)->get("ap_maps")->row();
    }
    public function getsetting(){
        return $this->db->get("setting")->result();
    }
    public function save($ar = array()){
        $this->db->insert("tb_mapsgoo",$ar);
    }
    public function saveAp($ar = array()){
        $this->db->insert("ap_maps",$ar);
    }
    public function update($id,$ar = array()){
        $this->db->where("id_mps",$id)->update("tb_mapsgoo",$ar);
    }
    public function updateAp($id,$ar = array()){
        $this->db->where("ap_id",$id)->update("ap_maps",$ar);
    }
    public function updatesetting($ar = array()){
        $this->db->update("setting",$ar);
    }
    public function getallap($id,$floor){
        $this->db->select('*');
        $this->db->from('ap_maps');
        $this->db->where('bu_id', $id);
        $this->db->where('floor', $floor);
        $query = $this->db->get();
        return $query->result();
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
            $icon_image =  site_url("/images/darkgreen_MarkerO.png"); //marker สีเขียว
          }
          else if($maxBandwidth>$setR){
            $icon_image = site_url("/images/red_MarkerO.png"); //marker สีแดง
          }
          else{
            $icon_image = site_url("/images/yellow_MarkerO.png"); //marker สีเหลือง
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


    public function getjsonap($id,$floor){
        $results = array();
        $aps = array();
        $query = $this->db->get('setting');
        foreach ($query->result() as $row)
        {
                $setR  = $row->red;
                $setY = $row->yellow;
        }
        $this->db->select('*');
        $this->db->from('ap_maps');
        $this->db->where('bu_id', $id);
        $this->db->where('floor', $floor);
        $query = $this->db->get();
        $i=0;
        foreach ($query->result() as $ap) {
          $string = $ap->ap_name;
          if(($ap->status)==2){
            $status = 'down';
            $icon_image = site_url("/images/red_MarkerX.png");
          }
          else{
            $status = 'up';
            if(($ap->OutOctets)<$setY){
              $icon_image =  site_url("/images/darkgreen_MarkerO.png"); //marker สีเขียว
            }
            else if(($ap->OutOctets)>$setR){
              $icon_image = site_url("/images/red_MarkerO.png"); //marker สีแดง
            }
            else{
              $icon_image = site_url("/images/yellow_MarkerO.png"); //marker สีเหลือง
            }
          }

          $newArr = array(
            "iconimage"=>$icon_image,
            "ap_id"=>$ap->ap_id,
            "ap_name"=>$ap->ap_name,
            "bu_id"=>$ap->bu_id,
            "floor"=>$ap->floor,
            "ap_lat"=>$ap->ap_lat,
            "ap_lng"=>$ap->ap_lng,
            "Interface"=>$ap->Interface,
            "ap_traffic"=>$ap->ap_traffic,
            "OutOctets"=>$ap->OutOctets,
            "status"=>$status,
          );
          $results[$i] = $newArr;
          $i++;
        }

        echo json_encode($results);
    }


}
?>
