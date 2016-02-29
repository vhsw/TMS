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

1. Open Command Prompt in your htdocs folder and install Laravel 5.2 with composer:

```shell
composer -q create-project laravel/laravel [name of your project] "5.2.*"
```

2. CD into the newly created laravel project folder.

3. Initialize Git and fetch from master:

```shell
git init
git remote add origin git@github.com:matapuna/uhlelo.git
git fetch --all
git branch master origin/master
git checkout master
git reset --hard origin/master
```

4. Update:

```shell
composer update --no-scripts
```

5. Change Database Connection properties in the .env file.

6. Install Bower and packages:

```shell
npm install -g bower
bower install
```
The installed packages end up in /public/global/plugins

7. Run migration and seed:

```shell
php artisan migrate
php artisan db:seed
```

Warning! Seeding the database is not working right now.