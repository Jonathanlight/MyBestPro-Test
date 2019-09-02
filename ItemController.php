<?php

class ItemController
{

  const LIMIT = 5;

  /**
   * @var string
   */
  private $pdo;

  /**
   * @var string
   */
  private $hostname;

  /**
   * @var string
   */
  private $dbname;

  /**
   * @var string
   */
  private $username;

  /**
   * @var string
   */
  private $password;

  public function __construct(
    string $hostname,
    string $dbname,
    string $username,
    string $password
  ){
    try {
      $this->pdo = new PDO("mysql:host=$hostname;dbname=$dbname","$username","$password");
    } catch (PDOException $e) {
      echo "Failed database : " . $e->getMessage();
      exit;
    }
  }

  /**
   * @param string $table
   * @param int $id
   * @return array
   */
  public function findById(string $table, int $id): array
  {
    $state = $this->pdo->prepare("SELECT * FROM $table WHERE id = :id ");
    $state->bindParam(':id', $id);
    $state->execute();

    return $state->fetch();
  }

  /**
   * @param int $id
   * @return array
   */
  function showItem(int $id): array
    {
        $response = false;
        $response = [];

        if ($id < ItemController::LIMIT) {
          switch($id) {
            case 1:
              return $this->findById('items', $id);
              break;
            default:
              $response = ['error' => 'ID pas OK'];
              return $response;
              break;
          }
        }

        return $response;
    }
}

$item = new ItemController("localhost", "test", "root", "");
var_dump($item->showItem(1));
