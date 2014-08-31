(function execute() {
    $(document).ready(function() {
        browserResizeHelper();
    });

    $(window).resize(function() {
        browserResizeHelper();
    });
})();

function miniSize() {
    $("nav.breadcrumbs").addClass('mini');
    makeTilesMini();
}

function smallSize() {
    $("nav.breadcrumbs").addClass('small');
    $("nav.breadcrumbs").removeClass('mini');
    makeTilesNormal();
}

function normalSize() {
    $("nav.breadcrumbs").removeClass('small');
    $("nav.breadcrumbs").removeClass('mini');
    makeTilesNormal();
}

function makeTilesMini() {
    $("#toptiles div.tile").each(function() {
        $(this).addClass("half");
        
        var change = 0;
        var classtype = $(this).attr('class');
        if (classtype.search('double') !== -1) {
           width = 2 * 58;
           change = 1;
        }
        if (classtype.search('triple') !== -1) {
           width = 3 * 58;
           change = 1;
        }
        
        if (change === 1) {
          $(this).css({'width': ''}).attr('style', function(i, s) {
            return s + '; width: ' + width + 'px !important;'
          });       
        }
    });
}

function makeTilesNormal() {
    $("#toptiles div.tile").each(function() {
        $(this).removeClass("half");
        $(this).removeAttr( "style" );
    }
    );
}

function browserResizeHelper() {
    var winwidth = $(window).width();
    var width = winwidth - 20;
    if (width > 1280) {
        width = 1280;
    }

    $("#content-hgl").css({'width': ''}).attr('style', function(i, s) {
        return s + '; width: ' + width + 'px !important;'
    })

    $(".FlexibleWidthObject").css({'width': ''}).attr('style', function(i, s) {
        return s + '; width: ' + width + 'px !important;'
    })

    if (width < 1000) {
        if (width < 600) {
            miniSize();
        } else {
            smallSize();
        }
    } else {
        normalSize();
    }
}
