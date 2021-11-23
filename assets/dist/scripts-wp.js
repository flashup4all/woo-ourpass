"use strict";function _typeof(a){"@babel/helpers - typeof";return _typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(a){return typeof a}:function(a){return a&&"function"==typeof Symbol&&a.constructor===Symbol&&a!==Symbol.prototype?"symbol":typeof a},_typeof(a)}function _classCallCheck(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}function _defineProperties(a,b){for(var c,d=0;d<b.length;d++)c=b[d],c.enumerable=c.enumerable||!1,c.configurable=!0,"value"in c&&(c.writable=!0),Object.defineProperty(a,c.key,c)}function _createClass(a,b,c){return b&&_defineProperties(a.prototype,b),c&&_defineProperties(a,c),a}function _inherits(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function");a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,writable:!0,configurable:!0}}),b&&_setPrototypeOf(a,b)}function _createSuper(a){var b=_isNativeReflectConstruct();return function(){var c,d=_getPrototypeOf(a);if(b){var e=_getPrototypeOf(this).constructor;c=Reflect.construct(d,arguments,e)}else c=d.apply(this,arguments);return _possibleConstructorReturn(this,c)}}function _possibleConstructorReturn(a,b){if(b&&("object"===_typeof(b)||"function"==typeof b))return b;if(void 0!==b)throw new TypeError("Derived constructors may only return object or undefined");return _assertThisInitialized(a)}function _assertThisInitialized(a){if(void 0===a)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return a}function _wrapNativeSuper(a){var b="function"==typeof Map?new Map:void 0;return _wrapNativeSuper=function(a){function c(){return _construct(a,arguments,_getPrototypeOf(this).constructor)}if(null===a||!_isNativeFunction(a))return a;if("function"!=typeof a)throw new TypeError("Super expression must either be null or a function");if("undefined"!=typeof b){if(b.has(a))return b.get(a);b.set(a,c)}return c.prototype=Object.create(a.prototype,{constructor:{value:c,enumerable:!1,writable:!0,configurable:!0}}),_setPrototypeOf(c,a)},_wrapNativeSuper(a)}function _construct(){return _construct=_isNativeReflectConstruct()?Reflect.construct:function(b,c,d){var e=[null];e.push.apply(e,c);var a=Function.bind.apply(b,e),f=new a;return d&&_setPrototypeOf(f,d.prototype),f},_construct.apply(null,arguments)}function _isNativeReflectConstruct(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],function(){})),!0}catch(a){return!1}}function _isNativeFunction(a){return-1!==Function.toString.call(a).indexOf("[native code]")}function _setPrototypeOf(a,b){return _setPrototypeOf=Object.setPrototypeOf||function(a,b){return a.__proto__=b,a},_setPrototypeOf(a,b)}function _getPrototypeOf(a){return _getPrototypeOf=Object.setPrototypeOf?Object.getPrototypeOf:function(a){return a.__proto__||Object.getPrototypeOf(a)},_getPrototypeOf(a)}(function(){if(!(void 0===window.Reflect||void 0===window.customElements||window.customElements.polyfillWrapFlushCallback)){var a=HTMLElement,b={HTMLElement:function(){return Reflect.construct(a,[],this.constructor)}};window.HTMLElement=b.HTMLElement,HTMLElement.prototype=a.prototype,HTMLElement.prototype.constructor=HTMLElement,Object.setPrototypeOf(HTMLElement,a)}})();var template=document.createElement("template");template.innerHTML="\n    <style>\n        :host {\n            display: block;\n            width: 100%;\n            height: 50px;\n            font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Oxygen, Ubuntu, Cantarell, \"Fira Sans\", \"Droid Sans\", \"Helvetica Neue\", sans-serif;\n            overflow: visible;\n            clear: both;\n        }\n        :host .wrapper {\n            position: relative;\n        }\n        :host #ourpassButton {\n            background-color: rgb(29, 188, 134);\n            border: none;\n            border-radius: 10px;\n            color: white;\n            text-align: center;\n            text-decoration: none;\n            height: 50px;\n            width: 100%;\n            display: inline-flex;\n            align-items: center;\n            justify-content: center;\n            transition-duration: 0.4s;\n            cursor: pointer;\n            opacity: 1;\n            font-weight: 500;\n            font-size: 15px;\n        }\n        :host #icon{\n            margin-right: 10px;\n            width: 35px;\n            height: 35px;\n            position: relative;\n            bottom: 1px;\n            background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjxzdmcKICAgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIgogICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIgogICB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiCiAgIHhtbG5zOnN2Zz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKICAgaWQ9InN2ZzEwIgogICB2ZXJzaW9uPSIxLjEiCiAgIGZpbGw9Im5vbmUiCiAgIHZpZXdCb3g9IjAgMCAxNjcgMTY3IgogICBoZWlnaHQ9IjE2NyIKICAgd2lkdGg9IjE2NyI+CiAgPG1ldGFkYXRhCiAgICAgaWQ9Im1ldGFkYXRhMTYiPgogICAgPHJkZjpSREY+CiAgICAgIDxjYzpXb3JrCiAgICAgICAgIHJkZjphYm91dD0iIj4KICAgICAgICA8ZGM6Zm9ybWF0PmltYWdlL3N2Zyt4bWw8L2RjOmZvcm1hdD4KICAgICAgICA8ZGM6dHlwZQogICAgICAgICAgIHJkZjpyZXNvdXJjZT0iaHR0cDovL3B1cmwub3JnL2RjL2RjbWl0eXBlL1N0aWxsSW1hZ2UiIC8+CiAgICAgIDwvY2M6V29yaz4KICAgIDwvcmRmOlJERj4KICA8L21ldGFkYXRhPgogIDxkZWZzCiAgICAgaWQ9ImRlZnMxNCIgLz4KICA8Y2lyY2xlCiAgICAgaWQ9ImNpcmNsZTIiCiAgICAgZmlsbD0iIzFEQkM4NiIKICAgICByPSI4My41IgogICAgIGN5PSI4My41IgogICAgIGN4PSI4My41IiAvPgogIDxwYXRoCiAgICAgaWQ9InBhdGg0IgogICAgIGZpbGw9IiM5QkRGQzgiCiAgICAgZD0iTTU1LjM1MTYgODkuMTQwNEw4OS4yNjI5IDU1LjI2MDlWODkuMTQwNEg1NS4zNTE2WiIKICAgICBjbGlwLXJ1bGU9ImV2ZW5vZGQiCiAgICAgZmlsbC1ydWxlPSJldmVub2RkIgogICAgIG9wYWNpdHk9IjAuNSIgLz4KICA8cGF0aAogICAgIGlkPSJwYXRoNiIKICAgICBmaWxsPSJ3aGl0ZSIKICAgICBkPSJNNjMuODMyIDEyMy4wNTRMMTIwLjM0IDY2LjU0NTdWMTIzLjA1NEg2My44MzJaIgogICAgIGNsaXAtcnVsZT0iZXZlbm9kZCIKICAgICBmaWxsLXJ1bGU9ImV2ZW5vZGQiIC8+CiAgPHBhdGgKICAgICBpZD0icGF0aDgiCiAgICAgZmlsbD0id2hpdGUiCiAgICAgZD0iTTQ2Ljg3ODkgNjYuNTQ1M0w2OS40NzU5IDQzLjk0ODRWNjYuNTQ1M0g0Ni44Nzg5WiIKICAgICBjbGlwLXJ1bGU9ImV2ZW5vZGQiCiAgICAgZmlsbC1ydWxlPSJldmVub2RkIiAvPgo8L3N2Zz4K');\n            background-size: contain;\n            background-repeat: no-repeat;\n        }\n    </style>\n\n    <div class=\"wrapper\">\n        <button id=\"ourpassButton\">\n            <span>Checkout with OurPass</span>\n            <div id=\"icon\" alt=\"OurPass Secured Checkout\"></div>\n        </button>\n    </div>\n";var OurPassCartCheckoutButton=function(a){function b(){var a;return _classCallCheck(this,b),a=c.call(this),a.attachShadow({mode:"open"}),a.shadowRoot.appendChild(template.content.cloneNode(!0)),a}_inherits(b,a);var c=_createSuper(b);return _createClass(b,[{key:"connectedCallback",value:function connectedCallback(){var a=this;this.shadowRoot.querySelector("#ourpassButton").addEventListener("click",function(){return a.startCheckoutProcess()})}},{key:"disconnectedCallback",value:function disconnectedCallback(){this.shadowRoot.querySelector("#ourpassButton").removeEventListener()}},{key:"displayErrorMessage",value:function displayErrorMessage(){0<arguments.length&&void 0!==arguments[0]?arguments[0]:""}},{key:"handleCompletedOrder",value:function handleCompletedOrder(){var a=new URL(window.location.href);a.searchParams.append("ourpass_order_created","1"),window.location.assign(a.toString())}},{key:"startCheckoutProcess",value:function startCheckoutProcess(){var a=this;jQuery("body").block({message:null,overlayCSS:{background:"#fff",opacity:.6},css:{cursor:"wait"}}),jQuery.ajax({method:"GET",url:"/wp-json/wc/ourpass/v1/cart/data",beforeSend:function beforeSend(b){b.setRequestHeader("X-WP-Nonce",a.getAttribute("wp_nonce"))}}).success(function(b){OurpassCheckout.openIframe({env:b.data.env,api_key:b.data.api_key,reference:b.data.reference,amount:b.data.amount,qty:1,name:b.data.name,email:b.data.email,description:b.data.description,src:b.data.src,url:b.data.url,items:b.data.items,metadata:b.data.metadata,onSuccess:function onSuccess(){jQuery.ajax({method:"POST",url:"/wp-json/wc/ourpass/v1/order",data:{reference:b.data.reference},beforeSend:function beforeSend(b){b.setRequestHeader("X-WP-Nonce",a.getAttribute("wp_nonce"))}}).success(function(b){return b.success?void a.handleCompletedOrder():void(a.displayErrorMessage("Error, please try again"),jQuery("body").unblock())}).error(function(b){console.log(b),a.displayErrorMessage("Error, please try again"),jQuery("body").unblock()})},onClose:function onClose(){a.displayErrorMessage("Error, please try again"),jQuery("body").unblock()}})}).error(function(b){a.displayErrorMessage(b.responseJSON.message),jQuery("body").unblock()})}}]),b}(_wrapNativeSuper(HTMLElement));window.customElements.define("ourpass-cart-checkout-button",OurPassCartCheckoutButton);var productTemplate=document.createElement("template");productTemplate.innerHTML="\n    <style>\n        :host {\n            display: block;\n            width: 100%;\n            height: 50px;\n            font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Oxygen, Ubuntu, Cantarell, \"Fira Sans\", \"Droid Sans\", \"Helvetica Neue\", sans-serif;\n            overflow: visible;\n            clear: both;\n        }\n        :host .wrapper {\n            position: relative;\n        }\n        :host([hidden]) .wrapper {\n            display: none;\n        }\n\n        :host([invalid]) .tooltip {\n            display: block;\n        }\n        :host .tooltip {\n            display: none;\n            position: absolute;\n            bottom: calc(100% + 32px);\n            left: 50%;\n            transform: translateX(-50%);\n            background: #FFFFFF;\n            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.08);\n            border-radius: 6px;\n            padding: 24px;\n            font-size: 16px;\n            color: #000000;\n            font-weight: 500;\n            white-space: nowrap;\n            z-index: 9999;\n        }\n        :host .tooltip:before {\n            position: absolute;\n            top: calc(100% - 16px);\n            left: 50%;\n            transform: translateX(-50%) rotate(45deg);\n            content: '';\n            height: 30px;\n            width: 30px;\n            background: #FFFFFF;\n            box-shadow: 8px 8px 7px rgba(0, 0, 0, 0.08);\n        }\n\n        :host .tooltip img {\n            margin-right: 24px;\n            vertical-align: middle;\n            }\n        :host #ourpassButton {\n            background-color: rgb(29, 188, 134);\n            border: none;\n            border-radius: 10px;\n            color: white;\n            text-align: center;\n            text-decoration: none;\n            height: 50px;\n            width: 100%;\n            display: inline-flex;\n            align-items: center;\n            justify-content: center;\n            transition-duration: 0.4s;\n            cursor: pointer;\n            opacity: 1;\n            font-weight: 500;\n            font-size: 15px;\n        }\n        :host #icon{\n            margin-right: 10px;\n            width: 35px;\n            height: 35px;\n            position: relative;\n            bottom: 1px;\n            background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjxzdmcKICAgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIgogICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIgogICB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiCiAgIHhtbG5zOnN2Zz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKICAgaWQ9InN2ZzEwIgogICB2ZXJzaW9uPSIxLjEiCiAgIGZpbGw9Im5vbmUiCiAgIHZpZXdCb3g9IjAgMCAxNjcgMTY3IgogICBoZWlnaHQ9IjE2NyIKICAgd2lkdGg9IjE2NyI+CiAgPG1ldGFkYXRhCiAgICAgaWQ9Im1ldGFkYXRhMTYiPgogICAgPHJkZjpSREY+CiAgICAgIDxjYzpXb3JrCiAgICAgICAgIHJkZjphYm91dD0iIj4KICAgICAgICA8ZGM6Zm9ybWF0PmltYWdlL3N2Zyt4bWw8L2RjOmZvcm1hdD4KICAgICAgICA8ZGM6dHlwZQogICAgICAgICAgIHJkZjpyZXNvdXJjZT0iaHR0cDovL3B1cmwub3JnL2RjL2RjbWl0eXBlL1N0aWxsSW1hZ2UiIC8+CiAgICAgIDwvY2M6V29yaz4KICAgIDwvcmRmOlJERj4KICA8L21ldGFkYXRhPgogIDxkZWZzCiAgICAgaWQ9ImRlZnMxNCIgLz4KICA8Y2lyY2xlCiAgICAgaWQ9ImNpcmNsZTIiCiAgICAgZmlsbD0iIzFEQkM4NiIKICAgICByPSI4My41IgogICAgIGN5PSI4My41IgogICAgIGN4PSI4My41IiAvPgogIDxwYXRoCiAgICAgaWQ9InBhdGg0IgogICAgIGZpbGw9IiM5QkRGQzgiCiAgICAgZD0iTTU1LjM1MTYgODkuMTQwNEw4OS4yNjI5IDU1LjI2MDlWODkuMTQwNEg1NS4zNTE2WiIKICAgICBjbGlwLXJ1bGU9ImV2ZW5vZGQiCiAgICAgZmlsbC1ydWxlPSJldmVub2RkIgogICAgIG9wYWNpdHk9IjAuNSIgLz4KICA8cGF0aAogICAgIGlkPSJwYXRoNiIKICAgICBmaWxsPSJ3aGl0ZSIKICAgICBkPSJNNjMuODMyIDEyMy4wNTRMMTIwLjM0IDY2LjU0NTdWMTIzLjA1NEg2My44MzJaIgogICAgIGNsaXAtcnVsZT0iZXZlbm9kZCIKICAgICBmaWxsLXJ1bGU9ImV2ZW5vZGQiIC8+CiAgPHBhdGgKICAgICBpZD0icGF0aDgiCiAgICAgZmlsbD0id2hpdGUiCiAgICAgZD0iTTQ2Ljg3ODkgNjYuNTQ1M0w2OS40NzU5IDQzLjk0ODRWNjYuNTQ1M0g0Ni44Nzg5WiIKICAgICBjbGlwLXJ1bGU9ImV2ZW5vZGQiCiAgICAgZmlsbC1ydWxlPSJldmVub2RkIiAvPgo8L3N2Zz4K');\n            background-size: contain;\n            background-repeat: no-repeat;\n        }\n    </style>\n\n    <div class=\"wrapper\">\n        <div class=\"tooltip\">\n            <img src=\"data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMTgiIHZpZXdCb3g9IjAgMCAyMCAxOCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xOC42MjczIDE3LjUwMjdIMS4zODM2OUMxLjE4NDI0IDE3LjUwMjYgMC45ODg0MDQgMTcuNDQ5NSAwLjgxNjIzNyAxNy4zNDg4QzAuNjQ0MDcgMTcuMjQ4MSAwLjUwMTc1OSAxNy4xMDM1IDAuNDAzODc1IDE2LjkyOTdDMC4zMDU5OTEgMTYuNzU1OSAwLjI1NjA1MSAxNi41NTkyIDAuMjU5MTcxIDE2LjM1OThDMC4yNjIyOSAxNi4xNjA0IDAuMzE4MzU2IDE1Ljk2NTQgMC40MjE2MjggMTUuNzk0N0w5LjA0MzQ0IDEuNTQwNjdDOS4xNDM1NCAxLjM3NTA3IDkuMjg0NjggMS4yMzgxMiA5LjQ1MzIyIDEuMTQzMDZDOS42MjE3NiAxLjA0Nzk5IDkuODExOTggMC45OTgwNDcgMTAuMDA1NSAwLjk5ODA0N0MxMC4xOTkgMC45OTgwNDcgMTAuMzg5MiAxLjA0Nzk5IDEwLjU1NzcgMS4xNDMwNkMxMC43MjYzIDEuMjM4MTIgMTAuODY3NCAxLjM3NTA3IDEwLjk2NzUgMS41NDA2N0wxOS41ODk0IDE1Ljc5NDdDMTkuNjkyNiAxNS45NjU0IDE5Ljc0ODcgMTYuMTYwNCAxOS43NTE4IDE2LjM1OThDMTkuNzU1IDE2LjU1OTIgMTkuNzA1IDE2Ljc1NTkgMTkuNjA3MSAxNi45Mjk3QzE5LjUwOTIgMTcuMTAzNSAxOS4zNjY5IDE3LjI0ODEgMTkuMTk0OCAxNy4zNDg4QzE5LjAyMjYgMTcuNDQ5NSAxOC44MjY4IDE3LjUwMjYgMTguNjI3MyAxNy41MDI3VjE3LjUwMjdaTTEwLjAwNTUgMTYuMDA3NUMxMC4yMjggMTYuMDA3NSAxMC40NDU1IDE1Ljk0MTYgMTAuNjMwNSAxNS44MTc5QzEwLjgxNTUgMTUuNjk0MyAxMC45NTk3IDE1LjUxODYgMTEuMDQ0OCAxNS4zMTMxQzExLjEzIDE1LjEwNzUgMTEuMTUyMyAxNC44ODEzIDExLjEwODggMTQuNjYzMUMxMS4wNjU0IDE0LjQ0NDggMTAuOTU4MyAxNC4yNDQ0IDEwLjgwMSAxNC4wODdDMTAuNjQzNiAxMy45Mjk3IDEwLjQ0MzIgMTMuODIyNiAxMC4yMjQ5IDEzLjc3OTJDMTAuMDA2NyAxMy43MzU3IDkuNzgwNTEgMTMuNzU4IDkuNTc0OTUgMTMuODQzMkM5LjM2OTM4IDEzLjkyODMgOS4xOTM2OCAxNC4wNzI1IDkuMDcwMDYgMTQuMjU3NUM4Ljk0NjQ1IDE0LjQ0MjUgOC44ODA0NiAxNC42NiA4Ljg4MDQ2IDE0Ljg4MjVDOC44ODA0NiAxNS4xODA5IDguOTk4OTkgMTUuNDY3MSA5LjIwOTk3IDE1LjY3OEM5LjQyMDk1IDE1Ljg4OSA5LjcwNzEgMTYuMDA3NSAxMC4wMDU1IDE2LjAwNzVWMTYuMDA3NVpNMTAuNzU0OSA1LjUwNzUzSDkuMjYyODJDOS4yMTEzNiA1LjUwNjkzIDkuMTYwMzIgNS41MTY4MiA5LjExMjgyIDUuNTM2NkM5LjA2NTMxIDUuNTU2MzggOS4wMjIzNCA1LjU4NTYzIDguOTg2NTEgNS42MjI1N0M4Ljk1MDY4IDUuNjU5NSA4LjkyMjc2IDUuNzAzMzYgOC45MDQ0NSA1Ljc1MTQ0QzguODg2MTMgNS43OTk1MyA4Ljg3NzggNS44NTA4NSA4Ljg3OTk4IDUuOTAyMjZMOS4yMjI5OSAxMi4yNzczQzkuMjI5MjUgMTIuMzc0MiA5LjI3MjQzIDEyLjQ2NTEgOS4zNDM2NSAxMi41MzEyQzkuNDE0ODcgMTIuNTk3MyA5LjUwODcxIDEyLjYzMzUgOS42MDU4NyAxMi42MzI1SDEwLjQxMTlDMTAuNTA5IDEyLjYzMzUgMTAuNjAyOCAxMi41OTcyIDEwLjY3NDEgMTIuNTMxMkMxMC43NDUzIDEyLjQ2NTEgMTAuNzg4NSAxMi4zNzQyIDEwLjc5NDggMTIuMjc3M0wxMS4xMzc4IDUuOTAyMjZDMTEuMTM5OSA1Ljg1MDg1IDExLjEzMTYgNS43OTk1MyAxMS4xMTMzIDUuNzUxNDVDMTEuMDk1IDUuNzAzMzYgMTEuMDY3IDUuNjU5NTEgMTEuMDMxMiA1LjYyMjU4QzEwLjk5NTQgNS41ODU2NCAxMC45NTI0IDUuNTU2NCAxMC45MDQ5IDUuNTM2NjJDMTAuODU3NCA1LjUxNjg1IDEwLjgwNjQgNS41MDY5NyAxMC43NTQ5IDUuNTA3NTdWNS41MDc1M1oiIGZpbGw9IiNFQjU3NTciLz4KPC9zdmc+Cg==\" alt=\"warning\">\n            <span>Please fill out the missing fields</span>\n        </div>\n        <button id=\"ourpassButton\">\n            <span>Checkout with OurPass</span>\n            <div id=\"icon\" alt=\"OurPass Secured Checkout\"></div>\n        </button>\n    </div>\n";var OurPassProductCheckoutButton=function(a){function b(){var a;return _classCallCheck(this,b),a=c.call(this),a.attachShadow({mode:"open"}),a.shadowRoot.appendChild(productTemplate.content.cloneNode(!0)),a}_inherits(b,a);var c=_createSuper(b);return _createClass(b,[{key:"connectedCallback",value:function connectedCallback(){var a=this;this.shadowRoot.querySelector("#ourpassButton").addEventListener("click",function(){return a.startCheckoutProcess()}),this.shadowRoot.querySelector(".tooltip").addEventListener("click",function(){a.removeAttribute("invalid")})}},{key:"disconnectedCallback",value:function disconnectedCallback(){this.shadowRoot.querySelector("#ourpassButton").removeEventListener()}},{key:"displayErrorMessage",value:function displayErrorMessage(){0<arguments.length&&void 0!==arguments[0]?arguments[0]:""}},{key:"getCheckoutDataFromPage",value:function getCheckoutDataFromPage(){var a=this.closest("form");if(!a)return console.error("<ourpass-product-checkout-button> must be placed inside an HTML form."),{params:{}};var b={platform:"woocommerce"},c=[],d={};Array.prototype.slice.call(a.elements).forEach(function(a){if(a.name.startsWith("attribute_")){if(["checkbox","radio"].includes(a.type)&&!a.checked)return;a.value&&(d[a.name]=a.value)}}),0<d.length&&(b.option_values=d);var e=a.querySelector("input[name='variation_id']");if(e){var g=e.value;g&&"0"!==g?b.variant_id=g:c.push("variation_id"),b.product_id=a.querySelector("input[name='product_id']").value}else{var h=a.querySelector("*[name='add-to-cart']");if(!h)return console.error("No product_id in variation_id nor add-to-cart"),{params:{}};b.product_id=h.value}var f=a.querySelector("input[name='quantity']");return f?f.validity.valid?b.quantity=+f.value||1:c.push("quantity"):b.quantity=1,{invalidFields:c,params:b}}},{key:"startCheckoutProcess",value:function startCheckoutProcess(){var a=this;this.removeAttribute("invalid","invalid");var b=this.getCheckoutDataFromPage();return 0<b.invalidFields.length?void this.setAttribute("invalid","invalid"):void(jQuery("body").block({message:null,overlayCSS:{background:"#fff",opacity:.6},css:{cursor:"wait"}}),jQuery.ajax({method:"GET",url:"/wp-json/wc/ourpass/v1/product/data",data:{productId:b.params.product_id,variationId:b.params.variation_id,quantity:b.params.quantity,atttributesValues:b.params.option_values},beforeSend:function beforeSend(b){b.setRequestHeader("X-WP-Nonce",a.getAttribute("wp_nonce"))}}).success(function(b){OurpassCheckout.openIframe({env:b.data.env,api_key:b.data.api_key,reference:b.data.reference,amount:b.data.amount,discount:b.data.discount,qty:1,name:b.data.name,email:b.data.email,description:b.data.description,src:b.data.src,url:b.data.url,items:b.data.items,metadata:b.data.metadata,onSuccess:function onSuccess(){jQuery.ajax({method:"POST",url:"/wp-json/wc/ourpass/v1/order",data:{reference:b.data.reference},beforeSend:function beforeSend(b){b.setRequestHeader("X-WP-Nonce",a.getAttribute("wp_nonce"))}}).success(function(b){return b.success?void jQuery("body").unblock():void(a.displayErrorMessage("Error, please try again"),jQuery("body").unblock())}).error(function(){a.displayErrorMessage("Error, please try again"),jQuery("body").unblock()})},onClose:function onClose(){a.displayErrorMessage("Error, please try again"),jQuery("body").unblock()}})}).error(function(b){a.displayErrorMessage(b.responseJSON.message),jQuery("body").unblock()}))}}]),b}(_wrapNativeSuper(HTMLElement));window.customElements.define("ourpass-product-checkout-button",OurPassProductCheckoutButton);