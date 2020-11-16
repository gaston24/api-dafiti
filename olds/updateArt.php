<?php

use RocketLabs\SellerCenterSdk\Core\Client;
use RocketLabs\SellerCenterSdk\Core\Configuration;
use RocketLabs\SellerCenterSdk\Core\Response\ErrorResponse;
use RocketLabs\SellerCenterSdk\Endpoint\Endpoints;

function updateStock($sku, $cant){

    
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../samples/config/config.php';
    
    $client = Client::create(new Configuration(SC_API_URL, SC_API_USER, SC_API_KEY));
    
    // $sellerSku0 = 'XJWE08-202-24XL'; // Please change SellerSku to your convenience
    $sellerSku0 = $sku; // Please change SellerSku to your convenience
    $sellerSku1 = 'Api test product again'; // Please change SellerSku to your convenience
    
    $productCollectionRequest = Endpoints::product()->productUpdate();
    
    $productCollectionRequest
    ->updateProduct($sellerSku0)
    // ->setPrice($cant)
    // ->setSalePrice($price)
    ->setQuantity($cant)
    ;
    // ->setSaleStartDate(new DateTime('now'))
    // ->setSaleEndDate((new DateTime('now'))->modify('+5 day'));
    
    $productCollectionRequest->updateProduct($sellerSku1)->setName('Product Name Again Changed');
    
    $response = $productCollectionRequest->build()->call($client);
    
    if ($response instanceof ErrorResponse) {
        /** @var ErrorResponse $response */
        printf("ERROR !\n");
        printf("%s\n", $response->getMessage());
    } else {
        printf("The feed `%s` has been created.\n", $response->getFeedId());
    }
    
}
    

function updatePrecio($sku, $precio, $precioVenta){

    
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../samples/config/config.php';
    
    $client = Client::create(new Configuration(SC_API_URL, SC_API_USER, SC_API_KEY));
    
    // $sellerSku0 = 'XJWE08-202-24XL'; // Please change SellerSku to your convenience
    // $sellerSku0 = $sku; // Please change SellerSku to your convenience
    $sellerSku1 = 'Api test product again'; // Please change SellerSku to your convenience
    
    $productCollectionRequest = Endpoints::product()->productUpdate();
    
    $productCollectionRequest
    ->updateProduct($sku)
    ->setPrice(12345)
    ->setSalePrice(12345)
    ->setSaleStartDate(new DateTime('now'))
    ->setSaleEndDate((new DateTime('now'))->modify('+5 day'))
    ;
    
    $productCollectionRequest->updateProduct($sellerSku1)->setName('Product Name Again Changed');
    
    $response = $productCollectionRequest->build()->call($client);
    
    if ($response instanceof ErrorResponse) {
        /** @var ErrorResponse $response */
        printf("ERROR !\n");
        printf("%s\n", $response->getMessage());
    } else {
        printf("The feed `%s` has been created.\n", $response->getFeedId());
    }
    
}



