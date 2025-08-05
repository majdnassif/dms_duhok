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
      </div>
		  <footer class="main-footer">
    <div class="<?php if($this->UserModel->language()=="ENGLISH"){echo "float-right";}else{echo "float-left";}?> d-none d-sm-block">
      <b>Version</b> <?=sys_info()['version']?>
    </div>
    <strong>Copyright &copy; 2021-<?=date('Y')?> <a href="https://midyatech.com/">MidyaTech.com</a>.</strong> All rights reserved.
  </footer>
  
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
		</div>
<!-- ./wrapper -->

<!-- jQuery -->

<!-- Bootstrap 4 -->
<script src="<?=base_url('assets/');?>dist/Leaflet/leaflet.js?v=2"></script>

	<script src="<?=base_url('assets/');?>dist/Leaflet.markercluster/leaflet.markercluster-src.js?v=2"></script>
<script src="<?=base_url('assets/');?>tree/tree.js?v=3"></script>

<script src="<?=base_url('assets/');?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets/');?>dist/js/adminlte.min.js"></script>

<script src="<?=base_url('assets/');?>plugins/toastr/toastr.min.js"></script>


<!-- AdminLTE for demo purposes --><!-- 
<script src="<?=base_url('assets/');?>dist/js/demo.js"></script> -->
<!-- DataTables  & Plugins -->

<!-- <script src="<?=base_url('assets/')?>plugins/fullcalendar/main.js"></script> -->
<script src="<?=base_url('assets/');?>plugins/moment/moment.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/jszip/jszip.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?=base_url('assets/');?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?=base_url('assets/');?>dist/js/jquery.confirmModal.min.js"></script> 
<script src="<?=base_url('assets/');?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?=base_url('assets/')?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="<?=base_url('assets/')?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- test  -->
 <script src="<?=base_url('assets/');?>dist/js/pages/dashboard.js?v=6"></script> 
 <script src="<?=base_url('assets/plugins/jquery-validation/jquery.validate.min.js');?>"></script> 
<?php if(isset($output)):?>
			<?php foreach($js_files as $file): ?>
				<script src="<?php echo $file; ?>"></script>
			<?php endforeach; ?>
		<?php endif;?>

    <script src="<?=base_url('assets/');?>plugins/bootstrap-treeview/bootstrap-treeview.min.js"></script>
    <script src="<?=base_url('assets/');?>plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap Switch -->
