# Php Mailer Plugin

**This README.md file should be modified to describe the features, installation, configuration, and general usage of this plugin.**

The **Php Mailer** Plugin is for [Grav CMS](http://github.com/getgrav/grav). Sending mail through php

## Installation

Installing the Php Mailer plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install php-mailer

This will install the Php Mailer plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/php-mailer`.

### Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `php-mailer`. You can find these files on [GitHub](https://github.com/mickidum/grav-plugin-php-mailer) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/php-mailer
	
> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav) and the [Error](https://github.com/getgrav/grav-plugin-error) and [Problems](https://github.com/getgrav/grav-plugin-problems) to operate.

### Admin Plugin

If you use the admin plugin, you can install directly through the admin plugin by browsing the `Plugins` tab and clicking on the `Add` button.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/php-mailer/php-mailer.yaml` to `user/config/plugins/php-mailer.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
```

Note that if you use the admin plugin, a file with your configuration, and named php-mailer.yaml will be saved in the `user/config/plugins/` folder once the configuration is saved in the admin.

## Usage

**Describe how to use the plugin.**

## Credits

**Did you incorporate third-party code? Want to thank somebody?**

## To Do

- [ ] Future plans, if any

