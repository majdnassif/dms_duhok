<div class="trace-details-container">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered table-striped">
                <tr>
                    <th width="40%"><?= $this->Dictionary->GetKeyword('Type'); ?></th>
                    <td><?= $this->Dictionary->GetKeyword($trace['import_trace_type_name']); ?></td>
                </tr>

                <tr>
                    <th><?= $this->Dictionary->GetKeyword('Sender Department'); ?></th>
                    <td><?= $trace['sender_department']; ?></td>
                </tr>

                <tr>
                    <th width="40%"><?= $this->Dictionary->GetKeyword('Receiver Department'); ?></th>
                    <td><?= $trace['receiver_department']; ?></td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered table-striped">
                <tr>
                    <th><?= $this->Dictionary->GetKeyword('Sender User'); ?></th>
                    <td><?= $trace['sender_user']; ?></td>
                </tr>
                <tr>
                    <th><?= $this->Dictionary->GetKeyword('Receiver User'); ?></th>
                    <td><?= $trace['receiver_user'] ?? ''; ?></td>
                </tr>
                <tr>
                    <th><?= $this->Dictionary->GetKeyword('Sent Date'); ?></th>
                    <td><?= $trace['import_trace_sent_date'] ? date('Y-m-d', strtotime($trace['import_trace_sent_date'])) : ''; ?></td>
                </tr>
<!--                <tr>-->
<!--                    <th>--><?php //= $this->Dictionary->GetKeyword('Received Date'); ?><!--</th>-->
<!--                    <td>--><?php //= $trace['import_trace_received_date'] ? date('Y-m-d', strtotime($trace['import_trace_received_date'])) : ''; ?><!--</td>-->
<!--                </tr>-->

                <tr>
                    <th><?= $this->Dictionary->GetKeyword('Status'); ?></th>
                    <td>
                        <?php if ($trace['import_trace_status_id'] == 1): ?>
                            <span class="label label-warning"><?= $trace['import_trace_status_name']; ?></span>
                        <?php elseif ($trace['import_trace_status_id'] == 3): ?>
                            <span class="label label-success"><?= $trace['import_trace_status_name']; ?></span>
                        <?php elseif ($trace['import_trace_status_id'] == 4): ?>
                            <span class="label label-danger"><?= $trace['import_trace_status_name']; ?></span>
                        <?php else: ?>
                            <span class="label label-default"><?= $trace['import_trace_status_name']; ?></span>
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <th><?= $this->Dictionary->GetKeyword('Action'); ?></th>
                    <td><?= $this->Dictionary->GetKeyword($trace['action_type_name']); ?></td>
                </tr>
            </table>
        </div>
    </div>
    
    <?php if (!empty($trace['import_trace_note'])): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Notes'); ?></h3>
                </div>
                <div class="panel-body">
                    <?= nl2br($trace['import_trace_note']); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($trace['import_trace_attachment'])): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Attachments'); ?></h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th><?= $this->Dictionary->GetKeyword('File Name'); ?></th>
                                <th width="15%"><?= $this->Dictionary->GetKeyword('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($trace['import_trace_attachment'] as $index => $attachment): ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= $attachment['original_name']; ?></td>
                                <td>
                                    <a href="<?= base_url($attachment['file_path']); ?>" class="btn btn-sm btn-info" target="_blank">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div> 