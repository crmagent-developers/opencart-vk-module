<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="button" id="import-offer" data-toggle="tooltip" title="<?php echo $button_import_offer; ?>"
                class="btn btn-success btn-size" style="margin-right: 20px"><i class="fa fa-arrow-circle-down"></i></button>
        <button type="submit" form="form-vk" data-toggle="tooltip" title="<?php echo $button_save; ?>"
                class="btn btn-primary btn-size"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
           class="btn btn-default btn-size"><i class="fa fa-reply"></i></a>
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
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $text_general_tab; ?></a></li>
            <li><a href="#tab-references" data-toggle="tab"><?php echo $text_references_tab; ?></a></li>
            <li><a href="#tab-catalog" data-toggle="tab"><?php echo $text_catalog_tab; ?></a></li>
            <li><a href="#tab-logs" data-toggle="tab"><?php echo $text_logs_tab; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <fieldset>
                <?php
                  if(!isset($vk_event_status)) {
                    $vk_event_status = 0;
                  }
                ?>
                <legend><?php echo $text_vk_event_legend; ?></legend>
                <div class="">
                  <label class="col-sm-4 control-label"><?php echo $text_event_title; ?></label>
                  <button type="button" id="vk-event-on" data-toggle="tooltip"
                          class="btn btn-primary <?php if($vk_event_status == 1){ echo 'hidden'; } ?>"
                          style="font-weight: bold"><?php echo $button_on; ?></button>
                  <button type="button" id="vk-event-off" data-toggle="tooltip"
                          class="btn btn-danger <?php if($vk_event_status == 0){ echo 'hidden'; } ?>"
                          style="font-weight: bold"><?php echo $button_off; ?></button>
                </div>
              </fieldset>
            </div>
            <div class="tab-pane" id="tab-references">
              <fieldset>
                <legend><?php echo $text_status_legend; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $text_status_title; ?></label>
                  <div class="col-sm-10">
                    <?php foreach ($statuses['vk'] as $code => $name): ?>
                    <div class="row vk_unit">
                      <div class="col-lg-4 col-md-6 col-sm-6">
                        <select id="vk_settings_status_<?php echo $code; ?>" name="vk_settings_status[<?php echo $code; ?>]"
                                class="form-control">
                          <?php foreach ($statuses['opencart'] as $status): ?>
                          <?php $uid = $status['order_status_id']?>
                          <option value="<?php echo $uid;?>"
                          <?php if(isset($saved_settings['vk_settings_status'][$code]) && $uid == $saved_settings['vk_settings_status'][$code]):?>
                          selected="selected"<?php endif;?>>
                          <?php echo $status['name'];?>
                          </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="col-lg-4 col-md-6 col-sm-6">
                        <label class="control-label" style="text-align:left!important;"
                               for="vk_settings_status_<?php echo $code; ?>"><?php echo $name; ?></label>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </div>
                <legend><?php echo $text_delivery_legend; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $text_delivery_title; ?></label>
                  <div class="col-sm-10">
                    <div class="row">
                      <?php if ($delivery['opencart']) :?>
                      <?php foreach($delivery['vk'] as $code => $title): ?>
                      <div class="col-sm-12" style="margin-bottom:10px;">
                          <div class="row vk_unit">
                            <div class="col-lg-4 col-md-6 col-sm-6">
                              <select id="vk_settings_delivery_<?php echo $code; ?>"
                                      name="vk_settings_delivery[<?php echo $code; ?>]" class="form-control">
                                <option value="not_delivery"
                                <?php if(isset($saved_settings['vk_settings_delivery'][$code]) && 'not_delivery' == $saved_settings['vk_settings_delivery'][$code]):?>
                                selected="selected"<?php endif;?>>
                                <?php echo $text_not_delivery;?>
                                </option>

                                <?php foreach ($delivery['opencart'] as $value): ?>
                                <?php unset($value['title']); ?>
                                  <?php foreach ($value as $key => $val): ?>
                                    <?php $code_oc = $key; ?>
                                    <?php $title_oc = $val['title'] ?>
                                  <?php endforeach; ?>

                                <option value="<?php echo $code_oc; ?>"
                                <?php if(isset($saved_settings['vk_settings_delivery'][$code]) && $code_oc == $saved_settings['vk_settings_delivery'][$code]):?>
                                selected="selected"<?php endif;?>>
                                <?php echo $title_oc;?>
                                </option>

                                <?php endforeach; ?>
                              </select>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                              <label class="control-label" style="text-align:left!important;"
                                     for="vk_settings_delivery_<?php echo $code; ?>"><?php echo $title; ?></label>
                            </div>
                          </div>
                      </div>
                      <?php endforeach; ?>
                      <?php else :?>
                      <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo $text_error_delivery; ?>
                      </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <legend><?php echo $text_units_legend; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $text_units_length_title; ?></label>
                  <div class="col-sm-10">
                    <div class="row">
                      <?php if ($length_classes['opencart']) :?>
                      <?php foreach($length_classes['vk'] as $lengthUnit => $lengthFactor): ?>
                      <div class="col-sm-12" style="margin-bottom:10px;">
                        <div class="row vk_unit">
                          <div class="col-lg-4 col-md-6 col-sm-6">
                            <select id="vk_settings_length_<?php echo $lengthUnit; ?>"
                                    name="vk_settings_length[<?php echo $lengthUnit; ?>]" class="form-control">

                              <option value="not_unit"
                              <?php if(isset($saved_settings['vk_settings_length'][$lengthUnit]) && 'not_unit' == $saved_settings['vk_settings_length'][$lengthUnit]):?>
                              selected="selected"<?php endif;?>>
                              <?php echo $text_not_unit;?>
                              </option>

                              <?php foreach ($length_classes['opencart'] as $length_class): ?>
                              <option value="<?php echo $length_class['length_class_id']; ?>"
                              <?php if(isset($saved_settings['vk_settings_length'][$lengthUnit]) && $length_class['length_class_id'] == $saved_settings['vk_settings_length'][$lengthUnit]):?>
                              selected="selected"<?php endif;?>>
                              <?php echo $length_class['title'];?>
                              </option>

                              <?php endforeach; ?>
                            </select>
                          </div>
                          <div class="col-lg-4 col-md-6 col-sm-6">
                            <label class="control-label" style="text-align:left!important;"
                                   for="vk_settings_length_<?php echo $lengthUnit; ?>"><?php echo $units_title[$lengthUnit]; ?></label>
                          </div>
                        </div>
                      </div>
                      <?php endforeach; ?>
                      <?php else :?>
                      <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo $text_error_units_classes; ?>
                      </div>
                      <?php endif; ?>
                    </div>
                  </div>
                  <label class="col-sm-2 control-label"><?php echo $text_units_weight_title; ?></label>
                  <div class="col-sm-10">
                    <div class="row">
                      <?php if ($weight_classes['opencart']) :?>
                      <?php foreach($weight_classes['vk'] as $weightUnit => $weightFactor): ?>
                      <div class="col-sm-12" style="margin-bottom:10px;">
                        <div class="row vk_unit">
                          <div class="col-lg-4 col-md-6 col-sm-6">
                            <select id="vk_settings_weight_<?php echo $weightUnit; ?>"
                                    name="vk_settings_weight[<?php echo $weightUnit; ?>]" class="form-control">
                              <option value="not_unit"
                              <?php if(isset($saved_settings['vk_settings_weight'][$weightUnit]) && 'not_unit' == $saved_settings['vk_settings_weight'][$weightUnit]):?>
                              selected="selected"<?php endif;?>>
                              <?php echo $text_not_unit;?>
                              </option>
                              <?php foreach ($weight_classes['opencart'] as $weight_class): ?>
                              <option value="<?php echo $weight_class['weight_class_id']; ?>"
                              <?php if(isset($saved_settings['vk_settings_weight'][$weightUnit]) && $weight_class['weight_class_id'] == $saved_settings['vk_settings_weight'][$weightUnit]):?>
                              selected="selected"<?php endif;?>>
                              <?php echo $weight_class['title'];?>
                              </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                          <div class="col-lg-4 col-md-6 col-sm-6">
                            <label class="control-label" style="text-align:left!important;"
                                   for="vk_settings_weight_<?php echo $weightUnit; ?>"><?php echo $units_title[$weightUnit]; ?></label>
                          </div>
                        </div>
                      </div>
                      <?php endforeach; ?>
                      <?php else :?>
                      <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo $text_error_units_classes; ?>
                      </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <legend><?php echo $text_default_legend; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-10">
                    <div class="row">
                      <?php if ($delivery['opencart']) :?>
                      <div class="col-sm-12" style="margin-bottom:10px;">
                        <div class="row vk_unit">
                          <div class="col-lg-4 col-md-6 col-sm-6">
                            <select id="vk_settings_delivery_default"
                                    name="vk_settings_delivery_default" class="form-control">
                              <?php foreach ($delivery['opencart'] as $value): ?>
                                <?php unset($value['title']); ?>
                                <?php foreach ($value as $key => $val): ?>
                                  <?php $code_oc = $key; ?>
                                  <?php $title_oc = $val['title'] ?>
                                <?php endforeach; ?>
                                <option value="<?php echo $code_oc; ?>"
                                <?php if(isset($saved_settings['vk_settings_delivery_default']) && $code_oc == $saved_settings['vk_settings_delivery_default']):?>
                                selected="selected"<?php endif;?>>
                                <?php echo $title_oc;?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                          <div class="col-lg-4 col-md-6 col-sm-6">
                            <label class="control-label" style="text-align:left!important;"
                                   for="vk_settings_delivery_default"><?php echo $text_delivery_default_title; ?></label>
                          </div>
                        </div>
                      </div>
                      <?php else :?>
                      <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo $text_error_delivery; ?>
                      </div>
                      <?php endif; ?>
                    </div>
                  </div>
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-10">
                    <div class="row">
                      <?php if ($payments['opencart']) :?>
                      <div class="col-sm-12" style="margin-bottom:10px;">
                        <div class="row vk_unit">
                          <div class="col-lg-4 col-md-6 col-sm-6">
                            <select id="vk_settings_payment_default"
                                    name="vk_settings_payment_default" class="form-control">
                              <?php foreach ($payments['opencart'] as $code_oc => $title_oc): ?>
                              <option value="<?php echo $code_oc; ?>"
                              <?php if(isset($saved_settings['vk_settings_payment_default']) && $code_oc == $saved_settings['vk_settings_payment_default']):?>
                              selected="selected"<?php endif;?>>
                              <?php echo $title_oc;?>
                              </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                          <div class="col-lg-4 col-md-6 col-sm-6">
                            <label class="control-label" style="text-align:left!important;"
                                   for="vk_settings_payment_default"><?php echo $text_payment_default_title; ?></label>
                          </div>
                        </div>
                      </div>
                      <?php else :?>
                      <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo $text_error_payment; ?>
                      </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
            <div class="tab-pane" id="tab-catalog">
              <fieldset>
                <legend><?php echo $text_load_catalog; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $text_list_product; ?></label>
                  <div class="col-lg-8 col-md-6 col-sm-10">
                    <div class="well well-sm" style="height: 500px; overflow: auto;">
                      <hr>
                      <?php foreach($categories['opencart'] as $category) : ?>
                      <div class="checkbox row slim">
                        <label class="col-lg-4">
                          <input type="checkbox" name="<?php echo 'vk_settings_category-list[]'; ?>"
                                 value="<?php echo $category['category_id']; ?>"
                          <?php if(isset($saved_settings['vk_settings_category-list']) && in_array($category['category_id'], $saved_settings['vk_settings_category-list'])) :
                                  echo 'checked';
                                endif;?>
                          >
                          <?php echo $category['name']; ?>
                          <span class="count-category-<?php echo $category['category_id']; ?>"><?php echo ' (' . $category['count'] . ')'; ?></span>
                        </label>
                        <label class="col-lg-4 col-lg-offset-4">
                          <select class="select_vk_categories"
                                  name="vk_settings_category-conformity[<?php echo $category['category_id']; ?>]">
                            <?php foreach($categories['vk'] as $vk_section) : ?>
                            <option value="<?php echo $vk_section['id']; ?>" disabled>
                              <?php echo $vk_section['name'] ?>
                            </option>
                            <?php foreach($vk_section['categories'] as $vk_category) : ?>
                            <option value="<?php echo $vk_category['id']; ?>"
                            <?php if(isset($saved_settings['vk_settings_category-conformity'][$category['category_id']]) && $vk_category['id'] == $saved_settings['vk_settings_category-conformity'][$category['category_id']]) : ?>
                            selected="selected"
                            <?php endif;?>
                            >
                            &mdash; <?php echo $vk_category['name'] ?>
                            </option>
                            <?php endforeach; ?>
                            <?php endforeach; ?>
                          </select>
                        </label>
                      </div>
                      <hr>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
                <div class="col-lg-offset-2">
                  <button type="submit" form="form-vk" data-toggle="tooltip" title="<?php echo $button_save; ?>"
                          class="btn btn-primary"
                          style="font-weight: bold"><?php echo $button_save_export_offer; ?></button>
                  <button type="button" id="export-offer" data-toggle="tooltip"
                          class="btn btn-success"
                          style="font-weight: bold"><?php echo $button_export_offer; ?></button>
                </div>
              </fieldset>
            </div>
            <div class="tab-pane" id="tab-logs">
              <fieldset style="margin-bottom: 30px;">
                <legend>VK API error log</legend>
                <div class="vk_unit">
                  <a onclick="confirm('<?php echo $text_confirm_log; ?>') ? location.href='<?php echo $clear_vk; ?>' : false;"
                     data-toggle="tooltip" title="<?php echo $button_clear; ?>" class="btn btn-danger"><i
                            class="fa fa-eraser"></i> <span class="hidden-xs"><?php echo $button_clear; ?></span></a>
                  <?php if($logs['vk_detail'] != '') : ?>
                    <a href="<?php echo $logs['vk_detail']; ?>" class="btn btn-success"><?php echo $text_vk_detail; ?></a>
                  <?php endif; ?>
                </div>
                <?php if (isset($logs['vk_log'])) : ?>
                <div class="row">
                  <div class="col-sm-12">
                    <textarea wrap="off" rows="15" readonly
                              class="form-control"><?php echo $logs['vk_log']; ?></textarea>
                  </div>
                </div>
                <?php elseif (isset($logs['vk_error'])) : ?>
                <div class="alert alert-danger alert-dismissible"><i
                          class="fa fa-exclamation-circle"></i> <?php echo $logs['vk_error']; ?>
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                <?php endif; ?>
              </fieldset>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>

