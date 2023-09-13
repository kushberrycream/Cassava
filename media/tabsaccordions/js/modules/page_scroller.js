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

export function PageScroller(item) {
    this.item   = item;
    this.set    = item.set;
    this.button = item.button;
    this.panel  = item.panel;
}

PageScroller.prototype = {
    scroll: function(scroll) {
        if (scroll === 'adaptive') {
            this.scrollAdaptive();
        }
        if (scroll === 'top' || scroll === 'true') {
            this.scrollToTop();
        }
    },

    scrollAdaptive: async function() {
        const item   = await this.getItemSize();
        const view   = this.getView();
        const offset = this.getOffset();
        const margin = {
            'top'   : view.top + offset.top,
            'bottom': view.bottom - offset.bottom
        };

        const item_scroll_top = item.top - offset.top;

        // button and panel are both in view (inside margin), so don't scroll
        if (item.top >= margin.top && item.bottom <= margin.bottom) {
            return this.scrollTo(view.top);
        }

        // button top is outside the view, so scroll to top
        if (item.top < margin.top || item.top > view.bottom) {
            return this.scrollTo(item_scroll_top);
        }

        // newOffsetTop based on the panel being at the bottom inside the view (margin)
        const new_scroll_top = item.bottom + offset.bottom - view.height;

        // new offset is within the margin, so scroll to new offset
        if (new_scroll_top < item_scroll_top) {
            return this.scrollTo(new_scroll_top);
        }

        // new offset is above the margin (panel doesn't fit on screen), so scroll to top
        return this.scrollTo(item_scroll_top);
    },

    scrollToTop: async function() {
        const item   = await this.getItemSize();
        const offset = this.getOffset();

        this.scrollTo(item.top - offset.top);
    },

    scrollTo: function(position) {
        const view = this.getView();

        if ( ! ('scrollBehavior' in document.documentElement.style)) {
            return window.scroll(view.left, position);
        }

        return window.scrollTo({
            'behavior': 'smooth',
            'top'     : position
        });
    },

    getSizeFromElements: function(element_1, element_2) {
        const view = this.getView();

        const size_1 = element_1.getBoundingClientRect();
        const size_2 = element_2.getBoundingClientRect();

        return {
            'top'   : Math.min(size_1.top, size_2.top) + view.top,
            'bottom': Math.max(size_1.bottom, size_2.bottom) + view.top,
        };
    },

    getItemSize: async function() {
        const button = this.set.isTabs() ? this.set.buttonList : this.button.element;
        const panel  = this.panel.element;

        const active_item = this.set.getActive();

        if (active_item === this.item) {
            return this.getSizeFromElements(button, panel);
        }

        const active_panel = active_item.panel.element;

        active_panel.hidden = true;
        panel.hidden        = false;
        await this.panel.open();
        this.panel.setData('state', 'open');

        const size = this.getSizeFromElements(button, panel);

        active_panel.hidden = false;
        panel.hidden        = true;
        this.panel.close();
        this.panel.setData('state', 'closed');

        return size
    },

    getView: function() {
        return {
            top   : window.pageYOffset,
            bottom: window.pageYOffset + window.innerHeight,
            left  : window.pageXOffset,
            height: window.innerHeight
        }
    },

    getOffset: function() {
        return {
            'top'   : parseInt(this.set.isWideScreen() ? this.set.settings.scrollOffsetTopWide : this.set.settings.scrollOffsetTop),
            'bottom': parseInt(this.set.isWideScreen() ? this.set.settings.scrollOffsetBottomWide : this.set.settings.scrollOffsetBottom)
        };
    },
};
