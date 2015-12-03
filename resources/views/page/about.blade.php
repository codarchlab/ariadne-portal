@extends('app')
@section('title', 'About - Ariadne portal')

@section('description', 'ARIADNE brings together and integrates existing archaeological research data infrastructures
    so that researchers can use the various distributed datasets and new and powerful technologies as an integral
    component of the archaeological research methodology.')
@section('keywords', 'Archaeological Research Data Infrastructures, Metadata Registry')

@section('content')

    <div id="aboutpage" class="container">

    <!-- Main content -->
        <div class="row">

            <div class="col-md-12">

                <h1>Ariadne project and the registry</h1>

                <p>
                    ARIADNE brings together and integrates existing archaeological research data infrastructures so that researchers
                    can use the various distributed datasets and new and powerful technologies as an integral component of the
                    archaeological research methodology. There is now a large availablity of archaeological digital datasets
                    that all together span different periods, domains and regions; more are continuously created as a result
                    of the increasing use of IT. The are the accumulated outcome of the research of individuals, teams and
                    institutions, but form a vast and fragmented corpus and their potential has been constrained by difficult
                    access and non-homogenous perspectives.
                </p>
                <h2>Ariadne Metadata Registry</h2>
                <p>The ARIADNE metadata registry will survey currently used data standards and metadata schemas, and will compile a
                    registry of those in use in different fields/regions of archaeological research, including important related domains of
                    research, together with any available bilateral mapping.
                </p>
                <p>
                    Through this portal, data gathered in the Ariadne registry will
                    become searchable and useful to other researchers
                </p>

                <h1>Ariadne Dataset Catalogue Model (ACDM)</h1>

                <p>
                    ACDM is an extension of the <a href="http://www.w3.org/TR/vocab-dcat/">Data Catalog Vocabulary (DCAT)</a>, a quasi-recommendation of the W3C Consortium
                    that “is well-suited to representing government data catalogues
                    such as Data.gov and data.gov.uk.”  The reason for adopting the DCAT Vocabulary (apart from re-use)
                    is that DCAT is proposed as a tool for publishing datasets as Open Data. Its adoption places therefore ARIADNE
                    in an ideal position for publishing datasets as Open Data as well. To this end, ARIADNE will be following the
                    recommendations made in the “DCAT Application Profile for data portals in Europe”  concerning the use of the
                    terms of the DCAT ontology. These recommendations establish which attributes or classes are mandatory;
                    for the moment, we will not strictly adhere to these recommendations because we are using DCAT for internal purposes.
                    ACDM makes usage of the following namespaces:
                </p>
                <ul>
                    <li> dcat:    <a href="http://www.w3.org/ns/dcat#" target='_blank'> http://www.w3.org/ns/dcat# </a> </li>
                    <li> dct:     <a href="http://purl.org/dc/terms/" target='_blank'> http://purl.org/dc/terms/ </a> </li>
                    <li> dctype:  <a href="http://purl.org/dc/dcmitype/ " target='_blank'> http://purl.org/dc/dcmitype/ </a> </li>
                    <li> foaf:	  <a href="http://xmlns.com/foaf/0.1/ " target='_blank'> http://xmlns.com/foaf/0.1/ </a> </li>
                    <li> rdf:	  <a href="http://www.w3.org/1999/02/22-rdf-syntax-ns#" target='_blank'> http://www.w3.org/1999/02/22-rdf-syntax-ns# </a> </li>
                    <li> rdfs:	  <a href="http://www.w3.org/2000/01/rdf-schema#" target='_blank'> http://www.w3.org/2000/01/rdf-schema# </a> </li>
                    <li> skos:	  <a href="http://www.w3.org/2004/02/skos/core#" target='_blank'> http://www.w3.org/2004/02/skos/core# </a> </li>
                    <li> xsd:	  <a href="http://www.w3.org/2001/XMLSchema#" target='_blank'> http://www.w3.org/2001/XMLSchema# </a> </li>
                </ul>

                <h2>Class structure of the model </h2>
                <p align="justify">
                    The central notion of the model is the class ArchaeologicalResource, that has as
                    instances the main resources described in a catalogue. These are categorized in
                    services, language resources and data resources. A short description for each class
                    is following.
                </p>
                <ul>
                    <li><b>dcat:Catalog</b> -> This class is part of the DCAT Vocabulary. It has catalogues as instances, therefore the ARIADNE Catalogue will be an instance of this class. </li>
                    <li><b>foaf:Agent</b> -> This class is used in this schema to model the institution that makes a resource available.</li>
                    <li><b>:DataResource</b> -> This class has as instances the archaeological resources that are data containers such as databases, GIS, collections or datasets.
                        The class is created for the sole purpose of defining the domain and the range of a number of associations.
                        It is therefore an abstract class, it does not have any instance, it only inherits instances form its sub-classes.</li>
                    <li><b>:Database</b> -> This class is a specialization of the class DataResource, and has as instances databases,
                        defined as a set of homogeneously structured records managed through a Database Management System, such as MySQL.</li>
                    <li><b>:Dataset</b> -> This class is a specialization of the classes DataResource and dcat:Dataset, the latter coming from the DCAT Vocabulary.
                        It has archaeological datasets as instances. An archaeological dataset is defined as a set of homogeneously structured
                        records that are not managed through a Database Management System.</li>
                    <li><b>:GIS</b> -> This class is a specialization of the class DataResource, and has as instances Geographical Information Systems (GISs).</li>
                    <li><b>:DataFormat</b> -> An instance of this class describes the structure of a Datasets, or of a <i>MetadataSchema</i>, or of metadata record.</li>
                    <li><b>:DBSchema</b> -> An instance of this class describes the structure of a Database.</li>
                    <li><b>:MetadataSchema</b> -> This is a subclass of LanguageResource having as instances metadata schemas used in the archaeological domain.
                        This is the main class in the metadata registry of ARIADNE.</li>
                    <li><b>:Distribution</b> -> This class represents an accessible form of an ARIADNE resource as for example a downloadable file, an RSS feed or a web service.
                        It extends the class dcat:Distribution by adding three attributes (:numOfRecords, :OAI-PMHServerURI, :platformDescription).</li>
                    <li><b>:Mapping</b> -> An instance of this class represents a mapping between two language resources.</li>
                    <li><b>:Vocabulary</b> -> An instance of this class represents a vocabulary or authority file, used in the associated structure.
                        The instances of this class define the ARIADNE vocabulary registry.</li>
                    <li><b>:Licence</b> -> An instance of this class represents a Licence.</li>
                    <li><b>:Service</b> -> This class specializes the class dbpedia.org/ontology/Software.</li>
                </ul>

            </div>

        </div>

    </div>

@endsection


