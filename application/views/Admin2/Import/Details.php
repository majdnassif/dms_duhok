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
                <li><a href="<?= base_url('Import/List'); ?>"><?= $this->Dictionary->GetKeyword('Import Documents'); ?></a></li>
                <li class="active"><?= $this->Dictionary->GetKeyword($page_title); ?></li>
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
                    <?= $import['import_code']; ?>
                </h3>
                <div class="pull-right">

                    <?php if($this->Permission->CheckPermissionOperation('import_edit')): ?>
                        <a href="<?= base_url('Import/Edit/' . $import['import_id']); ?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-edit"></i> <?= $this->Dictionary->GetKeyword('Edit'); ?>
                        </a>
                    <?php endif; ?>


                    <a href="<?= base_url('Import/List'); ?>" class="btn btn-sm btn-default">
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




                <!--                <div class="row">-->
                <!--                    <div class="col-md-6">-->
                <!--                        <table class="table table-bordered table-striped">-->
                <!--                            <tr>-->
                <!--                                <th width="40%">--><?php //= $this->Dictionary->GetKeyword('Import Code'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['import_code']; ?><!--</td>-->
                <!--                            </tr>-->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Book Number'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['import_book_number']; ?><!--</td>-->
                <!--                            </tr>-->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Book Date'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['import_book_date'] ? date('Y-m-d', strtotime($import['import_book_date'])) : ''; ?><!--</td>-->
                <!--                            </tr>-->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Book Subject'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['import_book_subject']; ?><!--</td>-->
                <!--                            </tr>-->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('To Department'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['import_to_department']; ?><!--</td>-->
                <!--                            </tr>-->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('From Department'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['import_from_department']; ?><!--</td>-->
                <!--                            </tr>-->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Received Date'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['import_received_date'] ? date('Y-m-d', strtotime($import['import_received_date'])) : ''; ?><!--</td>-->
                <!--                            </tr>-->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Created Date'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['import_created_at'] ? date('Y-m-d', strtotime($import['import_created_at'])) : ''; ?><!--</td>-->
                <!--                            </tr>-->
                <!---->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Contact Name'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['contact_name'] ?><!--</td>-->
                <!--                            </tr>-->
                <!--                        </table>-->
                <!--                    </div>-->
                <!--                    -->
                <!--                    <div class="col-md-6">-->
                <!--                        <table class="table table-bordered table-striped">-->
                <!--                            <tr>-->
                <!--                                <th width="40%">--><?php //= $this->Dictionary->GetKeyword('Incoming Number'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['import_incoming_number']; ?><!--</td>-->
                <!--                            </tr>-->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Signed By'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['import_signed_by']; ?><!--</td>-->
                <!--                            </tr>-->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Book Category'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['import_book_category'] ?? ''; ?><!--</td>-->
                <!--                            </tr>-->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Book Language'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['import_book_language'] ?? ''; ?><!--</td>-->
                <!--                            </tr>-->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Importance Level'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['import_book_importance_level'] ?? ''; ?><!--</td>-->
                <!--                            </tr>-->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Is Direct'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['import_is_direct'] ? '<span class="label label-success">'.$this->Dictionary->GetKeyword('Yes').'</span>' : '<span class="label label-danger">'.$this->Dictionary->GetKeyword('No').'</span>'; ?><!--</td>-->
                <!--                            </tr>-->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Created By'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['created_by_name']; ?><!--</td>-->
                <!--                            </tr>-->
                <!---->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Is answer'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['import_is_answer'] ? '<span class="label label-success">'.$this->Dictionary->GetKeyword('Yes').'</span>' : '<span class="label label-danger">'.$this->Dictionary->GetKeyword('No').'</span>'; ?><!--</td>-->
                <!--                            </tr>-->
                <!---->
                <!--                            <tr>-->
                <!--                                <th>--><?php //= $this->Dictionary->GetKeyword('Contact Phone'); ?><!--</th>-->
                <!--                                <td>--><?php //= $import['contact_phone'] ?><!--</td>-->
                <!--                            </tr>-->
                <!--                        </table>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                -->
                <!--                <div class="row">-->
                <!--                    --><?php //if (!empty($import['import_note'])): ?>
                <!--                    <div class="col-md-12">-->
                <!--                        <div class="panel panel-info">-->
                <!--                            <div class="panel-heading">-->
                <!--                                <h3 class="panel-title">--><?php //= $this->Dictionary->GetKeyword('Notes'); ?><!--</h3>-->
                <!--                            </div>-->
                <!--                            <div class="panel-body">-->
                <!--                                --><?php //= nl2br($import['import_note'] ?? ''); ?>
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    --><?php //endif; ?>
                <!--                    --><?php //if (!empty($import['import_attachment'])): ?>
                <!--                        <div class="col-md-12">-->
                <!--                            <div class="panel panel-success">-->
                <!--                                <div class="panel-heading">-->
                <!--                                    <h3 class="panel-title">--><?php //= $this->Dictionary->GetKeyword('Attachments'); ?><!--</h3>-->
                <!--                                </div>-->
                <!--                                <div class="panel-body">-->
                <!--                                    <table class="table table-bordered table-striped">-->
                <!--                                        <thead>-->
                <!--                                            <tr>-->
                <!--                                                <th width="5%">#</th>-->
                <!--                                                <th>--><?php //= $this->Dictionary->GetKeyword('File Name'); ?><!--</th>-->
                <!--                                                <th width="15%">--><?php //= $this->Dictionary->GetKeyword('Actions'); ?><!--</th>-->
                <!--                                            </tr>-->
                <!--                                        </thead>-->
                <!--                                        <tbody>-->
                <!--                                            --><?php //foreach ($import['import_attachment'] as $index => $attachment): ?>
                <!--                                            <tr>-->
                <!--                                                <td>--><?php //= $index + 1; ?><!--</td>-->
                <!--                                                <td>--><?php //= $attachment['original_name']; ?><!--</td>-->
                <!--                                                <td>-->
                <!--                                                    <a href="--><?php //= base_url($attachment['file_path']); ?><!--" class="btn btn-sm btn-info" target="_blank">-->
                <!--                                                        <i class="fa fa-eye"></i>-->
                <!--                                                    </a>-->
                <!--                                                </td>-->
                <!--                                            </tr>-->
                <!--                                            --><?php //endforeach; ?>
                <!--                                        </tbody>-->
                <!--                                    </table>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    --><?php //endif; ?>
                <!--                </div>-->


                <!-- Import Answers Section -->
                <?php if ( !empty($import['import_is_answer']) && $import['import_is_answer'] == 1): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Answers'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <?php if (isset($import_answers) && !empty($import_answers)): ?>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th><?= $this->Dictionary->GetKeyword('Out Document Exists'); ?></th>
                                                <th><?= $this->Dictionary->GetKeyword('Out Book Number'); ?></th>
                                                <th><?= $this->Dictionary->GetKeyword('Out Book Date'); ?></th>
                                                <th><?= $this->Dictionary->GetKeyword('Out Department'); ?></th>
                                                <th><?= $this->Dictionary->GetKeyword('Created By'); ?></th>
                                                <th ><?= $this->Dictionary->GetKeyword('Actions'); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($import_answers as $index => $answer): ?>
                                                <tr>
                                                    <td><?= $index + 1; ?></td>
                                                    <td>
                                                        <?php if ($answer['out_id'] == 1): ?>
                                                            <span class="label label-success"><?= $this->Dictionary->GetKeyword('Yes'); ?></span>
                                                        <?php else: ?>
                                                            <span class="label label-danger"><?= $this->Dictionary->GetKeyword('No'); ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $answer['out_book_number']; ?></td>
                                                    <td><?= $answer['out_book_issue_date']; ?></td>
                                                    <td><?= $answer['out_from_department']; ?></td>
                                                    <td><?= $answer['created_by_name'] ?? ''; ?></td>

                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <?php if ($this->Permission->CheckPermission('import_edit')): ?>
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
                    </div>

                <?php endif; ?>

                <!-- Special form Section -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Special Form'); ?></h3>
                                <div class="pull-right">

                                    <?php if($this->Permission->CheckPermissionOperation('add_special_form')): ?>

                                        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addSpecialFormModal">
                                            <i class="fa fa-plus"></i> <?= $this->Dictionary->GetKeyword('Add Special Form'); ?>
                                        </button>

                                    <?php endif; ?>

                                </div>
                            </div>
                            <div class="panel-body">
                                <?php if (isset($import_traces) && !empty($import_traces)): ?>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th><?= $this->Dictionary->GetKeyword('User'); ?></th>
                                            <th><?= $this->Dictionary->GetKeyword('Note'); ?></th>
                                            <th><?= $this->Dictionary->GetKeyword('Page Number'); ?></th>
                                            <?php if($this->Permission->CheckPermissionOperation('print_special_form')): ?>
                                                <th><?= $this->Dictionary->GetKeyword('Actions'); ?></th>
                                            <?php endif; ?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($import_special_forms as $index => $import_special_form): ?>
                                            <tr>
                                                <td><?= $index + 1; ?></td>
                                                <td><?= $import_special_form['created_by_name']; ?></td>
                                                <td><?= $import_special_form['note']; ?></td>
                                                <td><?= $import_special_form['page_number']; ?></td>
                                                <?php if($this->Permission->CheckPermissionOperation('print_special_form')): ?>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">

                                                            <a href="<?= base_url('Import/SpecialForm/' . $import_special_form['id']); ?>" target="_blank" class="btn btn-sm btn-info">
                                                                <i class="fa fa-print"></i> <?= $this->Dictionary->GetKeyword('Print'); ?>
                                                            </a>
                                                        </div>
                                                    </td>
                                                <?php endif; ?>
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
                </div>


                <!-- Import Trace Section -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Trace History'); ?></h3>

                                <div class="pull-right">

                                    <?php if(
                                        $this->Permission->CheckPermissionOperation('import_addtrace')
                                        && $this->Permission->CheckPermissionOperation('send_trace_from_details')
                                        && $last_trace['import_trace_type_id']  != 4 // do not show actions for out trace
                                    ): ?>


                                            <button type="button" class="btn btn-sm btn-success btn-self-trace-sent"  data-toggle="modal" data-target="#addTraceModalSent" data-type="1" data-status="1">
                                                <i class="fa fa-mail-forward"></i> <?= $this->Dictionary->GetKeyword('Sent To Action'); ?>
                                            </button>

                                    <?php endif; ?>
                                </div>

                            </div>

                            <div class="panel-body">
                                <?php if (isset($import_traces) && !empty($import_traces)): ?>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th><?= $this->Dictionary->GetKeyword('Type'); ?></th>
                                            <th><?= $this->Dictionary->GetKeyword('From Dept'); ?></th>
                                            <th><?= $this->Dictionary->GetKeyword('To Dept'); ?></th>
                                            <th><?= $this->Dictionary->GetKeyword('Sender User'); ?></th>
                                            <th><?= $this->Dictionary->GetKeyword('Receiver User'); ?></th>
                                            <th><?= $this->Dictionary->GetKeyword('Sent Date'); ?></th>
                                            <th><?= $this->Dictionary->GetKeyword('Close Date'); ?></th>
                                            <th><?= $this->Dictionary->GetKeyword('Action'); ?></th>
                                            <!--                                            <th>--><?php //= $this->Dictionary->GetKeyword('Received Date'); ?><!--</th>-->
                                            <!--                                            <th>--><?php //= $this->Dictionary->GetKeyword('Status'); ?><!--</th>-->
                                            <th><?= $this->Dictionary->GetKeyword('Actions'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($import_traces as $index => $trace): ?>
                                            <tr>
                                                <td><?= $index + 1; ?></td>
                                                <td><?= $this->Dictionary->GetKeyword($trace['import_trace_type_name']); ?></td>
                                                <td><?= $trace['sender_department']; ?></td>
                                                <td><?= $trace['receiver_department']; ?></td>
                                                <td><?= $trace['sender_user']; ?></td>
                                                <td><?= $trace['receiver_user'] ?? ''; ?></td>
                                                <td><?= $trace['import_trace_sent_date'] ?  $trace['import_trace_sent_date']  : ''; ?></td>
                                                <!--                                            <td>--><?php //= $trace['import_trace_received_date'] ? date('Y-m-d', strtotime($trace['import_trace_received_date'])) : ''; ?><!--</td>-->
                                                <td><?= $trace['import_trace_close_date'] ? '<span class="label label-danger"> ' .  $trace['import_trace_close_date'] . '</span>' : ''; ?></td>
                                                <td><?= $this->Dictionary->GetKeyword($trace['action_type_name']) ?? ''; ?></td>


                                                <!--                                            <td>-->
                                                <!--                                                --><?php //if ($trace['import_trace_status_id'] == 1): ?>
                                                <!--                                                    <span class="label label-warning">--><?php //= $trace['import_trace_status_name']; ?><!--</span>-->
                                                <!--                                                --><?php //elseif ($trace['import_trace_status_id'] == 3): ?>
                                                <!--                                                    <span class="label label-success">--><?php //= $trace['import_trace_status_name']; ?><!--</span>-->
                                                <!--                                                --><?php //elseif ($trace['import_trace_status_id'] == 4): ?>
                                                <!--                                                    <span class="label label-danger">--><?php //= $trace['import_trace_status_name']; ?><!--</span>-->
                                                <!--                                                --><?php //else: ?>
                                                <!--                                                    <span class="label label-default">--><?php //= $trace['import_trace_status_name']; ?><!--</span>-->
                                                <!--                                                --><?php //endif; ?>
                                                <!--                                            </td>-->
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-info view-trace" data-trace-id="<?= $trace['import_trace_id']; ?>">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        <?php if ($this->Permission->CheckPermissionOperation('import_tracedelete')): ?>
                                                            <button type="button" class="btn btn-danger delete-trace" data-trace-id="<?= $trace['import_trace_id']; ?>">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
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
                </div>

            </div>
            <!-- /.card-body -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<!-- Add Special Form Modal -->
<div class="modal fade" id="addSpecialFormModal" tabindex="-1" role="dialog" aria-labelledby="addSpecialFormModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="addSpecialFormForm" action="<?= base_url('Import/AjaxAddSpecialForm'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title" id="addSpecialFormModalLabel"><?= $this->Dictionary->GetKeyword('Add Special Form'); ?></h4>

                </div>
                <div class="modal-body">
                    <input type="hidden" name="import_id" value="<?= $import['import_id']; ?>">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="special_form_note"><?= $this->Dictionary->GetKeyword('Note'); ?></label>
                                <textarea name="special_form_note" id="special_form_note" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="special_form_page_number"><?= $this->Dictionary->GetKeyword('Pages Count'); ?></label>
                                <input type="number" name="special_form_page_number" id="special_form_page_number" min="1" value="1" class="form-control">
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->Dictionary->GetKeyword('Close'); ?></button>
                    <button type="submit" class="btn btn-primary"><?= $this->Dictionary->GetKeyword('Save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- View Trace Modal -->
<div class="modal fade" id="viewTraceModal" tabindex="-1" role="dialog" aria-labelledby="viewTraceModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="viewTraceModalLabel"><?= $this->Dictionary->GetKeyword('Trace Details'); ?></h4>
            </div>
            <div class="modal-body" id="viewTraceContent">
                <!-- Content will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->Dictionary->GetKeyword('Close'); ?></button>
            </div>
        </div>
    </div>
</div>


<!-- Add Trace Modal For Sent-->
<div class="modal fade" id="addTraceModalSent" tabindex="-1" role="dialog" aria-labelledby="addTraceModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="addTraceFormSent" action="<?= base_url('Import/AddTrace'); ?>" method="post" enctype="multipart/form-data" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addTraceModalLabel"><?= $this->Dictionary->GetKeyword('Add New Trace'); ?></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="import_id" value="<?= $import['import_id']; ?>">
                    <input type="hidden" name="import_trace_type_id" value="">
                    <input type="hidden" name="import_trace_status_id" value="">


                    <div class="just_for_sent_status">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="trace_status"><?= $this->Dictionary->GetKeyword('Action Type'); ?> *</label>
                                    <select name="import_trace_action_type_id" id="trace_action_type" class="form-control" required>
                                        <option value=""><?= $this->Dictionary->GetKeyword('Select Action Type'); ?></option>
                                        <?php if (isset($trace_action_types)): ?>
                                            <?php foreach ($trace_action_types as $action_type): ?>
                                                <option value="<?= $action_type['id']; ?>"><?= $action_type['name']; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>


                        </div>

                        <div class="row">



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="receiver_user"><?= $this->Dictionary->GetKeyword('Receiver User'); ?></label>
                                    <select name="import_trace_receiver_user_id" id="receiver_user_id" class="form-control select2-users" required>
                                        <option value=""><?= $this->Dictionary->GetKeyword('Select User'); ?></option>
                                        <!--                                        --><?php //if (isset($active_users)): ?>
                                        <!--                                            --><?php //foreach ($active_users as $user): ?>
                                        <!--                                                <option value="--><?php //= $user['id']; ?><!--">--><?php //= $user['name']; ?><!--</option>-->
                                        <!--                                            --><?php //endforeach; ?>
                                        <!--                                        --><?php //endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="receiver_department"><?= $this->Dictionary->GetKeyword('Receiver Department'); ?> *</label>
                                    <div class="input-group">
                                        <input type="text" name="receiver_department" id="receiver_department" class="form-control"  readonly required>
                                        <input type="hidden" name="import_trace_receiver_department_id" id="receiver_department_id">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" onclick="OpenTree('department','receiver_department','receiver_department_id','1', 'extra-section', 1)"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="trace_note"><?= $this->Dictionary->GetKeyword('Note'); ?></label>
                                <textarea name="import_trace_note" id="trace_note" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="attachments"><?= $this->Dictionary->GetKeyword('Attachments'); ?></label>
                                <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
                                <small class="text-muted"><?= $this->Dictionary->GetKeyword('You can select multiple files.'); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->Dictionary->GetKeyword('Close'); ?></button>
                    <button type="submit" class="btn btn-primary"><?= $this->Dictionary->GetKeyword('Save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $('.btn-self-trace-sent').on('click', function() {

            var dataType = $(this).data('type');
            $('input[name="import_trace_type_id"]').val(dataType);

        });

        $('#addTraceFormSent').on('submit', function(e) {
            e.preventDefault();

            $('.overlay').css('display', 'flex'); // Show the overlay

            var formData = new FormData(this);

            console.log('formData', formData);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // $('#addTraceModal').modal('hide');
                    // $('.overlay').hide(); // Hide the overlay after success
                    // location.reload();

                    $('.form-error').remove();
                    $('.is-invalid').removeClass('is-invalid');

                    if(response.status !== "true") {
                        if (response.errors) {
                            for (const [field, message] of Object.entries(response.errors)) {
                                const input = $(`[name="${field}"]`);

                                input.addClass('is-invalid'); // Optional, if you're using Bootstrap

                                // Add error message right below the input
                                input.after(`<div class="form-error text-danger small">${message}</div>`);
                            }
                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'An error occurred while adding the trace.',
                                confirmButtonText: 'OK'
                            });
                        }

                        $('.overlay').hide(); // Hide overlay after error
                        return;
                    }else{
                        $('.overlay').hide(); // Hide the overlay after success
                        $('#addTraceModal').modal('hide');
                        location.reload();
                    }



                },
                // error: function(xhr, status, error) {
                //     $('.overlay').hide(); // Hide the overlay after success
                //     alert('An error occurred: ' + error);
                // }

                error: function(xhr, status, error) {
                    // Handle error (e.g., show an error message)
                    try {
                        const response = JSON.parse(xhr.responseText); // Parse the server response

                        if (response.errors) {
                            // Handle validation errors
                            let errorMessages = '';
                            for (const [field, message] of Object.entries(response.errors)) {
                                errorMessages += `${field}: ${message}\n`;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Errors',
                                text: errorMessages,
                                confirmButtonText: 'OK'
                            });
                        } else {
                            // Handle general error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'An error occurred while adding the trace.',
                                confirmButtonText: 'OK'
                            });
                        }
                    } catch (e) {
                        console.log('Error parsing JSON response:', e);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Invalid server response.',
                            confirmButtonText: 'OK'
                        });
                    }
                    $('.overlay').hide(); // Hide the overlay after success

                }


            });
        });


        $('#receiver_department_id').on('change', function() {
            const departmentId = $(this).val();
            if (departmentId) {
                loadUsersByDepartmentReceiver(departmentId);
            }
        });

        function loadUsersByDepartmentReceiver(departmentId) {
            $.ajax({
                url: '<?= base_url('User/AjaxGetUsersByDepartment') ?>',
                type: 'POST',
                data: { department_id: departmentId },
                dataType: 'json',
                success: function(response) {
                    console.log('sucesss response', response);
                    const $select = $('select[name="import_trace_receiver_user_id"]');
                    $select.empty();
                    $select.append('<option value=""><?= $this->Dictionary->GetKeyword('Select User'); ?></option>');

                    $.each(response, function(index, user) {
                        $select.append(`<option value="${user.id}">${user.name}</option>`);
                    });

                    $select.prop('disabled', false); // 🔓 enable the select
                },
                error: function() {
                    console.log('Error loading users');
                    alert('Error loading users');
                }
            });
        }



        $('#sender_department_id').on('change', function() {
            const departmentId = $(this).val();
            if (departmentId) {
                loadUsersByDepartment(departmentId);
            }
        });

        function loadUsersByDepartment(departmentId) {
            $.ajax({
                url: '<?= base_url('User/AjaxGetUsersByDepartment') ?>',
                type: 'POST',
                data: { department_id: departmentId },
                dataType: 'json',
                success: function(response) {
                    console.log('sucesss response', response);
                    const $select = $('select[name="import_trace_sender_user_id"]');
                    $select.empty();
                    $select.append('<option value=""><?= $this->Dictionary->GetKeyword('Select User'); ?></option>');

                    $.each(response, function(index, user) {
                        $select.append(`<option value="${user.id}">${user.name}</option>`);
                    });

                    $select.prop('disabled', false); // 🔓 enable the select
                },
                error: function() {
                    console.log('Error loading users');
                    alert('Error loading users');
                }
            });
        }





        $('#addTraceForm').on('submit', function(e) {
            e.preventDefault();
            $('.overlay').css('display', 'flex'); // Show the overlay
            var formData = new FormData(this);
            $('#addTraceModal').modal('hide');
            console.log('formData', formData);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    $('.overlay').hide(); // Hide the overlay after success
                    location.reload();
                },
                error: function(xhr, status, error) {
                    $('.overlay').hide(); // Hide the overlay after success
                    alert('An error occurred: ' + error);
                }
            });
        });


        $('#addSpecialFormForm').on('submit', function(e) {
            e.preventDefault();

            $('.overlay').css('display', 'flex'); // Show the overlay
            var formDataForm = new FormData(this);
            $('#addSpecialFormModal').modal('hide');
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formDataForm,
                processData: false,
                contentType: false,
                success: function(response) {

                    $('.overlay').hide(); // Hide the overlay after success
                    location.reload();
                },
                error: function(xhr, status, error) {
                    $('.overlay').hide(); // Hide the overlay after success
                    alert('An error occurred: ' + error);
                }
            });
        });


        // View trace details
        $('.view-trace').on('click', function() {
            const traceId = $(this).data('trace-id');

            // Load trace details via AJAX
            $.ajax({
                url: '<?= base_url("Import/GetTraceDetails"); ?>/' + traceId,
                type: 'GET',
                dataType: 'html',
                success: function(response) {
                    $('#viewTraceContent').html(response);
                    $('#viewTraceModal').modal('show');
                },
                error: function() {
                    alert('<?= $this->Dictionary->GetKeyword("Error loading trace details."); ?>');
                }
            });
        });

        // Delete trace confirmation
        $('.delete-trace').on('click', function() {
            const traceId = $(this).data('trace-id');

            if (confirm('<?= $this->Dictionary->GetKeyword("Are you sure you want to delete this trace record?"); ?>')) {
                // Delete trace via AJAX
                $.ajax({
                    url: '<?= base_url("Import/DeleteTrace"); ?>',
                    type: 'POST',
                    data: { trace_id: traceId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('<?= $this->Dictionary->GetKeyword("Error deleting trace record."); ?>');
                    }
                });
            }
        });


        $('.delete-answer').on('click', function() {
            const answerId = $(this).data('answer-id');

            if (confirm('<?= $this->Dictionary->GetKeyword("Are you sure you want to delete this answer record?"); ?>')) {
                // Delete trace via AJAX
                $.ajax({
                    url: '<?= base_url("Import/AjaxDeleteAnswer"); ?>',
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