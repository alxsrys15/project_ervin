<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
      APP SETTINGS
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['bootstrap.min.css']) ?>
    <?= $this->Html->css(['mdb.min.css']) ?>
    <?= $this->Html->css(['mdbbootstrap.min.css']) ?>
    <?= $this->Html->script(['jquery.js']) ?>
    <?= $this->Html->script(['bootstrap.min.js']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
        <!--Navbar-->
        <nav class="navbar navbar-light light-blue lighten-4">

          <!-- Navbar brand -->
          <a class="navbar-brand" href="#">Navbar</a>

          <!-- Collapse button -->
          <button class="navbar-toggler toggler-example" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1"
            aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

          <!-- Collapsible content -->
          <div class="collapse navbar-collapse" id="navbarSupportedContent1">

            <!-- Links -->
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Profile</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Settings</a>
              </li>
            </ul>
            <!-- Links -->

          </div>
          <!-- Collapsible content -->

        </nav>
        <!--/.Navbar-->
        <?= $this->fetch('content') ?>
</body>
</html>