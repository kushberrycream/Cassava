/* jce - 2.9.41 | 2023-08-23 | https://www.joomlacontenteditor.net | Copyright (C) 2006 - 2023 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
tinymce.create("tinymce.plugins.HelpPlugin", {
    init: function(ed, url) {
        (this.editor = ed).addCommand("mceHelp", function() {
            ed.windowManager.open({
                title: ed.getLang("dlg.help", "Help"),
                url: ed.getParam("site_url") + "index.php?option=com_jce&task=plugin.display&plugin=help&lang=" + ed.getParam("language") + "&section=editor&category=editor&article=about",
                size: "mce-modal-landscape-full"
            });
        }), ed.addButton("help", {
            title: "dlg.help",
            cmd: "mceHelp"
        });
    }
}), tinymce.PluginManager.add("help", tinymce.plugins.HelpPlugin);