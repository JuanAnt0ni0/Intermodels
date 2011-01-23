<?php

class Neo_Gdata_Video extends Neo_Gdata
{
    /**
     * Zend Gdata Photos
     *
     * @var Zend_Gdata_Youtube
     */
    private $_videos;
    
    public function __construct() {
        parent::__construct();
        
        $service = Zend_Gdata_YouTube::AUTH_SERVICE_NAME;

        try {
            $this->_client = Zend_Gdata_ClientLogin::getHttpClient( $this->getUsername(), $this->getPassword(), $service);
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
        }

        $this->_videos = new Zend_Gdata_YouTube($this->_client,
                             $this->getApplicationId(),
                             $this->getClientId(),
                             $this->getDeveloperKey());
        
        $this->_videos->enableRequestDebugLogging( APPLICATION_PATH .'data/zend_gdata_videos.log');
    }

    /**
     * Obtener un video especifico mediante su id.
     *
     * @param  integer     $videoId     id del video
     * @return Zend_Gdata_YouTube_VideoEntry
     */
    public function getVideo($videoId)
    {
        $video = $this->_videos->getVideoEntry($videoId);
        return $video;
    }

    public function addVideo($file)
    {
        // create a Zend_Gdata_YouTube_VideoEntry
        $myVideoEntry= new Zend_Gdata_YouTube_VideoEntry();

        // set up media group as in the example above
        $mediaGroup = $this->_videos->newMediaGroup();
        $mediaGroup->title = $this->_videos->newMediaTitle()->setText($file['titulo']);
        $mediaGroup->description = $this->_videos->newMediaDescription()->setText($file['descripcion']);

        // note the different schemes for categories and developer tags
        $categoryScheme = 'http://gdata.youtube.com/schemas/2007/categories.cat';
        $developerTagScheme = 'http://gdata.youtube.com/schemas/2007/developertags.cat';

        $mediaGroup->category = array(
            $this->_videos->newMediaCategory()->setText('Autos')->setScheme($categoryScheme),
            $this->_videos->newMediaCategory()->setText('mydevelopertag')->setScheme($developerTagScheme),
            $this->_videos->newMediaCategory()->setText('anotherdevelopertag')->setScheme($developerTagScheme)
        );

        $mediaGroup->keywords = $yt->newMediaKeywords()->setText('cars, funny');
        $myVideoEntry->mediaGroup = $mediaGroup;

        $tokenHandlerUrl = 'http://gdata.youtube.com/action/GetUploadToken';
        $tokenArray = $yt->getFormUploadToken($myVideoEntry, $tokenHandlerUrl);
        $tokenValue = $tokenArray['token'];
        $postUrl = $tokenArray['url'];
    }
}