/**
 * @license
 * Copyright (c) 2016 The Polymer Project Authors. All rights reserved.
 * This code may only be used under the BSD style license found at http://polymer.github.io/LICENSE.txt
 * The complete set of authors may be found at http://polymer.github.io/AUTHORS.txt
 * The complete set of contributors may be found at http://polymer.github.io/CONTRIBUTORS.txt
 * Code distributed by Google as part of the polymer project is also
 * subject to an additional IP rights grant found at http://polymer.github.io/PATENTS.txt
 */

/**
 * This shim allows elements written in, or compiled to, ES5 to work on native
 * implementations of Custom Elements v1. It sets new.target to the value of
 * this.constructor so that the native HTMLElement constructor can access the
 * current under-construction element's definition.
 */
(function() {
  if (
    // No Reflect, no classes, no need for shim because native custom elements
    // require ES2015 classes or Reflect.
    window.Reflect === undefined ||
    window.customElements === undefined ||
    // The webcomponentsjs custom elements polyfill doesn't require
    // ES2015-compatible construction (`super()` or `Reflect.construct`).
    window.customElements.polyfillWrapFlushCallback
  ) {
    return;
  }
  const BuiltInHTMLElement = HTMLElement;
  /**
   * With jscompiler's RECOMMENDED_FLAGS the function name will be optimized away.
   * However, if we declare the function as a property on an object literal, and
   * use quotes for the property name, then closure will leave that much intact,
   * which is enough for the JS VM to correctly set Function.prototype.name.
   */
  const wrapperForTheName = {
    'HTMLElement': /** @this {!Object} */ function HTMLElement() {
      return Reflect.construct(
          BuiltInHTMLElement, [], /** @type {!Function} */ (this.constructor));
    }
  };
  window.HTMLElement = wrapperForTheName['HTMLElement'];
  HTMLElement.prototype = BuiltInHTMLElement.prototype;
  HTMLElement.prototype.constructor = HTMLElement;
  Object.setPrototypeOf(HTMLElement, BuiltInHTMLElement);
})();

