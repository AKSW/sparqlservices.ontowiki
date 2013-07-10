<?php
/**
 * This file is part of the {@link http://ontowiki.net OntoWiki} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */


/**
 * Plugin to switch SparqlEndpoints in OW configuration
 *
 * @copyright  Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @author     Michael Martin <martin@informatik.uni-leipzig.de>
 * @package    Extensions_Sparqlservices
 */
class SparqlservicesPlugin extends OntoWiki_Plugin
{
    private $_owApp;

    /**
     * 
     */
    public function init()
    {
        $this->_owApp = OntoWiki::getInstance();
    }

    /**
     * Check before initializing store if there is a new backend URI to use.
     */
    public function onBeforeInitialisingStore($event)
    {
        $request = new OntoWiki_Request();

        if ($request->getParam("serviceUrl")) {
            $sparqlServiceRequested = $request->getParam("serviceUrl");
        } elseif (true == isset($_SESSION[_OWSESSION]['serviceUrl'])) {
            $sparqlServiceRequested     = $_SESSION[_OWSESSION]['serviceUrl'];
        } else {
            return false;
        }

        $sparqlService = '';

        // if given string is invalid
        if (false == Zend_Uri::check($sparqlServiceRequested)) {
            // do nothing
            return;

        // URI is valid
        } else {
            if ($request->getParam("userAddedServiceUrl")) {
                $_SESSION[_OWSESSION]['insertedEndpoint'] = $sparqlServiceRequested;
            }

            if (false == empty($sparqlServiceRequested)) {
                $sparqlService                         = $sparqlServiceRequested;
                $_SESSION[_OWSESSION]['serviceUrl']    = $sparqlServiceRequested;
            } else {
                if (false == empty($_SESSION[_OWSESSION]['serviceUrl'])) {
                    $sparqlService = $_SESSION[_OWSESSION]['serviceUrl'];
                }
            }

            $sconfig = array();
            if (false == empty($sparqlService)) {
                $sconfig = array('serviceUrl' => $sparqlService);
            } else {
                return;
            }

            //are there Models preconfigured?
            $preConfEndpoints = $this->_privateConfig->get('SparqlServicesConfig')->get('endpoints');

            $graphs = array();
            foreach ($preConfEndpoints as $endpoint) {
                if ($endpoint->address == $sparqlService) {
                    if (isset ($endpoint->models)) {
                        $models = $endpoint->models;
                        foreach ($models as $model) {
                            if ($model->modelUri) {
                                $graphs[] = $model->modelUri;
                            }
                        }
                    }
                }
            }
            $sconfig['graphs'] = $graphs;
            $sparqlConfig = new Zend_Config($sconfig);
            $this->_owApp->erfurt->getConfig()->store->sparql = $sparqlConfig;
        }
    }
}
