
<div style="padding: 10px">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total 1st Level Referrals</h5>
                    <p class="card-text" style="font-size: 10rem"><?= $referralFirst ?></p>
                </div>
            </div>
            <br>
            <button class="btn btn-primary" id="btnPayout">New Payout Request</button>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total 2nd Level Referrals</h5>
                    <p class="card-text" style="font-size: 10rem"><?= $referralSecond ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total 3rd Level Referrals</h5>
                    <p class="card-text" style="font-size: 10rem"><?= $referralThird ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="payoutModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Total amount:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnClose">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <center> <h1>₱<?= $total ?>.00</h1> </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Request</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnClose">Close</button>
      </div>
    </div>  
  </div>
</div>
<script type="text/javascript">    
    $(function () {
        $("#btnPayout").click(function () {
            $("#payoutModal").modal("show");
        });
    });
    $('#btnClose').on('click', function () {
      $('#payoutModal').hide();
    });
</script>