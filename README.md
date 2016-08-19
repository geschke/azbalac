# Tikva

## A pure and basic WordPress theme, based on Bootstrap 3.0 framework.

Version 0.4.3


## Version history:


Version 0.4.3
- Added option to show date and author under headline of featurized posts, default off

Version 0.4.2
 - Footer implementation refactored - choose between 18 different styles or deactivate footer. 
 - Customizer settings revisited and partly restructured

Version 0.4.1
 -  Bugfix: choosing theme stylesheet works again (Sorry for tha ugly bug!)
 - Social Media Button improvements: Choose style (circle or square), size (small, medium, large) and alignment. Additional, you can switch the colors independently from the default stylesheet color. 
 - minor code improvements
 - Bootstrap bumped to version 3.3.7

Version 0.4.0
 - Snapchat added to Social Media Buttons
 - new light stylesheet (kdo_flatly.css), based on Bootswatch Flatly, but with more contrast and some colors changed
 - minor fixes due to new WordPress versions
 - added image slider on homepage, add up to six images with optionally text and description, linkable to pages or any URL
 - refactoring of using customizer features

Version 0.3.2
 - fixed sanitizing number of featured articles on homepage

Version 0.3.1
 - fixed: wrong Customizer identifier of Facebook Social Media Button option

Version 0.3
 - Options framework switched to OptionTree (There were too many banner ads in Redux. Sorry, I really appreciate the work behind Redux Framework, but the ads were annoying. And there was no option to buy the removal plugin and use it in a free theme.)
 - Integration of Social Media Buttons

Version 0.2.1 (internal release, not published)
 - added Font Awesome 
 - changed icons on pages from Glyphicons to Font Awesome


Version 0.2
 - Bootstrap Version bumped to 3.3.6
 - Bootswatch themes updated
 - minor language fixes
 - Hiding header text enabled 
 - usage of register_sidebar() fixed 


Version 0.1.9.1
 - wording changed 
 - theme url changed to its new home

Version 0.1.9
 - fixed image resize problem with extra small width when no menu is shown 
 - Bootstrap updated to version 3.3.4
 - used widgets_init when initializing sidebars due to new theme guidelines
 - remove screen_icon functions from 3rd party tgm-plugin, because it's deprecated
 - added recommended title-tag handling for WordPress 4.1

Version 0.1.8
 - header image handling improved - choose between image options, resize automatically and/or upload matching images
 - options panel enhancements and cleanup
 - header and footer color functions cleanup
 - set default header image as part of the theme, the image is made by myself and licensed under the same restrictions as the theme
 - page width bug solved, it was too high because of strange formatting of skip-link URL
 - allow setting body and widget background and text color. (But this is not recommended, better use a custom stylesheet uploaded to css/design folder.)

Version 0.1.7
 - edit link duplication fix
 - visible :focus state fix (Firefox)

Version 0.1.6
 - slate_accessibility_ready design file bumped to version 3.2.0
 - Bootswatch design files bumped to version 3.2.0
 - skip to content link visibility fixed
 - line with author and date information improved, now they are in a single link wrapper
 - problems with focus outlines fixed

Version 0.1.5
 - fixed some accessibility issues (keyboard navigation, "read more" links, screenreader-text and so on)
 - added ARIA landmarks for header and footer
 - added new default color scheme regarding to accessibility problems
 - fixed read-more buttons in featured articles teaser
 - added line with date, author and edit links
 - Bootstrap updated to version 3.2.0
 - added new default css design file based on 'slate' design file for accessibility ready settings

Version 0.1.4:
 - title function taken from Twentyfourteen
 - multilevel menus now working
 - responsiveness optimized
 - accessibility fixes

Version 0.1.3:
 - strict standards warning in admin-config.php fixed
 - category/categories misspelling fixed
 - table default style added (unfortunately it is not easily possible to add a css class to widget contents)

Version 0.1.2:
 - strict standards warning in HeaderMenuWalker fixed
 - ReduxFramework marked as recommended

Version 0.1.1:
 - Fixed wp_enqueue_script issue, load JavaScript files with helper functions instead of directly in footer
 - Minor fixes and cleanups, removed some unnecessary comments and references

Version 0.1:
- Initial release.

## Thanks to:

- Thomas Park for his excellent Bootswatch Themes


## License:

Tikva is licensed under the General Public License (GPL) v2 or later,
see http://opensource.org/licenses/GPL-2.0
