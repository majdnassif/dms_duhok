<style>
    .status-badge {
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
        color: #fff;
    }
</style>

<style>

    .book-details-panel {
        border: none;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .book-details-panel .panel-heading {
        background-color: #f8f9fa;
        border-bottom: 1px solid #eaeaea;
        padding: 8px 12px;
    }

    .book-details-panel .panel-title {
        font-size: 15px;
        font-weight: 600;
        color: #444;
    }

    .book-details-compact {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin: -5px;
    }

    .book-detail-row {
        flex: 0 0 calc(33.333% - 8px);
        min-width: 180px;
        padding: 6px 8px;
        border-bottom: 1px solid #f0f0f0;
    }

    .book-detail-label {
        font-size: 12px;
        color: #777;
        margin-bottom: 2px;
        font-weight: 500;
    }

    .book-detail-value {
        font-size: 13px;
        color: #333;
        word-break: break-word;
    }

    .attachment-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }

    .attachment-item {
        display: flex;
        background-color: #ffffff;
        border-radius: 4px;
        padding: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #e7f3f9;
        transition: all 0.2s ease;
    }

    .attachment-item:hover {
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        transform: translateY(-2px);
        border-color: #bce8f1;
    }

    .attachment-icon {
        position: relative;
        width: 46px;
        height: 60px;
        background-color: #f8f9fa;
        color: #5bc0de;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 24px;
        border-radius: 3px;
        border: 1px solid #eaeaea;
    }

    .attachment-ext {
        position: absolute;
        bottom: 3px;
        font-size: 9px;
        font-weight: bold;
        color: #666;
        text-transform: uppercase;
    }

    .attachment-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .attachment-name {
        font-size: 14px;
        color: #333;
        margin-bottom: 10px;
        word-break: break-word;
        max-height: 40px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .attachment-actions {
        display: flex;
        justify-content: flex-end;
    }

    .attachment-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 4px;
        margin-left: 8px;
        color: #fff;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .view-btn {
        background-color: #5bc0de;
    }

    .view-btn:hover {
        background-color: #31b0d5;
        color: #fff;
        text-decoration: none;
    }

    .download-btn {
        background-color: #5cb85c;
    }

    .download-btn:hover {
        background-color: #449d44;
        color: #fff;
        text-decoration: none;
    }

    /* Responsive adjustments for attachments */
    @media (max-width: 768px) {
        .attachment-grid {
            grid-template-columns: 1fr;
        }
    }


    .trace-type-badge {
        background-color: #337ab7;
        color: #fff;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-badge {
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
        color: #fff;
    }

    .status-badge.status-pending {
        background-color: #f0ad4e;
    }

    .status-badge.status-completed {
        background-color: #5cb85c;
    }

    .status-badge.status-rejected {
        background-color: #d9534f;
    }
    }
</style>

<?php if (isset($page_title)): ?>
    <div class="page-title">
        <h3><?= $this->Dictionary->GetKeyword($page_title); ?></h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="<?= base_url(); ?>"><?= $this->Dictionary->GetKeyword('Home'); ?></a></li>
                <li><a href="<?= base_url('Import/List'); ?>"><?= $this->Dictionary->GetKeyword('Out Documents'); ?></a></li>
                <li class="active"><?= $this->Dictionary->GetKeyword($page_title);?></li>
            </ol>
        </div>
    </div>
<?php endif; ?>

