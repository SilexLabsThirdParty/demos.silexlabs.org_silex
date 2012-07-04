notes for google_analytics_plugin
----------------------------------------------------------------
This is a google web analytics plugin. 
Google Analytics is the enterprise-class web analytics solution that gives you rich insights into your website traffic and marketing effectiveness. Powerful, flexible and easy-to-use features now let you see and analyze your traffic data in an entirely new way. With Google Analytics, you're more prepared to write better-targeted ads, strengthen your marketing initiatives and create higher converting websites.


INSTALLATION INSTRUCTIONS

To install it, drop the google_analytics folder in the silex /plugins folder, 

You can activate it for a specific site or for the entire Silex server (for all sites hosted by your Silex server) through the Silex manager. Otherwise, you can do the same manually :

 - To activate this plugin manually for specific site, add it to the PLUGINS_LIST parameter of your site in contents/[your_site]/conf.txt. Each plugin listed in this parameter is separated by the character @

   ex : PLUGINS_LIST=wysiwyg@search@google_analytics&

   To configure this plugin, also set the following parameter:  googleAnaliticsAccountNumber=Account number of GA&

 - To activate it manually at the Silex server level : edit the /conf/plugins_server.php file and add it to the $conf['PLUGINS_LIST'] parameter
 
   ex : $conf['PLUGINS_LIST'] = 'wysiwyg@snapshot@google_analytics';
   
   To configure it, set the following parameter:  $conf['googleAnaliticsAccountNumber'] = 'Account number of GA';


   
It is made up of :
- index.php : contains the php and js necessary to load the plugin. It waits for the hook open_silex_page_google_analytics to be called.

