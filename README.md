# ThdSolution
OrderApi

Json Payload Example:

{  
   "customer":{  
      "email":"jdoe@example.com",
      "firstname":"Jane",
      "lastname":"Doe",
      "addresses":[  
         {  
            "defaultShipping":true,
            "defaultBilling":true,
            "firstname":"Jane",
            "lastname":"Doe",
            "region":{  
               "regionCode":"NY",
               "region":"New York",
               "regionId":43
            },
            "postcode":"10755",
            "street":[  
               "123 Oak Ave"
            ],
            "city":"Purchase",
            "telephone":"512-555-1111",
            "countryId":"US"
         }
      ]
   },
   "password":"Password1",
   "cartItem":{  
      "sku":"WS12-M-Orange",
      "qty":1,
      "quote_id":"4"
   },
   "addressInformation":{  
      "shipping_address":{  
         "region":"New York",
         "region_id":43,
         "region_code":"NY",
         "country_id":"US",
         "street":[  
            "123 Oak Ave"
         ],
         "postcode":"10577",
         "city":"Purchase",
         "firstname":"Jane",
         "lastname":"Doe",
         "email":"jdoe@example.com",
         "telephone":"512-555-1111"
      },
      "billing_address":{  
         "region":"New York",
         "region_id":43,
         "region_code":"NY",
         "country_id":"US",
         "street":[  
            "123 Oak Ave"
         ],
         "postcode":"10577",
         "city":"Purchase",
         "firstname":"Jane",
         "lastname":"Doe",
         "email":"jdoe@example.com",
         "telephone":"512-555-1111"
      },
      "shipping_carrier_code":"tablerate",
      "shipping_method_code":"bestway"
   },
   "paymentMethod":{  
      "method":"banktransfer"
   },
   "billing_address":{  
      "email":"jdoe@example.com",
      "region":"New York",
      "region_id":43,
      "region_code":"NY",
      "country_id":"US",
      "street":[  
         "123 Oak Ave"
      ],
      "postcode":"10577",
      "city":"Purchase",
      "telephone":"512-555-1111",
      "firstname":"Jane",
      "lastname":"Doe"
   }
}