<div class="container-fluid">
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title" dir=''>
                    <?= $out['out_book_code']; ?>
                </h3>
                <div class="pull-right">
                    <?php if ($this->Permission->CheckPermissionOperation('out_edit')): ?>
                        <a href="<?= base_url('Out/Edit/' . $out['id']); ?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-edit"></i> <?= $this->Dictionary->GetKeyword('Edit'); ?>
                        </a>
                    <?php endif; ?>

                    <a href="<?= base_url('Out/List'); ?>" class="btn btn-sm btn-default">
                        <i class="fa fa-list"></i> <?= $this->Dictionary->GetKeyword('Back to List'); ?>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th width="40%"><?= $this->Dictionary->GetKeyword('Out Code'); ?></th>
                                <td><?= $out['out_book_code']; ?></td>
                            </tr>
                            <tr>
                                <th><?= $this->Dictionary->GetKeyword('Book Number'); ?></th>
                                <td><?= $out['out_book_number']; ?></td>
                            </tr>
                            <tr>
                                <th><?= $this->Dictionary->GetKeyword('Book Issue Date'); ?></th>
                                <td><?= $out['out_book_issue_date'] ? date('Y-m-d', strtotime($out['out_book_issue_date'])) : ''; ?></td>
                            </tr>

                            <tr>
                                <th><?= $this->Dictionary->GetKeyword('To Department'); ?></th>
                                <td><?= $out['out_to_department']; ?></td>
                            </tr>
                            <tr>
                                <th><?= $this->Dictionary->GetKeyword('From Department'); ?></th>
                                <td><?= $out['out_from_department']; ?></td>
                            </tr>
                            <?php if(isset($out['remote_branch_name']) && !empty($out['remote_branch_name'])): ?>
                                <tr>
                                    <th><?= $this->Dictionary->GetKeyword('To Remote Branch'); ?></th>
                                    <td><span class="status-badge" style="background-color: #dc21f3"><?= $out['remote_branch_name']; ?></span></td>
                                </tr>
                            <?php endif; ?>

                        </table>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-bordered table-striped">

                            <tr>
                                <th><?= $this->Dictionary->GetKeyword('Signed By'); ?></th>
                                <td><?= $out['out_signed_by']; ?></td>
                            </tr>
                            <tr>
                                <th><?= $this->Dictionary->GetKeyword('Book Category'); ?></th>
                                <td><?= $out['out_book_category'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <th><?= $this->Dictionary->GetKeyword('Book Language'); ?></th>
                                <td><?= $out['out_book_language'] ?? ''; ?></td>
                            </tr>
                            <!--                            <tr>-->
                            <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Status'); ?><!--</th>-->
                            <!--                                <td>--><?php //= $out['out_status_name'] ?? ''; ?><!--</td>-->
                            <!--                            </tr>-->
                            <!--                            <tr>-->
                            <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Is Direct'); ?><!--</th>-->
                            <!--                                <td>--><?php //= $out['import_is_direct'] ? '<span class="label label-success">'.$this->Dictionary->GetKeyword('Yes').'</span>' : '<span class="label label-default">'.$this->Dictionary->GetKeyword('No').'</span>'; ?><!--</td>-->
                            <!--                            </tr>-->

                            <tr>
                                <th><?= $this->Dictionary->GetKeyword('Created By'); ?></th>
                                <td><?= $out['created_by_name']; ?></td>
                            </tr>
                            <tr>
                                <th><?= $this->Dictionary->GetKeyword('Book Subject'); ?></th>
                                <td><?= $out['out_book_subject']; ?></td>
                            </tr>

                            <tr>
                                <th><?= $this->Dictionary->GetKeyword('Entry Date'); ?></th>
                                <td><?= $out['out_created_at'] ? date('Y-m-d', strtotime($out['out_created_at'])) : ''; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <?php if (!empty($out['out_note'])): ?>
                        <div class="col-md-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Notes'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <?= nl2br($out['out_note'] ?? ''); ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Body'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <?= nl2br($out['out_book_body'] ?? ''); ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Copy List'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <?= nl2br($out['out_book_copy_list'] ?? ''); ?>
                                </div>
                            </div>
                        </div>



                        <!-- Import Answers Section -->
                        <?php if ( !empty($out['out_is_answer']) && $out['out_is_answer'] == 1): ?>

                            <div class="col-md-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Answers'); ?></h3>
                                    </div>
                                    <div class="panel-body">
                                        <?php if (isset($out_answers) && !empty($out_answers)): ?>
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th><?= $this->Dictionary->GetKeyword('Import Document Exists'); ?></th>
                                                    <th><?= $this->Dictionary->GetKeyword('Import Book Number'); ?></th>
                                                    <th><?= $this->Dictionary->GetKeyword('Import Book Date'); ?></th>
                                                    <th><?= $this->Dictionary->GetKeyword('Import Department'); ?></th>
                                                    <th><?= $this->Dictionary->GetKeyword('Created By'); ?></th>
                                                    <th ><?= $this->Dictionary->GetKeyword('Actions'); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($out_answers as $index => $answer): ?>
                                                    <tr>
                                                        <td><?= $index + 1; ?></td>
                                                        <td>
                                                            <?php if ($answer['import_id'] == 1): ?>
                                                                <span class="label label-success"><?= $this->Dictionary->GetKeyword('Yes'); ?></span>
                                                            <?php else: ?>
                                                                <span class="label label-danger"><?= $this->Dictionary->GetKeyword('No'); ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= $answer['import_book_number']; ?></td>
                                                        <td><?= $answer['import_book_date']; ?></td>
                                                        <td><?= $answer['import_from_department']; ?></td>
                                                        <td><?= $answer['created_by_name'] ?? ''; ?></td>

                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <?php if ($this->Permission->CheckPermissionOperation('out_edit')): ?>
                                                                    <button type="button" class="btn btn-danger delete-answer" data-answer-id="<?= $answer['id']; ?>">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <div class="alert alert-info">
                                                <?= $this->Dictionary->GetKeyword('No trace records found for this document.'); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>


                        <?php endif; ?>


                    <?php endif; ?>
                    <?php if (!empty($out['out_attachment'])): ?>
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
                                        <?php foreach ($out['out_attachment'] as $index => $attachment): ?>
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
                    <?php endif; ?>
                </div>


            </div>
            <!-- /.card-body -->
        </div>


        <?php if(isset($import) && !empty($import)): ?>

            <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title" dir=''>
                    <?= $this->Dictionary->GetKeyword('Related Import'); ?>
                </h3>
                <div class="pull-right">

                    <a href="<?= base_url("Import/Details/" . $import['import_id']);?>" target="_blank" class="btn btn-sm btn-default">
                        <i class="fa fa-eye"></i> <?= $this->Dictionary->GetKeyword('Show Full Details'); ?>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                <?php endif; ?>


                <div class="book-details-compact">
                    <div class="book-detail-row .col-xs-12 .col-sm-6 .col-md-8">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Import Code'); ?></div>
                        <div class="book-detail-value"><?= $import['import_code']; ?></div>
                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Book Number'); ?></div>
                        <div class="book-detail-value"><?= $import['import_book_number']; ?></div>
                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Book Date'); ?></div>
                        <div class="book-detail-value">
                            <?= $import['import_book_date'] ? date('Y-m-d', strtotime($import['import_book_date'])) : '-'; ?>
                        </div>
                    </div>

                    <div class="book-detail-row .col-xs-12 .col-sm-6 .col-md-8">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Book Subject'); ?></div>
                        <div class="book-detail-value"><?= $import['import_book_subject']; ?></div>
                    </div>

                    <div class="book-detail-row .col-xs-12 .col-sm-6 .col-md-8">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Received Date'); ?></div>
                        <div class="book-detail-value"><?= $import['import_received_date']; ?></div>
                    </div>

                    <div class="book-detail-row .col-xs-12 .col-sm-6 .col-md-8">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Created Date'); ?></div>
                        <div class="book-detail-value"><?= $import['import_created_at']; ?></div>
                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('From Department'); ?></div>
                        <div class="book-detail-value"><?= $import['import_from_department']; ?></div>
                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('To Department'); ?></div>
                        <div class="book-detail-value"><?= $import['import_to_department']; ?></div>
                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Created By'); ?></div>
                        <div class="book-detail-value"><?= $import['created_by_name']; ?></div>
                    </div>



                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Incoming Number'); ?></div>
                        <div class="book-detail-value"><?= $import['import_incoming_number']; ?></div>
                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Signed By'); ?></div>
                        <div class="book-detail-value"><?= $import['import_signed_by']; ?></div>
                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Is Direct'); ?></div>
                        <div class="book-detail-value">
                            <?= $import['import_is_direct'] == 1 ? '<span class="status-badge status-completed">' . $this->Dictionary->GetKeyword('Yes') .'</span>'  : '<span class="status-badge status-pending">' . $this->Dictionary->GetKeyword('No') .'</span>'; ?>
                        </div>

                    </div>

                    <div class="book-detail-row">
                        <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Is Answer'); ?></div>
                        <div class="book-detail-value">
                            <?= $import['import_is_answer'] == 1 ? '<span class="status-badge status-completed">' . $this->Dictionary->GetKeyword('Yes') .'</span>'  : '<span class="status-badge status-pending">' . $this->Dictionary->GetKeyword('No') .'</span>'; ?>

                        </div>
                    </div>

                    <?php if (isset($import['import_book_category'])): ?>
                        <div class="book-detail-row">
                            <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Book Category'); ?></div>
                            <div class="book-detail-value"><?= $import['import_book_category']; ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($import['import_book_language'])): ?>
                        <div class="book-detail-row">
                            <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Book Language'); ?></div>
                            <div class="book-detail-value"><?= $import['import_book_language']; ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($import['import_book_importance_level'])): ?>
                        <div class="book-detail-row">
                            <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Importance Level'); ?></div>
                            <div class="book-detail-value"><?= $this->Dictionary->GetKeyword($import['import_book_importance_level']); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($import['remote_branch_name'])): ?>
                        <div class="book-detail-row">
                            <div class="book-detail-label"><?= $this->Dictionary->GetKeyword('Remote Brach'); ?></div>
                            <div class="book-detail-value"><span class="status-badge" style="background-color: #dc21f3"><?= $import['remote_branch_name']; ?></span></div>
                        </div>
                    <?php endif; ?>

                </div>

                <?php if(!empty($last_trace)): ?>
                    <div class="panel panel-default book-details-panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Last Trace Brief'); ?></h3>
                            <div style="display: flex;justify-content: center;">

                                <?php if(isset($last_trace['action_type_name']) && !empty($last_trace['action_type_name'])): ?>
                                    <div class="trace-card-type" style="margin: 0 10px">
                                        <span> #</span>
                                        <span class="trace-type-badge"
                                              data-toggle="tooltip"
                                              data-title="<?= $this->Dictionary->GetKeyword('Action'); ?>"
                                              data-placement="bottom"
                                        ><?= isset($last_trace['action_type_name'])  ?  $this->Dictionary->GetKeyword($last_trace['action_type_name'] ) : ''  ?>
                        </span>
                                    </div>
                                <?php endif; ?>


                                <div class="trace-card-type" style="margin: 0 10px">
                                    <span> <i class="<?= $last_trace['import_trace_type_icon']; ?> trace_type_icon"></i></span>
                                    <span class="trace-type-badge"
                                          data-toggle="tooltip"
                                          data-title="<?= $this->Dictionary->GetKeyword('type'); ?>"
                                          data-placement="bottom"
                                    ><?=  $this->Dictionary->GetKeyword($last_trace['import_trace_type_name'] ); ?>
                        </span>
                                </div>

                                <div class="trace-card-status"
                                     data-toggle="tooltip"
                                     data-title="<?= $this->Dictionary->GetKeyword('status'); ?>"
                                     data-placement="bottom"
                                >
                                    <i class="<?= $last_trace['import_trace_status_icon']; ?> trace_status_icon"></i>
                                    <span class="status-badge status-pending" style="background-color: #ee4ef0">
                            <?php  echo $this->Dictionary->GetKeyword($last_trace['import_trace_status_name'] ?? '');
                            if($last_trace['import_trace_status_id'] == 3) {
                                ?>
                                <span><i class="fa fa-calendar"></i> <?=  ( isset($last_trace['import_trace_close_date']) && !empty($last_trace['import_trace_close_date'])) ? date('Y-m-d', strtotime($last_trace['import_trace_close_date'])) : ''; ?></span>
                            <?php } ?>

                        </span>
                                </div>

                            </div>
                        </div>

                    </div>
                <?php endif; ?>


                <?php if (!empty($import['import_note'])): ?>
                    <div class="panel panel-info mt-3">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Notes'); ?></h3>
                        </div>
                        <div class="panel-body">
                            <?= nl2br($import['import_note']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($import['import_attachment'])): ?>
                    <div class="panel panel-info mt-3 attachment-panel" style="margin-top: 6px">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-paperclip"></i> <?= $this->Dictionary->GetKeyword('Attachments'); ?> (<?= count($import['import_attachment']); ?>)</h3>
                        </div>
                        <div class="panel-body">
                            <div class="attachment-grid">
                                <?php foreach ($import['import_attachment'] as $attachment): ?>
                                    <?php
                                    $fileExtension = pathinfo($attachment['original_name'], PATHINFO_EXTENSION);
                                    $fileIcon = 'fa-file-o';

                                    // Determine file icon based on extension
                                    if (in_array(strtolower($fileExtension), ['pdf'])) {
                                        $fileIcon = 'fa-file-pdf-o';
                                    } elseif (in_array(strtolower($fileExtension), ['doc', 'docx', 'rtf', 'txt'])) {
                                        $fileIcon = 'fa-file-text-o';
                                    } elseif (in_array(strtolower($fileExtension), ['xls', 'xlsx', 'csv'])) {
                                        $fileIcon = 'fa-file-excel-o';
                                    } elseif (in_array(strtolower($fileExtension), ['ppt', 'pptx'])) {
                                        $fileIcon = 'fa-file-powerpoint-o';
                                    } elseif (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'])) {
                                        $fileIcon = 'fa-file-image-o';
                                    } elseif (in_array(strtolower($fileExtension), ['zip', 'rar', '7z', 'tar', 'gz'])) {
                                        $fileIcon = 'fa-file-archive-o';
                                    }
                                    ?>
                                    <div class="attachment-item">
                                        <div class="attachment-icon">
                                            <i class="fa <?= $fileIcon; ?>"></i>
                                            <span class="attachment-ext"><?= strtoupper($fileExtension); ?></span>
                                        </div>
                                        <div class="attachment-details">
                                            <div class="attachment-name" title="<?= $attachment['original_name']; ?>"><?= $attachment['original_name']; ?></div>
                                            <div class="attachment-actions">
                                                <a href="<?= base_url($attachment['file_path']); ?>" class="attachment-action-btn view-btn" target="_blank" title="<?= $this->Dictionary->GetKeyword('View'); ?>">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url($attachment['file_path']); ?>" class="attachment-action-btn download-btn" download title="<?= $this->Dictionary->GetKeyword('Download'); ?>">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


            </div>
            <!-- /.card-body -->
        </div>

        <?php endif; ?>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    $(document).ready(function() {

        $('.delete-answer').on('click', function() {
            const answerId = $(this).data('answer-id');

            if (confirm('<?= $this->Dictionary->GetKeyword("Are you sure you want to delete this answer record?"); ?>')) {
                // Delete trace via AJAX
                $.ajax({
                    url: '<?= base_url("Out/AjaxDeleteAnswer"); ?>',
                    type: 'POST',
                    data: { answer_id: answerId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('<?= $this->Dictionary->GetKeyword("Error deleting answer record."); ?>');
                    }
                });
            }
        });

    });
</script>


