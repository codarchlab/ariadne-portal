function Suggest(inputPath) {

	var subjects = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('prefLabel'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		remote: {
			url: '/subject/suggest?q=%QUERY',
			wildcard: '%QUERY',			
			transform: function(response) {
				return response.data;
			}
		}
	});

	var templates = {
		'suggestion': function(subject) {
			var template = "";
			if (subject._source.prefLabel) {
				template += '<b>' + subject._source.prefLabel + '</b>';
			}
			console.log(subject);
			for (var i = 0; i < subject._source.prefLabels.length; i++) {
				var label = subject._source.prefLabels[i];
				if (label.lang == 'en') {
					if (template.length + label.label.length > 100) {
                    	template += '/ ...';
                    	break;
                	}
                	if (template.length > 0) template += ' / ';
					template += label.label;
				}
			}
			var link = ' &nbsp; <a href="/subject/' + subject._id +'"><span class="glyphicon glyphicon-info-sign"></span></a>';
			return '<div>' + template + link + '</div>';
		},
		'notFound' : function() {
			return '<div class="tt-suggestion"><em>No subjects found ...</em></div>'
		},
		'pending' : function() {
			return '<div class="tt-suggestion"><em>Searching for subjects ...</em></div>'
		}
	};

	var active = false;

	this.create = function() {

		if (active) return this;
		$(inputPath).typeahead({
			highlight: true
		}, {
			display: 'prefLabel',
			name: 'subjects',
			source: subjects,
			limit: Infinity, // needed to circumvent https://github.com/twitter/typeahead.js/issues/1232
			templates: templates
		}).bind('typeahead:select', function(event, subject) {
			var query = new Query('*', { subjectUri: subject._id, subjectLabel: subject._source.prefLabel });
			window.location.href = query.toUri();
		});
		active = true;
		return this;

	};

	this.destroy = function() {
		$(inputPath).typeahead('destroy');
		active = false;
		return this;
	};

}
