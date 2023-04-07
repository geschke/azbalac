# Azbalac One

## A pure and basic WordPress theme, based on Bootstrap 5.0 framework

### This is an experimental release of a new generation WordPress theme. It uses the Twig template engine to separate the frontend from the backend output generation parts

Version 0.5.2

## Version history

Version 0.5.2

- Fix: Custom font setting
- Update: Bumped to current versions of vendor libraries

Version 0.5.1

- Update: Bumped to current Twig version.

Version 0.5.0

- Fix: Title font preview in customizer when title is set above header image
- Fix: Removed unnecessary get_settings() requests to azbalac_setting_social_button_color_*
- Breaking: Removed @import of Google fonts in Bootswatch CSS files due to GDPR/DSGVO issues. Usage of Azbalac typography settings is recommended.
- Update: Uses wp_enqueue_styles() instead of the static Google font URL, making it possible to use plugins to embed Google fonts locally (e.g. [Embed Google Fonts](https://wordpress.org/plugins/embed-google-fonts/))

Version 0.4.4

- Renamed to Azbalac One

Version 0.4.3

- New: Add option to hide "Nothing found" message on homepage if chosen "Your latest posts" and no posts are available, because they will be displayed as featured content

Version 0.4.2

- New: Add top-aligned navbar setting (with scrolling, so it's not fixed to top)
- New: Add option to set custom spacing between navbar and content when using fixed-top navigation, e.g. when using larger font size in navbar
- Fix: Strange behaviour of navbar menu position switching in fixed-top navbar when scrolling page content

Version 0.4.1

- New: Add Magazine-style featured content type
- Fix: Post image won't be shown on content page anymore
- Update: Content excerpt handling, don't add "Read more" button automatically
- Fix: Many fixes to due featured content posts

Version 0.4.0

- Major Update: Replace Bootstrap 4 with Bootstrap 5, Font Awesome with Bootstrap Icons
- Many fixes due to new Bootstrap version
- Fix: Slider ready for Bootstrap 5
- Update: New social media buttons, switched to Bootstrap Icons; missing icons taken from Font Awesome
- Update: New social media button styling options (template preset colors and custom colurs for icon and background, new button type)

Version 0.3.4

- Fix: Add necessary changes due to Twig 3
- Update: First version which depends on Twig 3 template engine
- Update: Twig 3 needs PHP 7.2.5, so increased the required PHP version in the style.css file

Version 0.3.3

- Fix: Upgrade to current Twig 2 version which works with PHP 8

Version 0.3.2

- Fix: Use h2 instead of h1 for main titles. This should improve SEO performance.

Version 0.3.1

- Cleanup of JavaScript code due to header image settings
- New: Add option to move title and subtitle above the header image (if it is placed on the header image) on small displays. Previously this was done automatically, now the behavior can be customized.

Version 0.3.0

- Improvement: header image loading with picture element, removed working, but crappy JavaScript code to load header image. This is a huge improvement, so it's worth to bump the version number!
- Fix: save extra small image didn't work (used wrong sanitizer)

Version 0.2.14

- Improvement: font switch added to CSS files
- Internal: license changed to GPL 3 or higher

Version 0.2.13

- Improvement: check jQuery versions before loading, because WordPress 5.6 includes the current jQuery 3.5.1 version, so there is no need to load in twice.

Version 0.2.12

- Update: jQuery and Bootstrap updated, moved to bundle version of Bootstrap which includes popper.js

Version 0.2.11

- Fix: prefetch, preload and so on

Version 0.2.10

- Add preloading for font-awesome and Google fonts

Version 0.2.9

- Fix: Setting of the background and foreground color of the sidebar works again.
- Fix: Header background color setting
- Fix: Footer background and foreground color live preview
- README fixes

Version 0.2.8

- Update: Bootstrap bumped to version 4.3.1, Bootswatch is version 4.2.1 now, but compiled with the new Bootstrap. The customized themes are also migrated and updated.

Version 0.2.7

- New feature: Add an option to display the social media buttons above the header image
- Internal: Created a Twig extension to display content of social media button section. It implements a Twig function which can be used in the templates directly.

Version 0.2.6

- Internal: Renamed customizer settings and controls variables to prevent conflicts between Azbalac and other themes
- New feature: Add an option so set a distance between title and subtitle when displayed on header image

Version 0.2.5

- New feature: Header Settings. This is awesome. You can place the title and subtitle as overlay on the header image, modify their fonts, font size, color, background color (with transparency), alignment and position. This works also on small and very small (smartphone) screens, the responsive behavior is created with small JavaScript. This is a beta release, there are too many possible cases, so it needs testing. 
- Add some edit shortcuts to improve the customizer user experience
- Fix: Show subfooter when content isn't modified

Version 0.2.4

- New feature: The font in the navigation bar is now editable with a new customizer option in the typography settings area.
- New feature: The whitespace between main menu entries in the navigation bar can be modified in five steps. This can be useful when increasing the font size of the menu entries to make the whitespace fit to the font size. 
- Fix: Live preview of navigation bar font modifications 

Version 0.2.3

- Fix: Show menu area only when menu or widget content in menu bar is present
- Fix: Hover colors of Social media icons turned more darken

Version 0.2.2

- Fix: Grid size detection and resizing of header image, now ready for Bootstrap 4 grid widths

Version 0.2.1

- Fix: Responsive behaviour in extra small screens now working, the sidebar moves below the main area
- Fix: Screen width error on small displays like smartphones (taken from Tikva theme)
- Fix: Width of extra small header image
- Fix: Sidebar element class changed to "card", because "well" was dropped in Bootstrap 4

Version 0.2

- Support of Polylang (and similar plugins). The language switcher can be displayed as widget in the header on the right side or in the navigation bar.
- New feature: Custom Logo with positioning in header. According to the theme guidelines the custom logo function has beed added. A custom logo is an image which can be uploaded from "Appearance > Header" in the admin panel. The logo can be positioned in the general theme settings to be displayed at the left or right side. Additional it can be centered, but this is usable only when not displaying title and subtitle of the site.

Version 0.1 (internal test version, not released)

- This version is derived from the release 0.5.5 of Tikva WordPress theme. It does not add any functionality, but contains some fixes.

## Version history of Tikva template

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

## Thanks to / Used third-party components

- The [Bootstrap](https://getbootstrap.com) project, which is licensed under the MIT license
- Thomas Park and the contributors of the great [Bootswatch](https://bootswatch.com/) project.
- [Font Awesome](https://fontawesome.com/v4.7.0/)

## License:

Azbalac is licensed under the General Public License (GPL) v2 or later,
see http://opensource.org/licenses/GPL-2.0
