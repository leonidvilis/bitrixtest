<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule("iblock"))
    return;
class examsComponent extends CBitrixComponent
{
    /**
     * Возвращаем массив элементов
     * @param $arParams
     * @return array
     */
    function setarResult($arParams){
        $arFields = [];

        $arParams['IBLOCK_NUMBER_ID'] = (int)trim($arParams['IBLOCK_NUMBER_ID']);

        $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_ATT_TEACHER", "PROPERTY_ATT_CABINET");
        $arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_NUMBER_ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(array("DATE_ACTIVE_FROM"=>"ASC"), $arFilter, false, array("nPageSize"=>50), $arSelect);

        while($ob = $res->GetNextElement())
        {
            $arFields['ITEMS'][] = $ob->GetFields();
        }
        // echo "<pre>".print_r($arFields, true)."</pre>";

        return $arFields;
    }

    /**
     *  Функция инициализации компонента.
     */
    public function executeComponent(){
        $this->arResult = array_merge($this->arResult, $this->setarResult($this->arParams));

        $this->includeComponentTemplate();
    }
}



?>
