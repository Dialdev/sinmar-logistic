var slzFormBuilder = {};

/**
 * @param {String} [prefix]
 */
slzFormBuilder.uniqueShortcode = function(prefix) {
	prefix = prefix || 'shortcode_';

	var shortcode = prefix + slz.randomMD5().substring(0, 7);

	shortcode = shortcode.replace(/-/g, '_');

	return shortcode;
};