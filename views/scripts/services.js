angular.module("app.services", [])
	.config(['$idleProvider', '$keepaliveProvider', function ($idleProvider, $keepaliveProvider) {
		// configure $idle settings
		$idleProvider.idleDuration(3000); // in seconds
		$idleProvider.warningDuration(5); // in seconds
		$keepaliveProvider.interval(2); // in seconds
	}])
	//Define a custom services
	.service('DSPService', ['$q', 'DreamFactory', function ($q, DreamFactory) {
		return {
			// Define custom getRecords service
			getRecords: function (tableNameStr) {
				// create a promise
				var deferred = $q.defer();
				// Create request obj
				var request = {
					table_name: tableNameStr
				};

				// Call DreamFactory database service with request obj
				DreamFactory.api.db.getRecords(request,
					// Success function
					function (data) {
						// Handle promise
						deferred.resolve(data);
					},
					// Error function
					function (error) {
						// Handle Promise
						deferred.reject(error);
					}
				);
				// Return promise
				return deferred.promise;
			}
		}
	}])
	.service('UserEventsService', [function () {
		return {
			login   : {
				loginRequest: 'user:login:request',
				loginSuccess: 'user:login:success',
				loginError  : 'user:login:error'
			},
			logout  : {
				logoutRequest: 'user:logout:request',
				logoutSuccess: 'user:logout:success',
				logoutError  : 'user:logout:error'

			},
			register: {
				registerRequest     : 'user:register:request',
				registerSuccess     : 'user:register:success',
				registerError       : 'user:register:error',
				registerConfirmation: 'user:register:confirmation'
			}
		}
	}])
	.service('UserDataService', [function () {
		var currentUser = false;

		function _getCurrentUser() {
			return currentUser;
		}

		function _setCurrentUser(userDataObj) {
			currentUser = userDataObj;
		}

		function _unsetCurrentUser() {
			currentUser = false;
		}

		function _hasUser() {
			return !!currentUser;
		}

		return {
			getCurrentUser: function () {
				return _getCurrentUser();
			},

			setCurrentUser: function (userDataObj) {
				_setCurrentUser(userDataObj);
			},

			unsetCurrentUser: function () {
				_unsetCurrentUser();
			},

			hasUser: function () {
				return _hasUser();
			}
		}
	}])
	.factory('AppData', ['DSP_URL', 'DSP_API_KEY', function (DSP_URL, DSP_API_KEY) {
		"use strict";
		return {
			DB          : DSP_URL + '/rest/db',
			Files       : DSP_URL + '/rest/files/applications/' + DSP_API_KEY,
			CouponImages: DSP_URL + '/rest/files/applications/' + DSP_API_KEY + '/images/coupons/?include_files=true'
		};
		// Usefull Things to remember
		// https://dsp-gorigins.cloud.dreamfactory.com/rest/db/coupons?related=shop_by_shop_id%2Ccategories_by_category_id
	}])
	.factory('Category', ['$resource', 'AppData', function ($resource, AppData) {
		"use strict";
		return $resource(AppData.DB + '/categories/:id/?app_name=Marketplace&fields=*', {},
			{ update: { method: 'PUT' }, query: {method: 'GET', isArray: false} });
	}])
	.factory('Issue', ['$resource', 'AppData', function ($resource, AppData) {
		"use strict";
		return $resource(AppData.DB + '/issues/:id/?app_name=Marketplace&fields=*&related=shop_by_shop_id%2Cdeals_by_issue_id', {},
			{ update: { method: 'PUT' }, query: {method: 'GET', isArray: false} });
	}])
	.factory('Shop', ['$resource', 'AppData', function ($resource, AppData) {
		"use strict";
		return $resource(AppData.DB + '/shop/:id/?app_name=Marketplace&fields=*&related=deals_by_shop_id%2Cissues_by_shop_id', {},
			{ update: { method: 'PUT' }, query: {method: 'GET', isArray: false} });
	}])
	.factory('Deal', ['$resource', 'AppData', function ($resource, AppData) {
		"use strict";
		return $resource(AppData.DB + '/deal/:id/?app_name=Marketplace&fields=*&related=shop_by_shop_id%2Ccategories_by_category_id%2Cissues_by_issue_id', {},
			{ update: { method: 'PUT', url: AppData.DB + '/deal/:id/?app_name=Marketplace&fields=*' }, query: {method: 'GET', isArray: false} });
	}])
	.factory('Coupon', ['$resource', 'AppData', function ($resource, AppData) {
		"use strict";
		return $resource(AppData.DB + '/coupons/:id/?app_name=Marketplace&fields=*&related=shop_by_shop_id%2Ccategories_by_category_id', {},
			{ update: { method: 'PUT', url: AppData.DB + '/coupons/:id/?app_name=Marketplace&fields=*' }, query: {method: 'GET', isArray: false} });
	}])
	.factory('CouponImages', ['$resource', 'AppData', function ($resource, AppData) {
		"use strict";
		return $resource(AppData.CouponImages, {},
			{
				create: { method: 'POST', url: AppData.Files + '/images/coupons/?check_exist=true', params: { url: '@url' } },
				update: { method: 'PUT' },
				query : { method: 'GET', isArray: false }
			});
	}])

