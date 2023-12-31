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
import {ButtonScroller} from './button_scroller.js?1.5.0';
import {Item} from './item.js?1.5.0';
import {Prototypes} from './prototypes.js?1.5.0';

export function Set(container, settings) {
    if ( ! (container instanceof Element)) {
        throw new Error('No button set passed in');
    }

    this.element           = container;
    this.id                = this.getData('id');
    this.store_id          = getStoreId();
    this.parent            = null;
    this.items             = [];
    this.buttonList        = null;
    this.panels            = null;
    this.buttonScroller    = null;
    this.active_item       = null;
    this.slideshow         = null;
    this.slideshow_restart = null;
    this.alignment         = null;

    this.events = [];

    this.settings = {
        type                    : 'tabs',
        mode                    : 'click',
        animations              : '',
        orientation             : 'horizontal',
        scroll                  : 'adaptive',
        wrapButtons             : false,
        addHashToUrls           : false,
        rememberActive          : false,
        switchToAccordions      : true,
        switchBasedOn           : 'screen',
        switchBreakPoint        : 576,
        buttonScrollSpeed       : 7,
        buttonScrollBaseDuration: 500,
        animationSpeed          : 7,
        animationStepsSlide     : 50,
        animationStepsFadeOpen  : 100,
        animationStepsFadeClose : 50,
        scrollOffsetTop         : 20,
        scrollOffsetBottom      : 20,
        scrollOffsetTopNarrow   : 20,
        scrollOffsetBottomNarrow: 20,
        slideshow               : false,
        slideshowInterval       : 5000,
        slideshowRestart        : true,
        slideshowRestartTimeout : 10000,
    };

    this.templates = {
        panels    : '<div>',
        buttonList: '<div role="tablist">',
    };

    this.init = async function() {
        const setSettings = (settings) => {
            if (window.rltaSettings !== undefined && window.rltaSettings.constructor === Object) {
                this.settings = {
                    ...this.settings,
                    ...window.rltaSettings
                };
            }

            if (settings !== undefined && settings !== null && settings.constructor === Object) {
                this.settings = {
                    ...this.settings,
                    ...settings
                };
            }

            Object.entries(this.settings).forEach(([key, value]) => {
                const data_value = this.getData(key);

                if (data_value === undefined) {
                    return;
                }

                this.settings[key] = data_value;
            });

            this.alignment = this.getData('alignment');
        };

        const setElements = async () => {
            const parent = this.element.closest('[data-rlta-element="panel"]');
            if (parent) {
                this.parent = parent.rlta.item;
            }

            await this.element.querySelectorAll(':scope > [data-rlta-element="button"]').forEach(button => {
                this.items.push(new Item(button.id, this));
            });

            this.buttonList = await Helper.createElementFromHTML(
                this.templates.buttonList,
                'button-list'
            );

            this.buttonScroller = new ButtonScroller(this);
        };

        const createEvents = () => {
            this.events.ready = new CustomEvent('rlta.ready', {bubbles: true, detail: this});
        };

        const addListeners = () => {
            window.addEventListener('resize', () => this.handleResize(), false);

            if (this.parent) {
                this.parent.panel.element.addEventListener('rlta.open', () => this.handleResize(), false);
            }

            this.buttonList.addEventListener('scroll', () => Helper.debounce(this.buttonScroller.update()), false);

            window.onbeforeprint = () => {
                this.convertToAccordions();
            }
        };

        await setSettings(settings);
        await setElements();
        await this.handleResize();

        this.setActive(this.getActiveBySelectedButton());

        let active_item = this.getActiveFromUrl();

        if (active_item) {
            active_item.open({scroll: this.settings.scrollOnUrls, focus: false, animate: false});
        }

        if ( ! active_item && this.settings.rememberActive) {
            active_item = this.getStoredActive();
            active_item && active_item.openNoAnimate();
        }

        if ( ! this.active_item) {
            this.setActive(this.getActiveBySelectedButton());
        }

        this.setState('ready');

        await createEvents();
        await addListeners();

        this.buttonScroller.centerActive(false);


        this.element.dispatchEvent(this.events.ready);
    };

    this.init(settings);

    function getStoreId() {
        const url = location.href
            .replace(origin, '')
            .replace('index.php', '')
            .replace(/^\/+/, '');

        // convert all characters to a number
        // 0 => 8, 1 => 9, 3 => 0, ...
        // A => 5, B => 6, C => 7, ...
        // a => 7, b => 8, c => 9, ...
        const id = url.split('').map(char => char.charCodeAt() % 10).join('');

        return `rlta.${id}`;
    }
}

