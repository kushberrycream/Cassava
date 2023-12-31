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

import {Helper} from './helper.js?1.5.0';

export function ButtonScroller(set) {
    this.set     = set;
    this.element = null;
    this.left    = null;
    this.right   = null;
    this.stepper = {
        interval: null,
        step    : 50,
        to      : 0,
        time    : 0,
    };

    this.templates = {
        buttons  : '<div tabindex="-1">',
        container: '<div>',
        hotspot  : '<div class="hidden">',
        button   : '<button type="button" tabindex="-1">',
    };

    this.init = async function() {
        const createElements = () => {
            const createScrollButton = (direction) => {
                const container                    = Helper.createElementFromHTML(
                    this.templates.container,
                    `button-scroller-${direction}`
                );
                container.hotspot                  = Helper.createElementFromHTML(
                    this.templates.hotspot,
                    'button-scroller-hotspot'
                );
                container.hotspot.button           = Helper.createElementFromHTML(
                    this.templates.button,
                    'button-scroller-button'
                );
                container.hotspot.button.innerHTML = Joomla.Text._(`RLTA_BUTTON_SCROLL_${direction}`);

                container.hotspot.appendChild(container.hotspot.button);
                container.appendChild(container.hotspot);

                this[direction] = container;

                return container;
            };

            this.element      = Helper.createElementFromHTML(
                this.templates.buttons,
                'button-scroller'
            );
            this.element.rlta = this;

            const left  = createScrollButton('left');
            const right = createScrollButton('right');

            this.element.appendChild(left);
            this.element.appendChild(right);

        };

        const addListeners = () => {
            this.left.hotspot.addEventListener('click', () => {
                this.left.mouseIsOver = false;
                this.scrollLeft(true);
            });
            this.left.hotspot.addEventListener('mouseover', () => {
                this.left.mouseIsOver = true;
                this.scrollLeft(false);
            });
            this.left.hotspot.addEventListener('mouseout', () => {
                this.left.mouseIsOver = false;
            });

            this.right.hotspot.addEventListener('click', () => {
                this.right.mouseIsOver = false;
                this.scrollRight(true);
            });
            this.right.hotspot.addEventListener('mouseover', () => {
                this.right.mouseIsOver = true;
                this.scrollRight(false);
            });
            this.right.hotspot.addEventListener('mouseout', () => {
                this.right.mouseIsOver = false;
            });
        };

        await createElements();
        await addListeners();
    };

    this.init();

}

