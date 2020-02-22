/**
 * $Id: editor_plugin_src.js 264 2007-04-26 20:53:09Z spocke $
 *
 * @author Moxiecode
 * @copyright Copyright © 2004-2008, Moxiecode Systems AB, All rights reserved.
 */

(function() {
	var DOM = tinymce.DOM, Event = tinymce.dom.Event, each = tinymce.each, is = tinymce.is;

	tinymce.create('tinymce.plugins.Compat2x', {
		getInfo : function() {
			return {
				longname : 'Compat2x',
				author : 'Moxiecode Systems AB',
				authorurl : 'http://tinymce.moxiecode.com',
				infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/compat2x',
				version : tinyMCE.majorVersion + "." + tinyMCE.minorVersion
			};
		}
	});

	(function() {
		// Extend tinyMCE/EditorManager
		tinymce.extend(tinyMCE, {
			addToLang : function(p, l) {
				each(l, function(v, k) {
					tinyMCE.i18n[(tinyMCE.settings.language || 'en') + '.' + (p ? p + '_' : '') + k] = v;
				});
			},

			getInstanceById : function(n) {
				return this.get(n);
			}
		});
	})();

	(function() {
		var EditorManager = tinymce.EditorManager;

		tinyMCE.instances = {};
		tinyMCE.plugins = {};
		tinymce.PluginManager.onAdd.add(function(pm, n, p) {
			tinyMCE.plugins[n] = p;
		});

		tinyMCE.majorVersion = tinymce.majorVersion;
		tinyMCE.minorVersion = tinymce.minorVersion;
		tinyMCE.releaseDate = tinymce.releaseDate;
		tinyMCE.baseURL = tinymce.baseURL;
		tinyMCE.isIE = tinyMCE.isMSIE = tinymce.isIE || tinymce.isOpera;
		tinyMCE.isMSIE5 = tinymce.isIE;
		tinyMCE.isMSIE5_0 = tinymce.isIE;
		tinyMCE.isMSIE7 = tinymce.isIE;
		tinyMCE.isGecko = tinymce.isGecko;
		tinyMCE.isSafari = tinymce.isWebKit;
		tinyMCE.isOpera = tinymce.isOpera;
		tinyMCE.isMac = false;
		tinyMCE.isNS7 = false;
		tinyMCE.isNS71 = false;
		tinyMCE.compat = true;

		// Extend tinyMCE class
		TinyMCE_Engine = tinyMCE;
		tinymce.extend(tinyMCE, {
			getParam : function(n, dv) {
				return this.activeEditor.getParam(n, dv);
			},

			addEvent : function(e, na, f, sc) {
				tinymce.dom.Event.add(e, na, f, sc || this);
			},

			getControlHTML : function(n) {
				return EditorManager.activeEditor.controlManager.createControl(n);
			},

			loadCSS : function(u) {
				tinymce.DOM.loadCSS(u);
			},

			importCSS : function(doc, u) {
				if (doc == document)
					this.loadCSS(u);
				else
					new tinymce.dom.DOMUtils(doc).loadCSS(u);
			},

			log : function() {
				console.debug.apply(console, arguments);
			},

			getLang : function(n, dv) {
				var v = EditorManager.activeEditor.getLang(n.replace(/^lang_/g, ''), dv);

				// Is number
				if (/^[0-9\-.]+$/g.test(v))
					return parseInt(v);

				return v;
			},

			isInstance : function(o) {
				return o != null && typeof(o) == "object" && o.execCommand;
			},

			triggerNodeChange : function() {
				EditorManager.activeEditor.nodeChanged();
			},

			regexpReplace : function