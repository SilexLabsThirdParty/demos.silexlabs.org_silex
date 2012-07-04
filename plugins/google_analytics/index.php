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

class google_analytics extends plugin_base
{
	
	function initDefaultParamTable()
	{
		$this->paramTable = array( 
			array(
				"name" => "googleAnaliticsAccountNumber",
				"label" => "Google Analytics Account Number",
				"description" => "This is the id of your Google Analitycs Account Number. For more information, please see http://www.google.com/analytics",
				"value" => "",
				"restrict" => "",
				"type" => "string",
				"maxChars" => "40"
			)
		);
	}
	
	
	public function initHooks($hookManager)
	{
		$hookManager->addHook('index-body-end', array($this, 'open_silex_page_index_body_end_hook'));
	}
		

    public function getAdminPage($siteName)
	{
		$result = "<html><body><iframe width=\"800\" height=\"1100\" frameborder=\"0\"  vspace=\"0\"  hspace=\"0\"  marginwidth=\"0\"
					marginheight=\"0\" scrolling=no src=\"http://www.google.com/analytics\" /></body></html>" ;
        return $result;
    }
	
	/**
	 * Silex hook for the script tag
	 */
	public function open_silex_page_index_body_end_hook()
	{
		
		$i = 0;
		while( $i < count( $this->paramTable ) && $this->paramTable[$i]["name"] != "googleAnaliticsAccountNumber") $i++;
		
		$googleAccount = $this->paramTable[$i]["value"];
		
		if (isset($googleAccount) && $googleAccount != "")
		{ 
			?>
			<script type="text/javascript">	
			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', "<?php echo $googleAccount; ?>"]);
			  _gaq.push(['_trackPageview']);
			  
			
			  (function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; 
				s.parentNode.insertBefore(ga, s);
			  })();
				
				function open_silex_page_google_analytics( $event)
				{
						  
						 var pageTracker = _gat._getTracker("<?php echo $googleAccount; ?>");
						 pageTracker._trackPageview($event.hashValue);
				 }
				// check if silexNS exists since it does not in html mode
				var silexNS; 
				if (silexNS != undefined)
					silexNS.HookManager.addHook("openSilexPage",open_silex_page_google_analytics);
			
			</script>
			<?php
		}
		//}
	}
	
}

?>
