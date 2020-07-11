## Simple Rest API

## Features
- Laravel default authentication scaffolding
- Static code analysis with phpcs
    - PHPCS
    - PHPMD

- Operation
    - Create
        - Validation
    - Retrive
    - Update
    - Delete
- Exception Handling
- API Auth Token
- BasicAuth middleware

## Details instructions

----

## Project structure

    -- laradock
    -- Laravel-Practice

## Installation

    Colne laradock:
    --------------
    git clone https://github.com/Laradock/laradock.git
    cd laradock
    cp env-example .env

    Clone project
    ---------------
    git clone -b rest-api https://github.com/mrafiq709/Laravel-Practice.git
    cd Laravel-Practice
    cp .env.example .env
    
    Database:
    ------------
    database name: db_rest
    db_host: localhost
    username: root
    pass: root
    
    Docker:
    -------
    cd laradock
    docker-compose up -d nginx mysql phpmyadmin redis workspace
    docker exec -it laradock_workspace_1 bash
    cd Laravel-Practice
    composer up
    php artisan migrate
    php artisan db:seed
    
    
    VHost configure:
    ----------------
    add "127.0.0.1    rest.api.test" to /etc/hosts [if windows then add in windows hosts file]
    
    [inside laradock_workspace_1 container]
    
    cd laradock/nginx/sites
    cp app.conf.example rest-api.conf
    nano rest-api.conf
    
    server {

        listen 80;
        listen [::]:80;

        # For https
        # listen 443 ssl;
        # listen [::]:443 ssl ipv6only=on;
        # ssl_certificate /etc/nginx/ssl/default.crt;
        # ssl_certificate_key /etc/nginx/ssl/default.key;

        server_name rest.api.test;
        root /var/www/Laravel-Practice/public;
        index index.php index.html index.htm;

        location / {
             try_files $uri $uri/ /index.php$is_args$args;
        }

        location ~ \.php$ {
            try_files $uri /index.php =404;
            fastcgi_pass php-upstream;
            fastcgi_index index.php;
            fastcgi_buffers 16 16k;
            fastcgi_buffer_size 32k;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            #fixes timeouts
            fastcgi_read_timeout 600;
            include fastcgi_params;
        }

        location ~ /\.ht {
            deny all;
        }

        location ~* \.(eot|ttf|woff|woff2)$ {
            add_header Access-Control-Allow-Origin *;
        }

        location /.well-known/acme-challenge/ {
            root /var/www/letsencrypt/;
            log_not_found off;
        }
    }
    
    press: ctrl + x
    write: yes
    press enter
    exit
    
    cd laradock
    docker-compose down
    docker-compose up
    
Now http://rest.api.test
    
----

----

Laravel default authentication scaffolding:
--------------------------------------------
    composer require laravel/ui
    php artisan ui vue --auth
    php artisan migrate
ref:  https://laravel.com/docs/7.x/authentication

***Note:** Sometimes Routs::auth() not found for apache configuration.*

Two most common causes of this behavior are: mod_rewrite not enabled

    sudo a2enmod rewrite && sudo service apache2 restart
    
AllowOverride is set to None, set it to All, assuming Apache2.4

    sudo nano /etc/apache2/apache2.conf
    
search for <Directory /var/www/> and change AllowOverride None to AllowOverride All, then save the file and restart apache

----

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
    
Some error will display on terminal also you will get a message on bottom of report that some error could be fixed automatically

To automatically fix those error run this command.

    ./vendor/bin/phpcbf app/Http/Controllers/TestController.php
     
But whenever we modified something we have to run this command again and again. So, if we setup a configuration file,

we do not need to run everytime. Let's setup:

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

add this extra line with above.

    <exclude-pattern>public</exclude-pattern>

Now we can check our all app/ directory code by just a simple command

    ./vendor/bin/phpcs
    
Every time before you commit your changes. You have to run phpcbf and phpcs . Sometimes, you forget. 

And you have to fix phpcs coding standard problem and commit/push again. So lets setup Git Commit PreHook Config

**Setup Git Commit PreHook Config [for linux os]**

Create a folder with name **git-hooks** in root directory of your application and inside this folder 

create a file with name **pre-commit** [no extension].

