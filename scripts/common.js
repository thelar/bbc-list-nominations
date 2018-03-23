jQuery(document).ready(function($){
    $('#bbc_list_nomination_form').on("submit", function(){
        console.log('form submit');
        var ntype = $('#type-select').val();
        var region = $('#region-select').val();
        var base = '/pdf-nominations/';
        if(ntype.length!==0){
            base+= 'type/' + ntype + '/';
        }
        if(region.length!==0){
            base+= 'region/' + region + '/';
        }
        console.log(base);
        return false;
    });
});
