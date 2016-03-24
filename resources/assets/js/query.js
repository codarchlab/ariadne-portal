/**
 * Class for managing search query parameters.
 *
 * Handles the conversion between a javascript object
 * representing a search query and the corresponging URI.
 *
 * @param q string query string.
 * @param params object representing the GET parameters of the query.
 */
function Query(q, params) {

	var self = this;

	this.q = typeof q !== 'undefined' ? q : '*';
	this.params = typeof params !== 'undefined' ? params : {};

	this.toUri = function() {
		var uri = '/search?q=' + self.q;
		for (var key in self.params) {
			uri += "&" + key + "=" + self.params[key];
		}
		return uri;
	}

}

Query.fromUri = function(uri) {
	var q = '*';
	var params = {};
	var re = /[\?&]([^&#]*)=([^&#]*)/g;
	var result;
	while ((result = re.exec(uri)) !== null) {
		if (result[1] == 'q') q = result[2];
		else params[result[1]] = result[2];
	}
	return new Query(q, params);
};