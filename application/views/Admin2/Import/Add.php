<?php if (isset($page_title)): ?>
    <div class="page-title">
        <h3><?= $this->Dictionary->GetKeyword($page_title); ?></h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="<?= base_url(); ?>"><?= $this->Dictionary->GetKeyword('Home'); ?></a></li>
                <li><a href="<?= base_url('Import/List'); ?>"><?= $this->Dictionary->GetKeyword('Import'); ?></a></li>
                <li class="active"><?= $this->Dictionary->GetKeyword($page_title); ?></li>
            </ol>
        </div>
    </div>
<?php endif; ?>

<style>
    .answer-row {
        margin-bottom: 4rem;
        display: flex;
        align-items: center;
    }

    fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow:  0px 0px 0px 0px #000;
        box-shadow:  0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        width:inherit; /* Or auto */
        padding:0 10px; /* To give a bit of padding on the left and right */
        border-bottom:none;
    }
</style>
<div class="container-fluid">
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title" dir=''><?= $this->Dictionary->GetKeyword($page_card_title) ?></h3>
                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
            </div>
            <div class="panel-body">

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                <?php endif; ?>


                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <?php echo form_open_multipart('Import/Add', ['class' => 'form-horizontal', 'id' => 'import-form']); ?>

                <div class="row">


                    <div class="col-md-6">

                        <input type="text" name="remote_out_id" id="remote_out_id"  hidden <?= (isset($remote_out) && $remote_out['id']) ? $remote_out['id'] : '' ?>>

                        <input type="text" name="remote_branch_id" id="remote_branch_id"  hidden <?= isset($remote_branch_id) ? $remote_branch_id : '' ?>>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Book Number'); ?></label>
                            <div class="col-md-8">

                                <input type="text" name="import_book_number"  id="import_book_number"
                                       value="<?= (isset($remote_out) && $remote_out['out_book_number']) ? $remote_out['out_book_number'] : '' ?>"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Book Date'); ?></label>
                            <div class="col-md-8">
                                <input type="date" name="import_book_date"   id="import_book_date"
                                       value="<?= (isset($remote_out) && $remote_out['out_book_issue_date']) ? date('Y-m-d', strtotime($remote_out['out_book_issue_date'])) : '' ?>"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Attachments'); ?>*</label>
                            <div class="col-md-8">
                                <input type="file" name="attachments[]" class="form-control" multiple required>
                                <small class="text-muted"><?= $this->Dictionary->GetKeyword('Allowed file types: pdf, doc, docx, xls, xlsx, jpg, png, gif'); ?></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('To Department'); ?> *</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" id="import_to_department" class="form-control"
                                           value="<?= (isset($remote_out) && $remote_out['out_to_department']) ? $remote_out['out_to_department'] : '' ?>"
                                           readonly required>
                                    <input type="hidden" id="import_to_department_id" name="import_to_department_id"
                                           value="<?= (isset($remote_out) && $remote_out['out_to_department_id']) ? $remote_out['out_to_department_id'] : '' ?>"
                                           required>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="OpenTree('department','import_to_department','import_to_department_id','1', 'extra-section', 1)">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>





                        <!--                        <div class="form-group">-->
                        <!--                            <label class="control-label col-md-4">--><?php //= $this->Dictionary->GetKeyword('Incoming Number'); ?><!--</label>-->
                        <!--                            <div class="col-md-8">-->
                        <!--                                <input type="text" name="import_incoming_number" class="form-control">-->
                        <!--                            </div>-->
                        <!--                        </div>-->

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Signed By'); ?></label>
                            <div class="col-md-8">
                                <input type="text" name="import_signed_by" id="import_signed_by"
                                       value="<?= (isset($remote_out) && $remote_out['out_signed_by']) ? $remote_out['out_signed_by'] : '' ?>"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group">
                                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Is Direct'); ?></label>
                                <div class="col-md-8">
                                    <input type="checkbox" name="import_is_direct" value="1" checked>
                                </div>

                            </div>


                            <div class="form-group">
                                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Is Answer'); ?></label>
                                <div class="col-md-8">
                                    <input type="checkbox" name="import_is_answer" id="import_is_answer">
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Incoming Number'); ?></label>
                            <div class="col-md-8">
                                <input type="text" name="import_incoming_number" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Received Date'); ?></label>
                            <div class="col-md-8">
                                <input type="date" name="import_received_date" class="form-control"
                                       value="<?php echo date('Y-m-d'); ?>"
                                >
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Book Subject'); ?> *</label>
                            <div class="col-md-8">
                                <input type="text" name="import_book_subject" id="import_book_subject" class="form-control"
                                       value="<?= (isset($remote_out) && $remote_out['out_book_subject']) ? $remote_out['out_book_subject'] : '' ?>"
                                       required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Book Body'); ?></label>
                            <div class="col-md-8">
                                <textarea name="import_body" id="import_body" class="form-control" rows="2"
                                ><?= (isset($remote_out) && $remote_out['out_book_body']) ? $remote_out['out_book_body'] : '' ?></textarea>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('From Department'); ?> *</label>
                            <div class="col-md-8">
                                <div class="input-group">

                                    <input type="text" id="import_from_department" class="form-control"
                                           value="<?= (isset($remote_out) && $remote_out['out_from_department']) ? $remote_out['out_from_department'] : '' ?>"
                                           readonly required>
                                    <input type="hidden" id="import_from_department_id" name="import_from_department_id"
                                           value="<?= (isset($remote_out) && $remote_out['out_from_department_id']) ? $remote_out['out_from_department_id'] : '' ?>"
                                           required>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="OpenTree('department','import_from_department','import_from_department_id','1')">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>





                        <?php if(!isset($remote_out) ): ?>

                            <div class="form-group">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-info btn-block" id="import-search-button">
                                        <i class="fa fa-search"></i> <?= $this->Dictionary->GetKeyword('Bring From Remote'); ?>
                                </div>
                                <div class="col-md-4"></div>
                            </div>

                        <?php endif; ?>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Book Category'); ?></label>
                            <div class="col-md-8">
                                <select name="import_book_category_id" class="form-control">
                                    <option value=""><?= $this->Dictionary->GetKeyword('Select'); ?></option>
                                    <?php
                                    $categories = $this->db->get('book_category')->result();
                                    foreach($categories as $category):
                                        ?>

                                        <!--                                        --><?php //= (isset($remote_out) && $remote_out['out_book_category_id'] == $category->book_category_id)  ? 'selected' : '' ?>
                                        <option value="<?= $category->book_category_id ?>">
                                            <?= $category->book_category_name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Book Language'); ?></label>
                            <div class="col-md-8">
                                <select name="import_book_language_id" id="import_book_language_id" class="form-control">
                                    <option value=""><?= $this->Dictionary->GetKeyword('Select'); ?></option>
                                    <?php
                                    $languages = $this->db->get('book_language')->result();
                                    foreach($languages as $language):
                                        ?>
                                        <option
                                                value="<?= $language->book_language_id ?>"
                                            <?= (isset($remote_out) && $remote_out['out_book_language_id'] == $language->book_language_id)  ? 'selected' : '' ?>
                                        >
                                            <?= $language->book_language_name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Importance Level'); ?></label>
                            <div class="col-md-8">
                                <select name="import_book_importance_level_id" class="form-control">
                                    <option value=""><?= $this->Dictionary->GetKeyword('Select'); ?></option>
                                    <?php
                                    $levels = $this->db->get('book_importance_level')->result();
                                    foreach($levels as $level):
                                        ?>
                                        <option value="<?= $level->book_importance_level_id ?>"
                                            <?= $level->book_importance_level_id == 2 ? 'selected' : '' ?> ><?= $level->book_importance_level_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-2"><?= $this->Dictionary->GetKeyword('Notes'); ?></label>
                            <div class="col-md-10">
                                <textarea name="import_note" id="import_note" class="form-control" rows="5"
                                ><?= (isset($remote_out) && $remote_out['out_note']) ? $remote_out['out_note'] : '' ?></textarea>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="row answers_section" style="margin: 2rem 0px; display:none">
                    <div class="col-md-12">

                        <div class="panel panel-success">

                            <div class="panel-heading">
                                <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Answers'); ?></h3>
                            </div>

                            <div class="panel-body" >

                                <div id="answers-container">
                                    <div class="row answer-row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Out Book Number'); ?>*</label>
                                                <div class="col-md-8">
                                                    <!--    required-->
                                                    <input type="text" name="answer_out_book_number[]" class="form-control" required disabled >
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Out Book Date'); ?>*</label>
                                                <div class="col-md-8">
                                                    <!--    required-->
                                                    <input type="date" name="answer_out_book_date[]" class="form-control" required disabled>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-md-5">

                                            <div class="form-group">
                                                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('From Department'); ?> *</label>
                                                <div class="col-md-8">
                                                    <div class="input-group">

                                                        <!--    required-->
                                                        <input type="text" class="form-control department-text" id="answer_out_to_department_1" name="answer_out_to_department[]" required disabled
                                                               value="<?=  $current_department->fullpath ?>"  readonly >
                                                        <!--    required-->
                                                        <input type="hidden" class="form-control department-id" id="answer_out_to_department_id_1" name="answer_out_to_department_id[]" required disabled
                                                               value="<?= $current_department->id  ?>"
                                                        >
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button" onclick="OpenTree('department','answer_out_to_department_1','answer_out_to_department_id_1','1', 'extra-section', 1)">
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Search For Out Book'); ?> </label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <!--    required-->
                                                        <input type="text" class="form-control department-text" id="answer_out_name"  readonly >
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button" onclick="checkOutExistence(this)">
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <a class="btn btn-sm btn-danger" onclick="DeleteAnswerRow(this)" role="button"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-add-answer">
                                                <i class="fa fa-plus"></i> <?= $this->Dictionary->GetKeyword('Add Answer'); ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>


                <div class="row" style="margin-top: 4rem;">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="control-label col-md-2"></label>
                            <div class="col-md-10">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border"><?= $this->Dictionary->GetKeyword('Contact'); ?></legend>

                                    <div class="col-md-4">
                                        <div class="form-group " >
                                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Name'); ?></label>
                                            <div class="col-md-8">
                                                <input type="text" name="contact_name" id="contact_name" class="form-control">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group " >
                                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Email'); ?></label>
                                            <div class="col-md-8">
                                                <input type="email" name="contact_email" id="contact_email" class="form-control">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group " >
                                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Phone'); ?></label>
                                            <div class="col-md-8">
                                                <input type="tel" name="contact_phone" id="contact_phone" class="form-control">
                                            </div>
                                        </div>
                                    </div>


                                </fieldset>
                            </div>
                        </div>

                    </div>
                </div>


                <?php if($this->Permission->CheckPermissionOperation('add_special_form')): ?>
                    <div class="row" style="margin-top: 2rem;">
                        <div class="col-md-12">
                            <!-- special form -->
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('Special Form'); ?></h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-2"><?= $this->Dictionary->GetKeyword('Note'); ?></label>
                                                <div class="col-md-10">
                                                    <textarea name="special_form_note" class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-2"><?= $this->Dictionary->GetKeyword('Pages Count'); ?></label>
                                                <div class="col-md-10">
                                                    <input type="number" min="1"  value="1" name="special_form_pages_count" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


                <div class="row" style="margin-top: 2rem;">
                    <div class="col-md-12">
                        <!-- first trace -->
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= $this->Dictionary->GetKeyword('First Trace'); ?></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- <div class="form-group">
                                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Trace Type'); ?> *</label>
                                            <div class="col-md-8">
                                                <select name="trace_type_id" class="form-control" required>
                                                    <option value=""><?= $this->Dictionary->GetKeyword('Select Type'); ?></option>
                                                    <?php

                                        foreach($trace_types as $type):
                                            ?>
                                                    <option value="<?= $type['import_trace_type_id'] ?>"><?= $this->Dictionary->GetKeyword($type['import_trace_type_name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div> -->

                                        <div class="form-group">
                                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Receiver User'); ?></label>
                                            <div class="col-md-8">
                                                <select name="trace_receiver_user_id" class="form-control" required >
                                                    <option value=""><?= $this->Dictionary->GetKeyword('Select User'); ?></option>
                                                    <!--                                                    --><?php // foreach($users as $user):?>
                                                    <!--                                                        <option value="--><?php //= $user['id'] ?><!--">--><?php //= $user['name'] ?><!--</option>-->
                                                    <!--                                                    --><?php //endforeach; ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Action Type'); ?> *</label>
                                            <div class="col-md-8">
                                                <select name="trace_action_type_id" class="form-control" required>
                                                    <option value=""><?= $this->Dictionary->GetKeyword('Select Action Type'); ?></option>
                                                    <?php
                                                    foreach($trace_action_types as $action_type):
                                                        ?>
                                                        <option value="<?= $action_type['id'] ?>"><?= $this->Dictionary->GetKeyword($action_type['name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>



                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Receiver Department'); ?> *</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <input type="text" id="trace_receiver_department" class="form-control" readonly required>
                                                    <input type="hidden" id="trace_receiver_department_id" name="trace_receiver_department_id" required>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button" onclick="OpenTree('department','trace_receiver_department','trace_receiver_department_id','1',  'extra-section', 1)">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-2"><?= $this->Dictionary->GetKeyword('Note'); ?></label>
                                            <div class="col-md-10">
                                                <textarea name="trace_note" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <div >
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> <?= $this->Dictionary->GetKeyword('Save'); ?>
                            </button>
                            <a href="<?= base_url('Import/List'); ?>" class="btn btn-default">
                                <i class="fa fa-times"></i> <?= $this->Dictionary->GetKeyword('Cancel'); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
            <!-- /.card-body -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<div id="answer-template" style="display: none;">
    <div class="row answer-row">
        <div class="col-md-5">
            <div class="form-group">
                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Out Book Number'); ?>*</label>
                <div class="col-md-8">
                    <!--    required-->
                    <input type="text" name="answer_out_book_number[]" class="form-control" required>
                </div>
            </div>

            <div class="form-group ">
                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Out Book Date'); ?>*</label>
                <div class="col-md-8">
                    <!--    required-->
                    <input type="date" name="answer_out_book_date[]" class="form-control" required>
                </div>
            </div>


        </div>

        <div class="col-md-5">

            <div class="form-group">
                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('From Department'); ?> *</label>
                <div class="col-md-8">
                    <div class="input-group">

                        <!--    required-->
                        <input type="text" class="form-control department-text" id="answer_out_to_department_1" name="answer_out_to_department[]" required
                               value="<?= $current_department->fullpath ?>"   readonly >
                        <!--    required-->
                        <input type="hidden" class="form-control department-id" id="answer_out_to_department_id_1" name="answer_out_to_department_id[]" required
                               value="<?= $current_department->id ?>"
                        >
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="OpenTree('department','answer_out_to_department_1','answer_out_to_department_id_1','1', 'extra-section', 1)">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Search For Out Book'); ?> </label>
                <div class="col-md-8">
                    <div class="input-group">
                        <!--    required-->
                        <input type="text" class="form-control department-text" id="answer_out_name"  readonly >
                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button" onclick="checkOutExistence(this)">
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-1">
            <div class="form-group">
                <a class="btn btn-sm btn-danger" onclick="DeleteAnswerRow(this)" role="button"><i class="fa fa-trash"></i></a>
            </div>
        </div>
    </div>
</div>

<script>



    $(document).ready(function () {


        function checkFieldsAndSendAjax() {
            const bookNumber = $('#import_book_number').val().trim();
            const bookDate = $('#import_book_date').val().trim();
            const from_department_id = $('#import_from_department_id').val().trim();

            if (bookNumber && bookDate && from_department_id) {
                // All fields are filled, send the AJAX request
                $.ajax({
                    url: '<?= base_url("Import/AjaxCheckImportExistence") ?>',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        book_number: bookNumber,
                        book_date: bookDate,
                        from_department_id: from_department_id
                    },
                    success: function (response) {
                        if (response.exists) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });

                        } else {

                        }
                    },
                    error: function () {
                        alert('An error occurred while checking the out book.');
                    }
                });
            }
        }

        $('#import_book_number, #import_book_date, #import_from_department_id').on('input change', function () {
            checkFieldsAndSendAjax();
        });



        const fromDepartmentField = document.getElementById('import_from_department');
        const bookNumberField = document.querySelector('input[name="import_book_number"]');
        const bookDateField = document.querySelector('input[name="import_book_date"]');
        const searchButton = document.getElementById('import-search-button');

        // Initially hide the button
        searchButton.parentElement.parentElement.style.display = 'none';

        function checkFields() {
            const isFromDepartmentFilled = fromDepartmentField.value.trim() !== '';
            const isBookNumberFilled = bookNumberField.value.trim() !== '';
            const isBookDateFilled = bookDateField.value.trim() !== '';

            console.log('isFromDepartmentFilled ', isFromDepartmentFilled, isBookNumberFilled, isBookDateFilled);


            if (isFromDepartmentFilled && isBookNumberFilled && isBookDateFilled) {
                searchButton.parentElement.parentElement.style.display = 'block';
            } else {
                searchButton.parentElement.parentElement.style.display = 'none';
            }
        }

        // Add event listeners to monitor changes
        fromDepartmentField.addEventListener('input', checkFields);
        bookNumberField.addEventListener('input', checkFields);
        bookDateField.addEventListener('input', checkFields);


        $('#trace_receiver_department_id').on('change', function() {
            const departmentId = $(this).val();
            if (departmentId) {
                loadUsersByDepartment(departmentId);
            }
        });

        // on click on import-search-button send ajax request to get remote import data
        $('#import-search-button').on('click', function () {
            const fromDepartmentId = $('#import_from_department_id').val();
            const bookNumber = bookNumberField.value.trim();
            const bookDate = bookDateField.value.trim();

            if (!fromDepartmentId || !bookNumber || !bookDate) {
                alert('Please fill in all required fields before searching.');
                return;
            }

            $('.overlay').css('display', 'flex'); // Show the overlay

            $.ajax({
                url: '<?= base_url('Import/AjaxGetRemoteImportData'); ?>',
                type: 'POST',
                data: {
                    from_department_id: fromDepartmentId,
                    book_number: bookNumber,
                    book_date: bookDate
                },
                dataType: 'json',
                success: function (response) {
                    $('.overlay').hide(); // Hide the overlay after response
                    console.log('response', response);
                    if (response.exists) {
                        console.log('response', response);
                        // add the response.name to answer_out_name
                        // const outNameInput = row.querySelector('#answer_out_name');
                        // outNameInput.value = response.out_subject;

                        // shwo swal alert success
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Remote import data fetched successfully.',
                            confirmButtonText: 'OK'
                        });

                        // Populate the form with the received data
                        let remote_out = response.out_info;
                        let remote_branch_id = response.branch_id;
                        $('#import_to_department').val(remote_out.out_to_department);
                        $('#import_to_department_id').val(remote_out.out_to_department_id);
                        //$('#import_book_category_id').val(response.data.book_category_id);
                        $('#import_book_language_id').val(remote_out.out_book_language_id);
                        $('#import_book_subject').val(remote_out.out_book_subject);
                        $('#import_body').val(remote_out.out_book_body);
                        $('#import_note').val(remote_out.out_note);
                        $('#import_signed_by').val(remote_out.out_signed_by);
                        $('#remote_out_id').val(remote_out.id);
                        $('#remote_branch_id').val(remote_branch_id);


                    } else {
                        //alert('The out book does not exist.');
                        $('.overlay').hide(); // Hide the overlay after response

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message || 'The out book does not exist.',

                        });
                    }


                },
                error: function () {
                    $('.overlay').hide(); // Hide the overlay after response
                    alert('Error fetching remote import data.');
                }
            });
        });






        function loadUsersByDepartment(departmentId) {
            $.ajax({
                url: '<?= base_url('User/AjaxGetUsersByDepartment') ?>',
                type: 'POST',
                data: { department_id: departmentId },
                dataType: 'json',
                success: function(response) {
                    console.log('sucesss response', response);
                    const $select = $('select[name="trace_receiver_user_id"]');
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


        $('#import-form').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission
            $('.overlay').css('display', 'flex'); // Show the overlay


            // Submit the form via AJAX
            $.ajax({
                url: '<?= base_url('Import/Add'); ?>',
                type: 'POST',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {

                    // Clear previous error messages
                    $('.form-error').remove();
                    $('.is-invalid').removeClass('is-invalid');
                    if(response.status !== 'true') {
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
                                text: response.message || 'An error occurred while adding the import.',
                                confirmButtonText: 'OK'
                            });
                        }

                        $('.overlay').hide(); // Hide overlay after error
                        return;
                    }else{
                        // go to the import detail page
                        window.location.href = '<?= base_url('Import/Details/'); ?>' + response.import_id;
                    }
                    // Handle success response
                    $('.overlay').hide(); // Hide the overlay after success

                },
                error: function (xhr, status, error) {
                    try {
                        const response = JSON.parse(xhr.responseText); // Parse the server response
                        console.log('Parsed error response:', response);

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
                                text: response.message || 'An error occurred while adding the import.',
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
                    $('.overlay').hide(); // Hide the overlay after error
                }
            });
        });





        $('#import_is_answer').on('change', function () {


            if ($(this).is(':checked')) {
                $('.answers_section').show();
                $('.answers_section :input').prop('disabled', false);
            } else {
                $('.answers_section').hide();
                $('.answers_section :input').prop('disabled', true);
            }
        });


        let rowIndex = 2;

        $(document).on('click', '.btn-add-answer', function () {
            // if there is no book number to the previous row show popup error
            const previousRow = document.querySelector('.answer-row:last-child');
            const previousBookNumber = previousRow.querySelector('input[name="answer_out_book_number[]"]').value;
            const previousBookDate = previousRow.querySelector('input[name="answer_out_book_date[]"]').value;
            //const previousDepartmentText = previousRow.querySelector('.department-text').value;

            // if (previousBookNumber === '' || previousBookDate === '' ) {
            //     alert('Please fill in all fields in the previous row before adding a new one.');
            //     return;
            // }
            const template = document.querySelector('#answer-template').innerHTML;
            const container = document.querySelector('#answers-container');

            // Create a DOM element to modify before inserting
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = template;

            const textInput = tempDiv.querySelector('.department-text');
            const hiddenInput = tempDiv.querySelector('.department-id');

            const textId = `answer_out_to_department_${rowIndex}`;
            const hiddenId = `answer_out_to_department_id_${rowIndex}`;

            textInput.id = textId;
            hiddenInput.id = hiddenId;

            // Also set name attributes as arrays
            textInput.name = 'answer_out_to_department[]';
            hiddenInput.name = 'answer_out_to_department_id[]';

            // Set the onclick with the new IDs
            const button = tempDiv.querySelector('button');
            button.setAttribute('onclick', `OpenTree('department','${textId}','${hiddenId}','1', 'extra-section', 1)`);

            container.appendChild(tempDiv.firstElementChild);

            rowIndex++;
        });


    });
    function DeleteAnswerRow(button) {
        const row = button.closest('.answer-row');
        if (row) {
            row.remove();
        }
    }


    function checkOutExistence(button) {
        const row = button.closest('.answer-row');
        const bookNumber = row.querySelector('input[name="answer_out_book_number[]"]').value;
        const bookDate = row.querySelector('input[name="answer_out_book_date[]"]').value;
        const departmentId = row.querySelector('.department-id').value;

        if (bookNumber === '' || bookDate === '' || departmentId === '') {
            alert('Please fill in all fields before checking.');
            return;
        }

        $.ajax({
            url: '<?= base_url('Import/AjaxCheckOutExistence'); ?>',
            type: 'POST',
            data: {
                out_book_number: bookNumber,
                out_book_date: bookDate,
                out_from_department_id: departmentId,
            },
            dataType: 'json',
            success: function (response) {
                if (response.exists) {
                    // add the response.name to answer_out_name
                    const outNameInput = row.querySelector('#answer_out_name');
                    outNameInput.value = response.out_subject;

                } else {
                    //alert('The out book does not exist.');


                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'The out book does not exist.',
                        // footer: '<a href="<?= base_url('Out/Add'); ?>">Create New Out Book</a>'
                    });
                }
            },
            error: function () {
                alert('An error occurred while checking the out book.');
            }
        });
    }


</script>