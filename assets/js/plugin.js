(function() {
    tinymce.create('tinymce.plugins.Blope', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            ed.addButton('blope', {
                text: '{ Bloks Stripe Buttons }',
                icon: false,
                tooltip: 'Stripe Buttons',
                onclick: function() {
                    ed.windowManager.open( {
                        title: 'Donation Buttons List',
                        width: 400,
                        height: 100,
                        body: [
                            {
                                type: 'listbox',
                                name: 'listboxName',
                                label: 'Select Button: ',
                                'values': ed.settings.blopeButtonsList
                            }
                        ],
                        onsubmit: function( e ) {
                            ed.insertContent( '[bloks_button id="' + e.data.listboxName + '"]');
                        }
                    });
                }
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
                longname : 'Bloks Button',
                author : 'Bloks Team',
                authorurl : 'http://bloks.co',
                infourl : 'http://bloks.co',
                version : "1.0"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add( 'blope', tinymce.plugins.Blope );
})();
