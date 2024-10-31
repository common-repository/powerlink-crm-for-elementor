=== PowerLink CRM for Elementor ===
Contributors: navarroido
Donate link: https://wpnavarro.com/
Tags: powerlink, crm, elementor form, contact form, Fireberry
Requires at least: 5.0.0
Tested up to: 6.0.2
Stable tag: 1.0.0
Requires PHP:  5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

New action after submission for elementor builder form widget.
addon which adds new subscriber to  Fireberry (Powerlink CRM) after form submission.

== Description ==

Get Data from Elementor to  Fireberry (Powerlink) sent via form widget, with the user’s Fireberry (Powerlink) account token.
Users must have an active  Fireberry (Powerlink) account in order to use the plugin.


fields are automatically integrated with  Fireberry (Powerlink) -  they MUST have same fields name
the basic fields for integration to 'client' object is:
accountname, emailaddress1, telephone1.

The plugin’s PRO version, Elementor to Powerlink Pro, allows you to choose any object on account (leads, clients, tasks, products...etc)

== Installation ==

1. Unzip the downloaded zip file and upload the plugin folder into the `wp-content/plugins/` directory. Alternatively, upload from Plugins >> Add New >> Upload Plugin.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Insert your TOKENID from  Fireberry (Powerlink) account
4. Add form widget to page from Elementor editor
5. Set action after sending form >> 'Powerlink'
6. Choose object to send data 
7. important: make sure to change fields name to  Fireberry (Powerlink) names

== Changelog ==


= 1.0.0 =
* Send data lead to powerlink 'client' object