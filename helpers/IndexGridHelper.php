<?php

namespace app\helpers;

use kartik\helpers\Html;
use kartik\mpdf\Pdf;
use Yii;
use yii\web\View;

/**
 * Class IndexGridHelper
 */
class IndexGridHelper
{
    /**
     * @param View $view
     * @return array
     */
    public static function gridParams(View $view, $modelName, $createRoute = [])
    {
        $gridLayout = <<< HTML
    <div>
        <div class="btn-toolbar kv-grid-toolbar" role="toolbar">
            {toolbar}
        </div>    
    </div>
    <br>
    <div class="clearfix"></div>{summary}\n{items}\n{pager}
HTML;

        $pdfHeader = [
            'L' => [
                'content' => '',
                'font-size' => 8,
                'color' => '#333333',
            ],
            'C' => [
                'content' => $view->title,
                'font-size' => 16,
                'color' => '#333333',
            ],
            'R' => [
                'content' => Yii::t('app', 'Gerado') . ': ' . Yii::$app->formatter->asDatetime(time(), 'php:D, d-M-Y g:i a T'),
                'font-size' => 8,
                'color' => '#333333',
            ],
        ];
        $pdfFooter = [
            'L' => [
                'content' => '(c) ' . date('Y') . ' ' . Yii::$app->name,
                'font-size' => 8,
                'font-style' => 'B',
                'color' => '#999999',
            ],
            'R' => [
                'content' => '[ {PAGENO} ]',
                'font-size' => 10,
                'font-style' => 'B',
                'font-family' => 'serif',
                'color' => '#333333',
            ],
            'line' => true,
        ];
        $cssExport = <<<CSS
body { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 12px; line-height: 1.42857143; color: #333; background-color: #fff }
CSS;


        return [
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'responsiveWrap' => false,
            'responsive' => true,
            'toolbar' => [
                ['content' => Html::a(Html::icon('plus') . Yii::t('app', 'Adicionar'), $createRoute?:['create'], ['class' => 'btn btn-success', 'title' => Yii::t('app', 'Registrar')." $modelName"]),
                ],
                '{export}',
            ],
            'export' => [
                'fontAwesome' => true,
                'label' => Yii::t('app', 'Exportar'),
            ],
            'exportConfig' => [
                \kartik\grid\GridView::EXCEL => [
                    'label' => 'Excel',
                    'filename' => 'grid-export',
                    'config' => [
                        'worksheet' => 'Export',
                    ],
                ],
                \kartik\grid\GridView::PDF => [
                    'label' => 'PDF',
                    'filename' => 'grid-export',
                    'config' => [
                        'mode' => Pdf::MODE_UTF8,
                        'orientation' => Pdf::MODE_UTF8,
                        'format' => Pdf::FORMAT_A4,
                        'destination' => Pdf::DEST_BROWSER,
                        'marginLeft' => 10,
                        'marginRight' => 10,
                        'methods' => [
                            'SetHeader' => [
                                ['odd' => $pdfHeader, 'even' => $pdfHeader],
                            ],
                            'SetFooter' => [
                                ['odd' => $pdfFooter, 'even' => $pdfFooter],
                            ],
                        ],
                        'options' => [
                            'title' => $view->title,
                        ],
                        'cssInline' => $cssExport,
                    ],
                ],
            ],
            'bordered' => true,
            'striped' => true,
            'layout' => $gridLayout,
        ];
    }
}
