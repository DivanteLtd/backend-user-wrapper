<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="/plugins/UserPermissions/static/css/normalize.css">
  <link rel="stylesheet" href="/plugins/UserPermissions/static/css/skeleton.css">
</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <div class="one-half column" style="margin-top: 10%">
        <h4><?=$this->t("user_permissions_config");?></h4>
        <form action="#" method="post">
          <div class="row">
            <div class="six columns">
              <label for="className"><?=$this->t("user_class_name");?></label>
              <input class="u-full-width" type="text" placeholder="User" id="className" name="className" value="<?=$this->className?>">
            </div>
          </div>

          <input class="button-primary" type="submit" value="<?=$this->t("save");?>">
        </form>
      </div>
    </div>
  </div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
