<?php
/**
 * @category    BackendUserWrapper
 * @date        19/05/2017 14:31
 * @author      Jakub Płaskonka <jplaskonka@divante.pl>
 * @copyright   Copyright (c) 2017 Divante Ltd. (https://divante.co)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="/plugins/BackendUserWrapper/static/css/normalize.css">
  <link rel="stylesheet" href="/plugins/BackendUserWrapper/static/css/skeleton.css">
</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <div class="one-half column" style="margin-top: 10%">
        <h4><?=$this->t("user_permissions_config");?></h4>
          <?php if($this->saved): ?>
              <?=$this->t("configuration_has_been_saved");?>
          <?php elseif ($this->reload): ?>
              <?=$this->t("roles_has_been_reloaded");?>
          <?php endif; ?>
        <form action="#" method="post">
          <div class="row">
            <div class="six columns">
              <label for="className"><?=$this->t("user_class_name");?></label>
              <input class="u-full-width" type="text" placeholder="BackendUser" id="className" name="className" value="<?=$this->className?>">
              <label for="adminUrl"><?=$this->t("admin_url_info");?></label>
                <?php $currentUrl = $this->getRequest()->getScheme() . "://" . $this->getRequest()->getHttpHost(); ?>
              <input class="u-full-width" type="text" placeholder="<?=$currentUrl?>" id="adminUrl" name="adminUrl" value="<?php if($this->adminUrl) echo $this->adminUrl; else echo $currentUrl?>">
            </div>
          </div>

          <input class="button-primary" type="submit" value="<?=$this->t("save");?>">

        </form>
          <label for="reload_roles"><?=$this->t("reload_roles_info");?></label>
          <input class="button" id="reload_roles" type="button" value="<?=$this->t("reload_roles");?>"
          onclick="document.location.href = '/plugin/BackendUserWrapper/admin/reload-roles';">
      </div>
    </div>
  </div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
