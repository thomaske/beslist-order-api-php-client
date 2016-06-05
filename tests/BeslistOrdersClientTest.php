<?php
class BeslistOrdersClientTest extends PHPUnit_Framework_TestCase
{
  private $client;
  const NUMBER_OF_PRODUCTS = 5;

  public function setUp()
  {
    $personalKey = '-- ENTER YOUR PUBLIC KEY --';
    $shopId = '-- ENTER YOUR SHOP ID --';
    $clientId = '-- ENTER YOUR CLIENT ID --';

    $this->client = new Wienkit\BeslistOrdersClient\BeslistOrdersClient($personalKey, $shopId, $clientId);
    $this->client->setTestMode(true);
  }

  public function testShoppingCartRetrieve()
  {
    $cart = $this->client->getShoppingCartData('2016-01-01', '2016-01-02');
    $this->assertNotEmpty($cart);
    return $cart;
  }

  /**
   * @depends testShoppingCartRetrieve
   */
  public function testNumberOfOrders($cart)
  {
    $this->assertEquals(count($cart->shopOrders), 1);
    return $cart->shopOrders[0];
  }

  /**
   * @depends testNumberOfOrders
   */
  public function testNumberOfProductsInOrder($order)
  {
    $this->assertEquals(count($order->products), 2);
    $this->assertEquals($order->numProducts, count($order->products));
  }

  public function testShoppingCartRetrieveMultiple()
  {
    $this->client->setTestModeTotalOrders(self::NUMBER_OF_PRODUCTS);
    $cart = $this->client->getShoppingCartData('2016-01-01', '2016-01-02');
    $this->assertNotEmpty($cart);
    return $cart;
  }

  /**
   * @depends testShoppingCartRetrieveMultiple
   */
  public function testNumberOfOrdersMultiple($cart)
  {
    $this->assertEquals(count($cart->shopOrders), self::NUMBER_OF_PRODUCTS);
    $this->assertEquals($cart->summary->numResults, self::NUMBER_OF_PRODUCTS);
  }
}
