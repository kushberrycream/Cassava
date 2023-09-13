/**
 * @package         Tabs & Accordions
 * @version         1.5.0
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            https://regularlabs.com
 * @copyright       Copyright © 2023 Regular Labs All Rights Reserved
 * @license         GNU General Public License version 2 or later
 */

'use strict';

import {Helper} from './modules/helper.js?1.5.0';
import {Set} from './modules/set.js?1.5.0';

(function() {
    window.RegularLabs = window.RegularLabs || {};

    RegularLabs.TabsAccordions = {
        init: function(settings) {
            document.querySelectorAll('[data-rlta-element="container"]').forEach(container => {
                container.rlta = new Set(container, settings);
            });
        },

        open: function(button, scroll) {
            button = Helper.getButtonByMixed(button);

            if ( ! button) {
                return;
            }

            if (scroll === undefined && window.rltaSettings !== undefined && window.rltaSettings.constructor === Object) {
                scroll = window.rltaSettings.scrollOnLinks;
            }

            button.rlta.item.open({scroll: scroll});
        },

        toggle: function(button, scroll) {
            button = Helper.getButtonByMixed(button);

            if ( ! button) {
                return;
            }

            if (scroll === undefined && window.rltaSettings !== undefined && window.rltaSettings.constructor === Object) {
                scroll = window.rltaSettings.scrollOnLinks;
            }

            button.rlta.item.toggle(scroll);
        },

        closeAll: function(parent) {
            parent = Helper.getParentByMixed(parent);

            const buttons = parent.querySelectorAll('[data-rlta-element="button"]');

            buttons.forEach(button => {
                if (button && button.rlta !== undefined) {
                    button.rlta.item.close();
                }
            });
        },

        openAll: function(parent) {
            parent = Helper.getParentByMixed(parent);

            const sets = parent.querySelectorAll('[data-rlta-type="accordions"],[data-rlta-element="button-list"]');

            sets.forEach(set => {
                const button = set.querySelector(':scope > [data-rlta-element="button"]');
                if (button && button.rlta !== undefined) {
                    button.rlta.item.open({scroll: false});
                }
            });
        },

        toggleAll: function(parent) {
            parent = Helper.getParentByMixed(parent);

            const sets = parent.querySelectorAll('[data-rlta-type="accordions"],[data-rlta-element="button-list"]');

            sets.forEach(set => {
                const button = set.querySelector(':scope > [data-rlta-element="button"]');
                if (button && button.rlta !== undefined) {
                    button.rlta.item.toggle(false);
                }
            });
        },

        closeAccordions: function(parent) {
            parent = Helper.getParentByMixed(parent);

            const buttons = parent.querySelectorAll('[data-rlta-type="accordions"] > [data-rlta-element="button"]');

            buttons.forEach(button => {
                if (button && button.rlta !== undefined) {
                    button.rlta.item.close();
                }
            });
        },

        openAccordions: function(parent) {
            parent = Helper.getParentByMixed(parent);

            const sets = parent.querySelectorAll('[data-rlta-type="accordions"]');

            sets.forEach(set => {
                const button = set.querySelector(':scope > [data-rlta-element="button"]');
                if (button && button.rlta !== undefined) {
                    button.rlta.item.open({scroll: false});
                }
            });
        },

        toggleAccordions: function(parent) {
            parent = Helper.getParentByMixed(parent);

            const sets = parent.querySelectorAll('[data-rlta-type="accordions"]');

            sets.forEach(set => {
                const button = set.querySelector(':scope > [data-rlta-element="button"]');
                if (button && button.rlta !== undefined) {
                    button.rlta.item.toggle(false);
                }
            });
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        RegularLabs.TabsAccordions.init(null)
    });

    window.rlta = window.rlta || RegularLabs.TabsAccordions;
})();