ButtonScroller.prototype = {
    scrollLeft: function(full_scroll = false) {
        // Scroll to the start position
        if (full_scroll) {
            this.scrollTo(0, this.set.settings.buttonScrollSpeed * 4);
            return;
        }

        this.scrollTo(0, null, this.left);
    },

    scrollRight: function(full_scroll = false) {
        // Scroll to the last possible position
        const max_scroll_size = this.set.buttonList.scrollWidth - this.set.buttonList.clientWidth;

        if (full_scroll) {
            this.scrollTo(max_scroll_size, this.set.settings.buttonScrollSpeed * 4);
            return;
        }

        this.scrollTo(max_scroll_size, null, this.right);
    },

    // The entry point to the scroll function
    scrollTo: function(to, speed, hover_element) {
        // Only do scrolling on horizontal tabs (not on vertical tabs or accordions)
        if (this.set.isAccordions() || this.set.isVertical()) {
            resolve();
            return;
        }

        if ( ! this.set.buttonList) {
            resolve();
            return;
        }

        clearInterval(this.stepper.interval);

        const date = new Date();

        this.stepper.to   = Math.floor(to);
        this.stepper.time = date.getTime();

        speed = speed || this.set.settings.buttonScrollSpeed;

        this.scroll(speed, hover_element);
    },

    // Don't use directly. Use scrollTo to trigger this
    scroll: function(speed, hover_element) {
        return new Promise(resolve => {
            clearInterval(this.stepper.interval);

            const position        = this.set.buttonList.scrollLeft;
            const direction       = position > this.stepper.to ? 'left' : 'right';
            const step            = direction === 'left' ? this.stepper.step * -1 : this.stepper.step;
            const max_scroll_size = this.set.buttonList.scrollWidth - this.set.buttonList.clientWidth;

            this.stepper.interval = setInterval(() => {
                if (hover_element && ! hover_element.mouseIsOver) {
                    clearInterval(this.stepper.interval);
                    resolve();
                    return;
                }

                const position = this.set.buttonList.scrollLeft;

                // The scroll position is already where we want it
                if (parseFloat(position) === this.stepper.to
                    || position === Math.floor(this.stepper.to)
                    || position === Math.ceil(this.stepper.to)
                ) {
                    clearInterval(this.stepper.interval);
                    this.set.buttonList.scrollLeft = this.stepper.to;
                    resolve();
                    return;
                }

                const date = new Date();

                let new_position = Helper.getValueByConstantSpeedEffect(
                    position,
                    date.getTime() - this.stepper.time,
                    speed,
                    step,
                    this.set.settings.buttonScrollBaseDuration
                );
                new_position     = direction === 'left'
                    ? Math.max(0, this.stepper.to, new_position)
                    : Math.min(max_scroll_size, this.stepper.to, new_position);

                this.stepper.time = date.getTime();

                this.set.buttonList.scrollLeft = new_position;
            }, 10);
        });
    },

    centerActive: function(animate = true) {
        return this.center(this.set.getActive(), animate);
    },

    center: async function(item, animate = true) {
        if (this.set.isAccordions() || this.set.isVertical()) {
            return;
        }

        if ( ! item) {
            return;
        }

        await this.update();

        const max_scroll_size = this.set.buttonList.scrollWidth - this.set.buttonList.clientWidth;

        if ( ! max_scroll_size) {
            return;
        }

        const scroll_margin = 100;

        const scroll_left  = this.set.buttonList.scrollLeft;
        const scroll_right = scroll_left + this.set.buttonList.clientWidth;

        const scroll_left_margin  = scroll_left + scroll_margin;
        const scroll_right_margin = scroll_right - scroll_margin;

        const button_left  = item.button.element.offsetLeft;
        const button_right = button_left + item.button.element.offsetWidth;

        if (button_left >= scroll_left_margin && button_right <= scroll_right_margin) {
            return;
        }

        let scroll_to = button_left - scroll_margin;

        if (button_right > scroll_right_margin) {
            // button is on the right side of the visible area
            // so scroll to the right
            scroll_to = button_right - this.set.buttonList.clientWidth + scroll_margin;
        }

        // const scroll_to = button_left - (this.set.buttonList.clientWidth / 2) + (item.button.element.offsetWidth / 2);
        //
        // const button_list_center   = this.set.buttonList.clientWidth / 2;
        // const active_button_center = item.button.element.clientWidth / 2;
        //
        // const active_button_center_offset = item.button.element.offsetLeft - this.set.buttonList.offsetLeft + active_button_center;
        //
        // let scroll_to = active_button_center_offset - button_list_center;

        // Limit scroll_to to 0 - max_scroll_size
        scroll_to = Math.min(scroll_to, max_scroll_size);
        scroll_to = Math.max(scroll_to, 0);

        if ( ! animate) {
            return this.set.buttonList.scrollLeft = scroll_to;
        }

        return this.scrollTo(scroll_to, this.set.settings.buttonScrollDuration / 2);
    },

    update: function() {
        return new Promise(resolve => {
            const css_loaded = getComputedStyle(this.set.buttonList).display !== 'block';

            if ( ! css_loaded) {
                setTimeout(() => {
                    this.update();
                }, 100);
                return;
            }

            if (this.set.parent) {
                this.set.parent.panel.element.style.display = 'block';
            }

            if (this.set.getData('alignment') === 'center') {
                this.set.setData('alignment', 'left');
            }

            const max_scroll_size = this.set.buttonList.scrollWidth - this.set.buttonList.clientWidth;
            const height          = parseFloat(getComputedStyle(this.set.buttonList).height);
            const scroll_left     = Math.ceil(this.set.buttonList.scrollLeft);

            if (this.set.parent) {
                this.set.parent.panel.element.style.display = '';
            }

            if (max_scroll_size <= 0) {
                this.set.setData('alignment', this.set.alignment);

                this.left.hotspot.classList.add('hidden');
                this.right.hotspot.classList.add('hidden');

                this.set.setData('button-scroller', 'ready');
                return;
            }

            this.left.hotspot.classList.toggle('hidden', scroll_left <= 0);
            this.right.hotspot.classList.toggle('hidden', scroll_left >= max_scroll_size);

            this.element.style.height = `${height}px`;

            this.set.setData('button-scroller', 'ready');

            resolve();
        });
    },
};
