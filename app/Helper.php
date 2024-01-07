<?php
//แปลง date เป็น date thai
function datethaitext($date)
{
    if ($date != null) {
        $year = date("y", strtotime($date)) + 43;
        $month = date("n", strtotime($date));
        $day = date("j", strtotime($date));
        $monthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        $monthThai = $monthCut[$month];
        return $day . ' ' . $monthThai . ' ' . $year;
    } else {
        return "-";
    }
}
//แปลง timestamp eng เป็น timestamp thai
function timestampthaitext($date)
{
    if ($date != null) {
        $year = date("y", strtotime($date)) + 43;
        $month = date("n", strtotime($date));
        $day = date("j", strtotime($date));
        $time = date("H:i", strtotime($date));
        $monthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        $monthThai = $monthCut[$month];
        return $day . ' ' . $monthThai . ' ' . $year . ' ' . $time;
    } else {
        return "-";
    }
}
//แปลง วัน/เดือน/ปี ไทย เป็น ปี/เดือน/วัน en
function dateeng($date)
{
    if ($date != null) {
        $date = str_replace('/', '-', $date);
        $date = date('Y-m-d', strtotime($date));
        $year = date("Y", strtotime($date)) - 543;
        $month = date("m", strtotime($date));
        $day = date("d", strtotime($date));
        return $year . '-' . $month . '-' . $day;
    } else {
        return;
    }
}
//แปลง วัน/เดือน/ปี ไทย เป็น ปี/เดือน/วัน th
function datethai($date)
{
    if ($date != null) {
        $year = date("Y", strtotime($date)) + 543;
        $month = date("m", strtotime($date));
        $day = date("d", strtotime($date));
        return $day . '/' . $month . '/' . $year;
    } else {
        return;
    }
}
//แปลงเลขไทยเป็นอารบิค
function arabicnum($num)
{
    return str_replace(
        array("๐", "๑", "๒", "๓", "๔", "๕", "๖", "๗", "๘", "๙"),
        array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9"),
        $num
    );
}
//ปี พ.ศ. ปัจจุบัน
function yearthai()
{
    return date("Y") + 543;
}
//Line Notify
function line($message, $LINE_TOKEN)
{
    $LINE_API = "https://notify-api.line.me/api/notify";
    $queryData = array('message' => $message);
    $queryData = http_build_query($queryData, '', '&');
    $token = "CNeFkOY33OimzI8M0b1SibVeead6aNr9YtPOkpznUYP";
    $headerOptions = array(
        'http' => array(
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                . "Authorization: Bearer " . $LINE_TOKEN . "\r\n"
                . "Content-Length: " . strlen($queryData) . "\r\n",
            'content' => $queryData
        )
    );
    $context = stream_context_create($headerOptions);
    $result = file_get_contents($LINE_API, FALSE, $context);
    $res = json_decode($result);
    return $res;
}
#เช็ค Device Mobile
function isMobile()
{
    return preg_match('/Line/i', $_SERVER["HTTP_USER_AGENT"]);
}