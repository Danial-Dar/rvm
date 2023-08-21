/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=script&lang=js":
/*!*****************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      type: "all",
      show: false,
      showChat: false,
      chatData: [],
      noteNew: "",
      callId: null,
      addNote: false,
      topics: null,
      scorecards: null,
      notes: null,
      audioPath: null,
      showCalls: false,
      calls: [],
      audio: [],
      addCall: {
        agent_id: null,
        scorecard_id: null,
        file: null
      },
      currentLabel: null,
      filters: {
        groups: null,
        agents: null,
        topics: null,
        scorecards: null,
        phrases: null,
        phoneNumber: null,
        transcribed: false,
        flagged: false,
        pending: false,
        reviewed: false,
        valid: false,
        invalid: false,
        processed: false
      },
      selectedFilters: {
        groups: "",
        agents: "",
        topics: "",
        scorecards: "",
        phrases: "",
        phoneNumber: null,
        transcribed: false,
        flagged: false,
        pending: false,
        reviewed: false,
        valid: false,
        invalid: false,
        processed: false
      },
      errors: {
        agent_id: null,
        scorecard_id: null,
        file: null
      },
      showChatModal: false,
      messages: [],
      reportMessages: []
    };
  },
  mounted: function mounted() {
    this.getFilters();
    this.getCalls();
  },
  methods: {
    changeButton: function changeButton(value) {
      var _this = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              console.log(value);
              _context.next = 3;
              return Nova.request().get("/nova-api/custom/qa-call/" + value).then(function (res) {
                console.log(JSON.parse(res.data.call.json_data));
                _this.messages = JSON.parse(res.data.call.json_data);
                _this.speakerFirst = _this.messages[0].speaker[0];
                console.log(_this.speakerFirst);
                console.log(res.data.call.status);
                if (res.data.call.status == "success") {
                  _this.showChatModal = true;
                } else {
                  _this.showChatModal = false;
                }
                console.log(_this.showChatModal);
              });
            case 3:
            case "end":
              return _context.stop();
          }
        }, _callee);
      }))();
    },
    saveNote: function saveNote() {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              console.log(_this2.noteNew);
              if (!(_this2.noteNew.length > 0)) {
                _context2.next = 6;
                break;
              }
              _context2.next = 4;
              return Nova.request().post("/nova-api/audio/notes/store", {
                note: _this2.noteNew,
                call_id: _this2.callId
              }).then(function (res) {
                if (!res.data.success) {
                  Nova.error(res.data.message);
                } else {
                  Nova.success("Note Added Successfully");
                  Nova.visit("/search-calls", {
                    remote: false
                  });
                }
              });
            case 4:
              _context2.next = 7;
              break;
            case 6:
              Nova.error("Note field is empty");
            case 7:
            case "end":
              return _context2.stop();
          }
        }, _callee2);
      }))();
    },
    fileChange: function fileChange(event) {
      this.addCall.file = event.target.files[0];
      this.currentLabel = this.addCall.file.name;
      this.errors.file = null;
    },
    loadChat: function loadChat(id) {
      var _this3 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) switch (_context3.prev = _context3.next) {
            case 0:
              console.log("?????????????????????????????????????????????????????????????????????????????");
              _this3.callId = id;
              _context3.next = 4;
              return Nova.request().get("/nova-api/custom/audio/" + id).then(function (res) {
                console.log(res.data);
                _this3.chatData = res.data.chatData;
                _this3.scorecards = res.data.scorecards;
                _this3.notes = res.data.notes;
                _this3.audioPath = "https://rvm.nyc3.digitaloceanspaces.com/RVM/" + res.data.filename;
                _this3.audio = res.data.audio;
              });
            case 4:
              _this3.showChat = true;
            case 5:
            case "end":
              return _context3.stop();
          }
        }, _callee3);
      }))();
    },
    reset: function reset() {
      var _this4 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4() {
        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
          while (1) switch (_context4.prev = _context4.next) {
            case 0:
              _this4.showCalls = false;
              _context4.next = 3;
              return _this4.getCalls();
            case 3:
              _this4.selectedFilters.topics = "";
              _this4.selectedFilters.scorecards = "";
              _this4.selectedFilters.groups = "";
              _this4.selectedFilters.agents = "";
              _this4.selectedFilters.phrases = "";
              _this4.selectedFilters.pending = "";
              _this4.selectedFilters.transcribed = "";
              _this4.selectedFilters.flagged = "";
              _this4.selectedFilters.reviewed = "";
              _this4.selectedFilters.valid = "";
              _this4.selectedFilters.invalid = "";
              _this4.selectedFilters.processed = "";
              Nova.success("Filters Reset Successfully");
            case 16:
            case "end":
              return _context4.stop();
          }
        }, _callee4);
      }))();
    },
    updateFilter2: function updateFilter2(e) {
      console.log(e);
      if (e == "transcribed") {
        this.selectedFilters.pending = "";
        this.selectedFilters.flagged = "";
        this.selectedFilters.processed = "";
      } else if (e == "pending") {
        this.selectedFilters.transcribed = "";
        this.selectedFilters.flagged = "";
        this.selectedFilters.processed = "";
      } else if (e == "flagged") {
        this.selectedFilters.pending = "";
        this.selectedFilters.transcribed = "";
        this.selectedFilters.processed = "";
      } else if (e == "processed") {
        this.selectedFilters.pending = "";
        this.selectedFilters.transcribed = "";
        this.selectedFilters.flagged = "";
      }
      if (e == "valid") {
        this.selectedFilters.invalid = "";
      } else if (e == "invalid") {
        this.selectedFilters.valid = "";
      }
      this.updateFilter();
    },
    updateFilter: function updateFilter() {
      var _this5 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee5() {
        return _regeneratorRuntime().wrap(function _callee5$(_context5) {
          while (1) switch (_context5.prev = _context5.next) {
            case 0:
              _context5.next = 2;
              return Nova.request().post("/nova-api/audio/filters/" + _this5.type, _this5.selectedFilters).then(function (res) {
                if (!res.data.success) {
                  Nova.error(res.data.message);
                } else {
                  _this5.calls = null;
                  Nova.success("Filter Applied");
                  _this5.calls = res.data.calls;
                  console.log(_this5.calls);
                }
              });
            case 2:
            case "end":
              return _context5.stop();
          }
        }, _callee5);
      }))();
    },
    submit: function submit() {
      var _this6 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee6() {
        var formData;
        return _regeneratorRuntime().wrap(function _callee6$(_context6) {
          while (1) switch (_context6.prev = _context6.next) {
            case 0:
              console.log(_this6.addCall.agent_id);
              console.log(_this6.addCall.scorecard_id);
              console.log(_this6.addCall.file);
              if (_this6.addCall.agent_id === null) _this6.errors.agent_id = "Please Select Agent";
              if (_this6.addCall.scorecard_id === null) _this6.errors.scorecard_id = "Please Select Scorecard";
              if (_this6.addCall.file === null) _this6.errors.file = "Please Select File";
              if (_this6.addCall.file.type !== "audio/wav") _this6.errors.file = "File type must be wav";
              if (!(_this6.addCall.agent_id == null || _this6.addCall.scorecard_id === null || _this6.addCall.file === null)) {
                _context6.next = 9;
                break;
              }
              return _context6.abrupt("return");
            case 9:
              if (!(_this6.addCall.file.type !== "audio/wav")) {
                _context6.next = 11;
                break;
              }
              return _context6.abrupt("return");
            case 11:
              _this6.errors.agent_id = null;
              _this6.errors.scorecard_id = null;
              _this6.errors.file = null;
              formData = new FormData();
              formData.append("agent_id", _this6.addCall.agent_id);
              formData.append("scorecard_id", _this6.addCall.scorecard_id);
              formData.append("file", _this6.addCall.file);
              _context6.next = 20;
              return Nova.request().post("/nova-api/audio/create", formData).then(function (res) {
                if (!res.data.success) {
                  Nova.error(res.data.message);
                } else {
                  Nova.success("Call Added Successfully");
                  Nova.visit("/search-calls", {
                    remote: false
                  });
                }
              });
            case 20:
            case "end":
              return _context6.stop();
          }
        }, _callee6);
      }))();
    },
    getFilters: function getFilters() {
      var _this7 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee8() {
        return _regeneratorRuntime().wrap(function _callee8$(_context8) {
          while (1) switch (_context8.prev = _context8.next) {
            case 0:
              _context8.next = 2;
              return Nova.request().get("/nova-api/audio/filters").then( /*#__PURE__*/function () {
                var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee7(res) {
                  return _regeneratorRuntime().wrap(function _callee7$(_context7) {
                    while (1) switch (_context7.prev = _context7.next) {
                      case 0:
                        if (res.data.success) {
                          _this7.filters.groups = res.data.groups;
                          _this7.filters.agents = res.data.agents;
                          _this7.filters.scorecards = res.data.scorecards;
                          _this7.filters.phrases = res.data.phrases;
                          console.log("filters", _this7.filters);
                        }
                      case 1:
                      case "end":
                        return _context7.stop();
                    }
                  }, _callee7);
                }));
                return function (_x) {
                  return _ref.apply(this, arguments);
                };
              }());
            case 2:
            case "end":
              return _context8.stop();
          }
        }, _callee8);
      }))();
    },
    getCalls: function getCalls() {
      var _this8 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee10() {
        return _regeneratorRuntime().wrap(function _callee10$(_context10) {
          while (1) switch (_context10.prev = _context10.next) {
            case 0:
              _context10.next = 2;
              return Nova.request().get("/nova-api/audio/type/" + _this8.type).then( /*#__PURE__*/function () {
                var _ref2 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee9(res) {
                  return _regeneratorRuntime().wrap(function _callee9$(_context9) {
                    while (1) switch (_context9.prev = _context9.next) {
                      case 0:
                        if (res.data.calls) {
                          _this8.calls = res.data.calls;
                          _this8.showCalls = true;
                        }
                        console.log(_this8.calls);
                      case 2:
                      case "end":
                        return _context9.stop();
                    }
                  }, _callee9);
                }));
                return function (_x2) {
                  return _ref2.apply(this, arguments);
                };
              }());
            case 2:
            case "end":
              return _context10.stop();
          }
        }, _callee10);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe&scoped=true":
