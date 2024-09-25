<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
CModule::IncludeModule('iblock');
\Bitrix\Main\Loader::IncludeModule("highloadblock");

$i = 0;
$key = array();
// множественное свойство типа список RETAIL
if(!empty($arResult["RETAIL"])){
	$retail = $arResult["RETAIL"];
  
	$url = preg_replace("(^https?://)", "", $retail);
	$www = preg_replace("(^www.)", "", $url);

	$key = array_map(function($v){
		return preg_replace('#^(([^.]*){2}).*$#', '$1', $v);
	}, $www);

	$fill = array_combine($key, $retail);
	ksort($fill, SORT_STRING);
					
	$val = array_values($fill);
	array_unshift($val, NULL);
	unset($val[0]);
}
foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProp): ++$i

if(!empty( $arProp["VALUE"])){
  // справочник highload-блока - WHERE_BUY
  if($pid == "WHERE_BUY"){
    if(!CModule::IncludeModule('highloadblock')) continue;
	$ID = 4;
	$hldata = Bitrix\Highloadblock\HighloadBlockTable::getById($ID)->fetch();
	$hlentity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
	$hlDataClass = $hldata['NAME'].'Table';
	$arFilter = Array("UF_XML_ID" => $key);
	$result = $hlDataClass::getList(array('select' => array('UF_FILE','UF_NAME'), 'order' => array('UF_XML_ID' =>'ASC'), 'filter' => $arFilter));?>
      <div class="row justify-content-start">
        <?$k = (int)$k;
          while($res = $result->fetch()){
		$k++;
		$r = isset($val) ? $val[$k] : '';
		$file = CFile::ResizeImageGet($res["UF_FILE"], array("width"=>"141","height"=>"93"), BX_RESIZE_IMAGE_PROPORTIONAL, true);
		echo '<div class="col-sm-3 align-self-center"><a href="'.$r.'" class="d-block" target="_blank" title="'.$res["UF_NAME"].'"><img src="'.$file["src"].'" class="img-fluid" alt="'.$res["UF_NAME"].'"/></a></div>';
	  	}?>  
      </div>
<?
  }
}
endforeach;
?>             
