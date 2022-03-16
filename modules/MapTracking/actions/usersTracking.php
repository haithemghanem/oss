<?php

class MapTracking_usersTracking_Action extends Vtiger_BasicAjax_Action {

    public function process(Vtiger_Request $request) {
        switch ($request->get("mode")) {
            case 'getLocation'	: $result = $this->getLocation($request);
									break;
            case 'setLocation'  : $result = $this->setLocation($request);
                                    break;
             case 'usersainTracking'  : $result = $this->updateuserinfo($request);
                                    break;                     
        
        }
         echo json_encode($result);
    }
    
    
    /**
     * get address for the record, based on the module type.
     * @param Vtiger_Request $request
     * @return type 
     */
    function setLocation(Vtiger_Request $request) {
        $resultret =array();
         $lat=$request->get('lat');
         $lng=$request->get('lng');
         $name=$request->get('name');
         if($lat =="" || $lat==null || $lng=="" || $lng==null){
              $resultret['status']="Error";

         }else{

        $db = PearDatabase::getInstance();
        $currentUser = Users_Record_Model::getCurrentUserModel();
        $userid=$currentUser->getId();
        $activationtracking=$currentUser->get('activationtracking');
        $trackingperiods=$currentUser->get('trackingperiods');
        $trackingperiodsintger;
        $data=date('Y-m-d');
        $time= date('H:i:s', time());
        switch ($trackingperiods){
          case '1 minutes' :  $trackingperiodsintger= 1; break;
          case '5 minutes' :  $trackingperiodsintger= 5; break;
          case '10 minutes' : $trackingperiodsintger= 10; break;
          case '15 minutes' : $trackingperiodsintger= 15; break;
          case '20 minutes' : $trackingperiodsintger= 20; break;
          case '25 minutes' : $trackingperiodsintger= 25; break;
          case '30 minutes' : $trackingperiodsintger= 30; break;
          case '35 minutes' : $trackingperiodsintger= 35; break;
          case '40 minutes' : $trackingperiodsintger= 40; break;
          case '45 minutes' : $trackingperiodsintger= 45; break;
          case '50 minutes' : $trackingperiodsintger= 50; break;
          case '55 minutes' : $trackingperiodsintger= 55; break;
        }
        //SELECT idtracking, name, user, let, lng, dateday, trackingtime, prvtime, type, comment FROM vtiger_trackingtb WHERE 1
         $sql ="SELECT * FROM vtiger_trackingtb  WHERE  dateday=? ORDER BY idtracking DESC LIMIT 1";
          $result = $db->pquery($sql, array($data));
          $notracking = $db->num_rows($result);
           if($notracking > 0){
              $trackingtim=$db->query_result($result, 0, 'trackingtime');
              $dif=date('i', strtotime($trackingtim) - time());
              if( $dif >= $trackingperiodsintger ){
                $sqlinsert ="INSERT INTO vtiger_trackingtb(name ,user,let,lng,dateday,trackingtime,prvtime,type,comment) VALUES (?,?,?,?,?,?,?,?,?)";
               $resultin = $db->pquery($sqlinsert, array("Tracking",$userid,$lat,$lng,$data,$time,$trackingtim,null,null));
              }
            

              $resultret['status']="Seccess: ".$dif;

           }else {
            $sql ="INSERT INTO vtiger_trackingtb(name ,user,let,lng,dateday,trackingtime,prvtime,type,comment) VALUES (?,?,?,?,?,?,?,?,?)";
             $result = $db->pquery($sql, array("Start",$userid,$lat,$lng,$data,$time,null,null,null));
             if($result){
                $resultret['status']="Seccess Insert ";
             }else{
                $resultret['status']="Error in Insert";
             }
           }
        
         }

       return  $resultret;

    }
    /**
     * get address for the record, based on the module type.
     * @param Vtiger_Request $request
     * @return type 
     */
    function getLocation(Vtiger_Request $request) {
        $result =array();
        $status=0;
        $db = PearDatabase::getInstance();
        $alllocation='<markers>';
        $Dateday=$request->get('Dateday');
        $userTracking=$request->get('userTracking');
        
        if($Dateday ==null || $Dateday =="" || $userTracking ==null || $userTracking ==""){

        }else{

          $arrue=array();
          $sql;
          if($userTracking =="All"){
             $sql ="SELECT max(idtracking),name,user,let,lng,dateday,trackingtime,prvtime,type,comment FROM vtiger_trackingtb WHERE  dateday=? GROUP BY user   ORDER by idtracking DESC ";
             $sql='SELECT max(t.idtracking),t.name,t.user,t.let,t.lng,t.dateday,t.trackingtime,t.prvtime,t.type,t.comment,
                vtiger_users.id, CONCAT(vtiger_users.first_name," ",vtiger_users.last_name)as fullname FROM vtiger_trackingtb  t
                INNER JOIN vtiger_users ON  vtiger_users.id=t.user and vtiger_users.status="ACTIVE"
                WHERE t.dateday=?
                GROUP BY t.user   ORDER by t.idtracking DESC';
                $arrue=array($Dateday);
          }else{
              
              $sql='SELECT t.*,
                vtiger_users.id, CONCAT(vtiger_users.first_name," ",vtiger_users.last_name)as fullname FROM vtiger_trackingtb  t
                INNER JOIN vtiger_users ON  vtiger_users.id=t.user and vtiger_users.status="ACTIVE"
                WHERE t.dateday=?  AND t.user=?';
                $arrue=array($Dateday,$userTracking);
          }
        

          $sqlresult = $db->pquery($sql,$arrue);
          $notracking = $db->num_rows($sqlresult);
          if($notracking > 0){
             $status=1;
              for($i=1; $i<= $notracking; ++$i) {
                $trackingId = $db->query_result($sqlresult, $i, 'trackingperiodsid');
                $fullname = $db->query_result($sqlresult, $i, 'fullname');
                $trackingtime = $db->query_result($sqlresult, $i, 'trackingtime');
                $let = $db->query_result($sqlresult, $i, 'let');
                $lng = $db->query_result($sqlresult, $i, 'lng');
                $alllocation .='<marker id="'.$i.'" name="'.$fullname.'" address="'.$trackingtime.'" lat="'.$let.'" lng="'.$lng.'" type="restaurant"/>';
            }
              
          }else{

            $alllocation.='
            <marker id="1" name="ENG Haithem" address="12:30 PM" lat="21.45033941110601" lng="39.17227243041998" type="restaurant"/>
            ';
            
          }

        }

     $alllocation.='</markers>';

    $result['sataus']=$status;
    $result['address']=$alllocation;

    //echo json_encode($result);
    return $result;
    }

    function updateuserinfo(Vtiger_Request $request){
      $result=array();
      $valeu=$request->get('valeu');
      $process=$request->get('process');
      $db = PearDatabase::getInstance();
      $status=0;
      $sqlUP;
      $currentUser = Users_Record_Model::getCurrentUserModel();
      $userid=$currentUser->getId();

      if($process==1){
        $sqlUP="UPDATE vtiger_users SET activationtracking=? WHERE id=?";
      }elseif($process==2){
        $sqlUP="UPDATE vtiger_users SET  trackingperiods=? WHERE id=?";
      }
       $qure=$db->pquery($sqlUP,array($valeu,$userid));
        if($qure){
            $status=1;
        }
      
       

      $result['sataus']=$status;
      return $result;
    }
    
    public function validateRequest(Vtiger_Request $request) {
        $request->validateReadAccess();
    }
}

?>