<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-vk" data-toggle="tooltip" title="<?php echo $button_get_token; ?>" class="btn btn-primary vk-btn-lh js-vk-btn"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-body">
        <form id="form-vk" action="<?php echo $action; ?>" method="post" class="form-horizontal js-vk-form">
          <fieldset>
            <legend><?php echo $text_authorization; ?></legend>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="vk_oath_id_application"><?php echo $text_id_application; ?></label>
              <div class="mb-10 col-lg-4 col-md-6 col-sm-10">
                <input id="vk_oath_id_application" type="text" name="vk_oath_id_application" value="<?php echo $vk_oath_id_application; ?>" class="form-control js-vk-empty">
                <?php if ($error_id_application) { ?>
                <div class="text-danger"><?php echo $error_id_application; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="vk_oath_secret_key"><?php echo $text_secret_key; ?></label>
              <div class="col-lg-4 col-md-6 col-sm-10">
                <input id="vk_oath_secret_key" type="text" name="vk_oath_secret_key" value="<?php echo $vk_oath_secret_key; ?>" class="form-control js-vk-empty">
                <?php if ($error_secret_key) { ?>
                <div class="text-danger"><?php echo $error_secret_key; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="vk_oath_id_group"><?php echo $text_id_group; ?></label>
              <div class="col-lg-4 col-md-6 col-sm-10">
                <input id="vk_oath_id_group" type="text" name="vk_oath_id_group" value="<?php echo $vk_oath_id_group; ?>" class="form-control js-vk-empty">
                <?php if ($error_id_group) { ?>
                <div class="text-danger"><?php echo $error_id_group; ?></div>
                <?php } ?>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>