<style>
    .inbox_totla_bueget{
        margin-left: 5px
    }
</style>
<ul class="menu accordion-menu">

    <?php if ($this->Permission->CheckPermissionOperation('admin_dashboard')) : ?>
        <li class=" load_overlay <?php if ($class == 'admin' && $method == 'dashboard') { echo 'active'; } ?>">
            <a href="<?= base_url('Admin/Dashboard'); ?>" class="waves-effect waves-button ">
                <span class="menu-icon glyphicon glyphicon-home"></span>
                <p><?= $this->Dictionary->GetKeyword('Dashboard'); ?></p>
            </a>
        </li>
    <?php endif; ?>

    <?php if ($this->Permission->CheckPermissionOperation('admin_reports')) : ?>
        <li class="load_overlay <?php if ($class == 'admin' && $method == 'reports') { echo 'active'; } ?>">
            <a href="<?= base_url('Admin/Reports'); ?>" class="waves-effect waves-button">
                <span class="menu-icon glyphicon glyphicon-stats"></span>
                <p><?= $this->Dictionary->GetKeyword('Reports'); ?></p>
            </a>
        </li>
    <?php endif; ?>

    <?php if ($this->Permission->CheckPermissionClass('inbox')) :?>
        <li class="droplink <?php if ($class == 'inbox') { echo 'active open'; } ?>">
            <a href="#" class="waves-effect waves-button">
                <span class="menu-icon glyphicon glyphicon-envelope"></span>
                <p >
                    <span class="inbox_budget"><?= $this->Dictionary->GetKeyword('Inbox'); ?></span>
                </p>

                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <!--        <li class="--><?php //if ($class == 'inbox' && $method == 'list' && empty($this->uri->segment(3))) { echo 'active'; } ?><!--">-->
                <!--          <a href="--><?php //= base_url('Inbox/List'); ?><!--">-->
                <!--            --><?php //= $this->Dictionary->GetKeyword('All'); ?>
                <!--            -->
                <!--            <span class="badge">--><?php //= $unread_count . '/' . $total_count; ?><!--</span>-->
                <!--          </a>-->
                <!--        </li>-->
                <?php $import_trace_type_receive = ['import_trace_type_id' => -1, 'import_trace_type_name' => 'received']; ?>
                <!--        --><?php //$import_trace_type= array_merge($import_trace_type, $this->Get_info->select('import_trace_type')); ?>

                <li class="load_overlay <?php if ($class == 'inbox' && $method == 'list' && $this->uri->segment(3) == $import_trace_type_receive['import_trace_type_id']) { echo 'active'; } ?>">
                    <a href="<?= base_url('Inbox/List/'.$import_trace_type_receive['import_trace_type_id']); ?>">
                        <?= $this->Dictionary->GetKeyword($import_trace_type_receive['import_trace_type_name']); ?>
                        <?php
                        $received_totals = $this->InboxModel->getReceivedTotals();
                        $show_totals = number_format($received_totals['unread'], '0', '.', ',' ). ' / ' . number_format($received_totals['total'], '0', '.', ',' );
                        //                  $type_all_count =  $this->InboxModel->GetTotalCount($import_trace_type_receive['import_trace_type_id']);
                        //
                        //                  $show_totals = $type_all_count;
                        //                      $type_unread_count =  $this->InboxModel->GetUnreadCount($import_trace_type_receive['import_trace_type_id']);
                        //                      $show_totals = $type_unread_count . '/' . $show_totals ;
                        ?>
                        <span class="badge"><?= $show_totals; ?></span>
                    </a>
                </li>

                <?php $import_trace_type = $this->InboxModel->GetTotalCountForAll(); ?>
                <?php foreach ($import_trace_type as $trace_type) : ?>
                    <li class="load_overlay <?php if ($class == 'inbox' && $method == 'list' && $this->uri->segment(3) == $trace_type['import_trace_type_id']) { echo 'active'; } ?>">
                        <a href="<?= base_url('Inbox/List/'.$trace_type['import_trace_type_id']); ?>">
                            <?= $this->Dictionary->GetKeyword($trace_type['import_trace_type_name']); ?>
                            <span class="badge"><?=  number_format($trace_type['total'], '0', '.', ',' )  ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
    <?php endif; ?>

    <?php if ($this->Permission->CheckPermissionClass('import')) : ?>
        <li class="droplink <?php if ($class === 'import') { echo 'active open'; } ?>">
            <a href="#" class="waves-effect waves-button">
                <span class="menu-icon glyphicon glyphicon-import"></span>
                <p><?= $this->Dictionary->GetKeyword('Import'); ?></p>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">

                <?php if ($this->Permission->CheckPermissionOperation('import_add')) : ?>
                    <li class="load_overlay <?php if ($class === 'import' && $method === 'add') { echo 'active'; } ?>">
                        <a href="<?= base_url('Import/Add'); ?>">
                            <?= $this->Dictionary->GetKeyword('Add New'); ?>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($this->Permission->CheckPermissionOperation('import_list')) : ?>
                    <li class="load_overlay <?php if ($class === 'import' && $method === 'list') { echo 'active'; } ?>">
                        <a href="<?= base_url('Import/List'); ?>">
                            <?= $this->Dictionary->GetKeyword('List'); ?>
                        </a>
                    </li>
                <?php endif; ?>
                <?php

                if ($this->Permission->CheckPermissionOperation('out_remotelist')) :
                    foreach (RemoteConnectionMapperHelper::all() as $branch_id => $location_info) : ?>
                        <li class="load_overlay <?php if ($class === 'Out' && $method === 'ajax_remote_list') { echo 'active'; } ?>">
                            <a href="<?= base_url('Out/RemoteList/'). $branch_id; ?>">
                                <?= $this->Dictionary->GetKeyword('Imports') . ' '.$this->Dictionary->GetKeyword($location_info['name']) ; ?>
                            </a>
                        </li>
                    <?php endforeach;
                endif; ?>


                ?>

            </ul>
        </li>
    <?php endif; ?>



    <?php if ($this->Permission->CheckPermissionClass('out')) : ?>
        <li class="droplink <?php if ($class === 'out') { echo 'active open'; } ?>">
            <a href="#" class="waves-effect waves-button">
                <span class="menu-icon glyphicon glyphicon glyphicon-export"></span>
                <p><?= $this->Dictionary->GetKeyword('Out'); ?></p>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <?php if ($this->Permission->CheckPermissionOperation('out_add')) : ?>
                    <li class="load_overlay <?php if ($class === 'out' && $method === 'add') { echo 'active'; } ?>">
                        <a href="<?= base_url('Out/Add'); ?>">
                            <?= $this->Dictionary->GetKeyword('Add New'); ?>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($this->Permission->CheckPermissionOperation('out_list')) : ?>
                    <li class="load_overlay <?php if ($class === 'out' && $method === 'list') { echo 'active'; } ?>">
                        <a href="<?= base_url('Out/List'); ?>">
                            <?= $this->Dictionary->GetKeyword('List'); ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>


    <?php if ($this->Permission->CheckPermissionClass('settings')) : ?>
        <li class="load_overlay <?php if ($class == 'settings') { echo 'active'; } ?>">
            <a href="<?= base_url('Settings/Index'); ?>" class="waves-effect waves-button">
                <span class="menu-icon glyphicon glyphicon-wrench"></span>
                <p><?= $this->Dictionary->GetKeyword('Settings'); ?></p>
            </a>
        </li>
    <?php endif; ?>

    <?php if (
        $this->Permission->CheckPermissionOperation('usersmanagement_userslist') ||
        $this->Permission->CheckPermissionOperation('usersmanagement_groupslist') ||
        $this->Permission->CheckPermissionOperation('usersmanagement_permission')
    ) : ?>
        <li class="droplink <?php if ($class === 'usersmanagement') { echo 'active open'; } ?>">
            <a href="" class="waves-effect waves-button">
                <span class="menu-icon glyphicon glyphicon-user"></span>
                <p><?= $this->Dictionary->GetKeyword('Users Management'); ?></p>
                <span class="arrow"></span>
            </a>

            <ul class="sub-menu">
                <?php if ($this->Permission->CheckPermissionOperation('usersmanagement_userslist')) : ?>
                    <li class="<?php if ($class === 'usersmanagement' && $method === 'userslist') { echo 'active'; } ?>"><a href="<?= base_url('UsersManagement/UsersList'); ?>"><?= $this->Dictionary->GetKeyword('Users List'); ?></a></li>
                <?php endif; ?>
                <?php if ($this->Permission->CheckPermissionOperation('usersmanagement_groupslist')) : ?>
                    <li class="<?php if ($class === 'usersmanagement' && $method === 'groupslist') { echo 'active'; } ?>"><a href="<?= base_url('UsersManagement/GroupsList'); ?>"><?= $this->Dictionary->GetKeyword('Groups List'); ?></a></li>
                <?php endif; ?>
                <?php if ($this->Permission->CheckPermissionOperation('usersmanagement_permission')) : ?>
                    <li class="<?php if ($class === 'usersmanagement' && $method === 'permission') { echo 'active'; } ?>"><a href="<?= base_url('UsersManagement/Permission'); ?>"><?= $this->Dictionary->GetKeyword('Permissions'); ?></a></li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>
</ul>

<script>
    $(document).ready(function () {
        // when click on a "$('.overlay').css('display', 'flex');
        $('.load_overlay').on('click', function () {
            $('.overlay').css('display', 'flex');
        });
    });
</script>