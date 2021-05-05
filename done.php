<?php

require_once __DIR__ . '/functions.php';

$id = filter_input(INPUT_GET, 'id');

// タスク完了処理の実行
// updateCdToDone($id);

header('Location: index.php');
exit;