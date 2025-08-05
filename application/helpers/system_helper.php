<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('CURRENCY'))
{
    function CURRENCY($number)
    {
        return sys_info()['base_currency'].' '.number_format($number,0,'.',',');
    }   
}
if ( ! function_exists('NUMBER'))
{
    function NUMBER($number)
    {
        return number_format($number,0,'.',',');
    }   
}
if ( ! function_exists('sys_info'))
{
    function sys_info()
    {
        return array(
            'title'=>'DMS Duhok',
            'name'=>'DMS Duhok',
            'logo'=>base_url('assets/dist/img/MidyaLogo.png'),
            'login_logo'=>base_url('assets/login/images/logo-300.png'),
            'sidebar_footer'=>base_url('assets/dist/img/Midya/MidyaLogo.png'),
            'gov_logo' => base_url('assets/dist/img/krg_logo_svg.svg'),
            'base_currency'=>'IQD',
            'version'=>'2.4'
        );
    }   
}
if ( ! function_exists('lang_array'))
{
    function lang_array()
    {
        return array(
            'ENGLISH'=>'English',
            'ARABIC'=>'Arabic',
            'KURDISH'=>'Kurdish'
        );
    }   
}
if ( ! function_exists('DataTableBuilder'))
{
    function DataTableBuilder($table_id,$ajax_url,$cols,$filter_fields)
    {
        $CI =& get_instance();
        $array=[];
        $header='';
        $filter='';
        $JSCols='';
        foreach($cols as $col){
            $header.='<th>'.$CI->Dictionary->GetKeyword($col).'</th>';
            $JSCols.='{data:\''.$col.'\',class:"text-center"},';
        }
        $array['html']='<table class="table table-striped" id="'.$table_id.'">
                <thead>
                    <tr>'.$header.'</tr>
                </thead>
            </table>
        </div>';
        
        $fields='<form onsubmit="return false;">
        <div class="row">';
        foreach($filter_fields as $field){
            if($field['type']=='select'){
                //select field array('type'=>'select','name'=>'name','id'=>'id','label'=>'label','list'=>array(),'list_id'=>'id','list_name'=>'name',)
                $fields.='<div class="form-group col-xl-3 col-md-4 col-sm-6 col-xs-12">
                <label>'.$CI->Dictionary->GetKeyword($field['label']).'</label>
                <select class="form-control select2" id="'.$field['id'].'" name="'.$field['name'].'"  >
                <option value="">'.$CI->Dictionary->GetKeyword('Select_'.$field['label']).'</option>';
                foreach($field['list'] as $key=>$value){
                    if($field['translate']==true){
                        $list_name=$CI->Dictionary->GetKeyword($value[$field['list_name']]);
                    }else{
                        $list_name=$value[$field['list_name']];
                    }
                    $fields.='<option value="'.$value[$field['list_id']].'">'.$list_name.'</option>';
                }
                $fields.='</select>
                </div>';
                $filter.=$field['name'].':$(\'#'.$field['id'].'\').val(),';
            }elseif($field['type']=='number'){
                //number field array('type'=>'number','name'=>'name','id'=>'id','label'=>'label','min'=>'0','max'=>'100')
                $fields.='<div class="form-group col-xl-3 col-md-4 col-sm-6 col-xs-12">
                <label>'.$CI->Dictionary->GetKeyword($field['label']).'</label>
                <input type="number" class="form-control" id="'.$field['id'].'" name="'.$field['name'].'" min="'.$field['min'].'" max="'.$field['max'].'">
                </div>';
                $filter.=$field['name'].':$(\'#'.$field['id'].'\').val(),';
            }elseif($field['type']=='date'){
                //date field array('type'=>'date','name'=>'name','id'=>'id','label'=>'label','min'=>'2020-01-01','max'=>'2020-12-31')
                $fields.='<div class="form-group col-xl-3 col-md-4 col-sm-6 col-xs-12">
                <label>'.$CI->Dictionary->GetKeyword($field['label']).'</label>
                <input data-date-format="yyyy-mm-dd" style="direction: ltr !important;" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask inputmode="numeric" autocomplete="off" data-provide="datepicker" type="text" class="form-control" id="'.$field['id'].'" name="'.$field['name'].'">
                </div>';
                $filter.=$field['name'].':$(\'#'.$field['id'].'\').val(),';
            }elseif($field['type']=='hidden'){
                //hidden field array('type'=>'hidden','name'=>'name','id'=>'id','value'=>'value')
                $fields.='<input type="hidden" class="form-control" id="'.$field['id'].'" name="'.$field['name'].'" value="'.$field['value'].'">';
                $filter.=$field['name'].':$(\'#'.$field['id'].'\').val(),';
            }elseif($field['type']=='tree'){
                //text field array('type'=>'text','name'=>'name','id'=>'id','label'=>'label',onclick=>'function(){}')
                $fields.='<div class="form-group col-xl-6 col-md-4 col-sm-6 col-xs-12">
                <label>'.$CI->Dictionary->GetKeyword($field['label']).'</label>
                <input type="text" class="form-control" id="'.$field['id'].'" name="'.$field['name'].'" onclick="'.$field['onclick'].'" readonly>
                </div>';
                $filter.=$field['name'].':$(\'#'.$field['id'].'\').val(),';
            }
            elseif($field['type'] == 'custom_html' ){
                $fields.= $field['content'];

                if (!empty($field['inputs'])) {
                    foreach ($field['inputs'] as $input) {
                        $inputId = $input['id'];
                        $inputName = $input['name'];
                        $inputType = isset($input['type']) ? $input['type'] : 'text';

                        if ($inputType === 'checkbox'  ) {
                            $filter .= $inputName . ':$(\'#' . $inputId . '\').is(":checked"),';
                        }
                        else if ( $inputType  === 'checkbox_group' ) {
                            $filter .= $inputName . ':$(\'input[name="' . $inputName . '"]:checked\').map(function() { return $(this).val(); }).get().join(","),';
                        }
                        else if($inputType === 'select'){
                            $filter .= $inputName . ':$(\'#' . $inputId . '\').val(),';
                        }
                        else if($inputType === 'radio'){
                            $filter .= $inputName . ':$(\'input[name="' . $inputName . '"]:checked\').val(),';
                        } else{
                            $filter .= $inputName . ':$(\'#' . $inputId . '\').val(),';
                        }
                    }
                }
            }
            else{
                //text field array('type'=>'text','name'=>'name','id'=>'id','label'=>'label')
                $fields.='<div class="form-group col-xl-3 col-md-4 col-sm-6 col-xs-12">
                <label>'.$CI->Dictionary->GetKeyword($field['label']).'</label>
                <input type="text" class="form-control" id="'.$field['id'].'" name="'.$field['name'].'">
                </div>';
                $filter.=$field['name'].':$(\'#'.$field['id'].'\').val(),';
            }
        }
        $fields.='<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <button id="Filter-btn" type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> '.$CI->Dictionary->GetKeyword('Search').'</button>
                    <button type="reset" class="btn btn-default"><i class="fa fa-eraser" aria-hidden="true"></i> '.$CI->Dictionary->GetKeyword('Reset Filter').'</button>
                </div>
            </div>
        </form>';
        
        $array['fields']=$fields;
        $array['js']='
        <script>
        var table;
        window.addEventListener("DOMContentLoaded", function() {
            initializeDataTable();
        });
        
        function initializeDataTable() {
            if (typeof $.fn.DataTable !== "undefined") {
                console.log("DataTables loaded. Initializing...");
                $("[data-mask]").inputmask();
                
                // Initialize with optimized settings
                table = $("#'.$table_id.'").DataTable({
                    searching: false,
                    ordering: true,
                    order: [[0, "desc"]],
                    paging: true,
                    responsive: false,
                    processing: true,
                    serverSide: true,
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    ajax: {
                        url: "'.$ajax_url.'",
                        dataType: "json",
                        type: "POST",
                        data: function(d) {
                            return $.extend({}, d, {'.$filter. '})
                        }
                    },
                    columns: [
                        ' .$JSCols.'
                    ],
                    dom: "<\'row\'<\'col-sm-12 col-md-6\'l><\'col-sm-12 col-md-6 button-datatable text-right\'B>>" +"<\'row\'<\'col-sm-12\'tr>>" +"<\'row\'<\'col-sm-12 col-md-4\'i><\'col-sm-12 col-md-8\'p>>",
                    dataSrc: "data",
                    language: { 
                        processing: \'<div class="text-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading Please Wait...</div>\'
                    },
                });
                
                // Setup Filter button
                $("#Filter-btn").on("click", function() {
                    $(this).prop("disabled", true);
                    $(this).html(\'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '.$CI->Dictionary->GetKeyword('Loading').' \');
                    table.draw();
                    
                    // Re-enable button after draw completes
                    table.one("draw", function() {
                        $("#Filter-btn").html(\'<i class="fa fa-search" aria-hidden="true"></i> '.$CI->Dictionary->GetKeyword('Search').'\');
                        $("#Filter-btn").prop("disabled", false);
                    });
                });
            } else {
                // If DataTables isn\'t loaded yet, try again after a short delay
                console.log("DataTables not loaded yet. Trying again in 100ms...");
                setTimeout(initializeDataTable, 100);
            }
        }
        </script>';        
        return $array;
    }   
}
?>