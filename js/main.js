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
	if (lang === "es") {
		localStorage.setItem("lang", false);
		$("html").attr("lang", lang);
		$(".switch-lang").removeClass("active");
	} else {
		localStorage.setItem("lang", true);
		$("html").attr("lang", lang);
		$(".switch-lang").addClass("active");
	}

	$(".switch-lang").on("click", function(e) {
		e.preventDefault();
		setCookie("lang", $(".switch-lang").attr("name"), 365);
		if (lang === "es") {
			localStorage.setItem("lang", true);
			$("html").attr("lang", "en");
			$(".switch-lang").addClass("active");
		} else {
			localStorage.setItem("lang", false);
			$("html").attr("lang", "es");
			$(".switch-lang").removeClass("active");
		}

		// setCookie("lang", $(".switch-lang").attr("name"), 365);
		// $("html").attr("lang", getCookie("lang"));
		// $("html").attr("lang", getCookie("lang"));

		$("body").load("./", function() {
			console.clear();
		});
	});
});
