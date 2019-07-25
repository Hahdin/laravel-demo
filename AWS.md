# Deploy Laravel to an EC2 instance

This guide is based on and copied in part from [here](https://medium.com/@idelara/step-by-step-guide-manually-deploying-a-laravel-app-running-on-lemp-to-an-aws-ec2-lightsail-d4792fd5c920)
## Start up an EC2 instance on aws
Log into your aws account and launch a new server. 

### EC2 config
- Any region should work.
- t2.nano instance for maximum $$$ savings.
- Amazon Linux (don't pick Amazon Linux 2 for this)

SSH into your server. See [here](https://docs.aws.amazon.com/quickstarts/latest/vmlaunch/step-2-connect-to-instance.html) for more information if you need it.

## Install LEMP

update the server
```
sudo yum update && sudo yum upgrade
```
Then install:
> Note: If you are using a DaaS or a different database, remove mysql57-server from the list. For this project I am using a MySQL instance hosted on AWS RDS.

```
sudo yum install php73 php73-mbstring php73-xml php73-fpm php73-pdo php73-mysqlnd mysql57-server nginx git
```

Confirm PHP installation and version.
```
php --version
```
You should see something like:
```
PHP 7.3.5 (cli) (built: May 24 2019 21:19:20) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.3.5, Copyright (c) 1998-2018 Zend Technologies

```

Check some services
```
sudo service php-fpm status; sudo service nginx status;
```
and you should see something like this:
```
php-fpm-7.3 is stopped
nginx is stopped
```

Test the services to make sure they run.
```
sudo service php-fpm start; sudo service nginx start;
```
No news (errors) is good news. At this point, you can paste your public IP of your EC2 instance into a browser and should see the NGINX default page.

## MySQL
> Ignore if you are using a different database.

Lets see if MySQL was installed okay:
```
sudo service mysqld status
```
You should see:
```
mysqld is stopped
```
Start the service
```
sudo service mysqld start
```

First time it should give a few warnings, set up a few things for us...


```
Initializing MySQL database
2019-07-24T02:02:30.309279Z 0 [Warning] TIMESTAMP with implicit DEFAULT value is                                                                                                                                                              deprecated. Please use --explicit_defaults_for_timestamp server option (see doc                                                                                                                                                             umentation for more details).
2019-07-24T02:02:31.128189Z 0 [Warning] InnoDB: New log files created, LSN=45790
2019-07-24T02:02:31.368814Z 0 [Warning] InnoDB: Creating foreign key constraint                                                                                                                                                              system tables.
2019-07-24T02:02:31.433816Z 0 [Warning] No existing UUID has been found, so we a                                                                                                                                                             ssume that this is the first time that this server has been started. Generating                                                                                                                                                              a new UUID: 1891c718-adb7-11e9-b09b-06294c26b58a.
2019-07-24T02:02:31.436514Z 0 [Warning] Gtid table is not ready to be used. Tabl                                                                                                                                                             e 'mysql.gtid_executed' cannot be opened.
2019-07-24T02:02:32.254109Z 0 [Warning] CA certificate ca.pem is self signed.
2019-07-24T02:02:32.294061Z 1 [Warning] root@localhost is created with an empty                                                                                                                                                              password ! Please consider switching off the --initialize-insecure option.
Starting mysqld:                                           [  OK  ]
[
```
As long as the [ OK ] is there, should be good to go.

## Git clone your repo in.

Assuming you have a git repo, just clone it.
> note that we are cloning our repo to our home directory, and then moving it to /var/www/html/yourappfolder so that our files and folders are created belonging to our user and group [ec2-user].

```bash
git clone https://github.com/yourname/yourrepo.git ~/yourappfolder
sudo mv ~/yourappfolder /var/www/html/
 ```


## Configurations

edit the nginx.conf like so:
```
sudo nano /etc/nginx/nginx.conf
```
We need to tweak our file a little bit. In short we need to add/modify the following lines:
```
http {
    
    ...
index  index.php index.html index.htm;
include  /etc/nginx/sites-enabled/*;
 
    ...
}
```
The first line adds precedence to our PHP index file over its .html and .htmcounterparts. The second line includes all the configuration files located in /etc/nginx/sites-enabled/, directory which as of now, does not exist.

In addition, we need to delete the existing server block nested inside our http block. Make sure you do that, else our config might not work properly.

Make two directories:
```
sudo mkdir /etc/nginx/sites-available /etc/nginx/sites-enabled
```

The first one will hold modular configuration files for each website or app we need to serve from nginx. Particularly, the files will hold only configuration pertaining to their respective apps/websites. The second directory will allow us to turn on/off websites with the use of symlinks (think of a symlink as a pointer to a file). Basically, it is just a directory that holds symlinks to config files in sites-available, and whatever symlinks are present will be loaded to our nginx.conf file by default.

Now we can create the config file for our website. 

Create a new file
```
sudo nano /etc/nginx/sites-available/yourappname.site
```

 and copy/paste the following:
```
server {
    listen 80;
    listen [::]:80;

    # Change this to your Laravel app location
    # Make sure to add the /public directory at the end of your directory, since 
    # this folder is the entry point used by Laravel apps
    root /var/www/html/myapp/public;
    index index.php index.html index.htm index.nginx-debian.html;

    server_name myapp.com;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ [^/]\.php(/|$) {
    
        fastcgi_split_path_info ^(.+?\.php)(/.*)$;
    
        if (!-f $document_root$fastcgi_script_name) {
            return 404;
        }

        # Mitigate https://httpoxy.org/ vulnerabilities
        fastcgi_param HTTP_PROXY "";

        fastcgi_pass 127.0.0.1:8080;
        fastcgi_index index.php;

        # include the fastcgi_param setting
        include fastcgi_params;

        # SCRIPT_FILENAME parameter is used for PHP FPM determining
        #  the script name. If it is not set in fastcgi_params file,
        # i.e. /etc/nginx/fastcgi_params or in the parent contexts,
        # please comment off following line:
        fastcgi_param  SCRIPT_FILENAME   $document_root$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }

}
```

>> Note: I needed to paste the above into my /nginx.conf to get it working


Once our file is created, we need to create a symlink (basically, enable our site’s configuration) in our sites-enabled directory:
```
sudo ln -s /etc/nginx/sites-available/myapp.site /etc/nginx/sites-enabled/myapp.site
```
Once you run the command above, you will have a symlink that will “point to” our original file in sites-available and will get loaded once we restart our nginx service or reload its configuration. Let’s restart our nginx service like so:
```
sudo service nginx restart
```

>> This didn't work for me (I don't think), as I mentioned above I needed to re-insert the modified server block into the nginx.conf file to get it working. Something to look into...

## Setting up php-fpm

Now that we have our config file setup, we need to make sure our php-fpm package is configured to listen on 127.0.0.1:8080 (or any other port that is not in use besides 8080) instead of listening on a UNIX socket. You can do it the other way around, but we’ll do it through the local loopback.  In addition, we need to change the default user and group that php-fpm uses to match that of nginx. We can do so by opening the following file:

```
sudo nano /etc/php-fpm.d/www.conf
```
The lines we need to modify are the following:
```
; RPM: apache user chosen to provide access to the same directories as httpd
user = nginx
; RPM: Keep a group allowed to write in log dir.
group = nginx
...
; The address on which to accept FastCGI requests.
...
; Note: This value is mandatory.
listen = 127.0.0.1:8080
```

Restart the service
```
sudo service php-fpm restart
```

## Setting up MySQL

### secure our MySQL installation
```
mysql_secure_installation
```

Once you run that command, the terminal will prompt you with a series of questions. Taking in consideration that we are using this instance for testing purposes, we can enter the following:
```
VALIDATE PASSWORD PLUGIN can be used to test passwords...      NO
New password:                            TYPE IN YOUR NEW PASSWORD
Remove anonymous users?                                        YES
Disallow root login remotely?                                  YES
Remove test database and access to it?                         YES
Reload privilege tables now?                                   YES
```

Now, we will be able to login to MySQL with our root user using the password we just entered. To do so, run:
```
mysql -u root -p
```

Now that we are in, lets create a database:
```
CREATE DATABASE `yourdbname`;
```
Then, inside that DB, lets create a user for our Laravel app:
> change username and password accordingly

```
CREATE USER 'myuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL ON yourdbname.* TO 'myuser'@'localhost';
```
Now exit
```
exit
```

See if you can log in with the new user

```
mysql -u myuser -p
```
## Composer
Now that we configured our packages, the last step is to install composer and install our project dependencies.
We will install composer in our home directory (to avoid having to add sudo to each composer’s installation commands), and then move it to our project’s directory. To install, run:

> Visit https://getcomposer.org/download/ for current hash

```bash
cd /var/www/html/myapp
sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php
sudo php -r "unlink('composer-setup.php');"
```

We are now ready to install the apps dependencies:
```
cd /var/www/html/myapp
sudo ./composer.phar install --no-dev
```

## Make our app’s directory accessible to nginx
As of now our Laravel app directory is not traversable by nginx, and that is a problem since it will not be able to serve files once we try to access our site.
What we need to do to fix this is add the group nginx to the directories we need nginx to access. But wait, how do we know that? Well, if you try accessing your IP address from your browser right now, your server should respond with a 500 code (server error). Now run the following command:
```
sudo cat /var/log/nginx/error.log
```

Run the following
```
sudo chgrp nginx -R /var/www/html/myapp/storage
```

This changes the group of the storage directory (and other directories and files inside it), recursively.
And then:
```
sudo chmod g+w -R /var/www/html/myapp/storage
```
This command gives write permissions to our nginx group to the directories and files inside our storage directory.

After having modified the permissions for our storage directory, let’s make sure our laravel.log file has the right permissions. I’ve had lots of trouble with this file before. If you have no laravel.log file yet, you can either create it right now to avoid future problems related to write permissions to the file, or you can skip this command. Just remember that if you run into problems with the laravel.log file, you can always come back and modify the file permissions. Ok, now, to modify the file permissions, run:
```
sudo chmod ugo+w /var/www/html/myapp/storage/logs/laravel.log

```
OR you can run this one if the above complains:
```
sudo chmod 776 /var/www/html/myapp/storage/logs/laravel.log
```

> **Note**: Make sure there is a .env file in your project directory. If you cloned if from a git repo, it should not have one (it better not) so make sure you create one and populate it with the required information.





