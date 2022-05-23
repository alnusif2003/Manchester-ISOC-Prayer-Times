<?php

error_reporting(0);
include('simple_html_dom.php');


function getPrayerTimes()
{

    $arrContextOptions = array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
        ),
    );

    $prayerTimes = array();
    $prayers = array();
    $prayerNames = ['fajr', 'dhuhr', 'asr', 'maghrib', 'isha'];



    $html = file_get_html('https://www.manchesterisoc.com', false, stream_context_create($arrContextOptions));

    $highlightedPrayer = $html->find('td[class=begins highlight]')[0];
    $highlightedPrayer = str_replace('<td class="begins highlight">', '<td class="begins">', $highlightedPrayer);


    foreach ($html->find('td[class=begins highlight]') as $e)
        $e->outertext = $highlightedPrayer;

    $html->save('manchesterisoc.html');
    $html = file_get_html('manchesterisoc.html', false, stream_context_create($arrContextOptions));


    foreach ($html->find('td[class=begins]') as $e)
        $prayerTimes[] = $e->innertext;




    for ($i = 0; $i <= 4; $i++) {
        $prayers[$prayerNames[$i]] = $prayerTimes[$i];
    }
    $date = getCurrentDate();
    $prayers["date"] = $date;
    $prayers = json_encode($prayers);
    $f = fopen('prayers.json', 'w');
    fwrite($f, "$prayers");
    fclose($f);
    return $prayers;
}



function getCurrentDate()
{
    date_default_timezone_set('Europe/London');
    $date = date('d-m-Y');
    return $date;
}


function main()
{

    $date = getCurrentDate();
    $file = 'prayers.json';
    if (file_exists($file)) {
        $prayersDate = json_decode(file_get_contents($file), true)['date'];
        if ($date == $prayersDate) {
            return file_get_contents($file);
        } else {
            return getPrayerTimes();
        }
    } else {
        getPrayerTimes();
        return getPrayerTimes();
    }
}
