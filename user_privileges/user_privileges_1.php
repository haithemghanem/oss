<?php


//This is the access privilege file
$is_admin=false;

$current_user_roles='H2';

$current_user_parent_role_seq='H1::H2';

$current_user_profiles=array(7,);

$profileGlobalPermission=array('1'=>1,'2'=>1,);

$profileTabsPermission=array('1'=>0,'2'=>0,'4'=>0,'6'=>0,'7'=>0,'8'=>0,'9'=>0,'10'=>0,'13'=>0,'14'=>0,'15'=>0,'16'=>0,'18'=>0,'19'=>0,'20'=>0,'21'=>0,'22'=>0,'23'=>0,'24'=>0,'25'=>0,'26'=>0,'27'=>0,'31'=>0,'34'=>0,'35'=>0,'37'=>0,'38'=>0,'39'=>0,'40'=>0,'41'=>0,'42'=>0,'43'=>0,'44'=>0,'45'=>0,'46'=>0,'47'=>0,'50'=>0,'51'=>0,'52'=>0,'54'=>0,'28'=>0,'3'=>0,);

$profileActionPermission=array(2=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,10=>0,),4=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,8=>0,10=>0,),6=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,8=>0,10=>0,),7=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,8=>0,9=>0,10=>0,),8=>array(0=>0,1=>0,2=>0,4=>0,7=>0,6=>0,),9=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,),13=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,8=>0,10=>0,),14=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,10=>0,),15=>array(0=>0,1=>0,2=>0,4=>0,7=>0,),16=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,),18=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,10=>0,),19=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,10=>0,),20=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,),21=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,),22=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,),23=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,),25=>array(0=>0,1=>0,2=>0,4=>0,7=>0,6=>0,13=>0,),26=>array(0=>0,1=>0,2=>0,4=>0,7=>0,),31=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,8=>0,11=>0,12=>0,),34=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,10=>0,),35=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,10=>0,),40=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,10=>0,),42=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,10=>0,),43=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,10=>0,),44=>array(0=>0,1=>0,2=>0,4=>0,7=>0,5=>0,6=>0,10=>0,),46=>array(0=>0,1=>0,2=>0,4=>0,7=>0,),47=>array(0=>0,1=>0,2=>0,4=>0,7=>0,),52=>array(0=>0,1=>0,2=>0,3=>0,4=>0,7=>0,),54=>array(0=>0,1=>0,2=>0,3=>0,4=>0,7=>0,),);

$current_user_groups=array(3,);

$subordinate_roles=array('H3','H8','H11','H12','H13','H14','H15','H16','H17','H18','H19','H20','H9',);

$parent_roles=array('H1',);

$subordinate_roles_users=array('H3'=>array(),'H8'=>array(),'H11'=>array(62,67,),'H12'=>array(65,),'H13'=>array(68,),'H14'=>array(),'H15'=>array(),'H16'=>array(58,),'H17'=>array(55,),'H18'=>array(57,),'H19'=>array(66,),'H20'=>array(69,),'H9'=>array(44,45,46,47,49,52,63,64,),);

$user_info=array('user_name'=>'admin','is_admin'=>'1','user_password'=>'$1$ad000000$Yecy.vpMWe8FZ9Y/M9Sl80','confirm_password'=>'$1$ad000000$Yecy.vpMWe8FZ9Y/M9Sl80','first_name'=>'AL-','last_name'=>'Ostorahِ','roleid'=>'H2','email1'=>'suport@solutions-time.com','status'=>'Active','activity_view'=>'This Week','hour_format'=>'12','end_hour'=>'23:00','start_hour'=>'00:00','is_owner'=>'1','title'=>'','phone_work'=>'','department'=>'','phone_mobile'=>'','reports_to_id'=>'','phone_other'=>'','email2'=>'','phone_fax'=>'','secondaryemail'=>'','phone_home'=>'','date_format'=>'yyyy-mm-dd','signature'=>'','description'=>'','address_street'=>'','address_city'=>'','address_state'=>'','address_postalcode'=>'','address_country'=>'','accesskey'=>'nXSkAMkeJgQ5WRQH','time_zone'=>'Asia/Muscat','currency_id'=>'2','currency_grouping_pattern'=>'123,456,789','currency_decimal_separator'=>'.','currency_grouping_separator'=>',','currency_symbol_placement'=>'$1.0','imagename'=>'','internal_mailer'=>'1','theme'=>'alphagrey','language'=>'ar_ae','reminder_interval'=>'1 Minute','phone_crm_extension'=>'','no_of_currency_decimals'=>'2','truncate_trailing_zeros'=>'1','dayoftheweek'=>'Sunday','callduration'=>'5','othereventduration'=>'5','calendarsharedtype'=>'public','default_record_view'=>'Detail','leftpanelhide'=>'1','rowheight'=>'','defaulteventstatus'=>'Planned','defaultactivitytype'=>'Call','hidecompletedevents'=>'0','defaultcalendarview'=>'MyCalendar','cf_989'=>'Jeddah','currency_name'=>'Saudi Arabia, Riyals','currency_code'=>'SAR','currency_symbol'=>' ','conv_rate'=>'1.00000','record_id'=>'','record_module'=>'','id'=>'1');
?>