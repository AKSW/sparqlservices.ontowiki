sparqlservices.ontowiki
=======================

OntoWiki extension to operate over configured SPARQL endpoints.
As part of this extension the following functionalities are delivered:
* A module that 
  * lists configured Sparql endpoints (configurations in doap file)
  * can be used to switch between sparql endpoints

* A Controller that is used to reset the OntoWiki App after switching a Sparql endpoint.

* A Plugin used to hook into loading the SPARQL Backend in order to set backend configurations

Note that this extension need Updates in the SPARQL Backend.
Currently these updates a locates in the feature branch feature-remote-sparqlendpoint

