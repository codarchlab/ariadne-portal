<?php

use Illuminate\Support\Facades\Storage;

$content = file_get_contents(base_path() . '/package.json');
$package = json_decode($content);

return [

	/*
	|--------------------------------------------------------------------------
	| Elastic Search host
	|--------------------------------------------------------------------------
	|
	| The host providing the elastic search service
	|
	*/    
    
	'elastic_search_host' => env('ELASTIC_SEARCH_HOST'),
	'elastic_search_catalog_index' => env('ELASTIC_SEARCH_CATALOG_INDEX'),
    'elastic_search_subject_index' => env('ELASTIC_SEARCH_SUBJECT_INDEX'),
    
	/* Aggregations used for filtering in the search */
	'elastic_search_aggregations' => [
        'archaeologicalResourceType' => ['terms' => ['field' => 'archaeologicalResourceType.name.raw']],        
        'derivedSubject' => ['terms' => ['field' => 'derivedSubject.prefLabel.raw']],
        'keyword' => ['terms' => ['field' => 'keyword.raw']],
        'contributor' => ['terms' => ['field' => 'contributor.name.raw']],
        'publisher' => ['terms' => ['field' => 'publisher.name.raw']],
        /*'temporal' => [
        	'nested' => ['path' => 'temporal'],
        	'aggs' => [
        		'temporal' =>[
        			'terms' => ['field' => 'temporal.periodName.raw']
        		]
        	]
        ],*/
        'temporal' => [
        	'nested' => ['path' => 'temporal'],
        	'aggs' => [
        		'temporal' =>[
        			'terms' => ['field' => 'temporal.periodName.raw'],
                                'aggs' =>[
                                    'top_reverse_nested'=>[
                                        'reverse_nested'=>new \stdClass()
                                    ]
                                ]
                                
        		]
        	]
        ],    
        'issued' => ['terms' => ['field' => 'issued.raw']],
        'nativeSubject' => ['terms' => ['field' => 'nativeSubject.prefLabel.raw']]
	],
  
	/*List of posible sorts */
	'elastic_search_sort' => [
		'issued',
		'title'
	],
    
	/*
	 * Fields to search in if a specific fieldgroup is selected in the frontpage search form
	 * (same values should be configured in assets/views/pages/welcome.blade.php)
	*/
	'elastic_search_field_groups' =>[
		'subject' => ['nativeSubject.prefLabel', 'aatSubjects.label', 'derivedSubject.prefLabel'],
		'time' => ['temporal.periodName'],
		'location' => ['spatial.placeName'],
		'identifier' => ['identifier', 'originalId'],
		'title' => ['title'],
		'nativeSubject' => ['nativeSubject.prefLabel'],
		'derivedSubject' => ['derivedSubject.prefLabel'],
		'subjectUri' => ['derivedSubject.source']
	],

	/* Aggregations whose values should be translated */
	'translate_aggregations' => [ 'type', 'language' ],
    
	/*
	|--------------------------------------------------------------------------
	| MORe
	|--------------------------------------------------------------------------
	|
	| The MORe host
	|
	*/  
    
	'more_host' => env('MORE_HOST'),    
    
	/*
	|--------------------------------------------------------------------------
	| Google analytics
	|--------------------------------------------------------------------------
	|
	| The Google Analytics access key
	|
	*/  
    
	'google_analytics' => env('GOOGLE_ANALYTICS'),

	/*
	|--------------------------------------------------------------------------
	| Contact eMail addresses
	|--------------------------------------------------------------------------
	|
	| The eMail addresses for reporting data quality issues
	|
	*/  
    
	'contact_email' => env('CONTACT_EMAIL'),


	/*
	|--------------------------------------------------------------------------
	| Application version
	|--------------------------------------------------------------------------
	|
	| Retrieve app version as stated in package.json
	|
	*/
		'version' => $package->version,
    
    
	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

	'debug' => env('APP_DEBUG'),

	/*
	|--------------------------------------------------------------------------
	| Application URL
	|--------------------------------------------------------------------------
	|
	| This URL is used by the console to properly generate URLs when using
	| the Artisan command line tool. You should set this to the root of
	| your application so that it is used when running Artisan tasks.
	|
	*/

	'url' => 'http://localhost',

	/*
	|--------------------------------------------------------------------------
	| Application Timezone
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default timezone for your application, which
	| will be used by the PHP date and date-time functions. We have gone
	| ahead and set this to a sensible default for you out of the box.
	|
	*/

	'timezone' => 'UTC',

	/*
	|--------------------------------------------------------------------------
	| Application Locale Configuration
	|--------------------------------------------------------------------------
	|
	| The application locale determines the default locale that will be used
	| by the translation service provider. You are free to set this value
	| to any of the locales which will be supported by the application.
	|
	*/

	'locale' => 'en',

	/*
	|--------------------------------------------------------------------------
	| Application Fallback Locale
	|--------------------------------------------------------------------------
	|
	| The fallback locale determines the locale to use when the current one
	| is not available. You may change the value to correspond to any of
	| the language folders that are provided through your application.
	|
	*/

	'fallback_locale' => 'en',

	/*
	|--------------------------------------------------------------------------
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| This key is used by the Illuminate encrypter service and should be set
	| to a random, 32 character string, otherwise these encrypted strings
	| will not be safe. Please do this before deploying an application!
	|
	*/

	'key' => env('APP_KEY', 'SomeRandomString'),

	'cipher' => MCRYPT_RIJNDAEL_128,

	/*
	|--------------------------------------------------------------------------
	| Logging Configuration
	|--------------------------------------------------------------------------
	|
	| Here you may configure the log settings for your application. Out of
	| the box, Laravel uses the Monolog PHP logging library. This gives
	| you a variety of powerful log handlers / formatters to utilize.
	|
	| Available Settings: "single", "daily", "syslog", "errorlog"
	|
	*/

	'log' => 'daily',

	/*
	|--------------------------------------------------------------------------
	| Autoloaded Service Providers
	|--------------------------------------------------------------------------
	|
	| The service providers listed here will be automatically loaded on the
	| request to your application. Feel free to add your own services to
	| this array to grant expanded functionality to your applications.
	|
	*/

	'providers' => [
                
		/*
		 * Laravel Framework Service Providers...
		 */
		'Illuminate\Foundation\Providers\ArtisanServiceProvider',
		'Illuminate\Auth\AuthServiceProvider',
		'Illuminate\Bus\BusServiceProvider',
		'Illuminate\Cache\CacheServiceProvider',
		'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
		'Illuminate\Routing\ControllerServiceProvider',
		'Illuminate\Cookie\CookieServiceProvider',
		'Illuminate\Database\DatabaseServiceProvider',
		'Illuminate\Encryption\EncryptionServiceProvider',
		'Illuminate\Filesystem\FilesystemServiceProvider',
		'Illuminate\Foundation\Providers\FoundationServiceProvider',
		'Illuminate\Hashing\HashServiceProvider',
		'Illuminate\Mail\MailServiceProvider',
		'Illuminate\Pagination\PaginationServiceProvider',
		'Illuminate\Pipeline\PipelineServiceProvider',
		'Illuminate\Queue\QueueServiceProvider',
		'Illuminate\Redis\RedisServiceProvider',
		'Illuminate\Auth\Passwords\PasswordResetServiceProvider',
		'Illuminate\Session\SessionServiceProvider',
		'Illuminate\Translation\TranslationServiceProvider',
		'Illuminate\Validation\ValidationServiceProvider',
		'Illuminate\View\ViewServiceProvider',
		'Illuminate\Html\HtmlServiceProvider',
		'Illuminate\Broadcasting\BroadcastServiceProvider',
        /*
		 * Laravel debugbarDebug
		 */
		'Barryvdh\Debugbar\ServiceProvider',
            
		/*
		 * Application Service Providers...
		 */
		'App\Providers\AppServiceProvider',
		'App\Providers\BusServiceProvider',
		'App\Providers\ConfigServiceProvider',
		'App\Providers\EventServiceProvider',
		'App\Providers\RouteServiceProvider',

	],

	/*
	|--------------------------------------------------------------------------
	| Class Aliases
	|--------------------------------------------------------------------------
	|
	| This array of class aliases will be registered when this application
	| is started. However, feel free to register as many as you wish as
	| the aliases are "lazy" loaded so they don't hinder performance.
	|
	*/

	'aliases' => [
                
		'App'       => 'Illuminate\Support\Facades\App',
		'Artisan'   => 'Illuminate\Support\Facades\Artisan',
		'Auth'      => 'Illuminate\Support\Facades\Auth',
		'Blade'     => 'Illuminate\Support\Facades\Blade',
		'Bus'       => 'Illuminate\Support\Facades\Bus',
		'Cache'     => 'Illuminate\Support\Facades\Cache',
		'Config'    => 'Illuminate\Support\Facades\Config',
		'Cookie'    => 'Illuminate\Support\Facades\Cookie',
		'Crypt'     => 'Illuminate\Support\Facades\Crypt',
		'DB'        => 'Illuminate\Support\Facades\DB',
		'Eloquent'  => 'Illuminate\Database\Eloquent\Model',
		'Event'     => 'Illuminate\Support\Facades\Event',
		'File'      => 'Illuminate\Support\Facades\File',
		'Hash'      => 'Illuminate\Support\Facades\Hash',
		'Input'     => 'Illuminate\Support\Facades\Input',
		'Inspiring' => 'Illuminate\Foundation\Inspiring',
		'Lang'      => 'Illuminate\Support\Facades\Lang',
		'Log'       => 'Illuminate\Support\Facades\Log',
		'Mail'      => 'Illuminate\Support\Facades\Mail',
		'Password'  => 'Illuminate\Support\Facades\Password',
		'Queue'     => 'Illuminate\Support\Facades\Queue',
		'Redirect'  => 'Illuminate\Support\Facades\Redirect',
		'Redis'     => 'Illuminate\Support\Facades\Redis',
		'Request'   => 'Illuminate\Support\Facades\Request',
		'Response'  => 'Illuminate\Support\Facades\Response',
		'Route'     => 'Illuminate\Support\Facades\Route',
		'Schema'    => 'Illuminate\Support\Facades\Schema',
		'Session'   => 'Illuminate\Support\Facades\Session',
		'Storage'   => 'Illuminate\Support\Facades\Storage',
		'URL'       => 'Illuminate\Support\Facades\URL',
		'Validator' => 'Illuminate\Support\Facades\Validator',
		'View'      => 'Illuminate\Support\Facades\View',
		'Utils'     => 'App\Services\Utils',
		'Debugbar'  => 'Barryvdh\Debugbar\Facade',
		'Form'      => 'Illuminate\Html\FormFacade',
		'Html'      => 'Illuminate\Html\HtmlFacade',
	],

];
