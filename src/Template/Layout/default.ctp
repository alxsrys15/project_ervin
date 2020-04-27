<!DOCTYPE html>
<html>
<head>
<!--     <?= $this->Html->charset() ?> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
      Captcha PH
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['bootstrap.min.css', 'jquery-ui.min.css']) ?>
    <?= $this->Html->css(['mdb.min.css']) ?>
    <?= $this->Html->css(captcha_layout_stylesheet_url(), ['inline' => false]) ?>
    
    <?= $this->Html->script(['jquery.min.js','bootstrap.min.js', 'jquery-ui.min.js']) ?>
    

   <!--  <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?> -->
    <style type="text/css">
      /* Absolute Center Spinner */
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
    background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

  background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 150ms infinite linear;
  -moz-animation: spinner 150ms infinite linear;
  -ms-animation: spinner 150ms infinite linear;
  -o-animation: spinner 150ms infinite linear;
  animation: spinner 150ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
    </style>

<script type="text/javascript">
      var onloadCallback = function() {
        console.log("grecaptcha is ready!");
      };
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
      async defer>
    </script>
</head>
<body>
  <div class="loading" id="blocker" style="display: none">Loading&#8230;</div>
  
        <!--Navbar-->
        <nav class="navbar navbar-light light-blue lighten-4">

          <!-- Navbar brand -->
          <?= $this->Html->link('Welcome', ['controller' => 'Home', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
          <!-- Collapse button -->
          <button class="navbar-toggler toggler-example" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1"
            aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

          <!-- Collapsible content -->
          <div class="collapse navbar-collapse" id="navbarSupportedContent1">

            <!-- Links -->
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <?= $this->Html->link('Profile', ['controller' => 'Users', 'action' => 'view'], ['class' => 'nav-link']) ?>
              </li>
              <li class="nav-item">
                <?= $this->Html->link('Change Password', ['controller' => 'Users', 'action' => 'changePassword'], ['class' => 'nav-link']) ?>
              </li>
              <li class="nav-item">
                <?= $this->Html->link('Logout', ['controller' => 'users', 'action' => 'logout'], ['class' => 'nav-link']); ?>
              </li>
              
            </ul>
            <!-- Links -->

          </div>
          <!-- Collapsible content -->

        </nav>
        <?php if ($this->request->session()->read('Auth.User.status') === "Inactive"): ?>
          <div class="alert alert-danger" role="alert">
            Your account is inactive. Please click <a href="#!" data-toggle="modal" data-target="#activationModal">here</a> to activate your account.
          </div>
        <?php endif ?>
        <!--/.Navbar-->
        <?= $this->Flash->render() ?>
        <div id="content">
          <?= $this->fetch('content') ?>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="activationModal">
          <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'selfActivation']]) ?>
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Activate account</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <?= $this->Form->input('activation_code', ['type' => 'text', 'class' => 'form-control']) ?>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-flat" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Activate</button>
                  </div>
              </div>
          </div>
          <?= $this->Form->end() ?>
        </div>
    <script type="text/javascript">
        var url = '<?= $this->Url->build('/', true); ?>';
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    </script>
    </body>
    
</html>