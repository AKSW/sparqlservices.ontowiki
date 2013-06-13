<?php
/**
 * This file is part of the {@link http://ontowiki.net OntoWiki} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */


/**
 * Module to list SparqlEndpoints
 *
 * @copyright  Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @author     Michael Martin <martin@informatik.uni-leipzig.de>
 * @package    Extensions_Sparqlservices
 */
class SparqlservicesModule extends OntoWiki_Module
{
    protected $_config;
    protected $_owApp;
    protected $_urlbase;

    public function init()
    {
        $this->session = new Zend_Session_Namespace(_OWSESSION);
        $this->_urlbase = $this->_config->urlBase;

        //Config object is overwritten Its a Hack in order to get it working
        $this->_config = $this->_privateConfig->get('SparqlServicesConfig');
        $this->_owApp    = OntoWiki::getInstance();
    }

    /**
     * show module only if Sparql Backend is configured
     *
     * @return boolean
     */
    public function shouldShow()
    {
        if ($this->_config->showServicesModule) {
            return true;
        }
        return false;
    }

    /**
     * Returns the menu of the module
     * Two elements Local Configured elements and discovered ones
     * @return string
     */
    public function getMenu()
    {
        $viewMenu = new OntoWiki_Menu();
        $viewMenu->setEntry('Show Configured Sparql endpoints', array('class' => 'show'));
        $viewMenu->setEntry('Show Discovered Sparql endpoints', array('class' => 'show'));
        $mainMenu = new OntoWiki_Menu();
        $mainMenu->setEntry('Source', $viewMenu);
        return $mainMenu;
    }

    /**
     * Returns the content for the model list.
     */
    public function getContents()
    {
        $endpoints = array();

        //create list on the basis of configured endpoints
        if ($this->_config->get('endpoints')) {
            foreach ($this->_config->get('endpoints') as $key => $entry) {
                $endpoint = array();
                $addressUrl = $this->_urlbase . 'sparqlservices/select/?serviceUrl=' . urlencode($entry->address);
                $endpoint['serviceUrl']     = $addressUrl;
                $endpoint['icon']           = $entry->icon;
                if (!empty($entry->title)) {
                    $endpoint['serviceTitle']   = $entry->title;
                } else {
                    $endpoint['serviceTitle']   = $entry->address;
                }
                //if selected then mark it as selected

                $endpoint['selected'] = '';
                if (isset($this->_owApp->erfurt->getConfig()->store->sparql->serviceUrl)) {
                    $selectedEndpoint = $this->_owApp->erfurt->getConfig()->store->sparql->serviceUrl;
                    if ($selectedEndpoint == $entry->address) {
                        $endpoint['selected'] = 'selected';
                    }
                }
                $endpoints[$key] = $endpoint;
            }
        }

        $content = $this->render('sparqlservices', $endpoints, 'endpoints');

        return $content;
    }

    public function getTitle()
    {
        $title = "Sparql Discovery";
        if (!empty($this->_config->title)) {
            $title = $this->_config->title;
        }
        return $title;
    }

}