/**
 * Filter for the service page
 * hide divs mot matching the filter text
 */
$(document).ready(function () {
    $('.service-search').keyup(function(){
        var search = $('input.service-search').val().toLowerCase();
        
        $('#services div').show(); 
        $('div.service').filter( function (){
            return $( this ).text().toLowerCase().indexOf(search) < 0;
        }).hide();

        $('div.service_divider').each(function(e){
            var service_type = $(this).attr('data-type');

            if($('div.'+service_type+':visible').length === 0){
                $(this).hide();
            }
        })
    });
});