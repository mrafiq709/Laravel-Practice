/**
* @apiDefine UnAuthorized
* @apiError AccessToken If x-api-key not set
* @apiErrorExample {json} Error-Response:
* HTTP/1.1 401 Unathorize
* {
*      "message": "API Key not found"
* }
*/