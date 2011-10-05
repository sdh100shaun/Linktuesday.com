## Linktuesday.com

This repository contains the sourcecode for the LinkTuesday.com website, a community website aimed at making it easy to track all links posted on Tuesday with the #linktuesday hashtag. 

### Installation

Installing this code is quite easy. 

* Clone the code to your local system
* Update app/config/properties.ini with your database credentials
* Ensure the app/cache and app/logs directories are created and writable
* On the commandline, run the following command:
	* app/console doctrine:schema:update --force
* Now run:
	* app/console linktuesday:fetchtweet
* Set up your webserver so that the web/ directory is your documentroot and app.php is your DirectoryIndex

Now you should have the LinkTuesday.com code up and running.

### Things to do and note

There is a lot of things to do and note. First of all, this code is quite old already and was created with an early preview release of Symfony2. You may for this reason find outdated or even deprecated code. The project is currently not even running the latest version of Symfony2. For things to do, surely, feel free to check the open issues on [Github](https://github.com/LinkTuesday/Linktuesday.com/issues), there's bound to be something there you can pick up on. Or, just (unit) test the software and report any found bugs. Any contribution is highly appreciated 