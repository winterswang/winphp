<html>
    <head>
        <title>text</title>
    </head>
    <body>
        <h1>it is views</h1>
        <ul>
            <?php foreach($list as $r):?>
            <li>ID: <?= $r['id']?>   TITLE: <?= $r['title']?></li>
            <?php endforeach;?>
        </ul>
        count: <?= $length?>
    </body>
</html>