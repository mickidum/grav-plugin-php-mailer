<?php
    /* at the top of 'check.php' */
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
        /* 
           Up to you which header to send, some prefer 404 even if 
           the files does exist for security
        */
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );

        /* choose the appropriate page to redirect users */
        die( header( 'location: /error.php' ) );

    }
?>

<?php
//headers
header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=export.csv;');
header('Content-Transfer-Encoding: binary'); 

if($_POST) {

$safe_post = array_map('test_input', $_POST);

$to = 'michael@zur4win.com';

$table_content = fopen('table_content.txt', 'w'); 
$file = fopen('maof_list.html', 'a+'); 
$csv = fopen('maof_list.csv', 'a+');

$event_name = $safe_post['event_name'] ? $safe_post['event_name'] : 'no name';

$subject = 'Register List From '.str_replace('_', ' ', $event_name);

$message_header = "<table style='direction:rtl; padding:5px 15px;'><tr><th colspan='2'><h2><strong>New Registrant Added</strong></h2></th></tr>";
$message_footer = "</table>";     
$message = "";
$text_content = "";
$csv_content = "";
$list_content = [];
array_push($list_content, 'Id');

foreach ($safe_post as $key => $value) {
  if ($key !== "event_name") {
    $message .= "<tr><th style='border-top:dotted 1px #000;border-left:dotted 1px #000;'><strong>{$key}</strong></th><td style='border-top:dotted 1px #000;'>{$value}</td>";
    $text_content .= "<td>{$value}</td>";
    $csv_content .= "{$value},";
    array_push($list_content, $key);
  }
}

array_push($list_content, 'date');
array_push($list_content, $event_name);

fwrite($table_content, implode(',', $list_content));

$message = $message_header.$message.$message_footer;

$html_content = "<tr><td>".(count(file('maof_list.html')) + 1)."</td>".$text_content."<td>".date("d-m-Y H:i:s")."</td></tr>\n";

$headers = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";
$headers .= 'From:atidim.co.il';

extract($safe_post);

if( $name && $email && $phone && strlen($name)>=2 && strlen($phone)>7){

  mail($to, $subject, $message, $headers); //This method sends the mail.
  echo '{"valid": true, "message": "נחזור אליכם בהקדם"}';

  fwrite($file, $html_content);

  $outcsv = $csv_content.date("d-m-Y H:i:s")."\r\n";
  //add BOM to fix UTF-8 in Excel
  fwrite($csv, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
     fwrite($csv, $outcsv);
  }

  else{
  echo '{"valid":false, "message":"יש טעויות בטופס"}'; 
  }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
