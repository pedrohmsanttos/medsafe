# MedSafer
[![pipeline status](https://git.inhalt.net.br/MedSafer/aplicacao/badges/master/pipeline.svg)](https://git.inhalt.net.br/MedSafer/aplicacao/commits/master)
[![coverage report](https://git.inhalt.net.br/MedSafer/aplicacao/badges/master/coverage.svg)](https://git.inhalt.net.br/MedSafer/aplicacao/commits/master)

The purpose of this repository is to show good development practices on [Laravel](http://laravel.com/) as well as to present cases of use of the framework's features like:

- [Authentication](https://laravel.com/docs/5.6/authentication)
- API
  - Token authentication
  - [API Resources](https://laravel.com/docs/5.6/eloquent-resources)
  - Versioning
- [Blade](https://laravel.com/docs/5.6/blade)
- [Broadcasting](https://laravel.com/docs/5.6/broadcasting)
- [Cache](https://laravel.com/docs/5.6/cache)
- [Email Verification](https://laravel.com/docs/5.6/verification)
- [Filesystem](https://laravel.com/docs/5.6/filesystem)
- [Helpers](https://laravel.com/docs/5.6/helpers)
- [Horizon](https://laravel.com/docs/5.6/horizon)
- [Localization](https://laravel.com/docs/5.6/localization)
- [Mail](https://laravel.com/docs/5.6/mail)
- [Migrations](https://laravel.com/docs/5.6/migrations)
- [Policies](https://laravel.com/docs/5.6/authorization)
- [Providers](https://laravel.com/docs/5.6/providers)
- [Requests](https://laravel.com/docs/5.6/validation#form-request-validation)
- [Seeding & Factories](https://laravel.com/docs/5.6/seeding)
- [Soft deleting](https://laravel.com/docs/5.6/eloquent#soft-deleting)
- [Testing](https://laravel.com/docs/5.6/testing)

Beside Laravel, this project uses other tools like:

- [Bootstrap 3](https://getbootstrap.com/)
- [Font Awesome](http://fontawesome.io/)
- [Redis](https://redis.io/)
- [spatie/laravel-medialibrary](https://github.com/spatie/laravel-medialibrary)
- [laravelgenerator](http://labs.infyom.com/laravelgenerator/)
- [AdminBSBMaterialDesign](https://github.com/gurayyarar/AdminBSBMaterialDesign)
- [Entrust](https://github.com/Zizaco/entrust)
- [laravel-breadcrumbs](https://github.com/davejamesmiller/laravel-breadcrumbs)
- [fzaninotto/faker](https://github.com/fzaninotto/faker)
- [Lavacharts](http://lavacharts.com/)
- Many more to discover.

## Some screenshots

You can find some screenshots of the application on : [#](#)

## Installation

Development environment requirements :
- [Docker](https://www.docker.com) >= 17.06 CE
- [Docker Compose](https://docs.docker.com/compose/install/)

Solutions to possible problems:
- [Docker ports "Windows"](https://success.docker.com/article/error-a-firewall-is-blocking-file-sharing-between-windows-and-the-containers)
- [Docker driver "Windows"](https://github.com/docker/for-win/issues/2995)
- *Linux not problems! ( be careful )
- Solve problem with cache password and user in windows command line (using git clone command): "git config --system --unset credential.helper"

Setting up your development environment on your local machine :
```bash
$ git clone git@git.inhalt.net.br:MedSafer/aplicacao.git
[Windows]$ docker run --rm -v ${pwd}:/app composer install
[Linux S2]$ docker run --rm -v $(pwd):/app composer install
$ cd aplicacao
$ cp .env.example .env
$ docker-compose exec app php artisan key:generate
$ docker-compose exec app php artisan config:clear
$ docker-compose exec app php artisan migrate
$ docker-compose exec app php artisan db:seed
$ docker-compose exec app php artisan cache:clear
$ docker-compose up
```

Now you can access the application via [http://localhost:8080](http://localhost:8080).

**There is no need to run ```php artisan serve```. PHP is already running in a dedicated container.**

**On change classmap run ```docker run --rm -v ${pwd}:/app composer dump-autoload``` on service app**

## Before starting
You need to run the migrations with the seeds :
```bash
$ docker-compose exec app php artisan db:seed --class=ClassTableSeeder
```

Acess bash on services:
```bash
$ docker exec -it name_service /bin/sh
```

This will create a new user that you can use to sign in :
```yml
email: inhalt@inhalt.com.br
password: inhalt
```

## Useful commands
Seeding the database :
```bash
$ docker-compose run --rm app php artisan db:seed
```

Running tests :
```bash
$ docker-compose run --rm app ./vendor/bin/phpunit --cache-result --order-by=defects --stop-on-defect
```

Running php-cs-fixer :
```bash
$ docker-compose run --rm --no-deps app ./vendor/bin/php-cs-fixer fix --config=.php_cs --verbose --dry-run --diff
```

Generating backup :
```bash
$ docker-compose run --rm app php artisan backup:run
```

Generating fake data :
```bash
$ docker-compose run --rm app php artisan db:seed --class=ClasstabaseSeeder
```

Discover package
```bash
$ docker-compose run --rm --no-deps app php artisan package:discover
```

In development environnement, rebuild the database :
```bash
$ docker-compose run --rm app php artisan migrate:fresh --seed
```

## Accessing the API

Clients can access to the REST API. API requests require authentication via token. You can create a new token in your user profile.

Then, you can use this token either as url parameter or in Authorization header :

```bash
# Url parameter
GET http://laravel-blog.app/api/v1/posts?api_token=your_private_token_here

# Authorization Header
curl --header "Authorization: Bearer your_private_token_here" http://laravel-blog.app/api/v1/posts
```

API are prefixed by ```api``` and the API version number like so ```v1```.

Do not forget to set the ```X-Requested-With``` header to ```XMLHttpRequest```. Otherwise, Laravel won't recognize the call as an AJAX request.

To list all the available routes for API :

```bash
$ docker-compose run --rm --no-deps app php artisan route:list --path=api
```

## More details

...

## Create new CRUD

* Create table or generate migration
* Run $ php artisan make:migration create_tableName_table
* Run $ php artisan infyom:scaffold $MODEL_NAME --fromTable --tableName=$TABLE_NAME
* Add columns on migrate and add $table->softDeletes();
* Edit view folder
* Add filters
* Add breadcrumbs
* Generating Factories

## Reads

- [O que é SOLID: O guia completo para você entender os 5 princípios da POO](https://medium.com/joaorobertopb/o-que-%C3%A9-solid-o-guia-completo-para-voc%C3%AA-entender-os-5-princ%C3%ADpios-da-poo-2b937b3fc530)
- [Versionamento Semântico](https://semver.org/lang/pt-BR/)
- [Composer – um pouco além do básico](https://tableless.com.br/composer-um-pouco-alem-basico/)
- [Utilizando o fluxo Git Flow](https://medium.com/trainingcenter/utilizando-o-fluxo-git-flow-e63d5e0d5e04)
- [Plugin git flow](https://github.com/nvie/gitflow)
- [Eloquent Mutators](https://github.com/artesaos/laravel-docs/blob/master/pt_BR/eloquent-mutators.md)

## Contributing

Do not hesitate to contribute to the project by adapting or adding features ! Bug reports or pull requests are welcome.