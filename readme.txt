=== 2046's Loop widgets ===
Contributors: 2046
Plugin URI: http://wordpress.org/extend/plugins/2046s-widget-loops/
Donate Link: http://2046.cz
Tags: admin, widget, loop, page, post
Requires at least: 2.8
Tested up to: 3.3.1
Stable tag: 0.13

2046's loop widgets boost you website prototyping.

== Description ==

Unlike other loop widgets "2046's loop widgets" are made with top-down logic.
Meaning, when you build the content you don't think about the programming logic behind it. The only thing you have to decide is what content you want to see and where.

These widgets covers the most routinely used Post and Page content logic. They are not supposed to fully cover all the possible layouts.
The aim of these widgets is to speed up the process of content structuring and simplicity of usage rather then offer overwhelming complex solution where you loose your self in an instant.

= The recent version has 3 widgets =

The "Post widget" that let's you display number of posts and can select what part of the content should be shown, plus you can restrict the loop by some rules.
The "Page widget" does almost the same as the "Post widget" but for Pages. Particular page logic can be for example to show child pages under the current parent page.
The "Final loop" widget is a loop which you can use in the main content area for the final content (single.php or page.php). Because the widget should basicaly replace your main loop it let's you control the comment area too. This widget is not restricted to the final post/page and can be used anywere else, though without the comment part.
All widgets allows you to display the picture belonging to the looped post/page. For that matter the Wordpress "Featured picture" is used.

"A picture better be worth a thousand words." Don't forget to check <a href="http://wordpress.org/extend/plugins/2046s-widget-loops/screenshots/">screenshots</a>.

== Installation ==

If you are installing 2046's loop widgets for the first time, follow these steps:

1. Upload the `2046s-widget-loops` folder to `/wp-content/plugins/`.
2. Else, activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions == 

= How can I use them? =

First you have to have some dynamic sidebars definied.
Some themes have them registered already, but I doubt they have them in the main content area where the loop widgets meets their intention.
(Most of the templates have them only in so called sidebars, or header.)
<em>The dynamic sidebar is a "slot" where you can put <a href="http://codex.wordpress.org/WordPress_Widgets">widgets</a> with countless features.</em> 

Log in to your admin and go to Appereance>Widgets. If you dont see the Widgets item, then your template hes no sidebars definied.
How to <a href="http://codex.wordpress.org/Function_Reference/register_sidebar">register sidebar</a>.

= What do you suggest? =

What I do is, that I register sidebars at least one per logical block in the webdesign layout (template).
Then using 2046's loop widgets you can place the content loops anywhere you like and how many you like.
You can interlace them by any other widgets. By drag & droping the widgets into the dynamic sidebar areas you can easily define the structure of the whole website.

= What about design? =

If your tempalte has the most basic css setups then you don't have to wary. Widgets will nicelly follow the css rules and will obediently follow the predefinied design rules.
And if you still needs some exceptions for this or that widget or it's element, every widget has it's own CSS "id" or "class" so you can easily bend them to your needs.

= I do not see what I have expected to see. =
Well the widgets are fairly complex though they do not look like.
Check if the restrictions are not beating each other and also chek if the content you expect there really is sortable that way you like it to be.
If none of these checks works, then let me know on the <a href="http://wordpress.org/tags/2046s-widget-loops">forum</a>, I'll do my best.

== Upgrade Notice == 

= 0.13 If you have any probems, just resave widgets. Note the recent widget is replaced by the Final loop widget.

== Screenshots == 
1. Post & Page widget
More on <a href="http://2046.cz/freestuff.html">http://2046.cz/freestuff.html</a>

== Changelog ==

= 1.13 =

 * Post widget fixes : Div "beforewidget" won't show up if the loop is empty, Disallow on ids can handle multiple ids.

 * Page widget fixes : Disallow on ids can handle multiple ids, Added Prevention for being show on Page, post ids and template types.

 * Recent widget removed
 * Added Final loop widget: Briefly. It let's you show Post or Pages anywhere. The widget let's you allow or disallow the loop to be shown on certain places. Plus, you can show or hide comments and it's form, show the author, list of categories and tags.

 * When the user is logged in the "edit link" is present after the post/page title. 
 * A small note added in to all widgets: "To see the widget behave properly, when you drop the wiget in here the widget should to be saved first."
 * In order to have a unique class which won't interfere with other classes, comment_booble class has been changed from "comment_number" to "wl2046_comment_number"

= 0.12: 2012-02-07 =

* UI fixes + added screenshot

= 0.11: 2012-02-07 =

Page widget: 

 * add show pages from the same hierarchy level
 * add restrict to pages by ID(s)
 
Post widget

 * restrict to post ID(s)
 * do not show on: Single post, home, Front Page, Archive, Tag/Term list, Taxonomy, Category list, Author's list, Search, 404 error page
 
Global facelift

= 0.1: 2012-02-05 = 

 * Initial version

= Known bugs =
When the widget is droped into the widget area it won't get its ID and so the jQuery switch for Logic part won't hide unnecessary inputs.
Once the widget is saved everything works as it supposed to.
This is not a cruicial bug, it wont brake anything it is just something I want to fix. If you know how to get the wodget ID before it is saved, let me know.

= Future plans =

* Fix the Jquery initial widget ID problem
* Add Post types select box (on the way...the WP jQuery ui causes problems still. )
* Add selection box for post, pages, instead if manual ID insertition



