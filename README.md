# yii2-rave-cms-erp
RaveCMS&ERP - Control Panel Based On Yii2 PHP Framework

Installation
------------

### Installing Rave CMS&ERP application. 

  1. Installing (using Composer)

    If you do not have [Composer](http://getcomposer.org/), follow the instructions in the
    [Installing Yii](https://github.com/yiisoft/yii2/blob/master/docs/guide/start-installation.md#installing-via-composer) section of the definitive guide to install it.

    With Composer installed, you can then install the application using the following commands:

    ```bash
    cd /var/www/
    php composer.phar global require "fxp/composer-asset-plugin:^1.2.0"
    php composer.phar create-project --prefer-dist --stability=dev ravesoft/yii2-rave-cms-erp mysite.com 
    php composer.phar create-project --prefer-dist ravesoft/yii2-rave-cms-erp mysite.com 
    ```

  2. Initialize the installed application

     Execute the `init` command and select `dev` or `prod` as environment.

      ```bash
      cd /var/www/mysite.com/
      php init
      ```
  
  3. Configurate your web server:

     For Apache config file could be the following:
     
     ```apacheconf
     <VirtualHost *:80>
       ServerName mysite.com
       ServerAlias www.mysite.com
       DocumentRoot "/var/www/mysite.com/"
       <Directory "/var/www/mysite.com/">
         AllowOverride All
       </Directory>
     </VirtualHost>
     ```
     For Nginx config file could be the following:
     
     ```nginx
     server {
         charset      utf-8;
         client_max_body_size  200M;
         listen       80;
     
         server_name  mysite.com;
         root         /var/www/mysite.com;
     
         location / {
             root  /var/www/mysite.com/frontend/web;
             try_files  $uri /frontend/web/index.php?$args;
     
             # avoiding processing of calls to non-existing static files by Yii
             location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
                 access_log  off;
                 expires  360d;
                 try_files  $uri =404;
             }
         }
     
         location /admin {
             alias  /var/www/mysite.com/backend/web;
             rewrite  ^(/admin)/$ $1 permanent;
             try_files  $uri /backend/web/index.php?$args;
         }
     
         # avoiding processing of calls to non-existing static files by Yii
         location ~ ^/admin/(.+\.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar))$ {
             access_log  off;
             expires  360d;
     
             rewrite  ^/admin/(.+)$ /backend/web/$1 break;
             rewrite  ^/admin/(.+)/(.+)$ /backend/web/$1/$2 break;
             try_files  $uri =404;
         }
     
         location ~ \.php$ {
             include  fastcgi_params;
             # check your /etc/php5/fpm/pool.d/www.conf to see if PHP-FPM is listening on a socket or port
             fastcgi_pass  unix:/var/run/php5-fpm.sock; ## listen for socket
             #fastcgi_pass  127.0.0.1:9000; ## listen for port
             fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
             try_files  $uri =404;
         }
         #error_page  404 /404.html;
     
         location = /requirements.php {
             deny all;
         }
     
         location ~ \.(ht|svn|git) {
             deny all;
         }
     }
     ```
     
       
  4. Create a new database and adjust the `components['db']` configuration in `common/config/main-local.php` accordingly.

  5. Apply all migrations with console command `php yii migrate --migrationLookup=@ravesoft/yii2-rave-core-rest/migrations/,@ravesoft/yii2-rave-auth/migrations/,@ravesoft/yii2-rave-settings/migrations/,@ravesoft/yii2-rave-menu/migrations/,@ravesoft/yii2-rave-user/migrations/,@ravesoft/yii2-rave-translation/migrations/,@ravesoft/yii2-rave-media/migrations/,@ravesoft/yii2-rave-post/migrations/,@ravesoft/yii2-rave-page/migrations/,@ravesoft/yii2-comments/migrations/,@ravesoft/yii2-rave-comment/migrations/,@ravesoft/yii2-rave-seo/migrations/`.

  6. Init root user with console command `php yii init-admin`.

  7. Configurate your mailer `['components']['mailer']` in `common/config/main-local.php`.

#####Your `Yee CMS` application is installed. Visit your site `mysite.com` or admin panel `mysite.com/admin`, the site should work and message _Congratulations! You have successfully created your Yii-powered application_ should be displayed.