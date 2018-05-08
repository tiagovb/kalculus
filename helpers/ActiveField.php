<?php

namespace app\helpers;

use app\components\enum\EnumBoolSimNao;
use app\components\enum\EnumSexo;
use kartik\color\ColorInput;
use kartik\date\DatePicker;
use kartik\switchinput\SwitchInput;
use kartik\time\TimePicker;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/**
 * Class ActiveField
 */
class ActiveField extends \kartik\form\ActiveField
{
    /* @var bool */
    public $showPopoverTip = true;

    /* @var array */
    public $config = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!empty($this->addClass) && !strpos('form-control', $this->addClass)) {
            $this->addClass .= ' form-control';
        }

        $attribute = Html::getAttributeName($this->attribute);
        if ($this->showPopoverTip && method_exists($this->model, 'getAttributeTips')) {
            $tip = $this->model->getAttributeTips($attribute);
            if (!empty($tip)) {
                $this->labelOptions += [
                    'title' => Html::activeLabel($this->model, $this->attribute),
                    'data-content' => $tip,
                    'data-toggle' => 'popover',
                    'rel' => 'popover',
                ];
                Html::addCssClass($this->labelOptions, 'has-tooltip');
            }
        }

        parent::init();
    }

    /**
     * @param array $options
     *
     * @throws \Exception
     * @return $this
     */
    public function data(array $options = [])
    {
        $this->setConfig($config, $options);

        if (!empty($this->model->{$this->attribute}) && preg_match('/\d{4}-\d{2}-\d{2}/', $this->model->{$this->attribute})
        ) {
            $date = \DateTime::createFromFormat('Y-m-d', $this->model->{$this->attribute});
            $this->model->{$this->attribute} = $date->format('d/m/Y');
        }

        $config['clientOptions'] = ['alias' => 'dd/mm/yyyy', 'placeholder' => 'dd/mm/aaaa', 'clearIncomplete' => false];
        $this->parts['{input}'] = MaskedInput::widget($config);

        return $this;
    }

    /**
     * @param $config
     * @param array $options
     */
    private function setConfig(&$config, array $options = [])
    {
        $config['model'] = $this->model;
        $config['attribute'] = $this->attribute;
        $config['view'] = $this->form->getView();
        $config['options'] = array_merge($this->inputOptions, $options);
        $config = array_merge($config, $this->config);
    }

    /**
     * @param array $options
     *
     * @throws \Exception
     * @return $this
     */
    public function hora(array $options = [])
    {
        $this->setConfig($config, $options);
        $config['pluginOptions'] = ['showMeridian' => false, 'minuteStep' => 5, 'defaultTime' => false];
        $this->parts['{input}'] = TimePicker::widget($config);

        return $this;
    }

    /**
     * @param array $options
     * @param array $pluginOptions
     *
     * @throws \Exception
     * @return $this
     */
    public function calendario(array $options = [], array $pluginOptions = [])
    {
        $this->setConfig($config, $options);
        $config['pluginOptions'] = array_merge([
            'todayHighlight' => true,
            'todayBtn' => true,
            'language' => Yii::$app->language,
            'format' => 'dd/mm/yyyy',
            'autoclose' => true,
        ], $pluginOptions);
        $config['removeButton'] = false;
        $config['type'] = DatePicker::TYPE_COMPONENT_APPEND;

        if (!empty($this->model->{$this->attribute}) && preg_match('/\d{4}-\d{2}-\d{2}/', $this->model->{$this->attribute})) {
            $date = \DateTime::createFromFormat('Y-m-d', $this->model->{$this->attribute});
            $this->model->{$this->attribute} = $date->format('d/m/Y');
        }

        $this->parts['{input}'] = DatePicker::widget($config);

        return $this;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function selectSimNao(array $options = [])
    {
        $options = array_merge($this->inputOptions, ['prompt' => ' '], $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeDropDownList(
            $this->model,
            $this->attribute,
            EnumBoolSimNao::getEnumListLabels(),
            $options
        );

        return $this;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function radioSimNao(array $options = [])
    {
        $options = array_merge(
            [
                'itemOptions' => [
                    'container' => '',
                    'labelOptions' => ['class' => 'radio-inline'],
                ],
            ],
            $options
        );
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeRadioList(
            $this->model,
            $this->attribute,
            EnumBoolSimNao::getEnumListLabels(),
            $options
        );

        return $this;
    }

    /**
     * @param array $options
     * @param array $pluginOptions
     *
     * @return $this|ActiveField
     */
    public function radioAtivo(array $options = [], array $pluginOptions = [])
    {
        $pluginOptions += [
            'onColor' => 'success',
            'offColor' => 'danger',
            'onText' => 'Ativo',
            'offText' => 'Inativo',
        ];

        return $this->switchSimNao($options, $pluginOptions);
    }

    /**
     * @param array $options
     * @param array $pluginOptions
     *
     * @throws \Exception
     * @return $this
     */
    public function switchSimNao(array $options = [], array $pluginOptions = [])
    {
        $options = array_merge(['value' => EnumBoolSimNao::BOOL_SIM, 'uncheck' => EnumBoolSimNao::BOOL_NAO], $options);
        $this->setConfig($config, $options);
        Html::removeCssClass($config['options'], 'form-control');
        Html::addCssClass($config['options'], 'switch-simNao');
        $config['options']['label'] = null;
        $config['inlineLabel'] = false;
        $config['pluginOptions'] = $pluginOptions + [
                'size' => 'small',
                'onText' => Yii::t('app', 'Sim'),
                'offText' => Yii::t('app', 'Não'),
                'onColor' => 'info',
            ];
        $config['containerOptions'] = [];
        $this->parts['{input}'] = SwitchInput::widget($config);

        return $this;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function radioSexo(array $options = [])
    {
        $options = array_merge(
            ['itemOptions' => ['container' => '', 'labelOptions' => ['class' => 'radio-inline']]],
            $options
        );
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeRadioList(
            $this->model,
            $this->attribute,
            EnumSexo::getEnumListLabels(),
            $options
        );

        return $this;
    }

    /**
     * @param array $options
     *
     * @throws \Exception
     * @return $this
     */
    public function cpf(array $options = [])
    {
        $this->setConfig($config, $options);
        $config['mask'] = '999.999.999-99';
        $config['clientOptions'] = ['clearIncomplete' => false, 'showMaskOnHover' => false];
        $this->parts['{input}'] = MaskedInput::widget($config);

        return $this;
    }

    /**
     * @param array $options
     *
     * @throws \Exception
     * @return $this
     */
    public function cnpj(array $options = [])
    {
        $this->setConfig($config, $options);
        $config['mask'] = '99.999.999/9999-99';
        $config['clientOptions'] = ['clearIncomplete' => false, 'showMaskOnHover' => false];
        $this->parts['{input}'] = MaskedInput::widget($config);

        return $this;
    }

    /**
     * @param array $options
     *
     * @return ActiveField
     */
    public function dinheiro(array $options = [])
    {
        $this->addon['prepend'] = ['content' => 'R$'];

        if (isset($options['inteiro'])) {
            unset($options['inteiro']);
            $this->addon['append'] = ['content' => ',00'];
            $campo = $this->inteiro($options);
        } else {
            $campo = $this->decimal($options);
        }

        return $campo;
    }

    /**
     * @param array $options
     *
     * @throws \Exception
     * @return $this
     */
    public function inteiro(array $options = [])
    {
        $this->validateOnType = false;
        if ($this->addon == [] && !isset($options['size']) && isset($options['maxlength'])) {   // TODO: Refatorar para aplicar a outros inputs
            $options['size'] = $options['maxlength'];
            $options['style'] = 'width: auto';
        }
        $this->setConfig($config, $options);
        $config['clientOptions']['alias'] = 'integer';
        $this->parts['{input}'] = MaskedInput::widget($config);

        return $this;
    }

    /**
     * @param array $options
     *
     * @throws \Exception
     * @return $this
     */
    public function decimal(array $options = [])
    {
        $this->validateOnType = false;
        $this->setConfig($config, $options);
        $config['clientOptions'] = [
            'alias' => 'decimal',
            'radixPoint' => ',',
            'placeholder' => '',
            'digits' => 2,
            'allowMinus' => false,
            'allowPlus' => false,
            'showMaskOnHover' => false,
        ];
        $this->parts['{input}'] = MaskedInput::widget($config);

        return $this;
    }

    /**
     * @param array $options
     *
     * @throws \Exception
     * @return $this
     */
    public function percentagem(array $options = [])
    {
        $this->validateOnType = false;
        $this->setConfig($config, $options);
        $config['clientOptions'] = [
            'alias' => 'decimal',
            'radixPoint' => ',',
            'placeholder' => '',
            'integerDigits' => 3,
            'digits' => 2,
            'allowMinus' => false,
            'allowPlus' => false,
            'showMaskOnHover' => false,
        ];
        $this->parts['{input}'] = MaskedInput::widget($config);

        return $this;
    }

    /**
     * @param array $options
     *
     * @throws \Exception
     * @return $this
     */
    public function telefone(array $options = [])
    {
        $this->setConfig($config, $options);
        $config['mask'] = ['(99) n9999-9999', '(99) 9999-9999'];
        $config['clientOptions'] = [
            'clearIncomplete' => false,
            'definitions' => [
                'n' => [
                    'validator' => '(9)',
                    'cardinality' => 1,
                ],
            ],
        ];
        $this->parts['{input}'] = MaskedInput::widget($config);

        return $this;
    }

    /**
     * @param array $options
     * @param array $config
     *
     * @throws \Exception
     * @return $this
     */
    public function telefoneFixo(array $options = [], array $config = [])
    {
        $config = ArrayHelper::merge([
            'mask' => '(dd) f999-9999',
            'clientOptions' => [
                'clearIncomplete' => false,
                'definitions' => [
                    'd' => [
                        'validator' => '([1-9])',
                        'cardinality' => 1,
                    ],
                    'f' => [
                        'validator' => '([2-5])',
                        'cardinality' => 1,
                    ],
                ],
            ],
        ], $config);
        $this->setConfig($config, $options);

        $this->parts['{input}'] = MaskedInput::widget($config);

        return $this;
    }

    /**
     * @param array $options
     * @param array $config
     *
     * @throws \Exception
     * @return $this
     */
    public function celular(array $options = [], array $config = [])
    {
        $config = ArrayHelper::merge([
            'mask' => ['(dd) n9999-9999', '(dd) x999-9999'],
            'clientOptions' => [
                'clearIncomplete' => false,
                'definitions' => [
                    'd' => [
                        'validator' => '([1-9])',
                        'cardinality' => 1,
                    ],
                    'x' => [
                        'validator' => '([7])',
                        'cardinality' => 1,
                    ],
                    'n' => [
                        'validator' => '(9)',
                        'cardinality' => 1,
                    ],
                ],
            ],
        ], $config);
        $this->setConfig($config, $options);

        $this->parts['{input}'] = MaskedInput::widget($config);

        return $this;
    }

    /**
     * @param array $options
     *
     * @throws \Exception
     * @return $this
     */
    public function cor(array $options = [])
    {
        $this->setConfig($config, $options);
        $config['pluginOptions'] = [
            'showAlpha' => false,
            'showInput' => false,
            'cancelText' => 'cancelar',
            'chooseText' => 'escolher',
            'clearText' => 'Limpar',
        ];
        $this->parts['{input}'] = ColorInput::widget($config);

        return $this;
    }

    /**
     * @param array $itens
     *
     * @return $this
     */
    public function drop(array $itens = [])
    {
        return $this->dropDownList($itens, ['prompt' => ' ']);
    }

    /**
     * @return $this
     */
    public function opcional()
    {
        $this->inputOptions['placeholder'] = '(opcional)';

        return $this;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function url(array $options = [])
    {
        $this->inputOptions['type'] = 'url';

        return $this->textInput($options);
    }

    /**
     * @param array $options
     * @param array $config
     *
     * @return $this
     */
    public function cep(array $options = [], array $config = [])
    {
        $this->setConfig($config, $options);
        $config['mask'] = '99999-999';
        $config['clientOptions']['placeholder'] = '_';
        $this->parts['{input}'] = MaskedInput::widget($config);

        return $this;
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function autoPlaceholder($value = true)
    {
        $this->autoPlaceholder = $value;

        return $this;
    }

    /**
     * @param string $label
     * @param bool $asButton
     * @param array $options
     *
     * @return $this
     */
    public function labelPrepend(string $label = null, $asButton = false, array $options = [])
    {
        $this->addon = $this->addon($label, $asButton, $options, 'prepend');

        return $this;
    }

    /**
     * @param string $label
     * @param bool $asButton
     * @param array $options
     *
     * @return $this
     */
    public function labelAppend(string $label = null, $asButton = false, array $options = [])
    {
        $this->addon = $this->addon($label, $asButton, $options, 'append');

        return $this;
    }

    /**
     * @param string|null $label
     * @param bool $asButton
     * @param array $options
     * @param $type
     *
     * @return array
     */
    private function addon($label, $asButton, $options, $type)
    {
        $this->label(false);

        return array_merge($this->addon, [$type => ['content' => $label ?? $this->model->getAttributeLabel($this->attribute), 'asButton' => $asButton, 'options' => $options]]);
    }
}
