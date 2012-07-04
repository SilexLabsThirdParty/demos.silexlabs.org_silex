<?php

class org_silex_core_AccessorManager {
	public function __construct($idSite) {
		if(!php_Boot::$skip_constructor) {
		$serverConfig = new org_silex_serverApi_ServerConfig();
		$siteEditor = new org_silex_serverApi_SiteEditor();
		$this->accessors->silex->{"rootUrl"} = org_silex_serverApi_RootDir::getRootUrl();
		$config = null;
		$config->{"id_site"} = $idSite;
		$config->{"initialContentFolderPath"} = $serverConfig->getContentFolderForPublication($idSite);
		if(null == $serverConfig->getSilexClientIni()) throw new HException('null iterable');
		$»it = $serverConfig->getSilexClientIni()->keys();
		while($»it->hasNext()) {
			$parameter = $»it->next();
			$config->{$parameter} = $serverConfig->getSilexClientIni()->get($parameter);
		}
		if(null == $serverConfig->getSilexServerIni()) throw new HException('null iterable');
		$»it = $serverConfig->getSilexServerIni()->keys();
		while($»it->hasNext()) {
			$parameter = $»it->next();
			$config->{$parameter} = $serverConfig->getSilexServerIni()->get($parameter);
		}
		$websiteConfig = $siteEditor->getWebsiteConfig($idSite, null);
		if($websiteConfig !== null) {
			if(null == $websiteConfig) throw new HException('null iterable');
			$»it = $websiteConfig->keys();
			while($»it->hasNext()) {
				$parameter = $»it->next();
				$config->{$parameter} = $websiteConfig->get($parameter);
			}
		}
		$this->accessors->silex->{"config"} = $config;
		org_silex_core_AccessorManager::$_accessorSeparator = Reflect::field($this->accessors->silex->config, "accessorsSepchar");
	}}
	public $accessors;
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->»dynamics[$m]) && is_callable($this->»dynamics[$m]))
			return call_user_func_array($this->»dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call «'.$m.'»');
	}
	static $_instance;
	static $_accessorSeparator;
	static function getInstance($idSite) {
		if(org_silex_core_AccessorManager::$_instance === null) {
			org_silex_core_AccessorManager::$_instance = new org_silex_core_AccessorManager($idSite);
		}
		return org_silex_core_AccessorManager::$_instance;
	}
	static function splitTags($inputString, $leftTag, $rightTag) {
		if($rightTag === null) {
			$rightTag = "))";
		}
		if($leftTag === null) {
			$leftTag = "((";
		}
		$tmpArray = null;
		$resultArray = new _hx_array(array());
		$cleanedResultArray = new _hx_array(array());
		$tmpArray = _hx_explode($leftTag, $inputString);
		{
			$_g = 0;
			while($_g < $tmpArray->length) {
				$element = $tmpArray[$_g];
				++$_g;
				if($element !== "") {
					$rightTagPos = _hx_index_of($element, $rightTag, null);
					if($rightTagPos !== -1) {
						$resultArray->push(_hx_substr($element, 0, $rightTagPos));
						if($rightTagPos + strlen($rightTag) < strlen($element)) {
							$resultArray->push(_hx_substr($element, $rightTagPos + strlen($rightTag), null));
						}
					} else {
						$resultArray->push($element);
					}
					unset($rightTagPos);
				}
				unset($element);
			}
		}
		return $resultArray;
	}
	static function splitAndRevealTags($inputString, $accessorsList, $separator) {
		if($separator === null) {
			$separator = org_silex_core_AccessorManager::$_accessorSeparator;
		}
		$tmpArray = null;
		$resultArray = new _hx_array(array());
		$cleanedResultArray = new _hx_array(array());
		$revealedElement = null;
		$leftTagArray = new _hx_array(array());
		$leftTag = org_silex_core_AccessorManager::getTarget("silex.config.accessorsLeftTag", $accessorsList, null);
		$rightTag = org_silex_core_AccessorManager::getTarget("silex.config.accessorsRightTag", $accessorsList, null);
		if(_hx_index_of($inputString, $leftTag, null) !== -1) {
			$tmpArray = _hx_explode($leftTag, $inputString);
			{
				$_g = 0;
				while($_g < $tmpArray->length) {
					$element = $tmpArray[$_g];
					++$_g;
					if($element !== "") {
						$rightTagPos = _hx_index_of($element, $rightTag, null);
						if($rightTagPos !== -1) {
							$stringToReveal = _hx_substr($element, 0, $rightTagPos);
							$revealedElement = org_silex_core_AccessorManager::getTarget($stringToReveal, $accessorsList, $separator);
							$resultArray->push($revealedElement);
							if($rightTagPos + strlen($rightTag) < strlen($element)) {
								$resultArray->push(_hx_substr($element, $rightTagPos + strlen($rightTag), null));
							}
							unset($stringToReveal);
						} else {
							$resultArray->push($element);
						}
						unset($rightTagPos);
					}
					unset($element);
				}
			}
		} else {
			$resultArray->push($inputString);
		}
		return $resultArray;
	}
	static function getTarget($pathString, $accessorsList, $separator) {
		if($separator === null) {
			$separator = org_silex_core_AccessorManager::$_accessorSeparator;
		}
		if($pathString === null || $pathString === "" || $pathString === ".") {
			return null;
		}
		$pathArray = _hx_explode($separator, $pathString);
		$target = $accessorsList;
		{
			$_g = 0;
			while($_g < $pathArray->length) {
				$element = $pathArray[$_g];
				++$_g;
				if(Reflect::field($target, $element) !== null) {
					$target = Reflect::field($target, $element);
				} else {
					return null;
				}
				unset($element);
			}
		}
		return $target;
	}
	static function revealAccessors($toBeRevealed, $accessorsList, $separator) {
		if($toBeRevealed === null || $toBeRevealed === "") {
			return "";
		}
		if($separator === null) {
			$separator = org_silex_core_AccessorManager::$_accessorSeparator;
		}
		$toBeRevealedSplited = _hx_explode($separator, $toBeRevealed);
		$tempArray1 = new _hx_array(array());
		$tempArray2 = new _hx_array(array());
		$resultArray = new _hx_array(array());
		$hasStringInIt = false;
		$tempArray1 = org_silex_core_AccessorManager::splitTags($toBeRevealed, null, null);
		{
			$_g = 0;
			while($_g < $tempArray1->length) {
				$element1 = $tempArray1[$_g];
				++$_g;
				$tempArray2 = org_silex_core_AccessorManager::splitAndRevealTags($element1, $accessorsList, $separator);
				{
					$_g1 = 0;
					while($_g1 < $tempArray2->length) {
						$element2 = $tempArray2[$_g1];
						++$_g1;
						$resultArray->push($element2);
						$»t = (Type::typeof($element2));
						switch($»t->index) {
						case 6:
						$c = $»t->params[0];
						{
							switch(Type::getClassName($c)) {
							case "String":{
								$hasStringInIt = true;
							}break;
							default:{
							}break;
							}
						}break;
						default:{
						}break;
						}
						unset($element2);
					}
					unset($_g1);
				}
				unset($element1);
			}
		}
		$result = null;
		if($hasStringInIt === true) {
			$result = $resultArray->join("");
		} else {
			if($resultArray->length > 1) {
				$result = $resultArray;
			} else {
				$result = $resultArray[0];
			}
		}
		return $result;
	}
	function __toString() { return 'org.silex.core.AccessorManager'; }
}
