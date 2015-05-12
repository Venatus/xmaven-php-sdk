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
//    $testName = \nano\core\config\Config::get('phpunit_test_name');
//    
//    $accounts = \project\db\om\main\AccountTable::retrieveByQuerySortAndLimit(array(
//      'name' => new \MongoRegex('/^'.$testName.'/'),
//    ), array());
//    
//    foreach ($accounts as $account) {
//      $account->deletePermanently();
//    }
//    
//    $users = \project\db\om\main\UserTable::retrieveByQueryAndSort(array(
//      'first_name' => new \MongoRegex('/^'.$testName.'/'),
//    ), array());
//    
//    foreach ($users as $user) {
//      $user->delete();
//    }
  }
  
  public function inArrayMatching($needlePattern, $haystack) {
    foreach ($haystack as $value) {
      if (preg_match($needlePattern, $value) === 1) {
        return true;
      }
    }
    return false;
  }
  
  public function assertDateFormat($str) {
    $this->assertRegExp('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/', $str);
  }
  
}