<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
      LOGIN
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['bootstrap.min.css']) ?>
    <?= $this->Html->script(['jquery.min.js','bootstrap.min.js', 'https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</body>
</html>