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
require_once ROOTPATH.'cgi/includes/site_editor.php';

class demo extends plugin_base
{
	
	
	public $newId;
	public function initHooks($hook_manager)
	{
		$hook_manager->addHook('index-head', array($this,'hookHandler'));

	}
	
	function hookHandler()
	{
	    		global $id_site;
        		global $ROOTURL;

        		if (!isset($id_site))
        		{
        //			$id_site = 'wysiwyg.demo';
        			// Retrieve the site name from URL
        			if (strpos($_SERVER['REQUEST_URI'],'?/')>0)
        			{
        				$maxlen = strlen($_SERVER['SCRIPT_NAME'])-strlen('index.php')+2;
        				// pretty permalinks
        				if (substr($_SERVER['REQUEST_URI'], -1, 1) != '/'){
        					$url = substr($_SERVER['REQUEST_URI'],$maxlen);
        				}
        				else{
        					$url = substr($_SERVER['REQUEST_URI'],$maxlen,-1);
        				}
        				// if the id is of the form "mysite/mypage1/.../mypageX", reload with "mysite/#/mypage1/.../mypageX"
        				$tab_url = explode ('/',$url);
        				$id_site = array_shift($tab_url);
        			}
        			else // to do : take the default site
        				$id_site = 'silex-demo';
        		}

        		if(!file_exists(ROOTPATH.'contents/'.$id_site.'/donotredirectdemo'))
        		{
					// duplicate website
					$siteEditor = new site_editor();
					$newId = date("dmYHis");
					$this->doDuplicateWebsite(ROOTPATH.'contents/'.$id_site.'/', ROOTPATH.'contents/'.$newId.'/');
					fopen(ROOTPATH.'contents/'.$newId.'/donotredirectdemo', 'w') or die("can't open file");
					
					
					// redirect
					header('HTTP/1.1 307 Temporary Redirect'); 
					
					$paramsUrl = $newId.'/';
					// keep vars from Url
					if (isset($_GET['autologin']) && $_GET['autologin'] == '1')
						$paramsUrl .= '&autologin=1'; 
					if (isset($_GET['login_str']))
						$paramsUrl .= '&login_str='.$_GET['login_str']; 
					if (isset($_GET['pass_str']))
						$paramsUrl .= '&pass_str='.$_GET['pass_str']; 
						
						
					header('Location:'.$ROOTURL.'?/'.$paramsUrl); 
					header('Connection: close');
        		}
	}

	function doDuplicateWebsite($folder,$newFolder){
	//	if ($this->logger) $this->logger->debug("doDuplicateWebsite($folder,$newFolder)");
		mkdir($newFolder);
		// list folder and copy
		$tmpFolder = opendir($folder);
		while ($tmpFile = readdir($tmpFolder)) {
			if ($tmpFile != "." && $tmpFile != ".."){
				if (is_file($folder.$tmpFile)){
					if (!copy($folder.$tmpFile,$newFolder.$tmpFile)){
						//if ($this->logger) $this->logger->emerg("doDuplicateWebsite error while copying file "+$folder.$tmpFile." to ".$newFolder.$tmpFile);
						return FALSE;
					}
				}
			}
		}
		return TRUE;
	}
	
	
	
}

?>
