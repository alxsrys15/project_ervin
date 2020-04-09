<?php $session = $this->request->session()->read('Auth.User') ?>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <?php if ($session['user_level_id'] === 2): ?>
    <li class="nav-item">
        <a href="#!" class="nav-link" id="packages-tab" data-toggle="tab" data-model="users" data-method="getPackages">My packages</a>
    </li>
        <?php if ($session['status'] === "Active"): ?>
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" data-model="users" data-method="getReferrals" href="#!">My Referrals</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="captcha-tab" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false" data-model="captchas" data-method="index" href="#!">Captcha</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"data-toggle="tab" role="tab" aria-controls="messages" aria-selected="false" data-model="payout-requests" data-method="referralPayout" href="#!">Referral Payout</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" role="tab" aria-controls="messages" aria-selected="false" data-model="captcha-payouts" data-method="captchaPayout" href="#!">Captcha Payout</a>
        </li>
        <?php endif ?>
    <?php else: ?>
    <li class="nav-item">
        <a class="nav-link" id="users-tab" data-toggle="tab" role="tab" aria-controls="settings" aria-selected="false" data-model="users" data-method="index" href="#!">Users</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="settings-tab" data-toggle="tab" role="tab" aria-controls="settings" aria-selected="false" href="#!" data-model="packages" data-method="index">Packages</a>
    </li>
    <li class="nav-item"> 
        <a href="#!" class="nav-link" data-toggle="tab" role="tab" data-model="package-requests" data-method="index">Package Requests</a>
    </li>
    <li class="nav-item">
        <a href="#!" class="nav-link" data-toggle="tab" id="requests-tab" data-model="payout-requests" data-method="getRequests">Referral Payout Requests</a>
    </li>
    <li class="nav-item">
        <a href="#!" class="nav-link" data-toggle="tab" id="requests-tab" data-model="captcha-payouts" data-method="index">Captcha Payout Requests</a>
    </li>
    <?php endif ?>
    

</ul>

<div id="tab-content">   

</div>

<script type="text/javascript">
    $(document).ready(function () {
        var params = "<?= !empty($this->request->params['pass']) ? $this->request->params['pass'][0] : ""  ?>";
        console.log(params == "view");
        $('#myTab a').on('click', function (e) {
            e.preventDefault()
            var model = $(this).data('model');
            var method = $(this).data('method');
            $.ajax({
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                url: url + model + '/' + method,
                type: 'post',
                beforeSend: function () {
                    $('#blocker').show();
                },
                success: function (data) {
                    $('#blocker').hide();
                    $('#tab-content').html(data);
                },
                error: function (err) {
                    $('#blocker').hide();
                    console.log(err.responseText);
                }
            })
        });

        if (params == "view") {
            $("#captcha-tab").trigger('click');
        } else {
            $('#myTab a').first().trigger('click');
        }

        $(document).on('click', '#pagination a', function () {
            var target = $(this).attr('href');
            if (!target) return false;
            $.ajax({
                header: {
                    'X-CSRF-Token': csrfToken,
                    url: target,
                    beforeSend: function () {
                        $('#blocker').show();
                    },
                    success: function (data) {
                        $('#blocker').hide();
                        $('#tab-content').html(data);
                    }
                }
            });
            return false;
        })
    });
</script>

