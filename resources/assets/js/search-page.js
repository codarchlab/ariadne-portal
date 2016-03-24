/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    placeGetMoreLinkForAggregations();

    $('.get-more').click(function () {
        $(this).button('loading');
        var aggregationElement = $(this);
        var aggregation = $(aggregationElement)
                            .parents('div.aggregation')
                            .attr('data-aggregation');

        var vars = getUrlVars();

        vars.noPagination = 'true';
        vars.size = 0;

        $.ajax({
            type: "GET",
            url: '/aggregation/'+aggregation+'/bucket',
            data: vars
        }).then(function (data) {
            var elements = $(data);
            var content = $('.aggregation-items', elements).html();

            $(aggregationElement).parents('div.aggregation-items').html(content);

            placeGetMoreLinkForAggregations();
        });
        
        return false;
    });
    
    $('div.aggregation div.panel-heading a').click(function(){
        var iconElement = $(this).find('span.glyphicon');
        if(iconElement.hasClass('glyphicon-menu-down')){
            iconElement.addClass('glyphicon-menu-right').removeClass('glyphicon-menu-down');
        }else{
            iconElement.addClass('glyphicon-menu-down').removeClass('glyphicon-menu-right');
        }
    });
    
    $("#sort-action").on('change', function() {
        $("input[name='sort']").val($("#sort-action").val());
        $("#searchPageForm").submit();
    });
});


function placeGetMoreLinkForAggregations(){
    var loadMoreLink = '<a href="#" class="list-group-item get-more"><span class="glyphicon glyphicon-plus"></span> Load more</a>';
    $('.aggregation').each(function () {
        if($(this).find('.list-group a.get-more').length == 0){
            var aggregation = $(this).attr('data-aggregation');
            var size = $(this).find('.list-group a.value').length;

            if (size % 10 == 0) {
                $(this).find('.list-group a.value')
                       .last()
                       .after(loadMoreLink);
            }
        }
    });    
}

function getUrlVars(){
    return new Query.fromUri(window.location.href).params;
}

/*
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
*/