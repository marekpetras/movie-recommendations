<?php

namespace app\services\source;

use app\services\source\interfaces\SocketSourceInterface;

/**
 * Class Pastebin
 * represents pastebin source
 */
class Pastebin extends SocketSource implements SocketSourceInterface
{
    protected $_path = '/raw/cVyp3McN';
    protected $_port = 443;
    protected $_host = 'ssl://pastebin.com';
    protected $_headers = ['Host'=>'pastebin.com'];
}