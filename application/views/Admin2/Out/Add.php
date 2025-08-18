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
<style>
    .answer-row {
        margin-bottom: 4rem;
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
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <?php echo form_open_multipart('Out/Add', ['class' => 'form-horizontal', 'id' => 'out-form']); ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('To Department'); ?> *</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" id="out_to_department" class="form-control" readonly required>
                                    <input type="hidden" id="out_to_department_id" name="out_to_department_id" required>
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
                                    <input type="text" id="out_from_department" class="form-control" readonly required>
                                    <input type="hidden" id="out_from_department_id" name="out_from_department_id" required>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="OpenTree('department','out_from_department','out_from_department_id','1',  'extra-section', 1)">
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
                                        <option value="<?= $category->book_category_id ?>"><?= $category->book_category_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Signed By'); ?></label>
                            <div class="col-md-8">
                                <input type="text" name="out_signed_by" class="form-control">
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
                                        <option value="<?= $language->book_language_id ?>"><?= $language->book_language_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!--                        <div class="form-group">-->
                        <!--                            <label class="control-label col-md-4">--><?php //= $this->Dictionary->GetKeyword('Status'); ?><!--</label>-->
                        <!--                            <div class="col-md-8">-->
                        <!--                                <select name="out_status_id" class="form-control">-->
                        <!--                                    <option value="">--><?php //= $this->Dictionary->GetKeyword('Select'); ?><!--</option>-->
                        <!--                                    --><?php //
                        //                                      foreach($statuses as $level):
                        //                                    ?>
                        <!--                                     <option value="--><?php //= $status['id'] ?><!--">--><?php //= $this->Dictionary->GetKeyword($status['name']) ?><!--</option>-->
                        <!--                                    --><?php //endforeach; ?>
                        <!--                                </select>-->
                        <!--                            </div>-->
                        <!--                        </div>-->





                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Attachments'); ?>*</label>
                            <div class="col-md-8">
                                <input type="file" name="attachments[]" class="form-control" multiple required>
                                <small class="text-muted"><?= $this->Dictionary->GetKeyword('Allowed file types: pdf, doc, docx, xls, xlsx, jpg, png, gif'); ?></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!--                        <div class="form-group">-->
                        <!--                            <label class="control-label col-md-4">--><?php //= $this->Dictionary->GetKeyword('Out Code'); ?><!-- *</label>-->
                        <!--                            <div class="col-md-8">-->
                        <!--                                <input type="text" name="out_book_code" class="form-control" required>-->
                        <!--                            </div>-->
                        <!--                        </div>-->

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Book Number'); ?></label>
                            <div class="col-md-8">
                                <input type="text" name="out_book_number" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Book Issue Date'); ?>*</label>
                            <div class="col-md-8">
                                <input type="date" name="out_book_issue_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Book Subject'); ?> *</label>
                            <div class="col-md-8">
                                <input type="text" name="out_book_subject" class="form-control" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Book Body'); ?></label>
                            <div class="col-md-8">
                                <textarea name="out_book_body" class="form-control" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Electronic Copy'); ?></label>
                            <div class="col-md-8">
                                <select name="elec_dep_reference" class="form-control">
                                    <option value="-1"><?= $this->Dictionary->GetKeyword('Select'); ?></option>
                                    <?php  foreach($branches as $branch):?>
                                        <option value="<?= $branch['id'] ?>"
                                        ><?= $branch['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!--                        <div class="form-group">-->
                        <!--                            <label class="control-label col-md-4">--><?php //= $this->Dictionary->GetKeyword('Entry Date'); ?><!--</label>-->
                        <!--                            <div class="col-md-8">-->
                        <!--                                <input type="date" name="out_book_entry_date" class="form-control">-->
                        <!--                            </div>-->
                        <!--                        </div>-->





                        <!--                        <div class="form-group">-->
                        <!--                            <label class="control-label col-md-4">--><?php //= $this->Dictionary->GetKeyword('Is Answer'); ?><!--</label>-->
                        <!--                            <div class="col-md-8">-->
                        <!--                                <input type="checkbox" name="is_answer" value="1">-->
                        <!--                            </div>-->
                        <!--                        </div>-->


                    </div>


                </div>

                <div class="row">
                    <div class="col-md-12">



                        <div class="form-group">
                            <label class="control-label col-md-2"><?= $this->Dictionary->GetKeyword('Notes'); ?></label>
                            <div class="col-md-10">
                                <textarea name="out_note" class="form-control" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2"><?= $this->Dictionary->GetKeyword('Copy List'); ?></label>
                            <div class="col-md-10">
                                <textarea name="out_book_copy_list" class="form-control" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Is Answer'); ?></label>
                                <div class="col-md-8">
                                    <input type="checkbox" name="out_is_answer" id="out_is_answer" >
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

                                            <div class="form-group col-md-6">
                                                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Import Book Number'); ?>*</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="answer_import_book_number[]" class="form-control" required disabled>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label class="control-label col-md-3"><?= $this->Dictionary->GetKeyword('From Department'); ?> *</label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control department-text" id="answer_import_from_department_1" name="answer_import_from_department[]"  readonly required disabled
                                                               value="<?=  $current_department->fullpath    ?>"
                                                        >
                                                        <input type="hidden" class="form-control department-id" id="answer_import_from_department_id_1" name="answer_import_from_department_id[]" required disabled
                                                               value="<?=  $current_department->id ?>"                                                        >
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button" onclick="OpenTree('department','answer_import_from_department_1','answer_import_from_department_id_1','1')">
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>


                                                <div class="form-group col-md-1">
                                                    <a class="btn btn-sm btn-danger" onclick="DeleteAnswerRow(this)" role="button"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Import Book Date'); ?>*</label>
                                                <div class="col-md-8">
                                                    <input type="date" name="answer_import_book_date[]" class="form-control" required disabled>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label class="control-label col-md-3"><?= $this->Dictionary->GetKeyword('Search For Import Book'); ?> </label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control department-text" id="answer_import_name"  readonly >
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" type="button" onclick="checkImportExistence(this)">
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                    </div>
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

        <div class="form-group col-md-6">
            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Import Book Number'); ?>*</label>
            <div class="col-md-8">
                <input type="text" name="answer_import_book_number[]" class="form-control" required>
            </div>
        </div>


        <div class="form-group col-md-6">
            <label class="control-label col-md-3"><?= $this->Dictionary->GetKeyword('From Department'); ?> *</label>

            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" class="form-control department-text"  required readonly
                           value="<?=  $current_department->fullpath    ?>">
                    <input type="hidden" class="form-control department-id" required  >
                    <span class="input-group-btn">
                            <button class="btn btn-default" type="button"
                                    value="<?=  $current_department->id    ?>">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                </div>
            </div>


            <div class="form-group col-md-1">
                <a class="btn btn-sm btn-danger" onclick="DeleteAnswerRow(this)" role="button"><i class="fa fa-trash"></i></a>
            </div>
        </div>



        <div class="form-group col-md-6">
            <label class="control-label col-md-4"><?= $this->Dictionary->GetKeyword('Import Book Date'); ?>*</label>
            <div class="col-md-8">
                <input type="date" name="answer_import_book_date[]" class="form-control" required >
            </div>
        </div>

        <div class="form-group col-md-6">
            <label class="control-label col-md-3"><?= $this->Dictionary->GetKeyword('Search For Import Book'); ?> </label>
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" class="form-control department-text" id="answer_import_name"  readonly >
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" onclick="checkImportExistence(this)">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </div>

        </div>

    </div>

</div>



<script>
    $(document).ready(function () {

        $('#out-form').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission
            $('.overlay').css('display', 'flex'); // Show the overlay


            // Submit the form via AJAX
            $.ajax({
                url: '<?= base_url('Out/Add'); ?>',
                type: 'POST',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log('success responseeeeeeeeeee', response);

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
                        window.location.href = '<?= base_url('Out/Details/'); ?>' + response.out_id;
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


        $('#out_is_answer').on('change', function () {
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
            const previousBookNumber = previousRow.querySelector('input[name="answer_import_book_number[]"]').value;
            const previousBookDate = previousRow.querySelector('input[name="answer_import_book_date[]"]').value;
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

            const textId = `answer_import_from_department_${rowIndex}`;
            const hiddenId = `answer_import_from_department_id_${rowIndex}`;

            textInput.id = textId;
            hiddenInput.id = hiddenId;

            // Also set name attributes as arrays
            textInput.name = 'answer_import_from_department[]';
            hiddenInput.name = 'answer_import_from_department_id[]';

            // Set the onclick with the new IDs
            const button = tempDiv.querySelector('button');
            button.setAttribute('onclick', `OpenTree('department','${textId}','${hiddenId}','1')`);

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


    function checkImportExistence(button) {
        const row = button.closest('.answer-row');
        const bookNumber = row.querySelector('input[name="answer_import_book_number[]"]').value;
        const bookDate = row.querySelector('input[name="answer_import_book_date[]"]').value;
        const departmentId = row.querySelector('.department-id').value;

        if (bookNumber === '' || bookDate === '' || departmentId === '') {
            alert('Please fill in all fields before checking.');
            return;
        }

        $.ajax({
            url: '<?= base_url('Out/AjaxCheckImportExistence'); ?>',
            type: 'POST',
            data: {
                import_book_number: bookNumber,
                import_book_date: bookDate,
                import_from_department_id: departmentId
            },
            dataType: 'json',
            success: function (response) {
                if (response.exists) {
                    // add the response.name to answer_out_name
                    const importNameInput = row.querySelector('#answer_import_name');
                    importNameInput.value = response.import_subject;

                } else {
                    //alert('The out book does not exist.');


                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'The import book does not exist.',
                        //footer: '<a href="<?= base_url('Out/Add'); ?>">Create New Out Book</a>'
                    });
                }
            },
            error: function () {
                alert('An error occurred while checking the out book.');
            }
        });


    }



</script>