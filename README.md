# Laravel-Practice
Laravel Template

Install PHP
--------------
```
sudo apt update
sudo apt install php

sudo apt update
sudo apt install php-fpm

systemctl status php7.4-fpm
```

Install node & npm
--------------------
```
sudo apt update && sudo apt install curl -y
curl https://raw.githubusercontent.com/creationix/nvm/master/install.sh | bash
source ~/.profile 
nvm ls-remote
nvm install v14.16.0
nvm list
```
Change version
  nvm use v15.12.0 

Access PHP Object in Javascript
------------------------------------

##### In controller:
```
compact('user')
^ Illuminate\Support\Collection {#1839 ▼
  #items: array:1 [▼
    0 => {#1831 ▼
      +"count": 543
    }
  ]
}
```

##### In Javascript
```
<script>
    var dataSet = @json($users ?? '');
    alert(dataSet[0]['count']);
</script>
```
Replacing Parameters In Translation Strings
-------------------------------
.php file
```
$subject = trans('constants.feedback.email.subjects.start_processing', ['code' => $feedback->code], 'en');

en:
 'email' => [
            'subjects' => [
                config('constants.feedback.email.subjects.start_processing') => 'NOTICE OF RECEIVING FEEDBACK - REFERENCE NUMBER: ":code"',
            ],
        ],

vn:
'email' => [
            'subjects' => [
                config('constants.feedback.email.subjects.start_processing') => 'THÔNG BÁO TIẾP NHẬN FEEDBACK– SỐ THAM CHIẾU: ":code"',
            ],
        ],
```

config.php file
```
 'email' => [
            'subjects' => [
                'start_processing' => 'start_processing',
            ],
        ],
```
https://laravel.com/docs/8.x/localization#replacing-parameters-in-translation-strings