/*!*********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe&scoped=true ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

var _withScopeId = function _withScopeId(n) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.pushScopeId)("data-v-ef10eebe"), n = n(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.popScopeId)(), n;
};
var _hoisted_1 = {
  "class": "flex-container flex-start"
};
var _hoisted_2 = {
  "class": "flex-item relative"
};
var _hoisted_3 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    selected: "",
    value: ""
  }, "Select Agent", -1 /* HOISTED */);
});
var _hoisted_4 = ["value"];
var _hoisted_5 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    "class": "flex-shrink-0 pointer-events-none form-select-arrow",
    xmlns: "http://www.w3.org/2000/svg",
    width: "10",
    height: "6",
    viewBox: "0 0 10 6"
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "class": "fill-current",
    d: "M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z"
  })], -1 /* HOISTED */);
});
var _hoisted_6 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "flex-item relative"
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    placeholder: "Phone Number",
    "class": "w-full form-control form-input form-input-bordered",
    id: "name-create-campaign-text-field",
    dusk: "name",
    list: "name-list"
  })], -1 /* HOISTED */);
});
var _hoisted_7 = {
  "class": "flex-item relative"
};
var _hoisted_8 = {
  "class": "flex-shrink-0 ml-auto pr-2"
};
var _hoisted_9 = {
  "class": "flex-container flex-start"
};
var _hoisted_10 = {
  "class": "flex-item relative"
};
var _hoisted_11 = {
  "for": "type"
};
var _hoisted_12 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "mlbz-radio-label"
  }, "Transcribed", -1 /* HOISTED */);
});
var _hoisted_13 = {
  "class": "flex-item relative"
};
var _hoisted_14 = {
  "for": "type"
};
var _hoisted_15 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "mlbz-radio-label"
  }, "Processed", -1 /* HOISTED */);
});
var _hoisted_16 = {
  "class": "flex-item relative"
};
var _hoisted_17 = {
  "for": "type"
};
var _hoisted_18 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "mlbz-radio-label"
  }, "Pending", -1 /* HOISTED */);
});
var _hoisted_19 = {
  "class": "flex-item relative"
};
var _hoisted_20 = {
  "for": "type"
};
var _hoisted_21 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "mlbz-radio-label"
  }, "Flagged", -1 /* HOISTED */);
});
var _hoisted_22 = {
  "class": "flex-item relative"
};
var _hoisted_23 = {
  "for": "type"
};
var _hoisted_24 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "mlbz-radio-label"
  }, "Reviewed", -1 /* HOISTED */);
});
var _hoisted_25 = {
  "class": "flex-item relative"
};
var _hoisted_26 = {
  "for": "type"
};
var _hoisted_27 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "mlbz-radio-label"
  }, "Valid", -1 /* HOISTED */);
});
var _hoisted_28 = {
  "class": "flex-item relative"
};
var _hoisted_29 = {
  "for": "type"
};
var _hoisted_30 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "mlbz-radio-label"
  }, "Invalid", -1 /* HOISTED */);
});
var _hoisted_31 = {
  "class": "w-full flex items-center mb-6"
};
var _hoisted_32 = {
  "class": "ml-auto flex items-center"
};
var _hoisted_33 = {
  "class": "flex-shrink-0 ml-auto pr-2"
};
var _hoisted_34 = ["onClick"];
var _hoisted_35 = {
  id: "secondTable",
  style: {
    "font-family": "'Open Sans', sans-serif",
    "width": "100%",
    "margin": "10px 10px 0 10px"
  }
};
var _hoisted_36 = {
  style: {
    "padding": "8px",
    "min-width": "30px",
    "text-align": "left"
  }
};
var _hoisted_37 = {
  style: {
    "padding": "8px",
    "min-width": "30px",
    "text-align": "left"
  }
};
var _hoisted_38 = {
  style: {
    "padding": "8px",
    "min-width": "30px",
    "text-align": "left"
  }
};
var _hoisted_39 = {
  key: 0,
  "class": "inline-flex items-center whitespace-nowrap h-6 px-2 rounded-full uppercase text-xs font-bold badge-success"
};
var _hoisted_40 = {
  key: 1,
  "class": "inline-flex items-center whitespace-nowrap h-6 px-2 rounded-full uppercase text-xs font-bold badge-info"
};
var _hoisted_41 = {
  key: 2,
  "class": "inline-flex items-center whitespace-nowrap h-6 px-2 rounded-full uppercase text-xs font-bold badge-warning"
};
var _hoisted_42 = {
  key: 3,
  "class": "inline-flex items-center whitespace-nowrap h-6 px-2 rounded-full uppercase text-xs font-bold badge-danger"
};
var _hoisted_43 = {
  style: {
    "padding": "8px",
    "min-width": "30px",
    "text-align": "left"
  }
};
var _hoisted_44 = {
  style: {
    "padding": "8px",
    "min-width": "30px",
    "text-align": "left"
  }
};
var _hoisted_45 = {
  style: {
    "padding": "8px",
    "min-width": "30px",
    "text-align": "left"
  }
};
var _hoisted_46 = {
  style: {
    "padding": "8px",
    "min-width": "30px",
    "text-align": "left"
  }
};
var _hoisted_47 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th")], -1 /* HOISTED */);
});
var _hoisted_48 = {
  "class": "flex-container flex-center dark-bg"
};
var _hoisted_49 = {
  "class": "flex-item lightskyblue"
};
var _hoisted_50 = {
  "class": "flex-item orangered"
};
var _hoisted_51 = {
  "class": "flex-item lime"
};
var _hoisted_52 = {
  "class": "flex-item lightcoral"
};
var _hoisted_53 = {
  key: 0,
  "class": "flex-item"
};
var _hoisted_54 = {
  xmlns: "http://www.w3.org/2000/svg",
  style: {
    "color": "red",
    "fill": "red"
  },
  "class": "h-6 w-6",
  fill: "none",
  viewBox: "0 0 24 24",
  stroke: "currentColor",
  "stroke-width": "2"
};
var _hoisted_55 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "stroke-linecap": "round",
    "stroke-linejoin": "round",
    d: "M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"
  }, null, -1 /* HOISTED */);
});
var _hoisted_56 = [_hoisted_55];
var _hoisted_57 = {
  "class": "flex-item"
};
var _hoisted_58 = {
  id: "recordingPlay",
  controls: ""
};
var _hoisted_59 = ["src"];
var _hoisted_60 = {
  "class": "flex-item"
};
var _hoisted_61 = ["onClick"];
var _hoisted_62 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    fill: "none",
    viewBox: "0 0 24 24",
    stroke: "currentColor",
    width: "24",
    "class": "inline-block v-popper--has-tooltip",
    role: "presentation",
    "data-v-0c784995": ""
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "stroke-linecap": "round",
    "stroke-linejoin": "round",
    "stroke-width": "2",
    d: "M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
  })], -1 /* HOISTED */);
});
var _hoisted_63 = [_hoisted_62];
var _hoisted_64 = {
  "class": "bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden",
  style: {
    "width": "660px"
  }
};
var _hoisted_65 = {
  ref: "chatArea",
  "class": "chat-area"
};
var _hoisted_66 = {
  "class": "ml-auto"
};
var _hoisted_67 = {
  "class": "bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden",
  style: {
    "width": "660px"
  }
};
var _hoisted_68 = {
  "class": "field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row",
  index: "0"
};
var _hoisted_69 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5"
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "for": "agent-create-audio-belongs-to-field",
    "class": "inline-block pt-2 leading-tight"
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Agent "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "text-red-500 text-sm",
    style: {
      "color": "red"
    }
  }, "*")])], -1 /* HOISTED */);
});
var _hoisted_70 = {
  "class": "mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5"
};
var _hoisted_71 = {
  "class": "flex items-center"
};
var _hoisted_72 = {
  "class": "flex relative w-full"
};
var _hoisted_73 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    disabled: "",
    value: ""
  }, "—", -1 /* HOISTED */);
});
var _hoisted_74 = ["value"];
var _hoisted_75 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    "class": "flex-shrink-0 pointer-events-none form-select-arrow",
    xmlns: "http://www.w3.org/2000/svg",
    width: "10",
    height: "6",
    viewBox: "0 0 10 6"
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "class": "fill-current",
    d: "M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z"
  })], -1 /* HOISTED */);
});
var _hoisted_76 = {
  key: 0,
  style: {
    "color": "red"
  }
};
var _hoisted_77 = {
  "class": "field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row",
  index: "2"
};
var _hoisted_78 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5"
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "for": "file-audio-upload_audio",
    "class": "inline-block pt-2 leading-tight"
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Upload Call "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
    "class": "text-red-500 text-sm",
    style: {
      "color": "red"
    }
  }, "*")])], -1 /* HOISTED */);
});
var _hoisted_79 = {
  "class": "mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5"
};
var _hoisted_80 = {
  "class": "form-file mr-4"
};
var _hoisted_81 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "for": "file-audio-upload_audio",
    "class": "cursor-pointer focus:outline-none focus:ring rounded border-2 border-primary-300 dark:border-gray-500 hover:border-primary-500 active:border-primary-400 dark:hover:border-gray-400 dark:active:border-gray-300 bg-white dark:bg-transparent text-primary-500 dark:text-gray-400 px-3 h-9 inline-flex items-center font-bold flex-shrink-0"
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, "Choose File")], -1 /* HOISTED */);
});
var _hoisted_82 = {
  key: 0,
  "class": "text-90 text-sm select-none"
};
var _hoisted_83 = {
  key: 1,
  "class": "",
  style: {
    "color": "red"
  }
};
var _hoisted_84 = /*#__PURE__*/_withScopeId(function () {
  return /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row",
    index: "3"
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5"
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
    "for": "status-create-audio-select-field",
    "class": "inline-block pt-2 leading-tight"
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Status "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if")])]), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5"
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Search Input "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Select Input Field "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    "class": "flex relative w-full"
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    id: "status",
    dusk: "status",
    disabled: "",
    "class": "w-full block form-control form-select form-select-bordered"
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    disabled: "",
    value: ""
  }, "Choose an option"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    value: "pending"
  }, "Pending"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    value: "success"
  }, "Success"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
    value: "failed"
  }, "Failed")]), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
    "class": "flex-shrink-0 pointer-events-none form-select-arrow",
    xmlns: "http://www.w3.org/2000/svg",
    width: "10",
    height: "6",
    viewBox: "0 0 10 6"
  }, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
    "class": "fill-current",
    d: "M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z"
  })])]), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if")])], -1 /* HOISTED */);
});
var _hoisted_85 = {
  "class": "ml-auto"
};
var _hoisted_86 = {
  "class": "bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden",
  style: {
    "width": "900px"
  }
};
var _hoisted_87 = {
  "class": "container2"
};
var _hoisted_88 = {
  "class": "row clearfix"
};
var _hoisted_89 = {
  "class": "col-lg-12"
};
var _hoisted_90 = {
  "class": "chat-app"
};
var _hoisted_91 = {
  "class": "chat"
};
var _hoisted_92 = {
  "class": "chat-history"
};
var _hoisted_93 = {
  "class": "m-b-0"
};
var _hoisted_94 = {
  "class": "clearfix"
};
var _hoisted_95 = {
  ref: "chatArea",
  "class": "chat-area"
};
var _hoisted_96 = {
  "class": "ml-auto"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Head = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Head");
  var _component_Heading = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Heading");
  var _component_Card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Card");
  var _component_ModalHeader = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ModalHeader");
  var _component_ModalContent = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ModalContent");
  var _component_LinkButton = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("LinkButton");
  var _component_ModalFooter = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ModalFooter");
  var _component_Modal = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Modal");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Head, {
    title: "Search Calls"
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Heading, {
    "class": "mb-6"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Filters")];
    }),
    _: 1 /* STABLE */
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, {
    style: {
      "min-height": "100px"
    },
    "class": "mt-4"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <Heading class=\"pl-2 mt-2\">Filters</Heading> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"flex-item relative\">\n          <select\n            id=\"\"\n            class=\"w-full block form-control form-select form-select-bordered\"\n            v-model=\"selectedFilters.groups\"\n            @change=\"updateFilter\"\n          >\n            <option selected value=\"\">Select Group</option>\n            <option\n              v-for=\"group in filters.groups\"\n              :key=\"group.id\"\n              :value=\"group.id\"\n            >\n              {{ group.name }}\n            </option>\n          </select>\n          <svg\n            class=\"flex-shrink-0 pointer-events-none form-select-arrow\"\n            xmlns=\"http://www.w3.org/2000/svg\"\n            width=\"10\"\n            height=\"6\"\n            viewBox=\"0 0 10 6\"\n          >\n            <path\n              class=\"fill-current\"\n              d=\"M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z\"\n            ></path>\n          </svg>\n        </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
        id: "",
        "class": "w-full block form-control form-select form-select-bordered",
        "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
          return $data.selectedFilters.agents = $event;
        }),
        onChange: _cache[1] || (_cache[1] = function () {
          return $options.updateFilter && $options.updateFilter.apply($options, arguments);
        })
      }, [_hoisted_3, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.filters.agents, function (agent) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
          key: agent.id,
          value: agent.id
        }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(agent.first_name + " " + agent.last_name), 9 /* TEXT, PROPS */, _hoisted_4);
      }), 128 /* KEYED_FRAGMENT */))], 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.selectedFilters.agents]]), _hoisted_5]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"flex-item relative\">\n          <select\n            id=\"\"\n            class=\"w-full block form-control form-select form-select-bordered\"\n            v-model=\"selectedFilters.scorecards\"\n            @change=\"updateFilter\"\n          >\n            <option selected value=\"\">Select Scorecard</option>\n            <option\n              v-for=\"scorecard in filters.scorecards\"\n              :key=\"scorecard.id\"\n              :value=\"scorecard.id\"\n            >\n              {{ scorecard.name }}\n            </option>\n          </select>\n          <svg\n            class=\"flex-shrink-0 pointer-events-none form-select-arrow\"\n            xmlns=\"http://www.w3.org/2000/svg\"\n            width=\"10\"\n            height=\"6\"\n            viewBox=\"0 0 10 6\"\n          >\n            <path\n              class=\"fill-current\"\n              d=\"M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z\"\n            ></path>\n          </svg>\n        </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"flex-item relative\">\n          <select\n            id=\"\"\n            class=\"w-full block form-control form-select form-select-bordered\"\n            v-model=\"selectedFilters.phrases\"\n            @change=\"updateFilter\"\n          >\n            <option selected value=\"\">Select Phrase</option>\n            <option\n              v-for=\"phrase in filters.phrases\"\n              :key=\"phrase.id\"\n              :value=\"phrase.id\"\n            >\n              {{ phrase.title }}\n            </option>\n          </select>\n          <svg\n            class=\"flex-shrink-0 pointer-events-none form-select-arrow\"\n            xmlns=\"http://www.w3.org/2000/svg\"\n            width=\"10\"\n            height=\"6\"\n            viewBox=\"0 0 10 6\"\n          >\n            <path\n              class=\"fill-current\"\n              d=\"M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z\"\n            ></path>\n          </svg>\n        </div> "), _hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        "class": "flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0",
        onClick: _cache[2] || (_cache[2] = function () {
          return $options.reset && $options.reset.apply($options, arguments);
        })
      }, " Reset ")])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <Heading class=\"pl-2 mt-2\">Human review</Heading> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        name: "transcribed",
        type: "checkbox",
        "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
          return $data.selectedFilters.transcribed = $event;
        }),
        onChange: _cache[4] || (_cache[4] = function ($event) {
          return $options.updateFilter2('transcribed');
        })
      }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelCheckbox, $data.selectedFilters.transcribed]]), _hoisted_12])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_14, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        name: "processed",
        type: "checkbox",
        "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
          return $data.selectedFilters.processed = $event;
        }),
        onChange: _cache[6] || (_cache[6] = function ($event) {
          return $options.updateFilter2('processed');
        })
      }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelCheckbox, $data.selectedFilters.processed]]), _hoisted_15])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_16, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        name: "pending",
        "onUpdate:modelValue": _cache[7] || (_cache[7] = function ($event) {
          return $data.selectedFilters.pending = $event;
        }),
        onChange: _cache[8] || (_cache[8] = function ($event) {
          return $options.updateFilter2('pending');
        }),
        type: "checkbox"
      }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelCheckbox, $data.selectedFilters.pending]]), _hoisted_18])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_20, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        name: "flagged",
        type: "checkbox",
        "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
          return $data.selectedFilters.flagged = $event;
        }),
        onChange: _cache[10] || (_cache[10] = function ($event) {
          return $options.updateFilter2('flagged');
        })
      }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelCheckbox, $data.selectedFilters.flagged]]), _hoisted_21])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_22, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_23, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        name: "type",
        type: "checkbox",
        "onUpdate:modelValue": _cache[11] || (_cache[11] = function ($event) {
          return $data.selectedFilters.reviewed = $event;
        }),
        onChange: _cache[12] || (_cache[12] = function () {
          return $options.updateFilter && $options.updateFilter.apply($options, arguments);
        })
      }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelCheckbox, $data.selectedFilters.reviewed]]), _hoisted_24])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_25, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_26, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        name: "type",
        type: "checkbox",
        "onUpdate:modelValue": _cache[13] || (_cache[13] = function ($event) {
          return $data.selectedFilters.valid = $event;
        }),
        onChange: _cache[14] || (_cache[14] = function ($event) {
          return $options.updateFilter2('valid');
        })
      }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelCheckbox, $data.selectedFilters.valid]]), _hoisted_27])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_28, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_29, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        name: "type",
        type: "checkbox",
        "onUpdate:modelValue": _cache[15] || (_cache[15] = function ($event) {
          return $data.selectedFilters.invalid = $event;
        }),
        onChange: _cache[16] || (_cache[16] = function ($event) {
          return $options.updateFilter2('invalid');
        })
      }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelCheckbox, $data.selectedFilters.invalid]]), _hoisted_30])])])])];
    }),
    _: 1 /* STABLE */
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_31, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Heading, {
    "class": "mb-6 mt-6"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Search Calls")];
    }),
    _: 1 /* STABLE */
  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" Create / Attach Button "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_32, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_33, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    "class": "flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0",
    onClick: _cache[17] || (_cache[17] = function ($event) {
      return $data.show = true;
    })
  }, " Add Call ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("teleport start"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("teleport end")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if")])]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.calls, function (call) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Card, {
      key: call.id,
      style: {
        "min-height": "100px"
      },
      "class": "mt-4"
    }, {
      "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
        return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
          href: "",
          onClick: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
            return $options.changeButton(call.id);
          }, ["prevent"])
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_35, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", _hoisted_36, " SESSION ID: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(call.id), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", _hoisted_37, " CALL DATE: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(call.created_at), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", _hoisted_38, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" CALL STATUS: "), call.status === 'success' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_39, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(call.status), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), call.status === 'processed' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_40, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(call.status), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), call.status === 'pending' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_41, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(call.status), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), call.status === 'flagged' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_42, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(call.status), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", _hoisted_43, " AGENT: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(call.agent.first_name) + " " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(call.agent.last_name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <th style=\"padding: 8px;min-width: 30px;text-align: left;\">SCORECARD: {{ call.scorecard.name }}</th> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", _hoisted_44, " CALL DURATION: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(call.length != null ? call.length : "00:00:00"), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", _hoisted_45, " PHONE: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(call.phone_number != null ? call.phone_number : "N/A"), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", _hoisted_46, " SILENCE: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(call.silence != null ? call.silence : "N/A"), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <th style=\"padding: 8px;min-width: 30px;\">CALL DURATION: {{ call.length != null ? call.length : '00:00:00' }} </th> ")]), _hoisted_47])])], 8 /* PROPS */, _hoisted_34), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_48, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_49, " NSFW: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(call.nsfw_count != null ? call.nsfw : 0), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_50, " BANNED: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(call.banned_count != null ? call.banned_count : 0), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_51, " GOOD: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(call.positive_count != null ? call.positive_count : 0), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_52, " REQUIRED: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(call.req_found_count != null ? call.req_found_count : 0), 1 /* TEXT */), call.status == 'flagged' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_53, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("svg", _hoisted_54, _hoisted_56))])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_57, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("audio", _hoisted_58, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("source", {
          src: 'https://rvm.nyc3.digitaloceanspaces.com/RVM/' + call.filename,
          type: "audio/wav"
        }, null, 8 /* PROPS */, _hoisted_59)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_60, [call.status === 'success' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("a", {
          key: 0,
          "aria-label": "View",
          "data-testid": "audio-items-0-view-button",
          dusk: "3-view-button",
          "class": "hover:text-primary-500 v-popper--has-tooltip",
          onClick: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
            return $options.loadChat(call.id);
          }, ["stop"])
        }, _hoisted_63, 8 /* PROPS */, _hoisted_61)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])];
      }),
      _: 2 /* DYNAMIC */
    }, 1024 /* DYNAMIC_SLOTS */);
  }), 128 /* KEYED_FRAGMENT */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Modal, {
    show: $data.showChatModal,
    "data-testid": "confirm-upload-removal-modal",
    role: "alertdialog"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_64, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ModalHeader, {
        textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__('Call Text'))
      }, null, 8 /* PROPS */, ["textContent"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ModalContent, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_65, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.messages, function (message) {
            return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("p", {
              key: message.speaker,
              "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["message-chat-modal", {
                'message-out': message.speaker === 'B',
                'message-in': message.speaker === 'A'
              }])
            }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(message.text), 3 /* TEXT, CLASS */);
          }), 128 /* KEYED_FRAGMENT */))], 512 /* NEED_PATCH */)];
        }),

        _: 1 /* STABLE */
      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ModalFooter, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_66, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_LinkButton, {
            dusk: "cancel-upload-delete-button",
            type: "button",
            onClick: _cache[18] || (_cache[18] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
              return $data.showChatModal = false;
            }, ["prevent"])),
            "class": "mr-3"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__("Cancel")), 1 /* TEXT */)];
            }),

            _: 1 /* STABLE */
          })])];
        }),

        _: 1 /* STABLE */
      })])];
    }),

    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["show"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Modal, {
    show: $data.show,
    "data-testid": "confirm-upload-removal-modal",
    role: "alertdialog"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_67, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ModalHeader, {
        textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__('Add Call'))
      }, null, 8 /* PROPS */, ["textContent"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ModalContent, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_68, [_hoisted_69, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_70, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_71, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_72, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
            "data-testid": "agents-select",
            dusk: "agent",
            "class": "w-full block form-control form-select form-select-bordered",
            "onUpdate:modelValue": _cache[19] || (_cache[19] = function ($event) {
              return $data.addCall.agent_id = $event;
            }),
            onChange: _cache[20] || (_cache[20] = function ($event) {
              return $data.errors.agent_id = null;
            })
          }, [_hoisted_73, ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.filters.agents, function (agent) {
            return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("option", {
              key: agent.id,
              value: agent.id
            }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(agent.first_name + " " + agent.last_name), 9 /* TEXT, PROPS */, _hoisted_74);
          }), 128 /* KEYED_FRAGMENT */))], 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.addCall.agent_id]]), _hoisted_75]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if")]), $data.errors.agent_id ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("p", _hoisted_76, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.errors.agent_id), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("teleport start"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("teleport end"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if")])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div\n            class=\"\n              field-wrapper\n              flex flex-col\n              border-b border-gray-100\n              dark:border-gray-700\n              md:flex-row\n            \"\n            index=\"0\"\n          >\n            <div class=\"px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5\">\n              <label\n                for=\"agent-create-audio-belongs-to-field\"\n                class=\"inline-block pt-2 leading-tight\"\n                >Scorecard\n                <span class=\"text-red-500 text-sm\" style=\"color: red\"\n                  >*</span\n                ></label\n              >\n            </div>\n            <div class=\"mt-1 md:mt-0 pb-5 px-8 w-full md:w-3/5 md:py-5\">\n              <div class=\"flex items-center\">\n                <div class=\"flex relative w-full\">\n                  <select\n                    data-testid=\"agents-select\"\n                    dusk=\"agent\"\n                    class=\"\n                      w-full\n                      block\n                      form-control form-select form-select-bordered\n                    \"\n                    v-model=\"addCall.scorecard_id\"\n                    @change=\"errors.scorecard_id = null\"\n                  >\n                    <option disabled=\"\" value=\"\">—</option>\n                    <option\n                      v-for=\"scorecard in filters.scorecards\"\n                      :key=\"scorecard.id\"\n                      :value=\"scorecard.id\"\n                    >\n                      {{ scorecard.name }}\n                    </option>\n                  </select>\n                  <svg\n                    class=\"flex-shrink-0 pointer-events-none form-select-arrow\"\n                    xmlns=\"http://www.w3.org/2000/svg\"\n                    width=\"10\"\n                    height=\"6\"\n                    viewBox=\"0 0 10 6\"\n                  >\n                    <path\n                      class=\"fill-current\"\n                      d=\"M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z\"\n                    ></path>\n                  </svg>\n                </div>\n              </div>\n              <p v-if=\"errors.scorecard_id\" style=\"color: red\">\n                {{ errors.scorecard_id }}\n              </p>\n            </div>\n          </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_77, [_hoisted_78, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_79, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_80, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
            dusk: "upload_audio",
            "class": "form-file-input select-none",
            type: "file",
            id: "file-audio-upload_audio",
            name: "name",
            onChange: _cache[21] || (_cache[21] = function () {
              return $options.fileChange && $options.fileChange.apply($options, arguments);
            })
          }, null, 32 /* HYDRATE_EVENTS */), _hoisted_81]), $data.errors.file == null ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_82, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.currentLabel ? $data.currentLabel : "no file selected"), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $data.errors.file ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_83, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.errors.file), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" file field end "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" status field start "), _hoisted_84, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" status field end ")];
        }),
        _: 1 /* STABLE */
      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ModalFooter, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_85, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_LinkButton, {
            dusk: "cancel-upload-delete-button",
            type: "button",
            onClick: _cache[22] || (_cache[22] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
              return $data.show = false;
            }, ["prevent"])),
            "class": "mr-3"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__("Cancel")), 1 /* TEXT */)];
            }),

            _: 1 /* STABLE */
          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
            "class": "flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0",
            onClick: _cache[23] || (_cache[23] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function () {
              return $options.submit && $options.submit.apply($options, arguments);
            }, ["prevent"]))
          }, " Create ")])];
        }),
        _: 1 /* STABLE */
      })])];
    }),

    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["show"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Modal, {
    show: $data.showChat,
    "data-testid": "conversation-modal",
    role: "alertdialog",
    style: {
      "padding-right": "20rem",
      "height": "80vh",
      "overflow": "auto"
    }
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_86, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ModalHeader, {
        textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__('Conversation Report'))
      }, null, 8 /* PROPS */, ["textContent"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ModalContent, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_87, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_88, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_89, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_90, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_91, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_92, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_93, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li class=\"clearfix\">\n                            <div class=\"message-data text-right\">\n                              <span class=\"message-data-time\"\n                                >10:10 AM, Today</span\n                              >\n                            </div>\n                            <div class=\"message other-message float-right\">\n                              Hi Aiden, how are you? How is the project coming\n                              along?\n                            </div>\n                          </li> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_94, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li class=\"clearfix\" v-for=\"chat in chatData\" :key=\"chat.time\"> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"message-data\">\n                              <span class=\"message-data-time\"\n                                >{{chat.time.split(':')[0]  + 's to '+ chat.time.split(':')[1] + 's' }}</span\n                              >\n                            </div>\n                            <div class=\"message my-message\">\n                              {{chat.text}}\n                            </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_95, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.chatData, function (message) {
            return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
              key: message.speaker
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
              "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["message-chat-modal mb-1", {
                'message-out': message.speaker !== 'A',
                'message-in': message.speaker !== 'B'
              }])
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(message.text) + " ", 1 /* TEXT */), message.sentiment == 'NEGATIVE' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", {
              key: 0,
              "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)({
                'emoji-out': message.speaker !== 'A',
                'emoji-in': message.speaker !== 'B'
              })
            }, " 🙁 ", 2 /* CLASS */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), message.sentiment == 'POSITIVE' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", {
              key: 1,
              "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)({
                'emoji-out': message.speaker !== 'A',
                'emoji-in': message.speaker !== 'B'
              })
            }, " ❤️ ", 2 /* CLASS */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 2 /* CLASS */)]);
          }), 128 /* KEYED_FRAGMENT */))], 512 /* NEED_PATCH */)])])])])])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div>\n            <h1>QA REPORT:</h1>\n            <div class=\"flex-container-report\">\n              <div class=\"item1-report\">\n                <p>\n                  Department:\n                  <span\n                    class=\"\n                      inline-flex\n                      items-center\n                      whitespace-nowrap\n                      h-6\n                      px-2\n                      m-2\n                      rounded-full\n                      uppercase\n                      text-xs\n                      font-bold\n                      badge-success\n                    \"\n                    >{{\n                      audio.agent.topic\n                        ? audio.agent.topic.department.name\n                        : \"ssa\"\n                    }}</span\n                  >\n                </p>\n                <p>\n                  Topic:\n                  <span\n                    class=\"\n                      inline-flex\n                      items-center\n                      whitespace-nowrap\n                      h-6\n                      px-2\n                      m-2\n                      rounded-full\n                      uppercase\n                      text-xs\n                      font-bold\n                      badge-success\n                    \"\n                    >{{ audio.agent.topic\n                        ? audio.agent.topic.title\n                        : \"ssa\" }}</span\n                  >\n                </p>\n                <p>\n                  Agent:\n                  <span\n                    class=\"\n                      inline-flex\n                      items-center\n                      whitespace-nowrap\n                      h-6\n                      px-2\n                      m-2\n                      rounded-full\n                      uppercase\n                      text-xs\n                      font-bold\n                      badge-success\n                    \"\n                    >{{ audio.agent.first_name }}\n                    {{ audio.agent.last_name }}</span\n                  >\n                </p>\n                <p>\n                  Scorecard:\n                  <span\n                    class=\"\n                      inline-flex\n                      items-center\n                      whitespace-nowrap\n                      h-6\n                      px-2\n                      m-2\n                      rounded-full\n                      uppercase\n                      text-xs\n                      font-bold\n                      badge-success\n                    \"\n                    >{{ audio.scorecard ? audio.scorecard.name : \"sas\" }}</span\n                  >\n                </p>\n              </div>\n              <div class=\"item2-report\">\n                <p>\n                  Duration:\n                  <span\n                    class=\"\n                      inline-flex\n                      items-center\n                      whitespace-nowrap\n                      h-6\n                      px-2\n                      m-2\n                      rounded-full\n                      uppercase\n                      text-xs\n                      font-bold\n                      badge-success\n                    \"\n                    >{{\n                      audio.length != null ? audio.length : \"00:00:00\"\n                    }}</span\n                  >\n                </p>\n                <p>\n                  Occurences of NSFW:\n                  <span\n                    class=\"\n                      inline-flex\n                      items-center\n                      whitespace-nowrap\n                      h-6\n                      px-2\n                      m-2\n                      rounded-full\n                      uppercase\n                      text-xs\n                      font-bold\n                      badge-success\n                    \"\n                    >{{\n                      audio.nsfw_count != null ? audio.nsfw_count : \"00\"\n                    }}</span\n                  >\n                </p>\n                <p>\n                  Occurences of Banned:\n                  <span\n                    class=\"\n                      inline-flex\n                      items-center\n                      whitespace-nowrap\n                      h-6\n                      px-2\n                      m-2\n                      rounded-full\n                      uppercase\n                      text-xs\n                      font-bold\n                      badge-success\n                    \"\n                    >{{\n                      audio.positive_count != null ? audio.positive_count : \"00\"\n                    }}</span\n                  >\n                </p>\n                <p>\n                  Occurences of Good:\n                  <span\n                    class=\"\n                      inline-flex\n                      items-center\n                      whitespace-nowrap\n                      h-6\n                      px-2\n                      m-2\n                      rounded-full\n                      uppercase\n                      text-xs\n                      font-bold\n                      badge-success\n                    \"\n                    >{{\n                      audio.positive_count != null ? audio.positive_count : \"00\"\n                    }}</span\n                  >\n                </p>\n                <p>\n                  Occurences of Required:\n                  <span\n                    class=\"\n                      inline-flex\n                      items-center\n                      whitespace-nowrap\n                      h-6\n                      px-2\n                      m-2\n                      rounded-full\n                      uppercase\n                      text-xs\n                      font-bold\n                      badge-success\n                    \"\n                    >{{\n                      audio.req_found_count != null ? audio.req_found_count : \"00\"\n                    }}</span\n                  >\n                </p>\n              </div>\n            </div>\n          </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div>\n            <h1 class=\"h pt-6\">Previous Notes:</h1>\n\n            <div class=\"flex-container-report chat\" style=\"overflow:auto; height:200px;\">\n              <div class=\"item1-report\">\n                <div v-if=\"notes\">\n                  <div class=\"chat-history\">\n                    <ol start=\"1\">\n                      <li v-for=\"note in notes\" :key=\"note.id\" class=\"clearfix\">\n                        <div class=\"message-data\">\n                          <span class=\"message-data-time\">{{ note.created_at.split('T')[0]}}, by  {{ note.user.first_name + ' ' + note.user.last_name }}</span>\n                        </div>\n                        <div class=\"message my-message\">* {{ note.body }}</div>\n                      </li>\n                    </ol>\n                  </div>\n                </div>\n              </div>\n            </div>\n\n            <h1 class=\"h mt-6\">Add Notes:</h1>\n            <div class=\"flex-container-report\">\n              <div class=\"item1-report\">\n                <textarea\n                  name=\"\"\n                  id=\"\"\n                  cols=\"100\"\n                  rows=\"3\"\n                  style=\"background: #f2f2f2\"\n                  v-model=\"noteNew\"\n                ></textarea>\n              </div>\n            </div>\n          </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div>\n            <button\n              class=\"\n                flex-shrink-0\n                shadow\n                rounded\n                focus:outline-none\n                ring-primary-200\n                dark:ring-gray-600\n                focus:ring\n                bg-primary-500\n                hover:bg-primary-400\n                active:bg-primary-600\n                text-white\n                dark:text-gray-800\n                inline-flex\n                items-center\n                font-bold\n                px-6\n                mb-4\n                h-9\n                text-sm\n              \"\n              @click=\"saveNote()\"\n            >\n              Save\n            </button>\n          </div> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <h1 class=\"h\">Play Audio:</h1> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <div class=\"flex-container-report\">\n            <div class=\"item1-report\" style=\"width: 80%\">\n              <audio id=\"recordingPlay\" controls style=\"width: 80%\">\n                <source\n                  :src=\"\n                    'https://rvm.nyc3.digitaloceanspaces.com/RVM/' +\n                    audio.filename\n                  \"\n                  type=\"audio/wav\"\n                />\n              </audio>\n            </div>\n            <div class=\"item1-report\" v-if=\"audio.bad_calls == true\">\n\n            </div>\n          </div> ")];
        }),
        _: 1 /* STABLE */
      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ModalFooter, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_96, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_LinkButton, {
            dusk: "cancel-upload-delete-button",
            type: "button",
            onClick: _cache[24] || (_cache[24] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
              return $data.showChat = false;
            }, ["prevent"])),
            "class": "mr-3"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__("Cancel")), 1 /* TEXT */)];
            }),

            _: 1 /* STABLE */
          })])];
        }),

        _: 1 /* STABLE */
      })])];
    }),

    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["show"])]);
}

