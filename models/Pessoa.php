<?php

namespace app\models;

/**
 * This is the model class for table "Pessoa".
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 */
class Pessoa extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Pessoa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'email'], 'required'],
            [['nome'], 'string', 'max' => 40],
            [['email'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'email' => 'Email',
        ];
    }

    public function canDelete()
    {
        return true;
    }
}
