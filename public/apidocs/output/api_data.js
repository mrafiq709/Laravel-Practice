define({ "api": [
  {
    "type": "get",
    "url": "/api/device/show",
    "title": "List",
    "version": "1.0.0",
    "group": "Device",
    "success": {
      "examples": [
        {
          "title": "Success Example:",
          "content": "\"Device\": [\n    {\n        \"id\": 1,\n        \"device_token\": \"d708cee3af1bbf72\",\n        \"type\": \"android\",\n        \"push_token\": \"cHyDZsvcTIeA9xoG2Gfi-l:APA91bEhdKzV_v22jQsBhIQAqGv48fYa1H9e7aNs5L4W1h_-E3EmzwkXWt0w7Meoz1WyZ62QO3WWe3lawCAOnGNwQxmeVrFKqs2C7JiyqpVNs7e6jE0gHfW2EGF9Q5rEqP2kOQ-vgTNz\",\n        \"created_at\": \"2020-11-29T11:42:40.000000Z\",\n        \"updated_at\": \"2020-11-29T12:10:25.000000Z\"\n    }\n]",
          "type": "json"
        }
      ]
    },
    "filename": "input/Device.js",
    "groupTitle": "Device",
    "name": "GetApiDeviceShow",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-api-key",
            "description": "<p>Access Token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n   \"x-api-key\": \"bbfe292a773aa314b527a4fdf23d5ebe\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "AccessToken",
            "description": "<p>If x-api-key not set</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 401 Unathorize\n{\n     \"message\": \"API Key not found\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/device",
    "title": "create",
    "version": "1.0.0",
    "group": "Device",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "\"android\"",
              "\"ios\""
            ],
            "optional": false,
            "field": "type",
            "description": "<p>required</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device_token",
            "description": "<p>required</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "push_token",
            "description": "<p>required</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Result from DB.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success Example:",
          "content": "{\n       \"message\": \"Push Token Created Successfully !\",\n       \"data\": {\n           \"type\": \"android\",\n           \"device_token\": \"123456789\",\n           \"push_token\": \"123456789\",\n           \"updated_at\": \"2020-11-29T15:24:39.000000Z\",\n           \"created_at\": \"2020-11-29T15:24:39.000000Z\",\n           \"id\": 3\n       }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "input/Device.js",
    "groupTitle": "Device",
    "name": "PostApiDevice",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "x-api-key",
            "description": "<p>Access Token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n   \"x-api-key\": \"bbfe292a773aa314b527a4fdf23d5ebe\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "AccessToken",
            "description": "<p>If x-api-key not set</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 401 Unathorize\n{\n     \"message\": \"API Key not found\"\n}",
          "type": "json"
        }
      ]
    }
  }
] });
