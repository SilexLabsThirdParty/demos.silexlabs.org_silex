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

class redirect extends plugin_base
{
	
	function initDefaultParamTable()
	{
		$this->paramTable = array( 
			array(
				"name" => "redirectUrl",
				"label" => "Address to redirect to",
				"description" => "This is the address where you want to redirect the user.",
				"value" => "",
				"restrict" => "",
				"type" => "string",
				"maxChars" => "255"
			),
			array(
				"name" => "redirectCondition",
				"label" => "Redirect condition",
				"description" => "Cases when to do the redirection: values can be 'mobile', 'desktop', 'html5', 'flash', 'no-html5', 'no-flash' or 'always', in order to edirect when the browser does or does not support HTML5 and Flash or always redirect.",
				"value" => "",
				"restrict" => "",
				"type" => "string",
				"maxChars" => "255"
			)
		);
	}
	
	public function initHooks($hookManager)
	{
//		$hookManager->addHook('index-body-end', array($this, 'redirect_index_body_end_hook'));
		$hookManager->addHook('index-all-js-scripts-loaded', array($this, 'redirect_index_body_end_hook'));
	}

	/**
	 * Silex hook for the script tag
	 */
	public function redirect_index_body_end_hook()
	{
		global $id_site;

		
		$i = 0;
		while( $i < count( $this->paramTable ) )
		{
			if($this->paramTable[$i]["name"] == "redirectUrl")
				$redirectUrl = $this->paramTable[$i]["value"];
			else if($this->paramTable[$i]["name"] == "redirectCondition")
				$redirectCondition = $this->paramTable[$i]["value"];
			$i++;
		}

		?>

		// **
		// Redirect plugin javascript code
		
		// test the browser capabilities
		var hasFlash = (deconcept.SWFObjectUtil.getPlayerVersion().major > 8);
		var hasHTML5 = !!(window.localStorage);
		var redirectUrl = "<?php echo $redirectUrl; ?>";
		var redirectCondition = "<?php echo $redirectCondition; ?>";
		var isMobile = false;
		if (window.screen) isMobile = (window.screen.width < 500 && window.screen.height < 500);
		
		// do the redirection if the required conditions are met
		if (redirectCondition == "always" ||
			(redirectCondition == "flash" && hasFlash) ||
			(redirectCondition == "no-flash" && !hasFlash) ||
			(redirectCondition == "html5" && hasHTML5) ||
			(redirectCondition == "no-html5" && !hasHTML5) ||
			(redirectCondition == "mobile" && isMobile) ||
			(redirectCondition == "desktop" && !isMobile)
		)
		{
			// prevent loading silex.swf
			onLoadBodyCallbackOccured= true;
		
			// redirect
			window.location = redirectUrl;
		}
		// **
		<?php
	}
	
}

?>
