<?php

class Seo {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->serverRootUrl = str_replace("plugins/Seo/hx/", "", org_silex_serverApi_RootDir::getRootUrl());
		$this->_pageComponents = new _hx_array(array());
		$this->_processedLayersAndDeeplinks = new Hash();
		$getParams = php_Web::getParams();
		$idSite = $getParams->get("id_site");
		$this->_accessors = org_silex_core_AccessorManager::getInstance($idSite)->accessors;
		$startLayer = Reflect::field($this->_accessors->silex->config, "CONFIG_START_SECTION");
		$this->generateSeo($idSite, $startLayer);
	}}
	public $serverRootUrl;
	public $_main;
	public $_accessors;
	public $_processedLayersAndDeeplinks;
	public $_pageComponents;
	public $_warningMessage;
	public function generateSeo($idSite, $layerName) {
		$processedLayerDeeplinks = null;
		$processedLayersQty = 0;
		$processedDeeplinksQty = 0;
		try {
			$this->generateSeoRecursive($idSite, $layerName, $layerName);
			print_r("SEO Generation complete for site " . $idSite . ".<BR/>\x0AProcessed Layers and deeplinks:<BR/>\x0A");
			if(null == $this->_processedLayersAndDeeplinks) throw new HException('null iterable');
			$»it = $this->_processedLayersAndDeeplinks->keys();
			while($»it->hasNext()) {
				$layer = $»it->next();
				$processedLayersQty++;
				print_r("=> " . $layer . "<BR />");
				$processedLayerDeeplinks = $this->_processedLayersAndDeeplinks->get($layer);
				{
					$_g = 0;
					while($_g < $processedLayerDeeplinks->length) {
						$deeplink = $processedLayerDeeplinks[$_g];
						++$_g;
						$processedDeeplinksQty++;
						print_r("------->" . $deeplink . "<BR />");
						unset($deeplink);
					}
					unset($_g);
				}
			}
			print_r("<BR/>\x0AProcessed layer: " . $processedLayersQty . "<BR/>\x0AProcessed deeplinks: " . $processedDeeplinksQty . "<BR/>\x0A<BR/>\x0A<BR/>\x0A" . $this->_warningMessage);
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			if(is_string($msg = $_ex_)){
				print_r($msg);
			} else throw $»e;;
		}
	}
	public function generateSeoRecursive($idSite, $layerName, $deeplink) {
		$layerSeoFilePath = org_silex_serverApi_RootDir::getRootPath() . Reflect::field($this->_accessors->silex->config, "initialContentFolderPath") . $idSite . "/" . $layerName . org_silex_core_seo_Constants::$SEO_FILE_EXTENSION;
		$unresolvedLayerSeoModel = null;
		$unresolvedLayerSeoModel = org_silex_core_seo_LayerSeo::readLayerSeoModel($layerSeoFilePath, "");
		$deeplinkLayerSeoModel = $unresolvedLayerSeoModel;
		$resolvedLink = org_silex_core_seo_Utils::createComponentSeoLinkModel();
		$resolvedLayerComponents = new _hx_array(array());
		{
			$_g = 0; $_g1 = $unresolvedLayerSeoModel->components;
			while($_g < $_g1->length) {
				$component = $_g1[$_g];
				++$_g;
				$this->_pageComponents->push($component);
				unset($component);
			}
		}
		$component = null;
		{
			$_g = 0; $_g1 = $unresolvedLayerSeoModel->components;
			while($_g < $_g1->length) {
				$component1 = $_g1[$_g];
				++$_g;
				if(_hx_has_field($component1, "className") === false) {
					$this->_warningMessage .= "Warning in file " . $layerName . ".seodata.xml: no className property defined for \"" . $component1->playerName . "\"  component.</BR>\x0A";
				} else {
					if($component1->className === Seo::$SELECTOR_CLASS_NAME) {
						$selector = $component1;
						$resolvedSelector = $selector;
						if($selector->iconIsIcon === "true") {
							$connectorExists = false;
							$connector = org_silex_core_seo_Utils::createComponentSeoModel();
							{
								$_g2 = 0; $_g3 = $this->_pageComponents;
								while($_g2 < $_g3->length) {
									$comp = $_g3[$_g2];
									++$_g2;
									if($selector->specificProperties->get("connectorName") === $comp->playerName) {
										$connectorExists = true;
										$connector = $comp;
										break;
									}
									unset($comp);
								}
								unset($_g3,$_g2);
							}
							if($connectorExists) {
								if(_hx_has_field($connector, "className") !== false) {
									if($connector->className === Seo::$XML_CONNECTOR_CLASS_NAME || $connector->className === Seo::$RSS_CONNECTOR_CLASS_NAME) {
										$xmlDataPath = _hx_add($this->serverRootUrl . org_silex_core_AccessorManager::revealAccessors($connector->specificProperties->get("urlBase"), $this->_accessors, null), org_silex_core_AccessorManager::revealAccessors($selector->specificProperties->get("formName"), $this->_accessors, null));
										$xmlDataString = haxe_Http::requestUrl($xmlDataPath);
										$xmlDataXml = Xml::createElement("root");
										try {
											$xmlDataXml = org_silex_core_XmlUtils::stringIndent2Xml($xmlDataString);
										}catch(Exception $»e) {
											$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
											if(is_string($msg = $_ex_)){
												haxe_Log::trace("Error when parsing the XML file, please check its syntax", _hx_anonymous(array("fileName" => "Seo.hx", "lineNumber" => 221, "className" => "Seo", "methodName" => "generateSeoRecursive")));
											} else throw $»e;;
										}
										$xmlDataDynamic = org_silex_core_XmlUtils::Xml2Dynamic($xmlDataXml, true);
										Reflect::deleteField($xmlDataDynamic, "attributes");
										$dataProvider = $xmlDataDynamic;
										if($connector->specificProperties->exists("xmlRootNodePath")) {
											$xmlRootNodePath = $connector->specificProperties->get("xmlRootNodePath");
											$dataProvider = org_silex_core_AccessorManager::getTarget($xmlRootNodePath, $xmlDataDynamic, "/");
											unset($xmlRootNodePath);
										}
										$selectorNode = _hx_anonymous(array());
										$selectorNode->{"dataProvider"} = $dataProvider;
										$resolvedSelector1 = org_silex_core_seo_Utils::createComponentSeoModel();
										$resolvedSelector1->links = new _hx_array(array());
										$resolvedLink1 = org_silex_core_seo_Utils::createComponentSeoLinkModel();
										{
											$_g2 = 0; $_g3 = Reflect::fields($dataProvider);
											while($_g2 < $_g3->length) {
												$selectedField = $_g3[$_g2];
												++$_g2;
												$selectedItemAccessor = _hx_anonymous(array());
												$selectedItem = Reflect::field($dataProvider, $selectedField);
												{
													$_g4 = 0; $_g5 = Reflect::fields($this->_accessors);
													while($_g4 < $_g5->length) {
														$field = $_g5[$_g4];
														++$_g4;
														$selectedItemAccessor->{$field} = Reflect::field($this->_accessors, $field);
														unset($field);
													}
													unset($_g5,$_g4);
												}
												$selectorNode->{"selectedIndex"} = $selectedField;
												$selectorNode->{"selectedItem"} = $selectedItem;
												{
													$_g4 = 0; $_g5 = Reflect::fields($selectedItem);
													while($_g4 < $_g5->length) {
														$field = $_g5[$_g4];
														++$_g4;
														$selectedItemAccessor->{$field} = Reflect::field($selectedItem, $field);
														unset($field);
													}
													unset($_g5,$_g4);
												}
												$this->_accessors->{$selector->playerName} = $selectorNode;
												$resolvedLink1->title = org_silex_core_AccessorManager::revealAccessors($selector->specificProperties->get("cellFormat"), $selectedItemAccessor, "/");
												$resolvedLink1->link = org_silex_core_AccessorManager::revealAccessors($selector->specificProperties->get("iconPageName"), $selectedItemAccessor, null);
												$resolvedLink1->deeplink = org_silex_core_AccessorManager::revealAccessors($selector->specificProperties->get("iconDeeplinkName"), $selectedItemAccessor, null);
												if($resolvedLink1->deeplink === "") {
													$resolvedLink1->deeplink = org_silex_core_AccessorManager::revealAccessors($selector->specificProperties->get("iconPageName"), $selectedItemAccessor, null);
												}
												$resolvedSelector1->links->push($resolvedLink1);
												$this->generateSeoRecursive($idSite, $resolvedLink1->link, $deeplink . "/" . ltrim($resolvedLink1->deeplink));
												unset($selectedItemAccessor,$selectedItem,$selectedField);
											}
											unset($_g3,$_g2);
										}
										unset($xmlDataXml,$xmlDataString,$xmlDataPath,$xmlDataDynamic,$selectorNode,$resolvedSelector1,$resolvedLink1,$msg,$dataProvider);
									}
								}
							}
							unset($connectorExists,$connector);
						}
						$resolvedLayerComponents->push($resolvedSelector);
						unset($selector,$resolvedSelector);
					} else {
						if($component1->iconIsIcon === "true") {
							$_g2 = 0; $_g3 = $component1->links;
							while($_g2 < $_g3->length) {
								$link = $_g3[$_g2];
								++$_g2;
								$this->generateSeoRecursive($idSite, org_silex_core_AccessorManager::revealAccessors($link->link, $this->_accessors, null), $deeplink . "/" . ltrim(org_silex_core_AccessorManager::revealAccessors($link->deeplink, $this->_accessors, null)));
								unset($link);
							}
							unset($_g3,$_g2);
						}
						if(_hx_has_field($component1, "description")) {
							$component1->description = org_silex_core_AccessorManager::revealAccessors($component1->description, $this->_accessors, null);
						}
						if(_hx_has_field($component1, "htmlEquivalent")) {
							$component1->htmlEquivalent = htmlspecialchars_decode($component1->htmlEquivalent);
							$component1->htmlEquivalent = org_silex_core_AccessorManager::revealAccessors($component1->htmlEquivalent, $this->_accessors, null);
							$component1->htmlEquivalent = htmlspecialchars_decode($component1->htmlEquivalent);
						}
						if(_hx_has_field($component1, "tags")) {
							$component1->tags = org_silex_core_AccessorManager::revealAccessors($component1->tags, $this->_accessors, null);
						}
						if(null == $component1->specificProperties) throw new HException('null iterable');
						$»it = $component1->specificProperties->keys();
						while($»it->hasNext()) {
							$propertyName = $»it->next();
							if($propertyName === "text") {
								$component1->specificProperties->set($propertyName, org_silex_core_seo_Utils::html2Text($component1->htmlEquivalent));
							} else {
								$specificProp = $component1->specificProperties->get($propertyName);
								$component1->specificProperties->set($propertyName, org_silex_core_AccessorManager::revealAccessors($specificProp, $this->_accessors, null));
								unset($specificProp);
							}
						}
						$resolvedLayerComponents->push($component1);
					}
				}
				unset($component1);
			}
		}
		$deeplinkLayerSeoModel->components = $resolvedLayerComponents;
		org_silex_core_seo_LayerSeo::writeLayerSeoModel($layerSeoFilePath, $deeplink, $deeplinkLayerSeoModel, true);
		$processedLayerDeeplinks = $this->_processedLayersAndDeeplinks->get($layerName);
		if($processedLayerDeeplinks === null) {
			$processedLayerDeeplinks = new _hx_array(array());
		}
		$processedLayerDeeplinks->push($deeplink);
		$this->_processedLayersAndDeeplinks->set($layerName, $processedLayerDeeplinks);
	}
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
	static $SELECTOR_CLASS_NAME = "org.oof.dataUsers.DataSelector";
	static $RSS_CONNECTOR_CLASS_NAME = "org.oof.dataConnectors.RssConnector";
	static $XML_CONNECTOR_CLASS_NAME = "org.oof.dataConnectors.XmlConnector";
	static function main() {
		$mainInstance = new Seo();
	}
	function __toString() { return 'Seo'; }
}
{
	require_once("../../../rootdir.php");
	set_include_path(get_include_path() . PATH_SEPARATOR . ROOTPATH);
	set_include_path(get_include_path() . PATH_SEPARATOR . ROOTPATH."cgi/library");
}
