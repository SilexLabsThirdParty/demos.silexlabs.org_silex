notes for piwik_analytics_plugin, by ZHAO QIAN 27/5/2010
----------------------------------------------------------------
This is a piwik web analytics plugin. 
Piwik is a downloadable, open source (GPL licensed) real time web analytics software program. It provides you with detailed reports on your website visitors: the search engines and keywords they used, the language they speak, your popular pages… and so much more.

To install it drop the piwik folder in the silex plugins folder, 

and add plugins/piwik/index.php
to
PLUGINS_LIST
in conf/silex_server.ini

and add piwikAddress=ADDRESS OF YOUR PIWIK FOLDER&
siteID=NUMERO DE SITE ID&
to conf.txt
in contents/NAME OF YOUR SITE


INSTALLATION INSTRUCTIONS

To install it, drop the piwik folder in the silex /plugins folder, 

You can activate it for a specific site or for the entire Silex server (for all sites hosted by your Silex server) through the Silex manager. Otherwise, you can do the same manually :

 - To activate this plugin manually for specific site, add it to the PLUGINS_LIST parameter of your site in contents/[your_site]/conf.txt. Each plugin listed in this parameter is separated by the character @

   ex : PLUGINS_LIST=wysiwyg@search@piwik&

   To configure this plugin, also set the below parameters:  
   
    piwikAddress=ADDRESS OF YOUR PIWIK FOLDER&
    siteID=NUMERO DE SITE ID&

 - To activate it manually at the Silex server level : edit the /conf/plugins_server.php file and add it to the $conf['PLUGINS_LIST'] parameter
 
   ex : $conf['PLUGINS_LIST'] = 'wysiwyg@snapshot@piwik';
   
   To configure it, set the below parameter:  
   
	$conf['piwikAddress'] = 'ADDRESS OF YOUR PIWIK FOLDER';
	$conf['siteID'] = 'NUMERO DE SITE ID';


It is made up of :
- index.php : contains the php and js necessary to load the plugin. It waits for the hook open_silex_page_piwik to be called.

