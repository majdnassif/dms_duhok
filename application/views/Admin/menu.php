<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
    <?php if ($this->Permission->CheckPermissionOperation('admin_dashboard')) : ?>
      <li class="nav-item">
        <a href="<?= base_url('Admin/Dashboard'); ?>" class="nav-link <?php if ($class == 'admin' && $method == 'dashboard') {
                                                                        echo 'active';
                                                                      } ?>">
          <i class="nav-icon fa fa-tasks "></i>
          <p>

            <?= $this->Dictionary->GetKeyword('Dashboard'); ?>
            <!-- <span class="right badge badge-danger">New</span> -->
          </p>
        </a>
      </li>

    <?php endif; ?>
    <?php if ($this->Permission->CheckPermissionClass('systemconfigration')) : ?>
      <li class="nav-item <?php if ($class == 'systemconfigration') {
                            echo 'active menu-is-opening menu-open';
                          } ?>">
        <a href="#" class="nav-link <?php if ($class == 'systemconfigration') {
                                      echo 'active';
                                    } ?>">
          <i class="nav-icon fas fa-th"></i>
          <p>
            <?= $this->Dictionary->GetKeyword('System Configuration'); ?>

            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
        <?php if ($this->Permission->CheckPermissionOperation('systemconfigration_dictionary')) : ?>
            <li class="nav-item ">
              <a href="<?= base_url('SystemConfigration/Dictionary'); ?>" class="nav-link <?php if ($class == 'systemconfigration' && $method == 'dictionary') {
                                                                                            echo 'active';
                                                                                          } ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  <?= $this->Dictionary->GetKeyword('Translation List'); ?></p>
              </a>
            </li>
          <?php endif; ?>
          <?php if ($this->Permission->CheckPermissionOperation('systemconfigration_workflow')) : ?>
            <li class="nav-item ">
              <a href="<?= base_url('SystemConfigration/Workflow'); ?>" class="nav-link <?php if ($class == 'systemconfigration' && $method == 'workflow') {
                                                                                            echo 'active';
                                                                                          } ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  <?= $this->Dictionary->GetKeyword('workflow List'); ?></p>
              </a>
            </li>
          <?php endif; ?>


        </ul>
      </li>
    <?php endif; ?>

      <?php if (
          $this->Permission->CheckPermissionOperation('usersmanagement_userslist') ||
          $this->Permission->CheckPermissionOperation('usersmanagement_grouplist') ||
          $this->Permission->CheckPermissionOperation('usersmanagement_permission')
      ) : ?>
          <li class="nav-item <?php if ($class == 'usersmanagement') {
              echo 'active menu-is-opening menu-open';
          } ?>">
              <a href="#" class="nav-link <?php if ($class == 'usersmanagement') {
                  echo 'active';
              } ?>">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                      <?= $this->Dictionary->GetKeyword('Users Management'); ?>
                      <i class="right fas fa-angle-left"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview">

                  <?php if ($this->Permission->CheckPermissionOperation('usersmanagement_userslist')) : ?>
                      <li class="nav-item">
                          <a href="<?= base_url('UsersManagement/UsersList'); ?>" class="nav-link <?php if ($class == 'usersmanagement' && $method == 'userslist') {
                              echo 'active';
                          } ?>">
                              <i class="far fa-circle nav-icon"></i>
                              <p>
                                  <?= $this->Dictionary->GetKeyword('Users List'); ?></p>
                          </a>
                      </li>

                  <?php endif; ?>
                  <?php if ($this->Permission->CheckPermissionOperation('usersmanagement_groupslist')) : ?>
                      <li class="nav-item">
                          <a href="<?= base_url('UsersManagement/GroupsList'); ?>" class="nav-link <?php if ($class == 'usersmanagement' && $method == 'groupslist') {
                              echo 'active';
                          } ?>">
                              <i class="far fa-circle nav-icon"></i>
                              <p>
                                  <?= $this->Dictionary->GetKeyword('Groups List'); ?></p>
                          </a>
                      </li>

                  <?php endif; ?>
                  <?php if ($this->Permission->CheckPermissionOperation('usersmanagement_permission')) : ?>
                      <li class="nav-item">
                          <a href="<?= base_url('UsersManagement/Permission'); ?>" class="nav-link <?php if ($class == 'usersmanagement' && $method == 'permission') {
                              echo 'active';
                          } ?>">
                              <i class="far fa-circle nav-icon"></i>
                              <p>
                                  <?= $this->Dictionary->GetKeyword('Permissions'); ?></p>
                          </a>
                      </li>

                  <?php endif; ?>
              </ul>
          </li>

      <?php endif; ?>


    <?php if ($this->Permission->CheckPermissionClass('reports')) : ?>
      <li class="nav-item <?php if ($class == 'reports') {
                            echo 'active menu-is-opening menu-open';
                          } ?>">
        <a href="#" class="nav-link <?php if ($class == 'reports') {
                                      echo 'active';
                                    } ?>">
          <i class="nav-icon fas fa-chart-pie"></i>
          <p>

            <?= $this->Dictionary->GetKeyword('Reports'); ?>
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">


          <?php if ($this->Permission->CheckPermissionOperation('reports_usersbalances')) : ?>
            <li class="nav-item">
              <a href="<?= base_url('Reports/UsersBalances'); ?>" class="nav-link <?php if ($class == 'reports' && $method == 'usersbalances') {
                                                                                        echo 'active';
                                                                                      } ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  <?= $this->Dictionary->GetKeyword('Users Balances'); ?></p>
              </a>
            </li>

          <?php endif; ?>

        </ul>
      </li>

    <?php endif; ?>
  </ul>
</nav>