<?php
import('lib/template');

/**
 * Test for the libraries.
 *
 * @author michael@xethorn.net (Michael Ortali)
 */

class TestTemplate extends UnitTestCase {
  function setUp() {
    $this->template = new Template();
  }

  function testSetView() {
    $this->template->setView('/index');
    $this->assertEqual($this->template->filename, dirname(dirname(__FILE__)).'/view/index.php');
  }
}


class TestTemplateEcho extends UnitTestCase {
  function get($txt) {
    ob_start();
    •($txt);
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
  }
  function testTemplate() {
    $this->assertTrue(True, True);
  }

  function testEcho() {
    $this->assertEqual($this->get('foo'), 'foo');
    $this->assertEqual($this->get('<foo>'), '&lt;foo&gt;');
    $this->assertEqual($this->get("'foo'"), "&#039;foo&#039;");
    $this->assertEqual($this->get('"foo"'), '&quot;foo&quot;');
  }
}
?>
