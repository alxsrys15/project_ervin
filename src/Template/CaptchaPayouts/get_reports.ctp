<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>

<div style="padding: 10px">
    <div class="row">
        <div class="col-sm-4">
            <?= $this->Form->input('transaction_type', [
                'type' => 'select',
                'options' => [
                    'captcha-payouts' => 'Captcha',
                    'payout-requests' => 'Referrals'
                ],
                'class' => 'custom-select'
            ])  ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date Coverage</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($requests) > 0): ?>
                        <?php foreach ($requests as $request): ?>
                            <tr>
                                <td><?= $request->date_start->format('Y-m-d') . ' - ' . $request->date_end->format('Y-m-d') ?></td>
                                <td>P <?= $request->total ?></td>
                                <td> <?= $request->status ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td class="text-center" colspan="20">No results found.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
            <div class="row justify-content-center">
                <div class="col-12">
                    <nav>
                        <ul class="pagination">
                            <?= $this->Paginator->prev('Previous') ?>
                            <?= $this->Paginator->numbers(['modulus' => 2]) ?>
                            <?= $this->Paginator->next('Next') ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>