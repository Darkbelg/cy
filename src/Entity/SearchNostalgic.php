<?php


namespace App\Entity;


class SearchNostalgic
{
    protected $_channel;
    protected $_period;

    /**
     * @return mixed
     */
    public function getPeriod()
    {
        return $this->_period;
    }

    /**
     * @param mixed $periode
     */
    public function setPeriod($periode): void
    {
        $this->_period = $periode;
    }

    /**
     * @return mixed
     */
    public function getChannel()
    {
        return $this->_channel;
    }

    /**
     * @param mixed $channel
     */
    public function setChannel($channel)
    {
        $this->_channel = $channel;
    }

}