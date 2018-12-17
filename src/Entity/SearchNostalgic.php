<?php


namespace App\Entity;


class SearchNostalgic
{
    protected $_channelId;

    /**
     * @return mixed
     */
    public function getChannelId()
    {
        return $this->_channelId;
    }

    /**
     * @param mixed $channelId
     */
    public function setChannelId($channelId)
    {
        $this->_channelId = $channelId;
    }

}