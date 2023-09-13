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

export const Helper = {
    createElementFromHTML: function(htmlString, element_type) {
        var div = document.createElement('div');

        div.innerHTML = htmlString.trim();

        const element               = div.firstChild;
        element.dataset.rltaElement = element_type || '';

        return element;
    },

    getData: function(element, name) {
        const value = element.dataset[`rlta${this.pascalCase(name)}`];

        if (value === 'true') {
            return true;
        }
        if (value === 'false') {
            return false;
        }

        return value;
    },

    pascalCase: function(string) {
        return string
            .replace(/([A-Z])/g, ' $1')
            .replace(/[-_]/g, ' ')
            .toLowerCase()
            .trim()
            .replace(/\s(.)/g, function(match) {
                return match.toUpperCase();
            })
            .replace(/\s/g, '')
            .replace(/^(.)/g, function(match) {
                return match.toUpperCase();
            });
    },

    // Used for animating stuff based on the total amount of time it should take (so longer 'distances' take the same time as short distances)
    getValueByFixedDurationEffect: function(start_value, end_value, time_diff, duration) {
        if ( ! time_diff) {
            return {
                value: start_value,
            };
        }

        duration = parseFloat(duration);

        const total_movement = end_value - start_value;

        // how far are we? 0 = still at starting point, 1 = all the way to there
        // max out at 1
        const position = Math.min(1, time_diff / duration);

        const value = start_value + (total_movement * position);

        return parseFloat(value);
    },

    // Used for animating stuff based on a constant speed (so longer 'distances' take longer)
    getValueByConstantSpeedEffect: function(previous_value, time_diff, speed, step, base_duration = 500) {
        const time_ratio = time_diff / base_duration; // 1 = 1 full step, lower is smaller increments, higher is larger increments

        const increment = step * time_ratio * speed;
        const value     = previous_value + increment;

        return parseFloat(value);
    },

    getParentByMixed: function(parent) {
        parent = parent || document;
        if (typeof parent === 'string') {
            parent = document.querySelector(`#${parent}`);
        }

        return parent;
    },

    getButtonByMixed: function(button) {
        if (typeof button === 'string') {
            let id = button.toLowerCase();

            id = id.replace(/[^a-z0-9]/g, '-');
            id = id.replace(/-+/g, '-');

            if (id.indexOf('rlta-') === -1) {
                id = `rlta-${id}`;
            }

            button = document.querySelector(`#${id}`);
        }

        if ( ! button || button.rlta === undefined) {
            return false;
        }

        return button;
    },

    // prevents the given Function from being executed too many times in quick succession
    debounce: function(func, wait = 20, immediate = true) {
        let timeout;

        return function() {
            const context = this, args = arguments;

            const later = function() {
                timeout = null;

                if (immediate) {
                    return;
                }

                return func.apply(context, args);
            };

            var callNow = immediate && ! timeout;

            clearTimeout(timeout);

            timeout = setTimeout(later, wait);

            if ( ! callNow) {
                return;
            }

            return func.apply(context, args);
        };
    },

    getInterval: function(amount, speed, step = 10) {
        speed                  = parseFloat(speed);
        const duration         = (11 - speed) * step;
        const increment_per_ms = amount / duration;

        return {
            amount          : amount,
            speed           : speed,
            step            : step,
            duration        : duration,
            increment_per_ms: increment_per_ms,
        };
    },
};