const template = document.createElement('template');
template.innerHTML = `
    <style>
        :host {
            display: block;
            width: 100%;
            height: 50px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            overflow: visible;
            clear: both;
        }
        :host .wrapper {
            position: relative;
        }
        :host #ourpassButton {
            background-color: rgb(29, 188, 134);
            border: none;
            border-radius: 10px;
            color: white;
            text-align: center;
            text-decoration: none;
            height: 50px;
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition-duration: 0.4s;
            cursor: pointer;
            opacity: 1;
            font-weight: 500;
            font-size: 15px;
        }
        :host #icon{
            margin-right: 10px;
            width: 35px;
            height: 35px;
            position: relative;
            bottom: 1px;
            background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjxzdmcKICAgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIgogICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIgogICB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiCiAgIHhtbG5zOnN2Zz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKICAgaWQ9InN2ZzEwIgogICB2ZXJzaW9uPSIxLjEiCiAgIGZpbGw9Im5vbmUiCiAgIHZpZXdCb3g9IjAgMCAxNjcgMTY3IgogICBoZWlnaHQ9IjE2NyIKICAgd2lkdGg9IjE2NyI+CiAgPG1ldGFkYXRhCiAgICAgaWQ9Im1ldGFkYXRhMTYiPgogICAgPHJkZjpSREY+CiAgICAgIDxjYzpXb3JrCiAgICAgICAgIHJkZjphYm91dD0iIj4KICAgICAgICA8ZGM6Zm9ybWF0PmltYWdlL3N2Zyt4bWw8L2RjOmZvcm1hdD4KICAgICAgICA8ZGM6dHlwZQogICAgICAgICAgIHJkZjpyZXNvdXJjZT0iaHR0cDovL3B1cmwub3JnL2RjL2RjbWl0eXBlL1N0aWxsSW1hZ2UiIC8+CiAgICAgIDwvY2M6V29yaz4KICAgIDwvcmRmOlJERj4KICA8L21ldGFkYXRhPgogIDxkZWZzCiAgICAgaWQ9ImRlZnMxNCIgLz4KICA8Y2lyY2xlCiAgICAgaWQ9ImNpcmNsZTIiCiAgICAgZmlsbD0iIzFEQkM4NiIKICAgICByPSI4My41IgogICAgIGN5PSI4My41IgogICAgIGN4PSI4My41IiAvPgogIDxwYXRoCiAgICAgaWQ9InBhdGg0IgogICAgIGZpbGw9IiM5QkRGQzgiCiAgICAgZD0iTTU1LjM1MTYgODkuMTQwNEw4OS4yNjI5IDU1LjI2MDlWODkuMTQwNEg1NS4zNTE2WiIKICAgICBjbGlwLXJ1bGU9ImV2ZW5vZGQiCiAgICAgZmlsbC1ydWxlPSJldmVub2RkIgogICAgIG9wYWNpdHk9IjAuNSIgLz4KICA8cGF0aAogICAgIGlkPSJwYXRoNiIKICAgICBmaWxsPSJ3aGl0ZSIKICAgICBkPSJNNjMuODMyIDEyMy4wNTRMMTIwLjM0IDY2LjU0NTdWMTIzLjA1NEg2My44MzJaIgogICAgIGNsaXAtcnVsZT0iZXZlbm9kZCIKICAgICBmaWxsLXJ1bGU9ImV2ZW5vZGQiIC8+CiAgPHBhdGgKICAgICBpZD0icGF0aDgiCiAgICAgZmlsbD0id2hpdGUiCiAgICAgZD0iTTQ2Ljg3ODkgNjYuNTQ1M0w2OS40NzU5IDQzLjk0ODRWNjYuNTQ1M0g0Ni44Nzg5WiIKICAgICBjbGlwLXJ1bGU9ImV2ZW5vZGQiCiAgICAgZmlsbC1ydWxlPSJldmVub2RkIiAvPgo8L3N2Zz4K');
            background-size: contain;
            background-repeat: no-repeat;
        }
    </style>

    <div class="wrapper">
        <button id="ourpassButton">
            <span>Checkout with OurPass</span>
            <div id="icon" alt="OurPass Secured Checkout"></div>
        </button>
    </div>
`;

class OurPassCartCheckoutButton extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });
        this.shadowRoot.appendChild(template.content.cloneNode(true));
    }

    connectedCallback() {
        this.shadowRoot.querySelector("#ourpassButton")
            .addEventListener('click', () => this.startCheckoutProcess());
    }

    disconnectedCallback() {
        this.shadowRoot.querySelector("#ourpassButton")
            .removeEventListener();
    }

    displayErrorMessage(message = "") {

    }

    handleCompletedOrder() {
        const t = new URL(window.location.href);
            t.searchParams.append("ourpass_order_created", "1"),
            window.location.assign(t.toString())
    }

    startCheckoutProcess() {
        jQuery('body').block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            },
            css: {
                cursor: "wait"
            }
        });

        jQuery.ajax({
            method: "GET",
            url: "/wp-json/wc/ourpass/v1/cart/data",
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', this.getAttribute('wp_nonce'))
            }
        }).success((response) => {
            OurpassCheckout.openIframe({
                env: response.data.env,
                api_key: response.data.api_key,
                reference: response.data.reference,
                amount: response.data.amount,
                qty: 1,
                name: response.data.name,
                email: response.data.email,
                description: response.data.description,
                src: response.data.src,
                url: response.data.url,
                items: response.data.items,
                onSuccess: (res) => {
                    jQuery.ajax({
                        method: "POST",
                        url: "/wp-json/wc/ourpass/v1/order",
                        data: {
                            reference: response.data.reference,
                        },
                        beforeSend: (xhr) => {
                            xhr.setRequestHeader('X-WP-Nonce', this.getAttribute('wp_nonce'))
                        }
                    }).success((data) => {
                        if (data.success) {
                            this.handleCompletedOrder();
                            return;
                        }

                        this.displayErrorMessage('Error, please try again');
                        jQuery('body').unblock();

                    }).error((err) => {
                        console.log(err)
                        this.displayErrorMessage('Error, please try again');
                        jQuery('body').unblock();
                    });
                },
                onClose: () => {
                    this.displayErrorMessage('Error, please try again');
                    jQuery('body').unblock();
                }
            });


        }).error((err) => {
            this.displayErrorMessage(err.responseJSON.message);
            jQuery('body').unblock();
        })
    }
}

