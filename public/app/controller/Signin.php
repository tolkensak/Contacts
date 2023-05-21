<?php
namespace App\Controller;

use App\Sess;
use App\Conn;
use App\Controller;
use function App\redirect;

class Signin extends Controller
{
    public function processRequest() : void
    {
        if (($_POST['submit']??'')!==$this->uniq) {
            return;
        }

        $field=$this->addField('login');
        $field->testForEmpty();

        $field=$this->addField('pass');
        $field->testForEmpty();

        if ($this->checkFields()) {
            $ok=false;
            $conn=Conn::inst();

            if ($res=$conn->query('call sp_signin("'.$conn->real_escape_string($this->field('login')->value).'","'.$conn->real_escape_string($this->field('pass')->value).'")')) {
                if ($row=$res->fetch_assoc()) {
                    $ok=true;
                }

                $res->close();
                $conn->free_result();

                if ($ok) {
                    Sess::inst()->signin($row['id'], $row['fname']);
                    redirect('?route=home');
                }
                else {
                    $this->error='Данные для входа неверны';
                }
            }
            else {
                $this->error='Error '. $conn->errno.': '.$conn->error;
            }
        }
    }

    public function printView() : void
    {
        $groups=[
            'login'=>['label'=>'Логин', 'type'=>'text', 'required'=>true],
            'pass'=>['label'=>'Пароль', 'type'=>'password', 'required'=>true],
            'submit'=>['label'=>'Войти', 'type'=>'submit', 'fgClass'=>'form-group-last'],
        ];

       $this-> createForm($groups);

       echo '<div class="note">Существующие логины q, w, e, пароли q, w, e соответственно.</div>';
       echo '<div class="note">Вы можете зарегистрировать нового пользователя, нажав на <a href="?route=signup">Регистрация</a>.</div>';
    }
}
