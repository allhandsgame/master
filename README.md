Few things to get started:

##Requirements:##

 * PHP 5.3.10.
 * Apache2 with:
  * mod_rewrite support.
  * .htaccess support for the directory.


##Setup##

The php files are located under the www/ directory. Once you move them over, make sure to allow .htaccess files on your apache2 settings and to have the mod_rewrite enabled.

Urls:
 * Run the unitary tests: /test.php (in debug mode only.)
 * Run the project: /

Directories:

 * **controller/**: contains all the controllers (one controller per page.)
 * **lib/**: additional libraries, contains a quick homemade template system along with the SimpleTest library.
 * **model/**: all the data models.
 * **static/**: static content to deliver (images, css files.)
 * **view/**: contains all the templates.


##Setup for Vagrant users##

You're a vagrant user? That's awesome! [Vagrant users](http://vagrantup.com/) can use the Vagrantfile along with the necessary cookbooks. Once vagrant is up, you can access to your project by going to [localhost:8080](http://localhost:8080/) on your machine.


##Other things:##

 * [Demo](http://allhands.xethorn.net/)
