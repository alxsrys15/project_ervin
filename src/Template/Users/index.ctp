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
                        <th>Action</th>
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
                                <td>
                                    <?php if ($user->status === "Inactive"): ?>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#activateModal" data-user_id="<?= $user->id ?>">Activate</button>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="activateModal">
    <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'activateUser']]) ?>
    <?= $this->Form->input('user_id', ['type' => 'hidden']) ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Activate user?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->input('package_id', ['type' => 'select', 'empty' => 'Please select a package', 'options' => $packages, 'label' => 'Please select a package', 'class' => 'custom-select']) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-flat" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Activate</button>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#activateModal').on('show.bs.modal', function (e) {
            var user_id = $(e.relatedTarget).data('user_id');
            $('#user-id').val(user_id);
        });
    });
</script>