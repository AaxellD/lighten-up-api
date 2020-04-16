<?php
include_once __DIR__ . '/../models/joke.php';

header('Content-Type: application/json');

if ($_REQUEST['action'] === 'index') {
  echo json_encode(Jokes::all());
} 

elseif ($_REQUEST['action'] === 'joke') {
  $request_body = file_get_contents('php://input');
  $body_object = json_decode($request_body);
  $new_joke = new Joke(null, $body_object->category, $body_object->title, $body_object->description);
  $all_jokes = Jokes::create($new_joke);
  echo json_encode($all_jokes);
} 

else if ($_REQUEST['action'] === 'update') {
  $request_body = file_get_contents('php://input');
  $body_object = json_decode($request_body);
  $updated_joke = new Joke($_REQUEST['id'], $body_object->category, $body_object->title, $body_object->description);
  $all_jokes = Jokes::update($updated_joke);
  echo json_encode($all_jokes);
} 

else if ($_REQUEST['action'] === 'delete') {
  $all_jokes = Jokes::delete($_REQUEST['id']);
  echo json_encode($all_jokes);
}
?>