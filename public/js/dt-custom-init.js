/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/dt-custom-init.js":
/*!****************************************!*\
  !*** ./resources/js/dt-custom-init.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  $(function () {
    var $table = $('#dtable');
    var model = $table.data('model');
    $table.DataTable({
      responsive: true,
      searching: true,
      dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
      lengthMenu: [5, 10, 25, 50],
      pageLength: 10,
      order: [],
      language: {
        'lengthMenu': 'Rodyti _MENU_'
      },
      columnDefs: [{
        targets: -1,
        title: 'Veiksmai',
        orderable: false,
        className: 'nowrap',
        'type': 'html',
        'render': function render(data, type, row) {
          return "\n                            <div class=\"d-flex\">\n                                <a href=\"contracts/".concat(row.DT_RowData.contractid, "/edit\" data-toggle=\"confirmation\" class=\"btn btn-sm btn-clean btn-icon btn-icon-md\">\n                                    <i class=\"la la-edit\"></i>\n                                </a>\n                                <div class=\"action-confirmation\">\n                                    <button type=\"button\" class=\"btn btn-sm btn-clean btn-icon btn-icon-md confirm_action\">\n                                        <i class=\"la la-trash\"></i>\n                                    </button>\n                                    <div class=\"confirm-block\">\n                                        <form action=\"contracts/").concat(row.DT_RowData.contractid, "\" method=\"post\">\n                                            <input type=\"hidden\" name=\"_token\" value=\"").concat(window.CSRF, "\">\n                                            <input type=\"hidden\" name=\"_method\" value=\"DELETE\">\n                                            <div>\n                                                <div class=\"d-flex\">\n                                                    <button type=\"submit\" rel=\"tooltip\" data-toggle=\"confirmation\" class=\"btn btn-sm btn-danger mr-1\">\n                                                        Trinti\n                                                    </button>\n                                                    <button type=\"button\" rel=\"tooltip\" data-toggle=\"confirmation\" class=\"btn btn-sm btn-clean close_confirmation\">\n                                                        At\u0161aukti\n                                                    </button>\n                                                </div>\n                                            </div>\n                                        </form>\n                                    </div>\n                                </div>\n                            </div>\n                        ");
        }
      }],
      'processing': true,
      'serverSide': true,
      'ajax': "".concat(model, "/json")
    });
  });
})(window.jQuery);

/***/ }),

/***/ 4:
/*!**********************************************!*\
  !*** multi ./resources/js/dt-custom-init.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/romas/Projects/VALET/termscrm/resources/js/dt-custom-init.js */"./resources/js/dt-custom-init.js");


/***/ })

/******/ });