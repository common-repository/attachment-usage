=== Attachment Usage ===
Contributors: konstk
Donate link: https://www.paypal.me/konstkWP
Tags: attachment, media, library, attachments, gallery, images, media library, media finder, media usage, optimizing, woo, woocommerce, optimize-workflow, usage, finder, find-attachments, attachment-usage
Requires at least: 5.0
Tested up to: 5.5.1
Requires PHP: 7.0
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Find easily attachment and media files used in different locations on your website.

== Description ==

***Ever lost the overview of your attachments in the media library? This plugin helps you to identify if an attachment has been used on the website. A free and easy to use plugin saving you time working in Wordpress.***

#### Your benefits

* You have immediate information if and where attachment and media files are used.
* Work more efficient with your media library.
* Provides links to the corresponding pages/posts or widgets where the media file was found.
* Filter your attachment/media list view by usage status (found/not found).
* Saves you a lot of time by knowing exactly where your files are used.
* It´s free and easy to use.

#### Locations looked through

* Posts, pages: It searches in content and excerpt field and it checks if the attachment/image is used in a gallery within the content/excerpt section.
* Custom post types: It searches in content and excerpt field of custom post types and checks if the attachment/image is used in a gallery within the content/excerpt section.
* Featured image: It searches if the media file is used as featured image for the different post types.
* Widgets: It searches if any media or attachment file is used in the following widget elements (text, audio, video, gallery, image).
* WooCommerce Products: It searches in content and excerpt field as well as checks the product thumbnail and product gallery.
* WooCommerce Product Variation: It looks through the product variation thumbnail if the image is used.
* WooCommerce Product Category: It searches if the image is set in a product category.

#### Compatible

The plugin is compatible with a multisite setup and WooCommerce. Furthermore it supports
the lookup process for the following page builders Gutenberg, Elementor and Visual Composer.

== Installation ==

Quick and easy installation:

1. Upload the folder `attachment-usage` to your plugin directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. That´s it!

== Frequently Asked Questions ==

= What does this plugin do? =

The plugin fetches the website content and displays an info if the attachment is
used somewhere and if so where.

== Screenshots ==

1. This is the colored border added in the media grid view for found/not-found attachments.
2. Button added if syncing on page loading is deactivated.
3. Shows the information where the attachment is used in the grid view.
4. Shows the sortable column if media list view is selected.
5. Shows the information where the attachment is used in a metabox on the attachment edit page.
6. Shows the information where the attachment is used in the list view.

== Changelog ==
= 1.2 =
* Bugfix: jQuery Issue in IE (translateable strings)
* Functionaliy: Modified rating banner functionality due to a typo (wrong default value on activation)

= 1.1 =
* Functionality: Implemented custom post type support.
* Functionality: Implemented checks for galleries/playlists inserted via media library.
* Functionality: Implemented attachment usage display in media list view.
* Functionality: Implemented notification to ask for rating of plugin. 
* Modified description. 

= 1.0.0 =
* Birth of Attachment Usage: Stable Version

== Future roadmap & wishlist ==

By future updates the plugin´s functionality will be enriched. 
If you have any suggestion please hit me an <a href="mailto:konstk.wp@gmail.com">email</a> 

== Contribute == 

Want to help improve the plugin feel free to submit PRs via Bitbucket <a href="https://bitbucket.org/konstk/attachment-usage/" target="_blank">here</a>.
