<?php
use Philo\Blade\Blade;

function assets($doc) {
  return base_url("assets/{$doc}");
}

function route($link) {
  return base_url($link);
}

function indo_currency($nominal) {
  return "Rp ".number_format($nominal, 2);
}

function indo_date($timestamp = '', $date_format = 'l, j F Y', $suffix = '')
{
    if (trim($timestamp) == '') {
        $timestamp = time();
    } elseif (!ctype_digit($timestamp)) {
        $timestamp = strtotime($timestamp);
    }
    # remove S (st,nd,rd,th) there are no such things in indonesia :p
    $date_format = preg_replace("/S/", "", $date_format);
    $pattern = array(
        '/Mon[^day]/', '/Tue[^sday]/', '/Wed[^nesday]/', '/Thu[^rsday]/',
        '/Fri[^day]/', '/Sat[^urday]/', '/Sun[^day]/', '/Monday/', '/Tuesday/',
        '/Wednesday/', '/Thursday/', '/Friday/', '/Saturday/', '/Sunday/',
        '/Jan[^uary]/', '/Feb[^ruary]/', '/Mar[^ch]/', '/Apr[^il]/', '/May/',
        '/Jun[^e]/', '/Jul[^y]/', '/Aug[^ust]/', '/Sep[^tember]/', '/Oct[^ober]/',
        '/Nov[^ember]/', '/Dec[^ember]/', '/January/', '/February/', '/March/',
        '/April/', '/June/', '/July/', '/August/', '/September/', '/October/',
        '/November/', '/December/',
    );
    $replace = array('Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min',
        'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu',
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des',
        'Januari', 'Februari', 'Maret', 'April', 'Juni', 'Juli', 'Agustus', 'Sepember',
        'Oktober', 'November', 'Desember',
    );
    $date = date($date_format, $timestamp);
    $date = preg_replace($pattern, $replace, $date);
    $date = "{$date} {$suffix}";
    return $date;
}

function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen($output_file, 'wb');

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>

    // we could add validation here with ensuring count( $data ) > 1
    fwrite($ifp, base64_decode($base64_string));
    // clean up the file resource
    fclose($ifp);

    return $output_file;
}

function getRandomName($image) {
  return md5(date("Y-m-d h:i:s")) . "." . pathinfo($image, PATHINFO_EXTENSION);
}


?>
