<?php
import('model/game');

/**
 * Tests for the Hand Model.
 *
 * Make sure all the set methods are working as expected.
 *
 * @author michael@xethorn.net (Michael Ortali)
 */

class TestHand extends UnitTestCase {
  /**
   * Try to get a random hand.
   */
  function testRandomHand() {
    $equals = true;
    $previous = null;

    /** The multiplier reduces the chances to select the same hand for x number
     * of times. Now it's less than 0.5%. */
    for ($i = 0; $i < count(Hand::$allowedHands) * 100; $i++) {
      $new = Hand::getRandom();
      if ($previous != $new) {
        $equals = false;
      }
      $previous = $new;
    }

    $this->assertFalse($equals);
  }

  /**
   * Try to get all the supported hands.
   */
  function testGetHand() {
    foreach (Hand::$allowedHands as $i => $hand) {
      $this->assertTrue(Hand::get($hand) instanceof $hand);
    }
  }

  /**
   * Get a hand that is not supported.
   */
  function testGetUnkownHand() {
    $this->expectException(new Exception('This hand is not supported.'));
    Hand::get('foo');
  }

  /**
   * Test the hand scenario.
   */
  function testHandWinner() {
    // Win.
    $winningCombinaisons = array(
      'HandScissors' => 'HandPaper',
      'HandPaper' => 'HandRock',
      'HandRock' => 'HandScissors',
    );

    foreach($winningCombinaisons as $player1 => $player2) {
      $this->assertEqual(Hand::get($player1)->compareTo(Hand::get($player2)), Hand::RESPONSE_WIN);
    }

    // Lose.
    $loosingCombinaisons = array(
      'HandPaper' => 'HandScissors',
      'HandRock' => 'HandPaper',
      'HandScissors' => 'HandRock',
    );

    foreach($loosingCombinaisons as $player1 => $player2) {
      $this->assertEqual(Hand::get($player1)->compareTo(Hand::get($player2)), Hand::RESPONSE_LOSE);
    }

    // Tie.
    foreach($loosingCombinaisons as $hand) {
      $this->assertEqual(Hand::get($hand)->compareTo(Hand::get($hand)), Hand::RESPONSE_TIE);
    }
  }
}
?>