Set.prototype = {
    handleButtonSelect: function(event) {
        this.stopSlideshow();
        event.currentTarget.rlta.item.toggle();
    },

    handleButtonKeyUp: function(event) {
        switch (event.keyCode) {
            case 9: // tab
                event.currentTarget.rlta.item.addFocus();
                break;
        }
    },

    handleButtonKeyDown: function(event) {
        this.stopSlideshow();

        switch (event.keyCode) {
            case 9: // tab
                event.currentTarget.rlta.item.removeFocus();
                break;
            case 13: // enter
                event.preventDefault();
                event.currentTarget.rlta.item.toggle(true);
                break;
            case 36: // home
                event.preventDefault();
                this.openFirst(true);
                break;
            case 35: // end
                event.preventDefault();
                this.openLast(true);
                break;

            // Up and down are in keydown event
            // because we need to prevent page scroll >:)
            case 38: // up
                if (this.isVertical()) {
                    event.preventDefault();
                    this.openPrevious();
                }
                break;

            case 40: // down
                if (this.isVertical()) {
                    event.preventDefault();
                    this.openNext();
                }
                break;

            case 37: // left
                if (this.isHorizontal()) {
                    event.preventDefault();
                    this.openPrevious();
                }
                break;

            case 39: // right
                if (this.isHorizontal()) {
                    event.preventDefault();
                    this.openNext();
                }
                break;
        }
    },

    handleResize: function() {
        if (this.settings.type === 'accordions') {
            return;
        }

        if (this.shouldSwitch()) {
            return this.convertToAccordions();
        }

        return this.convertToTabs();
    },

    removeFocus: function() {
        this.element.querySelectorAll('[data-rlta-focus="true"]').forEach(button => {
            button.rlta.item.removeFocus();
        });
    },

    shouldSwitch: function() {
        if ( ! this.settings.switchToAccordions) {
            return false;
        }

        if ( ! this.settings.switchBreakPoint) {
            return false;
        }

        const check_width = this.getSwitchElementWidth();

        return check_width < this.settings.switchBreakPoint;
    },

    isWideScreen: function() {
        if ( ! this.settings.useWideScreenScrollOffsets) {
            return false;
        }

        const check_width = this.getScrollOffsetElementWidth();

        return check_width >= this.settings.scrollOffsetBreakPoint;
    },

    getElementWidth: function(element) {
        switch (element) {
            case 'element':
                return this.element.offsetWidth;

            case 'screen':
                return screen.width;

            case 'window':
            default:
                return window.innerWidth;
        }
    },

    getSwitchElementWidth: function() {
        return this.getElementWidth(this.settings.switchBasedOn);
    },

    getScrollOffsetElementWidth: function() {
        return this.getElementWidth(this.settings.scrollOffsetBasedOn);
    },

    convertToTabs: function() {
        return new Promise(async resolve => {
            const should_have_button_scroller = this.shouldHaveButtonScroller();
            this.setData('has-button-scroller', should_have_button_scroller);

            if ( ! this.isTabs() || ! this.isReady()) {
                this.buttonList.setAttribute('aria-orientation', this.settings.orientation);

                await this.createButtonList();
                await this.groupPanels();

                this.setType('tabs');

                if (should_have_button_scroller) {
                    await this.addButtonScroller();
                }
            }

            resolve();

            if (should_have_button_scroller) {
                await this.buttonScroller.centerActive(false);

                this.buttonScroller.update();
            }
        });
    },

    shouldHaveButtonScroller: function() {
        if (this.isAccordions()) {
            return false;
        }

        if (this.settings.wrapButtons) {
            return false;
        }

        if (this.settings.orientation === 'vertical') {
            return false;
        }

        return true;
    },

    convertToAccordions: function() {
        return new Promise(async resolve => {
            if (this.isAccordions() && this.isReady()) {
                resolve();
                return;
            }

            if (this.element.contains(this.buttonList)) {
                this.element.removeChild(this.buttonList);
            }
            if (this.element.contains(this.buttonScroller.element)) {
                this.element.removeChild(this.buttonScroller.element);
            }
            if (this.element.contains(this.panels)) {
                this.element.removeChild(this.panels);
            }

            this.items.forEach(item => {
                item.setState(item.getState());

                item.button.element.setAttribute('role', 'button');
                item.panel.element.setAttribute('role', 'region');

                item.button.element.setAttribute('aria-expanded', item.button.element.getAttribute('aria-selected'));
                item.button.element.removeAttribute('aria-selected');

                if (this.isTabs()) {
                    this.element.appendChild(item.button.element);
                    this.element.appendChild(item.panel.element);
                }
            });

            this.setType('accordions');

            resolve();
        });
    },

    createButtonList: function() {
        this.items.forEach(item => {
            if (this.element === item.button.element.parentNode) {
                this.element.removeChild(item.button.element);
            }

            item.setState(item.getState());

            item.button.element.setAttribute('role', 'tab');
            item.panel.element.setAttribute('role', 'tabpanel');

            item.button.element.setAttribute('aria-selected', item.button.element.getAttribute('aria-expanded'));
            item.button.element.removeAttribute('aria-expanded');

            this.buttonList.appendChild(item.button.element);
        });

        this.element.insertBefore(this.buttonList, this.element.childNodes[0]);
    },

    groupPanels: async function() {
        if ( ! this.items.length) {
            return;
        }

        if (this.items[0].panel.element.parentNode.dataset['RltaElement'] === 'panels') {
            return;
        }

        this.panels = await Helper.createElementFromHTML(
            this.templates.panels,
            'panels'
        );

        this.items.forEach(item => {
            this.panels.appendChild(item.panel.element);
        });

        this.element.insertBefore(this.panels, this.element.childNodes[1]);
    },

    addButtonScroller: function() {
        this.element.insertBefore(this.buttonScroller.element, this.buttonList.nextSibling);
    },

    setActive: function(active_item) {
        this.active_item = active_item;
    },

    getActive: function() {
        return this.active_item;
    },

    getActiveBySelectedButton: function() {
        return this.items.find(item => item.button.isSelected());
    },

    getActiveFromUrl: function() {
        let item = this.getActiveFromUrlHash();

        if (item) {
            return item;
        }

        item = this.getActiveFromUrlParameter();

        if (item) {
            return item;
        }

        item = this.getActiveFromUrlHighlight();

        if (item) {
            return item;
        }

        return '';
    },

    getActiveFromUrlHash: function() {
        if ( ! this.settings.addHashToUrls) {
            return '';
        }

        try {
            let hash_id = decodeURIComponent(window.location.hash.replace('#', ''));

            // Ignore the url hash if it contains weird characters
            if (hash_id.indexOf('/') > -1 || hash_id.indexOf('/') > -1) {
                return '';
            }

            return this.items.find(item => (item.id === `rlta-${hash_id}`));
        } catch (err) {
            return '';
        }
    },

    getActiveFromUrlParameter: function() {
        try {
            const query_string = window.location.search;
            const url_params   = new URLSearchParams(query_string);

            const tab = url_params.get('tab');
            if (tab) {
                return this.items.find(item => (item.id === `rlta-${tab}`));
            }

            const accordion = url_params.get('accordion');
            if (accordion) {
                return this.items.find(item => (item.id === `rlta-${accordion}`));
            }

            return '';
        } catch (err) {
            return '';
        }
    },

    getActiveFromUrlHighlight: function() {
        try {
            // get first element with data-markjs="true" attribute
            const highlighted = this.element.querySelector('[data-markjs="true"]');

            if ( ! highlighted) {
                return '';
            }

            const panel = highlighted.closest('[data-rlta-element="panel"]');

            if ( ! panel) {
                return '';
            }

            // get aria-labeledby attribute from panel
            const id = panel.getAttribute('aria-labelledby');

            return this.items.find(item => (item.id === id));
        } catch (err) {
            return '';
        }
    },

    getStoredActive: function() {
        const active_items = JSON.parse(localStorage.getItem(this.store_id)) || {};

        const active_item = active_items[this.id];

        if ( ! active_item) {
            return null;
        }

        return this.items.find(item => (item.id === active_item));
    },

    storeActive: function(item) {
        if ( ! this.settings.rememberActive) {
            return;
        }

        const active_items    = JSON.parse(localStorage.getItem('rlta')) || {};
        active_items[this.id] = item.id;

        localStorage.setItem(this.store_id, JSON.stringify(active_items));
    },

    setUrlHash: function(item) {
        if ( ! this.settings.addHashToUrls) {
            return;
        }

        if ( ! item) {
            return;
        }

        window.location.hash = item.button.getData('alias');
    },

    startSlideshow: function() {
        if ( ! this.settings.slideshow) {
            return;
        }

        let interval = this.settings.slideshowInterval;

        if ( ! isNaN(this.settings.slideshow)) {
            interval = this.settings.slideshow;
        }

        // make sure timeout is not lower than 1000
        interval = Math.max(interval, 1000);

        this.slideshow = setInterval(() => {
            this.openNext({scroll: false, focus: false, hash: false}, false);
        }, interval);
    },

    stopSlideshow: function() {
        clearInterval(this.slideshow);
        clearInterval(this.slideshow_restart);

        if (this.settings.slideshowRestart) {
            this.slideshow_restart = setTimeout(() => {
                this.startSlideshow();
            }, this.settings.slideshowRestartTimeout);
        }
    },

    getFocused: function() {
        const focusedElement = document.activeElement;

        return this.items.find(item => (item.button.element === focusedElement));
    },

    getFirst: function() {
        return this.items[0];
    },

    getLast: function() {
        return this.items[this.items.length - 1];
    },

    getNext: function(includeFocused = true) {
        const activeItem = (includeFocused ? this.getFocused() : false) || this.getActive();
        const firstItem  = this.getFirst();
        const lastItem   = this.getLast();

        if ( ! activeItem) {
            return firstItem;
        }

        if (activeItem === lastItem) {
            return firstItem;
        }

        return this.items[activeItem.getIndex() + 1];
    },

    getPrevious: function(includeFocused = true) {
        const activeItem = (includeFocused ? this.getFocused() : false) || this.getActive();
        const firstItem  = this.getFirst();
        const lastItem   = this.getLast();

        if ( ! activeItem) {
            return firstItem;
        }

        if (activeItem === firstItem) {
            return lastItem;
        }

        return this.items[activeItem.getIndex() - 1];
    },

    setType: function(type) {
        this.setData('type', type);
    },

    getType: function() {
        return this.getData('type');
    },

    setState: function(state) {
        this.setData('state', state);
    },

    isAccordions: function() {
        return this.getType() === 'accordions';
    },

    isTabs: function() {
        return ! this.isAccordions();
    },

    isReady: function() {
        return this.getState() === 'ready';
    },

    isHorizontal: function() {
        return ! this.isVertical();
    },

    isVertical: function() {
        return this.buttonList.getAttribute('aria-orientation') === 'vertical';
    },

    openFirst   : function(actions) {
        return this.getFirst().open(actions);
    },
    openLast    : function(actions) {
        return this.getLast().open(actions);
    },
    openNext    : function(actions, includeFocused = true) {
        return this.getNext(includeFocused).open(actions);
    },
    openPrevious: function(actions, includeFocused = true) {
        return this.getPrevious(includeFocused).open(actions);
    },
};

Set.prototype.hasData    = Prototypes.hasData;
Set.prototype.getData    = Prototypes.getData;
Set.prototype.setData    = Prototypes.setData;
Set.prototype.removeData = Prototypes.removeData;
Set.prototype.getState   = Prototypes.getState;
