<?php
namespace App\Controller;

use App\Session;
use App\Connection;
use App\Controller;
use function App\redirect;

class Signup extends Controller
{
    public function processRequest() : void
    {
        if (($_POST['submit']??'') !== $this->uniq) {
            return;
        }

        $field=$this->addField('fname');
        $field->testForEmpty();

        $field=$this->addField('lname');

        $field=$this->addField('login');
        $field->testForEmpty();

        $fieldPass=$this->addField('pass');
        $fieldPass->testForEmpty();

        $fieldPass2=$this->addField('pass2');
        $fieldPass2->testForEmpty();

        if ($fieldPass2->isValid() && $fieldPass2->value!==$fieldPass->value) {
            $fieldPass2->error='Не совпадает с паролем!';
        }

        if ($this->checkFields()) {
            $ok=false;
            $conn=Connection::inst();

            if ($res=$conn->query('call sp_signup('.
                '"'.$conn->real_escape_string($this->field('fname')->value).'",'.
                '"'.$conn->real_escape_string($this->field('lname')->value).'",'.
                '"'.$conn->real_escape_string($this->field('login')->value).'",'.
                '"'.$conn->real_escape_string($this->field('pass')->value).'"'.
            ')')) {

                if ($row=$res->fetch_assoc()) {
                    $ok=true;
                }

                $res->close();
                $conn->free_result();
            }

            if ($ok) {
                Session::inst()->signin($row['id'], $this->field('fname')->value);
                redirect('?route=home');
            }
            else if ($conn->errno == 1062) {
                $this->error='Пользователь с таким логином существует. Пожалуйста, попробуйте с другим логином.';
            }
            else {
                $this->error='Error '. $conn->errno.': '.$conn->error;
            }
        }
    }

    public function printView() : void
    {
        $groups=[
            'fname'=>['label'=>'Имя', 'type'=>'text', 'required'=>true],
            'lname'=>['label'=>'Фамилия', 'type'=>'text'],
            'login'=>['label'=>'Логин', 'type'=>'text', 'required'=>true],
            'pass'=>['label'=>'Пароль', 'type'=>'password', 'required'=>true],
            'pass2'=>['label'=>'Подтвердите пароль', 'type'=>'password', 'required'=>true],
            'submit'=>['label'=>'Зарегистрироваться', 'type'=>'submit', 'fgClass'=>'form-group-last'],
        ];

        $this->createForm($groups);

       echo '<div class="note">Вы можете <a href="?route=signin">войти</a>, если у вас есть пользователь.</div>';
    }
}
