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
		$(".switch-lang").addClass("active");
	} else {
		$(".switch-lang").removeClass("active");
	}

	$(".switch-lang").on("click", function(e) {
		e.preventDefault();
		// console.log("default lang: ", default_lang);
		// setCookie("lang", $("#select_lang").val(), 365);
		// $("#select_lang").attr("value", default_lang);
		// default_lang = getCookie("lang");
		// console.log("modify lang: ", default_lang);

		setCookie("lang", $("#select_lang").val(), 365);

		//$("html").attr("lang", default_lang);
		if ($(".switch-lang").hasClass("active")) {
			localStorage.setItem("lang-mode", "true");
			$(".switch-lang").removeClass("active");
		} else {
			$(".switch-lang").addClass("active");
			localStorage.setItem("lang-mode", "false");
		}
		$("body").load("./");
		$("html").attr("lang", getCookie("lang"));
		//if (getCookie("lang") === "") {
		//} else if (getCookie("lang") === "es") {
		// 	setCookie("lang", $("#select_lang").val(), 365);
		// 	$("#select_lang").attr("value", default_lang);
		// 	let default_lang = getCookie("lang");
		// 	alert(default_lang);
		// } else {
		// }
		//  else if (getCookie("lang") === "en") {
		// 	setCookie("lang", $("#select_lang").val(), 365);
		// 	$("html").attr("lang", $("#select_lang").val());
		// 	$("#select_lang").attr("value", "es");
		// } else {
		// }
		// $(".switch-lang").toggleClass("active");
		// if ($(".switch-lang").hasClass("active")) {
		// 	setCookie("lang", $("#select_lang").val(), 365);
		// 	alert(getCookie("lang"));
		// 	localStorage.setItem("lang-mode", "true");
		// } else {
		// 	setCookie("lang", $("#select_lang").val(), 365);
		// 	alert(getCookie("lang"));
		// 	localStorage.setItem("lang-mode", "false");
		// }
		// setTimeout(function() {
		// 	$("#switch-lang").submit();
		// }, 1000);
	});
	// $(".switch-lang").submit(function(e) {
	// 	e.preventDefault();
	// 	var url = $(this).attr("action");
	// 	var data = $(this).serialize();
	// 	$("body").load("./");
	// 	// $("#status").load('url', data, function(response, status, request) {
	// 	// 	$("#status").text(response);
	// 	// });
	// });
	// $(".switch-lang").on("click", function(e) {
	// 	e.preventDefault();
	// 	// $.ajax({
	// 	// 	url: "./",
	// 	// 	dataType: "html",
	// 	// 	success: function(html) {
	// 	// 		$("body").html(html);
	// 	// 	}
	// 	// });
	// });
});
