<?php
/**
 * Theme
 * Theme class
 * 
 * @category   Erdiko
 * @package    Core
 * @copyright  Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author	   John Arroyo
 */
namespace erdiko\core;
use Erdiko;

class Theme extends Container
{	
	protected $_templateFolder = 'themes';
    protected $_defaultTemplate = 'default';
    // protected $_name = null;
    protected $_config = null;
    protected $_content = null;

    // $_template is the theme name

    /**
     *
     */
    public function getConfig()
    {
        if(empty($this->config))
        {
            $file = $this->getThemeFolder() . 'theme.json';
            $this->_config = Erdiko::getConfigFile($file);
        }
        return $this->_config;
    }

    /**
     *
     */
    public function getMeta()
    {
        if(isset($this->_data['meta']))
            return $this->_data['meta'];
        else 
            return array();
    }

    /**
     *
     */
    public function getPageTitle()
    {
        if(isset($this->_data['page_title']))
            return $this->_data['page_title'];
        else 
            return null;
    }

    /**
     *
     */
    public function getCss()
    {
        return $this->_config['css'];
    }

    /**
     *
     */
    public function getJs()
    {
        return $this->_config['js'];
    }

    /**
     * Get the theme folder
     * @return string $folder
     */
    public function getThemeFolder()
    {
        return parent::getTemplateFolder().$this->_template.'/';
    }

    /**
     * Get template folder relative to the theme root
     */
    public function getTemplateFolder()
    {
        return $this->getThemeFolder().'templates/';
    }


    /**
     * @param Container $content, e.g. View or Layout Object???
     */
    public function setContent($content)
    {
    	$this->_content = $content;
    }

    /**
     * @return string $content???
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->_template = $template;
    }

    /**
     * Get template file populated by the config
     * e.g. get header/footer
     * @return string $html
     */
    public function getTemplateHtml($partial, $context = 'default')
    {
        $config = $this->getConfig();
        $filename = $this->getTemplateFolder().$config['templates'][$partial]['file'];
        $html = $this->getTemplateFile($filename, $this->getContextConfig($context));
        
        return $html;
    }

    /**
     *
     */
    public function getContextConfig($context = 'default')
    {
        return Erdiko::getConfig('application/'.$context);
    }

    /**
     *
     */
    public function toHtml($content, $data)
    {
        $this->setContent($content); // rendered html (body content)
        $this->setData($data); // data injected from Response/Controller
        $this->getConfig(); // load the site config

        $filename = $this->getTemplateFolder().$this->_defaultTemplate;
        error_log("theme filename: $filename");
        $html = $this->getTemplateFile($filename, $this);

        return $html;
    }
}