=== Co-Authors Plus ===
Contributors: batmoo, danielbachhuber, automattic
Tags: authors, users, multiple authors, coauthors, multi-author, publishing
Tested up to: 5.3.1
Requires at least: 4.1
Stable tag: 3.4.3

Assign multiple bylines to posts, pages, and custom post types via a search-as-you-type input box

== Description ==

Assign multiple bylines to posts, pages, and custom post types via a search-as-you-type input box. Co-authored posts appear on a co-author's archive page and in their feed. Co-authors may edit the posts they are associated with, and co-authors who are contributors may only edit posts if they have not been published (as is core behavior).

Add writers as bylines without creating WordPress user accounts. Simply [create a guest author profile](http://vip.wordpress.com/documentation/add-guest-bylines-to-your-content-with-co-authors-plus/) for the writer and assign the byline as you normally would.

On the frontend, use the [Co-Authors Plus template tags](http://vip.wordpress.com/documentation/incorporate-co-authors-plus-template-tags-into-your-theme/) to list co-authors anywhere you'd normally list the author.

This plugin is an almost complete rewrite of the [Co-Authors](https://wordpress.org/plugins/co-authors/) plugin originally developed by Weston Ruter (2007). The original plugin was inspired by the '[Multiple Authors](https://txfx.net/2005/08/16/new-plugin-multiple-authors/)' plugin by Mark Jaquith (2005).

== Frequently Asked Questions ==

= How do I add Co-Authors Plus support to my theme? =

If you've just installed Co-Authors Plus, you might notice that the bylines are being added in the backend but aren't appearing on the frontend. You'll need to [add the template tags to your theme](http://vip.wordpress.com/documentation/incorporate-co-authors-plus-template-tags-into-your-theme/) before the bylines will appear.

= What happens to posts and pages when I delete a user assigned to a post or page as a coauthor? =

When a user is deleted from WordPress, they will be removed from all posts for which they are co-authors. If you chose to reassign their posts to another user, that user will be set as the coauthor instead.

= Can I use Co-Authors Plus with WordPress multisite? =

Yep! Co-Authors Plus can be activated on a site-by-site basis, or network-activated. If you create guest authors, however, those guest authors will exist on a site-by-site basis.

= Who needs permission to do what? =

To assign co-authors to posts, a WordPress user will need the 'edit_others_posts' capability. This is typically granted to the Editor role, but can be altered with the 'coauthors_plus_edit_authors' filter.

To create new guest author profiles, a WordPress will need the 'list_users' capability. This is typically granted to the Administrator role, but can be altered with the 'coauthors_guest_author_manage_cap' filter.

= Can I easily create a list of all co-authors? =

Yep! There's a template tag called `coauthors_wp_list_authors()` that accepts many of the same arguments as `wp_list_authors()`. Look in template-tags.php for more details.

= Can I disable Guest Authors?

Yep! Guest authors can be disabled entirely through an apt filter. Having the following line load on `init` will do the trick:
`add_filter( 'coauthors_guest_authors_enabled', '__return_false' )`

== Upgrade Notice ==

= 3.1 =
Manage co-authors from quick edit, Jetpack Open Graph support, bug fixes.

= 3.0.7 =
Support for symlink installations, updated French translation, bug fixes.

= 3.0.4 =
Bug fixes and the ability to automatically add co-authors to your feeds.

= 3.0.1 =
Bug fixes and minor enhancements

== Changelog ==

= 3.4.3 =
* Added author support to CPT instructions in readme FAQ
* Added object check for user in `coauthors_set_post_author_field()`
* Fix inefficient user query in avatar url hook
* Fix operand typo in `get_guest_author_thumbnail()` for adding custom classes
* Remove hardcoded default avatar and use default option

= 3.4.2 =
* Fix incorrect user avatar being displayed from featured post image
* Add check for `filter_get_avatar_url` to ensure valid second parameter
* `add_coauthors()` accepts ID parameter now and ensures valid term slug used
* `filter_count_user_posts` checks that user ID returns valid user object
* Added post count instructions in readme FAQ for CPTs

= 3.4.1 =
* Fix an issue that may arise in bulk edit

= 3.4 =
* New filter get_coauthors for modifying coauthor data returned in get_coauthors()
* New filter coauthors_guest_authors_exported_extra_data to allow guest author to export data as regular author
* New filter get_avatar_url() to show avatar in JS selection
* New parameter in coauthors_wp_list_authors() to only query authors with posts
* Add internationalization support to title and name in author archives
* Add safelist to skip irrelevant capabilities during permission checks
* Add helper function get_guest_author_post_count()
* Add parameter for outputting HTML classes in coauthors_get_avatar() template tag
* Add --append_coauthors flag to synopsis of CLI assign-coauthors
* Adjust CLI command create-guest-authors-from-csv to import website, avatar and description
* Post type of "any" can be used in filters
* Remove unnecessary is_array() check
* Remove unnecessary action_pre_user_query()
* Use correct args in search_authors()
* Have filter_author_archive_title() run on author archives only
* Improve tests coverage
* Change posts_selection to action from filter
* Fix number of args expected for get_the_archive_title callback
* Fix spelling, update FAQ for disabling guest authors and credits in readme
* Output coauthors_links_single() template tag correctly when guest author has no website
* Number by "Mine" link shows correct listing of posts
* Linked guest authors show accurate post counts
* Can no longer add co-author more than once
* No more overwriting posts with current user in `add_coauthors()`
* Accurate post count for user when using different login
* No more double post count for users with linked accounts
* Fix SQL error
* Fix "Mine" link href for Pages
* Can delete users when guest authors functionality disabled
* Fix incompatibility issue with Yoast of missing posts in author pages
* Resolve undefined index warnings on author archives
* Resolve warnings when current user has no term assigned

= 3.3.1 ("Gutentag") =
* 5.0 Compat: Hide core author inputs when using the Block Editor to limit confusion (h/t jonathanstegall).

= 3.3.0 ("Rebecca") =
* Fix private post viewing on front-end
* Reduce amount of sleep
* Author search UX issues
* Remove associated guest user when mapped user id deleted.
* Removed double left join on posts_join_filter
* Fixed WP CLI create-terms-for-posts if no co-authors found
* Pages archive now displays coauthors and quick edit works
* Terminology updated throughout
* Replace hardcoded 'author' with $this->$coauthor_taxonomy
* Move parenthesis to fix esc_html and sprintf
* Added progress to create-guest-authors so users have an idea of how long it will take
* Deleting guest authors is less confusing
* Guest author's featured image is avatar now
* Removed extra image sizing
* Remove duplicated byline
* coauthors_wp_list_authors() has option to list only guest authors now
* remove duplicates from linked accounts on coauthors_wp_list_authors()
* Accurate Guest Author post count on linked accounts
* New README.md
* Filter author archive
* Fix coauthors_links_single()
* Added guest author hooks for create/delete
* Fixes logic for DOING_AUTOSAVE check
* user_login spaces problem when using add_coauthors
* Adding details of filter for slow performance
* Remove redundant test for 404 on Author Archive
* Guest Author Counts are more accurate
* Set $coauthors_loading
* Fix the issue where guest authors with non-ASCII characters can't be used as co-authors
* Fix the issue where incompatibility when `coauthors_auto_apply_template_tags` set to true
* Unit tests/Fix warnings for template tags
* Review and improve test coverage
* Update class-wp-cli.php
* Update .travis.yml file for PHPUnit tests
* Changes to resolve issue #332 about missing coauthor meta

= 3.2.2 =
* Fix broken author ordering in 4.7+ (props mslinnea)
* Fix no moderation e-mail bug (props RobjS)
* Cached functions in CLI commands (props jasonbahl)
* Fix missing echos (props trepmal)
* Add `coauthors_guest_author_query_args` filter (props trepmal)

= 3.2.1 (May 16, 2016) =
* Hotfix for broken Guest Author bio metabox (props JS Morisset)

= 3.2 (May 12, 2016) =
Various minor bug and security fixes

= 3.1.2 (Aug. 31, 2015) =
* Minor bug fixes and coding standards changes.
* The author's display name is now filtered through the_author in coauthors_posts_links_single()
* New Russian and Ukrainian translations, courtesy of [Jurko Chervony](http://skinik.name/).

= 3.1.1 (Mar. 20, 2014) =
* Bug fix: Co-authors selection UI should appear when creating a new post too.

= 3.1 (Mar. 17, 2014) =
* Manage co-authors from Quick Edit. Props [mpatek](https://github.com/mpatek).
* Updated Spanish translation, courtesy of [sergiomajluf](https://github.com/sergiomajluf).
* Now matches core behavior when displaying author archive on multisite: user of the blog, or previously published author on the blog.
* Breaking change: "Create Profile" link is no longer shown by default on the Manage Users screen. Instead, it can be enabled with the `coauthors_show_create_profile_user_link` filter.
* Guest authors work properly with Jetpack Open Graph tags. Props [hibernation](https://github.com/hibernation).
* Guest author profile editor now supports a few different fields. Props [alpha1](https://github.com/alpha1).
* New `coauthors_count_published_post_types` filter for specifying the post type(s) used when calculating the user's number of published posts.
* Bug fix: Ensure `post_author` is set to one of the co-authors assigned to a post.
* Bug fix: Filter author feed link for guest authors on the author page. Props [hibernation](https://github.com/hibernation).
* Packages a composer.json file for those using Composer.
* Beginnings of unit test coverage for core features. Increased minimum required WordPress version to 3.7 because WordPress.org unit testing framework doesn't work reliabilty below that.

= 3.0.7 (Jan. 27, 2014) =
* Better support for installing Co-Authors Plus as a symlinked directory. [Follow these instructions](http://kaspars.net/blog/wordpress/plugins-via-symlinks) to filter `plugins_url`.
* Links to authors' posts pages to comply to hCard microformat, which Google depends on.
* New `coauthors_emails()` template tag to list email addresses of the co-authors. Props [benlk](https://github.com/benlk).
* Bug fix: Remove extraneous space between last two co-authors output. Props [johnciacia](https://github.com/johnciacia).
* Updated French translation, courtesy of Jojaba (via email).

= 3.0.6 (Dec. 9, 2013) =
* New Swedish translation, courtesy of [alundstroem](https://github.com/alundstroem)
* Updated German translation, courtesy of [krafit](https://github.com/krafit).
* New Dutch translation, courtesy of [kardotim](https://github.com/kardotim)
* New filter for specifying the default author assigned to a post. Props [tannerm](https://github.com/tannerm)
* Bug fix: When filtering a user's published post count, use the value of their guest author profile if one is mapped.
* Added support for checkboxes in Guest Author profiles
* Fix Strict warnings from CPT's that don't define all capabilities
* New swap-coauthors CLI command for replacing one co-author with another

= 3.0.5 (Feb. 18, 2013) =
* New filter 'coauthors_search_authors_get_terms_args' allows you to increase the number of matches returned with AJAX co-author selection
* Bug fix: If there isn't an author term yet for a co-author, avoid an erronous join that caused duplicate posts to appear.

= 3.0.4 (Jan. 6, 2013) =
* Support for automatically adding co-authors to your feeds. Props [cfg](https://github.com/cfg).
* Bug fix: No Co-Authors Plus on attachments. For now.
* Bug fix: Better support for co-authors with non-standard user_nicenames. Props [STRML](https://github.com/STRML).

= 3.0.3 (Dec. 3, 2012) =
* Bug fix: The default order for the 'author' taxonomy should be 'term_order', in order for the author positions to stick. Props [lgedeon](https://github.com/lgedeon)

= 3.0.2 (Nov. 23, 2012) =
* Bug fix: Fall back to non-pretty permalinks when the author permastruct is empty, so that coauthors_posts_links() doesn't link to the homepage

= 3.0.1 (Nov. 21, 2012) =
* Add your own custom columns to the guest authors table using filters. Props [cfg](https://github.com/cfg)
* A new wp-cli subcommand for renaming co-authors and another for removing author terms mistakenly assigned to revisions
* Bug fix: Using a featured image for a guest author avatar didn't work. Now it does.
* Bug fix: Don't assign author terms to revisions to avoid unnecessary database bloat
* Bug fix: Make the coauthors_wp_list_authors() template tag work again
* Bug fix: Improve capability filtering by properly handling super admin access and situations where user_id = 0
* Minor UI enhancements for guest authors

= 3.0 (Nov. 12, 2012) =
* Create guest author profiles for bylines you'd like to assign without creating WordPress user accounts. Guest authors can have all of the same fields as normal users including display name, biography, and avatars.
* Support for non-Latin characters in usernames and guest author names
* wp-cli subcommands for creating, assigning, and reassigning co-authors
* For themes using core template tags like the_author() or the_author_posts_link(), you enable Co-Authors Plus support with a simple filter
* New author terms are now prefixed with 'cap-' to avoid collisions with global scope
* Bug fix: Apply query filters to only post_types registered with the taxonomy. Props [Tom Ransom](https://github.com/1bigidea)
* Filter coauthors_posts_link_single() with 'coauthors_posts_link'. Also adds rel="author". Props [Amit Sannad](https://github.com/asannad) and [Gabriel Koen](https://github.com/mintindeed)
* Filter for the context and priorities of the Co-Authors meta boxes. Props [Tom???? Kapler](https://github.com/tkapler)
* Renamed the post meta box for selecting authors so it applies to many post types. Props [John Blackbourn](https://github.com/johnbillion)

= 2.6.4 (May 7, 2012) =
* Bug fix: Properly filter the user query so users can AJAX search against the display name field again
* If https is used for the admin, also use the secure Gravatar URL. Props [rmcfrazier](https://github.com/rmcfrazier)

= 2.6.3 (Apr. 30, 2012) =
* AJAX user search is back to searching against user login, display name, email address and user ID. The method introduced in v2.6.2 didn't scale well
* French translation courtesy of Sylvain B??rub??
* Spanish translation courtesy of Alejandro Arcos
* Bug fix: Resolved incorrect caps check against user editing an already published post. [See forum thread](http://wordpress.org/support/topic/multiple-authors-cant-edit-pages?replies=17#post-2741243)

= 2.6.2 (Mar. 6, 2012) =
* AJAX user search matches against first name, last name, and nickname fields too, in addition to display name, user login, and email address
* Comment moderation and approved notifications are properly sent to all co-authors with the correct caps
* Filter required capability for user to be returned in an AJAX search with 'coauthors_edit_author_cap'
* Filter out administrators and other non-authors from AJAX search with 'coauthors_edit_ignored_authors'
* Automatically adds co-authors to Edit Flow's story budget and calendar views
* Bug fix: Don't set post_author value to current user when quick editing a post. This doesn't appear in the UI anywhere, but adds the post to the current user's list of posts
* Bug fix: Properly cc other co-authors on new comment email notifications
* Bug fix: If a user has already been added as an author to a post, don't show them in the AJAX search again
* Bug fix: Allow output constants to be defined in a theme's functions.php file and include filters you can use instead

= 2.6.1 (Dec. 30, 2011) =
* Fix mangled usernames because of sanitize_key http://wordpress.org/support/topic/plugin-co-authors-plus-26-not-working-with-wp-33

= 2.6 (Dec. 22, 2011) =
* Sortable authors: Drag and drop the order of the authors as you'd like them to appear ([props kingkool68](http://profiles.wordpress.org/users/kingkool68/))
* Search for authors by display name (instead of nicename which was essentially the same as user_login)
* Option to remove the first author when there are two or more so it's less confusing
* Bumped requirements to WordPress 3.1
* Bug fix: Update the published post count for each user more reliably

= 2.5.3 (Aug. 14, 2011) =
* Bug fix: Removed extra comma when only two authors were listed. If you used the COAUTHORS_DEFAULT_BETWEEN_LAST constant, double-check what you have

= 2.5.2 (Apr. 23, 2011) =
* Bug: Couldn't query terms and authors at the same time (props nbaxley)
* Bug: Authors with empty fields (e.g. first name) were displaying blank in some cases
* Bug: authors with spaces in usernames not getting saved (props MLmsw, Ruben S. and others!)
* Bug: revisions getting wrong user attached (props cliquenoir!)

= 2.5.1 (Mar. 26, 2011) =
* Fix with author post count (throwing errors)

= 2.5 (Mar. 26, 2011) =
* Custom Post Type Support
* Compatibility with WP 3.0 and 3.1
* Gravatars
* Lots and lots and lots of bug fixes
* Thanks to everyone who submitted bugs, fixes, and suggestions! And for your patience!

= 2.1.1 (Oct. 16, 2009) =
* Fix for coauthors not being added if their username is different from display name
* Fixes to readme.txt (fixes for textual and punctuation errors, language clarification, minor formatting changes) courtesy of [Waldo Jaquith](http://www.vqronline.org)

= 2.1 (Oct. 11, 2009) =
* Fixed issues related to localization. Thanks to Jan Zombik <zombik@students.uni-mainz.de> for the fixes.
* Added set_time_limit to update function to get around timeout issues when upgrading plugin

= 2.0 (Oct. 11, 2009) =
* Plugin mostly rewritten to make use of taxonomy instead of post_meta
* Can now see all authors of a post under the author column from Edit Posts page
* All authors of a post are now notified on a new comment
* Various javascript enhancements
* New option to allow subscribers to be added as authors
* All Authors can edit they posts of which they are coauthors
* FIX: Issues with wp_coauthors_list function
* FIX: Issues with coauthored posts not showing up on author archives

= 1.2.0 (Jun. 16, 2012) =
* FIX: Added compatibility for WordPress 2.8
* FIX: Added new template tags (get_the_coauthor_meta & the_coauthor_meta) to fix issues related to displaying author info on author archive pages. See [Other Notes](http://wordpress.org/extend/plugins/co-authors-plus/other_notes/) for details.
* FIX: Plugin should now work for plugins not using the 'wp_' DB prefix
* FIX: Coauthors should no longer be alphabetically reordered when the post is updated
* FIX: Plugin now used WordPress native AJAX calls to tighten security
* DOCS: Added details about the new template tags

= 1.1.5 (Apr. 26, 2009) =
* FIX: Not searching Updated SQL query for autosuggest to search through first name, last name, and nickname
* FIX: When editing an author, and clicking on a suggested author, the original author was not be removed
* DOCS: Added code comments to javascript; more still to be added
* DOCS: Updated readme information

= 1.1.4 (Apr. 25, 2009) =
* Disabled "New Author" output in suggest box, for now
* Hopefully fixed SVN issue (if you're having trouble with the plugin, please delete the plugin and reinstall)

= 1.1.3 (Apr. 23, 2009) =
* Add blur event to disable input box
* Limit only one edit at a time.
* Checked basic cross-browser compatibility (Firefox 3 OS X, Safari 3 OS X, IE7 Vista).
* Add suggest javascript plugin to Edit Page.

= 1.1.2 (Apr. 19, 2009) =
* Disabled form submit when enter pressed.

= 1.1.1 (Apr. 15, 2009) =
* Changed SQL query to return only contributor-level and above users.

= 1.1.0 (Apr. 14, 2009) =
* Initial beta release.

== Installation ==

1. IMPORTANT: Please disable the original Co-Authors plugin (if you are using it) before installing Co-Authors Plus
1. Extract the coauthors-plus.zip file and upload its contents to the `/wp-content/plugins/` directory. Alternately, you can install directly from the Plugin directory within your WordPress Install.
1. Activate the plugin through the "Plugins" menu in WordPress.
1. Place the appropriate [co-authors template tags](http://vip.wordpress.com/documentation/incorporate-co-authors-plus-template-tags-into-your-theme/) in your template.
1. Add co-authors to your posts and pages.

== Screenshots ==

1. Multiple authors can be added to a Post, Page, or Custom Post Type using an auto-complete interface.
2. The order of your co-authors can be changed by drag and drop.
3. Guest authors allow you to assign bylines without creating WordPress user accounts. You can also override existing WordPress account meta by mapping a guest author to a WordPress user.