<script type="text/javascript">

    var token = '<?php echo $token; ?>';

    $('#export-offer').on('click', function () {
        $.ajax({
            url: '<?php echo $catalog; ?>' + 'admin/index.php?route=extension/module/vk/exportOffer&token=' + token,
            beforeSend: function () {
                $('#export-offer').button('loading');
            },
            complete: function () {
                $('.alert-success').remove();
                $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $text_success_export_offer; ?></div>');
                $('#export-offer').button('reset');
            },
            error: function () {
                alert('error');
            }
        });
    });

    $('#import-offer').on('click', function () {
      $.ajax({
        url: '<?php echo $catalog; ?>' + 'admin/index.php?route=extension/module/vk/importOffer&token=' + token,
        beforeSend: function () {
          $('#import-offer').button('loading');
        },
        complete: function () {
          $('.alert-success').remove();
          $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $text_success_import_offer; ?></div>');
          $('#import-offer').button('reset');
        },
        error: function () {
          alert('error');
        }
      });
    });

    $('#vk-event-on').on('click', function () {
        $.ajax({
            url: '<?php echo $catalog; ?>' + 'admin/index.php?route=extension/module/vk/subscribeToVkEvents&token=' + token,
            beforeSend: function () {
                $('#vk-event-on').button('loading');
            },
            complete: function () {
              $('#vk-event-on').addClass('hidden').button('reset');
              $('#vk-event-off').removeClass('hidden');
            },
            error: function (e) {
                console.log(e);
                alert('error');
            }
        });
    });

    $('#vk-event-off').on('click', function () {
        $.ajax({
            url: '<?php echo $catalog; ?>' + 'admin/index.php?route=extension/module/vk/unsubscribeToVkEvents&token=' + token,
            beforeSend: function () {
                $('#vk-event-off').button('loading');
            },
            complete: function () {
                $('#vk-event-off').addClass('hidden').button('reset');
                $('#vk-event-on').removeClass('hidden');
            },
            error: function () {
                alert('error');
            }
        });
    });

</script>
