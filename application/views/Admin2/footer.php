      <div class="modal fade" id="extra-modal-md">
        <div class="modal-dialog modal-md modal-dialog-centered">
          
          <div class="modal-content  table-responsive" style="border-radius: 20px;" id='extra-section-md'>
                        
      
          </div>
          
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


      <div class="modal fade" id="extra-modal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          
          <div class="modal-content  table-responsive" style="border-radius: 20px;" id='extra-section'>
          </div>
          
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>





      <div class="modal fade" id="extra-modal-xl">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          
          <div class="modal-content  table-responsive" style="border-radius: 20px;" id='extra-section-xl'>
                        
      
          </div>
          
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>




      <style>
        .modal-full {
            min-width: 90%;
       }

        .modal.custom-zindex {
            z-index: 2000 !important;
        }

        .overlay {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;

        }

        .overlay-content {
            text-align: center;
            color: #fff;
        }

        .overlay-icon {
            font-size: 50px;
            margin-bottom: 10px;
        }

        .overlay-text {
            font-size: 20px;
        }

/* .modal-full .modal-content {
    min-height: 100vh;
} */
      </style>
      <div class="modal fade" id="extra-modal-full">
        <div class="modal-dialog modal-full modal-dialog-centered">
          
          <div class="modal-content  table-responsive" style="border-radius: 20px;" id='extra-section-full'>
                        
      
          </div>
          
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" data-dismiss="modal">
      <div class="modal-content"  >              
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
             <img src="" class="imagepreview" style="width: 100%;" >
        </div>      
   </div>
 </div>
  <div class="page-footer">
      <p class="no-s">2015 © Modern by Steelcoders.</p>
  </div>
 </div><!-- Page Inner -->
 </main><!-- Page Content -->
 <div class="cd-overlay"></div>



      <!-- <nav class="cd-nav-container" id="cd-nav">
            <header>
                <h3>Navigation</h3>
                <a href="#0" class="cd-close-nav">Close</a>
            </header>
            <ul class="cd-nav list-unstyled">
                <li class="cd-selected" data-menu="index">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-home"></i>
                        </span>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li data-menu="profile">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                        <p>Profile</p>
                    </a>
                </li>
                <li data-menu="inbox">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-envelope"></i>
                        </span>
                        <p>Mailbox</p>
                    </a>
                </li>
                <li data-menu="#">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-tasks"></i>
                        </span>
                        <p>Tasks</p>
                    </a>
                </li>
                <li data-menu="#">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-cog"></i>
                        </span>
                        <p>Settings</p>
                    </a>
                </li>
                <li data-menu="calendar">
                    <a href="javsacript:void(0);">
                        <span>
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                        <p>Calendar</p>
                    </a>
                </li>
            </ul>
        </nav> -->


  <script src="<?=base_url('assets/admin2/')?>plugins/jquery-ui/jquery-ui.min.js"></script>
  <script src="<?=base_url('assets/');?>plugins/datatables/jquery.dataTables.min.js"></script>
  <!-- Core scripts - highest priority -->
  <script src="<?=base_url('assets/admin2/')?>plugins/jquery-blockui/jquery.blockui.js" defer></script>
  <script src="<?=base_url('assets/admin2/')?>plugins/bootstrap/js/bootstrap.min.js" defer></script>

  <!-- Secondary scripts - load with defer attribute -->
  <script src="<?=base_url('assets/admin2/')?>plugins/jquery-slimscroll/jquery.slimscroll.min.js" defer></script>
  <script src="<?=base_url('assets/admin2/')?>plugins/waves/waves.min.js" defer></script>
  <script src="<?=base_url('assets/admin2/')?>plugins/toastr/toastr.min.js" defer></script>
  <script src="<?=base_url('assets/')?>plugins/sweetalert2/sweetalert2.min.js" defer></script>
  
  <!-- UI enhancement scripts - load last -->
  <!-- <script src="<?=base_url('assets/admin2/')?>plugins/switchery/switchery.min.js" defer></script> -->
  <script src="<?=base_url('assets/admin2/')?>plugins/uniform/jquery.uniform.min.js" defer></script>

  <!-- <script src="<?=base_url('assets/admin2/')?>plugins/3d-bold-navigation/js/main.js" defer></script> -->
  <script src="<?=base_url('assets/admin2/')?>js/modern.js" defer></script>
  
  <!-- Form-related scripts - load when needed -->
  <script src="<?=base_url('assets/');?>plugins/inputmask/jquery.inputmask.min.js" defer></script>

  <?php if(isset($output)):?>
    <?php foreach($js_files as $file): ?>
      <script src="<?php echo $file; ?>" defer></script>
    <?php endforeach; ?>
  <?php endif;?>

  <!-- Additional functionality scripts -->
  <script src="<?=base_url('assets/');?>tree/tree.js" defer></script>
  <script src="<?=base_url('assets/admin2/');?>plugins/select2/js/select2.full.min.js" defer></script>
  <script src="<?=base_url('assets/');?>plugins/bootstrap-switch/js/bootstrap-switch.min.js" defer></script>
  <script src="<?=base_url('assets/admin2/');?>plugins/jquery-validation/jquery.validate.min.js" defer></script> 
  <script src="<?=base_url('assets/');?>dist/js/jquery.confirmModal.min.js" defer></script> 

  <script>
   //   $('.overlay').fadeOut();
    // Initialize all deferred scripts after document is ready
    document.addEventListener('DOMContentLoaded', function() {
      
      // Bootstrap validation
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      
      // Set default datepicker options
      if ($.fn.datepicker) {
        $.fn.datepicker.defaults={
          format: 'yyyy-mm-dd',
          autoclose: true,
          todayHighlight: true,
          orientation: "bottom"
        };
      }
      
      // SweetAlert Toast configuration
      var Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: true
      });
      
      // ConfirmModal defaults
      $defaultsConfirmModal={
        confirmButton: "<?=$this->Dictionary->GetKeyword('Yes')?>",
        cancelButton: "<?=$this->Dictionary->GetKeyword('No')?>"
      }
    });
    
    // Define functions after DOM is loaded, but don't execute them yet
    function OpenTree(type_name,TextInputID,IDInputID,AllSelectable=0,ViewSection="extra-section", isCurrent=0){
      $( "#"+ViewSection).html('<div class="modal-content" style="border-radius: 20px;" id="edit-section"><div class="modal-header"><h3 class="modal-title">Loading</h3><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body text-center"><div class="text-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading Please Wait...</div></div></div>');
      if(ViewSection=="extra-section"){
        $('#extra-modal').modal('show');
        $('#extra-modal').addClass('custom-zindex');

      }
      $.post("<?=base_url('Tree/AjaxLoadTree/');?>"+type_name+'/'+AllSelectable+'/'+isCurrent,{text_input_id:TextInputID,id_input_id:IDInputID,view_section:ViewSection},function(data){
        $('#'+ViewSection).html(data);
      });
    }
    
    // Lazy-load notifications only when needed
    //function GetNotifications(){
    //  console.log('GetNotifications');
    //  $('#nt_list').html('<li><a href="#" class="dropdown-item dropdown-footer">There are No Notifications</a></li>');
    //  $('#nt_count').html(0);
    //  $.ajax({
    //    type: "GET",
    //    url: "<?php //=base_url('Admin/AjaxNotification')?>//",
    //    success: function(response) {
    //      response=JSON.parse(response);
    //      if(response.count>0){
    //        if(response.count!=$('#nt_count').html()){
    //          toastr.success('You have new Notifications.', '',{"positionClass": "toast-bottom-right"});
    //         //ding();
    //        }
    //
    //        if(response.count!=$('#nt_count').html()){
    //          $('#nt_count').html(response.count);
    //          $('#nt_list').html('');
    //          $.each(response.data, function(index) {
    //            if(response.data[index].nt_link==''){
    //              response.data[index].nt_link='#';
    //            }
    //            $('#nt_list').append('<li><a href="'+response.data[index].nt_link+'" onclick="$.get('+"'<?php //=base_url('Admin/AjaxReadNotification/')?>//"+response.data[index].nt_id+"'"+')" class="dropdown-item"><p class="msg-text">'+response.data[index].nt_title+'</p><p class="msg-time">'+response.data[index].nt_create_date+'</p></a><div class="dropdown-divider"></div></li>');
    //            toastr.options.onclick = function(e) {
    //              window.location.replace(this.data.Link);
    //              $.get('<?php //=base_url('Admin/AjaxReadNotification/')?>//'+this.data.ID);
    //            }
    //
    //            toastr.success(response.data[index].nt_title, '',{"positionClass": "toast-bottom-right","data":{"Link":response.data[index].nt_link,"ID":response.data[index].nt_id}});
    //          });
    //        }
    //      }else{
    //        $('#nt_list').html('<li><a href="#" class="dropdown-item dropdown-footer">There are No Notifications</a></li>');
    //        $('#nt_count').html(0);
    //      }
    //    }
    //  });
    //}
    //GetNotifications()

    // load unread messages count
    function GetUnreadReceived(){

        $('#nt_list').html('<li><a href="#" class="dropdown-item dropdown-footer">There are No Notifications</a></li>');
        $('#nt_count').html(0);
        $.ajax({
            type: "GET",
            url: "<?=base_url('Admin/AjaxUnreadReceived')?>",
            success: function(response) {
                response=JSON.parse(response);
                if(response.count>0){
                    if(response.count!=$('#nt_count').html()){
                        //toastr.success('You have new Notifications.', '',{"positionClass": "toast-bottom-right"});
                        //ding();
                    }

                    if(response.count!=$('#nt_count').html()){
                        $('#nt_count').html(response.count);
                        $('#nt_list').html('');
                        $.each(response.data, function(index) {
                            if(response.data[index].nt_link==''){
                                response.data[index].nt_link='#';
                            }
                            $('#nt_list')
                                .append('<li><a href="" onclick="$.get('+"'<?=base_url('Inbox/List/-1')?>"+"'"+')" class="dropdown-item"><p class="msg-text">'+response.data[index].nt_title+'</p><p class="msg-time">'+response.data[index].nt_received_data+'</p></a><div class="dropdown-divider"></div></li>');
                            toastr.options.onclick = function(e) {
                                window.location.replace(this.data.Link);
                                $.get('<?=base_url('Admin/AjaxReadNotification/')?>'+this.data.ID);
                            }

                            //toastr.success(response.data[index].nt_title, '',{"positionClass": "toast-bottom-right","data":{"Link":response.data[index].nt_link,"ID":response.data[index].nt_id}});
                        });
                    }
                }else{
                    $('#nt_list').html('<li><a href="#" class="dropdown-item dropdown-footer">There are No Notifications</a></li>');
                    $('#nt_count').html(0);
                }
            }
        });
    }
    GetUnreadReceived()
  </script>

</body>
</html>
<?php 
// Unset success and error flashdata
$this->session->unset_userdata('success');
$this->session->unset_userdata('error'); 
?>