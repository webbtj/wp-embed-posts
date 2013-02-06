// Docu : http://wiki.moxiecode.com/index.php/TinyMCE:Create_plugin/3.x#Creating_your_own_plugins

(function() {	
	tinymce.create('tinymce.plugins.wpembedposts', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			//Register command
			ed.addCommand('mcewpembedposts', function() {
				console.log(window);
				ed.windowManager.open({
					file : url + '/window.php?id='+this.id,
					width : 400 + ed.getLang('wpembedposts.delta_width', 0),
					height : 120 + ed.getLang('wpembedposts.delta_height', 0),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			//Register button
			ed.addButton('wpembedposts', {
				title : 'Embed a Post',
				cmd : 'mcewpembedposts',
				image : url + '/icon.png'
			});

			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('wpembedposts', n.nodeName == 'IMG');
			});
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
					longname  : 'wpembedposts',
					author 	  : 'TJ Webb',
					authorurl : 'http://webb.tj/',
					infourl   : 'http://webb.tj/',
					version   : "1.0"
			};
		}
	});

	//Register plugin
	tinymce.PluginManager.add('wpembedposts', tinymce.plugins.wpembedposts);
})();