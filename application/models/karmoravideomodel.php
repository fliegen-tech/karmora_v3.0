<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class karmoravideomodel extends commonmodel {

    /**
     * This is the constructor of a Model
     */
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function getKarmoraVideos($videoId = NULL)
    {
        $whereClause = 1;
        if($videoId !== NULL)
        {
            $whereClause = 'pk_video_id !='.$videoId;
        }
        $query = "SELECT pk_video_id, video_title,video_url, video_cover_photo FROM view_karmora_videos WHERE $whereClause Order By pk_video_id DESC";
        
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($data); exit;
        if (count($data) > 0) {
            $response = $data;
        } else {
            $response = FALSE;
        }
        return $response;
    }
    
    public function getVideoWithTitle($videoTitle)
    {
        $query = "SELECT pk_video_id, video_title, video_url FROM view_karmora_videos WHERE video_title LIKE ('$videoTitle%') LIMIT 1";
        
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($data) > 0) {
            $response = $data;
        } else {
            $response = false;
        }
        return $response;
    }
}

?>