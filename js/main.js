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

	if (localStorage.getItem("lang-mode") === "true") {
		$(".switch-lang").removeClass("active");
	} else {
		$(".switch-lang").addClass("active");
	}
	$(".switch-lang").on("click", function(e) {
		e.preventDefault();

		setCookie("lang", $(".switch-lang").attr("name"), 365);
		$("html").attr("lang", getCookie("lang"));

		if ($(".switch-lang").hasClass("active")) {
			localStorage.setItem("lang-mode", "true");
			$(".switch-lang").removeClass("active");
		} else {
			$(".switch-lang").addClass("active");
			localStorage.setItem("lang-mode", "false");
		}

		$("body").load("./", function() {
			console.clear();
		});
	});
});
