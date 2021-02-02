# shopify-api-laravel

1. Create Laravel Project & configure ssl

2. Create shopify store
```
- create account: https://partners.shopify.com/
- select Stores form sidebar
- Clic Add store
- Select development

Fill the from
- store name
- store url (anything as your wish, your custom shop url)
- Enter new store password
- Developer preview: No need
- Store Purpose: Test an app or Theme

click Save
```

3. Create shopify App
```
- Select Apps from sidebar
- Click Create app
- Select Public app

General settings:
- App name: Anything
- App URL: Your Laravel project route which called: public static function authorizeResponse() see below #7 for descriptions of this function

Redirection URLs:
- same as App URL

click Create app Button
```

5. Copy **API keys** and **API secret key** from just cretaed shopify App and save in .env
```
SHOPIFY_API_KEY=API keys
SHOPIFY_API_SECRET=API secret key
SHOPIFY_API_SCOPES=read_orders,read_products,read_product_listings
SHOPIFY_API_REDIRECT_URI=Redirection URLs:same as App URL
SHOPIFY_API_SCOPES=read_orders,read_products,read_inventory,write_products,write_inventory,read_product_listings,read_assigned_fulfillment_orders,read_merchant_managed_fulfillment_orders,write_merchant_managed_fulfillment_orders,write_assigned_fulfillment_orders,read_third_party_fulfillment_orders,write_third_party_fulfillment_orders

```

6. Install package: https://github.com/osiset/Basic-Shopify-API
```
composer require osiset/basic-shopify-api
```
7. Connect With Laravel Project

Athentication: Create this function to get the access token and save in DB
```
  public static function authorizeResponse()
  {
    $code = request()->get('code');
    $shopifyShop = request()->get('shop');

    // Create options for the API
    $options = new Options();
    $options->setVersion('2020-10');
    $options->setApiKey(env('SHOPIFY_API_KEY'));
    $options->setApiSecret(env('SHOPIFY_API_SECRET'));

    // Create the client and session
    $api = new BasicShopifyAPI($options);
    $api->setSession(new Session($shopifyShop));

    $valid = $api->verifyRequest($_GET);

    if(!$valid) {
      return (object) [
        'status' => 'error',
        'message' => 'Not Authorized'
      ];
    }

    if (!empty($code)) {
        $access_token = $api->requestAccessToken($code);
        header("Location: ".url('login').'?shopify_token='.$access_token.'&shopify_shop='.$shopifyShop);
        // Save the $access_token and $shopifyShop in Database
        exit;
    } else {
        /**
         * No code, send user to authorize screen
         * Pass your scopes as an array for the first argument
         * Pass your redirect URI as the second argument
         * Pass your grant mode as the third argument
         */
        // $redirect = $api->getAuthUrl(env('SHOPIFY_API_SCOPES'), env('SHOPIFY_API_REDIRECT_URI'), 'per-user');
        $redirect = $api->getAuthUrl(env('SHOPIFY_API_SCOPES'), env('SHOPIFY_API_REDIRECT_URI'));
        Log::debug('Redirect', [$redirect]);
        header("Location: {$redirect}");
        exit;
    }
  }
```

Get data from shopify:
```
public static function apiConnect($db_shop)
  {
    $shopify_shop = $db_shop->shopify_shop; // shop url: myshop.com (without https://www)
    $shopify_token = $db_shop->shopify_token; // access token
    $options = new Options();
    $options->setVersion('2020-01'); // API Version

    $api = new BasicShopifyAPI($options);
    $api->setSession(new Session($shopify_shop, $shopify_token));

    return $api;
  }
  
public static function getItems()
  {
    $api = self::apiConnect();
      $response = $api->graph('{ shop { products(first: 70) { edges { node { handle, id, productType, variants(first: 10) {
        edges {
          node {
            id
            displayName
            sku
            barcode
            weight
          }
        }
      } } } } } }');
   }
   
For more details: https://shopify.dev/concepts/graphql/queries
```
