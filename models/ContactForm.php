<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Nome',
            'email' => 'E-mail',
            'subject' => 'Assunto',
            'body' => 'Mensagem',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact()
    {
        $adminEmail = Yii::$app->params['adminEmail'];

        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($adminEmail)
                ->setFrom($adminEmail)
                ->setSubject($this->subject)
                ->setTextBody("Enviado por {$this->name} - {$this->email}\n" . $this->body)
                ->send();

            return true;
        }
        return false;
    }
}
