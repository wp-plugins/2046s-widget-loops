=== 2046's Loop widget ===
Contributors: 2046
Plugin URI: http://wordpress.org/extend/plugins/2046s-widget-loops/
Donate Link: http://2046.cz/freestuff/2046s-loop-widget.html
Tags: admin, widget, loop, page, post, custom, type, taxonomy, tag, category, comments, content, drag, drop, gallery, image
Requires at least: 3.1
Tested up to: 3.4.2
Stable tag: 1.0

2046's loop widget boosts you website prototyping.

== Description ==

http://youtu.be/dU8Qll6Wqes

When you build the content with "2046's loop widget", the only thing you have to decide is what content you want to see and where. All the programming you always wanted to avoid is gone.
The widget covers the most routinely used content logic. The aim of this widget is to speed up the process of content structuring and simplicity of usage while keeping the standarts.

If you encounter any problem, please let me know on the <a href="http://wordpress.org/tags/2046s-widget-loops">forum</a>.

"A picture better be worth a thousand words." Don't forget to check <a href="http://wordpress.org/extend/plugins/2046s-widget-loops/screenshots/">screenshots</a>.

= Localization =

 * English
 * Czech

= Compatibility =

Tested with <a href="http://wordpress.org/extend/plugins/custom-content-type-manager/">CCTM</a>, <a href="More Types">More types</a>, <a href="http://wordpress.org/extend/plugins/more-taxonomies/">More taxonomies</a>, <a href="http://wpml.org/">WPML</a>.
<a href="http://wordpress.org/extend/plugins/wp-pagenavi/">WP-PageNavi</a> ready.<br />
<a href="http://twitter.github.com/">Bootstrap</a> ready.

= Future =
The furure is Easy.
<a href="http://wordpress.org/extend/plugins/easy/screenshots/">Easy</a> is a new version of 2046 loop widgets. It's much more flexible but not complete yet. Test it out and let me know what you think.
http://wordpress.org/extend/plugins/easy

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

 * When you are in the widget setting in the part [elswhere]>[selected taxonomy] then the taxonomy fields are sometimes multiplied. This happens when always you drag&drop the widget.
Don't wary this is just a Javascript skin effect. If you save the widget, or you come back next time, it will be fine. (I'm working on it).

== Upgrade Notice == 

= 1.0 = 

	Fixes for call_user_func_array() [function.call-user-func-array]... sorry for that.
	Fix for updates.. the versioning number doesn't match the requirements. From now on all the updates should show up. That's the reason why the version increased that much.

= 0.247 =

 * resave widgets (as always)

= 0.244 =

 * resave the widgets, the core changed again (sory for that)

= 0.242 =

 * The scafolding changed a bit. If you haven't use it (I mean custom class), nothing is changing for you. If you do. You have to rethink the design a bit. The reson why I changed it is that the native widget div broke the Bootsrap logic. I'm sorry for that. 

= 0.241 =
 * as of the new options for image linking, the internal values changed. If your image setup stop to work (I bet it will), just reset image settings.

= 0.2 = [22.02.2012]

Warning. The version 0.2 is totally rewritten. Though it is build on the same concept like the previous public version 0.131 all the widgets shirnked to only one widget.
When you update you have to build your widget logic from the scratch, but this time easier with lot more functionality.
The 0.2 version can be considered as a different plugin then the previous 0.131 version was.

= 0.131 =

 * some fixes

= 0.13 = 

If you have any problems, just re-save widgets. Note the recent widget is replaced by the Final loop widget.

== Screenshots ==
 
1. Screenshot of the version 0.241
More on <a href="http://2046.cz/freestuff/2046s-loop-widget.html">http://2046.cz/freestuff/2046s-loop-widget.html</a>

== Change log ==

= 2.253 = 
 * NEW - Admin menu > Settings > 2046's loop widget  - lets you switch the widget settings between normal mode and wide mode. More here http://o----o.info/2065/rearrange-resort-widget-screen-in-wordpress/

= 2.252 = 
 * Featured images are not rendred with the width and height in the img tag.... it plays much nicely if you build responsice layout ;)


= 2.251 = 
 * NEW - Special widget (admin)
 * NEW - widget notes (admin)
