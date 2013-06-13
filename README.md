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
  store.backend = sparql
* add further configurations to local config.ini in order to disable AccessControl, QueryCache and Versioning (these functions need a local triple store)
  versioning         = false
  sysont.enable      = false
  ac.type            = "none"
  cache.enable       = false
  cache.query.enable = false

* Edit the backend list in the doap file according your needs
* Switch between listed Sparql backends using the Sparql endpoints box or use directly the "serviceUrl=<address>" within the request
* Enjoy Linked Data :-)

Note 
====
This extension need updates in the SPARQL backend.
Currently these updates are located in the feature branch feature-remote-sparqlendpoint