/***/ }),

/***/ "./resources/js/tool.js":
/*!******************************!*\
  !*** ./resources/js/tool.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _pages_Tool__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./pages/Tool */ "./resources/js/pages/Tool.vue");

Nova.booting(function (app, store) {
  Nova.inertia('SearchCalls', _pages_Tool__WEBPACK_IMPORTED_MODULE_0__["default"]);
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n/* Scoped Styles */\n.flex-container[data-v-ef10eebe] {\n  padding: 0;\n  margin: 0;\n  list-style: none;\n  display: flex;\n}\n.chat-area[data-v-ef10eebe] {\n/*   border: 1px solid #ccc; */\n  background: white;\n  height: 50vh;\n  padding: 0px;\n  overflow: auto;\n  /* max-width: 350px; */\n  margin: 0 auto 2em auto;\n}\n.message-chat-modal[data-v-ef10eebe] {\n  width: 45%;\n  border-radius: 10px;\n  padding: .5em;\n/*   margin-bottom: .5em; */\n  font-size: .8em;\n}\n.message-out[data-v-ef10eebe] {\n  background: #407FFF;\n  color: white;\n  margin-left: 50%;\n  position: relative;\n}\n.div2[data-v-ef10eebe]{\n\n\nmargin: 10px;\nopacity: 0.7;\n}\n.message-in[data-v-ef10eebe] {\n  background: #F1F0F0;\n  color: black;\n  position: relative;\n}\n.emoji-out[data-v-ef10eebe] {\n    z-index: 1;\n    margin-left: 55%;\n    position: absolute;\n    bottom: -13px;\n    right: 5px;\n}\n.emoji-in[data-v-ef10eebe] {\n    z-index: 1;\n    margin-left: 55%;\n    position: absolute;\n    bottom: -13px;\n    right: 5px;\n}\n/* .emoji-in {\n  background: #F1F0F0;\n  color: black;\n} */\n.space-between[data-v-ef10eebe] {\n  justify-content: space-between;\n}\n.flex-start[data-v-ef10eebe] {\n  justify-content: flex-start;\n}\n.flex-center[data-v-ef10eebe] {\n  justify-content: center;\n}\n.flex-item[data-v-ef10eebe] {\n  margin: 5px;\n  color: rgb(108, 107, 107);\n}\nspan[data-v-ef10eebe] {\n  font-size: 13px;\n  font-weight: bold;\n  color: currentColor;\n  font-style: normal;\n  text-decoration: none;\n  line-height: 2em;\n  letter-spacing: 0px;\n}\n.orangered[data-v-ef10eebe] {\n  color: orangered;\n}\n.lightskyblue[data-v-ef10eebe] {\n  color: lightskyblue;\n}\n.lime[data-v-ef10eebe] {\n  color: lime;\n}\n.lightcoral[data-v-ef10eebe] {\n  color: lightcoral;\n}\n.dark-bg[data-v-ef10eebe] {\n  background: rgb(240, 239, 239);\n}\naudio[data-v-ef10eebe] {\n  width: 300px;\n  height: 24px;\n}\n\n/* new design */\n.bg[data-v-ef10eebe] {\n  background: #b4daef;\n}\n*[data-v-ef10eebe] {\n  outline: 0;\n}\n.time[data-v-ef10eebe] {\n  text-align: center;\n  margin-bottom: 10px;\n}\n.time span[data-v-ef10eebe] {\n  background-color: #000000;\n  display: inline-block;\n  border-radius: 3px;\n  text-align: center;\n  padding: 2px 20px;\n  color: #fff;\n  opacity: 0.3;\n}\n.message[data-v-ef10eebe] {\n  margin-bottom: 10px;\n}\n.message .messageText[data-v-ef10eebe] {\n  text-align: left;\n  color: #ffffff;\n}\n.message.sol[data-v-ef10eebe] {\n  text-align: left;\n}\n.message.sag[data-v-ef10eebe] {\n  text-align: right;\n}\n.message .resim[data-v-ef10eebe] {\n  background: #ff0044 none no-repeat center;\n  vertical-align: text-top;\n  background-size: cover;\n  display: inline-block;\n  position: relative;\n  color: #ffffff;\n  height: 40px;\n  width: 40px;\n}\n.message .messageText[data-v-ef10eebe] {\n  background-color: #0a74a3;\n  vertical-align: text-top;\n  display: inline-block;\n  position: relative;\n  line-height: 20px;\n  max-width: 165px;\n  color: #ffffff;\n  padding: 10px;\n}\n.message.left .userPortrait[data-v-ef10eebe],\n.message.sag .messageText[data-v-ef10eebe] {\n  border-radius: 5px 0 0 5px;\n}\n.message.sag .userPortrait[data-v-ef10eebe],\n.message.sol .messageText[data-v-ef10eebe] {\n  border-radius: 0 5px 5px 0;\n}\n.message.mtLine.sol .messageText[data-v-ef10eebe] {\n  border-radius: 0 5px 5px 0;\n}\n.message.mtLine.sag .messageText[data-v-ef10eebe] {\n  border-radius: 5px 0 0 5px;\n}\n.message .messageText[data-v-ef10eebe]:before {\n  border-color: transparent #0a74a3;\n  border-style: solid;\n  position: absolute;\n  border-width: 0;\n  display: block;\n  content: \"\";\n  z-index: 1;\n}\n.message.sol .messageText[data-v-ef10eebe]:before {\n  border-width: 0 10px 10px 0;\n  left: -10px;\n  top: 0;\n}\n.message.sag .messageText[data-v-ef10eebe]:before {\n  border-width: 10px 0 0 10px;\n  right: -10px;\n  top: 30px;\n}\n.message .messageText[data-v-ef10eebe]:after {\n  content: attr(data-time);\n  color: rgba(255, 255, 255, 0.5);\n  position: absolute;\n  line-height: 20px;\n  display: block;\n  bottom: 2px;\n  font-weight: 700;\n  z-index: 1;\n}\n.message.sol .messageText[data-v-ef10eebe]:after {\n  margin-left: 5px;\n  left: 100%;\n}\n.message.sag .messageText[data-v-ef10eebe]:after {\n  margin-right: 5px;\n  right: 100%;\n}\n.topic-bg[data-v-ef10eebe] {\n  border-bottom: 3px dotted #0a74a3;\n}\n.h[data-v-ef10eebe] {\n  margin-top: 1rem;\n  margin-bottom: 1rem;\n}\n.em[data-v-ef10eebe] {\n  float: left;\n}\n\n/* chat box new design */\n.card[data-v-ef10eebe] {\n  background: #fff;\n  transition: 0.5s;\n  border: 0;\n  margin-bottom: 30px;\n  border-radius: 0.55rem;\n  position: relative;\n  width: 100%;\n  box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);\n}\n.chat-app .people-list[data-v-ef10eebe] {\n  width: 280px;\n  position: absolute;\n  left: 0;\n  top: 0;\n  padding: 20px;\n  z-index: 7;\n}\n.chat-app .chat[data-v-ef10eebe] {\n}\n.people-list[data-v-ef10eebe] {\n  transition: 0.5s;\n}\n.people-list .chat-list li[data-v-ef10eebe] {\n  padding: 10px 15px;\n  list-style: none;\n  border-radius: 3px;\n}\n.people-list .chat-list li[data-v-ef10eebe]:hover {\n  background: #efefef;\n  cursor: pointer;\n}\n.people-list .chat-list li.active[data-v-ef10eebe] {\n  background: #efefef;\n}\n.people-list .chat-list li .name[data-v-ef10eebe] {\n  font-size: 15px;\n}\n.people-list .chat-list img[data-v-ef10eebe] {\n  width: 45px;\n  border-radius: 50%;\n}\n.people-list img[data-v-ef10eebe] {\n  float: left;\n  border-radius: 50%;\n}\n.people-list .about[data-v-ef10eebe] {\n  float: left;\n  padding-left: 8px;\n}\n.people-list .status[data-v-ef10eebe] {\n  color: #999;\n  font-size: 13px;\n}\n.chat[data-v-ef10eebe] {\n  width: 100%;\n}\n.chat .chat-header[data-v-ef10eebe] {\n  padding: 15px 20px;\n  border-bottom: 2px solid #f4f7f6;\n}\n.chat .chat-header img[data-v-ef10eebe] {\n  float: left;\n  border-radius: 40px;\n  width: 40px;\n}\n.chat .chat-header .chat-about[data-v-ef10eebe] {\n  float: left;\n  padding-left: 10px;\n}\n.chat .chat-history[data-v-ef10eebe] {\n  border-bottom: 2px solid #fff;\n}\n.chat .chat-history ul[data-v-ef10eebe] {\n  padding: 0;\n}\n.chat .chat-history ul li[data-v-ef10eebe] {\n  list-style: none;\n  margin-bottom: 30px;\n}\n.chat .chat-history ul li[data-v-ef10eebe]:last-child {\n  margin-bottom: 0px;\n}\n.chat .chat-history .message-data[data-v-ef10eebe] {\n  margin-bottom: 15px;\n}\n.chat .chat-history .message-data img[data-v-ef10eebe] {\n  border-radius: 40px;\n  width: 40px;\n}\n.chat .chat-history .message-data-time[data-v-ef10eebe] {\n  color: #434651;\n  padding-left: 6px;\n}\n.chat .chat-history .message[data-v-ef10eebe] {\n  color: #444;\n  padding: 18px 20px;\n  line-height: 26px;\n  font-size: 16px;\n  border-radius: 7px;\n  display: inline-block;\n  position: relative;\n}\n.chat .chat-history .message[data-v-ef10eebe]:after {\n  bottom: 100%;\n  left: 7%;\n  border: solid transparent;\n  content: \" \";\n  height: 0;\n  width: 0;\n  position: absolute;\n  pointer-events: none;\n  border-bottom-color: #fff;\n  border-width: 10px;\n  margin-left: -10px;\n}\n.chat .chat-history .my-message[data-v-ef10eebe] {\n  background: #efefef;\n}\n.chat .chat-history .my-message[data-v-ef10eebe]:after {\n  bottom: 100%;\n  left: 30px;\n  border: solid transparent;\n  content: \" \";\n  height: 0;\n  width: 0;\n  position: absolute;\n  pointer-events: none;\n  border-bottom-color: #efefef;\n  border-width: 10px;\n  margin-left: -10px;\n}\n.chat .chat-history .other-message[data-v-ef10eebe] {\n  background: #e8f1f3;\n  text-align: right;\n}\n.chat .chat-history .other-message[data-v-ef10eebe]:after {\n  border-bottom-color: #e8f1f3;\n  left: 93%;\n}\n.chat .chat-message[data-v-ef10eebe] {\n  padding: 20px;\n}\n.online[data-v-ef10eebe],\n.offline[data-v-ef10eebe],\n.me[data-v-ef10eebe] {\n  margin-right: 2px;\n  font-size: 8px;\n  vertical-align: middle;\n}\n.online[data-v-ef10eebe] {\n  color: #86c541;\n}\n.offline[data-v-ef10eebe] {\n  color: #e47297;\n}\n.me[data-v-ef10eebe] {\n  color: #1d8ecd;\n}\n.float-right[data-v-ef10eebe] {\n  float: right;\n}\n.clearfix[data-v-ef10eebe]:after {\n  visibility: hidden;\n  display: block;\n  font-size: 0;\n  content: \" \";\n  clear: both;\n  height: 0;\n}\n@media only screen and (max-width: 767px) {\n.chat-app .people-list[data-v-ef10eebe] {\n    height: 465px;\n    width: 100%;\n    overflow-x: auto;\n    background: #fff;\n    left: -400px;\n    display: none;\n}\n.chat-app .people-list.open[data-v-ef10eebe] {\n    left: 0;\n}\n.chat-app .chat[data-v-ef10eebe] {\n    margin: 0;\n}\n.chat-app .chat .chat-header[data-v-ef10eebe] {\n    border-radius: 0.55rem 0.55rem 0 0;\n}\n.chat-app .chat-history[data-v-ef10eebe] {\n    height: 300px;\n    overflow-x: auto;\n}\n}\n@media only screen and (min-width: 768px) and (max-width: 992px) {\n.chat-app .chat-list[data-v-ef10eebe] {\n    height: 650px;\n    overflow-x: auto;\n}\n.chat-app .chat-history[data-v-ef10eebe] {\n    height: 600px;\n    overflow-x: auto;\n}\n}\n@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {\n.chat-app .chat-list[data-v-ef10eebe] {\n    height: 480px;\n    overflow-x: auto;\n}\n.chat-app .chat-history[data-v-ef10eebe] {\n    height: calc(100vh - 350px);\n    overflow-x: auto;\n}\n}\n.flex-container-report[data-v-ef10eebe] {\n  display: flex;\n\n  justify-content: space-between;\n  align-items: stretch;\n  height: 100%;\n  padding: 15px;\n  gap: 5px;\n}\n.flex-container-report > div[data-v-ef10eebe] {\n  /* border: 1px solid #ffcc80; */\n  border-radius: 5px;\n  padding: 8px;\n}\n.item1-report[data-v-ef10eebe] {\n  /* flex:1 1 auto; */\n  flex-grow: 1;\n}\n.item2-report[data-v-ef10eebe] {\n  /* flex:1 1 auto; */\n  flex-grow: 1;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/runtime/api.js":
/*!*****************************************************!*\
  !*** ./node_modules/css-loader/dist/runtime/api.js ***!
  \*****************************************************/
/***/ ((module) => {



/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
// eslint-disable-next-line func-names
module.exports = function (cssWithMappingToString) {
  var list = []; // return the list of modules as css string

  list.toString = function toString() {
    return this.map(function (item) {
      var content = cssWithMappingToString(item);

      if (item[2]) {
        return "@media ".concat(item[2], " {").concat(content, "}");
      }

      return content;
    }).join("");
  }; // import a list of modules into the list
  // eslint-disable-next-line func-names


  list.i = function (modules, mediaQuery, dedupe) {
    if (typeof modules === "string") {
      // eslint-disable-next-line no-param-reassign
      modules = [[null, modules, ""]];
    }

    var alreadyImportedModules = {};

    if (dedupe) {
      for (var i = 0; i < this.length; i++) {
        // eslint-disable-next-line prefer-destructuring
        var id = this[i][0];

        if (id != null) {
          alreadyImportedModules[id] = true;
        }
      }
    }

    for (var _i = 0; _i < modules.length; _i++) {
      var item = [].concat(modules[_i]);

      if (dedupe && alreadyImportedModules[item[0]]) {
        // eslint-disable-next-line no-continue
        continue;
      }

      if (mediaQuery) {
        if (!item[2]) {
          item[2] = mediaQuery;
        } else {
          item[2] = "".concat(mediaQuery, " and ").concat(item[2]);
        }
      }

      list.push(item);
    }
  };

  return list;
};

/***/ }),

/***/ "./resources/css/tool.css":
/*!********************************!*\
  !*** ./resources/css/tool.css ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_style_index_0_id_ef10eebe_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_style_index_0_id_ef10eebe_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_style_index_0_id_ef10eebe_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js":
/*!****************************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js ***!
  \****************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {



var isOldIE = function isOldIE() {
  var memo;
  return function memorize() {
    if (typeof memo === 'undefined') {
      // Test for IE <= 9 as proposed by Browserhacks
      // @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805
      // Tests for existence of standard globals is to allow style-loader
      // to operate correctly into non-standard environments
      // @see https://github.com/webpack-contrib/style-loader/issues/177
      memo = Boolean(window && document && document.all && !window.atob);
    }

    return memo;
  };
}();

var getTarget = function getTarget() {
  var memo = {};
  return function memorize(target) {
    if (typeof memo[target] === 'undefined') {
      var styleTarget = document.querySelector(target); // Special case to return head of iframe instead of iframe itself

      if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {
        try {
          // This will throw an exception if access to iframe is blocked
          // due to cross-origin restrictions
          styleTarget = styleTarget.contentDocument.head;
        } catch (e) {
          // istanbul ignore next
          styleTarget = null;
        }
      }

      memo[target] = styleTarget;
    }

    return memo[target];
  };
}();

var stylesInDom = [];

function getIndexByIdentifier(identifier) {
  var result = -1;

  for (var i = 0; i < stylesInDom.length; i++) {
    if (stylesInDom[i].identifier === identifier) {
      result = i;
      break;
    }
  }

  return result;
}

function modulesToDom(list, options) {
  var idCountMap = {};
  var identifiers = [];

  for (var i = 0; i < list.length; i++) {
    var item = list[i];
    var id = options.base ? item[0] + options.base : item[0];
    var count = idCountMap[id] || 0;
    var identifier = "".concat(id, " ").concat(count);
    idCountMap[id] = count + 1;
    var index = getIndexByIdentifier(identifier);
    var obj = {
      css: item[1],
      media: item[2],
      sourceMap: item[3]
    };

    if (index !== -1) {
      stylesInDom[index].references++;
      stylesInDom[index].updater(obj);
    } else {
      stylesInDom.push({
        identifier: identifier,
        updater: addStyle(obj, options),
        references: 1
      });
    }

    identifiers.push(identifier);
  }

  return identifiers;
}

function insertStyleElement(options) {
  var style = document.createElement('style');
  var attributes = options.attributes || {};

  if (typeof attributes.nonce === 'undefined') {
    var nonce =  true ? __webpack_require__.nc : 0;

    if (nonce) {
      attributes.nonce = nonce;
    }
  }

  Object.keys(attributes).forEach(function (key) {
    style.setAttribute(key, attributes[key]);
  });

  if (typeof options.insert === 'function') {
    options.insert(style);
  } else {
    var target = getTarget(options.insert || 'head');

    if (!target) {
      throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");
    }

    target.appendChild(style);
  }

  return style;
}

function removeStyleElement(style) {
  // istanbul ignore if
  if (style.parentNode === null) {
    return false;
  }

  style.parentNode.removeChild(style);
}
/* istanbul ignore next  */


var replaceText = function replaceText() {
  var textStore = [];
  return function replace(index, replacement) {
    textStore[index] = replacement;
    return textStore.filter(Boolean).join('\n');
  };
}();

function applyToSingletonTag(style, index, remove, obj) {
  var css = remove ? '' : obj.media ? "@media ".concat(obj.media, " {").concat(obj.css, "}") : obj.css; // For old IE

  /* istanbul ignore if  */

  if (style.styleSheet) {
    style.styleSheet.cssText = replaceText(index, css);
  } else {
    var cssNode = document.createTextNode(css);
    var childNodes = style.childNodes;

    if (childNodes[index]) {
      style.removeChild(childNodes[index]);
    }

    if (childNodes.length) {
      style.insertBefore(cssNode, childNodes[index]);
    } else {
      style.appendChild(cssNode);
    }
  }
}

function applyToTag(style, options, obj) {
  var css = obj.css;
  var media = obj.media;
  var sourceMap = obj.sourceMap;

  if (media) {
    style.setAttribute('media', media);
  } else {
    style.removeAttribute('media');
  }

  if (sourceMap && typeof btoa !== 'undefined') {
    css += "\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))), " */");
  } // For old IE

  /* istanbul ignore if  */


  if (style.styleSheet) {
    style.styleSheet.cssText = css;
  } else {
    while (style.firstChild) {
      style.removeChild(style.firstChild);
    }

    style.appendChild(document.createTextNode(css));
  }
}

var singleton = null;
var singletonCounter = 0;

function addStyle(obj, options) {
  var style;
  var update;
  var remove;

  if (options.singleton) {
    var styleIndex = singletonCounter++;
    style = singleton || (singleton = insertStyleElement(options));
    update = applyToSingletonTag.bind(null, style, styleIndex, false);
    remove = applyToSingletonTag.bind(null, style, styleIndex, true);
  } else {
    style = insertStyleElement(options);
    update = applyToTag.bind(null, style, options);

    remove = function remove() {
      removeStyleElement(style);
    };
  }

  update(obj);
  return function updateStyle(newObj) {
    if (newObj) {
      if (newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap) {
        return;
      }

      update(obj = newObj);
    } else {
      remove();
    }
  };
}

module.exports = function (list, options) {
  options = options || {}; // Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
  // tags it will allow on a page

  if (!options.singleton && typeof options.singleton !== 'boolean') {
    options.singleton = isOldIE();
  }

  list = list || [];
  var lastIdentifiers = modulesToDom(list, options);
  return function update(newList) {
    newList = newList || [];

    if (Object.prototype.toString.call(newList) !== '[object Array]') {
      return;
    }

    for (var i = 0; i < lastIdentifiers.length; i++) {
      var identifier = lastIdentifiers[i];
      var index = getIndexByIdentifier(identifier);
      stylesInDom[index].references--;
    }

    var newLastIdentifiers = modulesToDom(newList, options);

    for (var _i = 0; _i < lastIdentifiers.length; _i++) {
      var _identifier = lastIdentifiers[_i];

      var _index = getIndexByIdentifier(_identifier);

      if (stylesInDom[_index].references === 0) {
        stylesInDom[_index].updater();

        stylesInDom.splice(_index, 1);
      }
    }

    lastIdentifiers = newLastIdentifiers;
  };
};

/***/ }),

/***/ "./node_modules/vue-loader/dist/exportHelper.js":
/*!******************************************************!*\
  !*** ./node_modules/vue-loader/dist/exportHelper.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, exports) => {


Object.defineProperty(exports, "__esModule", ({ value: true }));
// runtime helper for setting properties on components
// in a tree-shakable way
exports["default"] = (sfc, props) => {
    const target = sfc.__vccOpts || sfc;
    for (const [key, val] of props) {
        target[key] = val;
    }
    return target;
};


/***/ }),

