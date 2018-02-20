# Azbalac

## A pure and basic WordPress theme, based on Bootstrap 4.0 framework.

### This is an experimental release of a new generation WordPress theme. It uses the Twig template engine to seperate the frontend from the backend output generation parts. 

Version 0.2


## Version history:

Version 0.2

- Support of Polylang (and similar plugins). The language switcher can be displayed as widget in the header on the right side or in the navigation bar.
- New feature: Custom Logo with positioning in header. According to the theme guidelines the custom logo function has beed added. A custom logo is an image which can be uploaded from "Appearance > Header" in the admin panel. The logo can be positioned in the general theme settings to be displayed at the left or right side. Additional it can be centered, but this is usable only when not displaying title and subtitle of the site. 

Version 0.1 (internal test version, not released)

- This version is derived from the release 0.5.5 of Tikva WordPress theme. It does not add any functionality, but contains some fixes.

## Version history of Tikva template:

Version 0.5.5

- New feature: Live preview of typography settings implemented. While choosing a font and set the font size in the Customizer the final design will be shown in the live preview. 
- Live preview of header text color added
- Fix: Text color of title header text is editable in the Customizer


Version 0.5.4 

- Fix: Added string to translation in font options


Version 0.5.3

- New feature: Choose headline and body font. There is a new section in the theme options: "Typography Settings". You can choose between a list of default fonts and all webfonts powered by Google Fonts. Additional the base size can be changed and in case of using Google Fonts the font variant is selectable.
- Fix: Subtitle is now a h2 element instead of just being a div.
- Backend: New font selecton custom control added. It contains the select box to choose a font and a slider to change the font size. Beside the list of default fonts all Google Fonts could be chosen. 
- Sort order of theme options changed, hopefully the order is cleaner as before.
- Minor fixes: end marker of nbsp entity added, whitespace between author name and edit icon added
- Fix for MSIE/Edge problem - header image fade-in removed, JavaScript code optimized


Version 0.5.2

- Fixed problem with ampersand in page titles in function which builds page array


Version 0.5.1

- Translation and language fixes


Version 0.5.0

- New feature: Added an "Lead Section". This is a special frontpage area as seen in other themes to link to pages, blog entries or external URLs and show some information (fontawesome icon or image, title, description). You can add a maximum of 12 element columns (based on the 12-column Bootstrap framework).
- New feature: Edit subfooter content. You can modify the area under the footer by customizing colors and the text content.
- More refactoring than ever before! Moved slider and social media button code into their own "section" classes, optimized HTML structure so every section is placed into its own container. This allows different background colors with 100% width. 
- Fixed color setting of social media buttons
- Fix: Don't show subtitle if title and subtitle disabled
- Added live preview of some color settings
- Created a new custom control element: Azbalac_Custom_Repeater_Control. It is used to add a flexible number of elements in the introduction section. Currently it supports the following field types: text, textarea, radiobuttons, checkboxes, image, colorpicker, selections


Version 0.4.6

 - Font Awesome updated to version 4.6.3


Version 0.4.5

 - fixed some slider issues: show slider on homepage only, show slider on static startpage, css fixes


Version 0.4.4

 - Added Welcome screen with information and changelog tabs. Thanks to Awada theme / WebHunt Infotech for its great example. 


Version 0.4.3

 - Added option to show date and author under headline of featured posts, default off


Version 0.4.2

 - Footer implementation refactored - choose between 18 different styles or deactivate footer. 
 - Customizer settings revisited and partly restructured


Version 0.4.1

 - Bugfix: choosing theme stylesheet works again (Sorry for tha ugly bug!)
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

Azbalac is licensed under the General Public License (GPL) v2 or later,
see http://opensource.org/licenses/GPL-2.0
