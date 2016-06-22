<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Util extends Model
{
    public static function getScores()
    {
        $score = array(
            0=>array(
                "title"=>"總和評分",
                'detail'=>"（滿意度的指標，觀眾有沒有得到、聽到、學到想要得到、聽到、學到的東西）",
                "name"=>"total-score"
            ),
            1=>array(
                "title"=>"內容",
                'detail'=>"（與預告講題的相關度、適合本場演講的觀眾等等）",
                "name"=>"relevance-score"
            ),
            2=>array(
                "title"=>"容易懂",
                'detail'=>"（調理清晰，講話速度恰當，舉例子，好的視覺支援 等等）",
                "name"=>"clear-score"
            ),
            3=>array(
                "title"=>"啓發性",
                'detail'=>"（讓人有新的想法、聯想到自己事業或人生等等）",
                "name"=>"inspiration-score"
            ),
            4=>array(
                "title"=>"讓人投入",
                'detail'=>"（帶動氣氛的能力，讓人專注於講師，包含講師講笑話、感人故事等等）",
                "name"=>"interest-score"
            ),
            /*5=>array(
                "title"=>"內容",
                "name"=>"content-score"
            )*/
        );
        return $score;
    }

    public static function getCities()
    {
        $cities = array(
            1=>array(
                "name"=>"台北"
            ),
            2=>array(
                "name"=>"新北市"
            ),
            3=>array(
                "name"=>"新竹"
            ),
            4=>array(
                "name"=>"台中"
            ),
            5=>array(
                "name"=>"高雄"
            )
        );
        return $cities;
    }

    public static function getLocations()
    {
        $locations = array(
            1=>array(
                "name"=>"Garage+"
            ),
            2=>array(
                "name"=>">YOUR SPACE(數位時代)"
            ),
            3=>array(
                "name"=>"台大集思會議中心 GIS NTU Convention Center"
            ),
            4=>array(
                "name"=>"DOIT共創公域"
            ),
            5=>array(
                "name"=>"台大綜合體育館 NTU Sports Center"
            ),
            6=>array(
                "name"=>"台大醫院會議中心 NTUH International Convention Center"
            )
        );
        return $locations;
    }

    public static function getOrganizer()
    {
        $organizers = array(
            1=>array(
                "name"=>"數位時代（創業小聚，客座創業家，IoT沙龍，Meet Taipei)"
            ),
            2=>array(
                "name"=>">Garage+"
            ),
            3=>array(
                "name"=>"Taiwan Startup Stadium 台灣新創競技場"
            ),
            4=>array(
                "name"=>"500 Startups"
            ),
            5=>array(
                "name"=>"TRIPLE 快製中心"
            ),
            6=>array(
                "name"=>"tvca 中華民國創業投資商業同業協會"
            ),
            7=>array(
                "name"=>"Seinsights 社企流"
            ),
            8=>array(
                "name"=>"Fugle 群馥科技"
            )
        );
        return $organizers;
    }
}
