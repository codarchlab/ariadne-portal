@if (!Request::is('browse/*'))
	<footer id="footer">
	    <div class="container-fluid">
	        <p>

	            <img src="{{ asset("img/euflag_footer.jpg") }}" alt="European Commission" id="eulogo">
	            Copyright &copy; 2015 Ariadne. All rights reserved.<br>
	            Ariadne is funded by the <a href="http://ec.europa.eu/research/fp7/index_en.cfm">European Commission's 7th Framework Programme</a>.

	        </p>
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