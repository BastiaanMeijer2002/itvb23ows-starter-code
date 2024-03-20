<?php

namespace HiveGame;

/**
 * Manages the state of the game.
 */
class GameState
{

    /**
     * @return array
     */
    public static function getPlayer1hand(): array
    {
        return $_SESSION["hand"][0];
    }

    /**
     * @param array $player1hand
     */
    public static function setPlayer1hand(array $player1hand): void
    {
        $_SESSION["hand"][0] = $player1hand;
    }

    /**
     * @return array
     */
    public static function getPlayer2hand(): array
    {
        return $_SESSION["hand"][1];
    }

    /**
     * @param array $player2hand
     */
    public static function setPlayer2hand(array $player2hand): void
    {
        $_SESSION["hand"][1] = $player2hand;
    }

    /**
     * @param int $player
     * @return array
     */
    public static function getHand(int $player): array
    {
        return $_SESSION["hand"][$player];
    }

    /**
     * @param int $player
     * @param array $hand
     */
    public static function setHand(int $player, array $hand): void
    {
        $_SESSION["hand"][$player] = $hand;
    }

    /**
     * @return int
     */
    public static function getLastMove(): int
    {
        return $_SESSION["lastMove"] ?? 0;
    }

    /**
     * @param int $lastMove
     */
    public static function setLastMove(int $lastMove): void
    {
        $_SESSION["lastMove"] = $lastMove;
    }

    /**
     * @return int
     */
    public static function getGameId(): int
    {
        return $_SESSION["id"];
    }

    /**
     * @param int $gameId
     */
    public static function setGameId(int $gameId): void
    {
        $_SESSION["id"] = $gameId;
    }

    /**
     * @return array
     */
    public static function getBoard(): array
    {
        if (isset($_SESSION["board"]) && is_array($_SESSION["board"])) {
            return $_SESSION["board"];
        } else {
            return [];
        }
    }

    /**
     * @param array $board
     */
    public static function setBoard(array $board): void
    {
        $_SESSION["board"] = $board;
    }


    /**
     * @return int
     */
    public static function getPlayer(): int
    {
        return $_SESSION["player"];
    }

    /**
     * @param int $player
     */
    public static function setPlayer(int $player): void
    {
        $_SESSION["player"] = $player;
    }

    /**
     * @return string
     */
    public static function getState(): string
    {
        return serialize([
            "hand1" => self::getPlayer1hand(),
            "hand2" => self::getPlayer2hand(),
            "board" => self::getBoard(),
            "player" => self::getPlayer(),
        ]);
    }

    /**
     * @param string $state
     * @return void
     */
    public static function setState(string $state): void
    {
        $state = unserialize($state);

        self::setPlayer1hand($state["hand1"]);
        self::setPlayer2hand($state["hand2"]);
        self::setBoard($state["board"]);
        self::setPlayer($state["player"]);
    }

}
