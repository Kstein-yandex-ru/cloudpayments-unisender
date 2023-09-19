<?php



if ($_SERVER['REQUEST_METHOD'] == 'POST' and ($_POST['Status'] === 'Cancelled' or $_POST['Status'] === 'PastDue' or $_POST['Status'] === 'Rejected')) {

   require('config.php');


   if ($_POST['Status'] === 'PastDue') {
      $template_id = ERROR_RECURRENT_TEMPLATE;  // Шаблон при ошибке ежемесячного платежа

   } else if ($_POST['Status'] === 'Rejected') {
      $template_id = REJECTED_RECURRENT_TEMPLATE;  // Шаблон при отмене подписки после 3 попыток списания

   } else if ($_POST['Status'] === 'Cancelled') {
      $template_id = CANCELLED_RECURRENT_TEMPLATE;  // Шаблон при отмене подписки
   }


   $url = "https://go1.unisender.ru/ru/transactional/api/v1/email/send.json";

   $requestBody = [
      "api_key" => API_KEY,
      "username" => USER_NAME,
      "message" => [
         // "template_engine" => "velocity", 
         "template_id" => $template_id,
         "recipients" => [
            [
               "email" => $_POST['Email'],
               //   "substitutions" => [
               //      "to_name" => "Имя получателя 1", 
               //   "person" => [
               //      "name" => "Иванов Иван Иваныч" 
               //   ], 

            ]
         ]
      ],
      //                  "body" => [
      //    "html" => "<b>Hello, {{to_name}}</b>",
      //    "plaintext" => "Hello, {{to_name}}",
      //    "amp" => "<!doctype html><html amp4email><head> <meta charset=\"utf-8\"><script async src=\"https://cdn.ampproject.org/v0.js\"></script> <style amp4email-boilerplate>body[visibility:hidden]</style></head><body> Hello, AMP4EMAIL world.</body></html>"
      //  ],
      //  "subject" => "Спасибо за пожертвование",
      "from_email" => FROM_EMAIL,
      "from_name" => FROM_NAME,
      "reply_to" => REPLY_TO,
      "track_links" => 0,
      "track_read" => 0,
      "bypass_global" => 0,
      "bypass_unavailable" => 0,
      "bypass_unsubscribed" => 0,
      "bypass_complained" => 0


   ];

   $content = json_encode($requestBody);

   $curl = curl_init($url);
   curl_setopt($curl, CURLOPT_HEADER, false);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   curl_setopt(
      $curl,
      CURLOPT_HTTPHEADER,
      array("Content-type: application/json", "Accept: application/json",  "Origin: {$_SERVER['SERVER_NAME']}")
   );
   curl_setopt($curl, CURLOPT_POST, true);
   curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
   curl_setopt($curl, CURLOPT_RESOLVE, ["go1.unisender.ru:443:217.77.111.132"]);
   curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);






   $json_response = curl_exec($curl);








   // $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

   // if ( $status != 201 ) {
   //     die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
   // }


   curl_close($curl);

   $response = json_decode($json_response, true);


   $responseCloudPayments = json_encode([
      "code" => 0
   ]);

   echo $responseCloudPayments;
} else {
   echo 'No request';
}
