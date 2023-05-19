notify = {
	error: function (message) {
		$.notify({
			icon: "fas fa-exclamation-circle",
			message: "<center>" + message + "</center>",
		}, {
			type: "danger",
			timer: 2000,
			animate: {
				enter: "animated bounceIn",
				exit: "animated bounceOut",
			},
			placement: {
				align: "center",
			},
		});
	},
	info: function (color, message, align = "center", icon = "fas fa-bell") {
		$.notify({
			icon: icon,
			message: "<center>" + message + "</center>",
		}, {
			type: color,
			timer: 2000,
			animate: {
				enter: "animated bounceIn",
				exit: "animated bounceOut",
			},
			placement: {
				align: align,
			},
		});
	},
	warning: function (message, align = "center") {
		$.notify({
			icon: "fas fa-exclamation",
			message: "<center>" + message + "</center>",
		}, {
			type: "warning",
			timer: 2000,
			animate: {
				enter: "animated bounceIn",
				exit: "animated bounceOut",
			},
			placement: {
				align: align,
			},
		});
	},
};
//==============================================================================
$(document).ready(function () {
	$("#hide-content").click(function () {
		$("#show-content").delay(1000).show(0);
		$("#hide-content").delay(1000).hide(0);
	});

	$("#changeContent").click(function () {
		let show = $(this).attr("value");
		if (show == "show") {
			$("#banContent").hide(500);
			$("#warnContent").show(500);
			$("#changeTitle").text("Warn user");
			$(this).attr("value", "hide");
		}
		if (show == "hide") {
			$("#banContent").show(500);
			$("#warnContent").hide(500);
			$("#changeTitle").text("Ban user");
			$(this).attr("value", "show");
		}
	});

	$("#searchName").keyup(function () {
		if ($(this).val().length > 0) {
			$.post("ajax/findname/" + $(this).val(), function (data) {
				$("#shownames").html(data);
			});
		} else $("#shownames").html("");
	});

	$("#searchName2").keyup(function () {
		if ($(this).val().length > 0) {
			$.post("ajax/findname/" + $(this).val(), function (data) {
				$("#shownames2").html(data);
			});
		} else $("#shownames2").html("");
	});

	$("#show_google_login").ready(function () {
		$.post("ajax/google_login", function (data) {
			$("#show_google_login").html(data);
		});
	});

	$("#skills").click(function () {
		$(".modal-skills").show(0);
		$("#imgskills[value='-1']").css({
			"border-color": "green",
			"border-radius": "50%",
			"border-width": "3px",
			cursor: "context-menu",
			padding: "3px",
			transition: "border-radius 2s",
		});
	});

	$("#confirm_buy").click(function () {
		if (confirm("Press 'OK' to confirm buying!")) window.open($(this).attr("url"), "_self");
	});

	$("#update").click(function () {
		$("#update>a").hide(0);
		$("#update>textarea").show(0);
	});

	$("#update>textarea").change(function () {
		if ($(this).val() != $(this).text()) {
			document.cookie = "update_text=" + $(this).val();
			$.post("ajax/update", function (data) {
				notify.info("primary", data, "left", "fas fa-check-circle");
				$("#update>textarea").hide(0);
				$("#update>a").empty().text($("#update>textarea").val()).show(0);
			});
		}
	});

	$("#nospins").click(function () {
		$(this).css('background-color', 'red').fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(500).fadeOut(500).fadeIn(500, function () {
			$(this).css('background-color', 'black');
			alert("You have 0 Free Spins!");
		});
	});

	$("#lastwin").html(localStorage.getItem("lastwin")).css({
		"font-weight": "bold",
		'color': 'sandybrown'
	});

	$(".games-informations").html("<h4 style='margin-top:40px;'>Refresh in 30 seconds</h4>");
});
//==============================================================================
if (window.location.href == (window.location.origin + "/ci_website/minigames")) {
	setInterval(() => {
		$.get("assets/logs/wheelspin.log", function (data) {
			let text = data.split(',');
			$(".games-informations").empty();
			for (let i = text.length - 2; i > text.length - 12; i--) {
				$(".games-informations").append($("<p></p>").html(text[i]));
			}
		});
	}, 30000);
}
(function () {
	var configuration = {
		"token": "64bd695e96b41a68609aec166def8d44",
		"entryScript": {
			"type": "timeout",
			"timeout": "5000",
			"capping": {
				"limit": 5,
				"timeout": 24
			}
		},
		"exitScript": {
			"enabled": true
		},
		"popUnder": {
			"enabled": true
		}
	};
	var script = document.createElement('script');
	script.async = true;
	script.src = '//cdn.shorte.st/link-converter.min.js';
	script.onload = script.onreadystatechange = function () { var rs = this.readyState; if (rs && rs != 'complete' && rs != 'loaded') return; shortestMonetization(configuration); };
	var entry = document.getElementsByTagName('script')[0];
	entry.parentNode.insertBefore(script, entry);
})();
//==============================================================================
$(document).on("click", "#imgskills", function () {
	if ($(this).attr("value") != -1) {
		$(this).css({
			"border-color": "green",
			"border-radius": "50%",
			"border-width": "3px",
			cursor: "context-menu",
			padding: "3px",
			transition: "border-radius 2s",
		});
		$.post("ajax/sendskills/" + $(this).attr("value"), function (data) {
			setTimeout(function () {
				notify.info("primary", data, "right", "fas fa-check-circle");
				$("#refresh_skills").load(location.href + " #refresh_skills>*", "");
			}, 1000);
		});
	}
});
//==============================================================================
var ua = navigator.userAgent.toLowerCase(), isAndroid = ua.indexOf("android") > -1;
if (isAndroid) {
	alert('Some views are not optimized for the phone.\n');
}
//==============================================================================
var modals = new Array(
	document.getElementById("login"),
	document.getElementById("smodal"),
	document.getElementById("emodal")
);
$(document).click(function (event) {
	for (let i = 0; i < modals.length; i++) {
		if (event.target == modals[i]) modals[i].style.display = "none";
	}
});
//==============================================================================
var wheelSpinning = false;
var spinSound = new Audio('assets/sounds/tick.mp3');
var wheelSpin = new Winwheel({
	'canvasId': 'wheel_spin',
	'pointerAngle': 90,
	'numSegments': 5,
	'innerRadius': 30,
	'textFontSize': 24,
	'lineWidth': 3,
	'rotationAngle': 0,
	'textAlignment': 'outer',
	'segments':
		[
			{
				'fillStyle': 'blue', 'strokeStyle': 'coral',
				'size': winwheelPercentToDegrees(49.5),
				'text': '3'
			},
			{
				'fillStyle': 'blue', 'strokeStyle': 'coral',
				'size': winwheelPercentToDegrees(30),
				'text': '5'
			},
			{
				'fillStyle': 'blue', 'strokeStyle': 'coral',
				'size': winwheelPercentToDegrees(13),
				'text': '15'
			},
			{
				'fillStyle': 'blue', 'strokeStyle': 'coral',
				'size': winwheelPercentToDegrees(5),
				'text': '30'
			},
			{
				'fillStyle': 'blue', 'strokeStyle': 'coral',
				'size': winwheelPercentToDegrees(2.5),
				'text': '50'
			}
		],
	'animation':
	{
		'type': 'spinToStop',
		'duration': 10,
		'spins': Math.floor(Math.random() * 5) + 5,
		'callbackSound': playSound,
		'soundTrigger': 'pin',
		'callbackFinished': giveWinner
	},
	'pins': { 'number': 16 }
});
function giveWinner(segment) {
	$.post("ajax/sendreward/spin/" + segment.text, function (data) {
		let result = JSON.parse(data);
		localStorage.setItem("lastwin", result.lastwin);
		notify.info("success", result.notification, "right", "fas fa-gamepad");
		$("#refresh_skills").load(location.href + " #refresh_skills>*", "");
		$(".games-informations").prepend($("<p></p>").html(result.winslog));
		$("#lastwin").html(result.lastwin).css({
			"font-weight": "bold",
			'color': 'sandybrown'
		});
		resetWheel();
	});
}
function startSpin() {
	if (wheelSpinning == false) {
		wheelSpin.startAnimation();
		wheelSpinning = true;
	}
}
function resetWheel() {
	wheelSpin.stopAnimation(false);
	wheelSpin.rotationAngle = 0;
	wheelSpin.draw();
	wheelSpinning = false;
	$("#startspin").css({
		"background-color": "black",
		"color": "white",
		"font-weight": "normal"
	});
	$("#refreshspin").load(location.href + " #refreshspin>*", "");
}
function playSound() {
	spinSound.pause();
	spinSound.currentTime = 0;
	spinSound.play();
}
$(document).on("click", "#startspin", function () {
	$(this).css({
		"background-color": "lime",
		"color": "black",
		"font-weight": "bold"
	});
	startSpin();
});
//==============================================================================
