var $ = jQuery;

function headerAnimate() {
    var header = $('.et_pb_fullwidth_header_0 .et_pb_fullwidth_header_container'),
    headerCont = $('.et_pb_fullwidth_header_0 .et_parallax_bg'),
	position = $(window).scrollTop();

        header.css({
            'right': position
            
        });

		headerCont.css({
            'opacity': (1 / position) * 200 - 0.25
        });
};

module.exports = {
	headerAnimate: headerAnimate
};