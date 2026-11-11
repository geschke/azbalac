# Azbalac One

Azbalac One is a classic WordPress theme based on Bootstrap 5 and Twig 3. It provides a focused set of customization options without introducing a page builder, block-theme architecture, frontend build system, or commercial feature tier.

## Why Azbalac One exists

Azbalac One began as a theme for my own website. After moving from custom blog software to WordPress, I wanted to keep working with Bootstrap, which I already knew from other web projects. Existing themes were often either too limited or offered far more features and complexity than I needed.

The aim was therefore to build a small, general-purpose theme that stays close to Bootstrap and includes the features I actually use. I am a programmer rather than a designer, so relying on Bootstrap and Bootswatch also provides a solid visual foundation. Azbalac One remains free and does not have a "Pro", enhanced, or commercial edition.

## Features

- Classic WordPress theme with Classic Editor support
- Bootstrap 5 and selectable Bootswatch designs
- Twig templates separating presentation from PHP logic
- Configurable navigation, header, footer, colors, and typography
- Bootstrap carousel with up to six slides
- Multiple featured-post layouts
- Flexible introduction area with images or icons
- Bootstrap Icons and configurable social-media buttons
- Multiple sidebar and footer layouts
- WordPress Customizer integration

## Requirements

- Modern WordPress, tested with WordPress 7.1.4
- PHP 8.1 or newer
- Composer for installing or updating the bundled Twig 3 dependency

## Installation and development

The theme deliberately does not require npm or a frontend build system. Install the PHP dependencies from the theme directory with:

```shell
composer install
```

Theme options are available through the WordPress Customizer. Changes to the theme source should preferably be implemented in a child theme because a theme update may overwrite modified files.

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for the complete version history, including the history of the earlier Tikva theme from which Azbalac One originated.

## Updating the Google Fonts catalog

The Customizer uses a static Google Fonts catalog so normal WordPress requests never require a Google API key or a live Developer API request. To refresh the catalog, create a Google Fonts Developer API key and run the maintenance script from the theme directory:

```bash
GOOGLE_FONTS_API_KEY="..." php tools/update-webfonts.php
```

With PowerShell:

```powershell
$env:GOOGLE_FONTS_API_KEY = "..."
php tools/update-webfonts.php
Remove-Item Env:GOOGLE_FONTS_API_KEY
```

The key is used only for this command and must not be committed. The script replaces `inc/customizer/webfonts.php` with a validated, compact list containing the available font families and variants.

The `tools` directory is needed only for theme maintenance and is not used by WordPress at runtime. It may be omitted from a production deployment or removed from the production server after the font catalog has been updated.

## Third-party components

- [Bootstrap](https://getbootstrap.com/), licensed under the MIT License
- [Bootswatch](https://bootswatch.com/), licensed under the MIT License
- [Twig](https://twig.symfony.com/), licensed under the BSD 3-Clause License
- [Bootstrap Icons](https://icons.getbootstrap.com/), licensed under the MIT License

## License

Azbalac One is licensed under the GNU General Public License version 3 or later. See [GNU GPL v3](https://www.gnu.org/licenses/gpl-3.0.html).
