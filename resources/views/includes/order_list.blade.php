
<script>
    $(document).ready(function() {
    
    	$.ajax({
    		url: "{{url('paginate_items')}}",
    		method :'get',
    		data:{chart_id:{{$chart_id}}},
    		dataType: 'json',
            success: function(response) {
                $('#items-{{$chart_id}}').html(response.html);
                $('#pagination-links-{{$chart_id}}').html(response.links);
            }
    	});
    
        $(document).on('click', '#pagination-links-{{$chart_id}} a', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            
            $.ajax({
                url: url,
                method: 'get',
                dataType: 'json',
                success: function(response) {
                    $('#items-{{$chart_id}}').html(response.html);
                    $('#pagination-links-{{$chart_id}}').html(response.links);
                }
            });
        });
    });
</script>
 <table class="table table-dark table-striped" id="items-{{$chart_id}}">
 	
 </table>
 <div id="pagination-links-{{$chart_id}}"></div>