<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{$images}favicon.ico">

    <title>Banners</title>

    <!-- Bootstrap core CSS -->
    <link href="{$css}bootstrap.min.css" rel="stylesheet">

    <!-- Drive core CSS -->
    <link href="{$css}site.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{$css}sticky-footer-navbar.css" rel="stylesheet">

    <link href="{$css}toastr.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {block name="head"}{/block}
</head>

<body>
<!-- Begin page content -->
{block name="body"}
    <div class="container">
        {$body}
    </div>
{/block}
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="{$js}bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{$js}ie10-viewport-bug-workaround.js"></script>
<script src="{$js}ajaxcom.js"></script>
<script src="{$js}toastr.js"></script>
<script src="{$js}validator.js"></script>
<script src="{$js}site.js"></script>
{block name="scripts"}{/block}
</body>
</html>
