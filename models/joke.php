<?php
$dbconn = pg_connect("host=localhost dbname=lighten-up");

class Joke {
  public $category;
  public $title;
  public $description;
  public $id;

  public function __construct($category, $title, $description, $id){
    $this->category = $category;
    $this->title = $title;
    $this->description = $description;
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
        $row_object->category,
        $row_object->title,
        $row_object->description,
        intval($row_object->id)
      );
      $jokes[] = $new_joke;
      $row_object = pg_fetch_object($results);
    }
    return $jokes;
  }

  static function create($joke){
    $query = "INSERT INTO jokes (category, title, description) VALUES ($1, $2, $3)";
    $query_params = array($joke->category, $joke->title, $joke->description);
    pg_query_params($query, $query_params);
    return self::all();
  }

  static function update($updated_joke){
      $query = "UPDATE jokes SET category = $1, title = $2, description = $3 WHERE id = $4";
      $query_params = array($updated_joke->category, $updated_joke->title, $updated_joke->description, $updated_joke->id);
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
