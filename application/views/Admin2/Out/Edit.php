<?php if (isset($page_title)): ?>
    <div class="page-title">
        <h3><?= $this->Dictionary->GetKeyword($page_title); ?></h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="<?= base_url(); ?>"><?= $this->Dictionary->GetKeyword('Home'); ?></a></li>
                <li><a href="<?= base_url('Out/List'); ?>"><?= $this->Dictionary->GetKeyword('Out'); ?></a></li>
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
                <h3 class="panel-title" dir=''><?= $this->Dictionary->GetKeyword($page_title) ?></h3>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <?php echo form_open_multipart('Out/Edit/' . $out['id'], ['class' => 'form-horizontal', 'id' => 'out-form']); ?>

                <div class="row">
                    <div class="col-md-6">
                        <!--                        <div class="form-group">-->
                        <!--                            <label class="control-label col-md-4">--><?php //= $this->Dictionary->GetKeyword('Out Code'); ?><!-- *</label>-->
                        <!--                            <div class="col-md-8">-->
                        <!--                                <input type="text" name="out_book_code" class="form-control" value="--><?php //= $out['out_book_code']; ?><!--" required>-->
                        <!--                            </div>-->
                        <!--                        </div>-->

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Book Number'); ?></label>
                            <div class="col-md-8">
                                <input type="text" name="out_book_number" class="form-control" value="<?= $out['out_book_number']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Book Issue Date'); ?></label>
                            <div class="col-md-8">
                                <input type="date" name="out_book_issue_date" class="form-control" value="<?= $out['out_book_issue_date'] ? date('Y-m-d', strtotime($out['out_book_issue_date'])) : ''; ?>">
                            </div>
                        </div>

