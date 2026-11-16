<form id="form-id" onsubmit="return false">
	<input id="order_id" name="order_id" type="hidden" value="<?= $order_id ?>">
	<div class="mb-3">
		<input id="rating" name="rating" type="hidden" value="3">
		<div class="full-star-ratings" data-rateyo-full-star="true"></div>
	</div>
	<div class="mb-4">
	  	<label for="comment" class="form-label">Example textarea</label>
	  	<textarea class="form-control" id="comment" name="comment" rows="5"></textarea>
	</div>
	<div class="row">
		<div class="col-12 d-flex justify-content-between">
		    <button type="button" data-bs-dismiss="modal" class="btn btn-label-secondary">Batal</button>
		    <button id="saveRate" type="button" class="btn btn-primary">Simpan</button>
		</div>
	</div>	
</form>

<script type="text/javascript">
	$('.full-star-ratings').rateYo({
        rating: 3
    });

	$('.full-star-ratings').click(function () {
		starRate = $('.full-star-ratings').rateYo();
		rating = starRate.rateYo('rating');

		$('#rating').val(rating);
	});

    $('#saveRate').click(function() {
        var FormData = '&' + $('#form-id input, textarea').serialize();

        $.ajax({
            url: '<?= base_url('save_rate')?>',
            type: 'POST',
            cache: false,
            data: FormData,
            dataType: 'json',
            success: function(json) {
                if (json.status) {
                    sweetalert(null, 'success', json.message);
                    $('#basicModal').modal('hide');
                }else{
                    sweetalert(null, 'warning', json.message);
                }
            }
        });
    });	
</script>
