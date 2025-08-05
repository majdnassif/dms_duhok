<?php if (isset($page_title)) : ?>
  <div class="page-title">
    <h3><?= $this->Dictionary->GetKeyword($page_title); ?></h3>
    <div class="page-breadcrumb">
      <ol class="breadcrumb">
        <li><a href="<?= base_url(); ?>"><?= $this->Dictionary->GetKeyword('Home') ?></a></li>
        <li class="active"><?= $this->Dictionary->GetKeyword($page_title); ?></li>
      </ol>
    </div>
  </div>
    <div id="main-wrapper">
      <div class="row">
          <div class="col-lg-12 col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading">
                <h4 class="panel-title"><?= $this->Dictionary->GetKeyword('Delaying Departments'); ?></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive project-stats">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><?= $this->Dictionary->GetKeyword('Department'); ?></th>
                            <th><?= $this->Dictionary->GetKeyword('Avg Time'); ?></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($departmenst_delay_to_clos as $index => $department) : ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <th scope="row"><?= $department['name']; ?></th>
                                <td class="reprots_delay_time_value"><?php if($department['avg_time_to_close'] > 90) {
                                       echo '<span class="label label-danger">' . $department['avg_time_formatted'] .'</span>' ;
                                    }
                                    else if($department['avg_time_to_close'] > 30) {
                                        echo '<span class="label label-warning">' . $department['avg_time_formatted'] .'</span>' ;
                                    }
                                    else {
                                        echo '<span class="label label-info">' . $department['avg_time_formatted'] .'</span>' ;
                                    }

                                        ?></td>

                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
      </div>
    </div>

<?php endif; ?>