Place the bellow code in that file.

    #!/bin/bash

    STAGED_FILES=$(git diff --cached --name-only --diff-filter=ACM | grep ".php\{0,1\}$")

    if [[ "$STAGED_FILES" = "" ]]; then
      exit 0
    fi

    PASS=true

    printf "\nValidating PHPCS:\n"

    # Check for phpcs
    which ./vendor/bin/phpcs &> /dev/null
    if [[ "$?" == 1 ]]; then
      printf "\t\033[41mPlease install PHPCS\033[0m"
      exit 1
    fi

    RULESET=./phpcs.xml

    for FILE in $STAGED_FILES
    do
      ./vendor/bin/phpcs --colors --standard="$RULESET" "$FILE"

      if [[ "$?" == 0 ]]; then
        printf "\n\t\033[32mPHPCS Passed: $FILE\033[0m"
      else
        printf "\n\t\033[41mPHPCS Failed: $FILE\033[0m"
        PASS=false
      fi
    done

    printf "\nPHPCS validation completed!\n"

    if ! $PASS; then
      printf "\033[41mCOMMIT FAILED:\033[0m Your commit contains files that should pass PHPCS but do not. Please fix the PHPCS errors and try again.\n"
      exit 1
    else
      printf "\033[42mCOMMIT SUCCEEDED\033[0m\n"
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
     
 ***Note:** please use git bash if you get any error like bellow*

    > cp git-hooks/pre-commit .git/hooks/pre-commit
    'cp' is not recognized as an internal or external command,
    operable program or batch file.
    Script cp git-hooks/pre-commit .git/hooks/pre-commit handling the post-install-cmd event returned with error code 1

 ***Note:** For Docker container if: **fatal: cannot run .git/hooks/pre-commit: No such file or directory** => then run bellow command*
 
 **Explanation of error:** Your pre-commit file has extraneous carriage(external changes) returns in it. This can happen if you edit the file in Windows and copy the file to a Linux computer.
 
    cp .git/hooks/pre-commit /tmp/pre-commit
    tr -d '\r' < /tmp/pre-commit > .git/hooks/pre-commit

Now Run

    composer up
    
***That's it !***

----

## PHPMD

    composer require --dev phpmd/phpmd
    
Run PPHMD on terminal:

    ./vendor/bin/phpmd app text cleancode,codesize,controversial,design,naming,unusedcode > phpmd.text
    
**Command Analysis**

    vendor/bin/phpmd                                            =>  phpmd location
    app                                                         =>  analysable code directory
    text                                                        =>  output formate[html is also fine]
    cleancode,codesize,controversial,design,naming,unusedcode   =>  rule to analysis code
    > phpmd.text                                                =>  save output on phpmd.text file [it will save in current directory]

We can save all rules on a xml file. Create **phpmd.xml** file in the root directory of application.
Replace bellow code into phpmd.xml:

    <?xml version="1.0" encoding="UTF-8"?>
    <ruleset name="Laravel and similar phpmd ruleset"
        xmlns="http://pmd.sf.net/ruleset/1.0.0"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://pmd.sf.net/ruleset/1.0.0 http://pmd.sf.net/ruleset_xml_schema.xsd"
        xsi:noNamespaceSchemaLocation="http://pmd.sf.net/ruleset_xml_schema.xsd">
      <description>
        Inspired by https://github.com/phpmd/phpmd/issues/137
        using http://phpmd.org/documentation/creating-a-ruleset.html
      </description>
      <!-- se importan los rulesets, en este caso todos. -->
      <rule ref="rulesets/cleancode.xml">
        <exclude name="StaticAccess"/>
      </rule>
      <rule ref="rulesets/codesize.xml/CyclomaticComplexity"/>
      <rule ref="rulesets/codesize.xml/NPathComplexity"/>
      <rule ref="rulesets/codesize.xml/ExcessiveMethodLength"/>
      <rule ref="rulesets/codesize.xml/ExcessiveClassLength"/>
      <rule ref="rulesets/codesize.xml/ExcessiveParameterList"/>
      <rule ref="rulesets/codesize.xml/ExcessivePublicCount"/>
      <rule ref="rulesets/codesize.xml/TooManyFields"/>
      <rule ref="rulesets/codesize.xml/TooManyMethods">
          <properties>
              <property name="maxmethods" value="30"/>
          </properties>
      </rule>
      <rule ref="rulesets/codesize.xml/ExcessiveClassComplexity"/>
      <rule ref="rulesets/controversial.xml"/>
      <rule ref="rulesets/design.xml">
          <exclude name="CouplingBetweenObjects"/>
      </rule>
      <!-- beware the façades yo. -->
      <rule ref="rulesets/design.xml/CouplingBetweenObjects">
          <properties>
              <property name="minimum" value="20"/>
          </properties>
      </rule>
      <!-- se importa naming y se excluye ShortVariable para ser ajustada despues. -->
      <rule ref="rulesets/naming.xml">
          <exclude name="ShortVariable"/>
      </rule>
      <rule ref="rulesets/naming.xml/ShortVariable"
            since="0.2"
            message="Avoid variables with short names like {0}. Configured minimum length is {1}."
            class="PHPMD\Rule\Naming\ShortVariable"
            externalInfoUrl="http://phpmd.org/rules/naming.html#shortvariable">
          <priority>3</priority>
          <properties>
              <property name="minimum" description="Minimum length for a variable, property or parameter name" value="3"/>
              <property name="exceptions" value="id,q,w,i,j,v,e,f,fp" />
          </properties>
      </rule>
      <rule ref="rulesets/unusedcode.xml"/>
    </ruleset>

Now we can run command like bellow:

    vendor/bin/phpmd app text phpmd.xml > phpmd.text
    
***Note:** If we do not write "> phpmd.text" it will be printed in command line.*

----
    
ref 1: [https://medium.com/@setkyarwalar/setting-up-phpcs-on-laravel-908bccb82db]

ref 2: [https://github.com/ashraf789/PHP-static-code-analysis]
