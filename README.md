Telegram Bot Laravel
---------------------
create telegram new boot with BotFather

search in telegram @BotFather then

type `/newbot`

then `choose a name for your bo`

then `choose a username for your bot`

then it will give you a access token. update **.env** file with it
```
TELE_BOT_TOKEN=your-bot-token
TELE_BOT_NAME=your-bot-name
TELE_CHAT_ID=your-group-or-channel-id
```
How to get CHAT_ID
-------------------
Send any message in your group or channel then

Hit: https://api.telegram.org/bot{TELE_BOT_TOKEN}/getUpdates

Then you will receive like below
```
"chat":{"id":1577648133
```
Route
-------
```php
Route::get('/test', 'TelegramBotController@test');
```

Controller
-------------
```php
<?php

namespace App\Http\Controllers;

use App\Services\Telegram\TelegramReportSend;
use Request;

class TelegramBotController extends Controller
{
    public function test(Request $request, TelegramReportSend $report)
    {
        $report->new();
    }
}

```

Services
-----------
```php
app/Services/Telegram/TeleBotApiCall.php
app/Services/Telegram/TelegramReportSend.php
```

