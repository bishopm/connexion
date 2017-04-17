# Connexion

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Installation

1. Install laravel using Composer (eg: to create a project named connexion: `laravel new connexion`)
2. Change to the project folder created and fix permissions on bootstrap and storage folders: 
`sudo chmod -R 777 storage / bootstrap`
3. Add the connexion package to composer.json by adding a repositories section and requiring the package as follows:
```
"repositories": [
   {
     "type": "git",
     "url": "https://github.com/bishopm/connexion"
   }
],
"require-dev": {
   ...
   "bishopm/connexion": "dev-master"
},
```
4. Run *composer update* in the project folder, which will pull in the package and its dependencies
5. Add the package service provider to config/app.php (in the providers section): 
`Bishopm\Connexion\Providers\ConnexionServiceProvider::class,`
6. Add your database credentials to .env
7. In the project folder, run
`php artisan connexion:install`
follow the prompts to create your first admin user, and you're good to go!