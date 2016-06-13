@if (!Request::is('browse/*'))
	<footer id="footer">
	    <div class="container-fluid">
	    	<div class="row">
		        <div class="col-md-12">
		            <img src="{{ asset("img/euflag_footer.jpg") }}" alt="European Commission" id="eulogo">
		            @if(Config::get("app.version") != '')
						v{{Config::get("app.version")}} -
					@endif
					Copyright &copy; {{date('Y')}} Ariadne. All rights reserved. 
					<a href="{{ route('contact.form') }}">
		        		<span class="glyphicon glyphicon-envelope"></span> Contact
		        	</a>
		        	<br>
		            Ariadne is funded by the <a href="http://ec.europa.eu/research/fp7/index_en.cfm">European Commission's 7th Framework Programme</a>.
		        </div>
		    </div>
	    </div>
	</footer>
@endif

@if(Config::get("app.google_analytics") != '')
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', '{{ Config::get("app.google_analytics") }}', 'auto');
      ga('send', 'pageview');

    </script>
@endif