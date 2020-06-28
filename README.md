## Simple Rest API

## Features
##### 1.    Laravel default authentication scaffolding
##### 2.    Static code analysis with phpcs
            |--> PHPCS
            
##### 3.    API authentication key

## Details instructions

Laravel default authentication scaffolding:
--------------------------------------------
    composer require laravel/ui
    php artisan ui vue --auth
    php artisan migrate
ref:  https://laravel.com/docs/7.x/authentication

Note: Sometimes Routs::auth() not found for apache configuration.
Two most common causes of this behavior are: mod_rewrite not enabled

    sudo a2enmod rewrite && sudo service apache2 restart
    
AllowOverride is set to None, set it to All, assuming Apache2.4

    sudo nano /etc/apache2/apache2.conf
    
search for <Directory /var/www/> and change AllowOverride None to AllowOverride All, then save the file and restart apache

Static code analysis with phpcs:
---------------------------------
## PHPCS
    composer require --dev squizlabs/php_codesniffer
    
Now create a controller by artisan like **php artisan make:controller TestController** And modify controller like bellow.

    namespace AppHttpControllers;
    use IlluminateHttpRequest;
    class testController extends Controller
    {
        private function testTest(){
        }
    }
    
Run PPHCS on terminal

    ./vendor/bin/phpcs app/Http/Controllers/TestController.php
    
Some error will display on terminal also you will get a message on bottom of report that some error could be fixed automatically To automatically fix those error run this command.

    ./vendor/bin/phpcbf app/Http/Controllers/TestController.php
     
But whenever we modified something we have to run this command again and again. So, if we setup a configuration file, we do not need to run
everytime. Let's setup:

**Setup PHPCS Config [for linux os]**
Create a file with name **phpcs.xml** in the root directory of your application and placed the bellow code.

    <?xml version="1.0"?>
    <ruleset name="PSR2">    
    <description>The PSR2 coding standard.</description>    
    <rule ref="PSR2"/> <!-- Here checking code for PSR2 format -->
    <!-- <rule ref="PEAR"/> --> <!-- Here checking code for PEAR format. Please comment out if you want to enable this format-->
    
    <!-- We want to check only app directory of the project -->
    <file>app/</file>
    
    <!-- The directory listed bellows will be ommited for checking -->
    <exclude-pattern>vendor</exclude-pattern>    
    <exclude-pattern>resources</exclude-pattern>    
    <exclude-pattern>database/</exclude-pattern>    
    <exclude-pattern>storage/</exclude-pattern>    
    <exclude-pattern>node_modules/</exclude-pattern>
    </ruleset>

**Setup PHPCS Config [for windows os]**

    <exclude-pattern>public</exclude-pattern>
    
add this extra line with above.

Now we can check our all app/ directory code by just a simple command

    ./vendor/bin/phpcs
    
Every time before you commit your changes. You have to run phpcbf and phpcs . Sometimes, you forget. And you have to fix phpcs coding standard problem and commit/push again. So lets setup Git Commit PreHook Config

**Setup Git Commit PreHook Config [for linux os]**
Create a folder with name **git-hooks** in root directory of your application and inside this folder create a file with name **pre-commit** [no extension].
Place the bellow code in that file.

    #!/bin/bash

    STAGED_FILES=$(git diff --cached --name-only --diff-filter=ACM | grep ".php\{0,1\}$")

    if [[ "$STAGED_FILES" = "" ]]; then
      exit 0
    fi

    PASS=true

    echo "\nValidating PHPCS:\n"

    # Check for phpcs
    which ./vendor/bin/phpcs &> /dev/null
    if [[ "$?" == 1 ]]; then
      echo "\t\033[41mPlease install PHPCS\033[0m"
      exit 1
    fi

    RULESET=./phpcs.xml

    for FILE in $STAGED_FILES
    do
      ./vendor/bin/phpcs --standard="$RULESET" "$FILE"

      if [[ "$?" == 0 ]]; then
        echo "\t\033[32mPHPCS Passed: $FILE\033[0m"
      else
        echo "\t\033[41mPHPCS Failed: $FILE\033[0m"
        PASS=false
      fi
    done

    echo "\nPHPCS validation completed!\n"

    if ! $PASS; then
      echo "\033[41mCOMMIT FAILED:\033[0m Your commit contains files that should pass PHPCS but do not. Please fix the PHPCS errors and try again.\n"
      exit 1
    else
      echo "\033[42mCOMMIT SUCCEEDED\033[0m\n"
    fi

    exit $?
    
**Setup Git Commit PreHook Config [for windows os]**
Just chnage the first line to

        #!/bin/sh
        
One more thing- We have to add this pre-commit file in .git/hooks directory. There two option for adding this. I will show you both:
##### Option 1:
    cp git-hooks/pre-commit .git/hooks/pre-commit
    chmod +x .git/hooks/pre-commit
    
##### Option 2:
With composer.json file. Add bellow code in composer.json file inside "scripts":{} portion.

    "post-update-cmd": [
            "cp git-hooks/pre-commit .git/hooks/pre-commit",
            "chmod a+x .git/hooks/pre-commit"
        ],
     "post-install-cmd": [
            "cp git-hooks/pre-commit .git/hooks/pre-commit",
            "chmod a+x .git/hooks/pre-commit"
     ]
     
 **Note: please use git bash if you get any error like bellow**

    > cp git-hooks/pre-commit .git/hooks/pre-commit
    'cp' is not recognized as an internal or external command,
    operable program or batch file.
    Script cp git-hooks/pre-commit .git/hooks/pre-commit handling the post-install-cmd event returned with error code 1

Now Run

    composer up
    
**That's it !**
