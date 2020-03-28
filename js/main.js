$(document).ready(function() {
	// $(".switch-lang").submit(function(e) {
	// 	e.preventDefault();
	// 	var url = $(this).attr("action");
	// 	var data = $(this).serialize();
	// 	$("body").load("./");
	// 	// $("#status").load('url', data, function(response, status, request) {
	// 	// 	$("#status").text(response);
	// 	// });
	// });

	$(document).on("submit", ".switch-lang", function(e) {
		e.preventDefault();
		$.post("./", $("#switch-lang").serialze(), function(data) {
			$("#status").html(data);
		});
	});
});
