<?php
require './vendor/autoload.php';
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

class Scrapping {
  public function getSite ($url) {
    $client = new Client();
    $guzzleClient = new GuzzleClient(array(
        'timeout' => 60,
    ));
    $client->setClient($guzzleClient);

    $crawler = $client->request(
      'GET',
      $url
    );
    $crawler = $client->click($crawler->selectLink('Sign in')->link());
    $form = $crawler->selectButton('Sign in')->form();
    $crawler = $client->submit($form, array('login' => 'test', 'password' => 'test'));
    $crawler->filter('.flash-error')->each(function ($node) {
        print $node->text()."\n";
    });
  }
}

$http = new Scrapping();
$http->getSite('https://github.com/');
