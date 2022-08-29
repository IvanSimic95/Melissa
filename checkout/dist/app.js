(function() {
'use strict';
angular
    .module('Orders', [
        // dependencies go here
        'ngSanitize',
        'ui.bootstrap',
        'tf.mailcheck',
        'gettext',
        'credit-cards'
    ]);
})();
(function() {
'use strict';
AbandonedOrderService$.$inject = ["$http", "OrderFormMeta"];
angular
    .module('Orders')
    .service('AbandonedOrderService$', AbandonedOrderService$);

function AbandonedOrderService$($http, OrderFormMeta) {

    var service = {
        sendAbandonedOrderData: sendAbandonedOrderData,
        getSiteParameter: getSiteParameter,
        getVendorVariable: getVendorVariable
    };

    return service;

    ////////////

    function sendAbandonedOrderData(abandonedOrderData) {
        if (!_isValidData(abandonedOrderData)) {
            return;
        }

        function successCallback(response) {}

        function errorCallback(response) {}

        var config = {
            method: 'POST',
            url: OrderFormMeta.ctx + '/order/aostatus.html;jsessionid=' + OrderFormMeta.sid,
            headers: {
                'Content-Type': 'application/json',
                'X-Correlation-Id': OrderFormMeta.correlationId
            },
            data: abandonedOrderData,
            responseType: 'json'
        };

        $http(config).then(successCallback, errorCallback);
    }

    function getSiteParameter(params) {
        return _getParameterValue(params, 'vvvv');
    }

    function getVendorVariable(params) {
        return _getParameterValue(params, 'vvar');
    }

    function _getParameterValue(params, key) {
        var arrayParams = params.split('&');
        for (var i in arrayParams) {
            if (arrayParams.hasOwnProperty(i) && arrayParams[i].includes(key)) {
                return arrayParams[i].split('=')[1];
            }
        }
    }

    function _isValidData(data) {
        var EMAIL_REGEXP = /^\w+([\.+-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        return data && EMAIL_REGEXP.test(data.email);
    }
}
})();
(function() {
'use strict';
BillingInfo.$inject = ["$uibModal", "OrderFormService$", "OrderFormMeta"];
angular
    .module('Orders')
    .component('billingInfo', {
        template: '<div ng-include="$ctrl.getTemplate()">',
        require: {
            orderForm: '^orderForm',
            formController: '^form'
        },
        controller: BillingInfo
    })
    .filter('reverse', function() {
        return function(items) {
            return items.slice().reverse();
        };
    });

function BillingInfo($uibModal, OrderFormService$, OrderFormMeta) {
    // controller definition
    var billingInfo = this;

    billingInfo.billingInfo = {};
    billingInfo.expMonths = [];
    billingInfo.expYears = [];
    billingInfo.paymentMethod = '';
    billingInfo.stripeAccepted = false;
    billingInfo.paypalAdaptiveAccepted = false;
    billingInfo.paypalAccepted = false;
    billingInfo.cardAccepted = false;
    billingInfo.ccBrands = [];
    billingInfo.collectPhone = false;
    billingInfo.collectPhoneNumberForProduct = false;
    billingInfo.collectCardholder = false;
    billingInfo.billToNamePath = '';
    billingInfo.physical = false;
    billingInfo.country = undefined;
    billingInfo.isTestPurchase = false;
    billingInfo.oldZip = undefined;
    billingInfo.countries = [];
    billingInfo.cities = [];
    billingInfo.counties = [];
    billingInfo.states = [];
    billingInfo.cityRequired = false;
    billingInfo.stateRequired = false;
    billingInfo.countyRequired = false;
    billingInfo.showState = false;
    billingInfo.showCity = false;
    billingInfo.showCounty = false;
    billingInfo.hasStates = false;
    billingInfo.hasCities = false;
    billingInfo.hasCounties = false;
    billingInfo.isProAccount = false;
    billingInfo.showElv = false;

    // ELV Digital Fields
    billingInfo.address1 = '';
    billingInfo.address2 = '';
    billingInfo.euddBIC = '';
    billingInfo.euddIBAN = '';

    billingInfo.openCVVModal = function() {
        $uibModal.open({
            templateUrl: 'CVVModal.html',
            size: 'md'
        });
    };
    billingInfo.displayEmailSuggestion = function() {
        return /.+@.+\..+/.test(billingInfo.billingInfo.email) && billingInfo.mailcheck.suggestion !== null;
    };

    billingInfo.serialize = function() {
        var serialized;

        serialized = {
            'order.paymentInfo.creditCardNumber': billingInfo.billingInfo.cardNumber,
            'order.paymentInfo.expireMonth': billingInfo.billingInfo.expMonth,
            'order.paymentInfo.expireYear': billingInfo.billingInfo.expYear,
            'order.paymentInfo.cvv': billingInfo.billingInfo.code,
            'order.paymentInfo.soloIssueMonth': '',
            'order.paymentInfo.soloIssueYear': '',
            'order.paymentInfo.soloIssueNumber': '',
            'order.paymentInfo.stripeToken': billingInfo.billingInfo.stripeToken,
            'order.shipTo.email': billingInfo.billingInfo.email,
            'order.paymentInfo.paymentMethod': billingInfo.paymentMethod
        };

        if (billingInfo.paymentMethod === 'EUDD') {
            serialized['order.shipTo.address1'] = billingInfo.address1;
            serialized['order.shipTo.address2'] = billingInfo.address2;
            serialized['order.paymentInfo.euddBIC'] = billingInfo.billingInfo.euddBIC;
            serialized['order.paymentInfo.euddIBAN'] = billingInfo.billingInfo.euddIBAN;
            serialized['order.shipTo.phoneNumber'] = billingInfo.billingInfo.phoneNumber;
        }

        if (billingInfo.collectPhone && billingInfo.paymentMethod !== 'EUDD') {
            serialized['order.shipTo.phoneNumber'] = billingInfo.billingInfo.phoneNumber;
        }

        if (billingInfo.collectCardholder) {
            serialized['order.' + billingInfo.billToNamePath] = billingInfo.billingInfo.name;
        }

        if (!OrderFormService$.controllers.shippingInfo) {
            serialized['order.shipTo.countryId'] = billingInfo.country ? billingInfo.country.id : '1';
            serialized['order.shipTo.zip'] = billingInfo.billingInfo.zip;
            serialized['order.shipTo.city'] = billingInfo.billingInfo.city;
            serialized['order.shipTo.state'] = billingInfo.billingInfo.state;
            serialized['order.shipTo.county'] = billingInfo.billingInfo.county;
        }

        return serialized;
    };

    billingInfo.serializeAbandonedOrder = function() {
        var serialized;

        serialized = {
            'email': billingInfo.billingInfo.email,
            'phoneNumber': billingInfo.billingInfo.phoneNumber
        };

        if (OrderFormMeta.gdprstatus) {
            serialized.fromGdprCountry = OrderFormMeta.isGdprCountry;
        }

        if (!OrderFormService$.controllers.shippingInfo) {
            serialized.zip = billingInfo.billingInfo.zip;
            serialized.country = billingInfo.country ? billingInfo.country.code : '';
        }

        return serialized;
    };

    billingInfo.sendAbandonedOrderData = function(data) {
        if (!OrderFormService$.controllers.shippingInfo) {
            billingInfo.orderForm.sendAbandonedOrderData(data);
        }
    };

    billingInfo.updatePaymentMethodData = function(newJSON) {
        if (newJSON) {
            billingInfo.stripeAccepted = newJSON.stripeAccepted;
            billingInfo.paypalAdaptiveAccepted = newJSON.paypalAdaptiveAccepted;
            billingInfo.paypalAccepted = newJSON.paypalAccepted;
            billingInfo.cardAccepted = newJSON.cardAccepted;

            if (!billingInfo.paymentMethod) {
                if (newJSON.paymentMethod) {
                    billingInfo.paymentMethod = newJSON.paymentMethod;
                } else if (billingInfo.stripeAccepted) {
                    billingInfo.paymentMethod = 'STRIPE';
                } else if (billingInfo.paypalAdaptiveAccepted) {
                    billingInfo.paymentMethod = 'PAYPAL_ADAPTIVE';
                } else if (billingInfo.paypalAccepted) {
                    billingInfo.paymentMethod = 'PYPL';
                } else if (billingInfo.cardAccepted) {
                    billingInfo.paymentMethod = 'CARD';
                } else if (billingInfo.showElv) {
                    billingInfo.paymentMethod = 'EUDD';
                } else {
                    billingInfo.paymentMethod = '';
                }
            }
        }
    };

    billingInfo.recalculate = function(bypassChecks) {
        var newZip;

        if (bypassChecks) {
            OrderFormService$.recalculate();
        } else {
            newZip = billingInfo.billingInfo.zip;

            if (newZip && newZip !== '' && newZip !== billingInfo.oldZip) {
                billingInfo.oldZip = newZip;

                OrderFormService$.recalculate();
            }
        }
    };

    billingInfo.updateJSON = function(newJSON) {
        var i, j;

        if (angular.equals(newJSON, {})) {
            return;
        }

        billingInfo.billingInfo = {
            name: !OrderFormMeta.physical && newJSON[ 'order\\.shipTo\\.fullName' ] ? newJSON[ 'order\\.shipTo\\.fullName' ] : billingInfo.billingInfo.name,
            email: newJSON[ 'order\\.shipTo\\.email' ] || billingInfo.billingInfo.email,
            phoneNumber: newJSON[ 'order\\.shipTo\\.phoneNumber' ] || billingInfo.billingInfo.phoneNumber,
            zip: newJSON[ 'order\\.shipTo\\.zip' ] || '',
            city: newJSON[ 'order\\.shipTo\\.city' ] || '',
            state: newJSON[ 'order\\.shipTo\\.state' ] || '',
            country: newJSON[ 'order\\.shipTo\\.country' ],
            countryId: newJSON[ 'order\\.shipTo\\.countryId' ],
            county: newJSON[ 'order\\.shipTo\\.county' ] || '',
            cardNumber: billingInfo.billingInfo.cardNumber,
            expMonth: billingInfo.billingInfo.expMonth || _getCurrentMonth(),
            expYear: billingInfo.billingInfo.expYear || new Date().getFullYear(),
            code: billingInfo.billingInfo.code,
            stripeToken: billingInfo.billingInfo.stripeToken,
            euddBIC: billingInfo.billingInfo.euddBIC,
            euddIBAN: billingInfo.billingInfo.euddIBAN
        };

        billingInfo.countries = OrderFormService$.sortCountries(newJSON.countries);
        billingInfo.country = OrderFormService$.findCountry(billingInfo.countries, billingInfo.billingInfo.countryId);

        billingInfo.cities = newJSON.cities;
        billingInfo.counties = newJSON.counties;
        billingInfo.states = newJSON.states;
        billingInfo.cityRequired = newJSON.cityRequired;
        billingInfo.countyRequired = newJSON.countyRequired;
        billingInfo.stateRequired = newJSON.stateRequired;

        _updateAddress(newJSON);

        if (billingInfo.expMonths.length === 0) {
            for (i = 1; i <= 12; i++) {
                billingInfo.expMonths.push(i < 10 ? '0' + i : i);
            }
        }

        if (billingInfo.expYears.length === 0) {
            for (i = new Date().getFullYear(), j = i + 20; i <= j; i++) {
                billingInfo.expYears.push(i);
            }
        }

        billingInfo.updatePaymentMethodData(newJSON);

        billingInfo.isTestPurchase = newJSON.isTestPurchaseOnly;
        billingInfo.ccBrands = newJSON[ 'avail_brands' ];
        if (billingInfo.isSplitTestFeatureEnabled('Credit Card Logo Order')) {
            billingInfo.ccBrands = _sortCcBrands(billingInfo.ccBrands);
        }
        billingInfo.collectPhone = newJSON.phoneNumberRequired;
        billingInfo.collectPhoneNumberForProduct = OrderFormMeta.collectPhoneForProduct;
        billingInfo.billToNamePath = newJSON.billToNamePath;
        billingInfo.isProAccount = newJSON.isProAccount;
        billingInfo.collectCardholder = true;
        billingInfo.physical = OrderFormMeta.physical;
        billingInfo.showElv = _shouldShowElv();

        if (billingInfo.paymentMethod === 'EUDD' && !billingInfo.showElv) {
            billingInfo.paymentMethod = 'CARD';
        }

        if (!billingInfo.isProAccount && !billingInfo.physical) {
            billingInfo.showCity = _shouldShowCity();
            billingInfo.showCounty = _shouldShowCounty();
            billingInfo.showState = _shouldShowState();

            billingInfo.hasStates = billingInfo.states && billingInfo.states.length > 0;
            billingInfo.hasCities = billingInfo.cities && billingInfo.cities.length > 0;
            billingInfo.hasCounties = billingInfo.counties && billingInfo.counties.length > 0;
        }

        if (!billingInfo.showState) {
            billingInfo.billingInfo.state = '';
        }

        if (!billingInfo.showCity) {
            billingInfo.billingInfo.city = '';
        }

        if (!billingInfo.showCounty) {
            billingInfo.billingInfo.county = '';
        }
    };

    billingInfo.isSplitTestFeatureEnabled = function(name) {
        return OrderFormService$.isSplitTestFeatureEnabled(name);
    };

    billingInfo.getTemplate = function() {
        var featureEnabled = billingInfo.isSplitTestFeatureEnabled('ofv-remove-customer-information-label');

        if (featureEnabled === true) {
            return 'BillingInfoVariant.html';
        } else {
            return 'BillingInfo.html';
        }
    };

    billingInfo.onChangeBillingCountry = function() {
        billingInfo.recalculate(true);
        billingInfo.sendAbandonedOrderData(billingInfo.country);
    };

    OrderFormService$.addController('billingInfo', billingInfo);

    Array.prototype.remove = function(from, to) {
        var rest = this.slice((to || from) + 1 || this.length);
        this.length = from < 0 ? this.length + from : from;
        return this.push.apply(this, rest);
    };

    function _sortCcBrands(ccBrands) {
        switch (OrderFormService$.getCurrency().code) {
            case 'USD' :
                return _sort(ccBrands, [ 'visa', 'mastercard', 'amex', 'discover', 'diners', 'jcb' ]);
            case 'EUR' :
                return _sort(ccBrands, [ 'visa', 'mastercard', 'carte_bleue', 'maestro' ]);
            case 'JPY' :
                return _sort(ccBrands, [ 'visa', 'mastercard', 'jcb' ]);
            default :
                return _sort(ccBrands, [ 'visa', 'mastercard' ]);
        }
    }

    function _sort(ccBrands, cardsToPutFirst) {
        var sorted = [];
        if (ccBrands !== undefined && ccBrands.length > 0 && cardsToPutFirst !== undefined) {
            for (var i in cardsToPutFirst) {
                if (cardsToPutFirst.hasOwnProperty(i)) {
                    var cardName = cardsToPutFirst[i];
                    var cardIndex = ccBrands.indexOf(cardName);
                    if (cardIndex !== -1) {
                        ccBrands.remove(cardIndex);
                        sorted.push(cardName);
                    }
                }
            }
        }
        if (ccBrands.length > 0) {
            sorted = sorted.concat(ccBrands);
        }
        return sorted;
    }

    function _updateAddress(json) {
        var newAddress1 = json['order\\.shipTo\\.address1'];
        billingInfo.address1 = newAddress1 === 'null' ? '' : newAddress1;
        var newAddress2 = json['order\\.shipTo\\.address2'];
        billingInfo.address2 = newAddress2 === 'null' ? '' : newAddress2;
    }

    function _shouldShowElv() {
        var countryCode;
        countryCode = billingInfo.country && billingInfo.country.code;
        return OrderFormService$.json.euddAccepted &&
            OrderFormService$.getCurrency().code === 'EUR' &&
            (countryCode === 'DE' || countryCode === 'AT');
    }

    function _getCurrentMonth() {
        var month = new Date().getMonth() + 1;

        if (month < 10) {
            return '0' + month;
        }

        return month;
    }

    function _shouldShowCity() {
        var countryCode = billingInfo.country && billingInfo.country.code;
        return (countryCode === 'US' && _shouldShowField(billingInfo.cityRequired, billingInfo.cities)) || billingInfo.paymentMethod === 'EUDD';
    }

    function _shouldShowState() {
        var countryCode = billingInfo.country && billingInfo.country.code;
        return countryCode !== 'DE' && countryCode !== 'AT' && _shouldShowField(billingInfo.stateRequired, billingInfo.states);
    }

    function _shouldShowCounty() {
        return billingInfo.countyRequired && billingInfo.counties && billingInfo.counties.length > 1;
    }

    function _shouldShowField(requiredField, availableOptionsForField) {
        return requiredField && availableOptionsForField && availableOptionsForField.length > 1;
    }
}
})();
(function() {
'use strict';
ExitOffer.$inject = ["ExitOfferService$", "$timeout", "$location", "OrderFormService$", "$document", "OrderFormMeta", "EXIT_OFFER_TRIGGER_TOP_VALUE_PX", "EXIT_OFFER_REDIRECT_PARAM", "EXIT_OFFER_REDIRECT_TYPE"];
angular
    .module('Orders')
    .component('exitOffer', {
        templateUrl: 'ExitOffer.html',
        require: { orderForm: '^orderForm' },
        controller: ExitOffer
    })
    .constant({
        'EXIT_OFFER_TRIGGER_TOP_VALUE_PX': 10,
        'EXIT_OFFER_REDIRECT_PARAM': 'cbeor',
        'EXIT_OFFER_REDIRECT_TYPE': 'NEW_ORDER_FORM'
    });

function ExitOffer(ExitOfferService$, $timeout, $location, OrderFormService$, $document, OrderFormMeta,
                   EXIT_OFFER_TRIGGER_TOP_VALUE_PX, EXIT_OFFER_REDIRECT_PARAM, EXIT_OFFER_REDIRECT_TYPE) {

    var exitOffer = this;
    var exitOfferData = OrderFormMeta.eodata;
    var buttonCssMap = {
        'LEFT': 'text-left',
        'CENTER': 'text-center',
        'RIGHT': 'text-right',
        'SMALL': 'btn-sm',
        'MEDIUM': '',
        'LARGE': 'btn-lg',
        'ARIAL': 'Arial, "Helvetica Neue", Helvetica, sans-serif',
        'HELVETICA': '"Helvetica Neue", Helvetica, Arial, sans-serif',
        'VERDANA': 'Verdana, Geneva, sans-serif'
    };
    exitOffer.isExitOfferEnabled = true;

    if (OrderFormMeta.eostatus && OrderFormMeta.eodata && !OrderFormMeta.eoredirect) {
        _setExitOfferDetails();

        if (exitOfferData.buttonAction === EXIT_OFFER_REDIRECT_TYPE) {
            _buildExitOfferRedirectUrl();
        }

        _enableExitOffer();
    }

    //////////////

    function _setExitOfferDetails() {
        exitOffer.styles = {
            button: {
                container: {
                    'size': buttonCssMap[exitOfferData.buttonSize]
                },
                style: {
                    'align': buttonCssMap[exitOfferData.buttonPosition],
                    'background-color': exitOfferData.buttonBackgroundColor,
                    'font-family': buttonCssMap[exitOfferData.buttonFontFamily],
                    'color': exitOfferData.buttonFontColor
                }
            }
        };

        // custom/advanced css
        if (exitOfferData.css) {
            if (exitOfferData.css.includes('#modal-button-container')) {
                exitOffer.styles.button.container = {};
            }
            if (exitOfferData.css.includes('#modal-button-ql-editor')) {
                exitOffer.styles.button.style = {};
            }
        }

        exitOffer.actionType = exitOfferData.buttonAction;
        exitOffer.type = exitOfferData.type;
        exitOffer.css = exitOfferData.css;
        exitOffer.text = {
            header: exitOfferData.headerText,
            body: exitOfferData.bodyText,
            button: exitOfferData.buttonText
        };
        exitOffer.id = exitOfferData.id;
    }

    function _buildExitOfferRedirectUrl() {
        if (exitOfferData.buttonAction === EXIT_OFFER_REDIRECT_TYPE && exitOfferData.buttonActionUrl) {
            var serverName = OrderFormMeta.server;
            if (serverName.startsWith('www.') || serverName.startsWith('ssl.')) {
                var charactersToRemove = 4;
                serverName = serverName.substring(charactersToRemove);
            }
            var url = exitOfferData.buttonActionUrl.replace('SERVER', serverName);
            var exitOfferRedirectUrl = new URL(url);
            exitOfferRedirectUrl.searchParams.append(EXIT_OFFER_REDIRECT_PARAM, exitOfferData.id);
            exitOffer.actionUrl = exitOfferRedirectUrl;
        }
    }

    function _enableExitOffer() {
        $timeout(function() {
            $document.on('mouseleave', function(event) {
                if (exitOffer.isExitOfferEnabled) {
                    var top = event.pageY;
                    var isTargetSelector = event.target.tagName === 'SELECT';
                    if (top < EXIT_OFFER_TRIGGER_TOP_VALUE_PX && !isTargetSelector) {
                        exitOffer.isExitOfferEnabled = false;
                        ExitOfferService$.openExitOffer(exitOffer);
                    }
                }
            });
        }, 5000); //5sec.
    }
}
})();
(function() {
'use strict';
ExitOfferService$.$inject = ["$uibModal"];
angular
    .module('Orders')
    .service('ExitOfferService$', ExitOfferService$);

function ExitOfferService$($uibModal) {

    var service = {
        openExitOffer: openExitOffer
    };

    return service;

    ///////////////

    function openExitOffer(exitOfferDetails) {
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            backdrop: 'static',
            templateUrl: 'modalContent.html',
            controller: 'ModalInstanceCtrl',
            controllerAs: '$ctrl',
            resolve: {
                data: function() {
                    return {
                        styles: exitOfferDetails.styles,
                        text: exitOfferDetails.text,
                        actionType: exitOfferDetails.actionType,
                        type: exitOfferDetails.type,
                        css: exitOfferDetails.css,
                        actionUrl: exitOfferDetails.actionUrl,
                        exitOfferId: exitOfferDetails.id
                    };
                }
            }
        });

        //no-op. Otherwise it complains it is not here.
        modalInstance.result.then(function() {
            // no-op
        }, function() {
            // no-op
        });
    }
}
})();
(function() {
'use strict';
I18nService$.$inject = ["$log", "$locale", "gettextCatalog", "OrderFormMeta"];
angular
    .module('Orders')
    .service('I18nService$', I18nService$);

function I18nService$($log, $locale, gettextCatalog, OrderFormMeta) {
    var i18nService = this;

    i18nService.defaultLanguage = { name: 'English', code: 'en' };

    i18nService.setCurrentLanguage = function(language, callback) {
        var code, lang, remotePromise;

        code = language.code || language;
        lang = _normalizeLanguageCode(code);

        try {
            remotePromise = gettextCatalog.loadRemote(OrderFormMeta.ctx + '/app-orderform/dist/i18n/app-strings-' + lang + '.json');

            if (callback) {
                remotePromise.then(function() {
                    callback();
                }, function() {
                    callback();
                });
            }

            gettextCatalog.setCurrentLanguage(lang);
        } catch (error) {
            $log.warn('Error loading translations for ' + lang + ': ' + error);
            gettextCatalog.setCurrentLanguage(i18nService.defaultLanguage.code);
        }

        $locale.id = gettextCatalog.getCurrentLanguage();
    };

    function _normalizeLanguageCode(code) {
        var splitLocale, normalizedCode, splitLocaleLength;

        splitLocale = code.split('-');
        splitLocaleLength = splitLocale.length;
        normalizedCode = splitLocale[0].toLowerCase();

        if (splitLocaleLength > 1) {
            normalizedCode += '_' + splitLocale[1].toUpperCase();
        }

        if (splitLocaleLength > 2) {
            normalizedCode += splitLocale.slice(2).join('_');
        }

        return normalizedCode;
    }
}
})();
(function() {
'use strict';
ModalInstanceCtrl.$inject = ["$uibModalInstance", "data", "$sce", "OrderFormService$"];
angular
    .module('Orders')
    .controller('ModalInstanceCtrl', ModalInstanceCtrl);

function ModalInstanceCtrl($uibModalInstance, data, $sce, OrderFormService$) {
    var $ctrl = this;

    $ctrl.data = data;
    $ctrl.exitOfferAction = '';
    $ctrl.ok = ok;
    $ctrl.cancel = cancel;
    $ctrl.trustHtml = trustHtml;
    $ctrl.serialize = serialize;

    ////////////////

    function ok() {
        $ctrl.exitOfferAction = 'NEW_ORDER_FORM';
        $uibModalInstance.close();
    }

    function cancel() {
        $ctrl.exitOfferAction = 'STAY';
        $uibModalInstance.dismiss('cancel');
    }

    function trustHtml(string) {
        return $sce.trustAsHtml(string);
    }

    function serialize() {
        var serialized = {
            'order.exitOfferId': $ctrl.data.exitOfferId
        };

        return serialized;
    }

    OrderFormService$.addController('ModalInstanceCtrl', $ctrl);
}
})();
(function() {
'use strict';
OrderBump.$inject = ["$scope", "OrderFormService$", "$log"];
angular
    .module('Orders')
    .component('orderBump', {
        templateUrl: 'OrderBump.html',
        require: { orderForm: '^orderForm' },
        controller: OrderBump
    });

function OrderBump($scope, OrderFormService$, $log) {
    // controller definition
    var orderbump = this;

    orderbump.bumpItems = [];
    orderbump.bumpItemsCopy = [];
    orderbump.isProAccount = false;
    orderbump.orderFormSkinType = '';
    orderbump.bumpBgColor = '#f8f8f8';

    orderbump.serialize = function(action) {
        var serialized;

        serialized = {};

        if (action === 'BUMP' || action === 'TRANSLATE') {
            _getSelectedBumps();

            angular.extend(serialized, {
                'bsks': orderbump.selectedBumps
            });
        }

        return serialized;
    };

    orderbump.handleClick = function(event, orderBumpItem) {
        if (event.target.tagName === 'INPUT') {
            orderBumpItem.clicked = true;
            orderBumpItem.loading = true;
            OrderFormService$.processBump();
        }
    };

    orderbump.resetBumps = function() {
        if (orderbump.bumpItemsCopy) {
            orderbump.bumpItems = angular.copy(orderbump.bumpItemsCopy);
        }
    };

    $scope.$watch(
        function watchJSON() {
            return OrderFormService$.json;
        }, function handleJSONChange(newJSON, oldJSON) {
            if (angular.equals(newJSON, {})) {
                return;
            }

            orderbump.bumpItems = newJSON.bumpItems.map(_transformBumpItem);
            orderbump.bumpItemsCopy = angular.copy(orderbump.bumpItems);
            orderbump.isProAccount = newJSON.isProAccount;
            orderbump.orderFormSkinType = _setSkinType(newJSON.orderFormSkinType);
        }, true //provides deeper watch
    );

    function _transformBumpItem(bumpItem) {
        return {
            id: bumpItem[ 'ob.id' ],
            text: bumpItem[ 'ob.text' ],
            image: bumpItem[ 'ob.img' ],
            nextRebillDate: bumpItem.nextRebillDate,
            convertedInitialPrice: bumpItem[ 'ob.cInitialPrice' ],
            convertedPrice: bumpItem[ 'ob.cPrice' ],
            convertedSubsequentPrice: bumpItem[ 'ob.cSubsequentPrice' ],
            initialPrice: bumpItem[ 'ob.initialPrice' ],
            price: bumpItem[ 'ob.price' ],
            recurring: bumpItem[ 'ob.recurring' ],
            subsequentPrice: bumpItem[ 'ob.subsequentPrice' ],
            productId: bumpItem[ 'obp.id' ],
            itemNo: bumpItem[ 'obp.itemNo' ],
            recurringAcceptance: bumpItem[ 'obrt.acceptance' ],
            recurringBilledOn: bumpItem[ 'obrt.billedOn' ],
            recurringDescription: bumpItem[ 'obrt.description' ],
            recurringFuture: bumpItem[ 'obrt.future' ],
            recurringTerms: bumpItem[ 'obrt.terms' ],
            selected: bumpItem.selected,
            isDelayedDelivery: bumpItem[ 'ob.delayedDelivery' ],
            delayedDeliveryText: bumpItem[ 'ob.delayedDeliveryText' ],
            isBumpDigitalDownload: _isBumpDigitalDownload(bumpItem)
        };
    }

    function _setSkinType(skinType) {
        if ('undefined' !== typeof skinType) {
            switch (skinType) {
                case 'BASIC':
                    orderbump.bumpBgColor = 'transparent';
                    break;
                case 'BASIC_PRO':
                    orderbump.bumpBgColor = 'transparent';
                    break;
                case 'ADVANCED':
                    orderbump.bumpBgColor = 'transparent';
                    break;
                case 'ADVANCED_NG':
                    orderbump.bumpBgColor = 'transparent';
                    break;
                case 'None':
                    orderbump.bumpBgColor = '#f8f8f8';
                    break;
                default:
                    orderbump.bumpBgColor = '#f8f8f8';
            }
        }
    }

    function _isBumpDigitalDownload(bumpItem) {
        return bumpItem[ 'ob.isDigital' ];

    }

    function _getSelectedBumps() {
        var selectedBumps;

        selectedBumps = [];

        orderbump.bumpItems.forEach(function(element, index, array) {
            if (element.selected) {
                selectedBumps.push(element.itemNo);
            }
        });

        orderbump.selectedBumps = selectedBumps.join(',');
    }

    OrderFormService$.addController('orderbump', orderbump);
}
})();
(function() {
'use strict';
OrderForm.$inject = ["$document", "$scope", "$timeout", "$window", "OrderFormService$", "AbandonedOrderService$", "I18nService$", "OrderFormMeta"];
angular
    .module('Orders')
    .component('orderForm', {
        templateUrl: 'OrderForm.html',
        controller: OrderForm
    })
    .config(["$sceDelegateProvider", function($sceDelegateProvider) {
        $sceDelegateProvider.resourceUrlWhitelist([
            'self', // trust all resources from the same origin
            '*://www.youtube.com/**' // trust all resources from `www.youtube.com`
        ]);
    }]);

function OrderForm($document, $scope, $timeout, $window, OrderFormService$, AbandonedOrderService$, I18nService$, OrderFormMeta) {

    var ORDER_PROPERTY_TO_FORM_FIELD_MAP = {
        'order.paymentInfo.creditCardNumber': 'cardNumber',
        'order.paymentInfo.expireMonth': 'expMonth',
        'order.paymentInfo.expireYear': 'expYear',
        'order.paymentInfo.cvv': 'securityCode',
        'order.paymentInfo.euddBIC': 'euddBIC',
        'order.paymentInfo.euddIBAN': 'euddIBAN',
        'order.billTo.fullName': 'cardholderName',
        'order.shipTo.fullName': 'fullName',
        'order.shipTo.email': 'email',
        'order.shipTo.address1': 'shippingAddress1',
        'order.shipTo.address2': 'shippingAddress2',
        'order.shipTo.city': 'shippingCity',
        'order.shipTo.zip': 'shippingZip',
        'order.shipTo.state': 'shippingState',
        'order.shipTo.countryId': 'shippingCountry',
        'order.shipTo.county': 'shippingCounty',
        'order.shipTo.phoneNumber': 'phone',
        'order.coupon': 'couponCode'
    };

    // controller definition
    var orderForm = this;

    orderForm.initv = '';
    orderForm.story = '';
    orderForm.isCart = false;
    orderForm.hasAnyDelayedDeliveryItems = false;
    orderForm.isPhysical = false;
    orderForm.recurring = false;
    orderForm.hasOrderBumps = false;
    orderForm.acceptedTerms = false;
    orderForm.showCbBranding = false;
    orderForm.submitDisabled = false;
    orderForm.errors = {};
    orderForm.paykey = '';
    orderForm.isTestPurchase = false;
    orderForm.isUnapprovedSkin = false;
    orderForm.testPurchaseReason = '';
    orderForm.languages = OrderFormMeta.languages;
    orderForm.selectedLanguage = undefined;
    orderForm.affiliateMessage = OrderFormMeta.affiliateMessage;
    orderForm.lifeTimeCommission = OrderFormMeta.lifetimeCommissionEnabled || false;
    orderForm.showAffiliate = _shouldShowAffiliate();
    orderForm.headerImage = OrderFormMeta.header ? OrderFormMeta.ctx + OrderFormMeta.header : '';
    orderForm.isProAccount = false;
    orderForm.flexibleRefundEnabled = false;
    orderForm.wamBaseUrl = OrderFormService$.getWamBaseUrl();
    orderForm.orderFormKaptcha = OrderFormMeta.orderFormKaptcha;
    orderForm.kaptchaUrl = OrderFormMeta.kaptchaUrl;
    orderForm.nortonLogo = OrderFormMeta.nortonLogo;
    orderForm.sid = OrderFormMeta.sid;
    orderForm.europeanUnion = OrderFormMeta.isEuropeanUnion;
    orderForm.gdprCountries = OrderFormMeta.gdprCountries;
    orderForm.isClickBankMarketingAccepted = false;
    orderForm.isVendorMarketingAccepted = false;
    orderForm.isGdprCustomer = false;
    orderForm.isGdprCountry = OrderFormMeta.isGdprCountry;
    orderForm.country = OrderFormMeta.country;
    orderForm.isMobile = false;
    orderForm.trusteUrl = '';
    orderForm.trusteImgUrl = '';
    orderForm.kountImgUrl = 'dist/assets/Kount_Secure.png';
    orderForm.formTitle = OrderFormService$.json.formTitle ? OrderFormService$.json.formTitle : 'Secure Checkout';

    orderForm.getShowCustomBasicHeader = function(image, skinType) {
        return !!image && skinType === 'BASIC_PRO';
    };
    orderForm.getShowVideo = function(skinType, videoId) {
        return !!videoId && skinType === 'ADVANCED_VIDEO_NG';
    };
    orderForm.isVideoAutoplay = function() {
        return !!OrderFormMeta.videoAutoplay;
    };
    orderForm.getVSLUrl = function() {
        return 'https://www.youtube.com/embed/' + OrderFormMeta.videoId + '?controls=0&showinfo=0&modestBranding=1&rel=0&loop=1' + (orderForm.isVideoAutoplay() ? '&autoplay=1' : '');
    };
    orderForm.skinType = OrderFormMeta.skinType;
    orderForm.showVideo = orderForm.getShowVideo(OrderFormMeta.skinType, OrderFormMeta.videoId);

    orderForm.showCustomBasicHeader = orderForm.getShowCustomBasicHeader(orderForm.headerImage, OrderFormMeta.skinType);
    orderForm.billingSoftDescriptor = OrderFormMeta.billingSoftDescriptor ? OrderFormMeta.billingSoftDescriptor : 'COM';

    orderForm.submit = function(isValid) {
        var paymentType;

        if (isValid) {
            paymentType = OrderFormService$.getPaymentType();

            if (paymentType === 'STRIPE') {
                OrderFormService$.submitForStripe();
            } else if (paymentType === 'PAYPAL_ADAPTIVE') {
                OrderFormService$.submit();
            } else {
                OrderFormService$.submit();
            }
        } else {
            var error = $scope.orderForm.$error;

            for (var errorType in error) {
                if (error.hasOwnProperty(errorType)) {
                    /* jshint ignore:start */
                    angular.forEach(error[errorType], function(errorObject, index) {
                        var errorObjectName = errorObject.$name;
                        $scope.orderForm[errorObjectName].$setValidity(errorType, false);
                        $scope.orderForm[errorObjectName].$setDirty();
                        $scope.orderForm[errorObjectName].$setTouched();
                    });
                    /* jshint ignore:end */
                }
            }
            _jumpToFirstInvalidField();
        }
    };

    orderForm.serialize = function(action) {
        var serialized;

        serialized = {
            'order.javascriptDisabled': 0,
            'initv': orderForm.initv,
            'sessionId': OrderFormMeta.sid,
            'hopId': '',
            'storyName': '',
            'locale': orderForm.selectedLanguage.code,
            'order.currency': 'USD'
        };

        if (action === 'SUBMIT') {
            angular.extend(serialized, {
                'order.acceptedTerms': orderForm.acceptedTerms,
                'order.story': orderForm.story,
                'paykey': orderForm.paykey,
                'altc': OrderFormMeta.altc || false
            });
            if (orderForm.isGdprCustomer) {
                angular.extend(serialized, {
                    'order.gdprData.clickbankConsent': orderForm.isClickBankMarketingAccepted,
                    'order.gdprData.vendorConsent': orderForm.isVendorMarketingAccepted
                });
            }
        } else if (action === 'TRANSLATE') {
            angular.extend(serialized, {
                'refresh': true
            });
        }

        return serialized;
    };

    orderForm.serializeAbandonedOrder = function() {
        var serialized;

        serialized = {
            'language': orderForm.selectedLanguage.code,
            'initv': orderForm.initv,
            'vvvv': AbandonedOrderService$.getSiteParameter($window.location.search),
            'vvar': AbandonedOrderService$.getVendorVariable($window.location.search)
        };

        return serialized;
    };

    orderForm.parseErrors = function(errors) {
        var scope = $scope;

        orderForm.clearErrors();
        orderForm.errors.general = [];

        if (errors && errors.length > 0) {
            angular.forEach(errors, function(error, index) {
                if (error.defaultMsg) {
                    var targetField;

                    if (error.field) {

                        // This can either mean the CC name (digital) or Shipping name (physical) so we need to identify which it is
                        if (error.field === 'order.shipTo.fullName' && OrderFormService$.getBillToNamePath() === 'shipTo.fullName') {
                            error.field = 'order.billTo.fullName';
                        }

                        targetField = scope.orderForm[ORDER_PROPERTY_TO_FORM_FIELD_MAP[error.field]];

                        // name could have come from either cardholder name or EUDD account name field
                        if (!targetField && error.field === 'order.billTo.fullName' && scope.orderForm.accountName) {
                            targetField = scope.orderForm.accountName;
                        }
                    }

                    if (targetField) {
                        $timeout(function() {
                            targetField.$setValidity('server', false);
                            targetField.$setDirty();
                        });
                        orderForm.errors[targetField.$name] = error.defaultMsg;
                    } else {
                        orderForm.errors.general.push(error.defaultMsg);
                    }
                }
            });

            scope.orderForm.$setSubmitted();
        }
    };

    orderForm.getShoppingCartController = function() {
        return OrderFormService$.controllers.shoppingCart;
    };

    orderForm.processStripeTokenError = function(error) {
        var targetField;
        var scope = $scope;

        switch (error.code) {
            case 'incorrect_number' :
            case 'invalid_number' :
                targetField = scope.orderForm.cardNumber;
                break;
            case 'invalid_expiry_month' :
                targetField = scope.orderForm.expMonth;
                break;
            case 'invalid_expiry_year' :
                targetField = scope.orderForm.expYear;
                break;
            case 'invalid_cvc' :
                targetField = scope.orderForm.securityCode;
                break;
            default :
                orderForm.errors.general = orderForm.errors.general || [];
                orderForm.errors.general.push(error.message);
        }

        if (targetField) {
            $timeout(function() {
                targetField.$setValidity('stripe', false);
                targetField.$setDirty();
            });
        }
    };

    orderForm.sendAbandonedOrderData = function(toSend) {
        if (_shouldSendDataForCartAbandonment(toSend)) {
            OrderFormService$.sendAbandonedOrderData();
        }
    };

    orderForm.clearErrors = function() {
        orderForm.errors = {};
    };

    orderForm.getControllers = function() {
        return OrderFormService$.controllers;
    };

    orderForm.onChangeLanguage = function() {
        OrderFormService$.translate();

        orderForm.sendAbandonedOrderData(orderForm.selectedLanguage);
    };

    orderForm.isSplitTestFeatureEnabled = function(featureName) {
        return OrderFormService$.isSplitTestFeatureEnabled(featureName);
    };

    orderForm.shouldShowGDPRConsentInfo = function() {
        if (OrderFormMeta.gdprstatus) {
            var billingCountry = this.getControllers().billingInfo.country;

            function _isBillingAddressInGdpr() {
                var isBillingAddressInGdpr = billingCountry && this.gdprCountries.includes(billingCountry.code);
                orderForm.isGdprCustomer = isBillingAddressInGdpr;
                return isBillingAddressInGdpr;
            }

            return (billingCountry) ? _isBillingAddressInGdpr.call(this) : this.isGdprCountry;
        }

        return false;
    };

    $document.ready(function() {
        if (OrderFormService$.json && OrderFormService$.json.errors && OrderFormService$.json.errors.length > 0) {
            orderForm.parseErrors(OrderFormService$.json.errors);
            _jumpToFirstInvalidField();
        }
    });

    $scope.$watch(
        function watchJSON() {
            return OrderFormService$.json;
        }, function handleJSONChange(newJSON, oldJSON) {
            if (angular.equals(newJSON, {})) {
                return;
            }

            if (newJSON.formTitle) {
                orderForm.formTitle = newJSON.formTitle;
            }

            orderForm.initv = newJSON.initv;
            orderForm.story = newJSON.story;
            orderForm.isProAccount = newJSON.isProAccount;
            orderForm.hasOrderBumps = newJSON.bumpItems && newJSON.bumpItems.length > 0;
            orderForm.showCbBranding = _shouldShowCbBranding();
            _updateTestPurchase(newJSON);
            orderForm.recurring = newJSON.recurring;
            orderForm.isCart = newJSON.cartOrder;
            orderForm.hasAnyDelayedDeliveryItems = newJSON.hasAnyDelayedDeliveryItems;
            orderForm.isPhysical = OrderFormMeta.physical;
            orderForm.flexibleRefundEnabled = newJSON.flexibleRefundEnabled;
            orderForm.selectedLanguage = _getLanguage(newJSON.locale || I18nService$.defaultLanguage);

            if (orderForm.europeanUnion) {
                orderForm.trusteUrl = _getTrusteUrl(newJSON.locale);
                orderForm.trusteImgUrl = _getTrusteImgUrl(newJSON.locale);
            }

            orderForm.isMobile = newJSON.isMobile;

            I18nService$.setCurrentLanguage(orderForm.selectedLanguage, OrderFormService$.updateControllersJSON);
        }
    );

    function _jumpToFirstInvalidField() {
        $document[0].querySelector('input.ng-invalid, select.ng-invalid, textarea.ng-invalid').focus();
    }

    function _shouldSendDataForCartAbandonment(toSend) {
        var shouldApplyGdpr = OrderFormMeta.gdprstatus && OrderFormMeta.isGdprCountry;

        return toSend && OrderFormMeta.aostatus && !OrderFormMeta.upsell && !shouldApplyGdpr;
    }

    function _updateTestPurchase(json) {
        if (json.testPurchaseOnlyReason) {
            orderForm.isTestPurchase = true;
            orderForm.testPurchaseReason = json.testPurchaseOnlyReason;
            orderForm.isUnapprovedSkin = orderForm.testPurchaseReason === 'order_form_unapprovedSkin_testModeOnly';
        } else {
            orderForm.isTestPurchase = false;
            orderForm.isUnapprovedSkin = false;
            orderForm.testPurchaseReason = '';
        }
    }

    function _getLanguage(languageOrCode) {
        var i, language, len, code, languageCode;

        code = languageOrCode.code || languageOrCode;

        for (i = 0, len = orderForm.languages.length; i < len; i++) {
            language = orderForm.languages[i];
            languageCode = language.code;

            if (languageCode && code && languageCode.toLowerCase() === code.toLowerCase()) {
                return language;
            }
        }

        return undefined;
    }

    function _shouldShowCbBranding() {
        return !orderForm.isProAccount;
    }

    function _shouldShowAffiliate() {
        return orderForm.affiliateMessage && !orderForm.lifeTimeCommission;
    }

    function _getTrusteUrl(locale) {
        var trusteLocale = locale || 'en';
        return 'https://privacy-policy.truste.com/click-with-confidence/eusafe/' + trusteLocale.toLowerCase() + '/www.clickbank.com/seal_l';
    }

    function _getTrusteImgUrl(locale) {
        var trusteLocale = locale || 'en';
        return '//privacy-policy.truste.com/certified-seal/eusafe/' + trusteLocale.toLowerCase() + '/www.clickbank.com/seal_l.png';
    }

    OrderFormService$.addController('orderForm', orderForm);
}
})();
(function() {
'use strict';
OrderFormService$.$inject = ["$log", "$http", "$q", "$window", "$timeout", "$location", "gettextCatalog", "AbandonedOrderService$", "OrderFormMeta"];
angular
    .module('Orders')
    .service('OrderFormService$', OrderFormService$);

function OrderFormService$($log, $http, $q, $window, $timeout, $location, gettextCatalog, AbandonedOrderService$, OrderFormMeta) {
    var orderFormService = this;

    orderFormService.json = {};
    orderFormService.requests = {};
    orderFormService.abortedRequests = {};
    orderFormService.controllers = {};
    orderFormService.COMMON_COUNTRY_THRESHOLD = 20;

    orderFormService.setJSON = function(json) {
        orderFormService.json = json;
    };

    orderFormService.addController = function(name, controller) {
        if (orderFormService.controllers) {
            orderFormService.controllers[name] = controller;

            if (angular.isFunction(controller.onControllerAdded)) {
                controller.onControllerAdded();
            }
        }
    };

    orderFormService.translate = function() {
        var key, config;

        key = 'TRANSLATE';

        function successCallback(response, id) {
            if (response && response.data) {
                orderFormService.setJSON(response.data);
            }

            _cleanupRequest(key, id);

            return true;
        }

        function errorCallback(response, id) {
            _cleanupRequest(key, id);

            return true;
        }

        config = {
            method: 'POST',
            url: 'recalculate2.html;jsessionid=' + OrderFormMeta.sid,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Correlation-Id': OrderFormMeta.correlationId
            },
            transformRequest: _transformRequest,
            data: _serializeForm(key),
            responseType: 'json'
        };

        _call(key, config, successCallback, errorCallback, 15);
    };

    orderFormService.recalculate = function() {
        var countryChanged, key, config;

        countryChanged = false;
        key = 'RECALCULATE';

        function successCallback(response, id) {
            if (response && response.data) {
                orderFormService.setJSON(response.data);
            }

            _cleanupRequest(key, id);

            return true;
        }

        function errorCallback(response, id) {
            if (response.status === -1) {
            }

            _cleanupRequest(key, id);

            return true;
        }

        config = {
            method: 'POST',
            url: 'recalculate2.html;jsessionid=' + OrderFormMeta.sid,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Correlation-Id': OrderFormMeta.correlationId
            },
            transformRequest: _transformRequest,
            data: angular.extend(_serializeForm(key), { 'countryChanged': countryChanged }),
            responseType: 'json'
        };

        _call(key, config, successCallback, errorCallback, 15);
    };

    orderFormService.applyCoupon = function() {
        var key, config;

        key = 'COUPON';

        function successCallback(response, id) {
            if (response && response.data) {
                if (response.data.errors) {
                    orderFormService.controllers.orderForm.parseErrors(response.data.errors);
                }

                orderFormService.setJSON(response.data);
            }

            _cleanupRequest(key, id);

            orderFormService.controllers.paymentInfo.enableApplyButton();

            return true;
        }

        function errorCallback(response, id) {
            if (response.status === -1) {
            }

            _cleanupRequest(key, id);

            orderFormService.controllers.paymentInfo.enableApplyButton();

            return true;
        }

        config = {
            method: 'POST',
            url: 'recalculate2.html;jsessionid=' + OrderFormMeta.sid,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Correlation-Id': OrderFormMeta.correlationId
            },
            transformRequest: _transformRequest,
            data: _serializeForm(key),
            responseType: 'json'
        };

        _call(key, config, successCallback, errorCallback, 15);
    };

    orderFormService.processBump = function() {
        var key, config;

        key = 'BUMP';

        function successCallback(response, id) {
            if (orderFormService.requests) {
                orderFormService.requests[key] = undefined;
            }

            if (response && response.data) {
                orderFormService.setJSON(response.data);
            }

            return true;
        }

        function errorCallback(response, id) {
            var request, cid;

            request = orderFormService.requests[key];
            cid = request ? request.id : undefined;

            if (response.status === -1) {
                if (orderFormService.abortedRequests && orderFormService.abortedRequests[id]) {
                    delete orderFormService.abortedRequests[id];

                    return false;
                }
            }

            if (orderFormService.requests) {
                orderFormService.requests[key] = {
                    id: cid
                };

                if (orderFormService.controllers.orderbump) {
                    orderFormService.controllers.orderbump.resetBumps();
                }
            }

            return true;
        }

        config = {
            method: 'POST',
            url: 'orderBump.html;jsessionid=' + OrderFormMeta.sid,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Correlation-Id': OrderFormMeta.correlationId
            },
            transformRequest: _transformRequest,
            data: _serializeForm(key),
            responseType: 'json'
        };

        _call(key, config, successCallback, errorCallback, 15);
    };

    orderFormService.enableSubmit = function() {
        _disableSubmitButton(false);
    };

    orderFormService.submit = function() {
        var config;
        var key = 'SUBMIT';
        var startTime = new Date();

        function successCallback(response) {
            var redirectUrl;

            if (response && response.data) {
                redirectUrl = response.data.redirect;

                if (redirectUrl) {
                    if (redirectUrl.indexOf('redirect:receipt') >= 0) {
                        redirectUrl = OrderFormMeta.ctx + '/order/' + redirectUrl;
                    }

                    redirectUrl = redirectUrl.replace('redirect:', '');

                    var orderformProcessingTimeInMilliseconds = new Date() - startTime;

                    var orderformMetrics = {
                        'orderformProcessingTimeInMilliseconds': orderformProcessingTimeInMilliseconds
                    };

                    logOrderformMetricsToServer(orderformMetrics, OrderFormMeta.sid);
                    sendSubmissionMetricsToNewRelic(orderformMetrics);
                    $window.location.href = redirectUrl;

                    return false;
                } else {
                    if (response && response.data) {
                        if (response.data.errors) {
                            orderFormService.controllers.orderForm.parseErrors(response.data.errors);
                        }
                        orderFormService.setJSON(response.data);
                    } else {
                        orderFormService.controllers.orderForm.clearErrors();
                    }
                }
            }

            return true;
        }

        function errorCallback(response) {
            if (response && response.data && response.data.errors) {
                orderFormService.controllers.orderForm.parseErrors(response.data.errors);
            }

            return true;
        }

        config = {
            method: 'POST',
            url: 'pay.html;jsessionid=' + OrderFormMeta.sid,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Correlation-Id': OrderFormMeta.correlationId
            },
            transformRequest: _transformRequest,
            data: _serializeForm(key),
            responseType: 'json'
        };
        _disableSubmitButton(true);
        _call(key, config, successCallback, errorCallback, -1);
    };

    function logOrderformMetricsToServer(jsonEncodedMetrics, sessionId) {
        try {
            var config = {
                method: 'POST',
                url: OrderFormMeta.ctx + '/order/orderformMetrics.html;jsessionid=' + sessionId,
                headers: {
                    'Content-Type': 'application/json'
                },
                timeout: 2000,
                data: jsonEncodedMetrics
            };

            $http(config).then(function(response) {
            }, function(response) {
                $log.info('Logging orderform metrics failed with response: ' + response);
            });

        } catch (e) {
            $log.error('Failed to send orderform metrics to server');
        }
    }

    function sendSubmissionMetricsToNewRelic(jsonEncodedMetrics) {
        try {
            /* jshint ignore:start */
            if (typeof newrelic !== 'undefined') {
                newrelic.addPageAction('SubmitButtonClicked', jsonEncodedMetrics);
            }
            /* jshint ignore:end */
        } catch (e) {
            $log.error('Failed to update New Relic with orderform processing statistics');
        }
    }

    orderFormService.getPaymentType = function() {
        return orderFormService.controllers.billingInfo.paymentMethod;
    };

    orderFormService.getBillToNamePath = function() {
        return orderFormService.controllers.billingInfo.billToNamePath;
    };

    orderFormService.getCurrency = function() {
        return orderFormService.controllers.paymentInfo.selectedCurrency;
    };

    orderFormService.updateControllersJSON = function() {
        var controllers = orderFormService.controllers;

        if (controllers) {
            if (controllers.billingInfo) {
                controllers.billingInfo.updateJSON(orderFormService.json);
            }

            if (controllers.shippingInfo) {
                controllers.shippingInfo.updateJSON(orderFormService.json);
            }
        }
    };

    orderFormService.isCartWithSingleRecurring = function() {
        var numberOfRecurringItems = 0;
        var cartItems = getCartItemsFromShoppingCartController();

        for (var i = 0; i < cartItems.length; i++) {
            if (cartItems[i].rebill) {
                numberOfRecurringItems++;
            }
        }

        return numberOfRecurringItems === 1;
    };

    orderFormService.getFirstRebillCartItem = function() {
        var cartItems = getCartItemsFromShoppingCartController();

        for (var i = 0; i < cartItems.length; i++) {
            if (cartItems[i].rebill) {
                return cartItems[i];
            }
        }

        return {};
    };

    function getCartItemsFromShoppingCartController() {
        return orderFormService.controllers.shoppingCart.cartItems;
    }

    function groupCountries(countries) {
        return countries.map(function(country) {
            if (country.sortPriority !== 50) {
                country.group = gettextCatalog.getString('Common Countries');
                country.groupOrder = country.sortPriority;
            } else {
                country.group = gettextCatalog.getString('Other Countries');
                country.groupOrder = country.sortPriority;
            }
            return country;
        });

    }

    orderFormService.sortCountries = function(countries) {
        var sortedCountries = countries;
        if (countries.length >= orderFormService.COMMON_COUNTRY_THRESHOLD) {
            sortedCountries = groupCountries(countries);
        }
        return uniqBy(sortedCountries, function(item) { return item.alias + '_' + item.group; });
    };

    function uniqBy(a, key) {
        var seen = {};
        return a.filter(function(item) {
            var k = key(item);
            return seen.hasOwnProperty(k) ? false : (seen[k] = true);
        });
    }

    orderFormService.findCountry = function(countries, id) {
        var country;

        for (var i = 0, length = countries.length; i < length; i++) {
            country = countries[i];

            if (String(country.id) === String(id)) {
                return country;
            }
        }

        return undefined;
    };

    orderFormService.submitForStripe = function() {
        _disableSubmitButton(true);

        $window.Stripe.card.createToken({
            number: orderFormService.controllers.billingInfo.billingInfo.cardNumber,
            cvc: orderFormService.controllers.billingInfo.billingInfo.code,
            'exp_month': orderFormService.controllers.billingInfo.billingInfo.expMonth,
            'exp_year': orderFormService.controllers.billingInfo.billingInfo.expYear
        }, _stripeResponseHandler);
    };

    orderFormService.getWamBaseUrl = function() {
        return $location.$$protocol + '://' + orderFormService.json.wamBaseUrl;
    };

    orderFormService.sendAbandonedOrderData = function() {
        AbandonedOrderService$.sendAbandonedOrderData(_serializeAbandonedOrderForm());
    };

    orderFormService.isSplitTestFeatureEnabled = function(featureName) {
        var enabledSplitTestFeatures = orderFormService.json.enabledSplitTestFeatures;
        if (enabledSplitTestFeatures !== undefined && enabledSplitTestFeatures !== null) {
            for (var i = 0; i < enabledSplitTestFeatures.length; i++) {
                var name = enabledSplitTestFeatures[i];
                if (name === featureName) {
                    return true;
                }
            }
        }
        return false;
    };

    function _stripeResponseHandler(status, response) {
        if (response.error) {
            orderFormService.controllers.orderForm.processStripeTokenError(response.error);
            _disableSubmitButton(false);
        } else {
            orderFormService.controllers.billingInfo.billingInfo.stripeToken = response.id;
            orderFormService.submit();
        }
    }

    function _serializeAbandonedOrderForm() {
        var serializedAbandonedOrderForm = {};

        if (orderFormService && orderFormService.controllers) {
            angular.forEach(orderFormService.controllers, function(controller) {
                if (angular.isFunction(controller.serializeAbandonedOrder)) {
                    angular.extend(serializedAbandonedOrderForm, controller.serializeAbandonedOrder());
                }
            });
        }

        return serializedAbandonedOrderForm;
    }

    function _serializeForm(action) {
        var serializedForm;

        serializedForm = {
            action: action
        };

        if (orderFormService && orderFormService.controllers) {
            angular.forEach(orderFormService.controllers, function(controller, property) {
                angular.extend(serializedForm, controller.serialize(action));
            });
        }

        return serializedForm;
    }

    function _call(key, config, successCallback, errorCallback, timeoutInSeconds, stash) {
        var request, deferred, promise, previousRequest, timeoutPromise, uuid, puuid;

        if (!key || !config) {
            return;
        }

        previousRequest = orderFormService.requests[key];

        if (previousRequest && previousRequest.deferred) {
            previousRequest.deferred.resolve();
        }

        puuid = previousRequest && previousRequest.id;

        if (puuid) {
            orderFormService.abortedRequests[puuid] = true;
        }

        uuid = _uuid();
        deferred = $q.defer();
        promise = deferred.promise;
        config.url = OrderFormMeta.ctx + '/order/' + config.url;
        config.timeout = promise;

        request = {
            id: uuid,
            deferred: deferred,
            stash: stash
        };

        orderFormService.requests[key] = request;

        if (timeoutInSeconds && timeoutInSeconds > 0) {
            timeoutPromise = $timeout(function() {
                deferred.resolve();
            }, timeoutInSeconds * 1000);
        }

        //TODO THIS IS CAUSING THE 'FLASH' ON THE PAY BUTTON. Need to pass a prop to have more control
        //_disableSubmitButton(true);

        $http(config).then(function(response) {
            var complete;

            _clearTimeout(timeoutPromise);

            complete = successCallback(response, uuid);

            if (complete) {
                _disableSubmitButton(false);
            }
        }, function(response) {
            var complete;

            _clearTimeout(timeoutPromise);

            complete = errorCallback(response, uuid);

            if (complete) {
                _disableSubmitButton(false);
            }
        });
    }

    function _transformRequest(request) {
        var params = [];

        for (var param in request) {
            if (request.hasOwnProperty(param)) {
                params.push(encodeURIComponent(param) + '=' + encodeURIComponent(request[param] === undefined ? '' : request[param]));
            }
        }

        return params.join('&');
    }

    function _clearTimeout(timeoutPromise) {
        if (timeoutPromise) {
            $timeout.cancel(timeoutPromise);
        }
    }

    function _cleanupRequest(key, id) {
        if (orderFormService.requests) {
            orderFormService.requests[key] = undefined;
        }

        _clearAbortedRequest(id);
    }

    function _clearAbortedRequest(id) {
        if (orderFormService.abortedRequests) {
            delete orderFormService.abortedRequests[id];
        }
    }

    function _uuid() {
        return _s4() + _s4() + '-' + _s4() + '-' + _s4() + '-' + _s4() + '-' + _s4() + _s4() + _s4();
    }

    function _s4() {
        return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
    }

    function _disableSubmitButton(disabled) {
        if (orderFormService.controllers && orderFormService.controllers.orderForm) {
            orderFormService.controllers.orderForm.submitDisabled = disabled;
        }
    }
}
})();
(function() {
'use strict';
PaymentInfo.$inject = ["$scope", "OrderFormService$", "OrderFormMeta"];
angular
    .module('Orders')
    .component('paymentInfo', {
        templateUrl: 'PaymentInfo.html',
        require: { orderForm: '^orderForm' },
        controller: PaymentInfo
    });

function PaymentInfo($scope, OrderFormService$, OrderFormMeta) {
    // controller definition
    var paymentInfo = this;

    paymentInfo.isPhysical = false;
    paymentInfo.isDigital = false;
    paymentInfo.isCart = false;
    paymentInfo.hasAnyDelayedDeliveryItems = false;
    paymentInfo.recurring = true;
    paymentInfo.subtotal = '';
    paymentInfo.cartSubtotal = '';
    paymentInfo.shipping = '';
    paymentInfo.tax = '';
    paymentInfo.total = '';
    paymentInfo.couponEnabled = false;
    paymentInfo.couponApplied = false;
    paymentInfo.couponFromPaylink = undefined;
    paymentInfo.negatedCouponDiscount = '';
    paymentInfo.couponInput = '';
    paymentInfo.activeCouponCode = undefined;
    paymentInfo.disableApplyButton = false;
    paymentInfo.isProAccount = false;
    paymentInfo.isMultiCurrency = setMultiCurrency();
    paymentInfo.currencies = OrderFormMeta.currencies;
    paymentInfo.selectedCurrency = getCurrencyByCode(OrderFormMeta.selectedCurrency.code);
    paymentInfo.isVat = false;
    paymentInfo.isGstCountry = false;

    paymentInfo.serialize = function(action) {
        var serialized, couponProperties, submitProperties;

        serialized = {
            'order.currency': paymentInfo.selectedCurrency.code
        };

        if (action === 'COUPON') {
            couponProperties = {
                'order.coupon': paymentInfo.couponInput
            };

            angular.extend(serialized, couponProperties);
        } else if (action === 'SUBMIT') {
            submitProperties = {
                'order.coupon': paymentInfo.couponApplied ? paymentInfo.activeCouponCode : ''
            };

            angular.extend(serialized, submitProperties);
        }

        return serialized;
    };

    paymentInfo.applyCoupon = function() {
        var newCoupon = paymentInfo.couponInput;

        if (newCoupon && newCoupon !== '' && newCoupon !== paymentInfo.activeCouponCode) {
            paymentInfo.disableApplyButton = true;
            OrderFormService$.applyCoupon();
        }
    };

    paymentInfo.enableApplyButton = function() {
        paymentInfo.disableApplyButton = false;
    };

    paymentInfo.changeCurrency = function() {
        OrderFormService$.recalculate();
    };

    function setMultiCurrency() {
        return !paymentInfo.isProAccount;
    }

    function getCurrencyByCode(currencyCode) {
        for (var i = 0; i < paymentInfo.currencies.length; ++i) {
            if (paymentInfo.currencies[i].code === currencyCode) {
                return paymentInfo.currencies[i];
            }
        }
    }

    function updateCurrency(json) {
        paymentInfo.isProAccount = json.isProAccount;
        paymentInfo.isMultiCurrency = setMultiCurrency();

        if (paymentInfo.isMultiCurrency) {
            var currency = getCurrencyByCode(json.currency);
            if (currency) {
                paymentInfo.selectedCurrency = currency;
            }
        }
    }

    paymentInfo.clearCouponError = function() {
        OrderFormService$.controllers.orderForm.errors.couponCode = '';
    };

    paymentInfo.serializeAbandonedOrder = function() {
        var serialized;

        serialized = {
            'currency': paymentInfo.selectedCurrency.code,
            'coupon': paymentInfo.couponInput
        };

        return serialized;
    };

    paymentInfo.onChangeCouponCode = function() {
        paymentInfo.clearCouponError();

        paymentInfo.orderForm.sendAbandonedOrderData(paymentInfo.couponInput);
    };

    paymentInfo.onChangeCurrency = function() {
        paymentInfo.changeCurrency();

        paymentInfo.orderForm.sendAbandonedOrderData(paymentInfo.selectedCurrency);
    };

    $scope.$watch(
        function watchJSON() {
            return OrderFormService$.json;
        }, function handleJSONChange(newJSON, oldJSON) {
            var firstItem;

            if (angular.equals(newJSON, {})) {
                return;
            }

            paymentInfo.isPhysical = OrderFormMeta.physical;
            paymentInfo.isDigital = newJSON.digital;
            paymentInfo.recurring = newJSON.recurring;
            paymentInfo.isCart = newJSON.cartOrder;
            paymentInfo.hasAnyDelayedDeliveryItems = newJSON.hasAnyDelayedDeliveryItems;

            paymentInfo.tax = newJSON.tax;
            //jscs:disable requireCamelCaseOrUpperCaseIdentifiers
            paymentInfo.isVat = newJSON.tax_type === 'vat';
            paymentInfo.isGstCountry = newJSON.tax_type === 'gst';
            paymentInfo.total = newJSON.total;
            paymentInfo.shipping = paymentInfo.isPhysical ? newJSON.preDiscountShipping : '*';
            paymentInfo.couponEnabled = newJSON.couponEnabled;
            paymentInfo.subtotal = newJSON.subtotal;
            paymentInfo.cartSubtotal = newJSON.cartSubtotal;
            paymentInfo.couponApplied = newJSON.couponApplied;
            paymentInfo.negatedCouponDiscount = newJSON.negatedCouponDiscount;
            paymentInfo.updateCurrencyTranslations(newJSON.currencyList);

            firstItem = newJSON.items[0];

            if (paymentInfo.couponFromPaylink === undefined) {
                paymentInfo.couponFromPaylink = newJSON.couponFromPaylink;
            }

            if (paymentInfo.couponApplied) {
                paymentInfo.activeCouponCode = newJSON.activeCouponCode;
                paymentInfo.couponInput = '';
            } else {
                paymentInfo.activeCouponCode = undefined;
            }

            if (paymentInfo.isProAccount) {
                if (newJSON.baseOrderSize > 1) {
                    if (!newJSON.isFreeCart) {
                        paymentInfo.cartSubtotal = newJSON.preDiscountAmount;
                    }
                } else if (!(firstItem[' product_is_free'] || firstItem.freeStandardShippable)) {
                    paymentInfo.subtotal = firstItem['orig_productPrice'] + firstItem.preDiscountAmount;
                }
            }

            updateCurrency(newJSON);
        }
    );

    paymentInfo.updateCurrencyTranslations = function(currencyList) {
        if (currencyList !== undefined && currencyList !== null && Object.keys(currencyList).length !== 0) {
            paymentInfo.currencies = _transformCurrencyList(currencyList);
        }
    };

    paymentInfo.onControllerAdded = function() {
        paymentInfo.couponInput = OrderFormService$.json && OrderFormService$.json.couponAttempted;
    };

    function _transformCurrencyList(currencyList) {
        return Object.keys(currencyList).map(function(key) {
            return {
                code: key,
                name: currencyList[key]
            };
        });
    }

    paymentInfo.isTaxCountry = function() {
        return !(paymentInfo.isVat || paymentInfo.isGstCountry);
    };

    OrderFormService$.addController('paymentInfo', paymentInfo);
}
})();
(function() {
'use strict';
ShippingInfo.$inject = ["OrderFormService$", "OrderFormMeta"];
angular
    .module('Orders')
    .component('shippingInfo', {
        templateUrl: 'ShippingInfo.html',
        require: { orderForm: '^orderForm' },
        controller: ShippingInfo
    });

function ShippingInfo(OrderFormService$, OrderFormMeta) {
    // controller definition
    var shippingInfo = this;

    shippingInfo.shippingInfo = {};
    shippingInfo.countries = [];
    shippingInfo.states = [];
    shippingInfo.cities = [];
    shippingInfo.counties = [];
    shippingInfo.oldZip = undefined;
    shippingInfo.physical = false;
    shippingInfo.country = undefined;
    shippingInfo.cityRequired = false;
    shippingInfo.stateRequired = false;
    shippingInfo.countyRequired = false;
    shippingInfo.showState = false;
    shippingInfo.showCity = false;
    shippingInfo.showCounty = false;
    shippingInfo.hasStates = false;
    shippingInfo.hasCities = false;
    shippingInfo.hasCounties = false;
    shippingInfo.isProAccount = false;
    shippingInfo.fullNameRegExp = '[\\w]+[\\w\\s]*[\\s]+[\\w]+[\\s]*';

    shippingInfo.serialize = function(action) {
        var serialized, submitProperties;

        serialized = {
            'order.shipTo.countryId': shippingInfo.country ? shippingInfo.country.id : '1',
            'order.shipTo.zip': shippingInfo.shippingInfo.zip || '',
            'order.shipTo.city': shippingInfo.shippingInfo.city || '',
            'order.shipTo.state': shippingInfo.shippingInfo.state || '',
            'payment_option': 'on'
        };

        if (shippingInfo.isCountyRequired()) {
            serialized['order.shipTo.county'] = shippingInfo.shippingInfo.county || '';
        }

        if (action === 'SUBMIT') {
            submitProperties = {
                'order.shipTo.fullName': shippingInfo.shippingInfo.name,
                'order.shipTo.address1': shippingInfo.shippingInfo.address1,
                'order.shipTo.address2': shippingInfo.shippingInfo.address2
            };

            angular.extend(serialized, submitProperties);
        }

        return serialized;
    };

    shippingInfo.serializeAbandonedOrder = function() {
        var serialized;

        serialized = {
            'address1': shippingInfo.shippingInfo.address1,
            'address2': shippingInfo.shippingInfo.address2,
            'zip': shippingInfo.shippingInfo.zip,
            'country': shippingInfo.country ? shippingInfo.country.code : ''
        };

        return serialized;
    };

    shippingInfo.recalculate = function(bypassChecks) {
        var newZip;

        if (bypassChecks) {
            OrderFormService$.recalculate();
        } else {
            newZip = shippingInfo.shippingInfo.zip;

            if (newZip && newZip !== '' && newZip !== shippingInfo.oldZip) {
                shippingInfo.oldZip = newZip;

                OrderFormService$.recalculate();
            }
        }
    };

    shippingInfo.sendAbandonedOrderData = function() {
        shippingInfo.orderForm.sendAbandonedOrderData(shippingInfo.shippingInfo.zip);
    };

    shippingInfo.onChangeZipCode = function() {
        shippingInfo.recalculate();
    };

    shippingInfo.onChangeShippingCountry = function() {
        shippingInfo.recalculate(true);
        shippingInfo.orderForm.sendAbandonedOrderData(shippingInfo.country);
    };

    shippingInfo.isCountyRequired = function() {
        return shippingInfo.countyRequired && shippingInfo.counties && shippingInfo.counties.length > 1;
    };

    /*Visible for test*/
    shippingInfo.ifNullOrUndefinedThenReturnEmptyString = function(currentValue, newValue) {
        if (_isNullOrUndefined(currentValue)) {
            if (_isNullOrUndefined(newValue)) {
                return '';
            } else {
                return newValue;
            }
        }
        return currentValue;
    };

    shippingInfo.updateJSON = function(newJSON) {
        if (angular.equals(newJSON, {})) {
            return;
        }

        shippingInfo.shippingInfo = {
            name: shippingInfo.ifNullOrUndefinedThenReturnEmptyString(shippingInfo.shippingInfo.name, newJSON[ 'order\\.shipTo\\.fullName' ]),
            address1: shippingInfo.ifNullOrUndefinedThenReturnEmptyString(shippingInfo.shippingInfo.address1, newJSON[ 'order\\.shipTo\\.address1' ]),
            address2: shippingInfo.ifNullOrUndefinedThenReturnEmptyString(shippingInfo.shippingInfo.address2, newJSON[ 'order\\.shipTo\\.address2' ]),
            zip: shippingInfo.ifNullOrUndefinedThenReturnEmptyString(undefined, newJSON[ 'order\\.shipTo\\.zip' ]),
            city: shippingInfo.ifNullOrUndefinedThenReturnEmptyString(undefined, newJSON[ 'order\\.shipTo\\.city' ]),
            state: shippingInfo.ifNullOrUndefinedThenReturnEmptyString(undefined, newJSON[ 'order\\.shipTo\\.state' ]),
            country: shippingInfo.ifNullOrUndefinedThenReturnEmptyString(undefined, newJSON[ 'order\\.shipTo\\.country' ]),
            countryId: shippingInfo.ifNullOrUndefinedThenReturnEmptyString(undefined, newJSON[ 'order\\.shipTo\\.countryId' ]),
            county: shippingInfo.ifNullOrUndefinedThenReturnEmptyString(undefined, newJSON[ 'order\\.shipTo\\.county' ]),
            email: shippingInfo.ifNullOrUndefinedThenReturnEmptyString(undefined, newJSON[ 'order\\.shipTo\\.email' ])
        };

        shippingInfo.countries = OrderFormService$.sortCountries(newJSON.countries);
        shippingInfo.country = OrderFormService$.findCountry(shippingInfo.countries, shippingInfo.shippingInfo.countryId);

        shippingInfo.states = newJSON.states;
        shippingInfo.cities = newJSON.cities;
        shippingInfo.counties = newJSON.counties;
        shippingInfo.cityRequired = newJSON.cityRequired;
        shippingInfo.countyRequired = newJSON.countyRequired;
        shippingInfo.stateRequired = newJSON.stateRequired;
        shippingInfo.collectFullName = true;

        shippingInfo.physical = OrderFormMeta.physical;

        shippingInfo.showState = _shouldShowState();
        shippingInfo.showCity = _shouldShowField(shippingInfo.cityRequired, shippingInfo.cities);
        shippingInfo.showCounty = _shouldShowCounty();

        shippingInfo.hasStates = shippingInfo.states && shippingInfo.states.length > 0;
        shippingInfo.hasCities = shippingInfo.cities && shippingInfo.cities.length > 0;
        shippingInfo.hasCounties = shippingInfo.counties && shippingInfo.counties.length > 0;

        if (!shippingInfo.showState) {
            shippingInfo.shippingInfo.state = '';
        }

        if (!shippingInfo.showCity) {
            shippingInfo.shippingInfo.city = '';
        }

        if (!shippingInfo.showCounty) {
            shippingInfo.shippingInfo.county = '';
        }

        shippingInfo.isProAccount = newJSON.isProAccount;
    };

    OrderFormService$.addController('shippingInfo', shippingInfo);

    function _shouldShowState() {
        var countryCode;

        countryCode = shippingInfo.country && shippingInfo.country.code;

        return countryCode !== 'DE' && countryCode !== 'AT' && _shouldShowField(shippingInfo.stateRequired, shippingInfo.states);
    }

    function _shouldShowCounty() {
        return shippingInfo.countyRequired && shippingInfo.counties && shippingInfo.counties.length > 1;
    }

    function _shouldShowField(requiredField, availableOptionsForField) {
        var countryCode;

        countryCode = shippingInfo.country && shippingInfo.country.code;

        return (shippingInfo.physical && (countryCode && (countryCode !== 'US' || shippingInfo.cities.length > 0))) ||
            (requiredField && availableOptionsForField && availableOptionsForField.length > 1);
    }

    function _isNullOrUndefined(value) {
        return value === undefined || value === null;
    }
}
})();
(function() {
'use strict';
ShoppingCart.$inject = ["$scope", "$uibModal", "OrderFormService$", "OrderFormMeta"];
angular
    .module('Orders')
    .component('shoppingCart', {
        templateUrl: 'ShoppingCart.html',
        require: { orderForm: '^orderForm' },
        controller: ShoppingCart
    });

function ShoppingCart($scope, $uibModal, OrderFormService$, OrderFormMeta) {
    var shoppingCart = this;

    shoppingCart.editItems = false;
    shoppingCart.cartItems = [];
    shoppingCart.maxQuantity = OrderFormMeta.maxQuantity;
    shoppingCart.isProAccount = false;
    shoppingCart.showDigitalWatermark = false;
    shoppingCart.isCartWithSingleRecurring = false;
    shoppingCart.firstRebillCartItem = {};
    shoppingCart.firstCartItem = {};
    shoppingCart.hasAnyDelayedDeliveryItems = false;

    shoppingCart.serialize = function() {
        var serialized;

        serialized = {};

        angular.forEach(shoppingCart.cartItems, function(cartItem, index) {
            var prefix, cartObject;

            cartObject = {};
            prefix = 'order.orderItems[' + index + '].';
            cartObject[prefix + 'productId'] = cartItem.productId;
            cartObject[prefix + 'quantity'] = cartItem.newQuantity;
            cartObject[prefix + 'remove'] = cartItem.remove;
            cartObject[prefix + 'sku'] = cartItem.sku;
            cartObject[prefix + 'productImagePath'] = cartItem.productImagePath;

            angular.extend(serialized, cartObject);
        });

        return serialized;
    };

    shoppingCart.changeQuantity = function(cartItem) {
        var newQuantity = cartItem.newQuantity;

        if (newQuantity !== cartItem.quantity && newQuantity >= 1 && newQuantity <= cartItem.maxQuantity) {
            OrderFormService$.recalculate();
        }
    };

    shoppingCart.setRemoveItem = function(cartItem) {
        cartItem.remove = !cartItem.remove;

        OrderFormService$.recalculate();
    };

    shoppingCart.removeButtonEnabled = function() {
        var nonRemovedItems = 0;
        if (shoppingCart.cartItems.length > 1) {
            shoppingCart.cartItems.forEach(function callback(cartItem) {
                if (!cartItem.remove) {
                    nonRemovedItems++;
                }
            });
        }

        return nonRemovedItems > 1;
    };

    $scope.$watch(
        function watchJSON() {
            return OrderFormService$.json;
        }, function handleJSONChange(newJSON, oldJSON) {
            if (angular.equals(newJSON, {})) {
                return;
            }

            _handleCartUpdate(newJSON, oldJSON);
        }
    );

    function _handleCartUpdate(newJSON, oldJSON) {
        shoppingCart.isCart = newJSON.cartOrder;
        shoppingCart.editItems = newJSON.editItems;
        shoppingCart.isProAccount = newJSON.isProAccount;
        shoppingCart.hasAnyDelayedDeliveryItems = newJSON.hasAnyDelayedDeliveryItems;

        _handleCartItemsUpdate(newJSON.items);

        shoppingCart.isCartWithSingleRecurring = _isCartWithSingleRecurring();
        shoppingCart.firstRebillCartItem = _getFirstRebillCartItem();
        shoppingCart.firstCartItem = _getFirstCartItem();
    }

    function _handleCartItemsUpdate(newItems) {
        var newCartItems = newItems.map(_transformCartItem).filter(_filterBaseItems);
        if (shoppingCart.cartItems.length === 0) {
            shoppingCart.cartItems = newCartItems;
        } else {
            shoppingCart.cartItems.forEach(function(currentCartItem, index, array) {
                newCartItems.forEach(function(newCartItem) {
                    if (currentCartItem.productId === newCartItem.productId) {
                        array[index] = newCartItem;
                    }
                });
            });
        }
    }

    function _isCartWithSingleRecurring() {
        return OrderFormService$.isCartWithSingleRecurring();
    }

    function _getFirstRebillCartItem() {
        return OrderFormService$.getFirstRebillCartItem();
    }

    function _getFirstCartItem() {
        return shoppingCart.cartItems.length ? shoppingCart.cartItems[0] : {};
    }

    function _transformCartItem(item) {
        var itemMaxQuantity = item.maxQuantity;

        return {
            title: item.orderItemTitle,
            sku: item.sku,
            productId: item.productid,
            price: item.productPrice,
            quantity: item.quantity,
            newQuantity: item.quantity,
            isPhysical: item.isPhysical,
            isDigital: item.isDigital,
            maxPayments: item.maxPayments,
            rebill: item.rebill,
            rebillFrequency: item.rebillFrequency,
            rebillName: item.orderItemTitle,
            rebillPayments: item.rebillPayments,
            futurePaymentsTitle: item.futurePaymentsTitle,
            futurePayments: item.futurePayments,
            futureRebillDate: item.futureRebillDate,
            futureTermsDescription: item.futureTermsDescription,
            billedFrequency: item.billedFrequency,
            recurring: item.recurring,
            remove: item.remove,
            type: item.orderItemType,
            preDiscountAmount: item.preDiscountAmount,
            maxQuantity: angular.isNumber(itemMaxQuantity) ? itemMaxQuantity : shoppingCart.maxQuantity,
            description: item.orderItemDescription || '',
            isDigitalDownload: _isDigitalDownload(item),
            productImagePath: item.productImagePath,
            delayedDelivery: item.delayedDelivery,
            estimatedShipDate: item.estimatedShipDate
        };
    }

    function _isDigitalDownload(item) {
        return item.isDigital;
    }

    function _filterBaseItems(item) {
        return item.type !== 'BUMP';
    }

    OrderFormService$.addController('shoppingCart', shoppingCart);
}
})();
(function() {
'use strict';
SpecUtil$.$inject = ["OrderFormService$", "_$componentController_"];
angular
    .module('Orders')
   .service('SpecUtil', SpecUtil$);

function SpecUtil$(OrderFormService$, _$componentController_) {
    var specUtil = this;

    var $componentController = _$componentController_;

    var minimalJson = {
        'paymentInfo': function(json) {
            json.items = [ { freeStandardShippable: 'true' } ];
        }
    };

    specUtil.dependsOn = function(componentNames, $scope) {
        componentNames.map(function(componentName) {
            $componentController(componentName, { $scope: $scope }, { orderFormService$: OrderFormService$ });
            if (minimalJson[componentName]) {
                minimalJson[componentName](OrderFormService$.json);
            }
        });
    };
}
})();
(function() {
'use strict';
angular
    .module('Orders')
    .directive('alertFor', alertFor);

function alertFor() {
    function link($scope, $element, $attrs) {
        var field,
            $formCtrl = $element.controller('form');

        if ($attrs.type === 'danger' && $formCtrl && $attrs.alertFor) {
            field = $formCtrl[$attrs.alertFor];
            $scope.$watchGroup([ touchedExpr, errorExpr, serverErrorExpr ], showOrHide);
        }

        function touchedExpr() {
            return field ? field.$touched : false;
        }

        function errorExpr() {
            var errors = $attrs.errors ? $attrs.errors.split(' ') : [ 'required' ];
            return errors.some(function(error) {
                return field ? field.$error[error] : false;
            });
        }

        function serverErrorExpr() {
            var serverError = $attrs.errors ? stringContains($attrs.errors, /\bserver\b/) : false;
            var isEmpty = true;
            var errorDiv = $element[0].querySelector('div[ng-transclude]');
            if (errorDiv) {
                isEmpty = !errorDiv.textContent || stringContains(errorDiv.textContent, '{{.*}}');
            }
            return serverError && !isEmpty;
        }

        function showOrHide() {
            if ((serverErrorExpr() && !touchedExpr()) || (touchedExpr() && errorExpr())) {
                $element.attr('aria-hidden', 'false');
                $element.removeClass('ng-hide');
            } else {
                $element.attr('aria-hidden', 'true');
                $element.addClass('ng-hide');
            }
        }

        function stringContains(string, substring) {
            return string.search(substring) !== -1;
        }
    }

    return {
        restrict: 'EA',
        link: link
    };
}
})();
(function() {
'use strict';
angular
    .module('Orders')
    .directive('resetUibAlerts', resetUibAlerts);

function resetUibAlerts() {
    function link($scope, $attrs, $controller, $ngModel) {

        var errorTypes = $controller.resetUibAlerts.split(' ');

        $scope.$watch($controller.ngModel, function() {
            if (!$ngModel.$valid) {
                angular.forEach(errorTypes, function(errorType) {
                    $ngModel.$setValidity(errorType, true);
                });
            }
        });
    }

    return {
        restrict: 'A',
        require: 'ngModel',
        link: link
    };
}
})();