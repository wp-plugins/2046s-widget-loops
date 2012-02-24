=== 2046's Loop widget ===
Contributors: 2046
Plugin URI: http://wordpress.org/extend/plugins/2046s-widget-loops/
Donate Link: http://2046.cz
Tags: admin, widget, loop, page, post, custom, type, taxonomy, tag, category, comments, content, drag, drop
Requires at least: 2.8
Tested up to: 3.3.1
Stable tag: 0.22

2046's loop widget boosts you website prototyping.

== Description ==

Unlike other loop widgets "2046's loop widget" is made with top-down logic.
Meaning, when you build the content you don't think about the programming logic behind it. The only thing you have to decide is what content you want to see and where.

The wdget covers the most routinely used content logic. The widget is pretty complex, but it do not fully cover all the possible layouts which not even it's aim.
The aim of this widget is to speed up the process of content structuring and simplicity of usage rather then offer overwhelming complex solution where you loose your self in an instant.

If you encounter any problem, please let me know on the <a href="http://wordpress.org/tags/2046s-widget-loops">forum</a>.

= Post types =

The widget automatically finds all the public post types your WP has. Native Post and Pages and also your custom post types.
It will load it's taxonomies. Native (category, tags), custom taxonimies, settings for comments form and more. For the page types it gives you an extra hierarchy settings.
 
= The content =

All the content settings lays on the left side of the widget. There you can select if you would like to see the post title, featured post image. You can choose if 
you would like to see full content, excerpt or without the body content and simply show or hide post meta such as comment numbers, date, author, taxonomies etc.
In the case of the I call it "final post/page" the comment form settings lets you show or hide the comment form with comments.
The navigation cover most of the native Wordpress next, prev links, plus if you have Scribu's Page Navi plugin installed then you can choose even that kind of nice navigation. 

= The logic =

The logic is on the right side of the widget.

All the post types in Wordpress are basically linear with no hierarchy, they are categorized and can be tagged. If you are skilled enough or help your self with a plugin you can
create custom post types and add some extra taxonomies. You can find them all listed in the widget and select the logic on which the widget will render the content
to the front end of your site. Like, when you want to see "x" posts from the category pets, or "x" posts from the same category as the actual main post is, or select
posts exactly by their ID and stuff like that.
On the contrary you can also restrict the widget content not to be shown certain template types, such as index, category, post, or page, search result, or hide it on certain page by it's ID. 

The Wordpress page types are hierarchical. The widget shows you all the settings as like for the posts (even taxonomies if you made any), plus particular hierarchical
logic based on which the widget will show the content.

The final content loop has no settings in this logic area. It doesn't need any, it simply shows the final content. By the final content is meant the main post/page/custom post types
 content on the (template speaking) single.php, page.php.

<em>All widgets allows you to display the picture belonging to the looped post/page/custom post type. For that matter the Wordpress "Featured picture" is used.<br />
The "Debug" mode renders the Query arguments you build by the widget to the front-end of your site, right before the loop.</em>

"A picture better be worth a thousand words." Don't forget to check <a href="http://wordpress.org/extend/plugins/2046s-widget-loops/screenshots/">screenshots</a>.

== Installation ==

If you are installing 2046's loop widgets for the first time, follow these steps:

1. Upload the `2046s-widget-loops` folder to `/wp-content/plugins/` abs activate it in the admin plugin area.
2. Else, download and activate the plugin through the 'Plugins' in the WordPress adimin area.

Widget has no extra settings. All the settings are done in the widget area as like for any other normal widget.

== Frequently Asked Questions == 

