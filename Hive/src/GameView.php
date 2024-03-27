<?php

namespace HiveGame;

class GameView
{
    public static function render(): void
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <title>Hive</title>
                <style>
                    div.board {
                        width: 60%;
                        height: 100%;
                        min-height: 500px;
                        float: left;
                        overflow: scroll;
                        position: relative;
                    }

                    div.board div.tile {
                        position: absolute;
                    }

                    div.tile {
                        display: inline-block;
                        width: 4em;
                        height: 4em;
                        border: 1px solid black;
                        box-sizing: border-box;
                        font-size: 50%;
                        padding: 2px;
                    }

                    div.tile span {
                        display: block;
                        width: 100%;
                        text-align: center;
                        font-size: 200%;
                    }

                    div.player0 {
                        color: black;
                        background: white;
                    }

                    div.player1 {
                        color: white;
                        background: black
                    }

                    div.stacked {
                        border-width: 3px;
                        border-color: red;
                        padding: 0;
                    }
                </style>
            </head>
            <body>
                <div class="board">
                    <?php
                    self::renderBoard();
                    ?>
                </div>
                <div class="hand">
                    <?php
                    self::renderHand(GameState::getPlayer1hand(), 0);
                    self::renderHand(GameState::getPlayer2hand(), 1);
                    ?>
                </div>
                <div class="turn">
                    Turn: <?php echo (GameState::getPlayer() == 0) ? "White" : "Black"; ?>
                </div>
                <form method="post" action="../index.php">
                    <?php if (GameState::getGameId() !== null) {
                        echo '<input type="hidden" name="game" value="'.GameState::getGameId().'" />';
                    } ?>
                    <select name="piece">
                        <?php
                        $hand = GameState::getHand(GameState::getPlayer());

                        foreach ($hand as $tile => $ct) {
                            echo "<option value=\"$tile\">$tile</option>";
                        }
                        ?>
                    </select>
                    <select name="to">
                        <?php
                        foreach (GameUtils::getPossiblePlays(GameState::getBoard()) as $pos) {
                            echo "<option value=\"$pos\">$pos</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" name="action" value="Play">
                </form>
                <form method="post" action="../index.php">
                    <?php if (GameState::getGameId() !== null) {
                        echo '<input type="hidden" name="game" value="'.GameState::getGameId().'" />';
                    } ?>
                    <select name="from">
                        <?php
                        foreach (GameUtils::getPlayerTiles(GameState::getBoard()) as $pos => $data) {
                            echo "<option value=\"$pos\">$pos</option>";
                        }
                        ?>
                    </select>
                    <select name="to">
                        <?php
                        foreach (GameUtils::getPossiblePlays(GameState::getBoard()) as $pos) {
                            echo "<option value=\"$pos\">$pos</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" name="action" value="Move">
                </form>
                <form method="post" action="../index.php">
                    <input type="submit" value="Pass">
                </form>
                <form method="post" action="../index.php">
                    <?php if (GameState::getGameId() !== null) {
                        echo '<input type="hidden" name="game" value="'.GameState::getGameId().'" />';
                    } ?>
                    <input type="submit" name="Action" value="Pass">
                </form>
                <form method="post" action="undo.php">
                    <input type="submit" value="Undo">
                </form>
                <strong><?php echo GameState::getError(); ?></strong>
            </body>
        </html>
        <?php
    }

    private static function renderBoard(): void
    {
        $html = '';

        $min_p = 1000;
        $min_q = 1000;
        foreach (GameState::getBoard() as $pos => $tile) {
            $pq = explode(',', $pos);
            if (isset($pq[0]) && isset($pq[1])) {
                $min_p = min($min_p, $pq[0]);
                $min_q = min($min_q, $pq[1]);
            }
        }

        if (is_array(GameState::getBoard())) {
            foreach (array_filter(GameState::getBoard()) as $pos => $tile) {
                $pq = explode(',', $pos);
                $html .= self::renderTile($tile, $pq, $min_p, $min_q);
            }
        }

        echo $html;
    }

    private static function renderTile($tile, $pq, $min_p, $min_q): string
    {
        $html = '';
        $h = count($tile);
        $html .= '<div class="tile player';
        if (is_array($tile) && !empty($tile)) {
            $html .= $tile[0][0];
        }
        if ($h > 1) {
            $html .= ' stacked';
        }
        $html .= '" style="left: ';
        $html .= ($pq[0] - $min_p) * 4 + ($pq[1] - $min_q) * 2;
        $html .= 'em; top: ';
        $html .= ($pq[1] - $min_q) * 4;
        $html .= "em;\">($pq[0],$pq[1])<span>";
        if (is_array($tile) && !empty($tile)) {
            $html .= $tile[0][1];
        }
        $html .= '</span></div>';

        return $html;
    }

    private static function renderHand(array $hand, int $player): void
    {
        foreach ($hand as $tile => $ct) {
            for ($i = 0; $i < $ct; $i++) {
                echo '<div class="tile player'.$player.'"><span>'.$tile."</span></div> ";
            }
        }
    }

}