window.customElements.define('ourpass-cart-checkout-button', OurPassCartCheckoutButton);


//======= PRODUCT CHECKOUT =======//
const productTemplate = document.createElement('template');
productTemplate.innerHTML = `
    <style>
        :host {
            display: block;
            width: 100%;
            height: 50px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            overflow: visible;
            clear: both;
        }
        :host .wrapper {
            position: relative;
        }
        :host([hidden]) .wrapper {
            display: none;
        }

        :host([invalid]) .tooltip {
            display: block;
        }
        :host .tooltip {
            display: none;
            position: absolute;
            bottom: calc(100% + 32px);
            left: 50%;
            transform: translateX(-50%);
            background: #FFFFFF;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.08);
            border-radius: 6px;
            padding: 24px;
            font-size: 16px;
            color: #000000;
            font-weight: 500;
            white-space: nowrap;
            z-index: 9999;
        }
        :host .tooltip:before {
            position: absolute;
            top: calc(100% - 16px);
            left: 50%;
            transform: translateX(-50%) rotate(45deg);
            content: '';
            height: 30px;
            width: 30px;
            background: #FFFFFF;
            box-shadow: 8px 8px 7px rgba(0, 0, 0, 0.08);
        }

        :host .tooltip img {
            margin-right: 24px;
            vertical-align: middle;
            }
        :host #ourpassButton {
            background-color: rgb(29, 188, 134);
            border: none;
            border-radius: 10px;
            color: white;
            text-align: center;
            text-decoration: none;
            height: 50px;
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition-duration: 0.4s;
            cursor: pointer;
            opacity: 1;
            font-weight: 500;
            font-size: 15px;
        }
        :host #icon{
            margin-right: 10px;
            width: 35px;
            height: 35px;
            position: relative;
            bottom: 1px;
            background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjxzdmcKICAgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIgogICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIgogICB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiCiAgIHhtbG5zOnN2Zz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKICAgaWQ9InN2ZzEwIgogICB2ZXJzaW9uPSIxLjEiCiAgIGZpbGw9Im5vbmUiCiAgIHZpZXdCb3g9IjAgMCAxNjcgMTY3IgogICBoZWlnaHQ9IjE2NyIKICAgd2lkdGg9IjE2NyI+CiAgPG1ldGFkYXRhCiAgICAgaWQ9Im1ldGFkYXRhMTYiPgogICAgPHJkZjpSREY+CiAgICAgIDxjYzpXb3JrCiAgICAgICAgIHJkZjphYm91dD0iIj4KICAgICAgICA8ZGM6Zm9ybWF0PmltYWdlL3N2Zyt4bWw8L2RjOmZvcm1hdD4KICAgICAgICA8ZGM6dHlwZQogICAgICAgICAgIHJkZjpyZXNvdXJjZT0iaHR0cDovL3B1cmwub3JnL2RjL2RjbWl0eXBlL1N0aWxsSW1hZ2UiIC8+CiAgICAgIDwvY2M6V29yaz4KICAgIDwvcmRmOlJERj4KICA8L21ldGFkYXRhPgogIDxkZWZzCiAgICAgaWQ9ImRlZnMxNCIgLz4KICA8Y2lyY2xlCiAgICAgaWQ9ImNpcmNsZTIiCiAgICAgZmlsbD0iIzFEQkM4NiIKICAgICByPSI4My41IgogICAgIGN5PSI4My41IgogICAgIGN4PSI4My41IiAvPgogIDxwYXRoCiAgICAgaWQ9InBhdGg0IgogICAgIGZpbGw9IiM5QkRGQzgiCiAgICAgZD0iTTU1LjM1MTYgODkuMTQwNEw4OS4yNjI5IDU1LjI2MDlWODkuMTQwNEg1NS4zNTE2WiIKICAgICBjbGlwLXJ1bGU9ImV2ZW5vZGQiCiAgICAgZmlsbC1ydWxlPSJldmVub2RkIgogICAgIG9wYWNpdHk9IjAuNSIgLz4KICA8cGF0aAogICAgIGlkPSJwYXRoNiIKICAgICBmaWxsPSJ3aGl0ZSIKICAgICBkPSJNNjMuODMyIDEyMy4wNTRMMTIwLjM0IDY2LjU0NTdWMTIzLjA1NEg2My44MzJaIgogICAgIGNsaXAtcnVsZT0iZXZlbm9kZCIKICAgICBmaWxsLXJ1bGU9ImV2ZW5vZGQiIC8+CiAgPHBhdGgKICAgICBpZD0icGF0aDgiCiAgICAgZmlsbD0id2hpdGUiCiAgICAgZD0iTTQ2Ljg3ODkgNjYuNTQ1M0w2OS40NzU5IDQzLjk0ODRWNjYuNTQ1M0g0Ni44Nzg5WiIKICAgICBjbGlwLXJ1bGU9ImV2ZW5vZGQiCiAgICAgZmlsbC1ydWxlPSJldmVub2RkIiAvPgo8L3N2Zz4K');
            background-size: contain;
            background-repeat: no-repeat;
        }
    </style>

    <div class="wrapper">
        <div class="tooltip">
            <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMTgiIHZpZXdCb3g9IjAgMCAyMCAxOCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xOC42MjczIDE3LjUwMjdIMS4zODM2OUMxLjE4NDI0IDE3LjUwMjYgMC45ODg0MDQgMTcuNDQ5NSAwLjgxNjIzNyAxNy4zNDg4QzAuNjQ0MDcgMTcuMjQ4MSAwLjUwMTc1OSAxNy4xMDM1IDAuNDAzODc1IDE2LjkyOTdDMC4zMDU5OTEgMTYuNzU1OSAwLjI1NjA1MSAxNi41NTkyIDAuMjU5MTcxIDE2LjM1OThDMC4yNjIyOSAxNi4xNjA0IDAuMzE4MzU2IDE1Ljk2NTQgMC40MjE2MjggMTUuNzk0N0w5LjA0MzQ0IDEuNTQwNjdDOS4xNDM1NCAxLjM3NTA3IDkuMjg0NjggMS4yMzgxMiA5LjQ1MzIyIDEuMTQzMDZDOS42MjE3NiAxLjA0Nzk5IDkuODExOTggMC45OTgwNDcgMTAuMDA1NSAwLjk5ODA0N0MxMC4xOTkgMC45OTgwNDcgMTAuMzg5MiAxLjA0Nzk5IDEwLjU1NzcgMS4xNDMwNkMxMC43MjYzIDEuMjM4MTIgMTAuODY3NCAxLjM3NTA3IDEwLjk2NzUgMS41NDA2N0wxOS41ODk0IDE1Ljc5NDdDMTkuNjkyNiAxNS45NjU0IDE5Ljc0ODcgMTYuMTYwNCAxOS43NTE4IDE2LjM1OThDMTkuNzU1IDE2LjU1OTIgMTkuNzA1IDE2Ljc1NTkgMTkuNjA3MSAxNi45Mjk3QzE5LjUwOTIgMTcuMTAzNSAxOS4zNjY5IDE3LjI0ODEgMTkuMTk0OCAxNy4zNDg4QzE5LjAyMjYgMTcuNDQ5NSAxOC44MjY4IDE3LjUwMjYgMTguNjI3MyAxNy41MDI3VjE3LjUwMjdaTTEwLjAwNTUgMTYuMDA3NUMxMC4yMjggMTYuMDA3NSAxMC40NDU1IDE1Ljk0MTYgMTAuNjMwNSAxNS44MTc5QzEwLjgxNTUgMTUuNjk0MyAxMC45NTk3IDE1LjUxODYgMTEuMDQ0OCAxNS4zMTMxQzExLjEzIDE1LjEwNzUgMTEuMTUyMyAxNC44ODEzIDExLjEwODggMTQuNjYzMUMxMS4wNjU0IDE0LjQ0NDggMTAuOTU4MyAxNC4yNDQ0IDEwLjgwMSAxNC4wODdDMTAuNjQzNiAxMy45Mjk3IDEwLjQ0MzIgMTMuODIyNiAxMC4yMjQ5IDEzLjc3OTJDMTAuMDA2NyAxMy43MzU3IDkuNzgwNTEgMTMuNzU4IDkuNTc0OTUgMTMuODQzMkM5LjM2OTM4IDEzLjkyODMgOS4xOTM2OCAxNC4wNzI1IDkuMDcwMDYgMTQuMjU3NUM4Ljk0NjQ1IDE0LjQ0MjUgOC44ODA0NiAxNC42NiA4Ljg4MDQ2IDE0Ljg4MjVDOC44ODA0NiAxNS4xODA5IDguOTk4OTkgMTUuNDY3MSA5LjIwOTk3IDE1LjY3OEM5LjQyMDk1IDE1Ljg4OSA5LjcwNzEgMTYuMDA3NSAxMC4wMDU1IDE2LjAwNzVWMTYuMDA3NVpNMTAuNzU0OSA1LjUwNzUzSDkuMjYyODJDOS4yMTEzNiA1LjUwNjkzIDkuMTYwMzIgNS41MTY4MiA5LjExMjgyIDUuNTM2NkM5LjA2NTMxIDUuNTU2MzggOS4wMjIzNCA1LjU4NTYzIDguOTg2NTEgNS42MjI1N0M4Ljk1MDY4IDUuNjU5NSA4LjkyMjc2IDUuNzAzMzYgOC45MDQ0NSA1Ljc1MTQ0QzguODg2MTMgNS43OTk1MyA4Ljg3NzggNS44NTA4NSA4Ljg3OTk4IDUuOTAyMjZMOS4yMjI5OSAxMi4yNzczQzkuMjI5MjUgMTIuMzc0MiA5LjI3MjQzIDEyLjQ2NTEgOS4zNDM2NSAxMi41MzEyQzkuNDE0ODcgMTIuNTk3MyA5LjUwODcxIDEyLjYzMzUgOS42MDU4NyAxMi42MzI1SDEwLjQxMTlDMTAuNTA5IDEyLjYzMzUgMTAuNjAyOCAxMi41OTcyIDEwLjY3NDEgMTIuNTMxMkMxMC43NDUzIDEyLjQ2NTEgMTAuNzg4NSAxMi4zNzQyIDEwLjc5NDggMTIuMjc3M0wxMS4xMzc4IDUuOTAyMjZDMTEuMTM5OSA1Ljg1MDg1IDExLjEzMTYgNS43OTk1MyAxMS4xMTMzIDUuNzUxNDVDMTEuMDk1IDUuNzAzMzYgMTEuMDY3IDUuNjU5NTEgMTEuMDMxMiA1LjYyMjU4QzEwLjk5NTQgNS41ODU2NCAxMC45NTI0IDUuNTU2NCAxMC45MDQ5IDUuNTM2NjJDMTAuODU3NCA1LjUxNjg1IDEwLjgwNjQgNS41MDY5NyAxMC43NTQ5IDUuNTA3NTdWNS41MDc1M1oiIGZpbGw9IiNFQjU3NTciLz4KPC9zdmc+Cg==" alt="warning">
            <span>Please fill out the missing fields</span>
        </div>
        <button id="ourpassButton">
            <span>Checkout with OurPass</span>
            <div id="icon" alt="OurPass Secured Checkout"></div>
        </button>
    </div>
`;

