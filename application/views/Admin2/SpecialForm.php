
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Print Document</title>
    <link href="print/css/print.css" rel="stylesheet" type="text/css">
    <style>
        .boarded {
            border: 1px solid black;
            text-align: right;
            padding-right: 6px;
            height: 25px;
        }

        .title-cell{
            /*padding: 0px 12px;*/
            font-weight: bold;
        }
        td.head {
            background-color: #fff;
            height: 20px;
        }
        td.note {
            background-color: #fff;
            width: 50%;
            height: 260px;
        }

        /*#row_book_info_header {*/
        /*    line-height: 0px;*/
        /*}*/

    </style>
</head>

<body onload="window.print();">
<?php for($i=1; $i<=$special_form['page_number']; $i++):?>
 <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="print">
    <tr>
        <td><table width="800" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td><img src="<?= base_url('assets/dist/img/SpecialForm/special_form_1.png')?>" width="166" height="158" alt="">
                        <img src="<?= base_url('assets/dist/img/SpecialForm/special_form_2.png')?>" width="456" height="158" alt=""></td>
                    <td>&nbsp;</td>
                    <td><img src="<?= base_url('assets/dist/img/SpecialForm/special_form_3.png')?>" width="166" height="158" alt=""></td>
                </tr>
            </table></td>
    </tr>

    <tr>

        <td><table width="800" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td  align="right"><h3 style="    margin: 0 auto !important;"> <?=$import['import_code']?> : <?= $this->Dictionary->GetKeyword('Book Info');  ?></h3></td>
<!--                    <td width="700"  align="center" colspan="3">--><?php //=$import['import_code']?><!--</td>-->

                </tr>
            </table>
        </td>
    </tr>

    <tr align="center">
        <td >
            <table width="760"  cellspacing="0" cellpadding="0">
                <tr id="row_book_info_header" >
                    <td width="700" class="boarded" align="center" colspan="3" ><?=$import['import_from_department']?></td>
                    <td width="100" class="boarded title-cell"> <?= $this->Dictionary->GetKeyword('From Department'); ?></td>
                </tr>

                <tr id="row_book_info_header" >
                    <td width="700" class="boarded" align="center" colspan="3"><?=$import['import_to_department']?></td>
                    <td width="100" class="boarded title-cell"> <?= $this->Dictionary->GetKeyword('To Department'); ?></td>
                </tr>

                <tr id="row_book_info_header" >
                    <td width="300" class="boarded" align="center"><?=$import['import_book_date']?></td>
                    <td width="100" class="boarded title-cell"> <?= $this->Dictionary->GetKeyword('Book Date'); ?></td>
                    <td width="300" class="boarded" align="center"><?=$import['import_book_number']?></td>
                    <td width="100" class="boarded title-cell"> <?= $this->Dictionary->GetKeyword('Book Number'); ?></td>
                </tr>

<!--                <tr id="row_book_info_header" >-->
<!---->
<!--                    <td width="300" class="boarded" align="center">--><?php //=$import['import_code']?><!--</td>-->
<!--                    <td width="100" class="boarded title-cell"><h3>--><?php //= $this->Dictionary->GetKeyword('Code'); ?><!--</h3></td>-->
<!--                   -->
<!--                    <td width="300" class="boarded" align="center">--><?php //=$import['import_book_subject']?><!--</td>-->
<!--                    <td width="100" class="boarded title-cell"><h3>Subject</h3></td>-->
<!--                </tr>-->

                <tr id="row_book_info_header" >
                    <td width="700" class="boarded" align="center" colspan="3"><?=$import['import_book_subject']?></td>
                    <td width="100" class="boarded title-cell"> <?= $this->Dictionary->GetKeyword('Subject'); ?></td>
                </tr>

                <tr id="row_book_info_header" >
                    <td width="300" class="boarded" align="center"><?=$import['import_received_date']?></td>
                    <td width="150" class="boarded title-cell"> <?= $this->Dictionary->GetKeyword('Received Date'); ?></td>

                    <td width="300" class="boarded" align="center"><?=$import['import_incoming_number']?></td>
                    <td width="100" class="boarded title-cell"> <?= $this->Dictionary->GetKeyword('Incoming Number'); ?></td>


                </tr>




            </table>
        </td>

    </tr>

    <tr>
        <td><table width="800" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td  align="right"><h3> : <?= $this->Dictionary->GetKeyword('Deliver Book To'); ?></h3></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td>
            <table border="1" width="100%" cellpadding="5" cellspacing="0" style="direction:rtl" class="content">

                <tr>
                    <td class="head"><?= $special_form['start_from_block'] + 1?></td>
                    <td class="head"><?= $special_form['start_from_block']  + 2?></td>
                </tr>
                <tr>
                    <td class="note"></td>
                    <td class="note"></td>
                </tr>
                <tr>
                    <td class="head"><?= $special_form['start_from_block']  + 3?></td>
                    <td class="head"><?= $special_form['start_from_block']  + 4?></td>
                </tr>
                <tr>
                    <td class="note"></td>
                    <td class="note"></td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td style="direction:rtl;padding:10px;">
            تێبینی:
            &nbsp;1.       بۆ هەموو پەراوێزێك راو روونکردنەوە بە روونی و بەکورتی بنوسرێت.
            &nbsp;2.       نوسراو یان یاداشت نابێت لە سەری بنوسرێت.
            &nbsp;3.       لەژێر پەراوێز ئاماژە بە هاوپێچ بکرێ ئەگەر هەبوو.
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
<?php
    $special_form['start_from_block'] = $special_form['start_from_block'] + 4;
endfor;?>

</body>
</html>

