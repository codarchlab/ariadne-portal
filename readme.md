#Before setup

###Install composer
https://getcomposer.org
Follow install instructions for your operating system

###Clone repo from bitbucket (git)
Clone repo from bitbucket (you need to have access to the private repo at https://bitbucket.org/ariadne-infrastructure/ariadne-portal/) into you project folder.
Create local config file
Make a copy of .env.example and name it .env
Edit .env in a text editor, change username, password and database.

###Install vendor libraries via composer
navigate to the root folder of the project (where composer.json is located)
run: 

    composer install

Libraries used by the portal will now be downloaded, this could take a while
The libraries will be downloaded into the directory called “vendor”, this directory is ignored in the file .gitignore
If you have project files from your IDE in the same folder as the source code, add these to .gitignore

###Compile JS and CSS files

Gulp is used to compile SCSS into CSS files and to combine and minify all JavaScript files. Before deployment gulp has to be run:

    npm install
    bower install
    gulp

For Windows:</br></br>
   1) Download node.js https://nodejs.org/en/download/</br>
   2) Download python https://www.python.org/getit/windows/</br>
   3) Run <code> npm install -g node-gyp</code></br>
   4) Run <code> npm insatll </code></br>
   5) Run <code> npm install -g bower</code></br>
   5) Run <code> npm install -g gulp</code></br>

###Run during development
To run PHP:s built in webserver run:

    php artisan serve

To automatically recompile js and css files after changes

    gulp watch

##Setup apache
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
    	</Directory>
    	
        ServerName ariadne.laravel.localhost
        ErrorLog "logs/ariadne.laravel.localhost-error.log"
        CustomLog "logs/ariadne.laravel.localhost-access.log" common
    </VirtualHost>


Observe the path of the directory, DocumentRoot should be the folder named public inside the project folder.
Place this file in apaches vhost directory, be sure the line for loading the module vhost_alias_module and “Include conf/extra/httpd-vhosts.conf” is uncommented. In httpd.conf

###Add an entry to your host file:
(on windows C:\Windows\System32\Drivers\etc\hosts, mac: Open /Applications/Utilities/NetInfo Manager, linux: sudo nano /etc/hosts)
ariadne.laravel.localhost 127.0.0.1


The portal should no be hosted via http://ariadne.laravel.localhost

Overview of central parts of the portal in Laravel
The application code is located in the sub-folder “app”.
Views are located in resources\views

##Routes (paths)
Laravel looks for matching paths in app/Http/routes.php an example is:

    Route::get('providers', 'ProviderController@index');

This line forwards any request to http://ariadne.laravel.localhost/providers to the function index in the class ProviderController in the file app/Http/Controllers/ProviderController.php

More information about controllers can be found in the Laravel documentation: http://laravel.com/docs/5.0/routing

##Controllers
Controllers handles request and provides a rendered view (html) or data in some form.
Logic for handle the request and rendering of the views should be called here.

###Documentation about controllers:
http://laravel.com/docs/5.0/controllers
Services
A service meant for doing calls for data retrieval.
For example app/Services/Provider.php handles retrieval of provider-records from the Elastic Search.

##Views
Views (templates) is responsible for rendering items.
These are located in resources\views
app.blade.php is the main structure for the portal and is extended for eg home.blade.php or providers.blade.php

Views are called from the controller eg from ProviderController.php:

    $providers = Provider::statistics();
    return view('providers')->with('providers', $providers);

This will give the view (providers.blade.php) a variable ($providers) with all the providers to loop trough.

###More about views:
http://laravel.com/docs/5.0/views
