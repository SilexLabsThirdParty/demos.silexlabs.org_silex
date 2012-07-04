<?php
/*
 This file is part of Silex: RIA developement tool - see http://silex-ria.org/

Silex is (c) 2007-2012 Silex Labs and is released under the GPL License:

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License (GPL) as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version. 

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

To read the license please visit http://www.gnu.org/copyleft/gpl.html
*/

// include './rootdir.php'; we do not call rootdir.php for the moment as it's already within the filepath. Also this includes seems to break the administration part of the plugin. If we notice some cases where ROOTPATH isn't known when we call index.php, we will have to rethink this part.
require_once ROOTPATH.'cgi/includes/plugin_base.php';

class ZincDesktop extends plugin_base
{
	/**
	* Initialises the plugin's parameters
	*/
	public function initDefaultParamTable()
	{
		// get plugin language data
		$langManager = LangManager::getInstance();
		$localisedFileUrl = $langManager->getLangFile($this->pluginName);
		global $localisedStrings;
		$localisedStrings = $langManager->getLangObject($this->pluginName, $localisedFileUrl);
		
		$this->paramTable = array( 
/*			array(
				'name' => 'us',
				'label' => $localisedStrings['SNAPSHOT_LAYOUT_DEPTH_LABEL'],
				'description' => $localisedStrings['SNAPSHOT_LAYOUT_DEPTH_DESCRIPTION'],
				'value' => '0',
				'restrict' => '',
				'type' => 'string',
				'maxChars' => '2'
			),*/
			array(
				'name' => 'SWF_LIBS_TO_LOAD',
				'label' => $localisedStrings['SWF_LIBS_TO_LOAD'],
				'description' => $localisedStrings['SWF_LIBS_TO_LOAD'],
				'value' => 'plugins/baseComponents/baseComponentsClasses.swf,plugins/oofComponents/OofClasses.swf,plugins/silexComponents/silexComponentsClasses.swf,plugins/ZincDesktop/ZincDesktop.swf',
				'restrict' => '',
				'type' => 'string',
			)

		);
	}
	
	/**
	* Overrides the initHooks method and adds a callback
	*/
	public function initHooks(HookManager $hookManager)
	{
		parent::initHooks($hookManager);
	}
}

?>