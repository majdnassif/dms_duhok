<form id="ClientForm" method="POST">
            <div class="modal-header">
              <h3 class="modal-title"><?=$this->Dictionary->GetKeyword($form_title)?></h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="client_id" name="client_id" value="">
                <!-- client_name -->
                <div class="row">
                <div class="form-group col-md-6">
                    <label for="client_name"><?=$this->Dictionary->GetKeyword('client_name')?></label>
                    <input type="text" class="form-control" id="client_name" name="client_name" placeholder="<?=$this->Dictionary->GetKeyword('client_name')?>" required>
                </div>
                <!-- client_profile -->
                <div class="form-group col-md-6">
                    <label id="label_client_profile" for="client_profile"><?=$this->Dictionary->GetKeyword('client_profile')?></label>
                    <input type="text" class="form-control" id="client_profile" name="client_profile" placeholder="<?=$this->Dictionary->GetKeyword('client_profile')?>" required>
                </div>
                <!-- client_platform_id select -->
                <div class="form-group col-md-6">
                    <label for="client_platform_id"><?=$this->Dictionary->GetKeyword('client_platform_id')?></label>
                    <select class="form-control select2" id="client_platform_id" name="client_platform_id" required>
                        <option value=""><?=$this->Dictionary->GetKeyword('client_platform_id')?></option>
                        <?php foreach($Platforms as $Platform):?>
                            <option value="<?=$Platform['platform_id']?>"><?=$Platform['platform_name_en']?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                 <!-- client_region_id select -->
                 <div class="form-group col-md-6">
                    <label for="client_region_id"><?=$this->Dictionary->GetKeyword('client_region_id')?></label>
                    <select class="form-control select2" id="client_region_id" name="client_region_id" required>
                        <option value=""><?=$this->Dictionary->GetKeyword('client_region_id')?></option>
                        <?php foreach($Regions as $Region):?>
                            <option value="<?=$Region['region_id']?>"><?=$this->Dictionary->GetKeyword($Region['region_name_en'])?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <!-- client_mobile_1 -->
                <div class="form-group col-md-6">
                    <label for="client_mobile_1"><?=$this->Dictionary->GetKeyword('client_mobile_1')?></label>
                    <input type="text" class="form-control" id="client_mobile_1" name="client_mobile_1" placeholder="<?=$this->Dictionary->GetKeyword('client_mobile_1')?>" required>
                </div>
                <!-- client_mobile_2 -->
                <div class="form-group col-md-6">
                    <label for="client_mobile_2"><?=$this->Dictionary->GetKeyword('client_mobile_2')?></label>
                    <input type="text" class="form-control" id="client_mobile_2" name="client_mobile_2" placeholder="<?=$this->Dictionary->GetKeyword('client_mobile_2')?>" required>
                </div>
                <!-- client_address_1 -->
                <div class="form-group  col-md-12">
                    <label for="client_address_1"><?=$this->Dictionary->GetKeyword('client_address_1')?></label>
                    <input type="text" class="form-control" id="client_address_1" name="client_address_1" placeholder="<?=$this->Dictionary->GetKeyword('client_address_1')?>" required>
                </div>
                <!-- client_address_2 -->
                <div class="form-group  col-md-12">
                    <label for="client_address_2"><?=$this->Dictionary->GetKeyword('client_address_2')?></label>
                    <input type="text" class="form-control" id="client_address_2" name="client_address_2" placeholder="<?=$this->Dictionary->GetKeyword('client_address_2')?>" required>
                </div>
                <!-- client_comments -->
                <div class="form-group  col-md-12">
                    <label for="client_comments"><?=$this->Dictionary->GetKeyword('client_comments')?></label>
                    <textarea class="form-control" id="client_comments" name="client_comments" placeholder="<?=$this->Dictionary->GetKeyword('client_comments')?>" required></textarea>
                </div>
                </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="progress_bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="modal-footer col-12 justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?=$this->Dictionary->GetKeyword('Close')?></button>
              <button type="submit"  class="btn btn-success" ><?=$this->Dictionary->GetKeyword($form_submit)?></button>
            </div>
            
        </form>
        

        <script>
         $(document).ready(function() {
             $('#ClientForm .progress').hide();
             $('#ClientForm .progress-bar').css('width', '0%');
            <?php if($form_type=='add'):?>
            $('#ClientForm').submit(function(event) {
                event.preventDefault();
                    submitform();
                return false;
            });
            function submitform(){
                // Get form
                var form = $('#ClientForm')[0];
                // Create an FormData object 
                var dataform = new FormData(form);
                
             $('#ClientForm .progress').show();
                     $.ajax({
                         xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    if(percentComplete<100){
                                        $('#ClientForm button[type="submit"]').prop('disabled', true);
                                    }else{
                                        
                                        $('#ClientForm button[type="submit"]').prop('disabled', false);
                                    }
                                    $('#progress_bar').css('width', percentComplete+'%');
                                    $('#progress_bar').html(percentComplete+'%');
                                    console.log(percentComplete);
                                }
                            }, false);
                            return xhr;
                        },
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "<?=base_url('Orders/AjaxAddClientOrder/'.$OrderID )?>",
                    data: dataform,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function(response) {
                        if(response[0]=='<'){

                            toastr.error("<?=$this->Dictionary->GetKeyword('Error')?>");
                        }else{
                            response=JSON.parse(response);
                            if(response.status=='True'){
                                $("#card-OrderInformation").click();
                                $("#extra-modal").modal('hide');
                                $('.modal-backdrop').remove(); 
                                $("body").removeClass("modal-open");
                                toastr.success(response.message);
                            }else{
                                toastr.error(response.message);
                            }
                        }
                    },
                    error: function() {
                        toastr.error("we can't Upload this file");
                    }
                });
                
            }
                <?php endif;?>
        });
       
        $('#client_name').on('autocompletecreate', function(event, ui) {
                                                                  $(event.target).autocomplete("instance")._renderItem = function(ul, item) {
                                                                    return $('<li onclick="LoadClientInfo('+item.client_id+')">').append("<div>"+item.client_name+"</div>").appendTo(ul);
                                                                   };
                                                                });
$('#client_name').autocomplete({"source":"<?=base_url('Orders/AjaxClientSearch')?>","autoFill":false,"minLength":"2"});
             </script>