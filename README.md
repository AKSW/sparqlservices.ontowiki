sparqlservices.ontowiki
=======================

OntoWiki extension to operate over configured SPARQL endpoints.
As part of this extension the following functionalities are delivered:
* A module that 
  * lists configured Sparql endpoints (configurations in doap file)
  * can be used to switch between sparql endpoints

* A Controller that is used to reset the OntoWiki App after switching a Sparql endpoint.

* A Plugin used to hook into loading the SPARQL Backend in order to set backend configurations

Usage
=====
* Please configure sparql as backend in your local ontowiki config.ini (further backend configurations such as serviceUrl or graphs are not necessary):

  `store.backend = sparql`

* If you want to configure a default graph please add the following options to the OW config.ini

  `store.sparql.serviceUrl = <your Service Url>`

  `store.sparql.graphs[]` = <first graph Uri>

  `store.sparql.graphs[]` = <a further graph Uri>

* add further configurations to local config.ini in order to disable AccessControl, QueryCache and Versioning (these functions need a local triple store)

  `versioning         = false`

  `sysont.enable      = false`

  `ac.type            = "none"`

  `cache.enable       = false`

  `cache.query.enable = false`

* Edit the backend list in the doap file according your needs. 
  In the following an example is shown illustrating that you are able to setup the SPARQL endpoint URI and a respective label, that will be used in the list.

  `owconfig:config [

      a owconfig:Config;

      owconfig:id "endpoint-5" ;

      rdfs:label "DBpedia" ;

      :address <http://dbpedia.org/sparql>

   ];`


* Toggle visualization of the SparqlSelection Module using the following option in the doap file:

  `:showServicesModule "true"^^xsd:boolean ;`

* Toggle display of the input form for Sparql endpoints using the following option in the doap file:

  `:userInputAllowed "true"^^xsd:boolean ;`

* Switch between listed Sparql backends using the Sparql endpoints box or use directly the `serviceUrl=<address>` within the request

* Enjoy Linked Data :-)

Note 
====
This extension need updates in the SPARQL backend.
Currently these updates are located in the feature branch feature-remote-sparqlendpoint

