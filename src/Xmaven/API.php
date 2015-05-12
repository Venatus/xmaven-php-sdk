<?php
namespace Xmaven;

use GuzzleHttp\Client;
use GuzzleHttp\Stream\Stream;

class API {
  
  protected $userId = null;
  protected $privateKey = null;
  protected $accountId = null;
  protected $uri = 'https://api.xmaven.com';
  protected $client = null;
  
  public function __construct($userId, $privateKey, $accountId = null){
    $this->client = new Client();
    $this->userId = $userId;
    $this->privateKey = $privateKey;
    $this->accountId = $accountId;
  }
  
  public function createRequest($type='GET', $endPoint='/', array $queryParams=array(), array $data=array()){
    $request = $this->client->createRequest($type, $this->uri.$endPoint);
    $request->setHeader('USERID', $this->userId);
    $request->setHeader('APIKEY', $this->privateKey);
    $request->setHeader('ACCOUNTID', $this->accountId);
    $query = $request->getQuery();
    foreach($queryParams as $k => $v){
      $query->set($k, $v);
    }
    if(preg_match('/^(POST|PUT|DELETE)$/',$type)){
      $request->setHeader('CONTENT-TYPE', 'application/json');
      $request->setBody(Stream::factory(json_encode($data)));
    }
    return $request;
  }
  
  public function makeRequest($type='GET', $endPoint='/', array $queryParams=array(), array $data=array()){
    $response = $this->client->send($this->createRequest($type,$endPoint,$queryParams,$data));
    $json = $response->json();
    if(is_array($json) && isset($json['success']) && $json['success']){
      return $json;
    }
    if(is_array($json) && isset($json['errors']) && is_array($json['errors'])){
      throw new \Xmaven\Exception(implode(', ',$json['errors']));
    }
    if(is_array($json) && isset($json['error']) && is_string($json['error'])){
      throw new \Xmaven\Exception($json['error']);
    }
    throw new \Xmaven\Exception('Received a bad response');
  }
  
}