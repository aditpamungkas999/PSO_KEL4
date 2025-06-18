<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <?= csrf_meta(); ?>
   <?= $this->include('templates/css'); ?>
   <title><?= $title ?></title>
   <?= $this->include('templates/js') ?>
   <script>var BaseConfig = {baseURL: '<?= base_url(); ?>', csrfTokenName: '<?= csrf_token() ?>', textOk: "Ok", textCancel: "Batalkan"};</script>
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
   integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
   crossorigin=""/>>

<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
</head>