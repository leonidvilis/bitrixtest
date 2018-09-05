<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$this->addExternalCss("/local/style.css");
?>
<div class="exams-list">
    <table border="2">
        <tr>
            <th>Дата</th>
            <th>Предмет</th>
            <th>Преподаватель</th>
            <th>Аудитория</th>
        </tr>
        <?foreach ($arResult["ITEMS"] as $arItem){?>
            <tr>
                <td><?echo $arItem["DATE_ACTIVE_FROM"]?></td>
                <td><?echo $arItem["NAME"]?></td>
                <td><?echo $arItem["PROPERTY_ATT_TEACHER_VALUE"]?></td>
                <td><?echo $arItem["PROPERTY_ATT_CABINET_VALUE"]?></td>
            </tr>
        <?}?>
    </table>
</div>