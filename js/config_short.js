/*
 general settings:
 gridWidth: width of your presentation content, basis for your x-axis. For example if your layout is based on the 960.gs-framework, the gridWith setting would be 960. This is NOT the image width.
 tooltipWidth: Standard width of your tooltips. Can be altered in every step

 Settings for each step of your presentation:
 screenNumber: The image to be shown. Same order as in your index.html.
 name: a unique identifier for your tooltip / screen / intro page. Serves as anchor name (default: step[number])
 showAsIntro: If true, an overlay is generated. Used for introducing a set of tooltips.
 posX: Position of the tooltip on x-axis (not needed on intro pages or if text is empty)
 posY: Position of the tooltip on y-axis (not needed on intro pages or if text is empty)
 tooltipWidth: Width of the tooltip (default: 250)
 color: the color of the tooltip or the intro page (black | white, default: black)
 text: the text inside the tooltip / the intro page. Leave empty for showing only the screen. (default empty)
 position: the position of the tip. Possible values are
 TL	top left
 TR  top right
 BL  bottom left
 BR  bottom right
 LT  left top
 LB  left bottom
 RT  right top
 RB  right bottom
 T   top
 R   right
 B   bottom
 L   left
 */

var gridWidth = 1000,
	config = [
		{
			"screenNumber":1,
			"name":"start",
			"showAsIntro":true,
			"text":"<strong>Welcome to the screens of <br />project XY!</strong><br><br>For navigating through the tour use the buttons on the bottom left."
		},
		{
			"screenNumber":1,
			"name":"screen1"
		},
		{
			"screenNumber":2,
			"name":"layout2"
		},
		{
			"screenNumber":2,
			"name":"layout2b",
			"posX":0,
			"posY":240,
			"tooltipWidth":100,
			"text":"A nice font",
			"position":"R"
		},
		{
			"screenNumber":2,
			"name":"layout2c",
			"posX":60,
			"posY":1170,
			"tooltipWidth":100,
			"text":"Awesome buttons",
			"position":"B"
		},
		{
			"screenNumber":3,
			"name":"layout3"
		},
		{
			"screenNumber":1,
			"name":"end",
			"bgcolor":"white",
			"showAsIntro":true,
			"text":"<strong>Thank you. </strong><br/><br />Please contact John Doe if you got any questions"
		}
	],
	previousStep = false,
	step = 0,
	total_steps = config.length - 1;
