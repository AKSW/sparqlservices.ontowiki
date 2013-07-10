$(document).ready(function(){
    /**
     * Set onChange event for select box above
     */
    $("#sparqlServ-selectPreConfEndpoint").change(function(event){
    
        // if use change select-box, there is a redirect and a new sparql
        // endpoint will be set
        window.location.href = $(this).val();
    });
    
    /**
     * 
     */
    $("#sparqlServ-hidingContainerIfModelSetBtn").click(function(){
        $("#sparqlServ-hidingContainerIfModelSet").fadeIn("slow", function(){
            $("#sparqlServ-hidingContainerIfModelSetBtn").fadeOut("slow");
        });
    });
});