<script src="<?=base_url('assets/');?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script>
      window.addEventListener('load', function() {
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
  }, false);
      $.fn.datepicker.defaults={
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom"
      };
      var Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: true
      });
      $defaultsConfirmModal={
                            confirmButton: "<?=$this->Dictionary->GetKeyword('Yes')?>",
                            cancelButton: "<?=$this->Dictionary->GetKeyword('No')?>"
                }
      function OpenTree(type_name,TextInputID,IDInputID,AllSelectable=0,ViewSection="extra-section", isCurrent=0){
                        $( "#"+ViewSection).html('<div class="modal-content" style="border-radius: 20px;" id="edit-section"><div class="modal-header"><h3 class="modal-title">Loading</h3><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body text-center"><div class="text-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading Please Wait...</div></div></div>');
                        if(ViewSection=="extra-section"){
                          $('#extra-modal').modal('show');
                        }
                        $.post("<?=base_url('Tree/AjaxLoadTree/');?>"+type_name+'/'+AllSelectable+'/'+isCurrent,{text_input_id:TextInputID,id_input_id:IDInputID,view_section:ViewSection},function(data){
                            $('#'+ViewSection).html(data);
                        });
                    }
      
     function GetNotifications(){
      $.ajax({
                    type: "GET",
                    url: "<?=base_url('Admin/AjaxNotification')?>",
                    success: function(response) {
                        response=JSON.parse(response);
                        if(response.count>0){
                          if(response.count!=$('#nt_count').html()){
                            toastr.success('You have new Notifications.', '',{"positionClass": "toast-bottom-right"});
                            ding();
                          }
                          
                          if(response.count!=$('#nt_count').html()){
                           $('#nt_count').html(response.count);
                           $('#nt_list').html('');
                           $.each(response.data, function(index) {
                             if(response.data[index].nt_link==''){
                              response.data[index].nt_link='#';
                             }
                            $('#nt_list').append('<a href="'+response.data[index].nt_link+'" onclick="$.get('+"'<?=base_url('Admin/AjaxReadNotification/')?>"+response.data[index].nt_id+"'"+')" class="dropdown-item"><i class="fas fa-envelope mr-2"></i>'+response.data[index].nt_title+'<span class="float-right text-muted text-sm">'+response.data[index].nt_create_date+'</span></a><div class="dropdown-divider"></div>');
                            toastr.options.onclick = function(e) {
                              window.location.replace(this.data.Link);
                              $.get('<?=base_url('Admin/AjaxReadNotification/')?>'+this.data.ID);
                            }

                            toastr.success(response.data[index].nt_title, '',{"positionClass": "toast-bottom-right","data":{"Link":response.data[index].nt_link,"ID":response.data[index].nt_id}});
                            });
                          } 
                        }else{
                          $('#nt_list').html('<a href="#" class="dropdown-item dropdown-footer">There are No Notifications</a>');
                          $('#nt_count').html(0);
                        }
                    }
                });
     }
     function GetWaitingTickets(){
      $( "#extra-section").html('<div class="modal-content" style="border-radius: 20px;" id="edit-section"><div class="modal-header"><h3 class="modal-title">Loading</h3><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body text-center"><div class="text-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading Please Wait...</div></div></div>');
                $.get( '<?=base_url('QueList/AjaxQueWaitingList')?>', function( data ) {
                  $( "#extra-section").html( data );
                });
     }
        function AddNewOrder(){
          $("#extra-section").html('<div class="modal-content" style="border-radius: 20px;" id="edit-section"><div class="modal-header"><h3 class="modal-title">Loading</h3><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body text-center"><div class="text-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading Please Wait...</div></div></div>');
              $.get('<?= base_url('Orders/AjaxAddOrder/') ?>', function(data) {
                $("#extra-section").html(data);
              });
        }
     function LoadClientInfo(client_id){
           $.get('<?=base_url('Orders/AjaxLoadClientInfo/')?>'+client_id,function(data){
            if(data.client_address_1){
              $('#client_address_1').val(data.client_address_1);
            }
            if(data.client_address_2){
              $('#client_address_2').val(data.client_address_2);
            }
            if(data.client_comments){
              $('#client_comments').val(data.client_comments);
            }
            if(data.client_mobile_1){
              $('#client_mobile_1').val(data.client_mobile_1);
            }
            if(data.client_mobile_2){
              $('#client_mobile_2').val(data.client_mobile_2);
            }
            if(data.client_name){
              $('#client_name').val(data.client_name);
            }
            if(data.client_profile){
              $('#client_profile').val(data.client_profile);
            }
            if(data.client_region_id){
              $('#client_region_id').val(data.client_region_id);
              $('#client_region_id').trigger('change');
            }
            if(data.client_platform_id){
              $('#client_platform_id').val(data.client_platform_id);
              $('#client_platform_id').trigger('change');
            }
            if(data.client_id){
              $('#client_id').val(data.client_id);
            }
            // make lable_client_profile a tag and href="<?=base_url('Client/Clientinfo/')?>" client_id
            var html=$('#label_client_profile').text();
            console.log(html);
            $('#label_client_profile').html('<a href="<?=base_url('/Clients/ClientDetails/')?>'+data.client_id+'">'+html+'</a>');
            }) 
        }
        GetNotifications();
        setInterval(function(){ 
        GetNotifications();
}, 30000);


</script>

</body>
</html>