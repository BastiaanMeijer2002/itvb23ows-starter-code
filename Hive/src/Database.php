<?php

namespace HiveGame;

use mysqli;
use mysqli_result;

class Database
{
    private mysqli $db;
    private array $env = [
        "hostname" => "mysql",
        "username" => "root",
        "password" => "root",
        "database" => "hive",
        "AI_BASE_URL" => "http://ai:6000/"
    ];

    public function __construct(mysqli $db = null)
    {
        if ($db == null) {
            $mysqli = new mysqli(
                $this->env["hostname"],
                $this->env["username"],
                $this->env["password"],
                $this->env["database"]
            );

            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }

            $mysqli->set_charset('utf8mb4');

            $this->db = $mysqli;
        } else {
            $this->db = $db;
        }

    }

    public function storeMove(int $gameId, string $type, string $from, string $to, int $previous, string $state): bool
    {
        $stmt = $this->getDb()->prepare('insert into moves (game_id, type, move_from, move_to, previous_id, state) values (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('isssis', $gameId, $type, $from, $to, $previous, $state);
        return $stmt->execute();
    }

    public function getMoves(int $id): bool|mysqli_result
    {
        $stmt = $this->getDb()->prepare('SELECT * FROM moves WHERE id = ? ');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getMovesByGame(int $id): bool|mysqli_result
    {
        $stmt = $this->getDb()->prepare('SELECT * FROM moves WHERE game_id = ? ORDER BY id DESC ');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result();
    }


    public function createGame() {
        $this->getDb()->prepare('INSERT INTO games VALUES ()')->execute();
        return  $this->getDb()->insert_id;
    }

    public function getGame(int $id): void
    {
        $move = $this->getMovesByGame($id)->fetch_array();

        if ($move) {
            GameState::setState($move["state"]);
        }

        GameState::setGameId($id);

    }

    /**
     * @return mysqli
     */
    public function getDb(): mysqli
    {
        return $this->db;
    }

    /**
     * @param mysqli $db
     */
    public function setDb(mysqli $db): void
    {
        $this->db = $db;
    }
}