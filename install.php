<?php
// Подключаем модуль инфоблока
CModule::IncludeModule("iblock");


//*******************************//
// Массивы
//*******************************//

//________________________________
// Массив для типа инфоблока
$arFieldsIBType = array(
    'ID' => 'shedule',
    'SECTIONS' => 'Y',
    'IN_RSS' => 'N',
    'SORT' => 100,
    'LANG' => array(
        'en' => array(
            'NAME' => 'Shedule',
            'SECTION_NAME' => 'Institute',
            'ELEMENT_NAME' => 'Subject'
        ),
        'ru' => array(
            'NAME' => 'Расписание',
            'SECTION_NAME' => 'Институт',
            'ELEMENT_NAME' => 'Предмет'
        )
    )
);

//________________________________
// Массив для инфоблока
$arFieldsIB = array(
    "ACTIVE" => "Y",
    "NAME" => "Расписание экзаменов",
    "CODE" => "examines",
    "IBLOCK_TYPE_ID" => "",
    "SITE_ID" => "",
    "SORT" => "5",
    "GROUP_ID" => array("2" => "R"), // Права доступа для всех пользователей = чтение
    "FIELDS" => array(
        // Символьный код элементов
        "CODE" => array(
            "IS_REQUIRED" => "Y", // Обязательное
            "DEFAULT_VALUE" => array(
                "UNIQUE" => "Y", // Проверять на уникальность
                "TRANSLITERATION" => "Y", // Транслитерировать
                "TRANS_LEN" => "30", // Максмальная длина транслитерации
                "TRANS_CASE" => "L", // Приводить к нижнему регистру
                "TRANS_SPACE" => "-", // Символы для замены
                "TRANS_OTHER" => "-",
                "TRANS_EAT" => "Y",
                "USE_GOOGLE" => "N",
            ),
        ),
        // Символьный код разделов
        "SECTION_CODE" => array(
            "IS_REQUIRED" => "Y",
            "DEFAULT_VALUE" => array(
                "UNIQUE" => "Y",
                "TRANSLITERATION" => "Y",
                "TRANS_LEN" => "30",
                "TRANS_CASE" => "L",
                "TRANS_SPACE" => "-",
                "TRANS_OTHER" => "-",
                "TRANS_EAT" => "Y",
                "USE_GOOGLE" => "N",
            ),
        ),

        "VERSION" => 1, // Хранение элементов в общей таблице

        "ELEMENT_NAME" => "Экзамен",
        "ELEMENTS_NAME" => "Экзамены",
        "ELEMENT_ADD" => "Добавить экзамен",
        "ELEMENT_EDIT" => "Изменить экзамен",
        "ELEMENT_DELETE" => "Удалить экзамен",
        "SECTION_NAME" => "Категории",
        "SECTIONS_NAME" => "Категория",
        "SECTION_ADD" => "Добавить категорию",
        "SECTION_EDIT" => "Изменить категорию",
        "SECTION_DELETE" => "Удалить категорию"
    )
);

//________________________________
// Массив для свойств инфоблока
$arFieldsIBProp = array(
    'first' => array(
        "NAME" => "Аудитория",
        "ACTIVE" => "Y",
        "CODE" => "ATT_CABINET",
        "PROPERTY_TYPE" => "N", // Число
    ),
    'second' => array(
        "NAME" => "Преподаватель",
        "ACTIVE" => "Y",
        "CODE" => "ATT_TEACHER",
        "PROPERTY_TYPE" => "S", // Строка
    )
);

//________________________________
// Массив для создания элементов
$arFieldsIBElements = array(
    '0' => array(
        "ACTIVE" => "Y",
        "NAME" => "Физика",
        "CODE" => "physics",
        "IBLOCK_ID" => '',
        "ACTIVE_FROM" => '25.08.2018',
        "PROPERTY_VALUES" => array(
            "ATT_CABINET" => "5",
            "ATT_TEACHER" => "Шарапов С.А."
        )
    ),
    '1' => array(
        "ACTIVE" => "Y",
        "NAME" => "История",
        "CODE" => "history",
        "IBLOCK_ID" => '',
        "ACTIVE_FROM" => '15.08.2018',
        "PROPERTY_VALUES" => array(
            "ATT_CABINET" => "10",
            "ATT_TEACHER" => "Петров С.А."
        )
    ),
    '2' => array(
        "ACTIVE" => "Y",
        "NAME" => "Математика",
        "CODE" => "mathematics",
        "IBLOCK_ID" => '',
        "ACTIVE_FROM" => '12.08.2018',
        "PROPERTY_VALUES" => array(
            "ATT_CABINET" => "3",
            "ATT_TEACHER" => "Человеков С.А."
        )
    ),
    '3' => array(
        "ACTIVE" => "Y",
        "NAME" => "Электронника",
        "CODE" => "electronics",
        "IBLOCK_ID" => '',
        "ACTIVE_FROM" => '10.08.2018',
        "PROPERTY_VALUES" => array(
            "ATT_CABINET" => "8",
            "ATT_TEACHER" => "Иванов С.А."
        )
    ),
    '4' => array(
        "ACTIVE" => "Y",
        "NAME" => "Английский",
        "CODE" => "english",
        "IBLOCK_ID" => '',
        "ACTIVE_FROM" => '20.08.2018',
        "PROPERTY_VALUES" => array(
            "ATT_CABINET" => "1",
            "ATT_TEACHER" => "Нелюдимов С.А."
        )
    )
);


