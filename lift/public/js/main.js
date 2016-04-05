$(function() {
    
    // Comments
    
    var $commentList = $('.comments-list'),
        $commentForm = $('.comment-form');
    
    $commentForm.each(function() {
        var $form = $(this),
            $field = $form.find('.comment-form-field'),
            $submit = $form.find('.comment-form-submit'),
            canDeleteComments = $form.data('user-can-delete-comments');
            
        $form.on('submit', function(e) {
            e.preventDefault();
            
            if (!$field.val()) {
                return;
            }
            
            $submit.attr('disabled', true);
            
            $.post($form.attr('action'), $form.serialize(), function(data, status) {
                if (status != 'success') {
                    return;
                }
                
                var $comment = $(data);
                $submit.attr('disabled', false);
                $field.val('');
                
                if (!canDeleteComments) {
                    $comment.find('.comment-delete').hide();
                }
                
                $comment
                    .hide()
                    .appendTo($commentList)
                    .slideDown();
            });
        });
    });

    $commentList.on('click', '.comment-delete', function(e) {
        e.preventDefault();
        
        var $deleteTrigger = $(this),
            $comment = $deleteTrigger.parents('.comment'),
            $item = $comment.parent();
            commentId = $comment.data('comment-id');
            
        $.post($deleteTrigger.attr('href'), { commentary_id: commentId }, function(data, status) {
            if (status != 'success') {
                return;
            }

            $item.slideUp(function() {
                $item.remove();
            });
        });
    });
    
    
    
    // Sliders
    
    if ($.fn.bxSlider) {
        $('.slider').each(function() {
            var $slider = $(this),
                $canvas = $slider.children('.slider-canvas');

            $canvas.bxSlider({
                auto: true,
                pause: 7000,
                controls: false,

                onSliderLoad: function() {
                    $slider.removeClass('slider-hidden');
                },
            });
        });
        
        $('.promo-block').each(function() {
            var $block = $(this),
                $content = $block.find('.promo-block-content'),
                $switcher = $block.find('.promo-block-switcher');

            $content.bxSlider({
                touchEnabled: false,
                auto: false,
                mode: 'fade',
                controls: true,
                pager: true,
                pagerCustom: '#promo-block-switcher'
            });
        });
    }
    
    
    
    // WYSIWYG
    
    $('.wysiwyg').each(function() {
        var $field = $(this),
            toolbar = ['bold italic underline'],
            resize = false,
            plugins = 'paste';
            
        if ($field.hasClass('wysiwyg-advanced')) {
            plugins += ' link code image textcolor media';
            toolbar[0] += ' numlist bullist blockquote alignleft aligncenter alignright indent outdent link image media code';
            toolbar[1] = 'forecolor backcolor formatselect fontsizeselect';
            resize = true;
        }
        
        $field.tinymce({
            skin: 'lttf',
            language: 'ru',
            menubar: false,
            toolbar: toolbar,
            plugins: plugins,
            image_advtab: true,
            media_alt_source: false,
            media_poster: false,
            statusbar: resize,
            resize: resize,
            block_formats: 'Абзац=p;Heading 1=h2;Heading 2=h3;Heading 3=h4;Heading 4=h5;Heading 5=h6',
            fontsize_formats: '13px 15px 17px 20px 24px 29px',
            
            paste_auto_cleanup_on_paste : true,
            paste_remove_styles: true,
            paste_remove_styles_if_webkit: true,
            paste_strip_class_attributes: true,
            
            setup: function(editor) {
                editor.on('init', function() {
                    var $container = $(editor.getContainer());
                    
                    $container.addClass($field.attr('className')).removeClass('wysiwyg wysiwyg-advanced');
                });
            }
        });
    });
    
    
    
    // Dropdown
    
    $('.dropdown-block').each(function() {
        var $block = $(this),
            $trigger = $block.find('.dropdown-trigger'),
            $dropdown = $block.find('.dropdown');
            
        $trigger.on('click', function(e) {
            e.preventDefault();
            $block.toggleClass('dropdown-block-active');
        });
    });
    
    $(document).on('click', function(e) {
        if ($(e.target).closest('.dropdown, .dropdown-trigger').length) {
            return;
        }
        
        e.stopPropagation();
        $('.dropdown-block').removeClass('dropdown-block-active');
    });
    
    
    
    // Tabs
    
    $('.tabs').each(function() {
        var $tabs = $(this),
            $triggers = $tabs.find('.tabs-trigger'),
            $content = $tabs.find('.tabs-content');

        $triggers.each(function() {
            var $trigger = $(this),
                triggerContentId = $trigger.data('tabs-content'),
                $triggerContent = (triggerContentId)? $('#' + triggerContentId) : $content.eq($triggers.index($trigger));

            $trigger.on('click', function() {
                $triggers
                    .filter('.active')
                    .removeClass('active');
                $trigger.addClass('active');

                $content
                    .filter('.active')
                    .removeClass('active');
                    
                $triggerContent.addClass('active');
            });
        });
    });
    
    
    
    // Entry list
    
    $('.entry-list').each(function() {
        var $block = $(this),
            $heading = $block.find('.entry-list-heading'),
            $more = $block.find('.entry-list-more'),
            $container = $block.find('.entry-list-items'),
            $filterTriggers = $block.find('.entry-list-filters button'),
            $footer = $block.find('.entry-list-footer'),
            amount = $container.children().length;
            maxAmount = $block.data('entry-list-max-amount'),
            page = $block.data('entry-list-page'),
            url = $block.data('entry-list-url'),
            currentQuery = '';
            
        $filterTriggers.on('click', function() {
            var $filterTrigger = $(this),
                area;
                
            if ($filterTrigger.hasClass('filters-trigger-active')) {
                return;
            }
            
            area = $filterTrigger.data('filters-area');
            currentQuery = (area == 'all') ? '' : 'headings[' + area + ']=1';
            
            $filterTriggers.removeClass('filters-trigger-active');
            $filterTrigger.addClass('filters-trigger-active');
            $more.attr('disabled', true);
            
            $.get(url, currentQuery, function(response) {
                var $newItems = $(response).filter('.entry-list-item'),
                    $oldItems = $container.children(),
                    itemsHeight = 0,
                    hiddenItemsCount = 0;
                
                $newItems
                    .appendTo($container)
                    .each(function() {
                        itemsHeight += $(this).outerHeight(true);
                    })
                    .hide();
                    
                itemsHeight -= parseInt($newItems.first().css('margin-top'));
                    
                $container.animate({
                    height: itemsHeight
                });
                
                if (!$oldItems.length) {
                    $newItems.fadeIn(300);
                } else {
                    $oldItems.fadeOut(300, function() {
                        hiddenItemsCount++;
                        $(this).remove();
                        
                        if (hiddenItemsCount == $oldItems.length) {
                            $newItems.fadeIn();
                        }
                    });
                }
                
                $heading.text($filterTrigger.text());
                
                page = 1;
                amount = $newItems.length;
                maxAmount = $newItems.first().data('entry-list-max-amount') || 0;
                
                if (amount >= maxAmount) {
                    $footer.slideUp();
                } else {
                    $footer.slideDown();
                    $more.attr('disabled', false);
                }
            });
        });
        
        $more.on('click', function() {
            $more.attr('disabled', true);
            
            $.get(url + '?page=' + (page + 1), currentQuery, function(response) {
                var $newItems = $(response).filter('.entry-list-item'),
                    containerHeight = $container.height(),
                    itemsHeight = 0;
                
                $container.height(containerHeight);
                
                $newItems
                    .appendTo($container)
                    .each(function() {
                        itemsHeight += $(this).outerHeight(true);
                    });
                    
                $container.animate({
                    height: containerHeight + itemsHeight
                });
                
                page++;
                amount = $container.find('.entry-list-item').length;
                
                if (amount >= maxAmount) {
                    $footer.slideUp();
                } else {
                    $more.attr('disabled', false);
                }
            });
        });
    });



    // Image uploader
    
    $('.image-uploader').each(function() {
        if (!window.FileReader) {
            return;
        }
        
        var $block = $(this),
            $input = $block.find('.image-uploader-input'),
            previewSelector = $block.data('image-uploader-preview'),
            $preview = previewSelector ? $(previewSelector) : $block.find('.image-uploader-preview'),
            fileReader = new FileReader();
            
        if (!$preview.length) {
            return;
        }
        
        fileReader.onload = function(e) {
            if ($preview[0].tagName.toLowerCase() == 'img') {
                $preview.attr('src', e.target.result);
            } else {
                $preview.css('backgroundImage', 'url(' + e.target.result + ')');
            }
        };
         
        fileReader.onerror = function(event) {
        };
            
        $input.on('change', function(e) {
            var files = e.target.files || e.target.dataTransfer.files;
            
            if (files[0].size / 1024 / 1024 > 10) {
                alert('Размер файла не должен превышать 10 мегабайт.');
                return;
            }
            
            fileReader.readAsDataURL(files[0]);
            $block.addClass('image-uploader-active');
        });
    });
    
    
    
    // Datepicker
    
    $.extend($.fn.pickadate.defaults, {
        monthsFull: [ 'Январь', 'Февраль', 'Марта', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь' ],
        monthsShort: [ 'Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек' ],
        weekdaysFull: [ 'воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота' ],
        weekdaysShort: [ 'вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб' ],
        today: 'Cегодня',
        clear: 'Очистить',
        close: 'Закрыть',
        firstDay: 1,
        format: 'd mmmm yyyy',
        formatSubmit: 'yyyy-mm-dd',
        hiddenName: true
    });

    $('.datepicker').pickadate({
        // min: true,
        // max: true,
    });
});