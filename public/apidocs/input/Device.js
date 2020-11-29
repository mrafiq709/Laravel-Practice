/**
 * @api {get} /api/device/show List
 * @apiVersion 1.0.0
 * @apiGroup Device
 *
 * @apiUse AuthHeader
 * @apiUse UnAuthorized
 *
 * @apiSuccessExample {json} Success Example:
 * "Device": [
    {
        "id": 1,
        "device_token": "d708cee3af1bbf72",
        "type": "android",
        "push_token": "cHyDZsvcTIeA9xoG2Gfi-l:APA91bEhdKzV_v22jQsBhIQAqGv48fYa1H9e7aNs5L4W1h_-E3EmzwkXWt0w7Meoz1WyZ62QO3WWe3lawCAOnGNwQxmeVrFKqs2C7JiyqpVNs7e6jE0gHfW2EGF9Q5rEqP2kOQ-vgTNz",
        "created_at": "2020-11-29T11:42:40.000000Z",
        "updated_at": "2020-11-29T12:10:25.000000Z"
    }
* ]
*/

/**
 * @api {post} /api/device create
 * @apiVersion 1.0.0
 * @apiGroup Device
 *
 * @apiUse AuthHeader
 * @apiUse UnAuthorized
 * 
 * @apiParam {String="android", "ios"} type required
 * @apiParam {String} device_token required
 * @apiParam {String} push_token required
 * @apiSuccess {Object} data Result from DB.
 *
 * @apiSuccessExample {json} Success Example:
 *  {
        "message": "Push Token Created Successfully !",
        "data": {
            "type": "android",
            "device_token": "123456789",
            "push_token": "123456789",
            "updated_at": "2020-11-29T15:24:39.000000Z",
            "created_at": "2020-11-29T15:24:39.000000Z",
            "id": 3
        }
 *  }
 */