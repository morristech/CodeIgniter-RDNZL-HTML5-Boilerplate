CodeIgniter (RDNZL Mutation) + HTML5 Boilerplate
================================================

The goal of this project is to maintain a basic CodeIgniter build, with an HTML template based on HTML5 Boilerplate.

What you'll need
----------------
+ 	A webserver with PHP, and a MySQL database
+ 	Some understanding of CodeIgniter and/or MVC concepts.

Features
--------
+ 	Base HTML is the awesome HTML5 Boilerplate, including the "good" Javascript:
	- 	[Modernizer](http://www.modernizr.com/)
	- 	[jQuery](http://jquery.com)
	- 	[jQuery UI](http://jqueryui.com) (included theme: Pepper)
+ 	An demo AJAX Controller/View/Usage scenario to get people started on that path.
+ 	Access control by [Tank Auth](http://www.konyukhov.com/soft/tank_auth/) for access control (to a non-existent backend currently, sorry)
+ 	CodeIgniter's [Template Parser](http://codeigniter.com/user_guide/libraries/parser.html) (Note, this class is apparently pretty worthless. Resource-intensive. High likelihood of implementing [Phil Sturgeon's CI Dwoo Library](https://github.com/philsturgeon/codeigniter-dwoo)
+ 	Wordpress's the_content filter. It's awesome, you can't deny. (See "function wpautop()" in [wp-includes/formatting.php](http://svn.automattic.com/wordpress/tags/3.1.1/wp-includes/formatting.php))

Installation
------------
+ 	MySQL: You'll need a database (empty is best). Populate it with the contents of the SQL file (database_dump.sql) in the root folder of this package. Edit the CodeIgniter config file to match your database info.
	- 	**Configuration File Location and Default Settings:**
    -	**/application/config/config.php**
	- 	User: ci_boilerplate
    - 	Pass: ci_boilerplate
    - 	DB name: ci_boilerplate
    - 	Host: localhost
    
+ 	Apache: Just drop the whole package into the root of a VHost on your webserver. Here's my Apache VirtualHost entry:
    
    `<VirtualHost *:80>`
    <pre>
        ServerName ci_boilerplate.dev
        DocumentRoot path/to/some/directory/CodeIgniter-RDNZL-HTML5-Boilerplate
        ErrorLog path/to/some/directory/CodeIgniter-RDNZL-HTML5-Boilerplate/error_log.txt
    </pre>
    `</VirtualHost>`

The Future / Roadmap
--------------------
Since the primary goal of this project is to be a boilerplate, it's important to keep it light and simple. With that in mind, the priorities are that these aspects function perfectly:

+	Deployment, according to the instructions above. A caveman should be able to do it.
+	Latest, greatest updates to the libraries (jQ/UI/HTML5BP)
+	The HTML Starting point (views/tpl/*)
	-	Managing the core HTML
    -	Setting up a simple navigation-element pattern
    -	Adding CSS hooks based on various circumstances (is_home, is_top_level, that sort sort of thing)

These are secondary priorities:

+	Tank Auth and... well some kind of admin (the one area where CI has so much promise, but so little definition.)
+	A Demo Blog Model, or some other model. The goal is anything that can facilitate the explanation CodeIgniter's MVC pattern, in a way that it can be quickly understood, and re-worked by developers into their own apps. Basically: a model boilerplate.
+	AJAX Demo - Balance of the focus here is on leveraging your existing Controllers to handle AJAX calls, and NOT on coding JavaScript. 

And the following items could just be considered ideas that receive an occasional sidelong glance:

+	Template Parser - using PHP in templates is really not painful at all. Undecided on whether this would bleed the focus of the project.


For good times
--------------
Check out /application/controllers and /application/views. Obviously, you'll want to bone up on your CodeIgniter knowledge, but this is a great place to begin reverse-engineering, if you're that sort.