//*******************************//
// Функции
//*******************************//

/**
 * Создание типа инфоблока
 * @param $arFields
 * @return mixed
 */
function createIBlockType($arFields)
{
    global $DB;
    $blockType = $arFields['ID'];
    // проверяем наличие нужного типа инфоблока
    $dbIblockType = CIBlockType::GetList(array(), array("ID" => $blockType));
    // если его нет - создаём
    if (!$dbIblockType->Fetch()) {

        $obBlocktype = new CIBlockType;
        $DB->StartTransaction();
        $res = $obBlocktype->Add($arFields);
        if (!$res) {
            $DB->Rollback();
            echo 'Error: ' . $obBlocktype->LAST_ERROR . '<br>';
        } else
            $DB->Commit();
            echo "Создан тип инфоблока расписание<br>";
            return $blockType;
    } else
        echo "Такой тип инфоблока уже создан<br>";
}

/**
 * Функция для создания инфоблока
 * @param $iBlockType : тип инфоблока
 * @param $SiteId : ИД сайта
 * @param $arFields : Массив параметров инфоблока
 * @return int : -1 - инфоблок с таким ID уже есть, 0 - Ошибка, ID созданного блока.
 */
function createIBlock($iBlockType, $SiteId, $arFields)
{
    // Проверяем наличие блока, чтобы не дублировать
    $rsBlock = CIBlock::GetList(array(), array('CODE' => 'examines'), false);
    if ($arItem = $rsBlock->GetNext()) {
        return;
    } else {
        $ib = new CIBlock;

        $arFields['IBLOCK_TYPE_ID'] = $iBlockType;
        $arFields['SITE_ID'] = $SiteId;

        $ID = $ib->Add($arFields);
        if ($ID > 0) {
            echo $ID . "&mdash; инфоблок \"Расписание экзаменов\" успешно создан<br />";
            return $ID;
        } else {
            echo $ID . "&mdash; ошибка создания инфоблока \"Расписание экзаменов\"<br />";
        }
    }
}

/**
 * Функция создает свойства у инфоблока
 * @param $ID : идентификатор инфоблока
 * @param $arFieldsIBProp : массив параметров свйств
 */
function createIBlockProperties($ID, $arFieldsIBProp)
{
    // Определяем, есть ли у инфоблока свойства
    $dbProperties = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $ID));
    if ($dbProperties->SelectedRowsCount() <= 0) {
        $ibp = new CIBlockProperty;

        foreach ($arFieldsIBProp as $item) {
            $item['IBLOCK_ID'] = $ID;
            $propId = $ibp->Add($item); // функция возвращает ID
            if ($propId > 0) {
                echo "&mdash; Добавлено свойство " . $item["NAME"] . '<br>';
            } else
                echo "&mdash; Ошибка добавления свойства " . $item["NAME"] . '<br>';
        }
    }
}

/**
 * Создание элементов инфоблока
 * @param $ID
 * @param $arFields
 */
function createIBlockElements($ID, $arFields){
    $ibe = new CIBlockElement;
    foreach ($arFields as $item) {
        $item["IBLOCK_ID"] = $ID;
        if ($PRODUCT_ID = $ibe->Add($item))
            echo "Создан элемент с ID: " . $PRODUCT_ID . "<br>";
        else
            echo "Ошибка: " . $ibe->LAST_ERROR . "<br>";
    }
}


//*******************************//
// Создание инфоблока
//*******************************//

$blockTypeID = createIBlockType($arFieldsIBType);

if(isset($blockTypeID)){
    $ID = createIBlock($blockTypeID, 's1', $arFieldsIB);
}
if (isset($ID)) {
    createIBlockProperties($ID, $arFieldsIBProp);
    createIBlockElements($ID, $arFieldsIBElements);
}
?>