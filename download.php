<?php

  function input_tanggal($ket)
  {
    echo "Input bulan ".$ket." (yyyy-mm):";
    $handle = fopen ("php://stdin","r");
    $bulan = fgets($handle);
    if(trim($bulan) == '') die("Input kosong\n");
    else return $bulan;
  }

  error_reporting(E_ALL);
  $sdate = trim(input_tanggal('awal'));
  $edate = trim(input_tanggal('akhir'));

  $list = '';
  $list = file_get_contents("https://database.metrasat.net/lemon/api_blankspot/get_sensor");
  $list = json_decode($list,true);
  // print_r($list);

  $jumlah = count($list);
  $i = 1;
  foreach($list as $data)
  {
   
    $url = "http://202.43.73.157/historicdata_html.htm?id=".$data['bp3ti_sensor_traffic']."&sdate=".$sdate."-01-00-00-00&edate=".$edate."-01-00-00-00&avg=3600&pctavg=300&pctshow=false&pct=95&pctmode=false&username=isp Telkom&passhash=1024595950";

    $arrContextOptions = array(
      "ssl" => array("verify_peer"=>false, "verify_peer_name"=>false),
    );  

    $response = file_get_contents($url, false, stream_context_create($arrContextOptions));
    file_put_contents("traffic_".$data['id_link']."_".$sdate.".html", $response);

    $persen = round(($i/$jumlah)*100, 2);
    echo $data['link_name']."|".$persen."%\n";
    // echo $output."\n";
    sleep(2);
    $i++;
  }

  die("selesai\n");


 // require 'simple_html_dom.php';

  // $id_sensor = 12861;//ping
  // // $id_sensor = 12864 ;//trafik
  // $sdate = '2018-05';
  // $edate = '2018-06';
  // $id_link = 1545;
  // $url = "http://202.43.73.157/historicdata_html.htm?id=".$id_sensor."&sdate=".$sdate."-01-00-00-00&edate=".$edate."-01-00-00-00&avg=3600&pctavg=300&pctshow=false&pct=95&pctmode=false&username=isp Telkom&passhash=1024595950";

  // $arrContextOptions=array(
  //   "ssl"=>array(
  //   "verify_peer"=>false,
  //   "verify_peer_name"=>false,
  //   ),
  // );  

  // $response = file_get_contents($url, false, stream_context_create($arrContextOptions));
  // file_put_contents("output.html", $response);
  // // echo "<pre>";
  // // var_dump($response);
  // // echo $response;

  // echo file_put_contents("output.html", $response);

?>


 