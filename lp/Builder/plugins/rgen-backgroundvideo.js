!function i(a,u,l){function c(t,e){if(!u[t]){if(!a[t]){var n="function"==typeof require&&require;if(!e&&n)return n(t,!0);if(s)return s(t,!0);var r=new Error("Cannot find module '"+t+"'");throw r.code="MODULE_NOT_FOUND",r}var o=u[t]={exports:{}};a[t][0].call(o.exports,function(e){return c(a[t][1][e]||e)},o,o.exports,i,a,u,l)}return u[t].exports}for(var s="function"==typeof require&&require,e=0;e<l.length;e++)c(l[e]);return c}({1:[function(e,t,n){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.isVideo=function(e){return!!r.getHolder(e)};var r=function(e){{if(e&&e.__esModule)return e;var t={};if(null!=e)for(var n in e)Object.prototype.hasOwnProperty.call(e,n)&&(t[n]=e[n]);return t.default=e,t}}(e("./Utils"))},{"./Utils":3}],2:[function(e,t,n){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var r=function(){function r(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}return function(e,t,n){return t&&r(e.prototype,t),n&&r(e,n),e}}();var o="rgen-backgroundvideo",i=novi.react.React,a=novi.react.Component,u=novi.ui.input,l=novi.ui.button,c=novi.language,s=function(e){function n(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,n);var t=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(n.__proto__||Object.getPrototypeOf(n)).call(this));return t.state={settings:{querySelector:e.settings.querySelector}},t.saveSettings=t.saveSettings.bind(t),t.onChange=t.onChange.bind(t),t.messages=c.getDataByKey(o),t}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(n,a),r(n,[{key:"componentWillReceiveProps",value:function(e){this.setState({settings:{querySelector:e.settings.querySelector}})}},{key:"render",value:function(){return i.createElement("div",null,i.createElement("span",{style:{letterSpacing:"0,0462em"}},"R.Gen Background Plugin"),i.createElement("div",{style:{fontSize:13,color:"#6E778A",marginTop:21}},this.messages.settings.inputPlaceholder),i.createElement(u,{style:{marginTop:10,width:340},value:this.state.settings.querySelector,onChange:this.onChange}),i.createElement("div",{style:{marginTop:30}},i.createElement(l,{type:"primary",messages:{textContent:this.messages.settings.submitButton},onClick:this.saveSettings})))}},{key:"onChange",value:function(e){var t=e.target.value;this.setState({settings:{querySelector:t}})}},{key:"saveSettings",value:function(){novi.plugins.settings.update(o,this.state.settings)}}]),n}();n.default=s},{}],3:[function(e,t,n){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.getHolder=function(e){return e.querySelector("[data-bgholder=video]")},n.rgenjs=function(){return document.querySelector(".viewport-frame").contentWindow.rgen};novi.utils},{}],4:[function(e,t,n){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var r=a(e("./editor/Trigger")),o=a(e("./editor/Header")),i=function(e){{if(e&&e.__esModule)return e;var t={};if(null!=e)for(var n in e)Object.prototype.hasOwnProperty.call(e,n)&&(t[n]=e[n]);return t.default=e,t}}(e("../Utils"));function a(e){return e&&e.__esModule?e:{default:e}}var u=novi.react.React,l=novi.language.getDataByKey("rgen-backgroundvideo"),c={trigger:u.createElement(r.default,null),tooltip:l.editor.tooltip,header:[u.createElement(o.default,null)],closeIcon:"submit",width:300,onSubmit:function(e,t){var n=e[0].element,r=i.rgenjs();if(e[0].src===e[0].oldSrc)return;""!==e[0].src&&(novi.element.setAttribute(n,"data-videoid",e[0].src),r.videoBg(n));""===e[0].src&&(novi.element.removeAttribute(n,"data-videoid"),novi.page.forceUpdate())},title:l.editor.title,collapsed:!1};n.default=c},{"../Utils":3,"./editor/Header":5,"./editor/Trigger":6}],5:[function(e,t,n){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var r=function(){function r(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}return function(e,t,n){return t&&r(e.prototype,t),n&&r(e,n),e}}(),i=function(e){{if(e&&e.__esModule)return e;var t={};if(null!=e)for(var n in e)Object.prototype.hasOwnProperty.call(e,n)&&(t[n]=e[n]);return t.default=e,t}}(e("../../Utils"));var a=novi.ui.icon,u=novi.ui.input,l=novi.ui.icons,c=novi.react.React,s=novi.react.Component,o=function(e){function o(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,o);var t=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(o.__proto__||Object.getPrototypeOf(o)).call(this)),n=i.getHolder(e.element),r=novi.element.getAttribute(n,"data-videoid");return t.state={src:r,oldSrc:r,element:n},t._handleLinkChange=t._handleLinkChange.bind(t),t}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(o,s),r(o,[{key:"render",value:function(){return c.createElement("div",{className:"novi-link-tool"},c.createElement(a,null,l.ICON_IFRAME),c.createElement("div",{className:"link-tool-input-warp",style:{width:210}},c.createElement(u,{onChange:this._handleLinkChange,value:this.state.src})))}},{key:"_handleLinkChange",value:function(e){var t=void 0,n=void 0,r=void 0;t=e.target.value,r=e.target.value,t.indexOf("youtube")&&(n=t.split("?v=")[1])&&n.length&&(r="http://www.youtube.com/embed/"+n),this.setState({src:r})}}]),o}();n.default=o},{"../../Utils":3}],6:[function(e,t,n){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var r=function(){function r(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}return function(e,t,n){return t&&r(e.prototype,t),n&&r(e,n),e}}();var o=novi.ui.icon,i=(novi.ui.icons,novi.react.React),a=novi.react.Component,u=i.createElement(o,null,i.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 576 512"},i.createElement("path",{d:"M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"}))),l=function(e){function t(){return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t),function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).call(this))}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,a),r(t,[{key:"render",value:function(){return u}}]),t}();n.default=l},{}],7:[function(e,t,n){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var r=function(e){{if(e&&e.__esModule)return e;var t={};if(null!=e)for(var n in e)Object.prototype.hasOwnProperty.call(e,n)&&(t[n]=e[n]);return t.default=e,t}}(e("./Utils"));var o=novi.react.React,i=(novi.ui.icons,novi.ui.icon),a=(novi.language.getDataByKey("rgen-backgroundvideo"),{trigger:o.createElement(i,null,o.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 576 512"},o.createElement("path",{d:"M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"}))),tooltip:"Reset video background",closeIcon:"submit",title:"Reset video background",collapsed:!0,onTriggerClick:function(e){var t=r.getHolder(e);if(!t)return;novi.element.removeAttribute(t,"data-videoid"),novi.page.forceUpdate()}});n.default=a},{"./Utils":3}],8:[function(e,t,n){"use strict";var r=u(e("./Settings")),o=u(e("./bg_video/IframeEditor")),i=function(e){{if(e&&e.__esModule)return e;var t={};if(null!=e)for(var n in e)Object.prototype.hasOwnProperty.call(e,n)&&(t[n]=e[n]);return t.default=e,t}}(e("./ExcerptFunction")),a=u(e("./reset"));function u(e){return e&&e.__esModule?e:{default:e}}var l="rgen-backgroundvideo",c=novi.react.React,s=novi.language,f={name:l,title:"R.Gen Background Video Plugin",description:"R.Gen Plugin for background video customization",version:"1.0.0",dependencies:{novi:"0.9.0"},defaults:{querySelector:".bg-holder",childQuerySelector:".bg-holder > *"},ui:{editor:[o.default,a.default],settings:c.createElement(r.default,null)},excerpt:i.isVideo,onLanguageChange:function(e){s.getDataByKey(l);return e}};novi.plugins.register(f)},{"./ExcerptFunction":1,"./Settings":2,"./bg_video/IframeEditor":4,"./reset":7}]},{},[8]);