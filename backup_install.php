<?php
//защита от вызова из вне
if (php_sapi_name() != 'cli') {
    header('HTTP/1.1 403 Forbidden');
    die();
}

echo "=================================================\n";
echo "=    EchoCompany Backup installation script     =\n";
echo "=================================================\n";

$home = $_SERVER['HOME'];
$current = dirname(__FILE__);
$in_home = (mb_strpos($current, $home) === 0);

echo "=\n";
echo "= Home dir: $home\n";
echo "= Current dir: " . normalizePath($current) . "\n";
if (!$in_home) {
    echoWarning('Home dir not used - use absolute paths', 'Warning');
}
echo "=\n";
echo "=================================================\n";
echo "\n";

$deal_id = getDealId();

$detect = detectDB($current);

$config = [];
$config['id'] = $deal_id;

echo "=================================================\n";
echo "=\n";

if (empty($detect)) {
    echo "= Autodetect not found CMS - if CMS exist, say developers about it (info@echo-company.ru)\n";
    echo "=\n";
    $config['path'] = normalizePath($current);
    $config['system'] = 'Unknown';

    $config['db_host'] = "";
    $config['db_user'] = "";
    $config['db_database'] = "";
    $config['db_password'] = "";

} else {
    echo "= Detect \e[0;32m" . $detect['system'] . "\e[0m\n";
    echo "=\n";

    $config['system'] = $detect['system'];
    $config['path'] = normalizePath($detect['path']);
    $config['db_host'] = empty($detect['host']) ? "localhost" : $detect['host'];
    $config['db_user'] = $detect['user'];
    $config['db_database'] = $detect['database'];
    $config['db_password'] = $detect['password'];

}

$config['login'] = get_current_user();
$config['port'] = exec('echo "${SSH_CLIENT##* }"');
if (empty($config['port'])) {
    $config['port'] = 22;
}

$config['host'] = gethostname();
if (gethostbyname($config['host']) == $config['host']) {
    $config['host'] = exec('echo "${SSH_CLIENT}" | cut -d\' \' -f1');
}

input_data:

$config['path'] = getLine($config, "= Space separated backup path(s)", 'path');
$config['db_host'] = getLine($config, "= Database host", 'db_host');
$config['db_user'] = getLine($config, "= Database login", 'db_user');
$config['db_password'] = getLine($config, "= Database password", 'db_password');
$config['db_database'] = getLine($config, "= Database name", 'db_database');

$config['host'] = getLine($config, "= SSH host", 'host');
$config['port'] = getLine($config, "= SSH port", 'port');

$config['login'] = getLine($config, "= SSH login", 'login');
$config['password'] = getLine($config, "= SSH password", 'password');

echo "=\n";
echo "=================================================\n";
echo "\n";
echo "=================================================\n";
echo "=\n";
echo "= \e[0;31mPlease check!!!\e[0m\n";
showConfig($config);
echo "=\n";
echo "=================================================\n";

while (true) {
    $answer = getLine(['answer' => 'Y/N'], '= All right?', 'answer');

    if (($answer == 'Y') || ($answer == 'y')) {
        break;
    }
    if (($answer == 'N') || ($answer == 'n')) {

        echo "\n";
        echo "\n";
        echo "= Repeat\n";
        echo "=\n";
        goto input_data;
    }

    echo "\n";
}


echo "\n";
echo "=================================================\n";
echo "=    Creating backup                            =\n";
echo "=================================================\n";
echo "=\n";
echo "= Please waiting (usually above 30 seconds) ...\n";
echo "=\n";

$success = createBackup($config);

echo "=\n";
echo "=================================================\n";


if (!$success) {
    while (true) {
        $answer = getLine(['answer' => 'Y/N'], '= Repeat?', 'answer');
        if (($answer == 'Y') || ($answer == 'y')) {
            goto input_data;
        }
        if (($answer == 'N') || ($answer == 'n')) {
            break;
        }
        echo "\n";
    }
}
echo "\n";
echo "\n";


///
/// Функции
///
function createBackup($config)
{
    $result = post('backups/create/', $config);

    if (empty($result) || (empty($result['status'])) || ($result['status'] == 'error')) {
        echoWarning("Check https://api.dev.echo-company.ru/", "Backup create failed!");

        if (!empty($result['message'])) {
            echoWarning($result['message'], 'Info:');
        }
        return false;
    } elseif ($result['status'] == 'ok') {
        echo "= Success, see for details https://echo-company.ru/backups/?deal_id=" . $config['id'] . "\n";
        return true;
    }
}

function normalizePath($path)
{
    global $in_home, $home;
    if ($in_home) {
        return '$HOME' . mb_substr($path, mb_strlen($home));
    } else {
        return $path;
    }
}

function getDealId()
{
    global $argv;
    $deal_id = 0;

    if (isset($argv[1])) {
        $deal_id = (int)$argv[1];
    }

    if (empty($deal_id)) {

        echo "- Enter deal ID (in bitrix 24 task)\n";
        echo "-\n";
        echo "- Deal ID: ";

        $handle = fopen("php://stdin", "r");
        $deal_id = (int)trim(fgets($handle));
        if (empty($deal_id)) {
            echoWarning("", "Deal ID is required!");
            echo "=\n";
            echo "=================================================\n";
            die;
        }
        fclose($handle);
        echo "\n";
    }

    checkDealId($deal_id);

    return $deal_id;
}

