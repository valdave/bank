<?php

/* @var $this yii\web\View */

$this->title = 'Avarage deposit report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report">
    <table border="1"> 
        <tr>
            <th>Age range</th>
            <th>Avarage deposit</th>
        </tr>
        <?php foreach ($data as $range => $avg): ?>
            <tr>
                <td><?= $range ?></td>
                <td><?= $avg->avarage ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
