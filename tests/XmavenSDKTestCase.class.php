<?php

class XmavenSDKTestCase extends \PHPUnit_Framework_TestCase
{
	protected static $api = null;

  public static function setUpBeforeClass() {
    self::cleanUp();
    try {
      self::$api = new Xmaven\API(XMAVEN_API_USER_ID, XMAVEN_API_KEY);
    } catch (\Exception $e) {
      self::cleanUp();
      throw $e;
    }
  }
  
  public static function tearDownAfterClass() {
    self::cleanUp();
  }
  
  public static function cleanUp() {
    
  }
  
  public function assertDateFormat($str) {
    $this->assertRegExp('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/', $str);
  }
  
}