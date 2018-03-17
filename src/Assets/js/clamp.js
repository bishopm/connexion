(function () {
    'use strict';
    function clamp(element, options) {
        options = options || {};
        var win = window;
        var opt = {
            clamp:              options.clamp || 2,
            useNativeClamp:     typeof options.useNativeClamp !== 'undefined' ? options.useNativeClamp : true,
            splitOnChars:       options.splitOnChars || ['.', '-', '–', '—', ' '], //Split on sentences (periods), hypens, en-dashes, em-dashes, and words (spaces).
            animate:            options.animate || false,
            truncationChar:     options.truncationChar || '…',
            truncationHTML:     options.truncationHTML
        };
        var sty = element.style;
        var originalText = element.innerHTML;

        var supportsNativeClamp = typeof element.style.webkitLineClamp !== 'undefined';
        var clampValue = opt.clamp;
        var isCSSValue = clampValue.indexOf && (clampValue.indexOf('px') > -1 || clampValue.indexOf('em') > -1);
        var truncationHTMLContainer;

        if (opt.truncationHTML) {
            truncationHTMLContainer = document.createElement('span');
            truncationHTMLContainer.innerHTML = opt.truncationHTML;
        }
        // UTILITY FUNCTIONS __________________________________________________________
        /**
         * Return the current style for an element.
         * @param {HTMLElement} elem The element to compute.
         * @param {string} prop The style property.
         * @returns {number}
         */
        function computeStyle(elem, prop) {
            if (!win.getComputedStyle) {
                win.getComputedStyle = function (el) {
                    this.el = el;
                    this.getPropertyValue = function (prop) {
                        var re = /(\-([a-z]){1})/g;
                        if (prop === 'float') {
                            prop = 'styleFloat';
                        }
                        if (re.test(prop)) {
                            prop = prop.replace(re, function () {
                                return arguments[2].toUpperCase();
                            });
                        }
                        return el.currentStyle && el.currentStyle[prop] ? el.currentStyle[prop] : null;
                    };
                    return this;
                };
            }

            return win.getComputedStyle(elem, null).getPropertyValue(prop);
        }
        /**
         * Returns the line-height of an element as an integer.
         */
        function getLineHeight(elem) {
            var lh = computeStyle(elem, 'line-height');
            if (lh === 'normal') {
                // Normal line heights vary from browser to browser. The spec recommends
                // a value between 1.0 and 1.2 of the font size. Using 1.1 to split the diff.
                lh = parseFloat(computeStyle(elem, 'font-size')) * 1.2;
            }
            return parseFloat(lh);
        }

        /**
         * Returns the maximum number of lines of text that should be rendered based
         * on the current height of the element and the line-height of the text.
         */
        function getMaxLines(height) {
            var availHeight = height || element.clientHeight;
            var lineHeight = getLineHeight(element);
            return Math.max(Math.floor(availHeight / lineHeight), 0);
        }

        /**
         * Returns the maximum height a given element should have based on the line-
         * height of the text and the given clamp value.
         */
        function getMaxHeight(clmp) {
            var lineHeight = getLineHeight(element);
            return lineHeight * clmp;
        }

        var splitOnChars = opt.splitOnChars.slice(0);
        var splitChar = splitOnChars[0];
        var chunks;
        var lastChunk;

        /**
         * Gets an element's last child. That may be another node or a node's contents.
         */
        function getLastChild(elem) {
            //Current element has children, need to go deeper and get last child as a text node
            if (elem.lastChild.children && elem.lastChild.children.length > 0) {
                return getLastChild(Array.prototype.slice.call(elem.children).pop());
            }
            //This is the absolute last child, a text node, but something's wrong with it. Remove it and keep trying
            else if (!elem.lastChild || !elem.lastChild.nodeValue || elem.lastChild.nodeValue === '' ||
                elem.lastChild.nodeValue === opt.truncationChar) {
                elem.lastChild.parentNode.removeChild(elem.lastChild);
                return getLastChild(element);
            }
            //This is the last child we want, return it
            else {
                return elem.lastChild.nodeValue;
            }
        }

        function applyEllipsis(elem, str) {
            return str + opt.truncationChar;
        }

        /**
         * Removes one character at a time from the text until its width or
         * height is beneath the passed-in max param.
         */
        function truncate(targetValue, maxHeight) {
            if (!maxHeight) {return;}

            /**
             * Resets global variables.
             */
            function reset() {
                splitOnChars = opt.splitOnChars.slice(0);
                splitChar = splitOnChars[0];
                chunks = null;
                lastChunk = null;
            }

            var nodeValue = targetValue.replace(opt.truncationChar, '');

            //Grab the next chunks
            if (!chunks) {
                //If there are more characters to try, grab the next one
                if (splitOnChars.length > 0) {
                    splitChar = splitOnChars.shift();
                }
                //No characters to chunk by. Go character-by-character
                else {
                    splitChar = '';
                }

                chunks = nodeValue.split(splitChar);
            }

            //If there are chunks left to remove, remove the last one and see if
            // the nodeValue fits.
            if (chunks.length > 1) {
                //console.log('chunks', chunks);
                lastChunk = chunks.pop();
                //console.log('lastChunk', lastChunk);
                targetValue = applyEllipsis(targetValue, chunks.join(splitChar));
            }
            //No more chunks can be removed using this character
            else {
                chunks = null;
            }

            //Insert the custom HTML before the truncation character
            element.innerHTML = targetValue;
            if (truncationHTMLContainer) {
                targetValue = targetValue.replace(opt.truncationChar, '');
                element.innerHTML = targetValue + ' ' + truncationHTMLContainer.innerHTML + opt.truncationChar;
            }

            //Search produced valid chunks
            if (chunks) {
                //It fits
                if (element.scrollHeight <= maxHeight) {
                    //There's still more characters to try splitting on, not quite done yet
                    if (splitOnChars.length >= 0 && splitChar !== '') {
                        targetValue = applyEllipsis(targetValue, chunks.join(splitChar) + splitChar + lastChunk);
                        chunks = null;
                    }
                    //Finished!
                    else {
                        return element.innerHTML;
                    }
                }
            }
            //No valid chunks produced
            else {
                //No valid chunks even when splitting by letter, time to move
                //on to the next node
                if (splitChar === '') {
                    targetValue = applyEllipsis(targetValue, '');
                    targetValue = getLastChild(element);

                    reset();
                }
            }

            //If you get here it means still too big, let's keep truncating
            if (opt.animate) {
                setTimeout(function () {
                    truncate(targetValue, maxHeight);
                }, opt.animate === true ? 10 : opt.animate);
            } else {
                return truncate(targetValue, maxHeight);
            }
        }
        // CONSTRUCTOR ________________________________________________________________
        if (clampValue === 'auto') {
            clampValue = getMaxLines();
        } else if (isCSSValue) {
            clampValue = getMaxLines(parseInt(clampValue, 10));
        }

        var clampedText;
        if (supportsNativeClamp && opt.useNativeClamp) {
            sty.overflow = 'hidden';
            sty.textOverflow = 'ellipsis';
            sty.webkitBoxOrient = 'vertical';
            sty.display = '-webkit-box';
            sty.webkitLineClamp = clampValue;

            if (isCSSValue) {
                sty.height = opt.clamp + 'px';
            }
        } else {
            var height = Math.ceil(getMaxHeight(clampValue));
            if (height < element.scrollHeight) {
                clampedText = truncate(getLastChild(element), height);
            }
        }
        return {
            'original': originalText,
            'clamped': clampedText
        };
    }

    window.$clamp = clamp;
})();