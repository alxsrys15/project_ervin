<?php $this->Form->templates(['inputContainer' => '{{content}}']) ?>

<div style="padding: 10px">
    <div class="row">
        <div class="col-sm-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Deposit Reference #</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($users) > 0): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user->first_name ?></td>
                                <td><?= $user->last_name ?></td>
                                <td><?= $user->email ?></td>
                                <td><?= $user->reference_number ?></td>
                                <td><?= $user->status ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif ?>
                </tbody>
            </table>
            <div class="row justify-content-center">
                <div class="col-12">
                    <nav>
                        <ul class="pagination" id="pagination">
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

