#Before setup

###Install composer
https://getcomposer.org
Follow install instructions for your operating system

###setup
Clone this repo from GitHub
Create local config file
Make a copy of ``.env.example`` and name it ``.env``
Edit ``.env`` in a text editor, update info about elastic search etc.

###Install vendor libraries via composer
navigate to the root folder of the project (where composer.json is located)
run: 

    composer install

Libraries used by the portal will now be downloaded, this could take a while
The libraries will be downloaded into the directory called “vendor”, this directory is ignored in the file ``.gitignore``
If you have project files from your IDE in the same folder as the source code, add these to ``.gitignore``

###Compile JS and CSS files

Gulp is used to compile SCSS into CSS files and to combine and minify all JavaScript files. Before deployment gulp has to be run:

    npm install
    bower install
    gulp

For Windows:</br></br>
   1) Download node.js https://nodejs.org/en/download/</br>
   2) Download python https://www.python.org/getit/windows/</br>
   3) Run <code> npm install -g node-gyp</code></br>
   4) Run <code> npm install </code></br>
   5) Run <code> npm install -g bower</code></br>
   5) Run <code> npm install -g gulp</code></br>

###Run during development
To run PHP:s built in webserver run:

    php artisan serve

To automatically recompile js and css files after changes

    gulp watch

###Distribution

In order to create a distribution package run:

    gulp dist

This tar.gz package contains all files needed to run the application on a web server.
Before building the package make sure that the variables in `.env` are set up
for the production environment.


##Setup portal in apache

Easiest way to do development is to create a virtual host (vhost).
Example config:

    <VirtualHost ariadne.laravel.localhost:80>
        ServerAdmin webmaster@dummy-host2.example.com
        DocumentRoot "C:/Users/karl/ariadne-portal/public/"
    	
    	<Directory "C:/Users/karl/ariadne-portal/public/">
            Options Indexes FollowSymLinks Includes ExecCGI 
            Order allow,deny  
            Allow from all  
            AllowOverride All 
            AddDefaultCharset UTF-8
    	</Directory>
    	
        ServerName ariadne.laravel.localhost
        ErrorLog "logs/ariadne.laravel.localhost-error.log"
        CustomLog "logs/ariadne.laravel.localhost-access.log" common
    </VirtualHost>


Observe the path of the directory, DocumentRoot should be the folder named public inside the project folder.
Place this file in apaches vhost directory, be sure the line for loading the module vhost_alias_module and “Include conf/extra/httpd-vhosts.conf” is uncommented. In httpd.conf

###Add an entry to your host file:
(on windows C:\Windows\System32\Drivers\etc\hosts, mac: Open ``/Applications/Utilities/NetInfo Manager``, linux: ``sudo nano /etc/hosts``)
``ariadne.laravel.localhost 127.0.0.1``


The portal should now be hosted via http://ariadne.laravel.localhost