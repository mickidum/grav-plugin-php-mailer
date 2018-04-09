# Php Mailer Plugin

**If your hosting provider is blocking some PHP functions, that needed for "email plugin" properly work from the core of Grav CMS you can use this plugin as a temporary solution.**

The **Php Mailer** Plugin is for [Grav CMS](http://github.com/getgrav/grav). Sending mail through php mail() function

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

**Here is simple example contact form operated with php-mailer**

<pre>
	<code>
	---
	title: 'Contact Form'
	form:
	    name: contactform
	    classes: pure-form ajax-form-sending
	    action: /form
	    template: form-messages
	    fields:
	        -
	            name: name
	            label: 'full name'
	            placeholder: 'full name'
	            autocomplete: 'on'
	            type: text
	            validate: 
	            	required: true
	        -
	            name: phone
	            label: Phone
	            placeholder: Phone
	            type: text
            	validate:
          			required: true
	        -
	            name: email
	            label: 'email'
	            placeholder: 'example@test.com'
	            type: email
	        -
	            name: message
	            label: 'Your message'
	            placeholder: 'Your message'
	            type: textarea
	    buttons:
	        submit:
	            type: submit
	            value: Send
	            classes: 'pure-button pure-button-primary button-large'
	            wrapper: p
	    process:
	        -
	            phpemail:
	                subject: '[Site Contact Form] {{ form.value.name|e }}'
	                body: '{% include ''forms/data.html.twig'' %}'
	        -
	            message: 'message sent'
	---

	# Main Form
	</code>
</pre>