= 2.25 = 

 * NEW switch for pagination (on/off)
 * NEW user capabilities. You can select who can see the widget result.. based on WP roles
 * FIX post number for Page types, is shown and working from now.
 * FIX - cruicial fix for post types. From nowt recoignizes the post type correctly and applies the correct logic. (linear = post), (hierarchical = page).. or any other custom post types.

= 0.2474 =

 * fixed the "more" function for the content.. when you use the more tag and select in the widget to see the content, the content will by properly striped.

= 0.2473 =

 * the widget heading is Translation ready, meaning it is parsed by Gettext or if you have for example then it will go through : qTranslate and then Gettext

= 0.2472 =

 * Fix for empty filed for "selected 'xxxxx' IDs", it shows nothing, but it schould show all. If empty no restriction are applied in this setting.
 * Fix for last fix :), it really works now
 * added - no restriction field in the category selection, so you can inactivate category constrains

= 0.2471 =

 * small fix for  NEW - IDs in "restrict to" is 3 possibilities

= 0.247 =

 * cache-able 
 * h4 added class
 * navigation>link to category (change the arrow)
 * widget sub-title fixed (admin widget panel)
 * NEW - IDs in "restrict to" is 3 possibilities:
	1. only on given IDs
	2. only on child pages of given id
	3. for these Ids and it's children 

= 0.2461 =
 * no code changes, only the readme update plus new video showcase
 * 1/2 http://youtu.be/dU8Qll6Wqes
 * 2/2 http://youtu.be/wupAqsyLsF0

= 0.246 =

 * NEW - Gallery builder!
 * NEW - h1-h5+span settings for titles
 * NEW - added show/hide edit link
 * NEW - html settings for titles
 * NEW - ON/OFF title link
 * NEW - show/hide edit link
 * asmselect removed (the fancy taxonomy selector) until I find out how to implement it correctly

= 0.245 =

 * The image bellow the heading didn't work : FIXED
 
= 0.244 = [04.03.2012]

 * localized (English, Czech) ready for more.

= 0.243 = [03.03.2012]

 * NEW ordering and it's comparison paremetrs as well.
 * NEW filter logic for custom meta and the logic parametrs too. For one custom meta "only".
 * The javascript is handled bit better, but still it's not prefect ..see the Known bugs bellow.

= 0.242 =

 * the custom scafolding changed a bit. It doesn't add redundant native widget div. 
 * also the navigation and the comments moved out of the widget div. This change should give you lot more freedom over their position, then when it was part of the widget scafold. 
 * added hard check for all imputs, you can't write nonsense in the fields, or something that harms the result, or your layout ;)
 * ..under "selected taxonomy" is from now offset as well
 * fixed typo in "taxonomy comparison" variable

= 0.241 = [26.02.2012] 

 * when elsewhere>taxonomy was selected and no taxonomy was specified the "post number" didn't work : FIXED
 * edded Scafolding option
 * image has now selector where you can choose if the image links to: post/page, image or nolink
 * fixed edit links
 * added classes to image links. General and also extra for each link type.
 * Fixed bug for PAge types, when selected "by ID"

= 0.24 = [22.02.2012] 

 * fixed pagination
 * fixed navigation for pagination
 * simplified Javascript 
 * added the restriction for number of posts/pages in [elsewhere]>[Selected taxonomy]. If the result returns more theb the number and some kind of navigation is ON, then the result will be paged.
 
= 0.23 = [24.02.2012]

 * the multiple select box for taxonomy types is now runned by the jquery-asmselect (you'll love it if you have hundreds of tags )
 * works paged

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

When you have multiple widgets where you filter the content by the taxonomies, than when you save some of these widgets the taxonomy selector is multiplied for other widget than the one you just saved ;(
This is not a crucial bug, it wont brake anything it is just something I want to fix. If you know how, let me know.

= Future plans =

 * Drag&Drop content builder
 * multiple custom meta comparison filter 


= Thanks =

Thanks to Scribu for his WP Navi that I have "integrated" as one of the navigation settings in to the widget. And thanks to Sribu again. When I tried to find an answer for 
all the uncommon problems it was his answer somewhere in the Interweb that helps me to find the solution. Thanks to you allyou are my source of knowledge.
