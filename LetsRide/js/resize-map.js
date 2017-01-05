// Resize google maps to fit in Bootsrap grid
$(window).resize(function () {
    var topbarHeight = $('.main-navbar').height();
    var winHeight = $(window).height();
    $('#mainContainer').css('height', winHeight - topbarHeight);
}).resize();


