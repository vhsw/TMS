# Tool Management System

## Instation

Install docker and docker compose

```shell
docker-compose up --build -d
docker-compose restart server
docker-compose exec server php artisan migrate
docker-compose exec server php artisan db:seed
```

Now open <http://localhost:8080/>

## Desctiption

Custom made internal web application for tool control, procurement, inventory tracking and knowledge management. The goal is to maintain a more effective production or work flow in CNC machine shops. There is information available instantly for inventories and their locations, and for every purchase orders. It automatically send budget and purchase information, inventory and history reports  to economy manager. It also handles knowledge related to work processes, machines, industry and manufacturing standards. The underlying system is PHP7, Laravel 5.2, MySQL on a Windows Apache server.

* **Fuzzy Searching**
* **User Management**
* **Notification system**
* **Budget and reporting**
* **Fetching latest commits**
* **Inventory location management**
* **Instant barcode scanning search**
* **Ability for users to request inventory**
* **Full overview over requested and ordered inventory**
* **Instant login, changing of user and work place/resource**
* **Fetches and stores inventory information from suppliers**

### Pictures

<img src="https://raw.githubusercontent.com/matapuna/uhlelo/master/public/img/sc1.jpg" width="250px"> <img src="https://raw.githubusercontent.com/matapuna/uhlelo/master/public/img/sc2.jpg" width="250px">

<img src="https://raw.githubusercontent.com/matapuna/uhlelo/master/public/img/sc3.jpg" width="250px"> <img src="https://raw.githubusercontent.com/matapuna/uhlelo/master/public/img/sc4.jpg" width="250px">

### Requirement

* WAMP-stack
* Composer
* Git
* Node, NPM

### Installation

### 1 Laravel

Open Command Prompt in your htdocs folder and install Laravel 5.2 with composer:

```shell
composer create-project laravel/laravel [name of your project] "5.2.*"
```

CD into the newly created laravel project folder.

### 2 Git

Pull the remote repository and merge it with Laravel:

```shell
git init
git remote add origin git@github.com:johnny-human/uhlelo.git
git pull origin master
git reset --hard origin/master
```

### 3 Update

Update and Install Requirements:

```shell
composer update
```

### 4 Bower

Install Bower and javascript packages:

```shell
npm install -g bower
bower install
```

The installed packages end up in /public/global/plugins

### 5. Config

Add this to your Config/App.php in their respective places:

```php
Collective\Html\HtmlServiceProvider::class,
Cucxabeng\HtmlDom\HtmlDomServiceProvider::class,
TomLingham\Searchy\SearchyServiceProvider::class,
Spatie\Backup\BackupServiceProvider::class,

'Form'      => Collective\Html\FormFacade::class,
'Html'      => Collective\Html\HtmlFacade::class,
'HtmlDom'   => Cucxabeng\HtmlDom\HtmlDom::class,
'HtmlDomNode'   => Cucxabeng\HtmlDom\HtmlDomNode::class,
'Searchy'   => TomLingham\Searchy\Facades\Searchy::class,
```

Edit your .env files database configuration.

### 6. Database

Migrate and seed the database:

```shell
php artisan migrate
php artisan db:seed
```

### 7. Bugfix

When you have run composer update:
Open

```shell
vendor/cucxabeng/simple-html-dom/src/cucxabeng/simple-html-dom/HtmlDom.php
```

Add

```php
use HtmlDomNode;
```
