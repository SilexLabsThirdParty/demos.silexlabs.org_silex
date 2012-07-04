<?php

require_once ROOTPATH.'cgi/includes/plugin_base.php';


class fullscreen extends plugin_base
{

	public function initHooks($hookManager)
	{
		$hookManager->addHook('pre-index-head', array($this, 'preload_silexTween_pre_index_head_hook'));
	}
	
	/*
	*	Adds the silexTween as2 component to the site's preload file list.
	*/
	public function preload_silexTween_pre_index_head_hook($templateContext)
	{
		if ($templateContext->websitePreloadFileList != '') $templateContext->websitePreloadFileList .= ',';
		$templateContext->websitePreloadFileList .= "plugins/fullscreen/FullScreen.swf";
	}
}
?>