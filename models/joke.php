<?php

// $dbconn = pg_connect("
// host=localhost 
// dbname=lighten-up
// ");

// $dbconn = pg_connect("
// host=localhost 
// dbname=lighten-up
// user=btngpbkauucvsj
// password=8fe7e57c32ccdafa77f10b405ba83e226af1281b399fb9f3fe501a9a8125c29f
// port=5432
// ");

$db = parse_url(getenv('DATABASE_URL')) ?:"postgres://btngpbkauucvsj:8fe7e57c32ccdafa77f10b405ba83e226af1281b399fb9f3fe501a9a8125c29f@ec2-3-211-48-92.compute-1.amazonaws.com:5432/dambb0tr497ddb";
$db["path"] = ltrim($db["path"], "/");

$dbconn = pg_connect($db);

class Joke {
  public $setup;
  public $delivery;
  public $id;

  public function __construct($setup, $delivery, $id){
    $this->setup = $setup;
    $this->delivery = $delivery;
    $this->id = $id;
  }
}

class Jokes {
  static function all(){
    $jokes = array();

    $results = pg_query("SELECT * FROM jokes");

    $row_object = pg_fetch_object($results);
    while($row_object){
      $new_joke = new Joke(
        $row_object->setup,
        $row_object->delivery,
        intval($row_object->id)
      );
      $jokes[] = $new_joke;
      $row_object = pg_fetch_object($results);
    }
    return $jokes;
  }

  static function create($joke){
    $query = "INSERT INTO jokes (setup, delivery) VALUES ($1, $2)";
    $query_params = array($joke->setup, $joke-> $delivery);
    pg_query_params($query, $query_params);
    return self::all();
  }

  static function update($updated_joke){
      $query = "UPDATE jokes SET setup = $1, delivery = $2, WHERE id = $3";
      $query_params = array($updated_joke->setup, $updated_joke->delivery, $updated_joke->id);
      $result = pg_query_params($query, $query_params);

      return self::all();
    }

    static function delete($id){
      $query = "DELETE FROM jokes WHERE id = $1";
      $query_params = array($id);
      $result = pg_query_params($query, $query_params);

      return self::all();
    }
}