<!--                        <div class="form-group">-->
<!--                            <label class="control-label col-md-4">--><?php //= $this->Dictionary->GetKeyword('Book Entry Date'); ?><!--</label>-->
<!--                            <div class="col-md-8">-->
<!--                                <input type="date" name="out_book_entry_date" class="form-control" value="--><?php //= $out['out_book_entry_date'] ? date('Y-m-d', strtotime($out['out_book_entry_date'])) : ''; ?><!--">-->
<!--                            </div>-->
<!--                        </div>-->



                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Signed By'); ?></label>
                            <div class="col-md-8">
                                <input type="text" name="out_signed_by" class="form-control" value="<?= $out['out_signed_by']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Is Answer'); ?></label>
                            <div class="col-md-8">
                                <input type="checkbox" name="out_is_answer" id="out_is_answer" value="1" <?= $out['out_is_answer'] ? 'checked' : ''; ?>>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Book Subject'); ?> *</label>
                            <div class="col-md-8">
                                <input type="text" name="out_book_subject" class="form-control" value="<?= $out['out_book_subject']; ?>" required>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('To Department'); ?> *</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" id="out_to_department" class="form-control" value="<?= $out['out_to_department']; ?>" readonly required>
                                    <input type="hidden" id="out_to_department_id" name="out_to_department_id" value="<?= $out['out_to_department_id']; ?>" required>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="OpenTree('department','out_to_department','out_to_department_id','1')">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('From Department'); ?> *</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" id="out_from_department" class="form-control" value="<?= $out['out_from_department']; ?>" readonly required>
                                    <input type="hidden" id="out_from_department_id" name="out_from_department_id" value="<?= $out['out_from_department_id']; ?>" required>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="OpenTree('department','out_from_department','out_from_department_id','1', 'extra-section', 1)">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Book Category'); ?></label>
                            <div class="col-md-8">
                                <select name="out_book_category_id" class="form-control">
                                    <option value=""><?= $this->Dictionary->GetKeyword('Select'); ?></option>
                                    <?php
                                    $categories = $this->db->get('book_category')->result();
                                    foreach($categories as $category):
                                        ?>
                                        <option value="<?= $category->book_category_id ?>" <?= ($out['out_book_category_id'] == $category->book_category_id) ? 'selected' : ''; ?>><?= $category->book_category_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Book Language'); ?></label>
                            <div class="col-md-8">
                                <select name="out_book_language_id" class="form-control">
                                    <option value=""><?= $this->Dictionary->GetKeyword('Select'); ?></option>
                                    <?php
                                    $languages = $this->db->get('book_language')->result();
                                    foreach($languages as $language):
                                        ?>
                                        <option value="<?= $language->book_language_id ?>" <?= ($out['out_book_language_id'] == $language->book_language_id) ? 'selected' : ''; ?>><?= $language->book_language_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Electronic Copy'); ?></label>
                            <div class="col-md-8">
                                <select name="elec_dep_reference" class="form-control">
                                    <option value="-1"
                                        <?= $out['elec_dep_reference'] == -1 ? 'selected' : '' ?>
                                    ><?= $this->Dictionary->GetKeyword('Select'); ?></option>
                                    <?php  foreach($branches as $branch):?>
                                        <option value="<?= $branch['id'] ?>"
                                            <?= $out['elec_dep_reference'] == $branch['id'] ? 'selected' : '' ?>
                                        ><?= $branch['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Add Attachments'); ?></label>
                            <div class="col-md-8">
                                <input type="file" name="attachments[]" class="form-control" multiple>
                                <small class="text-muted"><?= $this->Dictionary->GetKeyword('Allowed file types: pdf, doc, docx, xls, xlsx, jpg, png, gif'); ?></small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">





                        <div class="form-group">
                            <label class="control-label col-md-2"><?= $this->Dictionary->GetKeyword('Notes'); ?></label>
                            <div class="col-md-10">
                                <textarea name="out_note" class="form-control" rows="5"><?= $out['out_note']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2"><?= $this->Dictionary->GetKeyword('Body'); ?></label>
                            <div class="col-md-10">
                                <textarea name="out_book_body" class="form-control" rows="5"><?= $out['out_book_body']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($out['out_attachment'])): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Current Attachments'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th><?= $this->Dictionary->GetKeyword('File Name'); ?></th>
                                            <th width="20%"><?= $this->Dictionary->GetKeyword('Actions'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($out['out_attachment'] as $index => $attachment): ?>
                                            <tr>
                                                <td><?= $index + 1; ?></td>
                                                <td><?= $attachment['original_name']; ?></td>
                                                <td>
                                                    <a href="<?= base_url($attachment['file_path']); ?>" class="btn btn-sm btn-info" target="_blank">
                                                        <i class="fa fa-download"></i> <?= $this->Dictionary->GetKeyword('Download'); ?>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteAttachment(<?= $out['id']; ?>, <?= $index; ?>)">
                                                        <i class="fa fa-trash"></i> <?= $this->Dictionary->GetKeyword('Delete'); ?>
                                                    </button>
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

                <div class="row">
                    <div class="col-md-12 text-center">
                        <div >
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> <?= $this->Dictionary->GetKeyword('Save'); ?>
                            </button>
                            <a href="<?= base_url('Out/Details/' . $out['id']); ?>" class="btn btn-default">
                                <i class="fa fa-times"></i> <?= $this->Dictionary->GetKeyword('Cancel'); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>

                <!-- Import Answers Section -->
                <div class="row answers_section" style="margin: 2rem 0px; display:none">
                    <div class="col-md-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Answers'); ?></h3>

                                <div class="pull-right">
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addAnswerModal">
                                        <i class="fa fa-plus"></i> <?= $this->Dictionary->GetKeyword('Add Answer'); ?>
                                    </button>

                                </div>

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
                                                        <?php if ($this->Permission->CheckPermission('out_edit')): ?>
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
            </div>
            <!-- /.card-body -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- Add Answer Modal -->
<div class="modal fade" id="addAnswerModal" tabindex="-1" role="dialog" aria-labelledby="addAnswerModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="addAnswerForm" action="<?= base_url('Out/AjaxAddAnswer'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addAnswerModalLabel"><?= $this->Dictionary->GetKeyword('Add New Answer'); ?></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="out_id" value="<?= $out['id']; ?>">

                    <div class="row answer-row">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Import Book Number'); ?>*</label>
                                <div class="col-md-8">
                                    <input type="text" name="answer_import_book_number" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Import Book Date'); ?>*</label>
                                <div class="col-md-8">
                                    <input type="date" name="answer_import_book_date" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('From Department'); ?> *</label>

                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control department-text" id="answer_import_from_department" name="answer_import_from_department"  readonly required>
                                        <input type="hidden" class="form-control department-id" id="answer_import_from_department_id" name="answer_import_from_department_id" required>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" onclick="OpenTree('department','answer_import_from_department','answer_import_from_department_id','1')">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>

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
    $(document).ready(function(){

        if ($('#out_is_answer').is(':checked')) {
            $('.answers_section').show();
        } else {
            $('.answers_section').hide();
        }
        $('#out_is_answer').on('change', function () {
            if ($(this).is(':checked')) {
                $('.answers_section').show();
            } else {
                $('.answers_section').hide();
            }
        });

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


    function deleteAttachment(outId, fileIndex) {
        if (confirm('<?= $this->Dictionary->GetKeyword('Are you sure you want to delete this attachment?'); ?>')) {
            $.ajax({
                url: '<?= base_url('Out/AjaxDeleteAttachment'); ?>',
                type: 'POST',
                data: {
                    out_id: outId,
                    file_index: fileIndex
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('<?= $this->Dictionary->GetKeyword('An error occurred while processing your request.'); ?>');
                }
            });
        }
    }
</script> 