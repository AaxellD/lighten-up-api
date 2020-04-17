<?php
include_once __DIR__ . '/../models/joke.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

if ($_REQUEST['action'] === 'index') {
  echo json_encode(Jokes::all());
}

elseif ($_REQUEST['action'] === 'post') {
  $request_body = file_get_contents('php://input');
  echo '!!!!!!!!!!!!!!!!!!!!!!!!';
  echo $request_body;
  echo '!!!!!!!!!!!!!!!!!!!!!!!!';
  $body_object = json_decode($request_body);
  $new_joke = new Joke(null, $body_object->setup, $body_object->delivery);
  $all_jokes = Jokes::create($new_joke);
  echo json_encode($all_jokes);
}

else if ($_REQUEST['action'] === 'update') {
  $request_body = file_get_contents('php://input');
  $body_object = json_decode($request_body);
  $updated_joke = new Joke($_REQUEST['id'], $body_object->setup, $body_object->delivery);
  $all_jokes = Jokes::update($updated_joke);
  echo json_encode($all_jokes);
}

else if ($_REQUEST['action'] === 'delete') {
  $all_jokes = Jokes::delete($_REQUEST['id']);
  echo json_encode($all_jokes);
}
?>
