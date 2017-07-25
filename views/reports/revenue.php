<?php

/* @var $this yii\web\View */

$this->title = 'turnover by monthes report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report">
    <table border="1">
        <tr>
            <th>Month</th>
            <th>Turnover</th>
        </tr>
        <?php foreach ($data as $turnoverModel): ?>
            <tr>
                <td><?= $turnoverModel->month ?></td>
                <td><?= $turnoverModel->turnover ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
