angular.module("app.directives", [])
	.directive("imgHolder", [function () {
		return{restrict: "A", link: function (scope, ele) {
			return Holder.run({images: ele[0]})
		}}
	}])
	.directive("customBackground", function () {
		return{restrict: "A", controller: ["$scope", "$element", "$location", function ($scope, $element, $location) {
			var addBg, path;
			return path = function () {
				return $location.path()
			}, addBg = function (path) {
				switch ($element.removeClass("body-home body-special body-tasks body-lock"), path) {
					case"/":
						return $element.addClass("body-home");
					case"/404":
					case"/500":
					case"/register":
					case"/forgot":
					case"/login":
					case"/logout":
					case"/pricing":
					case"/services":
					case"/about":
					case"/contact":
					case"/home":
						return $element.addClass("body-special");
					case"/lock-screen":
						return $element.addClass("body-special body-lock");
					case"/tasks":
						return $element.addClass("body-tasks")
				}
			}, addBg($location.path()), $scope.$watch(path, function (newVal, oldVal) {
				return newVal !== oldVal ? addBg($location.path()) : void 0
			})
		}]}
	})
	.directive("uiColorSwitch", [function () {
		return{restrict: "A", link: function (scope, ele) {
			return ele.find(".color-option").on("click", function (event) {
				var $this, hrefUrl, style;
				if ($this = $(this), hrefUrl = void 0, style = $this.data("style"), "loulou" === style)hrefUrl = "styles/main.css", $('link[href^="styles/main"]').attr("href", hrefUrl); else {
					if (!style)return!1;
					style = "-" + style, hrefUrl = "styles/main" + style + ".css", $('link[href^="styles/main"]').attr("href", hrefUrl)
				}
				return event.preventDefault()
			})
		}}
	}])
	.directive("toggleMinNav", ["$rootScope", function ($rootScope) {
		return{restrict: "A", link: function (scope, ele) {
			var $content, $nav, $window, Timer, app, updateClass;
			return app = $("#app"), $window = $(window), $nav = $("#nav-container"), $content = $("#content"), ele.on("click", function (e) {
				return app.hasClass("nav-min") ? app.removeClass("nav-min") : (app.addClass("nav-min"), $rootScope.$broadcast("minNav:enabled")), e.preventDefault()
			}), Timer = void 0, updateClass = function () {
				var width;
				return width = $window.width(), 768 > width ? app.removeClass("nav-min") : void 0
			}, $window.resize(function () {
				var t;
				return clearTimeout(t), t = setTimeout(updateClass, 300)
			})
		}}
	}])
	.directive("collapseNav", [function () {
		return{restrict: "A", link: function (scope, ele) {
			var $a, $aRest, $lists, $listsRest, app;
			return $lists = ele.find("ul").parent("li"), $lists.append('<i class="fa fa-caret-right icon-has-ul"></i>'), $a = $lists.children("a"), $listsRest = ele.children("li").not($lists), $aRest = $listsRest.children("a"), app = $("#app"), $a.on("click", function (event) {
				var $parent, $this;
				return app.hasClass("nav-min") ? !1 : ($this = $(this), $parent = $this.parent("li"), $lists.not($parent).removeClass("open").find("ul").slideUp(), $parent.toggleClass("open").find("ul").slideToggle(), event.preventDefault())
			}), $aRest.on("click", function () {
				return $lists.removeClass("open").find("ul").slideUp()
			}), scope.$on("minNav:enabled", function () {
				return $lists.removeClass("open").find("ul").slideUp()
			})
		}}
	}])
	.directive("highlightActive", [function () {
		return{restrict: "A", controller: ["$scope", "$element", "$attrs", "$location", function ($scope, $element, $attrs, $location) {
			var highlightActive, links, path;
			return links = $element.find("a"), path = function () {
				return $location.path()
			}, highlightActive = function (links, path) {
				return path = "#" + path, angular.forEach(links, function (link) {
					var $li, $link, href;
					return $link = angular.element(link), $li = $link.parent("li"), href = $link.attr("href"), $li.hasClass("active") && $li.removeClass("active"), 0 === path.indexOf(href) ? $li.addClass("active") : void 0
				})
			}, highlightActive(links, $location.path()), $scope.$watch(path, function (newVal, oldVal) {
				return newVal !== oldVal ? highlightActive(links, $location.path()) : void 0
			})
		}]}
	}])
	.directive("toggleOffCanvas", [function () {
		return{restrict: "A", link: function (scope, ele) {
			return ele.on("click", function () {
				return angular.element("#app").toggleClass("on-canvas")
			})
		}}
	}])
	.directive("slimScroll", [function () {
		return{restrict: "A", link: function (scope, ele, attrs) {
			return ele.slimScroll({height: attrs.scrollHeight || "100%"})
		}}
	}])
	/*.directive("niceScroll", [function () {
		return{restrict: "A", link: function (scope, ele, attrs) {
			return ele.niceScroll({cursorcolor: attrs.cursorcolor || "#777", cursorborder: "0", cursorborderradius: "0", cursorwidth: "3px"})
		}}
	}])*/
	.directive("goBack", [function () {
		return{restrict: "A", controller: ["$scope", "$element", "$window", function ($scope, $element, $window) {
			return $element.on("click", function () {
				return $window.history.back()
			})
		}]}
	}])
	.directive('nourl', function() {
		return function($scope, element, attrs) {
			angular.element(element).click(function(event) {
				event.preventDefault();
			});
		};
	})
	.directive('frontNav', function() {
		return function (scope, element, attrs) {
			element.find('a[href="'+window.location.pathname+'"]').parent().addClass('active');
			element.find('a').click(function() {
				element.find('li.active').removeClass('active');
				angular.element(this.parentElement).addClass('active');
			});
		};
	})