<?php if (isset($page_title)): ?>
  <div class="page-title">
    <h3><?= $page_title; ?></h3>
    <div class="page-breadcrumb">
      <ol class="breadcrumb">
        <li><a href="<?= base_url(); ?>"><?= $this->Dictionary->GetKeyword('Home'); ?></a></li>
        <li><a href="<?= base_url('Settings'); ?>"><?= $this->Dictionary->GetKeyword('System Settings'); ?></a></li>
        <li><a href="<?= base_url('Settings/listItems/' . $table); ?>"><?= $config['title']; ?></a></li>
        <li class="active"><?= $page_title; ?></li>
      </ol>
    </div>
  </div>
<?php endif; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= $page_card_title ?? $page_title; ?></h3>
                </div>
                <div class="panel-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?= $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?= validation_errors('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>', '</div>'); ?>
                    
                    <?php 
                    // Determine if we're editing (item is set) or adding new
                    $is_edit = isset($item);
                    $form_action = $is_edit 
                        ? base_url('Settings/editItem/' . $table . '/' . $item[$config['primary_key']])
                        : base_url('Settings/addItem/' . $table);
                    ?>
                    
                    <form action="<?= $form_action; ?>" method="POST">
                        <?php foreach ($config['fields'] as $field_name => $field_config): ?>
                            <div class="form-group">
                                <label for="<?= $field_name; ?>">
                                    <?= $this->Dictionary->GetKeyword($field_config['label']); ?>
                                    <?php if (!empty($field_config['required'])): ?>
                                        <span class="text-danger">*</span>
                                    <?php endif; ?>
                                </label>
                                
                                <?php
                                // Get field value for edit mode
                                $field_value = $is_edit ? $item[$field_name] : '';
                                // Override with post value if form was submitted with validation errors
                                $field_value = set_value($field_name, $field_value);
                                
                                // Determine field type and render appropriate input
                                switch ($field_config['type']):
                                    case 'textarea': 
                                ?>
                                    <textarea 
                                        class="form-control" 
                                        id="<?= $field_name; ?>" 
                                        name="<?= $field_name; ?>"
                                        rows="4"
                                        <?= !empty($field_config['required']) ? 'required' : ''; ?>
                                    ><?= $field_value; ?></textarea>
                                <?php break; default: // Default to text input ?>
                                    <input 
                                        type="<?= $field_config['type']; ?>" 
                                        class="form-control" 
                                        id="<?= $field_name; ?>" 
                                        name="<?= $field_name; ?>" 
                                        value="<?= $field_value; ?>"
                                        <?= !empty($field_config['required']) ? 'required' : ''; ?>
                                    >
                                <?php endswitch; ?>
                                
                                <?php if (!empty($field_config['help'])): ?>
                                    <small class="form-text text-muted">
                                        <?= $this->Dictionary->GetKeyword($field_config['help']); ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <?= $is_edit 
                                    ? $this->Dictionary->GetKeyword('Update') 
                                    : $this->Dictionary->GetKeyword('Save'); 
                                ?>
                            </button>
                            <a href="<?= base_url('Settings/listItems/' . $table); ?>" class="btn btn-default">
                                <?= $this->Dictionary->GetKeyword('Cancel'); ?>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.mt-4 {
  margin-top: 1.5rem;
}
</style> 