function Ourpass() {
  this.isMobileDevice = /Mobi/i.test(window.navigator.userAgent)

  this.dStyle = {
    ourpassLoaderWrapper: `
    display: flex;
    align-items: center;
    justify-content: center;
  `,
    ourpassLoaderImg: `
    height: 80px;
    width: 80px;
    animation: loader 1s 1s infinite;
    display: block;
  `,
    ourpassParentModal: `
    position: fixed;
    z-index: 99999;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(0,0,0,0.85);

  `,
    ourPassContentModalDesktop: `
    position: relative;
    background-color: rgb(254, 254, 254);
    margin: auto;
    width: calc(100% - 50px);
    height: 80%;
    display: none;
    justify-content: center;
    align-items: center;
    max-width: 740px;
    border-radius: 10px;
  `,
    ourPassContentModalMobile: `
    position: relative;
    background-color: rgb(254, 254, 254);
    margin: auto;
    padding: 0;
    border-radius: 5px;
    width: 100%;
    height: 100%;
    display: none;
    justify-content: center;
    align-items: center;
  `,
    ourpassIframe: `
    display: none;
    border: none;
    height: 100%;
    width: 100%;
    z-index: 99999;
  `,
    ourpassCloseButton: `
    color: white;
    position: absolute;
    right: -16px;
    font-size: 25px;
    font-weight: bold;
    cursor: pointer;
    top: -10px;
  `,
    ourpassCloseButtonFocus: `
    color: #000;
    text-decoration: none;
    cursor: pointer;
  `,
  }

  this.environments = {
    sandbox: {
      baseUrl: 'https://merchant-sandbox.ourpass.co'
    },
    production: {
      baseUrl: 'https://merchant.ourpass.co'
    }
  }

  this.config = {}
}

Ourpass.prototype.handleIframeLoaded = function () {
  this.removeEventListener('load', this.handleIframeLoaded, true)
  document.getElementById("ourpassLoaderWrapper").style.display = "none";
  document.getElementById("dFrame").style.display = "block";
  document.getElementById('ourPassContentModal').style.display = "block";
}

Ourpass.prototype.handleAnimation = function () {
  const loader = document.getElementById("ourpassLoaderImg");

  if (!loader) {
    // create loader
    this.createAnElement('ourpassParentModal', 'div', ['ourpassLoaderWrapper'], this.dStyle.ourpassLoaderWrapper);
    this.createAnElement('ourpassLoaderWrapper', 'img', ['ourpassLoaderImg'], this.dStyle.ourpassLoaderImg);
    document.getElementById('ourpassLoaderImg').setAttribute('src', 'https://www.ourpass.co/favicon.ico')
  }

  document.getElementById('ourpassLoaderImg').style.display = 'block'
  document.getElementById('ourpassLoaderImg').animate([
    // keyframes
    { transform: 'scale(0.7)' },
    { transform: 'scale(0.8)' },
    { transform: 'scale(0.7)' }
  ], {
    // timing options
    duration: 1000,
    iterations: Infinity
  });
  // end animation
}

Ourpass.prototype.generateIframeSrc = function () {
  const items = this.clientInfo.items ? JSON.stringify(this.clientInfo.items) : '';

  const src = `${this.config.baseUrl}/checkout/?src=${this.clientInfo.src}&items=${items}&amount=${this.clientInfo.amount}&url=${this.clientInfo.url}&name=${this.clientInfo.name}&email=${this.clientInfo.email}&qty=${this.clientInfo.qty}&description=${this.clientInfo.description}&api_key=${this.clientInfo.api_key}&reference=${this.clientInfo.reference}`;

  return src;
}

// Close Functions
// Close Button
Ourpass.prototype.g = function () {
  this.removeElement("ourpassParentModal")
  this.clientInfo.onClose()
}

// click Modal
Ourpass.prototype.closeOnModal = function () {
  if (event.target == document.getElementById("ourpassParentModal")) {
    this.g()
  }
}

// Element Creation
Ourpass.prototype.createAnElement = function (parentId, elementTag, elementId, style, html = null) {
  var modalDiv = document.createElement(elementTag)
  modalDiv.style.cssText = style
  if (html) modalDiv.innerHTML = html;

  modalDiv.setAttribute("id", elementId[0]);

  if (elementId.length > 1) modalDiv.setAttribute(`${elementId[1][0]}`, `${elementId[1][1]}`);

  if (parentId instanceof HTMLElement) {
    parentId.appendChild(modalDiv);
  } else {
    if (parentId == "pass") {
      var dParentElement = document.getElementById("button").parentNode
      dParentElement.appendChild(modalDiv);
    } else {
      document.getElementById(parentId).appendChild(modalDiv)
    }
  }

  return modalDiv
}

// Element Removal
Ourpass.prototype.removeElement = function (element) {
  if (!(element instanceof HTMLElement)) {
    element = document.getElementById(element);
  }

  if (element) {
    if (element.parentNode) {
      element.parentNode.removeChild(element);
    }
  }
}

Ourpass.prototype.openIframe = function (clientInfo) {

  //delete any previous element
  let backDropElement = document.getElementById("ourpassParentModal")

  if (!!backDropElement) {
    backDropElement.remove();
  }

  this.clientInfo = clientInfo;

  switch (clientInfo.env) {
    case 'sandbox':
      this.config = this.environments.sandbox;
      break;

    default:
      this.config = this.environments.production
      break;
  }

  // Create Backdrop Element
  backDropElement = this.createAnElement(
    document.getElementsByTagName("body")[0],
    "div",
    ["ourpassParentModal"],
    this.dStyle.ourpassParentModal
  );

  // Create Modal-Content card
  const ourPassContentModal = this.createAnElement("ourpassParentModal", "div", ["ourPassContentModal"]);

  // Create close button
  const ourpassCloseButton = this.createAnElement(
    "ourPassContentModal",
    "span",
    ["ourpassCloseButton",
      ["onclick", "OurpassCheckout.g()"]],
    this.dStyle.ourpassCloseButton,
    "&times;"
  );

  this.handleAnimation()

  if (this.isMobileDevice) {
    ourPassContentModal.style.cssText = this.dStyle.ourPassContentModalMobile;
    ourpassCloseButton.style.display = 'none';
  } else {
    this.dStyle.ourpassIframe = `${this.dStyle.ourpassIframe}border-radius: 10px;`;
    ourPassContentModal.style.cssText = this.dStyle.ourPassContentModalDesktop;
  }

  // Create Iframe
  var ourpassIframe = this.createAnElement(
    "ourPassContentModal",
    "iframe",
    ["dFrame", ["src", this.generateIframeSrc()]],
    this.dStyle.ourpassIframe
  )

  // window.OncloseData = clientInfo.onClose

  // iframeData(document.getElementById("ourpassParentModal"), clientInfo)

  ourpassIframe.addEventListener('load', this.handleIframeLoaded, true)

  window.addEventListener('message', (event) => {
    if (this.config.baseUrl === event.origin) {
      if (event.data == 'false pass') {
        this.removeElement(backDropElement)
        this.clientInfo.onClose()
      }

      if (event.data == 'false pass1') {
        this.removeElement(backDropElement)
        this.clientInfo.onSuccess(clientInfo)
      }
    }
  })
}

window.OurpassCheckout = new Ourpass();