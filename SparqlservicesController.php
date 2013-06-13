<?php
/**
 * This file is part of the {@link http://ontowiki.net OntoWiki} project.
 *
 * @copyright Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */


/**
 * Controller to handle switching of SparqlEndpoints
 *
 * @copyright  Copyright (c) 2013, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @author     Michael Martin <martin@informatik.uni-leipzig.de>
 * @package    Extensions_Sparqlservices
 */
class SparqlservicesController extends OntoWiki_Controller_Component
{
    protected $_config;
    public function init ()
    {
        parent::init();
        $this->session = new Zend_Session_Namespace(_OWSESSION);
        $this->_config = $this->_config->get('SparqlServicesConfig');
    }

    public function selectAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        //switching endpoint should remove a selected model
        unset ($_SESSION[_OWSESSION]['selectedModel']);

        $owApp    = OntoWiki::getInstance();
        $owApp->reset();

        $this->_redirect(
            $this->_config->urlBase,
            array('code' => 302)
        );
    }
}
