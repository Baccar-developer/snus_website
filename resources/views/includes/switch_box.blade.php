<div class="switch_button {{$name}}" 
	@if(isset($checked)  )
		@if($checked==1)
		chk = "true"
		@else
		chk="false"
		@endif
	@else
	chk="true"
	@endif
	
	>
    <div class="ball"></div>
    <input type="hidden" name='{{$name}}' 
    @if(isset($checked))
    	value='{{$checked}}'
    @else
    value='1' 
    @endif >
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