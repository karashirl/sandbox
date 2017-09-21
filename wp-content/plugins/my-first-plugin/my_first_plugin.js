(function($, _, Backbone) {

var $ = jQuery,
	rightControl = $('#control-right'),
	leftControl = $('#control-left'),

	sliderImg = $('.slider-container ul li img'),
	imgMarginLeft = parseInt(sliderImg.css('margin-left')),

	sliderContent = $('.slider-container .content'),
	contentMarginLeft = parseInt(sliderContent.css('margin-left')),

	sliderWidth = sliderImg.width(),
	numItems = $('.slider-container li').length,
	counter = 1;

function fwd() {
	var moveFwd = { marginLeft: imgMarginLeft - sliderWidth };
	var skipToFirst = { marginLeft: 0 };

	if (counter < numItems) {
		sliderImg.animate(moveFwd, 300);
		sliderContent.animate(moveFwd, 300);
		setTimeout(reset, 300);
		counter++;

	} else {
		sliderImg.animate(skipToFirst, 200);
		sliderContent.animate(skipToFirst, 200);		
		setTimeout(reset, 200);
		counter = 1;
	}
};

function back() {
	var moveBack = { marginLeft: imgMarginLeft + sliderWidth };
	var skipToLast = { marginLeft: -sliderWidth * (numItems - 1) };

	if (counter > 1) {	
		sliderImg.animate(moveBack, 300);
		sliderContent.animate(moveBack, 300);
		setTimeout(reset, 300);
		counter--;

	} else {
		sliderImg.animate(skipToLast, 200);
		sliderContent.animate(skipToLast, 200);
		setTimeout(reset, 200);
		counter = numItems;
	}
};

function reset() {
	imgMarginLeft = parseInt(sliderImg.css('margin-left'));
	contentMarginLeft = parseInt(sliderContent.css('margin-left'));
};

rightControl.on('click', fwd);
leftControl.on('click', back);

})(jQuery, _, Backbone);