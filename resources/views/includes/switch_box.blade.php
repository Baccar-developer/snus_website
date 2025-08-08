<div class="switch_button {{$name}}" chk="true">
    <div class="ball"></div>
    <input type="hidden" name='{{$name}}' value='1' >
</div>

<style>


.switch_button.{{$name}}[chk='false']{
    background-color :var(--bs-dark);
}


.switch_button[chk='false'].{{$name}} .ball{
    left:0px;
}
</style>

<script>

$(document).ready(function(){
    $(".switch_button.{{$name}}").click(function(){
    	if($(this).attr("chk")=="true"){
    		$(this).attr("chk" , "false");
    		$(this).children("input").attr('value' ,'0');
    	}
    	else{
    	
    		$(this).attr("chk" , "true");
    		$(this).children("input").attr('value' ,'1');
    	}
    });
})


</script>