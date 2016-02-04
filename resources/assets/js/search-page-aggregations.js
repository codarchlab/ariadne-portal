/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    placeGetMoreLinkForAggregations();

    $('.get-more').click(function () {
        var aggregationElement = $(this);
        var aggregation = $(aggregationElement).parents('div.aggregation').attr('data-aggregation');

        var vars = $.getUrlVars();
        vars.noPagination = 'true';
        vars.size = 0;
        //console.log(vars);
        var params = jQuery.param(vars);
        $.ajax({
            type: "GET",
            contentType: "application/json",
            url: '/aggregation/'+aggregation+'?'+params,
        }).complete(function (data) {
            console.log(data);
            var elements = $(data.responseText);
            var content = $('.aggregation-items', elements).html();

            $(aggregationElement).parents('div.aggregation-items').html(content);
        });

        return false;
    });
});


function placeGetMoreLinkForAggregations(){
    $('.aggregation').each(function () {
        var aggregation = $(this).attr('data-aggregation');
        var size = $(this).find('.list-group a.value').length;

        if (size % 10 == 0) {
            console.log(aggregation + ' ' + size);
            $(this).find('.list-group a.value').last().after('<a href="#" class="list-group-item get-more">Load more</a>');

        } else {
            console.log('NÖPE ' + aggregation + ' ' + size);
        }
    });    
}


$.extend({
  getUrlVars: function(){
    var vars = {}, hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++){
      hash = hashes[i].split('=');
      vars[hash[0]] = decodeURIComponent(hash[1]);
    }
    return vars;
  },
  getUrlVar: function(name){
    return $.getUrlVars()[name];
  }
});