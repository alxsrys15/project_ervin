<div style="padding: 10px">
    <div class="row">
        <div class="col-sm-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Date Covered</th>
                        <th>Total Captcha</th>
                        <th>Total Referral</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($requests) > 0): ?>
                        <?php foreach ($requests as $request): ?>
                            
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td class="text-center" colspan="20">No results found.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>