function checkDealId($id)
{
    $result = request('backups/exist/', ['id' => "deal_" . $id]);
    if (empty($result) || (empty($result['status'])) || ($result['status'] == 'error')) {
        echoWarning("Check https://api.dev.echo-company.ru/", "Deal id check failed!");
        die();
    } elseif ($result['status'] == 'ok') {
        echoWarning("Backups with this id (deal_$id) - exist, check deal id", "Deal id exist!");
        die();
    }
}

function request($url, $data = [])
{
    $data['secret'] = 'klashdkaj^#shdalx23jh3792HUE*^@!*DLUI';
    $url .= '?' . http_build_query($data);
    return json_decode(file_get_contents("https://api.dev.echo-company.ru/" . $url), 1);
}

function post($url, $data = [])
{
    $url = "https://api.dev.echo-company.ru/" . $url;
    $data['secret'] = 'klashdkaj^#shdalx23jh3792HUE*^@!*DLUI';

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return json_decode($result, 1);
}

function echoWarning($message, $title = "Warning!")
{
    echo "=\n";
    echo "= \e[0;31m$title\e[0m $message\n";
}


function detectDB($folder, $limit = 5)
{

    $result = false;

    //MODX DB
    if (file_exists($folder . '/manager/includes/config.inc.php')) {

        $content = file_get_contents($folder . '/manager/includes/config.inc.php');

        preg_match_all('/\$database_user.+[\'"](.*)[\'"]/Ui', $content, $match);

        if (!empty($match[1][0])) {

            $result = array();
            $result['path'] = $folder;
            $result['system'] = 'MODX';
            $result['user'] = $match[1][0];

            preg_match_all('/\$database_password.+[\'"](.*)[\'"]/Ui', $content, $match);
            $result['password'] = $match[1][0];

            preg_match_all('/\$dbase.+[\'"](.*)[\'"]/Ui', $content, $match);
            $result['database'] = str_replace('`', '', $match[1][0]);

        }

        //webAsyst
    } elseif (file_exists($folder . '/wa-config/db.php')) {

        $content = include($folder . '/wa-config/db.php');

        if (!empty($content['default'])) {
            $result = $content['default'];
            $result['path'] = $folder;
            $result['system'] = 'webAsyst';
        }

        //Битрикс
    } elseif (file_exists($folder . '/bitrix/php_interface/dbconn.php')) {
        $content = file_get_contents($folder . '/bitrix/php_interface/dbconn.php');

        preg_match_all('/\$DBLogin.+[\'"](.*)[\'"]/Ui', $content, $match);

        if (!empty($match[1][0])) {

            $result = array();
            $result['path'] = $folder;

            $result['user'] = $match[1][0];

            preg_match_all('/\$DBPassword.+[\'"](.*)[\'"]/Ui', $content, $match);
            $result['password'] = $match[1][0];

            preg_match_all('/\$DBName.+[\'"](.*)[\'"]/Ui', $content, $match);
            $result['database'] = str_replace('`', '', $match[1][0]);

            $result['system'] = 'Bitrix';

        }

        //WordPresss
    } elseif (file_exists($folder . '/wp-config.php')) {
        $content = file_get_contents($folder . '/wp-config.php');

        preg_match_all('/DB_USER[\'"].+[\'"](.*)[\'"]/Ui', $content, $match);

        if (!empty($match[1][0])) {

            $result = array();
            $result['path'] = $folder;

            $result['user'] = $match[1][0];

            preg_match_all('/DB_PASSWORD[\'"].+[\'"](.*)[\'"]/Ui', $content, $match);
            $result['password'] = $match[1][0];

            preg_match_all('/DB_NAME[\'"].+[\'"](.*)[\'"]/Ui', $content, $match);
            $result['database'] = str_replace('`', '', $match[1][0]);

            $result['system'] = 'WordPress';

        }
    }

    //Рекурсивно смотрим дочерние каталоги
    if (!$result && $limit) {

        $list = scandir($folder);
        foreach ($list as $scan_dir) {
            if ($scan_dir == '.' || $scan_dir == '..' || !is_dir($folder . '/' . $scan_dir)) {
                continue;
            }

            $temp = detectDB($folder . "/" . $scan_dir, $limit - 1);

            if (!empty($temp)) {
                $result = $temp;
                break;
            }
        }

    }

    return $result;
}

function showConfig($config)
{
    echo "- \n";
    echo "- Id: " . $config['id'] . "\n";
    echo "- System: " . $config['system'] . "\n";
    echo "- Backup path: " . $config['path'] . "\n";
    echo "- \n";
    echo "- Database:\n";
    echo "  - Host: " . $config['db_host'] . "\n";
    echo "  - Login: " . $config['db_user'] . "\n";
    echo "  - Password: " . $config['db_password'] . "\n";
    echo "  - Database: " . $config['db_database'] . "\n";
    echo "- \n";
    echo "- SSH:\n";
    echo "  - Host: " . $config['host'] . "\n";
    echo "  - Port: " . $config['port'] . "\n";
    echo "  - Login: " . $config['login'] . "\n";
    echo "  - Password: " . $config['password'] . "\n";
    echo "- \n";
}

function getLine($config, $title, $key)
{
    echo $title;
    if (!empty($config[$key])) {
        echo " (" . $config[$key] . ")";
    }

    echo ": ";
    $handle = fopen("php://stdin", "r");

    $path = trim(fgets($handle));
    if ($path != '') {
        $config[$key] = $path;
    }
    fclose($handle);

    return $config[$key];
}