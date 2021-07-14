<?php


namespace App\Services;


use Illuminate\Support\Facades\Route;

class FunctionsService
{

    public function telLink($phone)
    {
        return 'tel:+' . preg_replace('/[^0-9]/', '', $phone);
    }

    /**
     * $youtubeID = get_youtube_video_id('youtube video url');
     * $thumbURL = 'https://img.youtube.com/vi/' . $youtubeID . '/mqdefault.jpg';
     */

    public function getYoutubeVideoId($pageVideUrl)
    {
        $link     = $pageVideUrl;
        $video_id = explode("?v=", $link);
        if ( ! isset($video_id[1])) {
            $video_id = explode("youtu.be/", $link);
        }
        $youtubeID = $video_id[1];
        if (empty($video_id[1])) {
            $video_id = explode("/v/", $link);
        }
        $video_id       = explode("&", $video_id[1]);
        $youtubeVideoID = $video_id[0];
        if ($youtubeVideoID) {
            return $youtubeVideoID;
        } else {
            return false;
        }
    }

    public function isFrontPage()
    {
        if (Route::getCurrentRoute()->uri() == '/') {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }


}
