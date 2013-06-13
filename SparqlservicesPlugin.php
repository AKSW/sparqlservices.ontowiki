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

    public function init()
    {
        $this->_owApp    = OntoWiki::getInstance();
    }

    public function onBeforeInitialisingStore($event)
    {
        $request                    = new OntoWiki_Request();
        $sparqlServiceRequested     = $request->getParam("serviceUrl");
        $sparqlService              = "";

        if (!empty($sparqlServiceRequested)) {
            $sparqlService                  = $sparqlServiceRequested;
            $_SESSION['serviceUrl']         = $sparqlServiceRequested;
        } else {
            if (!empty($_SESSION['serviceUrl'])) {
                $sparqlService = $_SESSION['serviceUrl'];
            }
        }

        //writing the selected Language back into configuration
        if (!empty($sparqlService)) {
            $sparqlConfig = new Zend_Config(array('serviceUrl' => $sparqlService));
            $this->_owApp->erfurt->getConfig()->store->sparql = $sparqlConfig;
        }

    }
}
