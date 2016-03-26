## Tool Management System

Built on top of Laravel 5.2 as back-end, and Metronic Admin Theme on the front. It's a custom internal website for managing tools in a mechanical workshop. It has:

* **Easy access to online tool data from suppliers**
* **User Management**
* **Easy login / logout of users and changing of workplace**
* **Ability for users to request tools**
* **Full overview over requested and ordered tools**
* **Tool inventory**
* **Budget**
* **Notification system**
* **Searching**
* **Update to latest commits**

### Pictures

<img src="https://raw.githubusercontent.com/matapuna/uhlelo/master/public/img/sc1.jpg" width="250px">

<img src="https://raw.githubusercontent.com/matapuna/uhlelo/master/public/img/sc2.jpg" width="250px">

<img src="https://raw.githubusercontent.com/matapuna/uhlelo/master/public/img/sc3.jpg" width="250px">

<img src="https://raw.githubusercontent.com/matapuna/uhlelo/master/public/img/sc4.jpg" width="250px">

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

### 2 Git:
Pull the remote repository and merge it with Laravel:

```shell
git init
git remote add origin git@github.com:johnny-human/uhlelo.git
git pull origin master
git reset --hard origin/master
```

### 3 Update:
Update and Install Requirements:

```shell
composer update
```

### 4 Bower:
Install Bower and javascript packages:

```shell
npm install -g bower
bower install
```
The installed packages end up in /public/global/plugins

### 5. Config:
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

### 6. Database:
Migrate and seed the database:

```shell
php artisan migrate
php artisan db:seed
```
