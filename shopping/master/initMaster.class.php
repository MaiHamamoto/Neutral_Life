<?php
/*
 * ファイルパス：/Applications/MAMP/htdocs/DT/shopping/initMaster.class.php
 * ファイル名：initMaster.class.php
 */
namespace shopping\master;

class initMaster
{

    public static function getDate()
    {
        $yearArr = [];
        $monthArr = [];
        $dayArr = [];

        $next_year = date('Y') + 1;

        // 年を作成
        for ($i = 1900; $i < $next_year; $i ++) {
            $year = sprintf("%04d", $i);
            $yearArr[$year] = $year . ' Year';
        }

        // 月を作成
        for ($i = 1; $i < 13; $i ++) {
            $month = sprintf("%02d", $i);
            $monthArr[$month] = $month . ' Month';
        }
        // 日を作成
        for ($i = 1; $i < 32; $i ++) {
            $day = sprintf("%02d", $i);
            $dayArr[$day] = $day . ' Day';
        }

        return [$yearArr, $monthArr, $dayArr];
    }

    public static function getSex()
    {
        $sexArr = ['1' => 'Male', '2' => 'Female'];
        return $sexArr;
    }

    public static function getTrafficWay()
    {
        $trafficArr = ['Walking', 'Bicycle', 'Bus', 'Train', 'Car・Motorcycle'];
        return $trafficArr;
    }
}