/***/ "./resources/js/pages/Tool.vue":
/*!*************************************!*\
  !*** ./resources/js/pages/Tool.vue ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Tool_vue_vue_type_template_id_ef10eebe_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Tool.vue?vue&type=template&id=ef10eebe&scoped=true */ "./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe&scoped=true");
/* harmony import */ var _Tool_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Tool.vue?vue&type=script&lang=js */ "./resources/js/pages/Tool.vue?vue&type=script&lang=js");
/* harmony import */ var _Tool_vue_vue_type_style_index_0_id_ef10eebe_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css */ "./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css");
/* harmony import */ var _Users_air_Desktop_upwork_rvm_laravel_nova_components_SearchCalls_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,_Users_air_Desktop_upwork_rvm_laravel_nova_components_SearchCalls_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Tool_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Tool_vue_vue_type_template_id_ef10eebe_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render],['__scopeId',"data-v-ef10eebe"],['__file',"resources/js/pages/Tool.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/pages/Tool.vue?vue&type=script&lang=js":
/*!*************************************************************!*\
  !*** ./resources/js/pages/Tool.vue?vue&type=script&lang=js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Tool.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe&scoped=true":
/*!*******************************************************************************!*\
  !*** ./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe&scoped=true ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_template_id_ef10eebe_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_template_id_ef10eebe_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Tool.vue?vue&type=template&id=ef10eebe&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe&scoped=true");


/***/ }),

/***/ "./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css":
/*!*********************************************************************************************!*\
  !*** ./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_style_index_0_id_ef10eebe_scoped_true_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&scoped=true&lang=css");


/***/ }),

/***/ "vue":
/*!**********************!*\
  !*** external "Vue" ***!
  \**********************/
/***/ ((module) => {

module.exports = Vue;

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			id: moduleId,
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/tool": 0,
/******/ 			"css/tool": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkrvm_search_calls"] = self["webpackChunkrvm_search_calls"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/nonce */
/******/ 	(() => {
/******/ 		__webpack_require__.nc = undefined;
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/tool"], () => (__webpack_require__("./resources/js/tool.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/tool"], () => (__webpack_require__("./resources/css/tool.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;