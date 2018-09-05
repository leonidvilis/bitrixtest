<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("T_IBLOCK_DESC_SHEDULE_LIST"),
	"DESCRIPTION" => GetMessage("T_IBLOCK_DESC_SHEDULE_DESC"),
	"ICON" => "/images/photo_view.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 40,
	"PATH" => array(
		"ID" => "content",
		"CHILD" => array(
			"ID" => "shedule",
			"NAME" => GetMessage("T_IBLOCK_DESC_SHEDULE"),
			"SORT" => 20,
		)
	),
);

?>