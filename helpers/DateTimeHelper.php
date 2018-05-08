<?php

namespace app\helpers;

use DateTime;
use Yii;

/**
 * Class DateTimeHelper
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 * @SuppressWarnings(PHPMD.CamelCaseParameterName)
 * @SuppressWarnings(PHPMD.CamelCaseVariableName)
 */
class DateTimeHelper
{
    /**
     * @param int $qtdDias
     * @param string $dataBase
     *
     * @return mixed
     */
    public static function diasUteisParaCorridos($qtdDias, $dataBase = '')
    {
        $dataUtil = self::somarDiasUteis($qtdDias, $dataBase);
        $dateTimeUtil = new DateTime($dataUtil);
        $dateTimeHoje = new DateTime($dataBase ?: date('Y-m-d'));

        return $dateTimeUtil->diff($dateTimeHoje)->days;
    }

    /**
     * param $dataBase é opcional. Default data atual.
     * Retorna data informada somada ou subtraida à quantidade de dias uteis informada como parámetro.
     *
     * @param int $qtdDias
     * @param string $dataBase
     *
     * @return string
     */
    public static function somarDiasUteis($qtdDias, $dataBase = null)
    {
        $dataBase = $dataBase ?: date('Y-m-d');
        $sinal = ($qtdDias >= 0) ? '+' : '-';
        $qtdDias = abs($qtdDias);

        $feriados = self::getFeriados();
        // Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00
        // Transforma para DATE - aaaa-mm-dd

        $dataBase = substr($dataBase, 0, 10);

        // Se a data estiver no formato brasileiro: dd/mm/aaaa
        // Converte-a para o padrão americano: aaaa-mm-dd

        if (preg_match('@/@', $dataBase) == 1) {
            $dataBase = implode('-', array_reverse(explode('/', $dataBase)));
        }

        $array_data = explode('-', $dataBase);
        $count_days = 0;
        $qtdDias_uteis = 0;

        while ($qtdDias_uteis < $qtdDias) {
            $count_days++;
            $day = date('m-d', strtotime($sinal . $count_days . 'day', strtotime($dataBase)));

            if (($dias_da_semana = gmdate('w', strtotime($sinal . $count_days . ' day', gmmktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0])))) != '0'
                && $dias_da_semana != '6' && !in_array($day, $feriados)
            ) {
                $qtdDias_uteis++;
            }
        }

        return gmdate('Y-m-d', strtotime($sinal . $count_days . ' day', strtotime($dataBase)));
    }

    /**
     * @return array
     */
    public static function getFeriados()
    {
        // chama a funcao que calcula a pascoa
        $pascoa_dt = self::dataPascoa(date('Y'));
        $aux_p = explode('/', $pascoa_dt);
        $aux_dia_pas = $aux_p[0];
        $aux_mes_pas = $aux_p[1];
        $pascoa = "$aux_mes_pas" . '-' . "$aux_dia_pas"; // crio uma data somente como mes e dia

        // chama a funcao que calcula o carnaval
        $carnaval_dt = self::dataCarnaval(date('Y'));
        $aux_carna = explode('/', $carnaval_dt);
        $aux_dia_carna = $aux_carna[0];
        $aux_mes_carna = $aux_carna[1];
        $carnaval = "$aux_mes_carna" . '-' . "$aux_dia_carna";

        // chama a funcao que calcula corpus christi
        $CorpusChristi_dt = self::dataCorpusChristi(date('Y'));
        $aux_cc = explode('/', $CorpusChristi_dt);
        $aux_cc_dia = $aux_cc[0];
        $aux_cc_mes = $aux_cc[1];
        $Corpus_Christi = "$aux_cc_mes" . '-' . "$aux_cc_dia";

        // chama a funcao que calcula a sexta feira santa
        $sexta_santa_dt = self::dataSextaSanta(date('Y'));
        $aux = explode('/', $sexta_santa_dt);
        $aux_dia = $aux[0];
        $aux_mes = $aux[1];
        $sexta_santa = "$aux_mes" . '-' . "$aux_dia";

        $feriados = [
            '01-01',
            $carnaval,
            $sexta_santa,
            $pascoa,
            $Corpus_Christi,
            '04-21',
            '05-01',
            '06-12',
            '07-09',
            '07-16',
            '09-07',
            '10-12',
            '11-02',
            '11-15',
            '12-24',
            '12-25',
            '12-31',
        ];

        return $feriados;
    }

    /**
     * dataPascoa(ano, formato);
     * Autor: Yuri Vecchi
     *
     * Funcao para o calculo da Pascoa
     * Retorna o dia da pascoa no formato desejado ou false.
     *
     * ######################ATENCAO###########################
     * Esta funcao sofre das limitacoes de data de mktime()!!!
     * ########################################################
     *
     * Possui dois parametros, ambos opcionais
     * ano = ano com quatro digitos
     * Padrao: ano atual
     * formato = formatacao da funcao date() http://br.php.net/date
     * Padrao: d/m/Y
     *
     * @param bool $ano
     * @param string $form
     *
     * @return bool|string
     */
    public static function dataPascoa($ano = false, $form = 'd/m/Y')
    {
        $ano = $ano ? $ano : date('Y');
        if ($ano < 1583) {
            $A = ($ano % 4);
            $B = ($ano % 7);
            $C = ($ano % 19);
            $D = ((19 * $C + 15) % 30);
            $E = ((2 * $A + 4 * $B - $D + 34) % 7);
            $F = (int)(($D + $E + 114) / 31);
            $G = (($D + $E + 114) % 31) + 1;

            return date($form, mktime(0, 0, 0, $F, $G, $ano));
        }

        $A = ($ano % 19);
        $B = (int)($ano / 100);
        $C = ($ano % 100);
        $D = (int)($B / 4);
        $E = ($B % 4);
        $F = (int)(($B + 8) / 25);
        $G = (int)(($B - $F + 1) / 3);
        $H = ((19 * $A + $B - $D - $G + 15) % 30);
        $I = (int)($C / 4);
        $K = ($C % 4);
        $L = ((32 + 2 * $E + 2 * $I - $H - $K) % 7);
        $M = (int)(($A + 11 * $H + 22 * $L) / 451);
        $P = (int)(($H + $L - 7 * $M + 114) / 31);
        $Q = (($H + $L - 7 * $M + 114) % 31) + 1;

        return date($form, mktime(0, 0, 0, $P, $Q, $ano));
    }

    /**
     * dataCarnaval(ano, formato);
     * Autor: Yuri Vecchi
     *
     * Funcao para o calculo do Carnaval
     * Retorna o dia do Carnaval no formato desejado ou false.
     *
     * ######################ATENCAO###########################
     * Esta funcao sofre das limitacoes de data de mktime()!!!
     * ########################################################
     *
     * Possui dois parametros, ambos opcionais
     * ano = ano com quatro digitos
     * Padrao: ano atual
     * formato = formatacao da funcao date() http://br.php.net/date
     * Padrao: d/m/Y
     *
     * @param bool $ano
     * @param string $form
     *
     * @return bool|string
     */
    public static function dataCarnaval($ano = false, $form = 'd/m/Y')
    {
        $ano = $ano ? $ano : date('Y');
        $a = explode('/', self::dataPascoa($ano));

        return date($form, mktime(0, 0, 0, $a[1], $a[0] - 47, $a[2]));
    }

    /**
     * dataCorpusChristi(ano, formato);
     * Autor: Yuri Vecchi
     *
     * Funcao para o calculo do Corpus Christi
     * Retorna o dia do Corpus Christi no formato desejado ou false.
     *
     * ######################ATENCAO###########################
     * Esta funcao sofre das limitacoes de data de mktime()!!!
     * ########################################################
     *
     * Possui dois parametros, ambos opcionais
     * ano = ano com quatro digitos
     * Padrao: ano atual
     * formato = formatacao da funcao date() http://br.php.net/date
     * Padrao: d/m/Y
     *
     * @param bool $ano
     * @param string $form
     *
     * @return bool|string
     */
    public static function dataCorpusChristi($ano = false, $form = 'd/m/Y')
    {
        $ano = $ano ? $ano : date('Y');
        $a = explode('/', self::dataPascoa($ano));

        return date($form, mktime(0, 0, 0, $a[1], $a[0] + 60, $a[2]));
    }

    /**
     * dataSextaSanta(ano, formato);
     * Autor: Yuri Vecchi
     *
     * Funcao para o calculo da Sexta-feira santa ou da Paixao.
     * Retorna o dia da Sexta-feira santa ou da Paixao no formato desejado ou false.
     *
     * ######################ATENCAO###########################
     * Esta funcao sofre das limitacoes de data de mktime()!!!
     * ########################################################
     *
     * Possui dois parametros, ambos opcionais
     * ano = ano com quatro digitos
     * Padrao: ano atual
     * formato = formatacao da funcao date() http://br.php.net/date
     * Padrao: d/m/Y
     *
     * @param bool $ano
     * @param string $form
     *
     * @return bool|string
     */
    public static function dataSextaSanta($ano = false, $form = 'd/m/Y')
    {
        $ano = $ano ? $ano : date('Y');
        $a = explode('/', self::dataPascoa($ano));

        return date($form, mktime(0, 0, 0, $a[1], $a[0] - 2, $a[2]));
    }

    /**
     * Retorna data informada somada ou subtraida à quantidade de horas uteis informada como parâmetro.
     *
     * @param int $qtdHoras
     * @param string $data
     *
     * @return string
     */
    public static function subtrairHorasUteis($qtdHoras, $data = null)
    {
        $return = (new DateTime($data))->getTimestamp();

        $feriados = self::getFeriados();

        while ($qtdHoras > 0) {
            $return = strtotime('-1 hours', $return);
            if (!in_array(date('m-d', $return), $feriados, true) && ((int)date('N', $return)) < 6) {
                $qtdHoras--;
            }
        }

        return date('Y-m-d H:i:s', $return);
    }

    /**
     * param $str_data é opcional. Default data atual.
     * Retorna data informada somada à quantidade de dias uteis informada como parámetro.
     *
     * @param $int_qtd_dias_subtrair
     * @param $str_data
     *
     * @return string
     */
    public static function subtrairDiasUteis($int_qtd_dias_subtrair, $str_data = false)
    {
        $str_data = $str_data ?: date('Y-m-d');

        $feriados = self::getFeriados();
        // Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00
        // Transforma para DATE - aaaa-mm-dd

        $str_data = substr($str_data, 0, 10);

        // Se a data estiver no formato brasileiro: dd/mm/aaaa
        // Converte-a para o padrão americano: aaaa-mm-dd

        if (preg_match('@/@', $str_data) == 1) {
            $str_data = implode('-', array_reverse(explode('/', $str_data)));
        }

        $array_data = explode('-', $str_data);
        $count_days = 0;
        $int_qtd_dias_uteis = 0;

        while ($int_qtd_dias_uteis < $int_qtd_dias_subtrair) {
            $count_days++;
            $day = date('m-d', strtotime('-' . $count_days . 'day', strtotime($str_data)));

            if (($dias_da_semana = gmdate('w', strtotime('-' . $count_days . ' day', gmmktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0])))) != '0'
                && $dias_da_semana != '6' && !in_array($day, $feriados)
            ) {
                $int_qtd_dias_uteis++;
            }
        }

        return gmdate('Y-m-d', strtotime('-' . $count_days . ' day', strtotime($str_data)));
    }

    /**
     * @param $dtInicio
     * @param bool $dtFim
     *
     * @return number
     */
    public static function getDiffDias($dtInicio, $dtFim = false)
    {
        if (preg_match('@/@', $dtInicio) == 1) {
            $dtInicio = implode('-', array_reverse(explode('/', $dtInicio)));
        }

        if (preg_match('@/@', $dtFim) == 1) {
            $dtFim = implode('-', array_reverse(explode('/', $dtFim)));
        }

        $dateTimeInicio = new DateTime($dtInicio);
        $dateTimeFim = new DateTime($dtFim ?: date('Y-m-d H:i:s'));
        $dDiff = $dateTimeFim->diff($dateTimeInicio);

        return abs($dDiff->days);
    }

    /**
     * @param bool $microtime Se deve ser incluído o microtime
     * @param int $epochTimestamp O timestamp da data inicial. Default: 2016-01-01 00:00:00
     *
     * @return int
     */
    public static function relativeTimestamp($microtime = false, $epochTimestamp = 1451606400)
    {
        if ($microtime === true) {
            $relativeTimestamp = (int)((microtime(true) - (int)$epochTimestamp) * 10000);
        } else {
            $relativeTimestamp = (time() - (int)$epochTimestamp);
        }

        return $relativeTimestamp;
    }

    /**
     * @param string $attribute
     * @param string $value
     * @param string $tableName
     *
     * @return array
     */
    public static function buscarIntervalo($attribute, $value, $tableName = null)
    {
        list($inicio, $fim) = self::definirIntervalo($value);
        if ($tableName !== null) {
            $tableName .= '.';
        }

        return ['between', $tableName . $attribute, $inicio, $fim];
    }

    /**
     * @param $valor
     *
     * @return null|array
     */
    public static function definirIntervalo($valor)
    {
        $dtList = null;
        if ($valor !== null) {
            $valor = str_replace('/', '-', $valor);
            if (strpos($valor, ' - ')) {
                list($dtList[0], $dtList[1]) = explode(' - ', $valor);
                $dtList[0] = Yii::$app->formatter->asDate($dtList[0], 'YYYY-MM-dd 00:00:00');
                $dtList[1] = Yii::$app->formatter->asDate($dtList[1], 'YYYY-MM-dd 23:59:59');
            }
        }

        return $dtList;
    }

    /**
     * @param $valor
     *
     * @return string
     */
    public static function toSqlDate($valor)
    {
        if (strpos($valor, '/') !== false) {
            $valor = str_replace('/', '-', $valor);
        }

        return Yii::$app->formatter->asDate($valor, 'YYYY-MM-dd');
    }

    /**
     * @param $date
     * @param string $format
     *
     * @return bool
     */
    public static function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) == $date;
    }

    /**
     * @return bool
     */
    public static function isManhaSegunda()
    {
        return date('la') === 'Mondayam';
    }

    /**
     * @param string $dtNascimento data no formato dd/mm/aaaa.
     *
     * @return int
     */
    public static function calcularIdade($dtNascimento)
    {
        if (empty($dtNascimento)) {
            return null;
        }

        $dateTime = null;

        if (preg_match('/^(?<dia>\d{1,2})\/(?<mes>\d{1,2})\/(?<ano>\d{2}|\d{4})$/', trim($dtNascimento), $matches)) {
            if (strlen($matches['ano']) === 2) {
                $matches['ano'] = ($matches['ano'] > date('y')) ? '19' . $matches['ano'] : '20' . $matches['ano'];
            }

            $dateTime = DateTime::createFromFormat('d/m/Y', "{$matches['dia']}/{$matches['mes']}/" . $matches['ano']);
        }

        if (!$dateTime) {
            throw new \InvalidArgumentException('Não foi informada uma data de nascimento no formato dd/mm/aaaa');
        }

        return $dateTime->diff(new DateTime('today'))->y;
    }
}