class OurPassProductCheckoutButton extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });
        this.shadowRoot.appendChild(productTemplate.content.cloneNode(true));
    }

    connectedCallback() {
        this.shadowRoot.querySelector("#ourpassButton")
            .addEventListener('click', () => this.startCheckoutProcess());

        this.shadowRoot.querySelector(".tooltip")
            .addEventListener('click', () => {
                this.removeAttribute('invalid');
            });
    }

    disconnectedCallback() {
        this.shadowRoot.querySelector("#ourpassButton")
            .removeEventListener();
    }

    displayErrorMessage(message = "") {
        
    }

    getCheckoutDataFromPage() {
        const formElement = this.closest("form");
        if (!formElement){
            console.error("<ourpass-product-checkout-button> must be placed inside an HTML form.");
            return {
                params: {}
            };
        }
            
        const e = {
            platform: "woocommerce"
        }, invalidFields = [], attributes = {};

        Array.prototype.slice.call(formElement.elements).forEach((element => {
            if (element.name.startsWith("attribute_")) {
                if (["checkbox", "radio"].includes(element.type) && !element.checked) return;

                if(element.value) {
                    attributes[element.name] = element.value;
                }
            }
        }));

        if(attributes.length > 0) {
            e.option_values = attributes;
        }

        const variationIdElement = formElement.querySelector("input[name='variation_id']");

        if (variationIdElement) {
            const variationId = variationIdElement.value;

            variationId && "0" !== variationId ? e.variant_id = variationId : invalidFields.push("variation_id");
            
            e.product_id = formElement.querySelector("input[name='product_id']").value
        
        } else {
            const addToCart = formElement.querySelector("*[name='add-to-cart']");

            if (!addToCart) {
                console.error("No product_id in variation_id nor add-to-cart");

                return {
                    params: {}
                };
            }
                
            e.product_id = addToCart.value
        }

        const quantityElement = formElement.querySelector("input[name='quantity']");

        return quantityElement 
            ? quantityElement.validity.valid 
                ? e.quantity = Number(quantityElement.value) || 1 
                : invalidFields.push("quantity") 
            : e.quantity = 1,
        
        {
            invalidFields: invalidFields,
            params: e
        }
    }

    startCheckoutProcess() {
        this.removeAttribute('invalid', "invalid");
        const data = this.getCheckoutDataFromPage();
        
        if (data.invalidFields.length > 0) {
            this.setAttribute('invalid', "invalid");
            return;
        }
        
        jQuery('body').block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            },
            css: {
                cursor: "wait"
            }
        });

        jQuery.ajax({
            method: "GET",
            url: "/wp-json/wc/ourpass/v1/product/data",
            data: {
                productId: data.params.product_id,
                variationId: data.params.variation_id,
                quantity: data.params.quantity,
                atttributesValues: data.params.option_values
            },
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', this.getAttribute('wp_nonce'))
            }
        }).success((response) => {
            OurpassCheckout.openIframe({
                env: response.data.env,
                api_key: response.data.api_key,
                reference: response.data.reference,
                amount: response.data.amount,
                discount: response.data.discount,
                qty: 1,
                name: response.data.name,
                email: response.data.email,
                description: response.data.description,
                src: response.data.src,
                url: response.data.url,
                items: response.data.items,
                onSuccess: (res) => {
                    jQuery.ajax({
                        method: "POST",
                        url: "/wp-json/wc/ourpass/v1/order",
                        data: {
                            reference: response.data.reference,
                        },
                        beforeSend: (xhr) => {
                            xhr.setRequestHeader('X-WP-Nonce', this.getAttribute('wp_nonce'))
                        }
                    }).success((data) => {
                        if (data.success) {
                            jQuery('body').unblock();
                            return;
                        }

                        this.displayErrorMessage('Error, please try again');
                        jQuery('body').unblock();

                    }).error((err) => {
                        this.displayErrorMessage('Error, please try again');
                        jQuery('body').unblock();
                    });
                },
                onClose: () => {
                    this.displayErrorMessage('Error, please try again');
                    jQuery('body').unblock();
                }
            });
        }).error((err) => {
            this.displayErrorMessage(err.responseJSON.message);
            jQuery('body').unblock();
        })
    }
}

window.customElements.define('ourpass-product-checkout-button', OurPassProductCheckoutButton);