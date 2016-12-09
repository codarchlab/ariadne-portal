@extends('app')
@section('title', 'About - Ariadne portal')

@section('description', 'ARIADNE brings together and integrates existing archaeological research data infrastructures
    so that researchers can use the various distributed datasets and new and powerful technologies as an integral
    component of the archaeological research methodology.')
@section('keywords', 'Archaeological Research Data Infrastructures, Metadata Registry')

@section('content')

    <div id="aboutpage" class="container content">

    <!-- Main content -->
        <div class="row">

            <div class="col-md-12">

                <h1>ARIADNE</h1>

                <p>
                    ARIADNE is a research infrastructure for archaeology.  Its main objective is to support research, learning and teaching
                    by enabling access to digital resources and innovative new services.  It does this by maintaining a catalogue of digital
                    datasets, by promoting best practices in the management and use of digital data in archaeology, by offering training and
                    advice, and by supporting the development of innovative new services for archaeology. 
                </p>                
                <p>
                    The datasets that are registered in the ARIADNE catalogue are held by its partners and have been created through research, 
                    in excavations, in fieldwork, laboratory and other projects.  In recent years archaeologists have been making increasing 
                    use of sophisticated digital equipment and techniques.  During the course of a research project large volumes of data are 
                    created and collected, and become part of the research archive.  ARIADNE aims to make these archives available through its 
                    portal for researchers to consult when starting new research. 
                </p>
                
                <h1>ARIADNE portal</h1>

                <p>
                    The ARIADNE Portal offers a central point of access to the archaeological resources made available from partner institutions 
                    throughout Europe. Behind the portal lie the ARIADNE registry and a set of services that are used to manage information about 
                    the datasets, collections, vocabularies, metadata schemas and mappings.
                </p>
                <p>
                    The registry is used to gather information about data resources and services, and to support the search functionalities offered 
                    by the portal.  Partners provide a description of their digital resources based on the ARIADNE Catalog Data Model (ACDM), which 
                    is used to include the resource in the registry.
                </p>
                
                <h2>Disclaimer </h2>
                <p>
                    Whilst we have used best efforts to ensure the accuracy of resources catalogued by the ARIADNE portal, we explicitly disclaim 
                    to the extent permitted by law any responsibility for the accuracy, content, or availability of information located through use 
                    of the Portal, or for any damage incurred owing to use of the information contained therein.
                </p>
                <p>
                    Information located through use of the Portal may be subject to specific use constraints, as advised by the data publishers. 
                    It is the responsibility of potential and actual users to be aware of such constraints and to abide by them. By making use of
                    material on this web server, including the contents of the Portal, you accept these provisions.
                </p>
                <p>
                    If you notice a mistake in one of the catalogue records or linked resources, then comments should be addressed to the data publisher,
                    not to the ARIADNE consortium.
                </p>
                <h2>For more information </h2>
                <p>
                    About the ARIADNE research infrastructure please see our project website: <a href='http://www.ariadne-infrastructure.eu'>http://www.ariadne-infrastructure.eu</a>
                </p>
                
                <h2>Guide to searching on the ARIADNE portal </h2>
                <p>
                   The portal offers users a simple friendly interface. It includes the familiar search box, which, once users start typing, suggests keywords based on the content
                   that is actually available from ARIADNE. Typing the single letter <i>“f”</i> offers the option of searching for fortifications, flat-bottomed watercraft and fragments.
                   The magic of this search technology is that it accesses the multi-lingual vocabularies. Typing the letter <i>“f”</i> offers the option of searching for 'blanks”, which
                   are 'flan' in Spanish and 'Halbfabrikat' in German. 
                </p>
                <p>
                    The keyword search is a very quick and easy way of starting to use the ARIADNE portal. For users who would like to browse the catalogue to see what type of 
                    content is available there are three starting points: Where, When and What. 
                </p>
                <br/>
                <img src="img/about1.png" class="img-responsive"/>
                <br/>
                <p>
                   Choosing to begin exploring ARIADNE by clicking on “What” is a very good way of getting an idea of the overall semantic scope of the collection. This browse option displays 
                   a word cloud based on the subject concepts included in the content metadata.
                </p>
                <br/>
                <img src="img/about2.png" class="img-responsive"/>
                <br/>
                <p>
                   Houses, earthworks, archaeological sites and buildings are all well represented in the collection. Archaeologists will notice many other familiar features to choose to continue
                   their exploration of the collection. 
                </p>
                <p>
                    Clicking on any of the subject concepts in the Word Cloud takes you to a list of the results. 
                </p>
                <br/>
                <img src="img/about3.png" class="img-responsive"/>
                <br/>
                <p>
                    All three browse options (what, where and when) are offered as additional filters on the search results page. The figure below shows the spread of content relating to “mounds” 
                    across Europe in an arc from the north of Scotland to Romania mainly concentrated in the period around 1000 BP.
                </p>
                <p>
                   This type of visualisation is a great way of helping users to explore the catalogue. Researchers can use the filters to narrow their searches to a particular region or time period, 
                   and the visualisation to identify new areas that may be related to their research interests. 
                </p>
                <p>
                    The search results provide a list of the datasets that are available. More detailed information is available for each dataset, which includes a description and a link to the content 
                    if it is available on the web. 
                </p>
                <br/>
                <img src="img/about4.png" class="img-responsive"/>
                <br/>
                <p>
                    The listing encourages researchers to explore the catalogue by highlighting other content in the same geographic region or related to the same subject topic. 
                </p>
            </div>

        </div>

    </div>

@endsection


