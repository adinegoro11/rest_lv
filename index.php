<?php

  require 'simple_html_dom.php';

  $sdate = '2018-05';

  $list = '';
  $list = file_get_contents("https://database.metrasat.net/lemon/api_blankspot/get_sensor");
  $list = json_decode($list,true);
  // print_r($list);

  $jumlah = count($list);
  $i = 1;
  foreach($list as $data)
  {
    $prtg = file_get_html("traffic_".$data['id_link']."_".$sdate.".html");
    //========= overview =================
    foreach($prtg->find('table[class=overview table]') as $e) $teks = $e->plaintext;
    $hasil2 = trim(preg_replace('/\t+/', '', $teks));
    $hasil = explode("  ",$hasil2);

    //========= cari nilai max traffic ======
    $max_traffic = 0;
    foreach($prtg->find('td[class=col-value col-traffic-total-(speed)]') as $a)
    {
      $angka = explode(" ",$a->plaintext);          

      $angka_1 = str_replace('.', '', $angka[0]);
      $angka_1 = str_replace(',', '.', $angka_1);
      if($angka_1 > $max_traffic) $max_traffic = $angka_1;
    } 
    //========= return data =================
    $output = array(
      'id_sensor' => $data['bp3ti_sensor_traffic'],
      'persen_up' => $hasil[17],
      'persen_down' => $hasil[19],
      'average' => $hasil[32],
      'total_traffic' => $hasil[36],
      'max_traffic' => $max_traffic
    );
  
  // echo "<pre>";
  // var_dump($data);

    $persen = round(($i/$jumlah)*100, 2);
    echo $data['link_name']."|".$persen."%\n";    
    print_r($output);
    sleep(1);
    $i++;
  }

  die("selesai\n");


?>
