$(document).ready(function() {
	function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
		var expires = "expires=" + d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	function getCookie(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(";");
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == " ") {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}

	let lang = $("html").attr("lang");

	if (!localStorage.getItem("lang") || !getCookie("lang")) {
		if (lang === "es") {
			$(".switch-lang").removeClass("active");
			setCookie("lang", lang, 365);
			localStorage.setItem("lang", lang);
		} else if (lang === "en") {
			$(".switch-lang").addClass("active");
			setCookie("lang", lang, 365);
			localStorage.setItem("lang", lang);
		} else {
			setCookie("lang", "", -365);
			localStorage.removeItem("lang");
			$("html").attr("lang", lang);
			$("body").addClass("lang-none");
		}
	} else {
		if (lang === "es") {
			$(".switch-lang").removeClass("active");
		} else if (lang === "en") {
			$(".switch-lang").addClass("active");
		} else {
			setCookie("lang", "", -365);
			localStorage.removeItem("lang");
			$("html").attr("lang", lang);
			$(".switch-lang").hide();
		}
	}

	$(".switch-lang").on("click", function(e) {
		e.preventDefault();
		setCookie("lang", $(".switch-lang").attr("name"), 365);
		if (localStorage.getItem("lang") === "es") {
			localStorage.setItem("lang", "en");
			$("html").attr("lang", "en");
			$(".switch-lang").attr("name", "es");
			$(".switch-lang").addClass("active");
		} else if (localStorage.getItem("lang") === "en") {
			localStorage.setItem("lang", "es");
			$("html").attr("lang", "es");
			$(".switch-lang").attr("name", "en");
			$(".switch-lang").removeClass("active");
		} else {
			setCookie("lang", "", -365);
			localStorage.removeItem("lang");
			$("html").attr("lang", lang);
			$(".switch-lang").hide();
		}

		$("body").load("./", function() {
			console.clear();
		});
	});
});
