$(function () {
	$("#inner").css({
		"margin-left":"-" + gridWidth / 2 + "px"
	}).width(gridWidth);
	var screenWidth = $("#wrapper").children("img").width()
		, screenHeight = $("#wrapper").children("img").height()
		, screens = $("#wrapper img");

	$("#wrapper img").css({
		"margin-left":"-" + (screenWidth / 2) + "px"
	})
	$("#wrapper,#inner").height(screenHeight);
	if (config[step].showAsIntro == true) showOverlay(1, config[step].text);
	showControls();
	$.address.init(function (event) {
		$.address.strict(false);
	});
	$.address.externalChange(function (event) {
		var anchor = window.location.hash.substring(1);
		if (anchor != "") {
			for (var stepnumber = 0; stepnumber <= total_steps; stepnumber++) {
				if (config[stepnumber].name == anchor) step = stepnumber;
			}
		}
		showScreens(true);
		gotoStep(step);
	})
	$('#nextstep').click(function (event) {
		goNext();
	});
	$('#prevstep').click(function (event) {
		goPrevious();
	});
	$('body').keyup(function (event) {
		if (event.keyCode == '39') {
			event.preventDefault();
			goNext();
		}
		if (event.keyCode == '37') {
			event.preventDefault();
			goPrevious();
		}
	});

	function goNext() {
		previousStep = false;
		if (step < total_steps) {
			$.address.value(config[step + 1].name);
			lastStep = step;
			step++;
			showScreens(false);
			gotoStep(step);
		}
	}

	;

	function goPrevious() {
		previousStep = true;
		if (step > 0) {
			$.address.value(config[step - 1].name);
			lastStep = step;
			step--;
			showScreens(false);
			gotoStep(step);
		}
	}

	;

	function gotoStep(newstep) {
//		console.log('newstep: ' + newstep + ', step: ' + step + ' of total: ' + total_steps);
		if (step > 0) {
			$('#prevstep').show();
			$('#prevstep').attr("href", "#" + config[step - 1].name);
		}
		else
			$('#prevstep').hide();
		if (step == total_steps)
			$('#nextstep').hide();
		else {
			$('#nextstep').show();
			$('#nextstep').attr("href", "#" + config[step + 1].name);
		}
		showTooltip();
	}

	function showScreens(initial) {
//		console.log(initial + " | " + step + " | " + total_steps + " | ")
		if (step > 0)
			var previous_step_config = config[step - 1];
		if (step < total_steps)
			var next_step_config = config[step + 1];
		var step_config = config[step];
		if (initial == false) {
			if (step > 0) {
				if (step_config.screenNumber != previous_step_config.screenNumber && previousStep != true) {
					$(screens[step_config.screenNumber - 1]).fadeIn(500,function () {
						$(screens[previous_step_config.screenNumber - 1]).fadeOut(500).removeClass("active");
					}).addClass("active");
				}
			}
			if (step < total_steps) {
				if (step_config.screenNumber != next_step_config.screenNumber && previousStep == true) {
					$(screens[step_config.screenNumber - 1]).fadeIn(500,function () {
						$(screens[next_step_config.screenNumber - 1]).fadeOut(500).removeClass("active");
					}).addClass("active");
				}
			}
		}
		else {
			if ($(screens[step_config.screenNumber - 1]).hasClass("active")) {
				$("#wrapper img:not(.active)").fadeOut(1000).removeClass("active");
			} else {
				$("#wrapper img.active").fadeOut(1000).removeClass("active");
				$(screens[step_config.screenNumber - 1]).fadeIn(500).addClass("active");
			}

		}
	}

	function showTooltip() {
		removeTooltip();
		hideOverlay();
		var step_config = config[step];
		if (step_config.text != "") {
			var bgcolor = step_config.bgcolor;
			var color = step_config.color;
			var tooltipWidth = 450;
			if (step_config.tooltipWidth != '' && step_config.tooltipWidth != undefined) {
				tooltipWidth = step_config.tooltipWidth;
			}
			var $tooltip = $('<div>', {
				id:'tour_tooltip',
				class:'tooltip',
				html:'<p>' + step_config.text + '</p><span class="tooltip_arrow"></span>'
			}).css({
					'display':'none',
					'color':color
				}).width(tooltipWidth).height("auto");
			if (step_config.bgcolor == "white") $tooltip.addClass("white");
			if (step_config.text == undefined) {
				$tooltip = $('<div>');
			}

			//the css properties the tooltip should have
			var properties = {};

			var tip_position = step_config.position;

			//append the tooltip but hide it
			$('#inner').prepend($tooltip);

			//get some info of the element
			var e_w = 0;
			var e_h = 0;
			var e_l = (step_config.posX != undefined) ? step_config.posX : 0;
			var e_t = (step_config.posY != undefined) ? step_config.posY : 0;
			var anitop = 0;
			var anileft = 0;

			switch (tip_position) {
				case 'TL'    :
					properties = {
						'left':e_l,
						'top':e_t + e_h + 20 + 'px'
					};
					$tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_TL');
					anitop = e_t + e_h + 'px';
					break;
				case 'TR'    :
					properties = {
						'left':e_l + e_w - $tooltip.width() + 'px',
						'top':e_t + e_h + 20 + 'px'
					};
					$tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_TR');
					anitop = e_t + e_h + 'px';
					break;
				case 'BL'    :
					properties = {
						'left':e_l + 'px',
						'top':e_t - $tooltip.height() - 20 + 'px'
					};
					$tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_BL');
					anitop = e_t - $tooltip.height() + 'px';
					break;
				case 'BR'    :
					properties = {
						'left':e_l + e_w - $tooltip.width() + 'px',
						'top':e_t - $tooltip.height() - 20 + 'px'
					};
					$tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_BR');
					anitop = e_t - $tooltip.height() + 'px';
					break;
				case 'LT'    :
					properties = {
						'left':e_l + e_w - 20 + 'px',
						'top':e_t + 'px'
					};
					$tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_LT');
					anileft = e_l + e_w + 'px';
					break;
				case 'LB'    :
					properties = {
						'left':e_l + e_w - 20 + 'px',
						'top':e_t + e_h - $tooltip.height() + 'px'
					};
					$tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_LB');
					anileft = e_l + e_w + 'px';
					break;
				case 'RT'    :
					properties = {
						'left':e_l - $tooltip.width() + 20 + 'px',
						'top':e_t + 'px'
					};
					$tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_RT');
					anileft = e_l - $tooltip.width() + 'px';
					break;
				case 'RB'    :
					properties = {
						'left':e_l - $tooltip.width() + 20 + 'px',
						'top':e_t + e_h - $tooltip.height() + 'px'
					};
					$tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_RB');
					anileft = e_l - $tooltip.width() + 'px';
					break;
				case 'T'    :
					properties = {
						'left':e_l + e_w / 2 - $tooltip.width() / 2 + 'px',
						'top':e_t + e_h + 20 + 'px'
					};
					$tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_T');
					anitop = e_t + e_h + 'px';
					break;
				case 'R'    :
					properties = {
						'left':e_l - $tooltip.width() - 20 + 'px',
						'top':e_t + e_h / 2 - $tooltip.height() / 2 + 'px'
					};
					$tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_R');
					anileft = e_l - $tooltip.width() + 'px';
					break;
				case 'B'    :
					properties = {
						'left':e_l + e_w / 2 - $tooltip.width() / 2 + 'px',
						'top':e_t - $tooltip.height() - 20 + 'px'
					};
					anitop = e_t - $tooltip.height() + 'px';
					$tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_B');
					break;
				case 'L'    :
				default :
					properties = {
						'left':e_l + e_w + 20 + 'px',
						'top':e_t + e_h / 2 - $tooltip.height() / 2 + 'px'
					};
					$tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_L');
					anileft = e_l + e_w + 'px';
					break;
					properties += {
						'display':'block',
						'opacity':0
					}
			}

			var w_t = $(window).scrollTop();
			var w_b = $(window).scrollTop() + $(window).height();
			var b_t = parseFloat(properties.top, 10);

			if (e_t < b_t)
				b_t = e_t;

			var b_b = parseFloat(properties.top, 10) + $tooltip.height();
			if ((e_t + e_h) > b_b)
				b_b = e_t + e_h;
			if ((b_t < w_t || b_t > w_b) || (b_b < w_t || b_b > w_b - 200)) {
				$('html, body').stop()
					.animate({scrollTop:b_t - 100}, 500, 'easeInOutExpo', function () {
						if (step_config.showAsIntro != true) {
							if (anitop == 0) anitop = properties.top;
							if (anileft == 0) anileft = properties.left;
							if (step_config.bgcolor == "white") $tooltip.addClass("white");
							$tooltip.css(properties).css({
								"display":"block",
								"opacity":0
							}).animate({
									"top":anitop,
									"left":anileft,
									"opacity":1
								}, 500);
						}
					});
			}
			else if (step_config.showAsIntro != true) {
				if (anitop == 0) anitop = properties.top;
				if (anileft == 0) anileft = properties.left;
				$tooltip.css(properties).css({
					"display":"block",
					"opacity":0
				}).animate({
						"top":anitop,
						"left":anileft,
						"opacity":1
					}, 500);
			}
		}
		if (step_config.showAsIntro == true) {
			{
				$('html, body').stop()
					.animate({scrollTop:0}, 500, 'easeInOutExpo');
				showOverlay(0, step_config.text);
			}
		}
	}

	function removeTooltip() {
		$('#tour_tooltip').fadeOut('fast', function () {
			$(this).remove();
		});
	}

	function showControls() {
		var controls = '<div id="tourcontrols" class="tourcontrols">';
		controls += '<div class="nav"><a class="button" id="prevstep" style="display:none;"></a>';
		controls += '<a class="button" id="nextstep" style="display:none;"></a></div>';
		controls += '</div>';

		$('body').prepend(controls);
		$('#tourcontrols').animate({'bottom':'0px'}, 500);
	}

	function hideControls() {
		$('#tourcontrols').remove();
	}

	function showOverlay(now, text) {
		var overlay = '<div id="tour_overlay" class="overlay"></div>';
		$('body').prepend(overlay);
		if (config[step].bgcolor == "white") $("#tour_overlay").addClass("white");
		$("#tour_overlay").css("display", "none").fadeIn(700);
		var introText = '<p id="introtext">' + text + '</p>';
		$("#inner").prepend(introText);
		innerWidth = $("#inner").width() / 10 * 7;
		$("#introtext").css({
			"top":$(window).height() * 0.5
		}).width(innerWidth);
		var introtextHeight = $("#introtext").height();
		if (config[step].bgcolor == "white") $("#introtext").addClass("white");
		$("#introtext").css({
			"margin-top":"-" + introtextHeight / 2 + "px",
			"margin-left":"-" + ($("#introtext").width() / 2) + "px"
		});
	}

	function hideOverlay() {
		$('#tour_overlay,#introtext').fadeOut(700, function () {
			$(this).remove();
		});
	}

});
$(document).ready(function () {

})
$(window).load(function () {
	$("#wrapper img").eq(0).fadeIn(500);
})