=== WP Embed Posts ===
Contributors: webbtj
Donate link: http://webb.tj/
Tags: admin, posts, embed
Requires at least: 3.5
Tested up to: 3.5
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows users to embed posts into other posts with a TinyMCE button

== Description ==

This plugin allows users to embed posts into other posts. Posts are embeded by default by printing the title
within an `<h2>` tag and by applything `the_content` filter to the post content. The plugin also adds a shortcode
of `wpembed_content` which passes two variables, the post object and the post type to allow developers to have
full control over how any given embeded post is rendered.

== Installation ==

This section describes how to install the plugin and get it working.

1. Extract wp-embed-posts.zip
2. Upload `wp-embed-posts/` to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Can I embed any post type =

Yes, by default you can embed posts and pages. Go to Embed Post Options under the Settings tab of the admin menu to enable/disable other post types.

= What happens if I embed a post within itself? =

Nothing, if you embed a post within itself, the plugin will simply render the normal content.

= Can posts with embeded posts be embeded? =

Yes, for example Post 1 can embed Post 2 which embeds Post 3 which embeds Post 4.

= What if I have a circular reference to posts? =

If one post embeds another which embeds the first post, the first post will be rendered with the contents of the second post embeded, without embeding the first post.

== Changelog ==

= 1.0 =
* Initial Release