
<?php
      function strong($text) {
    return("<em>$text</em>\n");
    }

  print(strong("この文字は強調されます"));


/*
 * ツエラーの公式による曜日計算 ( 0 が日曜日 )
 * @param int $y 年(西暦)
 * @param int $m 月
 * @param int $d 日、省略した場合は1日
 * @return int 0-6の数値、0が日曜日で6が土曜日
 */

  function Zeller($y, $m, $d = 1){
//$m = NULL;
    $y = intval( $y );
    $m = intval( $m );
    $d = intval( $d );
    if( $m == 1 or $m == 2 ){
        $y -= 1;
        $m += 12;
    }
    $res = ( $y + intval( $y / 4 ) - intval( $y / 100 ) + intval( $y / 400 ) + intval( ( 13 * $m + 8 ) / 5 ) + $d ) % 7;
    return $res;
}
//$today = NULL;
//$year = date("Y");
//$month = date("n");
//$day = date("j");
//echo($today);
//echo(Zeller($year,$month,$day));

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// timeStamp

$ym = isset($_GET['ym']) ? $_GET['ym'] : date("Y-m");

$timeStamp = strtotime($ym . "-01");

if ($timeStamp === false) {
    $timeStamp = time();
}

// 前月、翌月

$prev = date("Y-m", mktime(0,0,0,date("m",$timeStamp)-1,1,date("Y",$timeStamp)));
$next = date("Y-m", mktime(0,0,0,date("m",$timeStamp)+1,1,date("Y",$timeStamp)));

// 最終日？

$lastDay = date("t", $timeStamp);

// 1日は何曜日？
// 0: Sun ... 6: Sat
$y = date("Y");
$m = date("m");
$youbi = Zeller($y,$m);

// var_dump($lastDay);
// var_dump($youbi);
// exit;

$weeks = array();
$week = '';

$week .= str_repeat('<td></td>', $youbi);

for ($day = 1; $day <= $lastDay; $day++, $youbi++) {
    $week .= sprintf('<td class="youbi_%d">%d</td>', $youbi % 7, $day);

    if ($youbi % 7 == 6 OR $day == $lastDay) {
        if ($day == $lastDay) {
            $week .= str_repeat('<td></td>', 6 - ($youbi % 7));
        }
        $weeks[] = '<tr>' . $week . '</tr>';
        $week = '';
    }
}

// var_dump($weeks);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>カレンダー</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="get" action="index.php">
        <p>yyyy-mm：<input type="text" name="ym">
        <input type="submit" value="送信"></p>
    </form>
    <table>
        <thead>
            <tr>
                <th><a href="?ym=<?php echo h($prev); ?>">&laquo;</a></th>
                <th colspan="5"><?php echo h(date("Y",$timeStamp) . "-" . date("m", $timeStamp)); ?></th>
                <th><a href="?ym=<?php echo h($next); ?>">&raquo;</a></th>
            </tr>
            <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($weeks as $week) {
                    echo $week;
                }
            ?>
        </tbody>
    </table>
</body>
</html>