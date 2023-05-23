<?php
namespace App;

use App\Sole;
use App\Connection\Data;

class Connection extends \mysqli
{
    use Sole;
    use Data;

    protected function __construct()
    {
        mysqli_report(MYSQLI_REPORT_OFF);

        parent::__construct();

        parent::options(MYSQLI_INIT_COMMAND, 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci')
            or exit('MYSQLI_INIT_COMMAND failed');

        parent::real_connect(self::CONN_HOST, self::CONN_USER, self::CONN_PASS, self::CONN_DB)
            or exit('Connection failed (' . $this->connect_errno.'): '.$this->connect_error);
    }

    public function __destruct()
    {
        parent::close();
    }

    public function free_result()    {
        while (mysqli_more_results($this) && mysqli_next_result($this)) {
            $dummyResult=mysqli_use_result($this);

            if ($dummyResult instanceof mysqli_result) {
                mysqli_free_result($this);
            }
        }
    }
}
