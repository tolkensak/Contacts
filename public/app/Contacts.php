<?php
namespace App;

use App\Session;
use App\Connection;
use function App\hsc;

class Contacts
{
    public static function formatPhone(string $phone) : string
    {
        foreach([4, 8, 12] as $i){
            $phone=substr_replace($phone, ' ', -$i, 0);
        }

        return $phone;
    }

    public static function printList(string $whois) : void
    {
        $conn=Connection::inst();
        if ($res=$conn->query('call sp_'.$whois.'('.Session::inst()->userid().')')) {
            echo '<div class="info-bar">';
            echo '<div class="statis"><img class="fav-icon" src="image/fav-1.png"> <span id="fav-count"></span> / <span>'.$res->num_rows.'</span></div>';
            echo '<div class="info">Вы можете выбрать или отменить выбор, нажав значок сердца под его / ее именем.</span></div>';
            echo '<div class="info">Все контакты и их данные являются вымышленными.</div>';
            echo '</div>';
            echo '<div class="contacts">';

            while ($row=$res->fetch_assoc()) {
                $fav=$row['fav'];

                echo '<div class="contact">';
                echo '<div class="row-photo"><img src="image/sex-'.hsc($row['sex']).'.png"></div>';
                echo '<div class="row-name">'.hsc($row['name']).'</div>';
                echo '<div class="row-btns"><img class="fav-icon btn fav-btn" data-contactid="'.hsc($row['id']).'" data-fav="'.$fav.'" src="image/fav-'.$fav.'.png"></div>';
                echo '<div class="row-phone">'.($row['phone']?self::formatPhone(hsc($row['phone'])):'').'</div>';
                echo '<div class="row-email">'.($row['email']?hsc($row['email']):'').'</div>';
                echo '</div>';
            }

            echo '</div>';

            $res->close();
            $conn->free_result();
        }
        else {
            echo '<p class="error">Error '. $conn->errno.': '.hsc($conn->error).'</p>';
        }
    }
}
