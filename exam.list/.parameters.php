<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_TYPE"),
			"TYPE" => "STRING",
			"VALUE" => "shedule",
			"DEFAULT" => "shedule",
			"REFRESH" => "Y",
		),
        "IBLOCK_NUMBER_ID" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("IBLOCK_NUMBER_ID"),
            "TYPE" => "STRING",
        ),
		"CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
	),
);
?>
