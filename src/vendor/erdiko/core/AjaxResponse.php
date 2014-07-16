<?php
/**
 * AjaxResponse
 * 
 * @category   Erdiko
 * @package    Core
 * @copyright  Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author	   John Arroyo
 */
namespace erdiko\core;
use Erdiko;


class AjaxResponse extends Response 
{
	protected $_theme;
	protected $_content = null;

    public function render()
    {
        $responseData = array(
            "status" => 500,
            "body" => $this->_content,
            "errors" => array()
            );

        return json_encode($responseData);
    }

}
