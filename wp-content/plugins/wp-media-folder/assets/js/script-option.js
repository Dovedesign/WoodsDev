(function ($) {
    
    importWpmfTaxo = function(doit, button) {
        jQuery(button).closest('div').find('.spinner').show().css('visibility','visible');
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                action: "import_categories",
                doit: doit
            },
            success: function(response) {
                jQuery(button).closest('div').find('.spinner').hide();
                jQuery(button).closest('div').find('.wpmf_info_update').fadeIn(1000).delay(500).fadeOut(1000);
            }
        });
    }
    
    bindSelect = function(){
        $('#add_weight').on('click',function(){
            if(($('.wpmf_min_weight').val() == '') || ($('.wpmf_min_weight').val() == '' && $('.wpmf_max_weight').val() == '')){
                $('.wpmf_min_weight').focus();
            }else if($('.wpmf_max_weight').val() == ''){
                $('.wpmf_max_weight').focus();
            }else{
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data :  {
                        action : "wpmf_add_weight",
                        min_weight : $('.wpmf_min_weight').val(),
                        max_weight : $('.wpmf_max_weight').val(),
                        unit : $('.wpmfunit').val(),
                    },
                    success : function(res){
                        if(res != false){
                            var new_weight = '<li class="customize-control customize-control-select item_weight" style="display: list-item;" data-value="'+ res.key +'" data-unit="'+ res.unit +'">';
                                new_weight += '<input type="checkbox" name="weight[]" value="'+ res.key+','+res.unit+'" data-unit="'+ res.unit +'" >';
                                new_weight += '<span>'+ res.label +'</span>';
                                new_weight += '<i class="md md-delete wpmf-delete" data-label="weight" data-value="'+ res.key +'" data-unit="'+ res.unit +'" title="'+ wpmflang.unweight +'"></i>';
                                new_weight += '<i class="md md-edit wpmf-md-edit" data-label="weight" data-value="'+ res.key +'" data-unit="'+ res.unit +'" title="'+ wpmflang.editweight +'"></i>';
                                new_weight += '</li>';
                            $('.content_list_fillweight li.weight').before(new_weight);
                        }else{
                            alert(wpmflang.error);
                        }
                        $('li.weight input').val(null);
                        $('.wpmfunit option[value="kB"]').prop('selected',true).change();
                    }
                });
            }
        });
        
        $('#add_dimension').on('click',function(){
            if(($('.wpmf_width_dimension').val() == '') || ($('.wpmf_width_dimension').val() == '' && $('.wpmf_height_dimension').val() == '')){
                $('.wpmf_width_dimension').focus();
            }else if($('.wpmf_height_dimension').val() == ''){
                $('.wpmf_height_dimension').focus();
            }else{
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data :  {
                        action : "wpmf_add_dimension",
                        width_dimension : $('.wpmf_width_dimension').val(),
                        height_dimension : $('.wpmf_height_dimension').val(),
                    },
                    success : function(res){
                        if(res != false){
                            var new_dimension = '<li class="customize-control customize-control-select item_dimension" style="display: list-item;" data-value="'+ res +'">';
                                new_dimension += '<input type="checkbox" name="dimension[]" value="'+ res +'" >';
                                new_dimension += '<span>'+ res +'</span>';
                                new_dimension += '<i class="md md-delete wpmf-delete" data-label="dimension" data-value="'+ res +'" title="'+ wpmflang.undimension +'"></i>';
                                new_dimension += '<i class="md md-edit wpmf-md-edit" data-label="dimension" data-value="'+ res +'" title="'+ wpmflang.editdimension +'"></i>';
                                new_dimension += '</li>';
                            $('.content_list_filldimension li.dimension').before(new_dimension);
                        }else{
                            alert(wpmflang.error);
                        }
                        $('li.dimension input').val(null);
                    }
                });
            }
        });
        
        $('.wpmf-delete').live('click',function(){
            var $this = $(this);
            var value = $this.data('value');
            var label = $this.data('label');
            var unit = $this.data('unit');
            if(label == 'dimension'){
                var action = 'wpmf_remove_dimension';
            }else{
                var action = 'wpmf_remove_weight';
            }
            
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data :  {
                    action : action,
                    value : value,
                    unit : unit
                },
                success : function(res){
                    if(res == true){
                        $this.closest('li').remove();
                    }
                }
            });
        });
        
        $('.wpmfedit').live('click',function(){
            var $this = $(this);
            var label = $this.data('label');
            var curent_value = $('#edit_'+ label +'').data('value');
            var unit = $('.wpmfunit').val();
            if(label == 'dimension'){
                var new_value = $('.wpmf_width_dimension').val()+'x'+$('.wpmf_height_dimension').val();
            }else{
                if(unit == 'kB'){
                    var new_value = ($('.wpmf_min_weight').val()*1024)+'-'+($('.wpmf_max_weight').val()*1024)+','+unit;
                }else{
                    var new_value = ($('.wpmf_min_weight').val()*(1024*1024))+'-'+($('.wpmf_max_weight').val()*(1024*1024))+','+unit;
                }
            }
                
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data :  {
                    action : 'wpmf_edit',
                    label : label,
                    old_value : $this.data('value'),
                    new_value : new_value,
                    unit : $('.wpmfunit').val(),
                },
                success : function(res){
                    if(res !=  false){
                        if(label == 'dimension'){
                            $('li.item_'+ label +'[data-value="'+ curent_value +'"]').find('.wpmf-delete').attr('data-value',res.value).data('value',res.value);
                            $('li.item_'+ label +'[data-value="'+ curent_value +'"]').find('.wpmf-md-edit').attr('data-value',res.value).data('value',res.value);
                            $('li.item_'+ label +'[data-value="'+ curent_value +'"]').find('input[name="'+ label +'[]"]').val(res.value);
                            $('.content_list_filldimension li[data-value="'+ curent_value +'"]').find('span').html(new_value);
                            $('li.item_'+ label +'[data-value="'+ curent_value +'"]').attr('data-value',res.value).data('value',res.value);
                        }else{
                            var cur_val = curent_value.split(',');
                            $('li.item_'+ label +'[data-value="'+ cur_val[0] +'"]').find('.wpmf-delete').attr('data-value',res.value).data('value',res.value);
                            $('li.item_'+ label +'[data-value="'+ cur_val[0] +'"]').find('.wpmf-md-edit').attr('data-value',res.value).data('value',res.value);
                            $('li.item_'+ label +'[data-value="'+ cur_val[0] +'"]').find('input[name="'+ label +'[]"]').val(res.value+','+cur_val[1]);
                            $('.content_list_fillweight li[data-value="'+ cur_val[0] +'"]').find('span').html(res.label);
                            $('li.item_'+ label +'[data-value="'+ cur_val[0] +'"]').attr('data-value',res.value).data('value',res.value);
                        }
                        
                    }else{
                        alert(wpmflang.error);
                    }
                    $('.wpmf_can,#edit_'+ label +'').hide();
                    $('#edit_'+ label +'').attr('data-value',null).data('value',null);
                    $('#add_'+ label +'').show();
                    $('li.'+ label +' input').val(null);
                }
            });
        });
        
        $('.wpmf-md-edit').live('click',function(){
            var $this = $(this);
            var value = $this.data('value');
            var unit = $this.data('unit');
            var label = $this.data('label');
            $('.wpmf_can[data-label="'+ label +'"]').show();
            $('#add_'+ label +'').hide();
            
            if(label == 'dimension'){
                $('#edit_'+ label +'').show().attr('data-value',value).data('value',value);
                var value_array = value.split('x');
                $('.wpmf_width_dimension').val(value_array[0]);
                $('.wpmf_height_dimension').val(value_array[1]);
            }else{
                $('#edit_'+ label +'').show().attr('data-value',value+','+unit).data('value',value+','+unit);
                var unit = $this.data('unit');
                var value_array = value.split('-');
                if(unit == 'kB'){
                    $('.wpmf_min_weight').val(value_array[0]/1024);
                    $('.wpmf_max_weight').val(value_array[1]/1024);
                }else{
                    $('.wpmf_min_weight').val(value_array[0]/(1024*1024));
                    $('.wpmf_max_weight').val(value_array[1]/(1024*1024));
                }
                $('select.wpmfunit option[value="'+ unit +'"]').prop('selected',true).change();
            }
        });
        
        $('.wpmf_can').live('click',function(){
            var $this = $(this);
            var label = $this.data('label');
            $this.hide();
            $('#edit_'+ label +'').hide();
            $('#edit_'+ label +'').attr('data-value',null).data('value',null);
            $('#add_'+ label +'').show();
            $('li.'+ label +' input').val(null);
            if(label == 'weight'){
                $('.wpmfunit option[value="kB"]').prop('selected',true).change();
            }
        });
        
        $('.wpmf-section-title').on('click',function(){
            var title = $(this).data('title');
            if($(this).closest('li').hasClass('open')){
                $('.content_list_'+ title +'').slideUp('fast');
                $(this).closest('li').removeClass('open');
            }else{
                $('.content_list_'+ title +'').slideDown('fast');
                $(this).closest('li').addClass('open')
            }
        });
        
        $('#wmpfImpoBtn').on('click',function(){
            $(this).addClass('button-primary');
            importWpmfTaxo(true,this);
        });
        
        $('.btn_import_gallery').on('click',function(){
            $('.btn_import_gallery').closest('div').find('.spinner').show().css('visibility','visible');
            $(this).addClass('button-primary');
            $.ajax({
                type: 'POST',
                url : ajaxurl,
                data :  {
                    action : "import_gallery",
                    doit : true
                },
                success : function(res){
                    $('.btn_import_gallery').closest('div').find('.spinner').hide();
                    $('.btn_import_gallery').closest('div').find('.wpmf_info_update').fadeIn(1000).delay(500).fadeOut(1000);
                }
            });
        });
        
        $('.cb_option').unbind('click').bind('click', function() {
            var check = $(this).attr('checked');
            var type = $(this).attr('type');
            var value;
            var $this = $(this);
            if (type == 'checkbox') {
                if (check == 'checked') {
                    value = 1;
                    if($(this).data('label') == 'wpmf_active_media'){
                        $('.wpmf_show_media').slideDown('fast');
                    }
                } else {
                    if($(this).data('label') == 'wpmf_active_media'){
                        $('.wpmf_show_media').slideUp('fast');
                    }
                    value = 0;
                }
                $('input[name="'+ $(this).data('label') +'"]').val(value);
            }else{
                $this.closest('div').find('.spinner').show().css('visibility','visible');
                $('.cb_option').removeClass('button-primary');
                $(this).addClass('button-primary');
                value = $(this).data('value');
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: {
                        action: "update_opt",
                        label: $(this).data('label'),
                        value: value
                    },
                    success: function(res) {
                        $this.closest('div').find('.spinner').hide();
                        $this.closest('div').find('.wpmf_info_update').fadeIn(1000).delay(500).fadeOut(1000);
                    }
                });
            } 
        });
    }
    
    $(document).ready(bindSelect);
})(jQuery);