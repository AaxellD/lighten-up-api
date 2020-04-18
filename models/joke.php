<?php

$dbconn = null;
if(getenv('DATABASE_URL')){
    $connectionConfig = parse_url(getenv('DATABASE_URL'));
    $host = $connectionConfig['host'];
    $user = $connectionConfig['user'];
    $password = $connectionConfig['pass'];
    $port = $connectionConfig['port'];
    $dbname = trim($connectionConfig['path'],'/');
    $dbconn = pg_connect(
        "host=".$host." ".
        "user=".$user." ".
        "password=".$password." ".
        "port=".$port." ".
        "dbname=".$dbname
    );
} else {
    $dbconn = pg_connect("host=localhost dbname=jokes user=postgres password=blackdra9891");
}

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
    $query_params = array($joke->setup, $joke->delivery);
    pg_query_params($query, $query_params);
    return self::all();
  }

  static function update($updated_joke){
      $query = "UPDATE jokes SET setup = $1, delivery = $2 WHERE id = $3";
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
