<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html >
  <head>
    <meta charset="utf-8">
    <title><?php echo ($title); ?></title>
    <link rel="canonical" href="./regular-html-version.html">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <style amp-custom>
      h1 {color: red}
    </style>
    <script type="application/ld+json">
    {
      "@context": location,
      "@type": "NewsArticle",
      "headline": "<?php echo ($article[title]); ?>",
      "image": [
        "/Public/Dcard/image/face.png"
      ],
      "datePublished": "<?php echo (date('Y-m-d',$article[time])); ?>"
    }
    </script>
    <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
    <?php echo ($amp); ?>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
<link  rel = "canonical"  href = "<?php echo u('index/show');?>?id=<?php echo ($_GET['id']); ?>" >
  </head>
  <body>
    <h1><?php echo ($article[title]); ?></h1>
    <p>
      <?php echo ($article[content]); ?>
    </p>
  </body>
</html>