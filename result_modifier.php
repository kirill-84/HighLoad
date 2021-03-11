<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

// выборка множественного свойства списка RETAIL
foreach($arResult["PROPERTIES"] as $p=>$arProp){
	if($p == "RETAIL"){
		$arResult["RETAIL"] = $arProp["VALUE"];
	}
}
?>
