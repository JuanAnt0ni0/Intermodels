<?php

class Neo_Gdata_Photo extends Neo_Gdata
{
    /**
     * Zend Gdata Photos
     *
     * @var Zend_Gdata_Photos
     */
    private $_photos;
    
    public function __construct() {
        parent::__construct();
        
        $service = Zend_Gdata_Photos::AUTH_SERVICE_NAME;

        try {
            $this->_client = Zend_Gdata_ClientLogin::getHttpClient( $this->getUsername(), $this->getPassword(), $service);
        } catch (Zend_Exception $e) {
            $e->getMessage();
        }
        
        $this->_photos = new Zend_Gdata_Photos($this->_client, $this->getApplicationId());
        $this->_photos->enableRequestDebugLogging( APPLICATION_PATH .'data/zend_gdata_photos.log');
    }

    /**
     * Adicionar un nuevo album.
     *
     * @param  string           $name   name the new album
     * @return Zend_Gdata_Photos_AlbumEntry
     */
    public function addAlbum($name)
    {
        $entry  = new Zend_Gdata_Photos_AlbumEntry();
        $entry->setTitle($this->_photos->newTitle($name));
        $result = $this->_photos->insertAlbumEntry($entry);
        return $result;
    }

    /**
     * Eliminar un album especifico.
     *
     * @param  integer          $albumId id del album
     * @return void
     */
    public function deleteAlbum($albumId)
    {
        $albumQuery = new Zend_Gdata_Photos_AlbumQuery;
        $albumQuery->setAlbumId($albumId);
        $albumQuery->setType('entry');

        $entry = $this->_photos->getAlbumEntry($albumQuery);

        $this->_photos->deleteAlbumEntry($entry, true);
    }

    /**
     * Obtener un album especifico mediante su nombre.
     *
     * @param  integer     $albumId     id del album
     * @return Zend_Gdata_Photos_AlbumFeed
     */
    public function getAlbum( $albumId )
    {
        $query = new Zend_Gdata_Photos_AlbumQuery();
        $query->setAlbumId($albumId);

        $albumFeed = $this->_photos->getAlbumFeed($query);
        return $albumFeed;
    }

    public function updateAlbum()
    {
        //$createdEntry->title->text = "Updated album title";
        //$updatedEntry = $createdEntry->save();
    }

    /**
     * Adicionar una nueva foto a un album especifico.
     *
     * @param  integer          $albumId   id del album
     * @param  array            $photo   The uploaded photo
     * @return Zend_Gdata_Photos_PhotoEntry
     */
    public function insertPhoto($albumId, $photo)
    {
        $fd = $this->_photos->newMediaFileSource($photo["tmp_name"]);
        $fd->setContentType($photo["type"]);

        $entry = new Zend_Gdata_Photos_PhotoEntry();
        $entry->setMediaSource($fd);
        $entry->setTitle($this->_photos->newTitle($photo["name"]));
        $entry->setSummary($this->_photos->newSummary($photo["summary"]));

        $albumQuery = new Zend_Gdata_Photos_AlbumQuery;
        $albumQuery->setAlbumId($albumId);

        $albumEntry = $this->_photos->getAlbumEntry($albumQuery);
        try {
            $photo = $this->_photos->insertPhotoEntry($entry, $albumEntry);
        } catch (Zend_Exception $e) {
            //echo $e->getMessage();
        }
        
        return $photo;
    }

    /**
     * Eliminar una foto especifica.
     *
     * @param  integer          $albumId id del album
     * @param  integer          $photoId id de la foto
     * @return void
     */
    public function deletePhoto($albumId, $photoId)
    {
        $photoQuery = new Zend_Gdata_Photos_PhotoQuery;
        $photoQuery->setAlbumId($albumId);
        $photoQuery->setPhotoId($photoId);
        $photoQuery->setType('entry');

        $entry = $this->_photos->getPhotoEntry($photoQuery);
        $this->_photos->deletePhotoEntry($entry, true);
    }

    /**
     * Obtener una foto especifica.
     *
     * @param  integer          $albumId id del album
     * @param  integer          $photoId id de la foto
     * @return Zend_Gdata_Photos_PhotoEntry
     */
    public function getPhoto($albumId, $photoId)
    {
        $photoQuery = new Zend_Gdata_Photos_PhotoQuery;
        $photoQuery->setAlbumId($albumId);
        $photoQuery->setPhotoId($photoId);
        $photoQuery->setType('entry');

        $entry = $this->_photos->getPhotoEntry($photoQuery);

        return $entry;

    }

    /**
     * Obtener las fotos de un album especifico.
     *
     * @param  integer          $albumId Id Album
     * @return Zend_Gdata_Photos_AlbumFeed
     */
    public function getPhotos($albumId)
    {
        $query = new Zend_Gdata_Photos_AlbumQuery();
        $query->setAlbumId($albumId);

        $albumFeed = $this->_photos->getAlbumFeed($query);

        return $albumFeed;
    }

    /**
     * Obtener la ultima foto subida.
     *
     * @return Zend_Gdata_Photos_PhotoFeed
     */
    public function getLastPhotoUpload()
    {
        $query = $this->_photos->newUserQuery();
        $query->setKind("photo");
        $query->setMaxResults("1");
        $entry = $this->_photos->getUserFeed(null, $query);
        
        return $entry[0];
    }
}