= How can I use it`? =

First you have to have some dynamic sidebars defined.
Some themes have them registered already, but I doubt they have them in the main content area where this loop widget meets it's intention.
(Most of the templates have them only in so called sidebars, or header. Widgets are commonly are used for category listing, tag cloud, Facebook features etc.)
<em>The dynamic sidebar is a "slot" where you can put <a href="http://codex.wordpress.org/WordPress_Widgets">widgets</a> with countless features.</em> 

Log in to your admin and go to Appearance>Widgets. If you don't see the Widgets item, then your template hes no sidebars defined.
How to <a href="http://codex.wordpress.org/Function_Reference/register_sidebar">register sidebar</a>.

= What do you suggest? =

What I do is, that I register sidebars at least one per logical block in the webdesign layout (template).
Then using 2046's loop widget you can place the content loops anywhere you like and how many you like.
You can interlace them by any other widgets. By drag & dropping the widgets into the dynamic sidebar areas you can easily define the structure of the whole website.

= What about design? =

If your template has the most basic CSS setups then you don't have to wary. Widgets will nicely follow the actual template CSS rules and will obediently follow the predefined
design. If you still needs some exceptions for this or that widget or it's element, every widget has it's own CSS "id" or "class" so you can easily bend them to your needs.

= I do not see what I have expected to see. =

Well the widget is fairly complex.
Check if the restrictions are not beating each other and also check if the content you expect there really is sortable the way you like it to be.
If none of these checks works, then let me know on the <a href="http://wordpress.org/tags/2046s-widget-loops">forum</a>, I'll do my best.

= Known bugs =

 * When you select something from the select box, the admin menu sometimes pops out like if you click on it as well. Don't ask me why. If I know, I would fix it. ;(
 * When you use the CCTM plugin then there you might experience strange behavior when you work with taxonomies for custom post_types. It won't filter the content right, because the CCTM uses it's own functions which actually have this side effect.

== Upgrade Notice == 

= 0.2 = [22.02.2012]

Warning. The version 0.2 is totally rewritten. Though it is build on the same concept like the previous public version 0.131 all the widgets shirnked to only one widget.
When you update you have to build your widget logic from the scratch, but this time easier with lot more functionality.
The 0.2 version can be considered as a different plugin then the previous 0.131 version was.

= 0.131 =

 * some fixes

= 0.13 = 

If you have any problems, just re-save widgets. Note the recent widget is replaced by the Final loop widget.

== Screenshots ==
 
1. Screenshot of the version 0.2
More on <a href="http://2046.cz/freestuff.html">http://2046.cz/freestuff.html</a>

== Change log ==

= 0.22 = [24.02.2012]

 * the multiple select box for taxonomy types is now runned by the jquery-asmselect (you'll love it if you have hundreds of tags )

= 0.21 = [24.02.2012]

 * removed some forgotten echo calls
 * the multiple select box has native size 5 rows from now

= 0.2 =
  * all 3 widgets where merged in to one widget
  * the file structure of the plugin changed a lot, many files were deleted
  * The old initial JavaScript problem is solved
  * the CSS and JS are not hard coded in each widget but loads independently and only once
  * The widget now finds even custom post types
  * it finds custom taxonomies and build appropriate settings for them
  * new navigation settings (Scribu's Page Navi ready)
  * and so on... 
  

= 0.131 =

 * fixed typo
 * added the page restriction

= 0.13 =

 * Post widget fixes : Div "beforewidget" won't show up if the loop is empty, Disallow on ids can handle multiple ids.

 * Page widget fixes : Disallow on ids can handle multiple ids, Added Prevention for being show on Page, post ids and template types.

 * Recent widget removed
 * Added Final loop widget: Briefly. It let's you show Post or Pages anywhere. The widget let's you allow or disallow the loop to be shown on certain places. Plus, you can show or hide comments and it's form, show the author, list of categories and tags.

 * When the user is logged in the "edit link" is present after the post/page title. 
 * A small note added in to all widgets: "To see the widget behave properly, when you drop the widget in here the widget should to be saved first."
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
 
Global face lift

= 0.1: 2012-02-05 = 

 * Initial version

= Known bugs =
When the widget is dropped into the widget area it won't get its ID and so the jQuery switch for Logic part won't hide unnecessary inputs.
Once the widget is saved everything works as it supposed to.
This is not a crucial bug, it wont brake anything it is just something I want to fix. If you know how to get the widget ID before it is saved, let me know.

= Future plans =

 * Add selection box for post, pages, taxonomies as like in the menu builder instead manual ID insertion or log category, tag list.
 * Complete localization ready for translation to other languages
 * Might be you who gives me other ideas ;)

= Thanks =

Thanks to Scribu for his WP Navi that I have "integrated" as one of the navigation settings in to the widget. And thanks to Sribu again. When I tried to find an answer for 
all the uncommon problems it was his answer somewhere in the Interweb that helps me to find the solution.
