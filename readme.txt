=== Plugin Name ===
Contributors: hatesspam
Tags: credit, credits, image credit, licence, license, licenses, licences, caption, captions
Requires at least: 3.3
Tested up to: 4.3
Stable tag: 0.1.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A template for the Text editor that allows you to copy and paste authorship information about images into your posts.

== Description ==

This plug-in will let you add image credits to posts and pages. It does this by adding a button to your Text editor called 'credit'. Pressing the button conjures up a form that will let you fill out fields about the image, such as the name of the creator, and the URL of the license under which you are using the image. 

Press submit, and the plug-in will paste a nicely formatted string to the end of your editor. 

I am currently a happy user of my own plugin, and foresee no major changes in the future. Please let me know if there is any feature you could use.

Note that currently only the text editor is supported.

= Requirements =
* Javascript.
* WordPress editor tab "Text".

= Examples =

* _Photo_ by John Smith.
* _Photo of a fire truck_ by John Smith, _some rights reserved_.

= Rationale =

My goal in writing this plugin was mainly to help me avoid typos. 

== Installation ==

1. Upload the folder containing the plugin to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Screenshots ==
1. The form.

== Frequently Asked Questions ==

= Why doesn't it work? =

There could be a couple of reasons: 

1. You're using the Visual editor. At the moment only the Text editor is supported.
2. You have Javascript disabled or another Javascript program is interfering.

If the reason it doesn't work isn't in this list, please file a support request on the plugin's homepage. Please describe what you have tried (step for step) and where it goes wrong. 

== Changelog ==

= 0.1.5 = 
* Fixed: display the pop-up over WordPress' media buttons bar (it's like an arms race). 
* Changed: moved all of the changelog to the readme.txt. 
* Changed: moved todos out of the plugin.
* Changed: minor textual changes in plugin and readme.txt.
* Changed: some code clean-ups (I hope).

= 0.1.4.1 = 
* Fixed typos in the readme.

= 0.1.4 =
* Fixed: media buttons rendered over the pop-up.
* Changed: removed nonsense text to keep pop-up smaller.

= 0.1.3 = 
* First public version. Cleaned things up a bit, added a readme.txt.

= 0.1.2 =
* WordPress renamed a couple of action hooks we were using, and uses a Tags object now for the Quicktags.

= 0.1.1 =
Added a couple of WordPress styles to give it a more unified look.

= 0.1 =
* Initial version.
