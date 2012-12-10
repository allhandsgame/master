<?php
import('model/game');

/**
 * Tests for the Game Model.
 *
 * Make sure all the set methods are working as expected and explore couple
 * scenarios.
 *
 * @author michael@xethorn.net (Michael Ortali)
 */

class TestGame extends UnitTestCase {
  function setUp() {
    @session_start();
    $this->game = new Game();
  }

  /**
   * Set the game in all 4 possibilities (human-human, machine-machine,
   * human-machine, machine-human)
   */
  function TestSetupWithAllowedPlayerTypes() {
    foreach(GamePlayer::$GAME_PLAYER_TYPES as $player1Type => $player1Name) {
      foreach(GamePlayer::$GAME_PLAYER_TYPES as $player2Type => $player2Name) {
        $this->game->initialize($player1Type, $player2Type);
        $this->assertEqual($this->game->players[0]->type, $player1Type);
        $this->assertEqual($this->game->players[1]->type, $player2Type);
      }
    }
  }

  /**
   * Try setting a hand on both players.
   */
  function testSetHandForPlayers() {
    $this->game->initialize('human', 'human');
    foreach (Hand::$allowedHands as $id => $hand) {
      $this->game->setHandForPlayer(0, $hand);
      $this->assertTrue($this->game->players[0]->hand instanceof $hand);

      $this->game->setHandForPlayer(1, $hand);
      $this->assertTrue($this->game->players[1]->hand instanceof $hand);
    }
  }

  /**
   * Try setting with a non supported player id.
   */
  function testSetHandForPlayerWithUnkownPlayerId() {
    $this->game->initialize('human', 'human');
    $this->expectException(new Exception('This player does not exist.'));
    $this->game->setHandForPlayer(2, 'HandRock');
  }

  /**
   * Try setting with a non supported hand.
   */
  function testSetHandForPlayerWithUnkownHand() {
    $this->game->initialize('human', 'human');
    $this->expectException(new Exception('This hand is not supported.'));
    $this->game->setHandForPlayer(0, 'Foo');
  }

  /**
   * Try saving.
   */
  function TestSave() {
    $round = $this->game->roundCount;
    $this->game->save(false);
    $this->assertEqual($this->game->roundCount, $round);
    $this->game->save(true);
    $this->assertEqual($this->game->roundCount, $round + 1);
  }
}

class TestOfGameScenarios extends UnitTestCase {
  function setUp() {
    $this->game = new Game();
    $this->game->initialize('human', 'human');
  }

  /**
   * When the two players have the same cards.
   */
  function TestScenarioTie() {
    foreach (Hand::$allowedHands as $id => $hand) {
      $this->game->setHandForPlayer(0, $hand);
      $this->game->setHandForPlayer(1, $hand);
    }
    $this->assertFalse($this->game->findWinner());
    $this->assertEqual($this->game->players[0]->score, 0);
    $this->assertEqual($this->game->players[1]->score, 0);
  }

  /**
   * When the first player has a card that wins over the
   * second player.
   */
  function TestScenarioPlayer1Win() {
    $this->game->setHandForPlayer(0, 'HandRock');
    $this->game->setHandForPlayer(1, 'HandScissors');
    $score = $this->game->players[0]->score;
    $winner = $this->game->findWinner();
    $this->assertEqual($this->game->players[0], $winner);
    $this->assertEqual($this->game->players[0]->score, ($score + 1));
  }

  /**
   * When the second playe rhas a card that wins over the
   * first player.
   */
  function TestScenarioPlayer2Win() {
    $this->game->setHandForPlayer(0, 'HandScissors');
    $this->game->setHandForPlayer(1, 'HandRock');
    $score = $this->game->players[1]->score;
    $winner = $this->game->findWinner();
    $this->assertEqual($this->game->players[1], $winner);
    $this->assertEqual($this->game->players[1]->score, ($score + 1));
  }

  /**
   * Try setting the score and round counter.
   */
  function TestScoreAndRoundCount() {
    $score = $this->game->players[0]->score;
    $roundCount = $this->game->roundCount;
    $rounds = rand(5, 10);
    for ($i = 0; $i < $rounds; $i++) {
      $this->game->setHandForPlayer(0, 'HandRock');
      $this->game->setHandForPlayer(1, 'HandScissors');
      $this->game->findWinner();
      $this->game->save(true);
    }
    $this->assertEqual($this->game->players[0]->score, $score + $rounds);
    $this->assertEqual($this->game->roundCount, $roundCount + $rounds);
  }
}


class TestOfGamePlayer extends UnitTestCase {
  function setUp() {
    $this->player = new GamePlayer();
  }

  /**
   * Set player hand with allowed values.
   */
  function testGamePlayerSetHand() {
    foreach (Hand::$allowedHands as $i => $hand) {
      $h = new $hand();
      $this->player->setHand($h);
      $this->assertEqual($this->player->hand, $h);
    }
  }

  /**
   * Set player hand with an unsupported value.
   */
  function testGamePlayerSetHandUnknown() {
    $this->expectException(new Exception('Error - This is not a valid Hand.'));
    $this->player->setHand('foo');
  }

  /**
   * Set player type with allowed values.
   */
  function testGamePlayerSetType() {
    foreach(GamePlayer::$GAME_PLAYER_TYPES as $playerType => $playerName) {
      $this->player->setType($playerType);
      $this->assertEqual($this->player->type, $playerType);
    }
  }

  /**
   * Set player type with a manual value.
   */
  function testGamePlayerSetTypeManual() {
    $this->player->setType('human');
    $this->assertEqual($this->player->type, 'human');
    $this->player->setType('machine');
    $this->assertEqual($this->player->type, 'machine');
  }

  /**
   * Set player type with an unsupported value.
   */
  function testGamePlayerSetTypeUnknown() {
    $this->expectException(new Exception('Error - This type of user is not recognized.'));
    $this->player->setType('foo');
  }
}
?>