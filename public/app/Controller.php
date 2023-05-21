<?php
namespace App;

use App\Field;
use function App\hsc;

abstract class Controller
{
    protected readonly string $uniq;
    public string $error='';
    public array $fields=[];

    public function __construct()
    {
        $this->uniq=basename(get_class($this));
    }

    public function processRequest() : void {}
    public function printView() : void {}

    public function field(string $name) : Field|null
    {
        if (array_key_exists($name, $this->fields)) {
            return $this->fields[$name];
        }

        return null;
    }

    public function addField(string $name) : Field
    {
        if (array_key_exists($name, $this->fields)) {
            return $this->fields[$name];
        }

        $field=new Field($name);
        $field->value=trim($_POST[$name]??'');

        $this->fields[$name]=$field;
        return $field;
    }

    public function checkFields() : bool
    {
        foreach ($this->fields as $field) {
            if (!$field->isValid()) {
                return false;
            }
        }

        return true;
    }

    public function createForm(array &$groups) : void
    {
        echo '<p class="error">'.hsc($this->error).'</p>';
        echo '<form method="post">';

        foreach($groups as $name=>$info){
            $id=hsc($this->uniq.'-'.$name);
            $field=$this->field($name);

            echo '<div class="form-group '.(hsc($info['fgClass']??'')).'">';

            if ($info['type']==='submit') {
                echo '<button type="'.hsc($info['type']).'" name="'.hsc($name).'" value="'.hsc($this->uniq).'">'.hsc($info['label']).'</button>';
            }
            else {
                echo '<label for="'.$id.'">'.hsc($info['label']).'</label>';
                echo '<input type="'.hsc($info['type']).'" name="'.hsc($name).'" id="'.$id.'" value="'.hsc($field?->value??'').'" '.(($info['required']??false)?' required':'').'>';
                echo '<div class="field-error">'.hsc($field?->error??'').'</div>';
            }

            echo '</div>';
        }

        echo '</form>';
    }
}
