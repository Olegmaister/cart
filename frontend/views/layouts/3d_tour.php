<?php

\frontend\assets\ThreeDTourAsset::register($this);
$this->beginPage();
$this->head();
$this->registerCss("body {overflow: hidden; margin: 0;}");
?>
<body>

<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
