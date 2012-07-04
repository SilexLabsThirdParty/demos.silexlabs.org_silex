<?php
/*
This file is part of Silex - see http://projects.silexlabs.org/?/silex

Silex is © 2010-2011 Silex Labs and is released under the GPL License:

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License (GPL) as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version. 

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

To read the license please visit http://www.gnu.org/copyleft/gpl.html
*/

require_once ROOTPATH.'cgi/includes/PluginComponentLibraryBase.php';


class Seo extends plugin_base
{
	// Obsolete and or not to be implemented yet
	
	/**
	* override the initHooks method and add a callback
	*/ 
	/*public function initHooks(HookManager $hookManager)
	{
		parent::initHooks($hookManager);
		$hookManager->addHook('seo-creation', array($this, 'seoGeneration'));
	}*/
	
	
	/**
	 * seo-creation hook callback.
	*/
	/*public function seoGeneration($siteName)
	{
		
	}*/

	
	/**
	* Returns the html code corresponding to the administration page of the plugin.
	* In that case, we call the / hx / index.php script of the Seo plugin passing the site name in parameter
	*
	* @return string
	*/
	public function getAdminPage($siteName)
	{
		// get plugin language data
		$langManager = LangManager::getInstance();
		$localisedFileUrl = $langManager->getLangFile($this->pluginName);
		global $localisedStrings;
		$localisedStrings = $langManager->getLangObject($this->pluginName, $localisedFileUrl);
		
		// html code to be displayed in the manager plugin's page
		$result = "
			<html>
				<body>
				
					<img src='plugins/".$this->pluginName."/plugin.png' alt='".$this->pluginName."' /><br/><br/>
					
					<div id=\"Seo\">
						
						<input type=\"button\" value=\"".$localisedStrings['SEO_BUTTON_LABEL']."\" onclick=\"javascript:$.get( 'plugins/".$this->pluginName."/hx/index.php', {id_site: '".$siteName."'}, function( data ) { $('#Seo').html(data); } );\"> 
					
					</div>
					
				</body>
			</html>
			" ;
			
        return $result;
	}
	

}

?>