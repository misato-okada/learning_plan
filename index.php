<?php

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

$title = '';
$due_date = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = filter_input(INPUT_POST, 'title');
    $due_date = filter_input(INPUT_POST, 'due_date');

    $errors = insertValidate($title, $due_date);

    if (empty($errors)) {
        insertPlan($title, $due_date);
    }
}

$notyet_plans = findPlansByCd();

$done_plans = findPlansByDonecd();

?>
<!DOCTYPE html>

<html lang="ja">

<?php include_once __DIR__ . '/_head.html' ?>

<body>
    <div class="wrapper">
        <h1 class="title">学習管理アプリ</h1>
        <div class="form-area">
            <?php if ($errors) echo (createErrMsg($errors)); ?>
            <form action="" method="post">
                <label for="title">学習内容</label>
                <input type="text" name="title">
                <label for="due_date">期限日</label>
                <input type="date" name="due_date">
                <input type="submit" class="btn submit-btn" value="追加">
            </form>
        </div>
        <div class="incomplete-area">
            <h2 class="sub-title">未達成</h2>
            <table class="plan-list">
                <thead>
                    <tr>
                        <th class="plan-title">学習内容</th>
                        <th class="plan-due-date">完了期限</th>
                        <th class="done-link-area"></th>
                        <th class="edit-link-area"></th>
                        <th class="delete-link-area"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notyet_plans as $plan): ?>
                        <tr>
                            <td class="plan-title">
                                <?= h($plan['title']) ?>
                            </td>
                            <td class="plan-due-date <?php if ($plan) echo (expiredDuedate($plan)); ?>">
                                <?= h(date('Y/m/d', strtotime($plan['due_date']))) ?>
                            </td>
                            <td class="done-link-area">
                                <a href="done.php?id=<?= h($plan['id']) ?>" class="btn mini-btn">完了</a>
                            </td>
                            <td class="edit-link-area">
                                <a href="edit.php?id=<?= h($plan['id']) ?>" class="btn mini-btn">編集</a>
                            </td>
                            <td class="delete-link-area">
                                <a href="delete.php?id=<?= h($plan['id']) ?>" class="btn mini-btn">削除</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="complete-area">
            <h2 class="sub-title">完了</h2>
            <table class="plan-list">
                <thead>
                    <tr>
                        <th class="plan-title">学習内容</th>
                        <th class="plan-completion-date">完了日</th>
                        <th class="done-link-area"></th>
                        <th class="edit-link-area"></th>
                        <th class="delete-link-area"></th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach ($done_plans as $plan): ?>
                    <tr>
                        <td class="plan-title">
                            <?= h($plan['title']) ?>
                        </td>
                        <td class="plan-completion-date">
                            <?= h(date('Y/m/d', strtotime($plan['completion_date']))) ?>
                        </td>
                        <td class="notyet-link-area">
                            <a href="done_cancel.php?id=<?= h($plan['id']) ?>" class="btn mini-btn">未完了</a>
                        </td>
                        <td class="edit-link-area">
                            <a href="edit.php?id=<?= h($plan['id']) ?>" class="btn mini-btn">編集</a>
                        </td>
                        <td class="delete-link-area">
                            <a href="delete.php?id=<?= h($plan['id']) ?>" class="btn mini-btn">削除</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>