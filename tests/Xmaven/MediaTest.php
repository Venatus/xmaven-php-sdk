<?php
require_once __DIR__.'/../XmavenSDKTestCase.class.php';

class MediaTest extends XmavenSDKTestCase
{
  protected $testTitle;
  protected $testDescription;
  protected $testTags;
  protected $isPublished;
  protected $isMarketplace;
  protected $testState;
  
  protected static $createdMediaId;
  
  public function setUp() {
    $this->testTitle = 'Xmaven SDK PHPUnit Test Title';
    $this->testDescription = 'Xmaven SDK PHPUnit Test Description';
    $this->testTags = array('PHPUnit', 'Test');
    $this->isPublished = false;
    $this->isMarketplace = false;
    $this->testState = 0;
  }
  
  public function assertMediaObjectArrayCorrect($obj) {
    $this->assertArrayHasKey('id', $obj);
    $this->assertArrayHasKey('title', $obj);
    $this->assertArrayHasKey('description', $obj);
    $this->assertArrayHasKey('tags', $obj);
    $this->assertArrayHasKey('is_published', $obj);
    $this->assertArrayHasKey('is_marketplace', $obj);
    $this->assertArrayHasKey('author_screen_name', $obj);
    $this->assertArrayHasKey('date_created', $obj);
    $this->assertArrayHasKey('date_updated', $obj);
    $this->assertArrayHasKey('state', $obj);
    $this->assertArrayHasKey('nice_state', $obj);
    $this->assertArrayHasKey('simple_state', $obj);
    $this->assertArrayHasKey('error', $obj);
    $this->assertArrayHasKey('ready', $obj);
    
    $this->assertRegExp('/^[0-9a-z]+$/i', $obj['id']);
    $this->assertRegExp('/^.+$/', $obj['nice_state']);
    $this->assertRegExp('/^.+$/', $obj['simple_state']);
    
    $this->assertInternalType('bool', $obj['error']);
    $this->assertInternalType('bool', $obj['ready']);
    
    $this->assertDateFormat($obj['date_created']);
    $this->assertDateFormat($obj['date_updated']);
  }
  
  public function assertTestDataMatches($obj) {
    $this->assertEquals($this->testTitle, $obj['title']);
    $this->assertEquals($this->testDescription, $obj['description']);
    $this->assertEquals($this->testTags, $obj['tags']);
    $this->assertEquals($this->isPublished, $obj['is_published']);
    $this->assertEquals($this->isMarketplace, $obj['is_marketplace']);
    $this->assertEquals($this->testState, $obj['state']);
    $this->assertEquals(false, $obj['error']);
    $this->assertEquals($this->testState != 0, $obj['ready']);
  }
  
  public function testCreateMedia() {
    $r = self::$api->makeRequest('POST', '/v1/media', array(), array(
      'title' => $this->testTitle,
      'description' => $this->testDescription,
      'tags' => $this->testTags,
      'is_published' => $this->isPublished,
      'is_marketplace' => $this->isMarketplace,
    ));
    
    $this->assertArrayHasKey('success', $r);
    $this->assertEquals(true, $r['success']);
    $this->assertArrayHasKey('obj', $r);
    $obj = $r['obj'];
    $this->assertMediaObjectArrayCorrect($obj);
    $this->assertTestDataMatches($obj);
    
    self::$createdMediaId = $obj['id'];
  }
  
  /**
   * @depends testCreateMedia
   */
  public function testListMedia() {
    $r = self::$api->makeRequest('GET', '/v1/media', array(
      'filter_title'=> substr($this->testTitle, 0, 15),
      'sort_on' => 'title',
      'sort_direction' => -1,
      'limit' => 1,
    ));
    
    $this->assertArrayHasKey('success', $r);
    $this->assertEquals(true, $r['success']);
    $this->assertArrayHasKey('obj_count', $r);
    $this->assertEquals(1, $r['obj_count']);
    $this->assertArrayHasKey('sort', $r);
    $this->assertEquals(array('title' => -1), $r['sort']);
    $this->assertArrayHasKey('objs', $r);
    $objs = $r['objs'];
    $this->assertInternalType('array', $objs);
    $this->assertEquals(1, count($objs));
    $obj = $objs[0];
    
    $this->assertMediaObjectArrayCorrect($obj);
    $this->assertTestDataMatches($obj);
  }
  
  /**
   * @depends testCreateMedia
   */
  public function testUpdateMedia() {
    $this->testTitle .= ' Updated';
    $this->testDescription .= ' Updated';
    $this->testTags[] = 'Updated';
    $r = self::$api->makeRequest('PUT', '/v1/media', array(), array(
      'id' => self::$createdMediaId,
      'title' => $this->testTitle,
      'description' => $this->testDescription,
      'tags' => $this->testTags,
    ));
    
    $this->assertArrayHasKey('success', $r);
    $this->assertEquals(true, $r['success']);
    $this->assertArrayHasKey('obj', $r);
    $obj = $r['obj'];
    $this->assertMediaObjectArrayCorrect($obj);
    $this->assertTestDataMatches($obj);
  }
  
  /**
   * @depends testCreateMedia
   */
  public function testDeleteMedia() {
    $r = self::$api->makeRequest('DELETE', '/v1/media', array(), array(
      'id' => self::$createdMediaId,
    ));
    
    $this->assertArrayHasKey('success', $r);
    $this->assertEquals(true, $r['success']);
    $this->assertEquals(self::$createdMediaId, $r['id']);
  }
  
}