/**
 * Filter for the service page
 * hide divs mot matching the filter text
 */
$(document).ready(function () {
    $('.service-search').keyup(function(){
        var search = $('input.service-search').val();
        
        $('#services div').show(); 
        $('div.service:not(:contains('+ search +'))').hide(); 

        $('div.service_divider').each(function(e){
            var service_type = $(this).attr('data-type');

            if($('div.'+service_type+':visible').length === 0){
                $(this).hide();
            }
        })
    });
});