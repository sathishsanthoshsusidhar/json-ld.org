<?php
/*
 * This is a really dangerous proxy script, only run it on machines that
 * can't cause any damage if they were to be pwnd.
 */
if($_GET && $_GET['url']) {
  $headers = getallheaders();
  $headers_str = array();
  $url = $_GET['url'];

  if(strpos($url, 'http') !== 0) {
    exit('Only proxying HTTP URLs is allowed. Invalid URL: ' . $url);
  }

  foreach($headers as $key => $value){
    if($key == 'Host')
      continue;
    $headers_str[]=$key.":".$value;
  }

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_str);
  $result = curl_exec($ch);
  curl_close($ch);
  echo $result;
}

?>
