 $('.jobSubItem').on('click', function() {
        var icon = $(this).find('svg');
        
        if ($(this).attr('aria-expanded') === 'true') {
            icon.css('transform', 'rotate(0deg)');
        } else {
            icon.css('transform', 'rotate(90deg)');
        }
    });