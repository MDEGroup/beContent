Created by: Golden Works
Contact: bunescuandrei@gmail.com
Version: 1.1


Thank you for purchasing my theme. If you have any questions that are beyond the scope of this help file, please feel free to email, via my user page contact form.

This template is validated as XHTML 1.0 Strict and CSS 2.1 (with the exception of 1 css property for opacity that is valid only in css 3 specifications) and is semantically coded.
The overall structure of the home page is the follwing:

<div id="body-wrapper">
    logo + searh

    <div class="main-menu-wrapper">

	contains main menu & dropdown menu

    </div>
    
    <div id="slideshow-wrapper">
 
 	contains home slider 

    </div>


    <div id="left">
	
    	left content

    </div>

    <div id="right">
	
    	right content

    </div>


    <div id="footer">

   	contains the home footer

    </div>

</div>


The body-wrapper has 960px width and is center aligned. 

The interior pages have the same structure, the only difference being that slideshow-wrapper is not inserted anymore. Only portfolio page doesn't preserve the left and right sections.  

Customizing this template should be extremly easy: for theme switching you go to css folder and open the index css. There you will find a list with 1 active css file, for example the one that is found here: white_orange/styles.css. The rest are commented, all you have to do is to comment the active one and uncomment other css of your choice. If you want to change colors/background/background image without affecting the overall structure you do this in [theme_name]/styles.css.(where [theme_name] can be "white_orange", "white_blue", "white_green", "dark_reblue", etc). Also this css file is very well commented.

Please note, in folder [theme_name] you also find images that correspond to each different theme.

The other css files available are:
reset.css - used to reset the default browser properties.
typography - used to set the typography of the theme: here you can change distance between text rows, font family, font size and font-styles(normal, bold, italic) for each defined class.
general_styles.css - the most important css and main file, here you find all the theme structure properties.
slimbox2.css - here you find the default styles that come with jQuery slimbox v2 plugin -> these are used to styles the lightbox.
ie6 - a css file that contains adjustments required for Internet Explorer 6 to render the theme properly. Basically this theme works flawlessly in Internet Explorer 6, the only functions unavailable are the hover styles on different blocks(like home latest news or input arrows) since this browser does not support hover property on pseudoclasses, only a:hover(hover on links) works.

------------------------------------------------------------------------------------

CREDITS:

Icons used on home & services page are taken from here:
http://www.iconeden.com/icon/bright-free-stock-iconset.html


reset.css by Eric Meyer: http://meyerweb.com/eric/tools/css/reset/


Jquery credits: the following plugins have been used in this template:
(don't hesitate to visit these links in order to be able to costumize these plugins to your liking)

http://jonraasch.com/blog/a-simple-jquery-slideshow - slideshow plugin
http://www.dynamicdrive.com/style/csslibrary/item/jquery_multi_level_css_menu_2/ - secondary menu
http://jqueryui.com/download - tabular data
http://www.digitalia.be/software/slimbox2 - lightbox plugin

The png used in this template has been taken from here:
http://www.dillerdesign.com/experiment/DD_belatedPNG/



The font used for logo and headers is called Liberation Sans and can be downloaded from here:
http://www.dafont.com/Liberation-Sans.Font
Cufon plugin for text replacement can be found here:
http://cufon.shoqolate.com/generate/
You can also generate and included any other font you like.



Update: What is new in version 1.1

1) 

Now you have a fully working jquery/php contact form attached to this theme. To properly run the contact.php and check the functionalities by yourself, you need to have apache server, php and a mail server installed on your computer(or you can test it on your host). 
To configure this script, open contact.php and find the follwing line:

$emailTo = 'youremail@yoursite.com'; //Put your own email address here  

Just as the comment says, you must replace youremail@yoursite.com with a valid email address where you want to receive the information/message that was sent by the site visitor. It's simple as that, you don't need to do anything else.
 

2)
Now you have the option to make a link from main menu active depending on which page you are. All you have to do is add the class "selected" to the li tag in main menu.

Open about_us.html, go to line with the code:

<li><a href=”about_us.html”>About Us</a></li>

Replace this line by adding to <li> tag the class “selected” like this:

<li class=”selected”><a href=”about_us.html”>About Us</a></li>

For other pages, this is similar. Example: for contact page, open contact.php and replace the line:

<li><a href=”contact.php”>Contact</a></li>

with this one:

<li class=”selected”><a href=”contact.php”>Contact</a></li>

Basically you add the class “selected” to the link you want to highlight as active.

If you plan to add more styles to this selected class or simply change the color, you will find this property in styles.css situated in [theme_name] directory for each theme, starting on line 62:

.jqueryslidemenu ul .selected a {
	color:#f87b27;
}

This color apears in the default white_orange theme. Each other theme has it's own colors defined.


